@extends('Dashboard.Layouts.main')

@section('page_title', 'Edit Category')

@section('breadcrumb', 'Edit Category')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-edit mr-2"></i>
                Edit Category

            </h3>

        </div>


        <form id="categories"
              action="{{ route('dashboard.categories.update', $category) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="card-body">

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <h6 class="mb-2">
                            Please correct the following errors:
                        </h6>

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="name">
                                Category Name
                            </label>

                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $category->name) }}"
                                   required>

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="parent_category">
                                Parent Category
                            </label>

                            <select name="parent_id"
                                    id="parent_category"
                                    class="form-control @error('parent_id') is-invalid @enderror">

                                <option value=""
                                    @selected(old('parent_id', $category->parent_id) === null)>

                                    Main Category

                                </option>

                                @foreach ($parent_category as $parent)

                                    <option value="{{ $parent->id }}"
                                        @selected(old('parent_id', $category->parent_id) == $parent->id)>

                                        {{ $parent->name }}

                                    </option>

                                @endforeach

                            </select>

                            @error('parent_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="description">
                                Description
                            </label>

                            <textarea id="description"
                                      name="description"
                                      rows="5"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>

                            @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="status">
                                Status
                            </label>

                            <select name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required>

                                <option value="Active"
                                    @selected(old('status', $category->status) === 'Active')>

                                    Active

                                </option>

                                <option value="Archived"
                                    @selected(old('status', $category->status) === 'Archived')>

                                    Archived

                                </option>

                            </select>

                            @error('status')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Current Image
                            </label>

                            <div>

                                @if ($category->image)

                                    <img src="{{ asset($category->image) }}"
                                         alt="{{ $category->name }}"
                                         class="img-thumbnail"
                                         style="width: 120px; height: 120px; object-fit: cover;">

                                @else

                                    <p class="text-muted mb-0">
                                        No image uploaded.
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="image">
                                Replace Image
                            </label>

                            <div class="custom-file">

                                <input type="file"
                                       id="image"
                                       name="image"
                                       class="custom-file-input @error('image') is-invalid @enderror"
                                       accept="image/*">

                                <label class="custom-file-label"
                                       for="image">

                                    Choose new image

                                </label>

                            </div>

                            @error('image')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            <div class="card-footer">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fas fa-save mr-1"></i>
                    Update Category

                </button>

                <a href="{{ route('dashboard.categories.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

@endsection