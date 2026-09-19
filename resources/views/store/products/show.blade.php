@extends('layouts.main')

@section('title', 'Product Details')

@section('content')

<!-- Breadcrumb Start -->
<x-breadcrumb currentpage="Product Detail"/>
<!-- Breadcrumb End -->


<!-- Product Detail Start -->
<div class="product-detail">

    <div class="container-fluid">

        <div class="row">

            <!-- Product Details Start -->
            <div class="col-lg-8">

                <div class="product-detail-top">

                    <div class="row align-items-center">

                        <!-- Product Image -->
                        <div class="col-md-5">

                            <div class="product-slider-single normal-slider">

                                <img
                                    src="{{ Handel_image::show_image($product->image) }}"
                                    alt="{{ $product->name }}"
                                >

                            </div>

                        </div>
                        <!-- Product Image End -->


                        <!-- Product Information -->
                        <div class="col-md-7">

                            <div class="product-content">

                                <!-- Product Name -->
                                <div class="title">
                                    <h2>{{ $product->name }}</h2>
                                </div>


                                <!-- Price -->
                                <div class="price">

                                    <h4>Price:</h4>

                                    <p>

                                        {{ Currency::format($product->price) }}

                                        @if ($product->compare_price)

                                            <span>
                                                {{ Currency::format($product->compare_price) }}
                                            </span>

                                        @endif

                                    </p>

                                </div>


                                <!-- Category -->
                                @if ($product->category)

                                    <div class="mb-3">

                                        <h4>Category:</h4>

                                        <a
                                            href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                                        >
                                            {{ $product->category->name }}
                                        </a>

                                    </div>

                                @endif


                                <!-- Tags -->
                                @if ($product->tags->isNotEmpty())

                                    <div class="mb-3">

                                        <h4>Tags:</h4>

                                        <div>

                                            @foreach ($product->tags as $tag)

                                                <a
                                                    href="{{ route('products.index', ['tag' => $tag->slug]) }}"
                                                    class="mr-2"
                                                >
                                                    #{{ $tag->name }}
                                                </a>

                                            @endforeach

                                        </div>

                                    </div>

                                @endif


                                <!-- Add To Cart -->
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


                                    <!-- Quantity -->
                                    <div class="quantity">

                                        <h4>Quantity:</h4>

                                        <div class="qty">

                                            <button
                                                type="button"
                                                class="btn-minus"
                                            >
                                                <i class="fa fa-minus"></i>
                                            </button>

                                            <input
                                                type="number"
                                                name="quantity"
                                                value="1"
                                                min="1"
                                                required
                                            >

                                            <button
                                                type="button"
                                                class="btn-plus"
                                            >
                                                <i class="fa fa-plus"></i>
                                            </button>

                                        </div>

                                    </div>


                                    <!-- Add To Cart Button -->
                                    <div class="action">

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

                    </div>

                </div>


                <!-- Product Description -->
                <div class="row product-detail-bottom">

                    <div class="col-lg-12">

                        <div class="product-description">

                            <h4>Product Description</h4>

                            @if ($product->description)

                                <p>
                                    {{ $product->description }}
                                </p>

                            @else

                                <p>
                                    No description available for this product.
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>
            <!-- Product Details End -->


            <!-- Sidebar Start -->
            <div class="col-lg-4 sidebar">


                <!-- Categories -->
                <div class="sidebar-widget category">

                    <h2 class="title">Categories</h2>

                    <nav class="navbar bg-light">

                        <ul class="navbar-nav">

                            @forelse ($categories as $category)

                                <li class="nav-item">

                                    <a
                                        class="nav-link {{ $product->category_id == $category->id ? 'font-weight-bold' : '' }}"
                                        href="{{ route('products.index', ['category' => $category->slug]) }}"
                                    >
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


                <!-- Tags -->
                @if ($product->tags->isNotEmpty())

                    <div class="sidebar-widget tag">

                        <h2 class="title">Tags</h2>

                        @foreach ($product->tags as $tag)

                            <a
                                href="{{ route('products.index', ['tag' => $tag->slug]) }}"
                            >
                                {{ $tag->name }}
                            </a>

                        @endforeach

                    </div>

                @endif

            </div>
            <!-- Sidebar End -->

        </div>

    </div>

</div>
<!-- Product Detail End -->


<!-- Related Products Start -->
@if ($relatedProducts->isNotEmpty())

    <div class="product">

        <div class="container-fluid">

            <div class="section-header">

                <h1>Related Products</h1>

            </div>


            <div class="row align-items-center product-slider product-slider-4">

                @foreach ($relatedProducts as $relatedProduct)

                    <div class="col-lg-3">

                        <div class="product-item">


                            <!-- Product Title -->
                            <div class="product-title">

                                <a
                                    href="{{ route('products.show', $relatedProduct->slug) }}"
                                >
                                    {{ $relatedProduct->name }}
                                </a>

                            </div>


                            <!-- Product Image -->
                            <div class="product-image">

                                <a
                                    href="{{ route('products.show', $relatedProduct->slug) }}"
                                >

                                    <img
                                        src="{{ Handel_image::show_image($relatedProduct->image) }}"
                                        alt="{{ $relatedProduct->name }}"
                                    >

                                </a>


                                <div class="product-action">

                                    <a
                                        href="{{ route('products.show', $relatedProduct->slug) }}"
                                        title="View Product"
                                    >
                                        <i class="fa fa-search"></i>
                                    </a>

                                </div>

                            </div>


                            <!-- Product Price -->
                            <div class="product-price">

                                <h3>

                                    {{ Currency::format($relatedProduct->price) }}

                                    @if ($relatedProduct->compare_price)

                                        <span>
                                            {{ Currency::format($relatedProduct->compare_price) }}
                                        </span>

                                    @endif

                                </h3>


                                <form
                                    action="{{ route('cart.store') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="{{ $relatedProduct->id }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="quantity"
                                        value="1"
                                    >

                                    <button
                                        type="submit"
                                        class="btn"
                                    >
                                        <i class="fa fa-shopping-cart"></i>
                                        Add to Cart
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

@endif
<!-- Related Products End -->


@endsection