<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreRequest;
use App\Models\Store;
use App\Services\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class StoresController extends Controller
{
    public function __construct(
        private readonly MediaUploader $media
    ) {
    }

    public function index(Request $request)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('viewAny', Store::class);

        $query = Store::query()
            ->with('vendor')
            ->withCount('products');

        if ($admin->isVendor()) {
            $query->where('id', $admin->store_id);
        }

        if ($request->filled('name')) {
            $query->where(
                'name',
                'like',
                '%' . $request->string('name') . '%'
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $stores = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('Dashboard.Stores.index', compact('stores'));
    }

    public function create(Request $request)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('create', Store::class);

        return view('Dashboard.Stores.create');
    }

    public function store(StoreRequest $request)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('create', Store::class);

        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['slug'] ?? $data['name']
        );

        $data['status'] = Store::STATUS_ACTIVE;

        if ($request->hasFile('logo_image')) {
            $data['logo_image'] = $this->media->store(
                $request->file('logo_image'),
                'stores/logos'
            );
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->media->store(
                $request->file('cover_image'),
                'stores/covers'
            );
        }

        Store::create($data);

        return redirect()
            ->route('dashboard.stores.index')
            ->with('success', 'Store created successfully.');
    }

    public function show(Request $request, Store $store)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('view', $store);

        $store->load('vendor')
            ->loadCount('products');

        return view('Dashboard.Stores.show', compact('store'));
    }

    public function edit(Request $request, Store $store)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('update', $store);

        return view('Dashboard.Stores.edit', compact('store'));
    }

    public function update(StoreRequest $request, Store $store)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('update', $store);

        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['slug'] ?? $data['name'],
            $store
        );

        if ($request->hasFile('logo_image')) {
            $this->media->delete($store->logo_image);

            $data['logo_image'] = $this->media->store(
                $request->file('logo_image'),
                'stores/logos'
            );
        }

        if ($request->hasFile('cover_image')) {
            $this->media->delete($store->cover_image);

            $data['cover_image'] = $this->media->store(
                $request->file('cover_image'),
                'stores/covers'
            );
        }

        $store->update($data);

        return redirect()
            ->route('dashboard.stores.index')
            ->with('success', 'Store updated successfully.');
    }

    public function updateStatus(Request $request, Store $store)
    {
        $admin = $request->user('admin');

        Gate::forUser($admin)->authorize('updateStatus', $store);

        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    Store::STATUS_PENDING,
                    Store::STATUS_ACTIVE,
                    Store::STATUS_INACTIVE,
                    Store::STATUS_REJECTED,
                ]),
            ],
        ]);

        $store->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Store status updated successfully.'
        );
    }

    private function generateUniqueSlug(
        string $value,
        ?Store $store = null
    ): string {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'store';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Store::query()
                ->when(
                    $store,
                    fn ($query) => $query->where(
                        $store->getQualifiedKeyName(),
                        '!=',
                        $store->getKey()
                    )
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}