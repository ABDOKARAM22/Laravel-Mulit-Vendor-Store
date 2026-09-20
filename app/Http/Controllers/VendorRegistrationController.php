<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRegistrationRequest;
use App\Models\Admin;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorRegistrationController extends Controller
{
    public function create(): View
    {
        return view('vendor.register');
    }

    public function store(VendorRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data): void {
            $store = Store::create([
                'name' => $data['store_name'],
                'slug' => $this->uniqueSlug($data['store_name']),
                'description' => $data['store_description'] ?? null,
                'status' => Store::STATUS_PENDING,
            ]);

            Admin::forceCreate([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => Admin::ROLE_VENDOR,
                'store_id' => $store->id,
                'status' => Admin::STATUS_PENDING,
            ]);
        });

        return redirect()
            ->route('vendor.register')
            ->with('success', 'Your vendor application was submitted and is awaiting approval.');
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'store';
        $slug = $base;
        $counter = 1;

        while (Store::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
