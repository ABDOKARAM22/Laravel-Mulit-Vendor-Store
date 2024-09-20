<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['store','category'])->Paginate();
        return view('Dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
    $store_id = Auth::user()->store_id;
    $product_slug = Str::slug($request->name);

    $request->merge([
        'store_id' => $store_id ,
        'slug' =>$product_slug
    ]);


        $data = $request->except('tag','image');
        $data ['image'] = $this->upload_image($request);

        $product = Product::create($data);
        
        $product->tags()->sync($this->handel_tags($request));
        
    return redirect()->route('dashboard.products.index')->with('success', 'Product Created successfully');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::pluck('name','id');
        $tags = implode(',',$product->tags()->pluck('name')->toArray());
        return view('Dashboard.products.edit', compact('product','categories','tags'));

    }
     
    
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $old_image = $product->image; 
        $data = $request->except('tag','image');

        $new_image = $this->upload_image($request);
      
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $product->tags()->sync($this->handel_tags($request));

        $product->update($data);

        if (isset($data['image']) && isset($old_image)) {
            Storage::disk('uploads')->delete($old_image);
        }


        return redirect()->back()->with('success','Product Updated successfully');
    }

    
    public function trash(Request $request){

        $products = Product::onlyTrashed()->paginate();
        return view('Dashboard.products.trash',compact('products'));

    }

    
    public function restore($id){
        $product = product::onlyTrashed()->FindOrFail($id);
        $product->restore();
        return redirect()->route('dashboard.products.trash')->with('success','Product Restored Sucsefully.');
    }
    
    public function destroy(string $id)
    {
        $product = Product::FindOrFail($id);
        $product->delete();
        return redirect()->back()->with("success", "Product Deleted Sucsefully.");
    }


    public function forcedelete($id){

        $product = Product::onlyTrashed()->FindOrFail($id);
        
        $image = $product->image;

        $product->forceDelete();

        if($image) {
            Storage::disk("uploads")->delete($image);
        }

        return redirect()->route("dashboard.products.trash")->with("success", "Product Deleted Forever Sucsefully.");


    }

    protected function handel_tags($request) {
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
}
