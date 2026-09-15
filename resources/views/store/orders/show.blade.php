@extends('layouts.main')

@section('title', 'Order Details')

@section('content')
<div class="container py-4">
    <h1>Order #{{ $order->number }}</h1>
    <p>Status: {{ $order->status }}</p>
    <p>Total: {{ Currency::format($order->total) }}</p>
    <ul>
        @foreach ($order->items as $item)
            <li>{{ $item->product_name }} x {{ $item->quantity }} — {{ Currency::format($item->subtotal) }}</li>
        @endforeach
    </ul>
</div>
@endsection
