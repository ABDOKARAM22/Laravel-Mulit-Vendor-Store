@extends('layouts.main')

@section('title', 'Sign Up')

@section('content')

    <!-- Breadcrumb Start -->
    <x-breadcrumb currentpage="Sign Up"/>
    <!-- Breadcrumb End -->

    <!-- Sign Up Start -->
    <div class="signup d-flex align-items-center min-vh-80 mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h3 class="text-center mb-3">Create Your Account</h3>
                    <div class="signup-form">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Full Name</label>
                                    <input id="name" class="form-control @error('name') is-invalid @enderror" 
                                           type="text" placeholder="Full Name" 
                                           name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email Address</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" 
                                           type="email" placeholder="Email Address" 
                                           name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="password">Password</label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror" 
                                           type="password" placeholder="Password" 
                                           name="password" required>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input id="password_confirmation" class="form-control" 
                                           type="password" placeholder="Confirm Password" 
                                           name="password_confirmation" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input @error('terms') is-invalid @enderror" 
                                               id="terms" name="terms" required>
                                        <label class="custom-control-label" for="terms">
                                            I agree to the <a href="#" class="text-secondary">Terms & Conditions</a>
                                        </label>
                                        @error('terms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <p class="text-secondary">
                                        Already have an account? 
                                        <a href="{{ route('login') }}" class="text-secondary">Login</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign Up End -->

@endsection
