@extends('Dashboard.Layouts.main')

@section('page_title', 'Products')

@section('breadcrumb', 'Products')

@section('content')

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-2 mb-md-0">
                    <i class="fas fa-box mr-2"></i>
                    Products
                </h3>

                @can('create', App\Models\Product::class)

                    <a href="{{ route('dashboard.products.create') }}"
                       class="btn btn-primary">

                        <i class="fas fa-plus mr-1"></i>
                        Add Product

                    </a>

                @endcan

            </div>

        </div>


        <div class="card-body">

            <form action="{{ route('dashboard.products.index') }}"
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
                               placeholder="Search by product name">

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

                        <a href="{{ route('dashboard.products.index') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>


            <x-success_alert />


            @if ($products->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Product</th>

                                <th>Price</th>

                                <th>Status</th>

                                <th>Store</th>

                                <th>Category</th>

                                <th>Image</th>

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

                                        @if ($product->description)

                                            <div class="text-muted small mt-1">

                                                {{ \Illuminate\Support\Str::limit($product->description, 80) }}

                                            </div>

                                        @endif

                                    </td>


                                    <td>
                                        {{ number_format((float) $product->price, 2) }}
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
                                        {{ $product->store?->name ?? '—' }}
                                    </td>


                                    <td>
                                        {{ $product->category?->name ?? '—' }}
                                    </td>


                                    <td>

                                        @if ($product->image)

                                            <img src="{{ asset($product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 width="60"
                                                 height="60"
                                                 class="img-thumbnail"
                                                 style="object-fit: cover;">

                                        @else

                                            <span class="text-muted">
                                                No image
                                            </span>

                                        @endif

                                    </td>


                                    <td class="text-center">

                                        @can('update', $product)

                                            <a href="{{ route('dashboard.products.edit', $product) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                        @endcan


                                        @can('delete', $product)

                                            <form action="{{ route('dashboard.products.destroy', $product) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this product?')">

                                                    <i class="fas fa-trash"></i>

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

                        <i class="fas fa-box-open fa-3x text-muted"></i>

                    </div>

                    <h5>
                        No Products Found
                    </h5>

                    <p class="text-muted">
                        There are no products matching your current filters.
                    </p>

                    @if (request()->hasAny(['name', 'status']))

                        <a href="{{ route('dashboard.products.index') }}"
                           class="btn btn-secondary">

                            Clear Filters

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection