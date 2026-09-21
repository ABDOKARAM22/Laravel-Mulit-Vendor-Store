<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Services\MediaUploader;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('viewAny', Category::class);

        $categories = Category::leftJoin(
                "categories as parent",
                "categories.parent_id",
                "=",
                "parent.id"
            )
            ->selectRaw(
                '(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count'
            )
            ->addSelect("categories.*", "parent.name as parent_name")
            ->filters($request)
            ->paginate();

        return view("Dashboard.categories.index", compact("categories"));
    }

    public function create(Request $request)
    {
        Gate::forUser($request->user('admin'))
            ->authorize('create', Category::class);

        $parent_category = Category::whereNull("parent_id")->get();

        return view(
            "Dashboard.categories.create",
            compact("parent_category")
        );
    }

    public function store(Request $request, MediaUploader $media)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)
            ->authorize('create', Category::class);

        // Inputs validation
        $request->validate(Category::CategoriesVlaidate());

        // Merge the slug into the request
        $request->merge([
            "slug" => Str::slug($request->name),
        ]);

        // Except the image field from the request to put the new path
        $data = $request->except('image');
        $data['image'] = $this->storeImage($request, $media);

        Category::create($data);

        return redirect()
            ->route("dashboard.categories.index")
            ->with("success", "Category Added Sucsefully.");
    }

    public function show(string $id, Request $request)
    {
        $category = Category::findOrFail($id);

        Gate::forUser($request->user('admin'))
            ->authorize('view', $category);

        $products = $category->products()
            ->with('store')
            ->paginate();

        return view(
            'Dashboard.categories.show',
            compact(['category', 'products'])
        );
    }

    public function edit(string $id, Request $request)
    {
        $category = Category::findOrFail($id);

        Gate::forUser($request->user('admin'))
            ->authorize('update', $category);

        $parent_category = Category::where('id', "<>", $id)
            ->whereNull('parent_id')
            ->get();

        return view(
            "Dashboard.categories.edit",
            compact("category", "parent_category")
        );
    }

    public function update(
        Request $request,
        string $id,
        MediaUploader $media
    ) {
        $category = Category::findOrFail($id);

        Gate::forUser($request->user('admin'))
            ->authorize('update', $category);

        $old_image = $category->image;

        $request->validate(Category::CategoriesVlaidate($id));

        // Except the image field from the request to put the new path
        $data = $request->except('image');
        $new_image = $this->storeImage($request, $media);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if (isset($data['image']) && isset($old_image)) {
            $media->delete($old_image);
        }

        return redirect()
            ->route("dashboard.categories.index")
            ->with("success", "Category Updated Sucsefully.");
    }

    public function destroy(string $id, Request $request)
    {
        $category = Category::findOrFail($id);

        Gate::forUser($request->user('admin'))
            ->authorize('delete', $category);

        $category->delete();

        return redirect()
            ->route("dashboard.categories.index")
            ->with("success", "Category Deleted Sucsefully.");
    }

    public function trash(Request $request)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)
            ->authorize('viewAny', Category::class);

        $categories = Category::onlyTrashed()
            ->filters($request)
            ->paginate();

        return view(
            'Dashboard.categories.trash',
            compact('categories')
        );
    }

    public function restore($id, Request $request)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        Gate::forUser($request->user('admin'))
            ->authorize('restore', $category);

        $category->restore();

        return redirect()
            ->route('dashboard.categories.trash')
            ->with('success', 'Category Restored Sucsefully.');
    }

    public function forcedelete($id, Request $request, MediaUploader $media)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        Gate::forUser($request->user('admin'))
            ->authorize('forceDelete', $category);

        $image = $category->image;

        $category->forceDelete();

        if ($image) {
            $media->delete($image);
        }

        return redirect()
            ->route("dashboard.categories.trash")
            ->with(
                "success",
                "Category Deleted Forever Sucsefully."
            );
    }

    protected function storeImage(
        Request $request,
        MediaUploader $media
    ): ?string {
        if (! $request->hasFile('image')) {
            return null;
        }

        return $media->store(
            $request->file('image'),
            'categories'
        );
    }
}