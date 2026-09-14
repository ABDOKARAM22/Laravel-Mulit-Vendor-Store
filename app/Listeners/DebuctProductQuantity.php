<?php

namespace App\Listeners;

use App\Facades\Cart;
use App\Models\Product;
use App\Events\OrderCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DebuctProductQuantity
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
        // Inventory is reserved and decremented inside the checkout transaction.
    }
}
