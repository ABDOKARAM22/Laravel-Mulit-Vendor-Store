<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){

        $products = Product::paginate(12);
        return view('store.products.index',compact('products'));
    }

    public function show(Product $product){

        if($product->status != 'Active'){
            abort(404);
        }

        return view('store.products.show',compact('product'));
    }
}
