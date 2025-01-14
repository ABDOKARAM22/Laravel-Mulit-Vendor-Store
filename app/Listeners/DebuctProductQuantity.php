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
        $order = $event->order;
        foreach($order->products as $product){

            if ($product->quantity >= $product->pivot->quantity) {
            $product->decrement('quantity',$product->pivot->quantity);
            }
        }
    }
}
