<?php

use App\Models\Admin;
use App\Models\Store;

test('vendor registration creates a pending vendor and store atomically', function () {
    $response = $this->post(route('vendor.register'), [
        'name' => 'New Vendor',
        'email' => 'vendor@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'store_name' => 'New Store',
        'store_description' => 'A store description',
        'role' => Admin::ROLE_SUPER_ADMIN,
        'status' => Admin::STATUS_ACTIVE,
        'store_id' => 999,
    ]);

    $response->assertRedirect(route('vendor.register'));
    $vendor = Admin::where('email', 'vendor@example.com')->firstOrFail();

    expect($vendor->role)->toBe(Admin::ROLE_VENDOR)
        ->and($vendor->status)->toBe(Admin::STATUS_PENDING)
        ->and($vendor->store_id)->not->toBeNull();

    expect($vendor->store->status)->toBe(Store::STATUS_PENDING)
        ->and($vendor->store->slug)->toBe('new-store');
});

test('vendor registration validates duplicate email and store names', function () {
    Admin::factory()->create(['email' => 'vendor@example.com']);
    Store::factory()->create(['name' => 'Existing Store']);

    $response = $this->from(route('vendor.register'))->post(route('vendor.register'), [
        'name' => 'New Vendor',
        'email' => 'vendor@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'store_name' => 'Existing Store',
    ]);

    $response->assertRedirect(route('vendor.register'))
        ->assertSessionHasErrors(['email', 'store_name']);
});

test('only administrators can view vendor management', function () {
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => Store::factory(),
    ]);

    $this->actingAs($vendor, 'admin')
        ->get(route('dashboard.vendors.index'))
        ->assertForbidden();
});

test('administrators can review and approve a vendor and its store', function () {
    $admin = Admin::factory()->create(['role' => Admin::ROLE_ADMIN]);
    $store = Store::factory()->create(['status' => Store::STATUS_PENDING]);
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'status' => Admin::STATUS_PENDING,
        'store_id' => $store->id,
    ]);

    $this->actingAs($admin, 'admin')
        ->patch(route('dashboard.vendors.status', $vendor), [
            'status' => Admin::STATUS_ACTIVE,
        ])
        ->assertRedirect();

    expect($vendor->refresh()->status)->toBe(Admin::STATUS_ACTIVE)
        ->and($store->refresh()->status)->toBe(Store::STATUS_ACTIVE);
});

test('administrators can reject a vendor and its store', function () {
    $admin = Admin::factory()->create(['role' => Admin::ROLE_ADMIN]);
    $store = Store::factory()->create(['status' => Store::STATUS_PENDING]);
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'status' => Admin::STATUS_PENDING,
        'store_id' => $store->id,
    ]);

    $this->actingAs($admin, 'admin')
        ->patch(route('dashboard.vendors.status', $vendor), [
            'status' => Admin::STATUS_REJECTED,
        ])
        ->assertRedirect();

    expect($vendor->refresh()->status)->toBe(Admin::STATUS_REJECTED)
        ->and($store->refresh()->status)->toBe(Store::STATUS_REJECTED);
});

test('vendors cannot manage themselves or another vendor', function () {
    $store = Store::factory()->create();
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $store->id,
    ]);

    $this->actingAs($vendor, 'admin')
        ->get(route('dashboard.vendors.index'))
        ->assertForbidden();

    $this->actingAs($vendor, 'admin')
        ->get(route('dashboard.vendors.show', $vendor))
        ->assertForbidden();
});

test('vendor update cannot change protected fields', function () {
    $admin = Admin::factory()->create(['role' => Admin::ROLE_ADMIN]);
    $store = Store::factory()->create();
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $store->id,
        'status' => Admin::STATUS_PENDING,
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('dashboard.vendors.update', $vendor), [
            'name' => 'Updated Vendor',
            'email' => 'updated@example.com',
            'role' => Admin::ROLE_SUPER_ADMIN,
            'store_id' => null,
            'status' => Admin::STATUS_ACTIVE,
        ])
        ->assertRedirect();

    expect($vendor->refresh()->name)->toBe('Updated Vendor')
        ->and($vendor->role)->toBe(Admin::ROLE_VENDOR)
        ->and($vendor->store_id)->toBe($store->id)
        ->and($vendor->status)->toBe(Admin::STATUS_PENDING);
});

test('inactive vendor statuses cannot authenticate', function (string $status) {
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'status' => $status,
        'password' => bcrypt('password'),
        'store_id' => Store::factory(),
    ]);

    $this->post(route('admin.login'), [
        'email' => $vendor->email,
        'password' => 'password',
    ])->assertSessionHasErrors('email');

    expect(auth('admin')->check())->toBeFalse();
})->with([
    Admin::STATUS_PENDING,
    Admin::STATUS_REJECTED,
    Admin::STATUS_SUSPENDED,
]);
