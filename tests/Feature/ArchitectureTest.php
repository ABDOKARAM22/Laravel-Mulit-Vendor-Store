<?php

use App\Models\Admin;
use App\Models\Store;

test('vendor admins can be assigned to a store', function () {
    $store = Store::factory()->create();
    $vendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $store->id,
    ]);

    expect($vendor->store->is($store))->toBeTrue()
        ->and($store->admins->contains($vendor))->toBeTrue();
});

test('public admin registration is not available', function () {
    $this->get('/admin/register')->assertNotFound();
    $this->post('/admin/register')->assertNotFound();
});
