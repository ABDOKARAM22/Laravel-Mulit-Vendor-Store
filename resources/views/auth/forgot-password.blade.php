@extends('layouts.main')

@section('title', 'Forgot Password')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-2">
                            Forgot Password?
                        </h2>

                        <p class="text-muted mb-0">
                            Enter your email address and we will send
                            you a password reset link.
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('password.email') }}"
                    >
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Email Password Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a
                            href="{{ route('login') }}"
                            class="text-decoration-none"
                        >
                            Back to Login
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection