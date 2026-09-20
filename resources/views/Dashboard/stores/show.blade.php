@extends('Dashboard.Layouts.main')

@section('page_title', 'Store Details')

@section('breadcrumb', 'Store Details')

@section('content')

    <div class="row">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <h3 class="card-title mb-2 mb-md-0">

                            <i class="fas fa-store mr-2"></i>
                            {{ $store->name }}

                        </h3>


                        @can('update', $store)

                            <a href="{{ route('dashboard.stores.edit', $store) }}"
                               class="btn btn-primary btn-sm">

                                <i class="fas fa-edit mr-1"></i>
                                Edit Store

                            </a>

                        @endcan

                    </div>

                </div>


                @if ($store->cover_image)

                    <div>

                        <img src="{{ asset('uploads/' . $store->cover_image) }}"
                             alt="{{ $store->name }} cover"
                             class="img-fluid w-100"
                             style="max-height: 300px; object-fit: cover;">

                    </div>

                @endif


                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 text-center mb-4 mb-md-0">

                            @if ($store->logo_image)

                                <img src="{{ asset('uploads/' . $store->logo_image) }}"
                                     alt="{{ $store->name }} logo"
                                     class="img-thumbnail rounded-circle"
                                     style="width: 160px; height: 160px; object-fit: cover;">

                            @else

                                <div class="text-muted py-5">

                                    <i class="fas fa-store fa-4x"></i>

                                    <div class="mt-2">
                                        No logo
                                    </div>

                                </div>

                            @endif

                        </div>


                        <div class="col-md-8">

                            <dl class="row">

                                <dt class="col-sm-4">
                                    Name
                                </dt>

                                <dd class="col-sm-8">
                                    {{ $store->name }}
                                </dd>


                                <dt class="col-sm-4">
                                    Slug
                                </dt>

                                <dd class="col-sm-8">
                                    {{ $store->slug }}
                                </dd>


                                <dt class="col-sm-4">
                                    Status
                                </dt>

                                <dd class="col-sm-8">

                                    @switch($store->status)

                                        @case(App\Models\Store::STATUS_ACTIVE)

                                            <span class="badge badge-success">
                                                Active
                                            </span>

                                            @break

                                        @case(App\Models\Store::STATUS_PENDING)

                                            <span class="badge badge-warning">
                                                Pending
                                            </span>

                                            @break

                                        @case(App\Models\Store::STATUS_INACTIVE)

                                            <span class="badge badge-secondary">
                                                Inactive
                                            </span>

                                            @break

                                        @case(App\Models\Store::STATUS_REJECTED)

                                            <span class="badge badge-danger">
                                                Rejected
                                            </span>

                                            @break

                                        @default

                                            <span class="badge badge-light">
                                                {{ $store->status }}
                                            </span>

                                    @endswitch

                                </dd>


                                <dt class="col-sm-4">
                                    Products
                                </dt>

                                <dd class="col-sm-8">

                                    <span class="badge badge-info">
                                        {{ $store->products_count }}
                                    </span>

                                </dd>


                                <dt class="col-sm-4">
                                    Created At
                                </dt>

                                <dd class="col-sm-8">

                                    {{ $store->created_at?->format('Y-m-d H:i') ?? '—' }}

                                </dd>

                            </dl>

                        </div>

                    </div>


                    <hr>


                    <h5>
                        Description
                    </h5>


                    @if ($store->description)

                        <p class="mb-0">
                            {{ $store->description }}
                        </p>

                    @else

                        <p class="text-muted mb-0">
                            No description provided.
                        </p>

                    @endif

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-user-tie mr-2"></i>
                        Vendor

                    </h3>

                </div>


                <div class="card-body">

                    @if ($store->vendor)

                        <h5>
                            {{ $store->vendor->name }}
                        </h5>

                        <p class="text-muted mb-2">
                            {{ $store->vendor->email }}
                        </p>

                        <span class="badge badge-primary">
                            {{ $store->vendor->role }}
                        </span>

                        <span class="badge badge-success">
                            {{ $store->vendor->status }}
                        </span>

                    @else

                        <p class="text-muted mb-0">
                            No vendor is assigned to this store yet.
                        </p>

                    @endif

                </div>

            </div>


            @can('updateStatus', $store)

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title">

                            <i class="fas fa-toggle-on mr-2"></i>
                            Store Status

                        </h3>

                    </div>


                    <div class="card-body">

                        <form action="{{ route('dashboard.stores.status', $store) }}"
                              method="POST">

                            @csrf

                            @method('PATCH')


                            <div class="form-group">

                                <label for="status">
                                    Status
                                </label>

                                <select name="status"
                                        id="status"
                                        class="form-control">

                                    <option value="{{ App\Models\Store::STATUS_PENDING }}"
                                        @selected($store->status === App\Models\Store::STATUS_PENDING)>

                                        Pending

                                    </option>

                                    <option value="{{ App\Models\Store::STATUS_ACTIVE }}"
                                        @selected($store->status === App\Models\Store::STATUS_ACTIVE)>

                                        Active

                                    </option>

                                    <option value="{{ App\Models\Store::STATUS_INACTIVE }}"
                                        @selected($store->status === App\Models\Store::STATUS_INACTIVE)>

                                        Inactive

                                    </option>

                                    <option value="{{ App\Models\Store::STATUS_REJECTED }}"
                                        @selected($store->status === App\Models\Store::STATUS_REJECTED)>

                                        Rejected

                                    </option>

                                </select>

                            </div>


                            <button type="submit"
                                    class="btn btn-primary btn-block">

                                <i class="fas fa-save mr-1"></i>
                                Update Status

                            </button>

                        </form>

                    </div>

                </div>

            @endcan


            <a href="{{ route('dashboard.stores.index') }}"
               class="btn btn-secondary btn-block">

                <i class="fas fa-arrow-left mr-1"></i>
                Back to Stores

            </a>

        </div>

    </div>

@endsection