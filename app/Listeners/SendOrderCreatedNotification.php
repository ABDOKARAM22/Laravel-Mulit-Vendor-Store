<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Admin;
use App\Notifications\OrderCreatedNotification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        Admin::query()
            ->where('role', Admin::ROLE_VENDOR)
            ->where('store_id', $order->store_id)
            ->get()
            ->each(fn (Admin $vendor) => $vendor->notify(new OrderCreatedNotification($order)));
    }
}
