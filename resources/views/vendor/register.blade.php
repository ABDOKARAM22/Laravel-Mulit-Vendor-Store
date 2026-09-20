@extends('layouts.main')

@section('title', 'Become a Vendor')

@section('content')
    <x-breadcrumb currentpage="Vendor Registration"/>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="mb-4">Become a Vendor</h2>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('vendor.register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" name="name" value="{{ old('name') }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password"
                                   class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirm password</label>
                            <input id="password_confirmation" type="password"
                                   name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="store_name">Store name</label>
                        <input id="store_name" name="store_name" value="{{ old('store_name') }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="store_description">Store description</label>
                        <textarea id="store_description" name="store_description"
                                  class="form-control" rows="4">{{ old('store_description') }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit application</button>
                </form>
            </div>
        </div>
    </div>
@endsection
