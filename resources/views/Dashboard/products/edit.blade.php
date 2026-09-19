@extends('Dashboard.Layouts.main')

@section('page_title', 'Edit Product')

@section('breadcrumb', 'Edit Product')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Edit Product
            </h3>

        </div>


        <form id="products"
              action="{{ route('dashboard.products.update', $product) }}"
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
                                Product Name
                            </label>

                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name) }}"
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

                            <label for="category_id">
                                Category
                            </label>

                            <select name="category_id"
                                    id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror"
                                    required>

                                <option value="">
                                    Select Category
                                </option>

                                @foreach ($categories as $id => $name)

                                    <option value="{{ $id }}"
                                        @selected(old('category_id', $product->category_id) == $id)>

                                        {{ $name }}

                                    </option>

                                @endforeach

                            </select>

                            @error('category_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="tag">
                                Tags
                            </label>

                            <input type="text"
                                   id="tag"
                                   name="tag"
                                   class="form-control @error('tag') is-invalid @enderror"
                                   value="{{ old('tag', $tags) }}"
                                   placeholder="Add product tags">

                            @error('tag')

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
                                      class="form-control @error('description') is-invalid @enderror"
                                      required>{{ old('description', $product->description) }}</textarea>

                            @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="price">
                                Price
                            </label>

                            <input type="number"
                                   id="price"
                                   name="price"
                                   step="0.01"
                                   min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price) }}"
                                   required>

                            @error('price')

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
                                    @selected(old('status', $product->status) === 'Active')>
                                    Active
                                </option>

                                <option value="Archived"
                                    @selected(old('status', $product->status) === 'Archived')>
                                    Archived
                                </option>

                                <option value="Draft"
                                    @selected(old('status', $product->status) === 'Draft')>
                                    Draft
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
                                Featured
                            </label>

                            <div>

                                <div class="custom-control custom-radio custom-control-inline">

                                    <input type="radio"
                                           id="featured_yes"
                                           name="featured"
                                           value="1"
                                           class="custom-control-input"
                                           @checked(old('featured', $product->featured) == 1)>

                                    <label class="custom-control-label"
                                           for="featured_yes">

                                        Yes

                                    </label>

                                </div>


                                <div class="custom-control custom-radio custom-control-inline">

                                    <input type="radio"
                                           id="featured_no"
                                           name="featured"
                                           value="0"
                                           class="custom-control-input"
                                           @checked(old('featured', $product->featured) == 0)>

                                    <label class="custom-control-label"
                                           for="featured_no">

                                        No

                                    </label>

                                </div>

                            </div>

                            @error('featured')

                                <div class="text-danger small mt-1">
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

                                @if ($product->image)

                                    <img src="{{ asset($product->image) }}"
                                         alt="{{ $product->name }}"
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
                    Update Product

                </button>

                <a href="{{ route('dashboard.products.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

@endsection


@push('styles')

    <link rel="stylesheet"
          href="{{ asset('dist/css/tagify.css') }}">

@endpush


@push('scripts')

    <script src="{{ asset('dist/js/tagify.js') }}"></script>

    <script src="{{ asset('dist/js/tagify.polyfills.min.js') }}"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const input = document.querySelector('[name="tag"]');

            if (input) {
                new Tagify(input);
            }

        });

    </script>

@endpush