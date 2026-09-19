@extends('Dashboard.Layouts.main')

@section('page_title', 'Dashboard')

@section('breadcrumb', 'Dashboard')

@section('content')

    {{-- Welcome --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="mb-1">
                        Welcome back, {{ $admin->name }}
                    </h5>

                    <p class="text-muted mb-0">
                        @if ($admin->isVendor())
                            Here is an overview of your store performance.
                        @else
                            Here is an overview of your store platform.
                        @endif
                    </p>

                </div>
            </div>
        </div>
    </div>


    {{-- Statistics --}}
    <div class="row">

        {{-- Total Orders --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="small-box bg-info">

                <div class="inner">

                    <h3>
                        {{ $stats['totalOrders'] }}
                    </h3>

                    <p>
                        {{ $admin->isVendor() ? 'My Orders' : 'Total Orders' }}
                    </p>

                </div>

                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>

                <a href="{{ route('dashboard.orders.index') }}"
                   class="small-box-footer">

                    View Orders
                    <i class="fas fa-arrow-circle-right ml-1"></i>

                </a>

            </div>
        </div>


        {{-- Pending Orders --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="small-box bg-warning">

                <div class="inner">

                    <h3>
                        {{ $stats['pendingOrders'] }}
                    </h3>

                    <p>
                        Pending Orders
                    </p>

                </div>

                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>

                <a href="{{ route('dashboard.orders.index') }}"
                   class="small-box-footer">

                    View Orders
                    <i class="fas fa-arrow-circle-right ml-1"></i>

                </a>

            </div>
        </div>


        {{-- Products --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="small-box bg-success">

                <div class="inner">

                    <h3>
                        {{ $stats['totalProducts'] }}
                    </h3>

                    <p>
                        {{ $admin->isVendor() ? 'My Products' : 'Total Products' }}
                    </p>

                </div>

                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>

                <a href="{{ route('dashboard.products.index') }}"
                   class="small-box-footer">

                    View Products
                    <i class="fas fa-arrow-circle-right ml-1"></i>

                </a>

            </div>
        </div>


        {{-- Sales --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="small-box bg-primary">

                <div class="inner">

                    <h3>
                        {{ Currency::format($stats['totalSales']) }}
                    </h3>

                    <p>
                        {{ $admin->isVendor() ? 'My Sales' : 'Total Sales' }}
                    </p>

                </div>

                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>

                <span class="small-box-footer">
                    Completed Orders
                </span>

            </div>
        </div>

    </div>


    {{-- Admin / Super Admin Statistics --}}
    @if (! $admin->isVendor())

        <div class="row">

            {{-- Customers --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="small-box bg-secondary">

                    <div class="inner">

                        <h3>
                            {{ $stats['totalCustomers'] }}
                        </h3>

                        <p>
                            Total Customers
                        </p>

                    </div>

                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>

                    <span class="small-box-footer">
                        Registered Customers
                    </span>

                </div>
            </div>


            {{-- Categories --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="small-box bg-dark">

                    <div class="inner">

                        <h3>
                            {{ $stats['totalCategories'] }}
                        </h3>

                        <p>
                            Total Categories
                        </p>

                    </div>

                    <div class="icon">
                        <i class="fas fa-tags"></i>
                    </div>

                    @if (
                        $admin->isAdmin() ||
                        $admin->isSuperAdmin()
                    )
                        <a href="{{ route('dashboard.categories.index') }}"
                           class="small-box-footer">

                            View Categories
                            <i class="fas fa-arrow-circle-right ml-1"></i>

                        </a>
                    @else
                        <span class="small-box-footer">
                            Categories
                        </span>
                    @endif

                </div>
            </div>

        </div>

    @endif


    {{-- Quick Actions --}}
    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Quick Actions
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Products --}}
                        @if ($admin->can('viewAny', \App\Models\Product::class))

                            <div class="col-md-4 mb-3 mb-md-0">

                                <a href="{{ route('dashboard.products.index') }}"
                                   class="btn btn-outline-primary btn-block">

                                    <i class="fas fa-box mr-1"></i>

                                    Manage Products

                                </a>

                            </div>

                        @endif


                        {{-- Add Product --}}
                        @if ($admin->can('create', \App\Models\Product::class))

                            <div class="col-md-4 mb-3 mb-md-0">

                                <a href="{{ route('dashboard.products.create') }}"
                                   class="btn btn-outline-success btn-block">

                                    <i class="fas fa-plus mr-1"></i>

                                    Add Product

                                </a>

                            </div>

                        @endif


                        {{-- Categories --}}
                        @if (
                            $admin->isAdmin() ||
                            $admin->isSuperAdmin()
                        )

                            <div class="col-md-4">

                                <a href="{{ route('dashboard.categories.index') }}"
                                   class="btn btn-outline-secondary btn-block">

                                    <i class="fas fa-tags mr-1"></i>

                                    Manage Categories

                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection