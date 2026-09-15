<?php

use App\Events\OrderCreated;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->category = Category::factory()->create();
    $this->storeA = Store::factory()->create();
    $this->storeB = Store::factory()->create();
});

function checkoutAddress(): array
{
    return [
        'billing' => [
            'first_name' => 'Jane',
            'last_name' => 'Customer',
            'email' => 'jane@example.com',
            'phone_number' => '123456789',
            'country' => 'US',
            'city' => 'New York',
            'state' => 'NY',
            'street_address' => '1 Main Street',
            'postal_code' => '10001',
        ],
        'shipping' => [
            'first_name' => 'Jane',
            'last_name' => 'Customer',
            'email' => 'jane@example.com',
            'phone_number' => '123456789',
            'country' => 'US',
            'city' => 'New York',
            'state' => 'NY',
            'street_address' => '1 Main Street',
            'postal_code' => '10001',
        ],
    ];
}

function addCartItem(Product $product, int $quantity, ?int $userId = null): string
{
    $cookieId = (string) Str::uuid();
    test()->withCookie('cart_id', $cookieId);
    $cartId = (string) Str::uuid();
    Cart::query()->insert([
        'id' => $cartId,
        'cookie_id' => $cookieId,
        'user_id' => $userId,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return $cartId;
}

test('guest checkout creates one order and snapshots server-side prices', function () {
    Event::fake([OrderCreated::class]);
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'price' => 19.99,
        'quantity' => 5,
        'status' => 'Active',
    ]);

    $cartId = addCartItem($product, 2);

    $response = $this->post(route('checkout'), [
        'payment' => 'cod',
        'addr' => checkoutAddress(),
        'total' => '0.01',
        'price' => '0.01',
    ]);

    $response->assertRedirect(route('home'));
    $order = Order::with('products', 'addresses')->firstOrFail();

    expect($order->user_id)->toBeNull()
        ->and((float) $order->total)->toBe(39.98)
        ->and($order->products->first()->pivot->price)->toBe('19.99')
        ->and($product->fresh()->quantity)->toBe(3)
        ->and(Cart::withoutGlobalScopes()->find($cartId))->toBeNull();

    Event::assertDispatched(OrderCreated::class, 1);
});

test('authenticated checkout associates the order with the web customer', function () {
    $customer = User::factory()->create();
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'price' => 10,
        'quantity' => 4,
        'status' => 'Active',
    ]);
    addCartItem($product, 1, $customer->id);

    $this->actingAs($customer, 'web')
        ->post(route('checkout'), ['payment' => 'cod', 'addr' => checkoutAddress()])
        ->assertRedirect(route('home'));

    expect(Order::firstOrFail()->user_id)->toBe($customer->id);
});

test('multi-store checkout creates and dispatches one order per actual product store', function () {
    Event::fake([OrderCreated::class]);
    $productA = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'price' => 10,
        'quantity' => 5,
        'status' => 'Active',
    ]);
    $productB = Product::factory()->create([
        'store_id' => $this->storeB->id,
        'category_id' => $this->category->id,
        'price' => 20,
        'quantity' => 5,
        'status' => 'Active',
    ]);

    $cookieId = (string) Str::uuid();
    $this->withCookie('cart_id', $cookieId);
    Cart::query()->insert([
        ['id' => (string) Str::uuid(), 'cookie_id' => $cookieId, 'product_id' => $productA->id, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['id' => (string) Str::uuid(), 'cookie_id' => $cookieId, 'product_id' => $productB->id, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
    ]);
    $this
        ->post(route('checkout'), ['payment' => 'cod', 'addr' => checkoutAddress()])
        ->assertRedirect(route('home'));

    expect(Order::count())->toBe(2)
        ->and(Order::where('store_id', $this->storeA->id)->value('total'))->toBe('10.00')
        ->and(Order::where('store_id', $this->storeB->id)->value('total'))->toBe('40.00')
        ->and($productA->fresh()->quantity)->toBe(4)
        ->and($productB->fresh()->quantity)->toBe(3)
        ->and(Cart::withoutGlobalScopes()->where('cookie_id', $cookieId)->count())->toBe(0);

    Event::assertDispatched(OrderCreated::class, 2);
    $eventStoreIds = Event::dispatched(OrderCreated::class)
        ->map(fn (array $event) => $event[0]->order->store_id)
        ->sort()
        ->values()
        ->all();

    expect($eventStoreIds)->toBe(
        collect([$productA->store_id, $productB->store_id])->sort()->values()->all()
    );
});

