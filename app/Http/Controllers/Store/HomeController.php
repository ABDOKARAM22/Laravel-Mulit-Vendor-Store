<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $featured_products = Product::oldest()->featured()->limit(8)->get();
        $latest_products = Product::latest()->limit(8)->get();
        return view('store.home',compact('featured_products','latest_products'));
    }
}
