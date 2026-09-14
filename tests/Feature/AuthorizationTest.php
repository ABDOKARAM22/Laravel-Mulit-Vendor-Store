<?php

use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('vendors cannot access category management routes', function () {
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => Store::factory(),
    ]);

    $this->actingAs($vendor, 'admin')
        ->get(route('dashboard.categories.index'))
        ->assertForbidden();
});

test('admins can access category management routes', function () {
    $admin = Admin::factory()->create([
        'role' => Admin::ROLE_ADMIN,
    ]);

    $this->actingAs($admin, 'admin')
        ->get(route('dashboard.categories.index'))
        ->assertOk();
});

test('vendor policies are limited to the assigned store', function () {
    $storeA = Store::factory()->create();
    $storeB = Store::factory()->create();
    $category = \App\Models\Category::factory()->create();
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $storeA->id,
    ]);
    $productA = Product::factory()->create(['store_id' => $storeA->id, 'category_id' => $category->id]);
    $productB = Product::factory()->create(['store_id' => $storeB->id, 'category_id' => $category->id]);
    $orderA = Order::create(['store_id' => $storeA->id, 'payment_method' => 'cod']);
    $orderB = Order::create(['store_id' => $storeB->id, 'payment_method' => 'cod']);

    expect(Gate::forUser($vendor)->allows('update', $productA))->toBeTrue()
        ->and(Gate::forUser($vendor)->allows('update', $productB))->toBeFalse()
        ->and(Gate::forUser($vendor)->allows('view', $orderA))->toBeTrue()
        ->and(Gate::forUser($vendor)->allows('view', $orderB))->toBeFalse();
});

test('customers can only view their own orders through the customer policy ability', function () {
    $customer = User::factory()->create();
    $otherCustomer = User::factory()->create();
    $store = Store::factory()->create();
    $ownOrder = Order::create(['store_id' => $store->id, 'user_id' => $customer->id, 'payment_method' => 'cod']);
    $otherOrder = Order::create(['store_id' => $store->id, 'user_id' => $otherCustomer->id, 'payment_method' => 'cod']);

    expect(Gate::forUser($customer)->allows('view', $ownOrder))->toBeTrue()
        ->and(Gate::forUser($customer)->allows('view', $otherOrder))->toBeFalse();
});
