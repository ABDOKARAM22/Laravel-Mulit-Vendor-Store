@extends('Dashboard.Layouts.main')

@section('page_title', $category->name . ' Products')

@section('breadcrumb', $category->name)

@section('content')

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-2 mb-md-0">

                    <i class="fas fa-box mr-2"></i>

                    Products in "{{ $category->name }}"

                </h3>

                <a href="{{ route('dashboard.categories.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left mr-1"></i>
                    Back to Categories

                </a>

            </div>

        </div>


        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-4">

                    <div class="info-box">

                        <span class="info-box-icon bg-info">

                            <i class="fas fa-tags"></i>

                        </span>

                        <div class="info-box-content">

                            <span class="info-box-text">
                                Category
                            </span>

                            <span class="info-box-number">
                                {{ $category->name }}
                            </span>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="info-box">

                        <span class="info-box-icon bg-success">

                            <i class="fas fa-box"></i>

                        </span>

                        <div class="info-box-content">

                            <span class="info-box-text">
                                Products
                            </span>

                            <span class="info-box-number">
                                {{ $products->total() }}
                            </span>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="info-box">

                        <span class="info-box-icon bg-secondary">

                            <i class="fas fa-toggle-on"></i>

                        </span>

                        <div class="info-box-content">

                            <span class="info-box-text">
                                Status
                            </span>

                            <span class="info-box-number">

                                @if ($category->status === 'Active')

                                    <span class="badge badge-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge badge-secondary">
                                        Archived
                                    </span>

                                @endif

                            </span>

                        </div>

                    </div>

                </div>

            </div>


            @if ($category->description)

                <div class="card card-light">

                    <div class="card-header">

                        <h3 class="card-title">

                            <i class="fas fa-align-left mr-2"></i>
                            Description

                        </h3>

                    </div>

                    <div class="card-body">

                        <p class="mb-0">
                            {{ $category->description }}
                        </p>

                    </div>

                </div>

            @endif


            <form action="{{ route('dashboard.categories.show', $category) }}"
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
                               placeholder="Search products">

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

                        </select>

                    </div>


                    <div class="col-md-3 mb-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary mr-2">

                            <i class="fas fa-search mr-1"></i>
                            Search

                        </button>

                        <a href="{{ route('dashboard.categories.show', $category) }}"
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

                                <th>Store</th>

                                <th>Status</th>

                                <th>Image</th>

                                <th>Created At</th>

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
                                        {{ $product->store?->name ?? '—' }}
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


                                    <td>
                                        {{ $product->created_at?->format('Y-m-d H:i') ?? '—' }}
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
                        There are no products in this category matching your filters.
                    </p>

                    @if (request()->hasAny(['name', 'status']))

                        <a href="{{ route('dashboard.categories.show', $category) }}"
                           class="btn btn-secondary">

                            Clear Filters

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection