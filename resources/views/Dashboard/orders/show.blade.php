@extends('Dashboard.Layouts.main')

@section('page_title', 'Order Details')

@section('breadcrumb', 'Order #' . $order->number)

@section('content')

    <div class="row">

        <!-- Order Information -->
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <h3 class="card-title mb-2 mb-md-0">

                            <i class="fas fa-shopping-cart mr-2"></i>

                            Order #{{ $order->number }}

                        </h3>

                        <a href="{{ route('dashboard.orders.index') }}"
                           class="btn btn-secondary">

                            <i class="fas fa-arrow-left mr-1"></i>
                            Back to Orders

                        </a>

                    </div>

                </div>


                <div class="card-body">

                    <div class="row">

                        <!-- Order Number -->
                        <div class="col-md-6 mb-3">

                            <strong>
                                Order Number
                            </strong>

                            <p class="text-muted mb-0">
                                #{{ $order->number }}
                            </p>

                        </div>


                        <!-- Created At -->
                        <div class="col-md-6 mb-3">

                            <strong>
                                Created At
                            </strong>

                            <p class="text-muted mb-0">

                                {{ $order->created_at?->format('Y-m-d H:i') ?? '—' }}

                            </p>

                        </div>


                        <!-- Customer -->
                        <div class="col-md-6 mb-3">

                            <strong>
                                Customer
                            </strong>

                            <p class="text-muted mb-0">

                                {{ $order->user->name }}

                            </p>

                            @if ($order->user->email)

                                <small class="text-muted">
                                    {{ $order->user->email }}
                                </small>

                            @endif

                        </div>


                        <!-- Store -->
                        <div class="col-md-6 mb-3">

                            <strong>
                                Store
                            </strong>

                            <p class="text-muted mb-0">

                                {{ $order->store?->name ?? '—' }}

                            </p>

                        </div>


                        <!-- Payment Method -->
                        <div class="col-md-6 mb-3">

                            <strong>
                                Payment Method
                            </strong>

                            <p class="text-muted mb-0">

                                {{ ucfirst($order->payment_method ?? '—') }}

                            </p>

                        </div>


                        <!-- Payment Status -->
                        <div class="col-md-6 mb-3">

                            <strong>
                                Payment Status
                            </strong>

                            <p class="mb-0">

                                @if ($order->payment_status === 'paid')

                                    <span class="badge badge-success">
                                        Paid
                                    </span>

                                @elseif ($order->payment_status === 'pending')

                                    <span class="badge badge-warning">
                                        Pending
                                    </span>

                                @elseif ($order->payment_status === 'failed')

                                    <span class="badge badge-danger">
                                        Failed
                                    </span>

                                @else

                                    <span class="badge badge-secondary">
                                        {{ ucfirst($order->payment_status ?? 'Unknown') }}
                                    </span>

                                @endif

                            </p>

                        </div>


                        <!-- Current Status -->
                        <div class="col-md-6 mb-3">

                            <strong>
                                Current Status
                            </strong>

                            <p class="mb-0">

                                @switch($order->status)

                                    @case(\App\Models\Order::STATUS_PENDING)

                                        <span class="badge badge-warning">
                                            Pending
                                        </span>

                                        @break

                                    @case(\App\Models\Order::STATUS_PROCESSING)

                                        <span class="badge badge-info">
                                            Processing
                                        </span>

                                        @break

                                    @case(\App\Models\Order::STATUS_DELIVERING)

                                        <span class="badge badge-primary">
                                            Delivering
                                        </span>

                                        @break

                                    @case(\App\Models\Order::STATUS_COMPLETED)

                                        <span class="badge badge-success">
                                            Completed
                                        </span>

                                        @break

                                    @case(\App\Models\Order::STATUS_CANCELLED)

                                        <span class="badge badge-danger">
                                            Cancelled
                                        </span>

                                        @break

                                    @default

                                        <span class="badge badge-secondary">
                                            {{ ucfirst($order->status) }}
                                        </span>

                                @endswitch

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Order Items -->
            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-box mr-2"></i>
                        Order Items

                    </h3>

                </div>


                <div class="card-body">

                    @if ($order->items->count())

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover">

                                <thead>

                                    <tr>

                                        <th>Product</th>

                                        <th>Price</th>

                                        <th>Quantity</th>

                                        <th>Subtotal</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach ($order->items as $item)

                                        <tr>

                                            <td>

                                                <strong>
                                                    {{ $item->product_name }}
                                                </strong>

                                            </td>


                                            <td>

                                                {{ Currency::format($item->price) }}

                                            </td>


                                            <td>

                                                {{ $item->quantity }}

                                            </td>


                                            <td>

                                                <strong>
                                                    {{ Currency::format($item->subtotal) }}
                                                </strong>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center py-4">

                            <i class="fas fa-box-open fa-2x text-muted mb-3"></i>

                            <p class="text-muted mb-0">
                                No items found for this order.
                            </p>

                        </div>

                    @endif

                </div>

            </div>


            <!-- Addresses -->
            <div class="row">

                <!-- Billing Address -->
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-header">

                            <h3 class="card-title">

                                <i class="fas fa-file-invoice mr-2"></i>
                                Billing Address

                            </h3>

                        </div>


                        <div class="card-body">

                            @if ($order->billingAddress)

                                <strong>

                                    {{ $order->billingAddress->first_name }}
                                    {{ $order->billingAddress->last_name }}

                                </strong>

                                <p class="text-muted mt-2 mb-1">

                                    {{ $order->billingAddress->street_address }}

                                </p>

                                <p class="text-muted mb-1">

                                    {{ $order->billingAddress->city }}

                                    @if ($order->billingAddress->state)
                                        , {{ $order->billingAddress->state }}
                                    @endif

                                </p>

                                @if ($order->billingAddress->postal_code)

                                    <p class="text-muted mb-1">

                                        {{ $order->billingAddress->postal_code }}

                                    </p>

                                @endif

                                @if ($order->billingAddress->country)

                                    <p class="text-muted mb-1">

                                        {{ $order->billingAddress->country_name }}

                                    </p>

                                @endif

                                @if ($order->billingAddress->phone_number)

                                    <p class="text-muted mb-0">

                                        {{ $order->billingAddress->phone_number }}

                                    </p>

                                @endif

                            @else

                                <p class="text-muted mb-0">
                                    No billing address available.
                                </p>

                            @endif

                        </div>

                    </div>

                </div>


                <!-- Shipping Address -->
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-header">

                            <h3 class="card-title">

                                <i class="fas fa-truck mr-2"></i>
                                Shipping Address

                            </h3>

                        </div>


                        <div class="card-body">

                            @if ($order->shippingAddress)

                                <strong>

                                    {{ $order->shippingAddress->first_name }}
                                    {{ $order->shippingAddress->last_name }}

                                </strong>

                                <p class="text-muted mt-2 mb-1">

                                    {{ $order->shippingAddress->street_address }}

                                </p>

                                <p class="text-muted mb-1">

                                    {{ $order->shippingAddress->city }}

                                    @if ($order->shippingAddress->state)
                                        , {{ $order->shippingAddress->state }}
                                    @endif

                                </p>

                                @if ($order->shippingAddress->postal_code)

                                    <p class="text-muted mb-1">

                                        {{ $order->shippingAddress->postal_code }}

                                    </p>

                                @endif

                                @if ($order->shippingAddress->country)

                                    <p class="text-muted mb-1">

                                        {{ $order->shippingAddress->country_name }}

                                    </p>

                                @endif

                                @if ($order->shippingAddress->phone_number)

                                    <p class="text-muted mb-0">

                                        {{ $order->shippingAddress->phone_number }}

                                    </p>

                                @endif

                            @else

                                <p class="text-muted mb-0">
                                    No shipping address available.
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Order Summary -->
        <div class="col-lg-4">

            <!-- Update Status -->
            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-sync-alt mr-2"></i>
                        Update Status

                    </h3>

                </div>


                <form method="POST"
                      action="{{ route('dashboard.orders.status', $order) }}">

                    @csrf
                    @method('PATCH')

                    <div class="card-body">

                        @if ($errors->any())

                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <div class="form-group">

                            <label for="status">
                                Order Status
                            </label>

                            <select name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror">

                                @foreach (\App\Models\Order::STATUSES as $status)

                                    <option value="{{ $status }}"
                                        @selected(old('status', $order->status) === $status)>

                                        {{ ucfirst($status) }}

                                    </option>

                                @endforeach

                            </select>

                            @error('status')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="card-footer">

                        <button type="submit"
                                class="btn btn-primary btn-block">

                            <i class="fas fa-save mr-1"></i>
                            Update Status

                        </button>

                    </div>

                </form>

            </div>


            <!-- Order Summary -->
            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-receipt mr-2"></i>
                        Order Summary

                    </h3>

                </div>


                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            {{ Currency::format($order->subtotal) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Shipping
                        </span>

                        <strong>
                            {{ Currency::format($order->shipping) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Tax
                        </span>

                        <strong>
                            {{ Currency::format($order->tax) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Discount
                        </span>

                        <strong class="text-success">

                            -{{ Currency::format($order->discount) }}

                        </strong>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between">

                        <strong>
                            Total
                        </strong>

                        <strong class="h5 mb-0">

                            {{ Currency::format($order->total) }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection