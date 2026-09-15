<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $admin = $request->user('admin');
        Gate::forUser($admin)->authorize('viewAny', Order::class);

        $query = Order::with('store')->latest();
        if ($admin->isVendor()) {
            $query->where('store_id', $admin->store_id);
        }

        $orders = $query->paginate(15);

        return view('Dashboard.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        Gate::forUser(request()->user('admin'))->authorize('view', $order);
        $order->load(['store', 'user', 'items', 'billingAddress', 'shippingAddress']);

        return view('Dashboard.orders.show', compact('order'));
    }

    public function updateStatus(OrderStatusRequest $request, Order $order)
    {
        $order->update(['status' => $request->validated('status')]);

        return back()->with('success', 'Order status updated successfully.');
    }
}
