<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    public function before(Admin $admin): ?bool
    {
        return $admin->isSuperAdmin() ? true : null;
    }

    public function viewAny(Admin $admin): bool
    {
        return $admin->isAdmin();
    }

    public function view(Admin $admin, Admin $vendor): bool
    {
        return $admin->isAdmin() && $vendor->isVendor();
    }

    public function update(Admin $admin, Admin $vendor): bool
    {
        return $admin->isAdmin() && $vendor->isVendor();
    }

    public function updateStatus(Admin $admin, Admin $vendor): bool
    {
        return $admin->isAdmin() && $vendor->isVendor();
    }
}
