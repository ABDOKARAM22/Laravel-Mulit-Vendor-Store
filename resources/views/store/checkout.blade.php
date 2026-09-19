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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-inner">
                        <div class="billing-address">
                            <h2>Billing Address</h2>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[billing][first_name]"
                                        placeholder="First Name"
                                        value="{{ old('addr.billing.first_name') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[billing][last_name]"
                                        placeholder="Last Name"
                                        value="{{ old('addr.billing.last_name') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input
                                        class="form-control"
                                        type="email"
                                        name="addr[billing][email]"
                                        placeholder="E-mail"
                                        value="{{ old('addr.billing.email') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Phone Number</label>
                                    <input
                                        class="form-control"
                                        type="tel"
                                        name="addr[billing][phone_number]"
                                        placeholder="Phone Number"
                                        value="{{ old('addr.billing.phone_number') }}"
                                    >
                                </div>

                                <div class="col-md-12">
                                    <label>Street Address</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[billing][street_address]"
                                        placeholder="Address"
                                        value="{{ old('addr.billing.street_address') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Country</label>
                                    <select class="custom-select" name="addr[billing][country]">
                                        <option value="" disabled {{ old('addr.billing.country') ? '' : 'selected' }}>
                                            Select Country
                                        </option>

                                        @foreach ($countries as $c_code => $country)
                                            <option
                                                value="{{ $c_code }}"
                                                {{ old('addr.billing.country') === $c_code ? 'selected' : '' }}
                                            >
                                                {{ $country }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>City</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[billing][city]"
                                        placeholder="City"
                                        value="{{ old('addr.billing.city') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>State</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[billing][state]"
                                        placeholder="State"
                                        value="{{ old('addr.billing.state') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Postal Code</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[billing][postal_code]"
                                        placeholder="Postal Code"
                                        value="{{ old('addr.billing.postal_code') }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="shipping-address">
                            <h2>Shipping Address</h2>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[shipping][first_name]"
                                        placeholder="First Name"
                                        value="{{ old('addr.shipping.first_name') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[shipping][last_name]"
                                        placeholder="Last Name"
                                        value="{{ old('addr.shipping.last_name') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input
                                        class="form-control"
                                        type="email"
                                        name="addr[shipping][email]"
                                        placeholder="E-mail"
                                        value="{{ old('addr.shipping.email') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input
                                        class="form-control"
                                        type="tel"
                                        name="addr[shipping][phone_number]"
                                        placeholder="Mobile No"
                                        value="{{ old('addr.shipping.phone_number') }}"
                                    >
                                </div>

                                <div class="col-md-12">
                                    <label>Street Address</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[shipping][street_address]"
                                        placeholder="Address"
                                        value="{{ old('addr.shipping.street_address') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Country</label>
                                    <select class="custom-select" name="addr[shipping][country]">
                                        <option value="" disabled {{ old('addr.shipping.country') ? '' : 'selected' }}>
                                            Select Country
                                        </option>

                                        @foreach ($countries as $c_code => $country)
                                            <option
                                                value="{{ $c_code }}"
                                                {{ old('addr.shipping.country') === $c_code ? 'selected' : '' }}
                                            >
                                                {{ $country }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>City</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[shipping][city]"
                                        placeholder="City"
                                        value="{{ old('addr.shipping.city') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>State</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[shipping][state]"
                                        placeholder="State"
                                        value="{{ old('addr.shipping.state') }}"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label>Postal Code</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="addr[shipping][postal_code]"
                                        placeholder="Postal Code"
                                        value="{{ old('addr.shipping.postal_code') }}"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="checkout-inner">
                        <div class="checkout-summary">
                            <h1>Cart Total</h1>

                            <p class="sub-total">
                                Sub Total
                                <span>{{ Currency::format($cart->total()) }}</span>
                            </p>

                            <p class="ship-cost">
                                Shipping Cost
                                <span>{{ Currency::format(0) }}</span>
                            </p>

                            <p>
                                Tax
                                <span>{{ Currency::format(0) }}</span>
                            </p>

                            <h2>
                                Grand Total
                                <span>{{ Currency::format($cart->total()) }}</span>
                            </h2>
                        </div>

                        <div class="checkout-payment">
                            <div class="payment-methods">
                                <h1>Payment Methods</h1>

                                <div class="payment-method">
                                    <div class="custom-control custom-radio">
                                        <input
                                            type="radio"
                                            class="custom-control-input"
                                            id="payment-1"
                                            name="payment"
                                            value="cod"
                                            {{ old('payment') === 'cod' ? 'checked' : 'checked' }}
                                        >

                                        <label class="custom-control-label" for="payment-1">
                                            Cash on Delivery
                                        </label>
                                    </div>

                                    <div class="payment-content" id="payment-1-show">
                                        <p>Pay when your order is delivered.</p>
                                    </div>
                                </div>
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