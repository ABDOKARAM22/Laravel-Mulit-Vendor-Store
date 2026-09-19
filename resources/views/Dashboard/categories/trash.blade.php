@extends('Dashboard.Layouts.main')

@section('page_title', 'Deleted Categories')

@section('breadcrumb', 'Deleted Categories')

@section('content')

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <h3 class="card-title mb-2 mb-md-0">

                    <i class="fas fa-trash-alt mr-2"></i>
                    Deleted Categories

                </h3>

                <a href="{{ route('dashboard.categories.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left mr-1"></i>
                    Back to Categories

                </a>

            </div>

        </div>


        <div class="card-body">

            <form action="{{ route('dashboard.categories.trash') }}"
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
                               placeholder="Search deleted categories">

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

                        <a href="{{ route('dashboard.categories.trash') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>


            <x-success_alert />


            @if ($categories->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Category</th>

                                <th>Status</th>

                                <th>Deleted At</th>

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

                                        <strong>
                                            {{ $category->name }}
                                        </strong>

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

                                        {{ $category->deleted_at?->format('Y-m-d H:i') ?? '—' }}

                                    </td>


                                    <td class="text-center">

                                        @can('restore', $category)

                                            <form action="{{ route('dashboard.categories.restore', $category) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-success"
                                                        title="Restore"
                                                        onclick="return confirm('Are you sure you want to restore this category?')">

                                                    <i class="fas fa-trash-restore"></i>

                                                </button>

                                            </form>

                                        @endcan


                                        @can('forceDelete', $category)

                                            <form action="{{ route('dashboard.categories.forcedelete', $category) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete Permanently"
                                                        onclick="return confirm('This will permanently delete the category. Are you sure?')">

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

                    {{ $categories->withQueryString()->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i class="fas fa-trash-alt fa-3x text-muted"></i>

                    </div>

                    <h5>
                        No Deleted Categories Found
                    </h5>

                    <p class="text-muted">
                        There are currently no categories in the trash matching your filters.
                    </p>

                    @if (request()->hasAny(['name', 'status']))

                        <a href="{{ route('dashboard.categories.trash') }}"
                           class="btn btn-secondary">

                            Clear Filters

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection