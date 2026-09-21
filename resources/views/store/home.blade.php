@extends('layouts.main')

@section('title', 'Abdo Store')

@section('content')

<!-- Main Slider Start -->

<div class="header">
    <div class="container-fluid">
        <div class="row">

            <x-Categories-menu />

            <div class="col-md-6">
                <div class="header-slider normal-slider">

                    <div class="header-slider-item">
                        <img
                            src="{{ asset('img/slider-1.jpg') }}"
                            alt="Store Products"
                        >

                        <div class="header-slider-caption">
                            <h1>Discover Our Products</h1>

                            <p>
                                Explore products from our marketplace.
                            </p>

                            <a
                                class="btn"
                                href="{{ route('products.index') }}"
                            >
                                <i class="fa fa-shopping-cart"></i>
                                Shop Now
                            </a>
                        </div>
                    </div>

                    <div class="header-slider-item">
                        <img
                            src="{{ asset('img/slider-2.jpg') }}"
                            alt="Featured Products"
                        >

                        <div class="header-slider-caption">
                            <h1>Featured Products</h1>

                            <p>
                                Discover some of our featured products.
                            </p>

                            <a
                                class="btn"
                                href="{{ route('products.index') }}"
                            >
                                <i class="fa fa-shopping-cart"></i>
                                Shop Now
                            </a>
                        </div>
                    </div>

                    <div class="header-slider-item">
                        <img
                            src="{{ asset('img/slider-3.jpg') }}"
                            alt="Latest Products"
                        >

                        <div class="header-slider-caption">
                            <h1>Latest Products</h1>

                            <p>
                                Check out the latest products in our store.
                            </p>

                            <a
                                class="btn"
                                href="{{ route('products.index') }}"
                            >
                                <i class="fa fa-shopping-cart"></i>
                                Shop Now
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="header-img">

                    <div class="img-item">
                        <img
                            src="{{ asset('img/category-1.jpg') }}"
                            alt="Store Products"
                        >

                        <a
                            class="img-text"
                            href="{{ route('products.index') }}"
                        >
                            <p>Explore Products</p>
                        </a>
                    </div>

                    <div class="img-item">
                        <img
                            src="{{ asset('img/category-2.jpg') }}"
                            alt="Store Products"
                        >

                        <a
                            class="img-text"
                            href="{{ route('products.index') }}"
                        >
                            <p>Shop Now</p>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Main Slider End -->


<!-- Feature Start -->

<div class="feature">
    <div class="container-fluid">

        <div class="row align-items-center">

            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">

                    <i class="fa fa-money-bill-wave"></i>

                    <h2>Cash on Delivery</h2>

                    <p>
                        Pay for your order when it is delivered.
                    </p>

                </div>
            </div>

            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">

                    <i class="fa fa-truck"></i>

                    <h2>Worldwide Delivery</h2>

                    <p>
                        Delivery service for customers worldwide.
                    </p>

                </div>
            </div>

            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">

                    <i class="fa fa-sync-alt"></i>

                    <h2>90 Days Return</h2>

                    <p>
                        Easy return policy for eligible orders.
                    </p>

                </div>
            </div>

            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">

                    <i class="fa fa-comments"></i>

                    <h2>24/7 Support</h2>

                    <p>
                        Customer support is available whenever you need it.
                    </p>

                </div>
            </div>

        </div>

    </div>
</div>

<!-- Feature End -->


<!-- Vendor CTA Start -->

<div class="vendor-cta">
    <div class="container-fluid">

        <div class="text-center py-5">

            <h2>Start Selling on Abdo Store</h2>

            <p>
                Have products to sell?
                Join our marketplace and start growing your business.
            </p>

            <a
                class="btn"
                href="{{ route('vendor.register') }}"
            >
                <i class="fa fa-store"></i>
                Become a Vendor
            </a>

        </div>

    </div>
</div>

<!-- Vendor CTA End -->


<!-- Featured Product Start -->

<div class="featured-product product">

    <div class="container-fluid">

        <div class="section-header">
            <h1>Featured Products</h1>
        </div>

        <div class="row align-items-center product-slider product-slider-4">

            @forelse ($featured_products as $f_product)

                <div class="col-lg-3">

                    <div class="product-item">

                        <div class="product-title">

                            <a
                                href="{{ route('products.show', $f_product->slug) }}"
                            >
                                {{ $f_product->name }}
                            </a>

                        </div>

                        <div class="product-image">

                            <a
                                href="{{ route('products.show', $f_product->slug) }}"
                            >
                                <img
                                    src="{{ Handel_image::show_image($f_product->image) }}"
                                    alt="{{ $f_product->name }}"
                                >
                            </a>

                            <div class="product-action">

                                <a
                                    href="{{ route('products.show', $f_product->slug) }}"
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
                                value="{{ $f_product->id }}"
                            >

                            <input
                                type="hidden"
                                name="quantity"
                                value="1"
                            >

                            <div class="product-price">

                                <h3>
                                    {{ Currency::format($f_product->price) }}
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

                <div class="col-12">
                    <div class="text-center py-5">

                        <h4>No featured products available.</h4>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn"
                        >
                            Browse Products
                        </a>

                    </div>
                </div>

            @endforelse

        </div>

    </div>

</div>

<!-- Featured Product End -->


<!-- Recent Product Start -->

<div class="recent-product product">

    <div class="container-fluid">

        <div class="section-header">
            <h1>Latest Products</h1>
        </div>

        <div class="row align-items-center product-slider product-slider-4">

            @forelse ($latest_products as $l_product)

                <div class="col-lg-3">

                    <div class="product-item">

                        <div class="product-title">

                            <a
                                href="{{ route('products.show', $l_product->slug) }}"
                            >
                                {{ $l_product->name }}
                            </a>

                        </div>

                        <div class="product-image">

                            <a
                                href="{{ route('products.show', $l_product->slug) }}"
                            >
                                <img
                                    src="{{ Handel_image::show_image($l_product->image) }}"
                                    alt="{{ $l_product->name }}"
                                >
                            </a>

                            <div class="product-action">

                                <a
                                    href="{{ route('products.show', $l_product->slug) }}"
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
                                value="{{ $l_product->id }}"
                            >

                            <input
                                type="hidden"
                                name="quantity"
                                value="1"
                            >

                            <div class="product-price">

                                <h3>

                                    {{ Currency::format($l_product->price) }}

                                    @if ($l_product->compare_price)
                                        <span>
                                            {{ Currency::format($l_product->compare_price) }}
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

                <div class="col-12">
                    <div class="text-center py-5">

                        <h4>No products available.</h4>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn"
                        >
                            Browse Products
                        </a>

                    </div>
                </div>

            @endforelse

        </div>

    </div>

</div>

<!-- Recent Product End -->

@endsection