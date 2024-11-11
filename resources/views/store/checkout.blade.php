@extends('layouts.main')
@section('title','CheckOut')
@section('content')

<!-- Breadcrumb Start -->
<x-breadcrumb currentpage="Orders Checkout"/>
<!-- Breadcrumb End -->

<!-- Checkout Start -->
<div class="checkout">
    <div class="container-fluid"> 
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-inner">
                        <div class="billing-address">
                            <h2>Billing Address</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" name="addr[billing][first_name]" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" name="addr[billing][last_name]" placeholder="Last Name">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" type="email" name="addr[billing][email]" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <label>Phone Number</label>
                                    <input class="form-control" type="tel" name="addr[billing][phone_number]" placeholder="Phone Number">
                                </div>
                                <div class="col-md-12">
                                    <label>Street Address</label>
                                    <input class="form-control" type="text" name="addr[billing][street_address]" placeholder="Address">
                                </div>
                                <div class="col-md-6">
                                    <label>Country</label>
                                    <select class="custom-select" name="addr[billing][country]">
                                        <option value="" selected disabled>Select Country</option>
                                        @foreach ($countries as $c_code => $country )
                                        <option value="{{$c_code}}">{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>City</label>
                                    <input class="form-control" type="text" name="addr[billing][city]" placeholder="City">
                                </div>
                                <div class="col-md-6">
                                    <label>State</label>
                                    <input class="form-control" type="text" name="addr[billing][state]" placeholder="State">
                                </div>
                                <div class="col-md-6">
                                    <label>Postal Code</label>
                                    <input class="form-control" type="text" name="addr[billing][postal_code]" placeholder="Postal Code">
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount" name="create_account">
                                        <label class="custom-control-label" for="newaccount">Create an account</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="shipto" name="ship_to_different_address">
                                        <label class="custom-control-label" for="shipto">Ship to different address</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="shipping-address">
                            <h2>Shipping Address</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" name="addr[shipping][first_name]" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" name="addr[shipping][last_name]" placeholder="Last Name">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" type="email" name="addr[shipping][email]" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="tel" name="addr[shipping][phone_number]" placeholder="Mobile No">
                                </div>
                                <div class="col-md-12">
                                    <label>Street Address</label>
                                    <input class="form-control" type="text" name="addr[shipping][street_address]" placeholder="Address">
                                </div>
                                <div class="col-md-6">
                                    <label>Country</label>
                                    <select class="custom-select" name="addr[shipping][country]">
                                        <option value="" disabled>Select Country</option>
                                        @foreach ($countries as $c_code => $country )
                                        <option value="{{$c_code}}">{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>City</label>
                                    <input class="form-control" type="text" name="addr[shipping][city]" placeholder="City">
                                </div>
                                <div class="col-md-6">
                                    <label>State</label>
                                    <input class="form-control" type="text" name="addr[shipping][state]" placeholder="State">
                                </div>
                                <div class="col-md-6">
                                    <label>Postal Code</label>
                                    <input class="form-control" type="text" name="addr[shipping][postal_code]" placeholder="Postal Code">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-inner">
                        <div class="checkout-summary">
                            <h1>Cart Total</h1>
                            <p class="sub-total">Sub Total<span>{{ Currency::format($cart->total()) }}</span></p>
                            <p class="ship-cost">Shipping Cost<span>$1</span></p>
                            <p>Tax<span>$99</span></p>
                            <h2>Grand Total<span>$100</span></h2>
                        </div>

                        <div class="checkout-payment">
                            <div class="payment-methods">
                                <h1>Payment Methods</h1>
                                @foreach(['Paypal', 'Payoneer', 'Check Payment', 'Direct Bank Transfer', 'Cash on Delivery'] as $index => $method)
                                    <div class="payment-method">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="payment-{{ $index + 1 }}" name="payment" value="{{ $method }}">
                                            <label class="custom-control-label" for="payment-{{ $index + 1 }}">{{ $method }}</label>
                                        </div>
                                        <div class="payment-content" id="payment-{{ $index + 1 }}-show">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="checkout-btn">
                                <button type="submit">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Checkout End -->

@endsection