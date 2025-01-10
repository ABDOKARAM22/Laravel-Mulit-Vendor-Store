<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    //    $user = User::where('store_id','=',$order->store_id)->first();
       $user = User::where('id','=',7)->first();
       if($user){
           
           $user->notify(new OrderCreatedNotification($order));

       }
    }
}
