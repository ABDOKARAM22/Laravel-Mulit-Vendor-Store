@extends('layouts.main')

@section('title', 'My Orders')

@section('content')

<!-- Breadcrumb Start -->
<x-breadcrumb currentpage="My Orders"/>
<!-- Breadcrumb End -->

<!-- Orders Start -->
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

            <!-- Orders Content -->
            <div class="col-md-9">

                <div class="tab-content">

                    <div class="tab-pane fade show active">

                        <h4>My Orders</h4>

                        @if ($orders->count())

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Order</th>
                                            <th>Store</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($orders as $order)

                                            @php
                                                $statusClasses = [
                                                    'pending' => 'badge-warning',
                                                    'processing' => 'badge-info',
                                                    'delivering' => 'badge-primary',
                                                    'completed' => 'badge-success',
                                                    'cancelled' => 'badge-danger',
                                                ];

                                                $statusClass = $statusClasses[$order->status] ?? 'badge-secondary';
                                            @endphp

                                            <tr>
                                                <td>
                                                    <strong>
                                                        #{{ $order->number }}
                                                    </strong>
                                                </td>

                                                <td>
                                                    {{ $order->store?->name ?? 'Store' }}
                                                </td>

                                                <td>
                                                    {{ $order->created_at?->format('d M Y') }}
                                                </td>

                                                <td>
                                                    <strong>
                                                        {{ Currency::format($order->total) }}
                                                    </strong>
                                                </td>

                                                <td>
                                                    <span class="badge {{ $statusClass }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <a
                                                        href="{{ route('orders.show', $order) }}"
                                                        class="btn btn-sm"
                                                    >
                                                        <i class="fa fa-eye"></i>
                                                        View
                                                    </a>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $orders->links() }}
                            </div>

                        @else

                            <!-- Empty State -->
                            <div class="text-center py-5">

                                <i
                                    class="fa fa-shopping-bag fa-3x mb-3"
                                    aria-hidden="true"
                                ></i>

                                <h5>No Orders Found</h5>

                                <p class="mb-4">
                                    You haven't placed any orders yet.
                                </p>

                                <a
                                    href="{{ route('products.index') }}"
                                    class="btn"
                                >
                                    <i class="fa fa-shopping-cart"></i>
                                    Start Shopping
                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<!-- Orders End -->

@endsection