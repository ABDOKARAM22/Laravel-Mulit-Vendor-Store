<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $addr;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->addr = $order->billingAddress;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast','database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Order #'. $this->order->number)
                    ->greeting("Hi {$notifiable->name},")
                    ->line("A new order #{$this->order->number} created by {$this->addr->name} from {$this->addr->country_name}")
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable){
        return [
            'title' => "New Order #{$this->order->number}",
            'body' => "A new order #{$this->order->number} created by {$this->addr->name} from {$this->addr->country_name}",
            'icon' => "fas fa-file",
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast(object $notifiable){
        return new BroadcastMessage([
            'title' => "New Order #{$this->order->number}",
            'body' => "A new order #{$this->order->number} created by {$this->addr->name} from {$this->addr->country_name}",
            'icon' => "fas fa-file",
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
