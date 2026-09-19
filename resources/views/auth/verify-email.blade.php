@extends('layouts.main')

@section('title', 'Verify Email')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5 text-center">

                    <div class="mb-4">
                        <h2 class="fw-bold mb-2">
                            Verify Your Email
                        </h2>

                        <p class="text-muted mb-0">
                            Thanks for signing up.
                            Please verify your email address by clicking
                            the link we sent to your email.
                        </p>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success text-start">
                            A new verification link has been sent
                            to your email address.
                        </div>
                    @endif

                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">

                        <form
                            method="POST"
                            action="{{ route('verification.send') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Resend Verification Email
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-outline-secondary"
                            >
                                Log Out
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection