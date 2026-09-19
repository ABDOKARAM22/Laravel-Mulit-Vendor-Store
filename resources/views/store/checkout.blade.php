@extends('layouts.main')

@section('title','CheckOut')

@section('content')

<!-- Breadcrumb Start -->
<x-breadcrumb currentpage="Orders Checkout"/>
<!-- Breadcrumb End -->

<!-- Checkout Start -->
<div class="checkout">
    <div class="container-fluid">
        <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
            @csrf


            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">

                <div class="col-lg-8">
                    <div class="checkout-inner">

                        <!-- Billing Address -->
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
                                    @error('addr.billing.first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                    @error('addr.billing.last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                    @error('addr.billing.email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                    @error('addr.billing.phone_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                    @error('addr.billing.street_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Country</label>

                                    <select
                                        class="custom-select"
                                        name="addr[billing][country]"
                                    >
                                        <option value="" selected disabled>
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

                                    @error('addr.billing.country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                    @error('addr.billing.city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                    @error('addr.billing.state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                    @error('addr.billing.postal_code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <!-- Different Shipping Address -->
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="shipto"
                                            name="ship_to_different_address"
                                            value="1"
                                            {{ old('ship_to_different_address') ? 'checked' : '' }}
                                        >

                                        <label
                                            class="custom-control-label"
                                            for="shipto"
                                        >
                                            Ship to different address
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Billing Address End -->


                        <!-- Shipping Address -->
                        <div
                            class="shipping-address"
                            id="shipping-address"
                            style="{{ old('ship_to_different_address') ? '' : 'display: none;' }}"
                        >

                            <h2>Shipping Address</h2>

                            <div class="row">

                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="text"
                                        name="addr[shipping][first_name]"
                                        placeholder="First Name"
                                        value="{{ old('addr.shipping.first_name') }}"
                                    >
                                    @error('addr.shipping.first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="text"
                                        name="addr[shipping][last_name]"
                                        placeholder="Last Name"
                                        value="{{ old('addr.shipping.last_name') }}"
                                    >
                                    @error('addr.shipping.last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="email"
                                        name="addr[shipping][email]"
                                        placeholder="E-mail"
                                        value="{{ old('addr.shipping.email') }}"
                                    >
                                    @error('addr.shipping.email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="tel"
                                        name="addr[shipping][phone_number]"
                                        placeholder="Mobile No"
                                        value="{{ old('addr.shipping.phone_number') }}"
                                    >
                                    @error('addr.shipping.phone_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label>Street Address</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="text"
                                        name="addr[shipping][street_address]"
                                        placeholder="Address"
                                        value="{{ old('addr.shipping.street_address') }}"
                                    >
                                    @error('addr.shipping.street_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Country</label>

                                    <select
                                        class="custom-select shipping-field"
                                        name="addr[shipping][country]"
                                    >
                                        <option value="" disabled>
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

                                    @error('addr.shipping.country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>City</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="text"
                                        name="addr[shipping][city]"
                                        placeholder="City"
                                        value="{{ old('addr.shipping.city') }}"
                                    >
                                    @error('addr.shipping.city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>State</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="text"
                                        name="addr[shipping][state]"
                                        placeholder="State"
                                        value="{{ old('addr.shipping.state') }}"
                                    >
                                    @error('addr.shipping.state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Postal Code</label>
                                    <input
                                        class="form-control shipping-field"
                                        type="text"
                                        name="addr[shipping][postal_code]"
                                        placeholder="Postal Code"
                                        value="{{ old('addr.shipping.postal_code') }}"
                                    >
                                    @error('addr.shipping.postal_code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <!-- Shipping Address End -->

                    </div>
                </div>


                <!-- Order Summary -->
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


                        <!-- Payment -->
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
                                            checked
                                        >
                                        <label class="custom-control-label" for="payment-1">
                                            Cash on Delivery
                                        </label>

                                    </div>

                                    <div
                                        class="payment-content"
                                        id="payment-1-show"
                                    >
                                        <p>
                                            Pay when your order is delivered.
                                        </p>
                                    </div>

                                </div>
                            </div>

                            @error('payment')
                                <small class="text-danger d-block mb-2">
                                    {{ $message }}
                                </small>
                            @enderror

                            <div class="checkout-btn">
                                <button type="submit">
                                    Place Order
                                </button>
                            </div>

                        </div>
                        <!-- Payment End -->

                    </div>
                </div>
                <!-- Order Summary End -->

            </div>
        </form>
    </div>
</div>
<!-- Checkout End -->


<script>
document.addEventListener('DOMContentLoaded', function () {

    const shipToCheckbox = document.getElementById('shipto');
    const shippingAddress = document.getElementById('shipping-address');

    const billingFields = {
        first_name: document.querySelector('[name="addr[billing][first_name]"]'),
        last_name: document.querySelector('[name="addr[billing][last_name]"]'),
        email: document.querySelector('[name="addr[billing][email]"]'),
        phone_number: document.querySelector('[name="addr[billing][phone_number]"]'),
        street_address: document.querySelector('[name="addr[billing][street_address]"]'),
        country: document.querySelector('[name="addr[billing][country]"]'),
        city: document.querySelector('[name="addr[billing][city]"]'),
        state: document.querySelector('[name="addr[billing][state]"]'),
        postal_code: document.querySelector('[name="addr[billing][postal_code]"]')
    };

    const shippingFields = {
        first_name: document.querySelector('[name="addr[shipping][first_name]"]'),
        last_name: document.querySelector('[name="addr[shipping][last_name]"]'),
        email: document.querySelector('[name="addr[shipping][email]"]'),
        phone_number: document.querySelector('[name="addr[shipping][phone_number]"]'),
        street_address: document.querySelector('[name="addr[shipping][street_address]"]'),
        country: document.querySelector('[name="addr[shipping][country]"]'),
        city: document.querySelector('[name="addr[shipping][city]"]'),
        state: document.querySelector('[name="addr[shipping][state]"]'),
        postal_code: document.querySelector('[name="addr[shipping][postal_code]"]')
    };

    function copyBillingToShipping() {
        Object.keys(billingFields).forEach(function (field) {
            shippingFields[field].value = billingFields[field].value;
        });
    }

    function toggleShippingAddress() {
    if (shipToCheckbox.checked) {
    shippingAddress.style.display = 'block';
    } else {
        copyBillingToShipping();
        shippingAddress.style.display = 'none';
    }
    }

    

    shipToCheckbox.addEventListener('change', toggleShippingAddress);

    Object.keys(billingFields).forEach(function (field) {
        billingFields[field].addEventListener('input', function () {
            if (!shipToCheckbox.checked) {
                copyBillingToShipping();
            }
        });

        billingFields[field].addEventListener('change', function () {
            if (!shipToCheckbox.checked) {
                copyBillingToShipping();
            }
        });
    });

    toggleShippingAddress();
});
</script>

@endsection