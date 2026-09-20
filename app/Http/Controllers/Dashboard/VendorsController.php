<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\VendorStatusRequest;
use App\Http\Requests\Dashboard\VendorUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class VendorsController extends Controller
{
    public function index(Request $request): View
    {
        Gate::forUser($request->user('admin'))->authorize('viewAny', Admin::class);

        $vendors = Admin::query()
            ->where('role', Admin::ROLE_VENDOR)
            ->with('store')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search');
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('Dashboard.vendors.index', compact('vendors'));
    }

    public function show(Request $request, Admin $vendor): View
    {
        $this->authorizeVendor($request, $vendor, 'view');
        $vendor->load('store');

        return view('Dashboard.vendors.show', compact('vendor'));
    }

    public function edit(Request $request, Admin $vendor): View
    {
        $this->authorizeVendor($request, $vendor, 'update');

        return view('Dashboard.vendors.edit', compact('vendor'));
    }

    public function update(VendorUpdateRequest $request, Admin $vendor): RedirectResponse
    {
        $this->authorizeVendor($request, $vendor, 'update');
        $vendor->update($request->validated());

        return redirect()
            ->route('dashboard.vendors.show', $vendor)
            ->with('success', 'Vendor details updated successfully.');
    }

    public function updateStatus(VendorStatusRequest $request, Admin $vendor): RedirectResponse
    {
        $this->authorizeVendor($request, $vendor, 'updateStatus');
        $status = $request->validated('status');

        DB::transaction(function () use ($vendor, $status): void {
            $vendor->forceFill(['status' => $status])->save();

            if ($vendor->store) {
                $vendor->store->forceFill([
                    'status' => $status === Admin::STATUS_ACTIVE
                        ? \App\Models\Store::STATUS_ACTIVE
                        : \App\Models\Store::STATUS_REJECTED,
                ])->save();
            }
        });

        return back()->with('success', 'Vendor and store status updated successfully.');
    }

    private function authorizeVendor(Request $request, Admin $vendor, string $ability): void
    {
        abort_unless($vendor->isVendor(), 404);
        Gate::forUser($request->user('admin'))->authorize($ability, $vendor);
    }
}
