@extends('layouts.main')

@section('title', 'My Orders')

@section('content')
<div class="container py-4">
    <h1>My Orders</h1>
    @forelse ($orders as $order)
        <div class="mb-3">
            <a href="{{ route('orders.show', $order) }}">Order #{{ $order->number }}</a>
            <span>{{ $order->status }}</span>
            <span>{{ Currency::format($order->total) }}</span>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
    {{ $orders->links() }}
</div>
@endsection
