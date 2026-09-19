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
                                    <div class="col-md-4">

                                        <div class="product-search">

                                            <input
                                                type="text"
                                                name="search"
                                                placeholder="Search products"
                                            >

                                            <button type="button">
                                                <i class="fa fa-search"></i>
                                            </button>

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
                                                    Sort Products
                                                </div>

                                                <div class="dropdown-menu dropdown-menu-right">

                                                    <a
                                                        href="#"
                                                        class="dropdown-item"
                                                    >
                                                        Newest
                                                    </a>

                                                    <a
                                                        href="#"
                                                        class="dropdown-item"
                                                    >
                                                        Popular
                                                    </a>

                                                    <a
                                                        href="#"
                                                        class="dropdown-item"
                                                    >
                                                        Most Sale
                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- Price Range -->
                                    <div class="col-md-4">

                                        <div class="product-price-range">

                                            <div class="dropdown">

                                                <div
                                                    class="dropdown-toggle"
                                                    data-toggle="dropdown"
                                                >
                                                    Product Price Range
                                                </div>

                                                <div class="dropdown-menu dropdown-menu-right">

                                                    <a
                                                        href="#"
                                                        class="dropdown-item"
                                                    >
                                                        $0 to $50
                                                    </a>

                                                    <a
                                                        href="#"
                                                        class="dropdown-item"
                                                    >
                                                        $51 to $100
                                                    </a>

                                                </div>

                                            </div>

                                        </div>

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

                                <li class="nav-item">

                                    <a
                                        class="nav-link"
                                        href="#"
                                    >
                                        <i class="fa fa-female"></i>
                                        Fashion & Beauty
                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a
                                        class="nav-link"
                                        href="#"
                                    >
                                        <i class="fa fa-child"></i>
                                        Kids & Babies Clothes
                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a
                                        class="nav-link"
                                        href="#"
                                    >
                                        <i class="fa fa-tshirt"></i>
                                        Men & Women Clothes
                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a
                                        class="nav-link"
                                        href="#"
                                    >
                                        <i class="fa fa-mobile-alt"></i>
                                        Gadgets & Accessories
                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a
                                        class="nav-link"
                                        href="#"
                                    >
                                        <i class="fa fa-microchip"></i>
                                        Electronics & Accessories
                                    </a>

                                </li>

                            </ul>

                        </nav>

                    </div>
                    <!-- Categories End -->


                    <!-- Tags -->
                    <div class="sidebar-widget tag">

                        <h2 class="title">
                            Tags
                        </h2>

                        <a href="#">
                            Lorem ipsum
                        </a>

                        <a href="#">
                            Vivamus
                        </a>

                        <a href="#">
                            Phasellus
                        </a>

                        <a href="#">
                            Pulvinar
                        </a>

                        <a href="#">
                            Curabitur
                        </a>

                        <a href="#">
                            Fusce
                        </a>

                        <a href="#">
                            Sem quis
                        </a>

                        <a href="#">
                            Mollis metus
                        </a>

                    </div>
                    <!-- Tags End -->


                </div>
                <!-- Sidebar End -->

            </div>

        </div>

    </div>
    <!-- Product List End -->


@endsection