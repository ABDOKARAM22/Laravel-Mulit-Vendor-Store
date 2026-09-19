@extends('Dashboard.Layouts.main')

@section('page_title', 'Create Category')

@section('breadcrumb', 'Create Category')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-plus-circle mr-2"></i>
                Create Category

            </h3>

        </div>


        <form id="categories"
              action="{{ route('dashboard.categories.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

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
                                   value="{{ old('name') }}"
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

                                <option value="">
                                    Main Category
                                </option>

                                @foreach ($parent_category as $parent)

                                    <option value="{{ $parent->id }}"
                                        @selected(old('parent_id') == $parent->id)>

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
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

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

                                <option value="">
                                    Select Status
                                </option>

                                <option value="Active"
                                    @selected(old('status') === 'Active')>

                                    Active

                                </option>

                                <option value="Archived"
                                    @selected(old('status') === 'Archived')>

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

                            <label for="image">
                                Category Image
                            </label>

                            <div class="custom-file">

                                <input type="file"
                                       id="image"
                                       name="image"
                                       class="custom-file-input @error('image') is-invalid @enderror"
                                       accept="image/*">

                                <label class="custom-file-label"
                                       for="image">

                                    Choose image

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
                    Save Category

                </button>

                <a href="{{ route('dashboard.categories.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

@endsection