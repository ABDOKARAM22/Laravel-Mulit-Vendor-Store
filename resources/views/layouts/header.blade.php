<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>@yield('title')</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta content="Multi-Vendor Store" name="keywords">
    <meta content="Multi-Vendor E-Commerce Store" name="description">

    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet"
    >

    <link href="{{ asset('lib/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/slick/slick-theme.css') }}" rel="stylesheet">

    @stack('style')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-6">
                    <i class="fa fa-envelope"></i>
                    Customer Support
                </div>

                <div class="col-sm-6">
                    <i class="fa fa-shopping-bag"></i>
                    Multi-Vendor Store
                </div>

            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav">
        <div class="container-fluid">

            <nav class="navbar navbar-expand-md bg-dark navbar-dark">

                <a href="{{ route('home') }}" class="navbar-brand">
                    STORE
                </a>

                <button
                    type="button"
                    class="navbar-toggler"
                    data-toggle="collapse"
                    data-target="#navbarCollapse"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div
                    class="collapse navbar-collapse justify-content-between"
                    id="navbarCollapse"
                >

                    <div class="navbar-nav mr-auto">

                        <a
                            href="{{ route('home') }}"
                            class="nav-item nav-link"
                        >
                            Home
                        </a>

                        <a
                            href="{{ route('products.index') }}"
                            class="nav-item nav-link"
                        >
                            Products
                        </a>

                        <a
                            href="{{ route('cart.index') }}"
                            class="nav-item nav-link"
                        >
                            Cart
                        </a>

                        <a
                            href="{{ route('checkout') }}"
                            class="nav-item nav-link"
                        >
                            Checkout
                        </a>

                        @auth('web')
                            <a
                                href="{{ route('orders.index') }}"
                                class="nav-item nav-link"
                            >
                                Orders
                            </a>

                            <a
                                href="{{ route('profile.edit') }}"
                                class="nav-item nav-link"
                            >
                                My Account
                            </a>
                        @endauth

                    </div>

                    <!-- User Account -->
                    <div class="navbar-nav ml-auto">

                        <div class="nav-item dropdown">

                            @auth('web')

                                <a
                                    href="#"
                                    class="nav-link dropdown-toggle"
                                    data-toggle="dropdown"
                                >
                                    {{ auth('web')->user()->name }}
                                </a>

                                <div class="dropdown-menu">

                                    <a
                                        href="{{ route('profile.edit') }}"
                                        class="dropdown-item"
                                    >
                                        Profile
                                    </a>

                                    <form
                                        action="{{ route('logout') }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="dropdown-item"
                                        >
                                            Logout
                                        </button>
                                    </form>

                                </div>

                            @else

                                <a
                                    href="#"
                                    class="nav-link dropdown-toggle"
                                    data-toggle="dropdown"
                                >
                                    User Account
                                </a>

                                <div class="dropdown-menu">

                                    <a
                                        href="{{ route('login') }}"
                                        class="dropdown-item"
                                    >
                                        Login
                                    </a>

                                    <a
                                        href="{{ route('register') }}"
                                        class="dropdown-item"
                                    >
                                        Register
                                    </a>

                                </div>

                            @endauth

                        </div>

                    </div>

                </div>

            </nav>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar">
        <div class="container-fluid">

            <div class="row align-items-center">

                <!-- Logo -->
                <div class="col-md-3">

                    <div class="logo">

                        <a href="{{ route('home') }}">

                            <img
                                src="{{ asset('img/logo.png') }}"
                                alt="Store Logo"
                            >

                        </a>

                    </div>

                </div>

                <!-- Store Message -->
                <div class="col-md-6">

                    <div class="text-center">
                        <h5 class="mb-0">
                            Discover Our Products
                        </h5>
                    </div>

                </div>

                <!-- Cart -->
                <div class="col-md-3">

                    <div class="user">

                        <a
                            href="{{ route('cart.index') }}"
                            class="btn cart"
                        >

                            <i class="fa fa-shopping-cart"></i>

                            <span>
                                ({{ $cartCount }})
                            </span>

                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>

</body>
</html>