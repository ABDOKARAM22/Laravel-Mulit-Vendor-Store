@extends('Dashboard.Layouts.main')

@section('page_title', 'Order Details')

@section('content')
<div class="container-fluid">
    <h2>Order #{{ $order->number }}</h2>
    <p>Store: {{ $order->store->name }}</p>
    <p>Customer: {{ $order->user->name }}</p>
    <p>Total: {{ Currency::format($order->total) }}</p>

    <form method="POST" action="{{ route('dashboard.orders.status', $order) }}">
        @csrf
        @method('PATCH')
        <select name="status">
            @foreach (\App\Models\Order::STATUSES as $status)
                <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <button type="submit">Update status</button>
    </form>

    <ul>
        @foreach ($order->items as $item)
            <li>{{ $item->product_name }} x {{ $item->quantity }} — {{ Currency::format($item->subtotal) }}</li>
        @endforeach
    </ul>
</div>
@endsection
