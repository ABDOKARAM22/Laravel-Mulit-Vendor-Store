@extends('Dashboard.Layouts.main')

@section('page_title', 'Vendors')
@section('breadcrumb', 'Vendors')

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Vendor applications</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.vendors.index') }}" class="form-row mb-4">
                <div class="col-md-5 mb-2">
                    <input name="search" value="{{ request('search') }}" class="form-control"
                           placeholder="Search name or email">
                </div>
                <div class="col-md-4 mb-2">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        @foreach ([App\Models\Admin::STATUS_PENDING, App\Models\Admin::STATUS_ACTIVE, App\Models\Admin::STATUS_REJECTED, App\Models\Admin::STATUS_SUSPENDED] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('dashboard.vendors.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead><tr><th>Vendor</th><th>Store</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse ($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->name }}<div class="small text-muted">{{ $vendor->email }}</div></td>
                            <td>{{ $vendor->store?->name ?? 'Not assigned' }}</td>
                            <td><span class="badge badge-secondary">{{ $vendor->status }}</span></td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('dashboard.vendors.show', $vendor) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">No vendors found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $vendors->links() }}
        </div>
    </div>
@endsection
