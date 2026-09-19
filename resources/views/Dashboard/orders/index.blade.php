@extends('Dashboard.Layouts.main')

@section('page_title', 'Orders')

@section('breadcrumb', 'Orders')

@section('content')

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-2 mb-md-0">

                    <i class="fas fa-shopping-cart mr-2"></i>
                    Orders

                </h3>

            </div>

        </div>


        <div class="card-body">

            @if ($orders->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>Order</th>

                                <th>Customer</th>

                                <th>Store</th>

                                <th>Total</th>

                                <th>Payment</th>

                                <th>Status</th>

                                <th>Created At</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($orders as $order)

                                <tr>

                                    <td>

                                        <a href="{{ route('dashboard.orders.show', $order) }}">

                                            <strong>
                                                #{{ $order->number }}
                                            </strong>

                                        </a>

                                    </td>


                                    <td>

                                        {{ $order->user->name }}

                                        @if ($order->user->email)

                                            <div class="text-muted small">
                                                {{ $order->user->email }}
                                            </div>

                                        @endif

                                    </td>


                                    <td>

                                        {{ $order->store?->name ?? '—' }}

                                    </td>


                                    <td>

                                        <strong>
                                            {{ Currency::format($order->total) }}
                                        </strong>

                                    </td>


                                    <td>

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

                                    </td>


                                    <td>

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

                                    </td>


                                    <td>

                                        {{ $order->created_at?->format('Y-m-d H:i') ?? '—' }}

                                    </td>


                                    <td class="text-center">

                                        <a href="{{ route('dashboard.orders.show', $order) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="View Order">

                                            <i class="fas fa-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                <div class="mt-4 d-flex justify-content-center">

                    {{ $orders->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i class="fas fa-shopping-cart fa-3x text-muted"></i>

                    </div>

                    <h5>
                        No Orders Found
                    </h5>

                    <p class="text-muted mb-0">
                        There are currently no orders to display.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection