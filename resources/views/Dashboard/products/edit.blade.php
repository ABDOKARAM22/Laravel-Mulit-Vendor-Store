@extends('Dashboard.Layouts.main')

@section('page_title', 'Edit Product')

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    <x-success_alert/>

                    <form id='products' action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control" id="category_id">
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" @selected($product->category_id == $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="store_id" value="{{ $product->store_id}}">
                        <input type="hidden" name="slug" value="{{ $product->slug}}">

                        <!-- Tags -->
                        <div class="form-group">
                            <label for="tag">Tags</label>
                            <input type="text" class="form-control" id="tag" name="tag" value="{{ $tags }}">
                            @error('tag')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="4">{{ $product->description }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured -->
                        <div class="form-group">
                            <label>Featured</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="featured" value="1" @checked($product->featured == 1)>
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="featured" value="0" @checked($product->featured == 0)>
                                <label class="form-check-label">No</label>
                            </div>
                            @error('featured')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Active" @selected($product->status == 'Active')>Active</option>
                                <option value="Archived" @selected($product->status == 'Archived')>Archived</option>
                                <option value="Draft" @selected($product->status == 'Draft')>Draft</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <input type="submit" value="Update" name="update" class="form-control btn-secondary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

@endsection

@push('styles')
<link href="{{asset('dist/css/tagify.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('script')
<script src="{{asset('dist/js/tagify.js')}}"></script>
<script src="{{asset('dist/js/tagify.polyfills.min.js')}}"></script>
<script>
    var inputElem = document.querySelector('[name=tag]') // the 'input' element which will be transformed into a Tagify component
    var tagify = new Tagify(inputElem);
</script>
@endpush