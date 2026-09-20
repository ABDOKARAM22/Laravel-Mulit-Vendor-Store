@extends('Dashboard.Layouts.main')

@section('page_title', 'Vendor Details')
@section('breadcrumb', 'Vendor Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">{{ $vendor->name }}</h3>
            <a href="{{ route('dashboard.vendors.edit', $vendor) }}" class="btn btn-sm btn-primary">Edit</a>
        </div>
        <div class="card-body">
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <dl class="row">
                <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $vendor->email }}</dd>
                <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ $vendor->status }}</dd>
                <dt class="col-sm-3">Store</dt><dd class="col-sm-9">{{ $vendor->store?->name ?? 'Not assigned' }}</dd>
                <dt class="col-sm-3">Store status</dt><dd class="col-sm-9">{{ $vendor->store?->status ?? '—' }}</dd>
                <dt class="col-sm-3">Store description</dt><dd class="col-sm-9">{{ $vendor->store?->description ?? '—' }}</dd>
            </dl>

            @if ($vendor->status === App\Models\Admin::STATUS_PENDING)
                <div class="d-flex">
                    <form method="POST" action="{{ route('dashboard.vendors.status', $vendor) }}" class="mr-2">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="{{ App\Models\Admin::STATUS_ACTIVE }}">
                        <button class="btn btn-success">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('dashboard.vendors.status', $vendor) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="{{ App\Models\Admin::STATUS_REJECTED }}">
                        <button class="btn btn-danger">Reject</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
