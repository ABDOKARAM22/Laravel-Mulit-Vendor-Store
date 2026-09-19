@extends('layouts.main')

@section('title', 'Order Details')

@section('content')
<x-breadcrumb currentpage="Order Details"/>

<div class="my-account">
    <div class="container-fluid">
        <div class="row">
<!-- Account Sidebar -->
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">

                    <a class="nav-link" href="{{ route('profile.edit') }}">
                        <i class="fa fa-user"></i>
                        Profile
                    </a>

                    <a class="nav-link active" href="{{ route('orders.index') }}">
                        <i class="fa fa-shopping-bag"></i>
                        Orders
                    </a>

                    <a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="fa fa-shopping-cart"></i>
                        Cart
                    </a>

                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                        Continue Shopping
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="nav-link w-100 text-left border-0">
                            <i class="fa fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>

                </div>
            </div>

            
            {{-- Order Details --}}
            <div class="col-lg-9">
                <div class="account-content">

                    @php
                        $statusClasses = [
                            'pending' => 'badge-warning',
                            'processing' => 'badge-info',
                            'delivering' => 'badge-primary',
                            'completed' => 'badge-success',
                            'cancelled' => 'badge-danger',
                        ];

                        $statusLabels = [
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'delivering' => 'Delivering',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ];

                        $paymentStatusLabels = [
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'failed' => 'Failed',
                            'refunded' => 'Refunded',
                        ];
                    @endphp

                    <div class="account-section">

                        {{-- Header --}}
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                            <div>
                                <h2 class="mb-1">
                                    Order #{{ $order->number }}
                                </h2>

                                <small class="text-muted">
                                    Placed on
                                    {{ $order->created_at?->format('d M Y, h:i A') }}
                                </small>
                            </div>

                            <a
                                href="{{ route('orders.index') }}"
                                class="btn btn-outline-primary mt-2 mt-md-0"
                            >
                                <i class="fa fa-arrow-left"></i>
                                Back to Orders
                            </a>

                        </div>

                        {{-- Order Information --}}
                        <div class="row mb-4">

                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block">
                                        Order Status
                                    </small>

                                    <span class="badge {{ $statusClasses[$order->status] ?? 'badge-secondary' }}">
                                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                    </span>

                                </div>
                            </div>

                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block">
                                        Payment Method
                                    </small>

                                    <strong>
                                        {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                                    </strong>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">

                                    <small class="text-muted d-block">
                                        Payment Status
                                    </small>

                                    <strong>
                                        {{ $paymentStatusLabels[$order->payment_status] ?? ucfirst($order->payment_status ?? 'N/A') }}
                                    </strong>

                                </div>
                            </div>

                        </div>

                        {{-- Store --}}
                        @if($order->store)
                            <div class="border rounded p-3 mb-4">

                                <small class="text-muted d-block">
                                    Store
                                </small>

                                <strong>
                                    {{ $order->store->name }}
                                </strong>

                            </div>
                        @endif

                        {{-- Order Items --}}
                        <h3 class="mb-3">
                            Order Items
                        </h3>

                        <div class="table-responsive mb-4">

                            <table class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($order->items as $item)
                                        <tr>

                                            <td>
                                                {{ $item->product_name }}
                                            </td>

                                            <td>
                                                {{ Currency::format($item->price) }}
                                            </td>

                                            <td>
                                                {{ $item->quantity }}
                                            </td>

                                            <td>
                                                {{ Currency::format($item->subtotal) }}
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        {{-- Addresses --}}
                        <div class="row mb-4">

                            {{-- Billing Address --}}
                            @if($order->billingAddress)
                                <div class="col-md-6 mb-4 mb-md-0">

                                    <div class="border rounded p-4 h-100">

                                        <h4 class="mb-3">
                                            Billing Address
                                        </h4>

                                        <p class="mb-1">
                                            <strong>
                                                {{ $order->billingAddress->first_name }}
                                                {{ $order->billingAddress->last_name }}
                                            </strong>
                                        </p>

                                        <p class="mb-1">
                                            {{ $order->billingAddress->street_address }}
                                        </p>

                                        <p class="mb-1">
                                            {{ $order->billingAddress->city }}

                                            @if($order->billingAddress->state)
                                                , {{ $order->billingAddress->state }}
                                            @endif
                                        </p>

                                        @if($order->billingAddress->postal_code)
                                            <p class="mb-1">
                                                {{ $order->billingAddress->postal_code }}
                                            </p>
                                        @endif

                                        <p class="mb-1">
                                            {{ $order->billingAddress->country_name }}
                                        </p>

                                        <p class="mb-1">
                                            {{ $order->billingAddress->phone_number }}
                                        </p>

                                        <p class="mb-0">
                                            {{ $order->billingAddress->email }}
                                        </p>

                                    </div>

                                </div>
                            @endif

                            {{-- Shipping Address --}}
                            @if($order->shippingAddress)
                                <div class="col-md-6">

                                    <div class="border rounded p-4 h-100">

                                        <h4 class="mb-3">
                                            Shipping Address
                                        </h4>

                                        <p class="mb-1">
                                            <strong>
                                                {{ $order->shippingAddress->first_name }}
                                                {{ $order->shippingAddress->last_name }}
                                            </strong>
                                        </p>

                                        <p class="mb-1">
                                            {{ $order->shippingAddress->street_address }}
                                        </p>

                                        <p class="mb-1">
                                            {{ $order->shippingAddress->city }}

                                            @if($order->shippingAddress->state)
                                                , {{ $order->shippingAddress->state }}
                                            @endif
                                        </p>

                                        @if($order->shippingAddress->postal_code)
                                            <p class="mb-1">
                                                {{ $order->shippingAddress->postal_code }}
                                            </p>
                                        @endif

                                        <p class="mb-1">
                                            {{ $order->shippingAddress->country_name }}
                                        </p>

                                        <p class="mb-1">
                                            {{ $order->shippingAddress->phone_number }}
                                        </p>

                                        <p class="mb-0">
                                            {{ $order->shippingAddress->email }}
                                        </p>

                                    </div>

                                </div>
                            @endif

                        </div>

                        {{-- Order Summary --}}
                        <div class="row justify-content-end">

                            <div class="col-lg-6 col-md-8">

                                <div class="border rounded p-4">

                                    <h4 class="mb-3">
                                        Order Summary
                                    </h4>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal</span>

                                        <span>
                                            {{ Currency::format($order->subtotal) }}
                                        </span>
                                    </div>

                                    @if((float) $order->discount > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Discount</span>

                                            <span>
                                                -{{ Currency::format($order->discount) }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping</span>

                                        <span>
                                            {{ Currency::format($order->shipping) }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Tax</span>

                                        <span>
                                            {{ Currency::format($order->tax) }}
                                        </span>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">

                                        <strong>
                                            Total
                                        </strong>

                                        <strong>
                                            {{ Currency::format($order->total) }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection