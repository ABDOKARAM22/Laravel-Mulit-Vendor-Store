@extends('Dashboard.Layouts.main')

@section('page_title', 'Categories')

@section('breadcrumb', 'Categories')

@section('content')

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-2 mb-md-0">

                    <i class="fas fa-tags mr-2"></i>
                    Categories

                </h3>

                @can('create', App\Models\Category::class)

                    <a href="{{ route('dashboard.categories.create') }}"
                       class="btn btn-primary">

                        <i class="fas fa-plus mr-1"></i>
                        Add Category

                    </a>

                @endcan

            </div>

        </div>


        <div class="card-body">

            <form action="{{ route('dashboard.categories.index') }}"
                  method="GET"
                  class="mb-4">

                <div class="row">

                    <div class="col-md-5 mb-2">

                        <label for="name">
                            Category Name
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control"
                               value="{{ request('name') }}"
                               placeholder="Search by category name">

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

                        <a href="{{ route('dashboard.categories.index') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>


            <x-success_alert />


            @if ($categories->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Category</th>

                                <th>Description</th>

                                <th>Parent Category</th>

                                <th>Products</th>

                                <th>Status</th>

                                <th>Image</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($categories as $category)

                                <tr>

                                    <td>
                                        {{ $category->id }}
                                    </td>


                                    <td>

                                        <a href="{{ route('dashboard.categories.show', $category) }}">

                                            <strong>
                                                {{ $category->name }}
                                            </strong>

                                        </a>

                                    </td>


                                    <td>

                                        @if ($category->description)

                                            <span>
                                                {{ \Illuminate\Support\Str::limit($category->description, 80) }}
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    <td>
                                        {{ $category->parent_name ?? 'Main Category' }}
                                    </td>


                                    <td>

                                        <span class="badge badge-info">
                                            {{ $category->products_count }}
                                        </span>

                                    </td>


                                    <td>

                                        @if ($category->status === 'Active')

                                            <span class="badge badge-success">
                                                Active
                                            </span>

                                        @elseif ($category->status === 'Archived')

                                            <span class="badge badge-secondary">
                                                Archived
                                            </span>

                                        @else

                                            <span class="badge badge-light">
                                                {{ $category->status }}
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        @if ($category->image)

                                            <img src="{{ asset($category->image) }}"
                                                 alt="{{ $category->name }}"
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

                                        @can('view', $category)

                                            <a href="{{ route('dashboard.categories.show', $category) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="View">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                        @endcan


                                        @can('update', $category)

                                            <a href="{{ route('dashboard.categories.edit', $category) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                        @endcan


                                        @can('delete', $category)

                                            <form action="{{ route('dashboard.categories.destroy', $category) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">

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

                    {{ $categories->withQueryString()->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i class="fas fa-tags fa-3x text-muted"></i>

                    </div>

                    <h5>
                        No Categories Found
                    </h5>

                    <p class="text-muted">
                        There are no categories matching your current filters.
                    </p>

                    @if (request()->hasAny(['name', 'status']))

                        <a href="{{ route('dashboard.categories.index') }}"
                           class="btn btn-secondary">

                            Clear Filters

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection