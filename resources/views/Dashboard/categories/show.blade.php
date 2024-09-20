@extends('Dashboard.Layouts.main')

@section('page_title', "$category->name Products")

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

                    <div class="categories-table">

                        <x-success_alert/>

                        <table class="table">

                            
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Store</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product )
                                <tr>
                                    <td> {{ $product->name }}</td>
                                    <td> {{ $product->store->name }}</td>
                                    <td> {{ $product->status }}</td>
                                    <td><img height="70" width="80"
                                        src="{{asset($product->image)}}"
                                        alt="Faild To opene"></td>
                                        <td> {{ $product->created_at }}</td>
                                    </tr>
                                    @empty
                                    <td colspan="6"  class="text-center"><b>No Categories Added.</b></td>
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
