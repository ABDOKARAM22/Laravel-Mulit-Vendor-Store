<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $admin = $request->user('admin');

        if ($admin->isVendor()) {
            $orderQuery = Order::where('store_id', $admin->store_id);
            $productQuery = Product::where('store_id', $admin->store_id);

            $stats = [
                'totalOrders' => (clone $orderQuery)->count(),

                'pendingOrders' => (clone $orderQuery)
                    ->where('status', Order::STATUS_PENDING)
                    ->count(),

                'totalProducts' => (clone $productQuery)->count(),

                'totalSales' => (clone $orderQuery)
                    ->where('status', Order::STATUS_COMPLETED)
                    ->sum('total'),
            ];

            return view('Dashboard.index', compact('admin', 'stats'));
        }

        $stats = [
            'totalOrders' => Order::count(),

            'pendingOrders' => Order::where(
                'status',
                Order::STATUS_PENDING
            )->count(),

            'totalProducts' => Product::count(),

            'totalCustomers' => User::count(),

            'totalCategories' => Category::count(),

            'totalSales' => Order::where(
                'status',
                Order::STATUS_COMPLETED
            )->sum('total'),
        ];

        return view('Dashboard.index', compact('admin', 'stats'));
    }
}