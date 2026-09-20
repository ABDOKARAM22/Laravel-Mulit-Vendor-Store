@extends('Dashboard.Layouts.main')

@section('page_title', 'Create Store')

@section('breadcrumb', 'Create Store')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-store mr-2"></i>
                Create Store

            </h3>

        </div>


        <form action="{{ route('dashboard.stores.store') }}"
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
                                Store Name
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

                            <label for="slug">
                                Slug
                            </label>

                            <input type="text"
                                   id="slug"
                                   name="slug"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   value="{{ old('slug') }}"
                                   placeholder="Optional">

                            <small class="form-text text-muted">

                                Leave empty to generate it from the store name.

                            </small>

                            @error('slug')

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

                            <label for="logo_image">
                                Logo
                            </label>

                            <div class="custom-file">

                                <input type="file"
                                       id="logo_image"
                                       name="logo_image"
                                       class="custom-file-input @error('logo_image') is-invalid @enderror"
                                       accept="image/*">

                                <label class="custom-file-label"
                                       for="logo_image">

                                    Choose logo

                                </label>

                            </div>

                            @error('logo_image')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="cover_image">
                                Cover Image
                            </label>

                            <div class="custom-file">

                                <input type="file"
                                       id="cover_image"
                                       name="cover_image"
                                       class="custom-file-input @error('cover_image') is-invalid @enderror"
                                       accept="image/*">

                                <label class="custom-file-label"
                                       for="cover_image">

                                    Choose cover image

                                </label>

                            </div>

                            @error('cover_image')

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
                    Create Store

                </button>


                <a href="{{ route('dashboard.stores.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

@endsection