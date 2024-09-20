<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::leftJoin("categories as parent", "categories.parent_id", "=", "parent.id")
            ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
            ->addSelect("categories.*", "parent.name as parent_name")
            ->filters($request)->paginate();
        return view("Dashboard.categories.index", compact("categories"));
    }
    
    public function create()
    {
        $parent_category = Category::whereNull("parent_id")->get();

        return view("Dashboard.categories.create", compact("parent_category"));
    }

    public function store(Request $request)
    {
        // Inputs validation
        $request->validate(Category::CategoriesVlaidate());

        // Merg the slug into the request
        $request->merge([
            "slug" => STR::slug($request->name),
        ]);

        // Except the image field from the request to put the new path
        $data = $request->except('image');
        $data['image'] = $this->upload_image($request);


        Category::create($data);
        return redirect()->route("dashboard.categories.index")->with("success", "Category Added Sucsefully.");
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->with('store')->paginate();
        return view('Dashboard.categories.show',compact(['category','products']));
    }

    public function edit(string $id)
    {

        $category = Category::findOrFail($id);
        $parent_category = Category::where('id', "<>", $id)->whereNull('parent_id')->get();
        return view("Dashboard.categories.edit", compact("category", "parent_category"));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $old_image = $category->image;

        $request->validate(Category::CategoriesVlaidate($id));

        // Except the image field from the request to put the new path
        $data = $request->except('image');
        $new_image = $this->upload_image($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if (isset($data['image']) && isset($old_image)) {
            Storage::disk('uploads')->delete($old_image);
        }

        return redirect()->route("dashboard.categories.index")->with("success", "Category Updated Sucsefully.");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route("dashboard.categories.index")->with("success", "Category Deleted Sucsefully.");
    }


    public function trash(Request $request){

        $categories = Category::onlyTrashed()->filters($request)->paginate();
        return view('Dashboard.categories.trash',compact('categories'));

    }

    public function restore($id){
        $category = Category::onlyTrashed()->FindOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success','Category Restored Sucsefully.');
    }
    
    public function forcedelete($id){

        $category = Category::onlyTrashed()->FindOrFail($id);
        
        $image = $category->image;

        $category->forceDelete();

        if($image) {
            Storage::disk("uploads")->delete($image);
        }

        return redirect()->route("dashboard.categories.trash")->with("success", "Category Deleted Forever Sucsefully.");


    }

    protected function upload_image(Request $request)
    {

        if (!$request->hasFile("image")) {
            return;
        }

        $image = $request->file("image");

        $path = $image->store("categories", ['disk' => 'uploads']);

        return $path;
    }
}
