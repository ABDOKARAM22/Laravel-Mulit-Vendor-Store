@extends('layouts.main')
@section('title','Abdo Store')
@section('content')

        <!-- Breadcrumb Start -->
        <x-breadcrumb currentpage="Cart"/>
        <!-- Breadcrumb End -->
        
        <!-- Cart Start -->
        <div class="cart-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-page-inner">
                            <div class="table-responsive">

                        <x-success_alert/>
                        
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                        @foreach ( $cart->get() as $item )
                                        <tr>
                                            <td>
                                                <div class="img">
                                                    <a href="{{ route('products.show',$item->product->slug) }}"><img src="{{Handel_image::show_image($item->product->image)}}" alt="Image"></a>
                                                    <p>{{ $item->product->name }} </p>
                                                </div>
                                            </td>
                                            <td>{{ Currency::format($item->product->price) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('cart.update', $item->id) }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="quantity" class="quantity" value="{{ $item->quantity }}">
                                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                    <div class="qty">
                                                        <button type="submit" name="action" value="minus" class="btn-minus"><i class="fa fa-minus"></i></button>
                                                        <input type="text" class="quantity" value="{{ $item->quantity }}" readonly>
                                                        <button type="submit" name="action" value="plus" class="btn-plus"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </form>
                                            </td>
                                            
                                             
                                            <td>{{ Currency::format($item->product->price * $item->quantity) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn-remove"><i class="fa fa-trash"></i></button>
                                                </form>                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-page-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="coupon">
                                        <input type="text" placeholder="Coupon Code">
                                        <button>Apply Code</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="cart-summary">
                                        <div class="cart-content">
                                            <h1>Cart Summary</h1>
                                            <p>Sub Total<span>$99</span></p>
                                            <p>Shipping Cost<span>$1</span></p>
                                            <h2>Grand Total<span>{{ Currency::format($cart->total()) }}</span></h2>
                                        </div>
                                        <div class="cart-btn">
                                            <button>Update Cart</button>
                                            <button>Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart End -->
        

@endsection