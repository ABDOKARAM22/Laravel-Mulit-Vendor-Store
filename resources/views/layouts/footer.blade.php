<!-- Footer Start -->
<div class="footer">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Abdo Store</h2>
                    <p>
                        Discover our products and enjoy a simple shopping experience.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Store</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}">Cart</a>
                        </li>
                        <li>
                            <a href="{{ route('checkout') }}">Checkout</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Account</h2>
                    <ul>
                        @auth('web')
                            <li>
                                <a href="{{ route('profile.edit') }}">My Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('orders.index') }}">My Orders</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Payment</h2>
                    <p>
                        We currently accept Cash on Delivery.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Footer Bottom Start -->
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12 copyright text-center">
                <p>
                    Copyright &copy; {{ date('Y') }}
                    <a href="{{ route('home') }}">Abdo Store</a>.
                    All Rights Reserved
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Footer Bottom End -->

<!-- Back to Top -->
<a href="#" class="back-to-top">
    <i class="fa fa-chevron-up"></i>
</a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/slick/slick.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('js/main.js') }}"></script>

@stack('scripts')

</body>
</html>