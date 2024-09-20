@extends('Dashboard.Layouts.main')

@section('page_title', 'Create Product')

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form id='products' action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control" id="category_id">
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                            </select>
                            
                            @error('category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- tags -->
                        <div class="form-group">
                            <label for="tag">Tags</label>
                            <input type="text" class="form-control" id="tag" name="tag" value="{{old('tag')}}">
                            @error('tag')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        


                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="4">{{old('description')}}</textarea>
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
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{old('price')}}">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Featured -->
                        <div class="form-group">
                            <label>Featured</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="featured" value="1" @checked(old('featured') == '1')>
                                <label class="form-check-label">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="featured" value="0" @checked(old('featured') == '0')>
                                <label class="form-check-label">
                                    No
                                </label>
                            </div>
                            @error('featured')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Active" @selected(old('status') == 'Active')>Active</option>
                                <option value="Archived" @selected(old('status') == 'Archived')>Archived</option>
                                <option value="Draft" @selected(old('status') == 'Draft')>Draft</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
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