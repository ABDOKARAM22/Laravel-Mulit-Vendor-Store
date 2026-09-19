@extends('Dashboard.Layouts.main')

@section('page_title', 'Edit Profile')

@section('breadcrumb', 'Profile')

@section('content')

    <div class="row">

        <!-- Profile Information -->
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-user-edit mr-2"></i>
                        Profile Information

                    </h3>

                </div>


                <form action="{{ route('dashboard.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')


                    <div class="card-body">

                        <x-success_alert />


                        @if ($errors->any())

                            <div class="alert alert-danger">

                                <h6 class="mb-2">
                                    Please correct the following errors:
                                </h6>

                                <ul class="mb-0">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <div class="row">

                            <!-- First Name -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="first_name">
                                        First Name
                                    </label>

                                    <input type="text"
                                           id="first_name"
                                           name="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           value="{{ old('first_name', $user->profile->first_name) }}"
                                           required>

                                    @error('first_name')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- Last Name -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="last_name">
                                        Last Name
                                    </label>

                                    <input type="text"
                                           id="last_name"
                                           name="last_name"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           value="{{ old('last_name', $user->profile->last_name) }}"
                                           required>

                                    @error('last_name')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- Phone Number -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="phone_number">
                                        Phone Number
                                    </label>

                                    <input type="text"
                                           id="phone_number"
                                           name="phone_number"
                                           class="form-control @error('phone_number') is-invalid @enderror"
                                           value="{{ old('phone_number', $user->profile->phone_number) }}">

                                    @error('phone_number')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- Birthday -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="birthday">
                                        Birthday
                                    </label>

                                    <input type="date"
                                           id="birthday"
                                           name="birthday"
                                           class="form-control @error('birthday') is-invalid @enderror"
                                           value="{{ old('birthday', $user->profile->birthday) }}">

                                    @error('birthday')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- Gender -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="gender">
                                        Gender
                                    </label>

                                    <select id="gender"
                                            name="gender"
                                            class="form-control @error('gender') is-invalid @enderror"
                                            required>

                                        <option value="">
                                            Select Gender
                                        </option>

                                        <option value="male"
                                            @selected(old('gender', $user->profile->gender) === 'male')>

                                            Male

                                        </option>

                                        <option value="female"
                                            @selected(old('gender', $user->profile->gender) === 'female')>

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


                            <!-- Language -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="language">
                                        Language
                                    </label>

                                    <select id="language"
                                            name="language"
                                            class="form-control @error('language') is-invalid @enderror"
                                            required>

                                        <option value="">
                                            Select Language
                                        </option>

                                        @foreach ($languages as $lang_code => $language)

                                            <option value="{{ $lang_code }}"
                                                @selected(old('language', $user->profile->language) === $lang_code)>

                                                {{ $language }}

                                            </option>

                                        @endforeach

                                    </select>

                                    @error('language')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- Street Address -->
                            <div class="col-md-12">

                                <div class="form-group">

                                    <label for="street_address">
                                        Street Address
                                    </label>

                                    <input type="text"
                                           id="street_address"
                                           name="street_address"
                                           class="form-control @error('street_address') is-invalid @enderror"
                                           value="{{ old('street_address', $user->profile->street_address) }}"
                                           required>

                                    @error('street_address')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- City -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="city">
                                        City
                                    </label>

                                    <input type="text"
                                           id="city"
                                           name="city"
                                           class="form-control @error('city') is-invalid @enderror"
                                           value="{{ old('city', $user->profile->city) }}"
                                           required>

                                    @error('city')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- Postal Code -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="postal_code">
                                        Postal Code
                                    </label>

                                    <input type="text"
                                           id="postal_code"
                                           name="postal_code"
                                           class="form-control @error('postal_code') is-invalid @enderror"
                                           value="{{ old('postal_code', $user->profile->postal_code) }}"
                                           required>

                                    @error('postal_code')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <!-- Country -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="country">
                                        Country
                                    </label>

                                    <select id="country"
                                            name="country"
                                            class="form-control @error('country') is-invalid @enderror"
                                            required>

                                        <option value="">
                                            Select Country
                                        </option>

                                        @foreach ($countries as $country_code => $country)

                                            <option value="{{ $country_code }}"
                                                @selected(old('country', $user->profile->country) === $country_code)>

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


                            <!-- Profile Image -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="image">
                                        Profile Image
                                    </label>

                                    <div class="custom-file">

                                        <input type="file"
                                               id="image"
                                               name="image"
                                               class="custom-file-input @error('image') is-invalid @enderror"
                                               accept="image/jpeg,image/png,image/gif">

                                        <label class="custom-file-label"
                                               for="image">

                                            Choose image

                                        </label>

                                    </div>

                                    @error('image')

                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or GIF. Maximum size: 2MB.
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="card-footer">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-save mr-1"></i>
                            Save Changes

                        </button>

                    </div>

                </form>

            </div>

        </div>


        <!-- Profile Summary -->
        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-user mr-2"></i>
                        Account

                    </h3>

                </div>


                <div class="card-body text-center">

                    @if ($user->profile->image)

                        <img src="{{ asset('uploads/' . $user->profile->image) }}"
                             alt="Profile Image"
                             class="img-circle elevation-2 mb-3"
                             style="width: 120px; height: 120px; object-fit: cover;">

                    @else

                        <div class="mb-3">

                            <div class="img-circle elevation-2 bg-secondary d-inline-flex align-items-center justify-content-center"
                                 style="width: 120px; height: 120px;">

                                <i class="fas fa-user fa-3x text-white"></i>

                            </div>

                        </div>

                    @endif


                    <h4 class="mb-1">

                        {{ $user->profile->first_name }}
                        {{ $user->profile->last_name }}

                    </h4>


                    <p class="text-muted mb-3">

                        {{ $user->email }}

                    </p>


                    <span class="badge badge-secondary px-3 py-2">

                        {{ $user->role }}

                    </span>

                </div>

            </div>


            <!-- Profile Notes -->
            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-info-circle mr-2"></i>
                        Profile Information

                    </h3>

                </div>


                <div class="card-body">

                    <p class="text-muted mb-0">

                        Keep your profile information up to date.
                        Your account email and authentication information
                        are managed separately.

                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection