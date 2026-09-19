@extends('Dashboard.Layouts.main')

@section('page_title', 'Deleted Products')

@section('breadcrumb', 'Deleted Products')

@section('content')

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-2 mb-md-0">

                    <i class="fas fa-trash-alt mr-2"></i>
                    Deleted Products

                </h3>

                <a href="{{ route('dashboard.products.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left mr-1"></i>
                    Back to Products

                </a>

            </div>

        </div>


        <div class="card-body">

            <form action="{{ route('dashboard.products.trash') }}"
                  method="GET"
                  class="mb-4">

                <div class="row">

                    <div class="col-md-5 mb-2">

                        <label for="name">
                            Product Name
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control"
                               value="{{ request('name') }}"
                               placeholder="Search deleted products">

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

                            <option value="Active"
                                @selected(request('status') === 'Active')>
                                Active
                            </option>

                            <option value="Archived"
                                @selected(request('status') === 'Archived')>
                                Archived
                            </option>

                            <option value="Draft"
                                @selected(request('status') === 'Draft')>
                                Draft
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3 mb-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary mr-2">

                            <i class="fas fa-search mr-1"></i>
                            Search

                        </button>

                        <a href="{{ route('dashboard.products.trash') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>


            <x-success_alert />


            @if ($products->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Product</th>

                                <th>Status</th>

                                <th>Deleted At</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($products as $product)

                                <tr>

                                    <td>
                                        {{ $product->id }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $product->name }}
                                        </strong>

                                    </td>


                                    <td>

                                        @switch($product->status)

                                            @case('Active')

                                                <span class="badge badge-success">
                                                    Active
                                                </span>

                                                @break

                                            @case('Archived')

                                                <span class="badge badge-secondary">
                                                    Archived
                                                </span>

                                                @break

                                            @case('Draft')

                                                <span class="badge badge-warning">
                                                    Draft
                                                </span>

                                                @break

                                            @default

                                                <span class="badge badge-light">
                                                    {{ $product->status }}
                                                </span>

                                        @endswitch

                                    </td>


                                    <td>

                                        {{ $product->deleted_at?->format('Y-m-d H:i') ?? '—' }}

                                    </td>


                                    <td class="text-center">

                                        @can('restore', $product)

                                            <form action="{{ route('dashboard.products.restore', $product->id) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-success"
                                                        title="Restore"
                                                        onclick="return confirm('Are you sure you want to restore this product?')">

                                                    <i class="fas fa-trash-restore"></i>

                                                </button>

                                            </form>

                                        @endcan


                                        @can('forceDelete', $product)

                                            <form action="{{ route('dashboard.products.forcedelete', $product->id) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete Permanently"
                                                        onclick="return confirm('This will permanently delete the product. Are you sure?')">

                                                    <i class="fas fa-times"></i>

                                                </button>

                                            </form>

                                        @endcan

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                <div class="mt-4 d-flex justify-content-center">

                    {{ $products->withQueryString()->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i class="fas fa-trash-alt fa-3x text-muted"></i>

                    </div>

                    <h5>
                        No Deleted Products Found
                    </h5>

                    <p class="text-muted">
                        There are currently no products in the trash matching your filters.
                    </p>

                    @if (request()->hasAny(['name', 'status']))

                        <a href="{{ route('dashboard.products.trash') }}"
                           class="btn btn-secondary">

                            Clear Filters

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection