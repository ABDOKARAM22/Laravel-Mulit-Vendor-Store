<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Category;

class CategoryPolicy
{
    public function before(Admin $admin): ?bool
    {
        return $admin->isSuperAdmin() ? true : null;
    }

    public function viewAny(Admin $admin): bool
    {
        return $admin->isAdmin();
    }

    public function view(Admin $admin, Category $category): bool
    {
        return $admin->isAdmin();
    }

    public function create(Admin $admin): bool
    {
        return $admin->isAdmin();
    }

    public function update(Admin $admin, Category $category): bool
    {
        return $admin->isAdmin();
    }

    public function delete(Admin $admin, Category $category): bool
    {
        return $admin->isAdmin();
    }

    public function restore(Admin $admin, Category $category): bool
    {
        return $admin->isAdmin();
    }

    public function forceDelete(Admin $admin, Category $category): bool
    {
        return $admin->isAdmin();
    }
}