test('checkout rejects unsupported payment and malformed addresses', function () {
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'quantity' => 2,
        'status' => 'Active',
    ]);
    addCartItem($product, 1);

    $this->post(route('checkout'), [
        'payment' => 'paypal',
        'addr' => ['billing' => []],
    ])->assertSessionHasErrors(['payment', 'addr.shipping']);
});

test('insufficient stock rolls back orders inventory and cart', function () {
    Event::fake([OrderCreated::class]);
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'quantity' => 1,
        'status' => 'Active',
    ]);
    $cartId = addCartItem($product, 2);

    $this->post(route('checkout'), ['payment' => 'cod', 'addr' => checkoutAddress()])
        ->assertStatus(422);

    expect(Order::count())->toBe(0)
        ->and($product->fresh()->quantity)->toBe(1)
        ->and(Cart::withoutGlobalScopes()->find($cartId))->not->toBeNull();

    Event::assertNotDispatched(OrderCreated::class);
});

test('duplicate checkout submissions cannot create a second order from the same cart', function () {
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'price' => 12,
        'quantity' => 2,
        'status' => 'Active',
    ]);
    addCartItem($product, 1);

    $payload = ['payment' => 'cod', 'addr' => checkoutAddress()];

    $this->post(route('checkout'), $payload)->assertRedirect(route('home'));
    $this->post(route('checkout'), $payload)->assertRedirect(route('cart.index'));

    expect(Order::count())->toBe(1)
        ->and($product->fresh()->quantity)->toBe(1)
        ->and(\App\Models\Cart::withoutGlobalScopes()->count())->toBe(0);
});

test('cart updates and deletes remain scoped to the current cart cookie', function () {
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'status' => 'Active',
    ]);
    $ownerCookie = (string) Str::uuid();
    $attackerCookie = (string) Str::uuid();
    $cartId = (string) Str::uuid();

    Cart::query()->insert([
        'id' => $cartId,
        'cookie_id' => $ownerCookie,
        'product_id' => $product->id,
        'quantity' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->withCookie('cart_id', $attackerCookie)
        ->put(route('cart.update', $cartId), [
            'product_id' => $product->id,
            'quantity' => 99,
            'action' => 'plus',
        ])
        ->assertNotFound();

    $this->withCookie('cart_id', $attackerCookie)
        ->delete(route('cart.destroy', $cartId))
        ->assertNotFound();

    expect(Cart::withoutGlobalScopes()->find($cartId)->quantity)->toBe(1);
});

test('authenticated carts require both the current cookie and user ownership', function () {
    $customerA = User::factory()->create();
    $customerB = User::factory()->create();
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'status' => 'Active',
    ]);
    $cookieA = (string) Str::uuid();
    $cartId = (string) Str::uuid();

    Cart::withoutGlobalScopes()->insert([
        'id' => $cartId,
        'cookie_id' => $cookieA,
        'user_id' => $customerA->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($customerB, 'web')
        ->withCookie('cart_id', $cookieA)
        ->get(route('cart.index'))
        ->assertOk()
        ->assertDontSee($product->name);

    $this->actingAs($customerB, 'web')
        ->withCookie('cart_id', $cookieA)
        ->delete(route('cart.destroy', $cartId))
        ->assertNotFound();

    expect(Cart::withoutGlobalScopes()->find($cartId)->quantity)->toBe(1);
});

test('guest cart is claimed by the authenticated user on login', function () {
    $customer = User::factory()->create(['password' => bcrypt('password')]);
    $product = Product::factory()->create([
        'store_id' => $this->storeA->id,
        'category_id' => $this->category->id,
        'status' => 'Active',
    ]);
    $cookieId = (string) Str::uuid();
    $cartId = (string) Str::uuid();

    Cart::withoutGlobalScopes()->insert([
        'id' => $cartId,
        'cookie_id' => $cookieId,
        'user_id' => null,
        'product_id' => $product->id,
        'quantity' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->withCookie('cart_id', $cookieId)
        ->post(route('login'), [
            'email' => $customer->email,
            'password' => 'password',
        ])
        ->assertRedirect();

    expect(Cart::withoutGlobalScopes()->find($cartId)->user_id)->toBe($customer->id);
});
