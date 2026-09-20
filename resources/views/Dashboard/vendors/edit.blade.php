@extends('Dashboard.Layouts.main')

@section('page_title', 'Edit Vendor')
@section('breadcrumb', 'Edit Vendor')

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Edit vendor details</h3></div>
        <form method="POST" action="{{ route('dashboard.vendors.update', $vendor) }}">
            @csrf @method('PUT')
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" value="{{ old('name', $vendor->name) }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $vendor->email) }}" class="form-control" required>
                </div>
            </div>
            <div class="card-footer"><button class="btn btn-primary">Save changes</button></div>
        </form>
    </div>
@endsection
