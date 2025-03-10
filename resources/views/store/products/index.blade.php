@extends('layouts.main')
@section('title','Products List')
@section('content')



    <!-- Breadcrumb Start -->
    <x-breadcrumb currentpage="Products List"/>
    <!-- Breadcrumb End -->
        
    <!-- Product List Start -->
    <div class="product-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product-view-top">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="product-search">
                                            <input type="text" placeholder="Search">
                                            <button><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-short">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Product short by</div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">Newest</a>
                                                    <a href="#" class="dropdown-item">Popular</a>
                                                    <a href="#" class="dropdown-item">Most sale</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-price-range">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Product price range</div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">$0 to $50</a>
                                                    <a href="#" class="dropdown-item">$51 to $100</a>
                                                    <!-- More price options -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @foreach ($products as $product)
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-title">
                                    <a href="#">{{ $product->name }}</a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <!-- More stars -->
                                    </div>
                                </div>
                                <div class="product-image">
                                    <a href="product-detail.html">
                                        <img src="{{ $product->image }}" alt="Product Image">
                                    </a>
                                    <div class="product-action">
                                        <a href="#"><i class="fa fa-cart-plus"></i></a>
                                        <a href="#"><i class="fa fa-heart"></i></a>
                                        <a href="{{ route('products.show', $product->slug) }}"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>

                                <form action="{{ route('cart.store') }}" method="POST">
                                    <div class="product-price">
                                        <h3>{{ Currency::format($product->price) }}
                                            @if (isset($product->compare_price))
                                                <span>{{ Currency::format($product->compare_price) }}</span>
                                            @endif
                                        </h3>
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn"><i class="fa fa-shopping-cart"></i> Buy Now</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- Pagination Start -->
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Pagination End -->
                    </div>           
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4 sidebar">
                    <div class="sidebar-widget category">
                        <h2 class="title">Category</h2>
                        <nav class="navbar bg-light">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fa fa-female"></i>Fashion & Beauty</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fa fa-child"></i>Kids & Babies Clothes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fa fa-tshirt"></i>Men & Women Clothes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fa fa-mobile-alt"></i>Gadgets & Accessories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fa fa-microchip"></i>Electronics & Accessories</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    
                    <div class="sidebar-widget widget-slider">
                        <div class="sidebar-slider normal-slider">
                            <div class="product-item">
                                <div class="product-title">
                                    <a href="#">Product Name</a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <div class="product-image">
                                    <a href="product-detail.html">
                                        <img src="img/product-10.jpg" alt="Product Image">
                                    </a>
                                    <div class="product-action">
                                        <a href="#"><i class="fa fa-cart-plus"></i></a>
                                        <a href="#"><i class="fa fa-heart"></i></a>
                                        <a href="#"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="product-price">
                                    <h3><span>$</span>99</h3>
                                    <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                                </div>
                            </div>
                            <div class="product-item">
                                <div class="product-title">
                                    <a href="#">Product Name</a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <div class="product-image">
                                    <a href="product-detail.html">
                                        <img src="img/product-9.jpg" alt="Product Image">
                                    </a>
                                    <div class="product-action">
                                        <a href="#"><i class="fa fa-cart-plus"></i></a>
                                        <a href="#"><i class="fa fa-heart"></i></a>
                                        <a href="#"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="product-price">
                                    <h3><span>$</span>99</h3>
                                    <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                                </div>
                            </div>
                            <div class="product-item">
                                <div class="product-title">
                                    <a href="#">Product Name</a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <div class="product-image">
                                    <a href="product-detail.html">
                                        <img src="img/product-8.jpg" alt="Product Image">
                                    </a>
                                    <div class="product-action">
                                        <a href="#"><i class="fa fa-cart-plus"></i></a>
                                        <a href="#"><i class="fa fa-heart"></i></a>
                                        <a href="#"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="product-price">
                                    <h3><span>$</span>99</h3>
                                    <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                                </div>
                            </div>
     
                        </div>
                    </div>
                    
                    <div class="sidebar-widget brands">
                        <h2 class="title">Our Brands</h2>
                        <ul>
                            <li><a href="#">Nulla </a><span>(45)</span></li>
                            <li><a href="#">Curabitur </a><span>(34)</span></li>
                            <li><a href="#">Nunc </a><span>(67)</span></li>
                            <li><a href="#">Ullamcorper</a><span>(74)</span></li>
                            <li><a href="#">Fusce </a><span>(89)</span></li>
                            <li><a href="#">Sagittis</a><span>(28)</span></li>
                        </ul>
                    </div>
                    
                    <div class="sidebar-widget tag">
                        <h2 class="title">Tags Cloud</h2>
                        <a href="#">Lorem ipsum</a>
                        <a href="#">Vivamus</a>
                        <a href="#">Phasellus</a>
                        <a href="#">pulvinar</a>
                        <a href="#">Curabitur</a>
                        <a href="#">Fusce</a>
                        <a href="#">Sem quis</a>
                        <a href="#">Mollis metus</a>
                        <a href="#">Sit amet</a>
                        <a href="#">Vel posuere</a>
                        <a href="#">orci luctus</a>
                        <a href="#">Nam lorem</a>
                    </div>
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Product List End -->  
    
    <!-- Brand Start -->
    <div class="brand">
        <div class="container-fluid">
            <div class="brand-slider">
                <div class="brand-item"><img src="img/brand-1.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-2.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-3.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-4.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-5.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-6.png" alt=""></div>
            </div>
        </div>
    </div>
    <!-- Brand End -->
    
@endsection
