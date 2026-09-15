<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Admin;

Broadcast::routes(['middleware' => ['auth:admin']]);

Broadcast::channel('stores.{store}.orders', function (Admin $admin, int $store): bool {
    return $admin->isSuperAdmin()
        || $admin->isAdmin()
        || ($admin->isVendor() && (int) $admin->store_id === $store);
}, ['guards' => ['admin']]);
