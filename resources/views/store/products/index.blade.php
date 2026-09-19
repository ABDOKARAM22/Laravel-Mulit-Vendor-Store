@extends('layouts.main')

@section('title', 'Products List')

@section('content')

<!-- Breadcrumb Start -->
<x-breadcrumb currentpage="Products List" />
<!-- Breadcrumb End -->


<!-- Product List Start -->
<div class="product-view">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-8">

                <div class="row">

                    <!-- Product Filters -->
                    <div class="col-md-12">

                        <div class="product-view-top">

                            <div class="row">

                                <!-- Search -->
                                <div class="col-md-6">

                                    <div class="product-search">

                                        <form
                                            action="{{ route('products.index') }}"
                                            method="GET"
                                        >
                                            <div class="product-search">

                                                <input
                                                    type="text"
                                                    name="search"
                                                    value="{{ request('search') }}"
                                                    placeholder="Search products"
                                                >

                                                <button type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>

                                            </div>
                                        </form>

                                    </div>

                                </div>


                                <!-- Sorting -->
                                <div class="col-md-4">

                                    <div class="product-short">

                                        <div class="dropdown">

                                            <div
                                                class="dropdown-toggle"
                                                data-toggle="dropdown"
                                            >
                                                @switch(request('sort'))

                                                    @case('price_low')
                                                        Price: Low to High
                                                        @break

                                                    @case('price_high')
                                                        Price: High to Low
                                                        @break

                                                    @case('featured')
                                                        Featured Products
                                                        @break

                                                    @case('newest')
                                                        Newest
                                                        @break

                                                    @default
                                                        Sort Products

                                                @endswitch
                                            </div>

                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a
                                                    href="{{ route('products.index', array_merge(request()->except('page'), ['sort' => 'newest'])) }}"
                                                    class="dropdown-item {{ request('sort') === 'newest' ? 'active' : '' }}"
                                                >
                                                    Newest
                                                </a>

                                                <a
                                                    href="{{ route('products.index', array_merge(request()->except('page'), ['sort' => 'price_low'])) }}"
                                                    class="dropdown-item {{ request('sort') === 'price_low' ? 'active' : '' }}"
                                                >
                                                    Price: Low to High
                                                </a>

                                                <a
                                                    href="{{ route('products.index', array_merge(request()->except('page'), ['sort' => 'price_high'])) }}"
                                                    class="dropdown-item {{ request('sort') === 'price_high' ? 'active' : '' }}"
                                                >
                                                    Price: High to Low
                                                </a>

                                                <a
                                                    href="{{ route('products.index', array_merge(request()->except('page'), ['sort' => 'featured'])) }}"
                                                    class="dropdown-item {{ request('sort') === 'featured' ? 'active' : '' }}"
                                                >
                                                    Featured Products
                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <!-- Clear Filters -->
                                <div class="col-md-2">

                                    @if (request()->query())

                                        <a
                                            href="{{ route('products.index') }}"
                                            class="btn"
                                        >
                                            Clear Filters
                                        </a>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- Product Filters End -->


                    <!-- Products -->
                    @forelse ($products as $product)

                        <div class="col-md-4">

                            <div class="product-item">

                                <div class="product-title">

                                    <a
                                        href="{{ route('products.show', $product->slug) }}"
                                    >
                                        {{ $product->name }}
                                    </a>

                                </div>


                                <div class="product-image">

                                    <a
                                        href="{{ route('products.show', $product->slug) }}"
                                    >

                                        <img
                                            src="{{ Handel_image::show_image($product->image) }}"
                                            alt="{{ $product->name }}"
                                        >

                                    </a>

                                    <div class="product-action">

                                        <a
                                            href="{{ route('products.show', $product->slug) }}"
                                            title="View Product"
                                        >
                                            <i class="fa fa-search"></i>
                                        </a>

                                    </div>

                                </div>


                                <form
                                    action="{{ route('cart.store') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="{{ $product->id }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="quantity"
                                        value="1"
                                    >

                                    <div class="product-price">

                                        <h3>

                                            {{ Currency::format($product->price) }}

                                            @if ($product->compare_price)

                                                <span>
                                                    {{ Currency::format($product->compare_price) }}
                                                </span>

                                            @endif

                                        </h3>

                                        <button
                                            type="submit"
                                            class="btn"
                                        >
                                            <i class="fa fa-shopping-cart"></i>
                                            Add to Cart
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @empty

                        <div class="col-md-12">

                            <div class="text-center py-5">

                                <h4>
                                    No products found.
                                </h4>

                                <a
                                    href="{{ route('products.index') }}"
                                    class="btn"
                                >
                                    Browse Products
                                </a>

                            </div>

                        </div>

                    @endforelse
                    <!-- Products End -->


                    <!-- Pagination -->
                    @if ($products->hasPages())

                        <div class="col-md-12">

                            <nav aria-label="Products pagination">

                                {{ $products->links() }}

                            </nav>

                        </div>

                    @endif
                    <!-- Pagination End -->

                </div>

            </div>


            <!-- Sidebar -->
            <div class="col-lg-4 sidebar">


                <!-- Categories -->
                <div class="sidebar-widget category">

                    <h2 class="title">
                        Categories
                    </h2>

                    <nav class="navbar bg-light">

                        <ul class="navbar-nav">

                            @forelse ($categories as $category)

                                <li class="nav-item">

                                    <a
                                        class="nav-link {{ request('category') === $category->slug ? 'active' : '' }}"
                                        href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
                                    >
                                        <i class="fa fa-folder"></i>
                                        {{ $category->name }}
                                    </a>

                                </li>

                            @empty

                                <li class="nav-item">

                                    <span class="nav-link">
                                        No categories available.
                                    </span>

                                </li>

                            @endforelse

                        </ul>

                    </nav>

                </div>
                <!-- Categories End -->


                <!-- Tags -->
                <div class="sidebar-widget tag">

                    <h2 class="title">
                        Tags
                    </h2>

                    @forelse ($tags as $tag)

                        <a
                            href="{{ route('products.index', array_merge(request()->except('page'), ['tag' => $tag->slug])) }}"
                            class="{{ request('tag') === $tag->slug ? 'active' : '' }}"
                        >
                            {{ $tag->name }}
                        </a>

                    @empty

                        <span class="nav-link">
                            No tags available.
                        </span>

                    @endforelse

                </div>
                <!-- Tags End -->


            </div>
            <!-- Sidebar End -->

        </div>

    </div>

</div>
<!-- Product List End -->

@endsection