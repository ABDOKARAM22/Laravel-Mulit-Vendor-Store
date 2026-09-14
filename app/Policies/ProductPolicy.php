<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;

class ProductPolicy
{
    public function before(Admin $admin): ?bool
    {
        return $admin->isSuperAdmin() ? true : null;
    }

    public function viewAny(Admin $admin): bool
    {
        return $admin->isAdmin() || $admin->isVendor();
    }

    public function view(Admin $admin, Product $product): bool
    {
        return $admin->isAdmin() || $this->ownsStore($admin, $product->store_id);
    }

    public function create(Admin $admin): bool
    {
        return $admin->isAdmin() || ($admin->isVendor() && $admin->store_id !== null);
    }

    public function update(Admin $admin, Product $product): bool
    {
        return $admin->isAdmin() || $this->ownsStore($admin, $product->store_id);
    }

    public function delete(Admin $admin, Product $product): bool
    {
        return $admin->isAdmin() || $this->ownsStore($admin, $product->store_id);
    }

    public function restore(Admin $admin, Product $product): bool
    {
        return $admin->isAdmin() || $this->ownsStore($admin, $product->store_id);
    }

    public function forceDelete(Admin $admin, Product $product): bool
    {
        return $admin->isAdmin() || $this->ownsStore($admin, $product->store_id);
    }

    private function ownsStore(Admin $admin, ?int $storeId): bool
    {
        return $admin->isVendor() && $admin->store_id === $storeId;
    }
}
