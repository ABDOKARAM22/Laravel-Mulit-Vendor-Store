@extends('Dashboard.Layouts.main')

@section('page_title', 'products')

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">


                    <form action="{{ URL::current() }}" method="GET" class="d-flex justify-content-between mb-4">

                        <input type="text" name="name" placeholder="Name" class="form-control mx-2" value="{{ request('name') }}">

                        <select name="status" class="form-control mx-2" >
                            <option value="">All</option>
                            <option value="Active" @selected(request('status') == 'Active')>Active</option>
                            <option value="Archived" @selected(request('status') == 'Archived')>Archived</option>
                        </select>

                        <button value="Search" class="btn btn-dark mx-2">Search</button>

                    </form>

                    <div class="products-table">

                        <x-success_alert/>

                        <table class="table">

                            
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Store Name</th>
                                    <th>Category Name</th>
                                    <th>Image</th>
                                    <th>Edit / Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product )
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td> {{ $product->name }}</td>
                                    <td> {{ $product->description }}</td>
                                    <td> {{ $product->price }}</td>
                                    <td> {{ $product->status }}</td>
                                    <td> {{ $product->store->name }}</td>
                                    <td> {{ $product->category->name }}</td>
                                        <td><img height="70" width="80"
                                        src="{{asset($product->image)}}"
                                        alt="Faild To opene"></td>
                                        <td>
                                            <a href="{{route('dashboard.products.edit',$product->id)}}"
                                                class="edit" title="Edit" data-toggle="tooltip">
                                                <i class="fas fa-edit text-secondary"></i>
                                            </a>
                                            //
                                            <form action="{{route('dashboard.products.destroy',$product->id)}}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="delete" title="Delete" data-toggle="tooltip"
                                            onclick="return confirm('Are you sure you want to delete this service?')">
                                            <i class="fas fa-trash" ></i>
                                        </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="6"  class="text-center"><b>No products Added.</b></td>
                                    @endforelse
                                </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed-->
    
    <div class="d-flex justify-content-center mt-4">
        {{ $products->WithQueryString()->links() }}
    </div>
    
@endsection
