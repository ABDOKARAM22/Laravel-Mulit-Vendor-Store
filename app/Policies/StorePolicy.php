<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Store;

class StorePolicy
{
    public function before(Admin $admin): ?bool
    {
        return $admin->isSuperAdmin() ? true : null;
    }

    public function viewAny(Admin $admin): bool
    {
        return $admin->isAdmin() || $admin->isVendor();
    }

    public function view(Admin $admin, Store $store): bool
    {
        return $admin->isAdmin() || $this->ownsStore($admin, $store);
    }

    public function create(Admin $admin): bool
    {
        return $admin->isAdmin();
    }

    public function update(Admin $admin, Store $store): bool
    {
        return $admin->isAdmin() || $this->ownsStore($admin, $store);
    }

    public function updateStatus(Admin $admin, Store $store): bool
    {
        return $admin->isAdmin();
    }

    public function delete(Admin $admin, Store $store): bool
    {
        return false;
    }

    private function ownsStore(Admin $admin, Store $store): bool
    {
        return $admin->isVendor()
            && $admin->store_id === $store->id;
    }
}