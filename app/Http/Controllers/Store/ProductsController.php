<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request){

        $search = $request->query('search');
        $category = $request->query('category');
        $tag = $request->query('tag');
        $sort = $request->query('sort');
        $products = Product::where('status', 'Active')
        ->search($search)
        ->category($category)
        ->tag($tag)
        ->sortBy($sort)
        ->paginate(12)
        ->withQueryString();
        $categories = Category::where('status', 'Active')->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('store.products.index',compact('products', 'categories', 'tags'));
    }

    public function show(Product $product)
    {
        if ($product->status != 'Active') {
            abort(404);
        }

        $categories = Category::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $relatedProducts = Product::where('status', 'Active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(10)
            ->get();

        return view(
            'store.products.show',
            compact('product', 'categories', 'relatedProducts')
        );
    }
}
