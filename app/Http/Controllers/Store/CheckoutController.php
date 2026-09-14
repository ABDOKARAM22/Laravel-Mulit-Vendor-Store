<?php

namespace App\Http\Controllers\Store;

use App\Events\OrderCreated;
use App\Http\Requests\CheckoutRequest;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function create(CartModelRepository $cart){
        if($cart->get()->count() == 0){
            return redirect()->route('cart.index');
        }
        return view('store.checkout', [ 
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(CheckoutRequest $request, CartModelRepository $cart)
    {
        $orders = DB::transaction(function () use ($request, $cart) {
            $cartItems = Cart::with('product')->lockForUpdate()->get();

            if ($cartItems->isEmpty()) {
                return collect();
            }

            $lockedItems = $cartItems->map(function ($cartItem) {
                $product = Product::whereKey($cartItem->product_id)
                    ->where('status', 'Active')
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($cartItem->quantity > $product->quantity) {
                    abort(422, "Insufficient stock for {$product->name}.");
                }

                return compact('cartItem', 'product');
            });

            $orders = $lockedItems->groupBy(fn ($item) => $item['product']->store_id)
                ->map(function ($storeItems, $storeId) use ($request) {
                    $totalCents = $storeItems->sum(
                        fn ($item) => $this->moneyToCents($item['product']->price) * $item['cartItem']->quantity
                    );

                    $order = Order::create([
                        'store_id' => $storeId,
                        'user_id' => $request->user('web')?->id,
                        'payment_method' => 'cod',
                        'shipping' => 0,
                        'tax' => 0,
                        'discount' => 0,
                        'total' => $totalCents / 100,
                    ]);

                    foreach ($storeItems as $item) {
                        $product = $item['product'];
                        $cartItem = $item['cartItem'];

                        $order->products()->attach($product->id, [
                            'product_name' => $product->name,
                            'price' => $this->moneyToCents($product->price) / 100,
                            'quantity' => $cartItem->quantity,
                            'options' => $cartItem->options,
                        ]);

                        $product->decrement('quantity', $cartItem->quantity);
                    }

                    foreach ($request->validated('addr') as $type => $address) {
                        $order->addresses()->create([...$address, 'type' => $type]);
                    }

                    return $order;
                })->values();

            $cart->empty($cartItems->pluck('id')->all());

            return $orders;
        });

        if ($orders->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $orders->each(fn (Order $order) => event(new OrderCreated($order)));

        return redirect()->route('home')->with('success', 'Order placed successfully.');
    }

    private function moneyToCents(string|float|int $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }
}
