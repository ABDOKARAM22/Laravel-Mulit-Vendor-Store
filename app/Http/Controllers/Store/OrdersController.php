<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $customer = $request->user('web');
        Gate::forUser($customer)->authorize('viewCustomerOrders', [Order::class]);

        $orders = Order::with('store')->where('user_id', $customer->id)->latest()->paginate(10);

        return view('store.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        Gate::forUser($request->user('web'))->authorize('view', $order);
        $order->load(['store', 'items', 'billingAddress', 'shippingAddress']);

        return view('store.orders.show', compact('order'));
    }
}
