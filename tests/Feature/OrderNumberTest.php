<?php

use App\Models\Order;
use App\Models\Store;

test('order numbers remain unique and preserve the year sequence format', function () {
    $store = Store::factory()->create();

    $first = Order::create([
        'store_id' => $store->id,
        'payment_method' => 'cod',
    ]);
    $second = Order::create([
        'store_id' => $store->id,
        'payment_method' => 'cod',
    ]);

    expect($first->number)->toMatch('/^' . now()->year . '\d{4}$/')
        ->and($second->number)->toMatch('/^' . now()->year . '\d{4}$/')
        ->and($second->number)->toBe((string) ((int) $first->number + 1))
        ->and($first->number)->not->toBe($second->number);
});
