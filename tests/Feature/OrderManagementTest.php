<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

beforeEach(function () {
    $this->storeA = Store::factory()->create();
    $this->storeB = Store::factory()->create();
    $this->category = Category::factory()->create();
    $this->vendorA = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->storeA->id,
    ]);
    $this->vendorB = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->storeB->id,
    ]);
    $this->customerA = User::factory()->create();
    $this->customerB = User::factory()->create();
});

function makeOrder(Store $store, ?int $userId = null, string $status = 'pending'): Order
{
    return Order::create([
        'store_id' => $store->id,
        'user_id' => $userId,
        'payment_method' => 'cod',
        'status' => $status,
        'subtotal' => 20,
        'total' => 20,
    ]);
}

test('customers can only list and view their own orders', function () {
    $own = makeOrder($this->storeA, $this->customerA->id);
    $other = makeOrder($this->storeA, $this->customerB->id);

    $this->actingAs($this->customerA, 'web')
        ->get(route('orders.index'))
        ->assertOk()
        ->assertSee($own->number)
        ->assertDontSee($other->number);

    $this->actingAs($this->customerA, 'web')
        ->get(route('orders.show', $other))
        ->assertForbidden();
});

test('guest customers cannot access order history', function () {
    $order = makeOrder($this->storeA, null);

    $this->get(route('orders.index'))->assertRedirect(route('login'));
    $this->get(route('orders.show', $order))->assertRedirect(route('login'));
});

test('vendors can only list and view orders for their store', function () {
    $own = makeOrder($this->storeA, $this->customerA->id);
    $other = makeOrder($this->storeB, $this->customerB->id);

    $this->actingAs($this->vendorA, 'admin')
        ->get(route('dashboard.orders.index'))
        ->assertOk()
        ->assertSee($own->number)
        ->assertDontSee($other->number);

    $this->actingAs($this->vendorA, 'admin')
        ->get(route('dashboard.orders.show', $other))
        ->assertForbidden();
});

test('super admins can access orders across stores', function () {
    $superAdmin = Admin::factory()->create(['role' => Admin::ROLE_SUPER_ADMIN]);
    $order = makeOrder($this->storeB, $this->customerB->id);

    $this->actingAs($superAdmin, 'admin')
        ->get(route('dashboard.orders.show', $order))
        ->assertOk()
        ->assertSee($order->number);
});

test('status transitions are enforced for vendors', function () {
    $order = makeOrder($this->storeA, $this->customerA->id);

    $this->actingAs($this->vendorA, 'admin')
        ->patch(route('dashboard.orders.status', $order), ['status' => 'processing'])
        ->assertRedirect();

    expect($order->fresh()->status)->toBe('processing');

    $this->actingAs($this->vendorA, 'admin')
        ->patch(route('dashboard.orders.status', $order), ['status' => 'completed'])
        ->assertForbidden();

    $this->actingAs($this->vendorA, 'admin')
        ->patch(route('dashboard.orders.status', $order), ['status' => 'invalid'])
        ->assertForbidden();
});

test('vendors cannot update another stores order status', function () {
    $order = makeOrder($this->storeB, $this->customerB->id);

    $this->actingAs($this->vendorA, 'admin')
        ->patch(route('dashboard.orders.status', $order), ['status' => 'processing'])
        ->assertForbidden();

    expect($order->fresh()->status)->toBe('pending');
});

test('admins can perform valid operational order updates', function () {
    $admin = Admin::factory()->create(['role' => Admin::ROLE_ADMIN]);
    $order = makeOrder($this->storeB, $this->customerB->id);

    $this->actingAs($admin, 'admin')
        ->patch(route('dashboard.orders.status', $order), ['status' => 'processing'])
        ->assertRedirect();

    expect($order->fresh()->status)->toBe('processing');
});

test('order item and address snapshots remain available after product changes', function () {
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'name' => 'Original Product',
        'price' => 12.50,
        'status' => 'Active',
    ]);
    $order = makeOrder($this->storeA, $this->customerA->id);
    $order->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'price' => 12.50,
        'quantity' => 2,
        'subtotal' => 25,
    ]);
    $order->addresses()->create([
        'type' => 'shipping',
        'first_name' => 'Jane',
        'last_name' => 'Customer',
        'phone_number' => '123456789',
        'country' => 'US',
        'city' => 'New York',
        'street_address' => '1 Main Street',
    ]);

    $product->update(['name' => 'Changed Product', 'price' => 99.99]);
    $order->load('items', 'shippingAddress');

    expect($order->items->first()->product_name)->toBe('Original Product')
        ->and((float) $order->items->first()->price)->toBe(12.50)
        ->and((float) $order->items->first()->subtotal)->toBe(25.0)
        ->and($order->shippingAddress->street_address)->toBe('1 Main Street');
});
