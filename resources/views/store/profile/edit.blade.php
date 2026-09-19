@extends('layouts.main')

@section('title', 'My Account')

@section('content')

    <x-breadcrumb currentpage="My Account"/>

    <div class="my-account">
        <div class="container-fluid">

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">
                    Profile updated successfully.
                </div>
            @endif

            <div class="row">

                {{-- Account Sidebar --}}
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="nav-link active"
                        >
                            <i class="fa fa-user"></i>
                            Profile
                        </a>

                        <a
                            href="{{ route('orders.index') }}"
                            class="nav-link"
                        >
                            <i class="fa fa-shopping-bag"></i>
                            Orders
                        </a>

                        <a
                            href="{{ route('cart.index') }}"
                            class="nav-link"
                        >
                            <i class="fa fa-shopping-cart"></i>
                            Cart
                        </a>

                        <a
                            href="{{ route('products.index') }}"
                            class="nav-link"
                        >
                            <i class="fa fa-store"></i>
                            Continue Shopping
                        </a>

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                            class="m-0"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="nav-link w-100 text-left border-0"
                            >
                                <i class="fa fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>

                    </div>
                </div>

                {{-- Profile Content --}}
                <div class="col-md-9">
                    <div class="tab-content">

                        {{-- Account Information --}}
                        <div class="mb-5">

                            <h2 class="mb-4">
                                Account Information
                            </h2>

                            <form
                                action="{{ route('profile.update') }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <div class="row">

                                    {{-- Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="name">
                                                Name
                                            </label>

                                            <input
                                                type="text"
                                                id="name"
                                                name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $user->name) }}"
                                                required
                                            >

                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="email">
                                                Email
                                            </label>

                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $user->email) }}"
                                                required
                                            >

                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                </div>

                                <button
                                    type="submit"
                                    class="btn"
                                >
                                    <i class="fa fa-save"></i>
                                    Save Changes
                                </button>

                            </form>

                        </div>


                        {{-- Personal Information --}}
                        <div class="mb-5">

                            <h2 class="mb-4">
                                Personal Information
                            </h2>

                            <form
                                action="{{ route('profile.update') }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <div class="row">

                                    {{-- First Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="first_name">
                                                First Name
                                            </label>

                                            <input
                                                type="text"
                                                id="first_name"
                                                name="first_name"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                value="{{ old('first_name', $profile->first_name) }}"
                                                required
                                            >

                                            @error('first_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Last Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="last_name">
                                                Last Name
                                            </label>

                                            <input
                                                type="text"
                                                id="last_name"
                                                name="last_name"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                value="{{ old('last_name', $profile->last_name) }}"
                                                required
                                            >

                                            @error('last_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="phone_number">
                                                Phone Number
                                            </label>

                                            <input
                                                type="tel"
                                                id="phone_number"
                                                name="phone_number"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                value="{{ old('phone_number', $profile->phone_number) }}"
                                            >

                                            @error('phone_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Birthday --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="birthday">
                                                Birthday
                                            </label>

                                            <input
                                                type="date"
                                                id="birthday"
                                                name="birthday"
                                                class="form-control @error('birthday') is-invalid @enderror"
                                                value="{{ old('birthday', $profile->birthday) }}"
                                            >

                                            @error('birthday')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Gender --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="gender">
                                                Gender
                                            </label>

                                            <select
                                                id="gender"
                                                name="gender"
                                                class="custom-select @error('gender') is-invalid @enderror"
                                                required
                                            >
                                                <option value="">
                                                    Select Gender
                                                </option>

                                                <option
                                                    value="male"
                                                    @selected(old('gender', $profile->gender) === 'male')
                                                >
                                                    Male
                                                </option>

                                                <option
                                                    value="female"
                                                    @selected(old('gender', $profile->gender) === 'female')
                                                >
                                                    Female
                                                </option>
                                            </select>

                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Country --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="country">
                                                Country
                                            </label>

                                            <select
                                                id="country"
                                                name="country"
                                                class="custom-select @error('country') is-invalid @enderror"
                                                required
                                            >
                                                <option value="">
                                                    Select Country
                                                </option>

                                                @foreach ($countries as $code => $country)
                                                    <option
                                                        value="{{ $code }}"
                                                        @selected(old('country', $profile->country) === $code)
                                                    >
                                                        {{ $country }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('country')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- City --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="city">
                                                City
                                            </label>

                                            <input
                                                type="text"
                                                id="city"
                                                name="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                value="{{ old('city', $profile->city) }}"
                                                required
                                            >

                                            @error('city')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Postal Code --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="postal_code">
                                                Postal Code
                                            </label>

                                            <input
                                                type="text"
                                                id="postal_code"
                                                name="postal_code"
                                                class="form-control @error('postal_code') is-invalid @enderror"
                                                value="{{ old('postal_code', $profile->postal_code) }}"
                                                required
                                            >

                                            @error('postal_code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Street Address --}}
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <label for="street_address">
                                                Street Address
                                            </label>

                                            <textarea
                                                id="street_address"
                                                name="street_address"
                                                rows="4"
                                                class="form-control @error('street_address') is-invalid @enderror"
                                                required
                                            >{{ old('street_address', $profile->street_address) }}</textarea>

                                            @error('street_address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                </div>

                                <button
                                    type="submit"
                                    class="btn"
                                >
                                    <i class="fa fa-save"></i>
                                    Save Changes
                                </button>

                            </form>

                        </div>


                        {{-- Change Password --}}
                        <div class="mb-5">

                            <h2 class="mb-4">
                                Change Password
                            </h2>

                            <form
                                action="{{ route('password.update') }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    {{-- Current Password --}}
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <label for="current_password">
                                                Current Password
                                            </label>

                                            <input
                                                type="password"
                                                id="current_password"
                                                name="current_password"
                                                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                                autocomplete="current-password"
                                                required
                                            >

                                            @error('current_password', 'updatePassword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- New Password --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="password">
                                                New Password
                                            </label>

                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                                autocomplete="new-password"
                                                required
                                            >

                                            @error('password', 'updatePassword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="password_confirmation">
                                                Confirm New Password
                                            </label>

                                            <input
                                                type="password"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                class="form-control"
                                                autocomplete="new-password"
                                                required
                                            >

                                        </div>
                                    </div>

                                </div>

                                <button
                                    type="submit"
                                    class="btn"
                                >
                                    <i class="fa fa-key"></i>
                                    Update Password
                                </button>

                            </form>

                        </div>


                        {{-- Delete Account --}}
                        <div>

                            <h2 class="mb-4 text-danger">
                                Delete Account
                            </h2>

                            <p>
                                Once your account is deleted, all of its
                                resources and data will be permanently deleted.
                            </p>

                            <form
                                action="{{ route('profile.destroy') }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <div class="form-group">

                                    <label for="delete_password">
                                        Confirm your password
                                    </label>

                                    <input
                                        type="password"
                                        id="delete_password"
                                        name="password"
                                        class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                        autocomplete="current-password"
                                        required
                                    >

                                    @error('password', 'userDeletion')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                >
                                    <i class="fa fa-trash"></i>
                                    Delete Account
                                </button>

                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection