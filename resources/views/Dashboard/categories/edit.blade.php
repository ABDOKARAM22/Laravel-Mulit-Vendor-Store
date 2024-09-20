@extends('Dashboard.Layouts.main')

@section('page_title', 'Edit Category')

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    <form id='categories' action="{{ route('dashboard.categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <div class="form-row">

                                <div class="form-group col-md-12">

                                    <label for="name">Category Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $category->name }}">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="parent_category">Parent Category</label>
                            <select name="parent_id" class="form-control" id="parent_category">
                                <option value="" @selected($category->parent_id == null)>Main Category</option>
                                @foreach ($parent_category as $parent)
                                    <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id)> {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" form="categories" rows="4">{{ $category->description }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Active"
                                    @checked($category->status == 'Active')>
                                <label class="form-check-label">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Archived"
                                    @checked($category->status == 'Archived')>
                                <label class="form-check-label">
                                    Archived
                                </label>
                            </div>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Save" name="save" class="form-control btn-secondary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

@endsection
