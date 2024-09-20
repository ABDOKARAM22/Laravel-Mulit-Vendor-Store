@extends('Dashboard.Layouts.main')

@section('page_title', 'Categories Trashed')

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
                                    <th>Status</th>
                                    <th>Deleted At</th>
                                    <th>Restore / Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product )
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td> {{ $product->name }}</td>
                                    <td> {{ $product->status }}</td>
                                    <td> {{ $product->deleted_at }}</td>
                                        <td>
                                            <form action="{{route('dashboard.products.restore',$product->id)}}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            
                                            <button type="submit" class="edit" title="Restore" data-toggle="tooltip">
                                            <i class="fas fa-trash" ></i>
                                        </button>
                                            </form>
                                            //
                                            <form action="{{route('dashboard.products.forcedelete',$product->id)}}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="delete" title="Delete" data-toggle="tooltip"
                                            onclick="return confirm('Are you sure you want to delete this service forever ?')">
                                            <i class="fas fa-trash" ></i>
                                        </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="6"  class="text-center"><b>No Products Found.</b></td>
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
