@extends('Dashboard.Layouts.main')

@section('page_title', 'Stores')

@section('breadcrumb', 'Stores')

@section('content')

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-2 mb-md-0">

                    <i class="fas fa-store mr-2"></i>
                    Stores

                </h3>

                @can('create', App\Models\Store::class)

                    <a href="{{ route('dashboard.stores.create') }}"
                       class="btn btn-primary">

                        <i class="fas fa-plus mr-1"></i>
                        Add Store

                    </a>

                @endcan

            </div>

        </div>


        <div class="card-body">

            <form action="{{ route('dashboard.stores.index') }}"
                  method="GET"
                  class="mb-4">

                <div class="row">

                    <div class="col-md-5 mb-2">

                        <label for="name">
                            Store Name
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control"
                               value="{{ request('name') }}"
                               placeholder="Search by store name">

                    </div>


                    <div class="col-md-4 mb-2">

                        <label for="status">
                            Status
                        </label>

                        <select name="status"
                                id="status"
                                class="form-control">

                            <option value="">
                                All Statuses
                            </option>

                            <option value="{{ App\Models\Store::STATUS_PENDING }}"
                                @selected(request('status') === App\Models\Store::STATUS_PENDING)>

                                Pending

                            </option>

                            <option value="{{ App\Models\Store::STATUS_ACTIVE }}"
                                @selected(request('status') === App\Models\Store::STATUS_ACTIVE)>

                                Active

                            </option>

                            <option value="{{ App\Models\Store::STATUS_INACTIVE }}"
                                @selected(request('status') === App\Models\Store::STATUS_INACTIVE)>

                                Inactive

                            </option>

                            <option value="{{ App\Models\Store::STATUS_REJECTED }}"
                                @selected(request('status') === App\Models\Store::STATUS_REJECTED)>

                                Rejected

                            </option>

                        </select>

                    </div>


                    <div class="col-md-3 mb-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary mr-2">

                            <i class="fas fa-search mr-1"></i>
                            Search

                        </button>

                        <a href="{{ route('dashboard.stores.index') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>


            <x-success_alert />


            @if ($stores->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Store</th>

                                <th>Vendor</th>

                                <th>Products</th>

                                <th>Status</th>

                                <th>Created At</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($stores as $store)

                                <tr>

                                    <td>
                                        {{ $store->id }}
                                    </td>


                                    <td>

                                        <a href="{{ route('dashboard.stores.show', $store) }}">

                                            <strong>
                                                {{ $store->name }}
                                            </strong>

                                        </a>

                                        <div class="text-muted small">
                                            /{{ $store->slug }}
                                        </div>

                                    </td>


                                    <td>

                                        @if ($store->vendor)

                                            {{ $store->vendor->name }}

                                            <div class="text-muted small">
                                                {{ $store->vendor->email }}
                                            </div>

                                        @else

                                            <span class="text-muted">
                                                Not assigned
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        <span class="badge badge-info">
                                            {{ $store->products_count }}
                                        </span>

                                    </td>


                                    <td>

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

                                    </td>


                                    <td>

                                        {{ $store->created_at?->format('Y-m-d H:i') ?? '—' }}

                                    </td>


                                    <td class="text-center">

                                        @can('view', $store)

                                            <a href="{{ route('dashboard.stores.show', $store) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="View">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                        @endcan


                                        @can('update', $store)

                                            <a href="{{ route('dashboard.stores.edit', $store) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                        @endcan


                                        @can('updateStatus', $store)

                                            <form action="{{ route('dashboard.stores.status', $store) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf

                                                @method('PATCH')

                                                <select name="status"
                                                        class="form-control form-control-sm d-inline-block"
                                                        style="width: 110px;"
                                                        onchange="this.form.submit()">

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

                                            </form>

                                        @endcan

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                <div class="mt-4 d-flex justify-content-center">

                    {{ $stores->withQueryString()->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i class="fas fa-store-slash fa-3x text-muted"></i>

                    </div>

                    <h5>
                        No Stores Found
                    </h5>

                    <p class="text-muted">

                        There are no stores matching your current filters.

                    </p>

                    @if (request()->hasAny(['name', 'status']))

                        <a href="{{ route('dashboard.stores.index') }}"
                           class="btn btn-secondary">

                            Clear Filters

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection