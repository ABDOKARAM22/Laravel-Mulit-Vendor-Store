<div class="col-md-3">
    <nav class="navbar bg-light">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('home') }}"
                >
                    <i class="fa fa-home"></i>
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('products.index') }}"
                >
                    <i class="fa fa-shopping-bag"></i>
                    All Products
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('cart.index') }}"
                >
                    <i class="fa fa-shopping-cart"></i>
                    Cart
                </a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('checkout') }}"
                >
                    <i class="fa fa-credit-card"></i>
                    Checkout
                </a>
            </li>

        </ul>
    </nav>
</div>