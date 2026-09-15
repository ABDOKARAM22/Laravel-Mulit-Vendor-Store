@extends('Dashboard.Layouts.main')

@section('page_title', 'Orders')

@section('content')
<div class="container-fluid">
    @forelse ($orders as $order)
        <div class="mb-3">
            <a href="{{ route('dashboard.orders.show', $order) }}">Order #{{ $order->number }}</a>
            <span>{{ $order->store->name }}</span>
            <span>{{ $order->status }}</span>
            <span>{{ Currency::format($order->total) }}</span>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
    {{ $orders->links() }}
</div>
@endsection
