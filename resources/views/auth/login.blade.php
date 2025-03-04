@extends('layouts.main')

@section('title', 'Login')

@section('content')

    <!-- Breadcrumb Start -->
    <x-breadcrumb currentpage="Login"/>
    <!-- Breadcrumb End -->

    <!-- Login Start -->
    <div class="login d-flex align-items-center min-vh-80 mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h3 class="text-center mb-3">Welcome Again</h3>
                    <div class="login-form">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email">E-mail</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" 
                                           type="text" placeholder="E-mail" 
                                           name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror" 
                                           type="password" placeholder="Password" 
                                           name="password" required>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                        <label class="custom-control-label" for="remember">Keep me signed in</label>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <button class="btn btn-primary w-100" type="submit">Submit</button>
                                </div>
                                <div class="col-md-6 text-center mt-3">
                                    <a href="{{ route('password.request') }}" class="text-secondary">Forgot your password?</a>
                                </div>
                                <div class="col-md-6 text-center mt-3">
                                    <a href="{{ route('register') }}" class="text-secondary">Don't have an account? Register</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->

@endsection
