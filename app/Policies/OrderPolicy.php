<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function before(Admin|User $user, string $ability): ?bool
    {
        return $user instanceof Admin && $user->isSuperAdmin() && $ability !== 'updateStatus' ? true : null;
    }

    public function viewAny(Admin|User $user): bool
    {
        return $user instanceof User
            || $user->isAdmin()
            || $user->isVendor();
    }

    public function viewCustomerOrders(User $user): bool
    {
        return true;
    }

    public function view(Admin|User $user, Order $order): bool
    {
        if ($user instanceof User) {
            return $order->user_id === $user->id;
        }

        return $user->isAdmin()
            || ($user->isVendor() && $user->store_id === $order->store_id);
    }

    public function updateStatus(Admin $admin, Order $order, string $status): bool
    {
        if (! $admin->isSuperAdmin()
            && ! $admin->isAdmin()
            && ! ($admin->isVendor() && $admin->store_id === $order->store_id)) {
            return false;
        }

        return $order->canTransitionTo($status);
    }
}
