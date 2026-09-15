<?php

use App\Events\OrderCreated;
use App\Listeners\SendOrderCreatedNotification;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Store;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->storeA = Store::factory()->create();
    $this->storeB = Store::factory()->create();
    $this->vendorA = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->storeA->id,
    ]);
    $this->vendorB = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->storeB->id,
    ]);
});

function notificationOrder(Store $store): Order
{
    return Order::create([
        'store_id' => $store->id,
        'payment_method' => 'cod',
    ]);
}

test('order notifications are sent to every vendor assigned to the order store only', function () {
    Notification::fake();
    $secondVendor = Admin::factory()->create([
        'role' => Admin::ROLE_VENDOR,
        'store_id' => $this->storeA->id,
    ]);
    $order = notificationOrder($this->storeA);

    (new SendOrderCreatedNotification())->handle(new OrderCreated($order));

    Notification::assertSentTo($this->vendorA, OrderCreatedNotification::class);
    Notification::assertSentTo($secondVendor, OrderCreatedNotification::class);
    Notification::assertNotSentTo($this->vendorB, OrderCreatedNotification::class);
});

test('order broadcasts use an authorized store channel and minimal metadata', function () {
    $order = notificationOrder($this->storeA);
    $event = new OrderCreated($order);

    expect($event->broadcastOn()[0]->name)->toBe("private-stores.{$this->storeA->id}.orders")
        ->and($event->broadcastWith())->toBe([
            'order_id' => $order->id,
            'order_number' => $order->number,
            'store_id' => $this->storeA->id,
            'status' => $order->status,
        ]);
});

test('vendors can authorize their store channel but not another store channel', function () {
    $channel = "private-stores.{$this->storeA->id}.orders";

    $this->actingAs($this->vendorA, 'admin')
        ->postJson('/broadcasting/auth', [
            'channel_name' => $channel,
            'socket_id' => '123.456',
        ])
        ->assertOk();

    $this->actingAs($this->vendorB, 'admin')
        ->postJson('/broadcasting/auth', [
            'channel_name' => $channel,
            'socket_id' => '123.456',
        ])
        ->assertForbidden();
});

test('admin and super admin can authorize store order channels', function () {
    foreach ([
        Admin::ROLE_ADMIN,
        Admin::ROLE_SUPER_ADMIN,
    ] as $role) {
        $admin = Admin::factory()->create(['role' => $role]);

        $this->actingAs($admin, 'admin')
            ->postJson('/broadcasting/auth', [
                'channel_name' => "private-stores.{$this->storeA->id}.orders",
                'socket_id' => '123.456',
            ])
            ->assertOk();
    }
});
