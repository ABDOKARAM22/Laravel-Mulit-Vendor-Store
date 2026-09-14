<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function before(Admin|User $user): ?bool
    {
        return $user instanceof Admin && $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(Admin|User $user): bool
    {
        return $user instanceof User
            || $user->isAdmin()
            || $user->isVendor();
    }

    public function view(Admin|User $user, Order $order): bool
    {
        if ($user instanceof User) {
            return $order->user_id === $user->id;
        }

        return $user->isAdmin()
            || ($user->isVendor() && $user->store_id === $order->store_id);
    }

    public function update(Admin|User $user, Order $order): bool
    {
        return $user instanceof Admin && 
        ($user->isAdmin() || ($user->isVendor() && $user->store_id === $order->store_id));
    }
}
