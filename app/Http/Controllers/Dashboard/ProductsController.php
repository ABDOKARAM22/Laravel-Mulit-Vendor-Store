<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admin = $request->user('admin');
        Gate::forUser($admin)->authorize('viewAny', Product::class);

        $query = Product::with(['store','category']);
        if ($admin->isVendor()) {
            $query->where('store_id', $admin->store_id);
        }

        $products = $query->paginate();
        return view('Dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::forUser($request->user('admin'))->authorize('create', Product::class);
        $categories = Category::pluck('name','id');
        return view('Dashboard.products.create', [
            'categories' => $categories,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $admin = $request->user('admin');
        Gate::forUser($admin)->authorize('create', Product::class);

        $data = $request->safe()->except(['tag', 'image', 'slug', 'store_id']);
        $data['slug'] = $this->uniqueSlug($request->string('name')->toString());
        $data ['image'] = $this->upload_image($request);

        $product = new Product($data);
        $product->store_id = $admin->store_id;
        $product->slug = $data['slug'];
        $product->save();
        
        $product->tags()->sync($this->handel_tags($request));
        
    return redirect()->route('dashboard.products.index')->with('success', 'Product Created successfully');
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product, Request $request)
    {
        Gate::forUser($request->user('admin'))->authorize('view', $product);

        return redirect()->route('dashboard.products.edit', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Request $request)
    {
        Gate::forUser($request->user('admin'))->authorize('view', $product);
        $categories = Category::pluck('name','id');
        $tags = implode(',',$product->tags()->pluck('name')->toArray());
        return view('Dashboard.products.edit', compact('product','categories','tags'));

    }
     
    
    public function update(ProductRequest $request, Product $product)
    {
        Gate::forUser($request->user('admin'))->authorize('update', $product);
        $old_image = $product->image; 
        $data = $request->safe()->except(['tag', 'image', 'slug', 'store_id']);
        $data['slug'] = $this->uniqueSlug($request->string('name')->toString(), $product);

        $new_image = $this->upload_image($request);
      
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $product->tags()->sync($this->handel_tags($request));

        $product->fill($data);
        $product->slug = $data['slug'];
        $product->save();

        if (isset($data['image']) && isset($old_image)) {
            Storage::disk('uploads')->delete($old_image);
        }


        return redirect()->back()->with('success','Product Updated successfully');
    }

    
    public function trash(Request $request){

        $admin = $request->user('admin');
        Gate::forUser($admin)->authorize('viewAny', Product::class);
        $query = Product::onlyTrashed();
        if ($admin->isVendor()) {
            $query->where('store_id', $admin->store_id);
        }

        $products = $query->paginate();
        return view('Dashboard.products.trash',compact('products'));

    }

    
    public function restore(string $id, Request $request){
        $product = Product::onlyTrashed()->findOrFail($id);
        Gate::forUser($request->user('admin'))->authorize('restore', $product);
        $product->restore();
        return redirect()->route('dashboard.products.trash')->with('success','Product Restored Sucsefully.');
    }
    
    public function destroy(Product $product, Request $request)
    {
        Gate::forUser($request->user('admin'))->authorize('delete', $product);
        $product->delete();
        return redirect()->back()->with("success", "Product Deleted Sucsefully.");
    }


    public function forcedelete(string $id, Request $request){

        $product = Product::onlyTrashed()->findOrFail($id);
        Gate::forUser($request->user('admin'))->authorize('forceDelete', $product);
        
        $image = $product->image;

        $product->forceDelete();

        if($image) {
            Storage::disk("uploads")->delete($image);
        }

        return redirect()->route("dashboard.products.trash")->with("success", "Product Deleted Forever Sucsefully.");


    }

    protected function handel_tags($request) {
        if(!($request->post('tag'))){
            return;
        }
        $tags = json_decode($request->post('tag'));
        $tag_ids = [];
        $saved_tags = Tag::all();
        foreach ($tags as $tag_name) {
            // make slug for tags
            $slug = str::slug($tag_name->value);
            // get tags if exist
            $tag = $saved_tags->where('slug',$slug)->first();
            // if not exist create it
            if( ! $tag ){
                $tag = Tag::create([
                    'name' => $tag_name->value,
                    'slug' => $slug
                ]);
            }
            $tag_ids[] = $tag->id; 
        }
        return $tag_ids;
           
    }

    
    protected function upload_image(Request $request)
    {

        if (!$request->hasFile("image")) {
            return;
        }

        $image = $request->file("image");

        $path = $image->store("products", ['disk' => 'uploads']);

        return $path;
    }

    protected function uniqueSlug(string $name, ?Product $product = null): string
    {
        $slug = Str::slug($name);
        $candidate = $slug;
        $suffix = 1;

        while (
            Product::withTrashed()
                ->where('slug', $candidate)
                ->when($product, fn ($query) => $query->where($product->getTable() . '.id', '!=', $product->getKey()))
                ->exists()
        ) {
            $candidate = $slug . '-' . $suffix++;
        }

        return $candidate;
    }
}
