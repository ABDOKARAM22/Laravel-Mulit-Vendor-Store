<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartModelRepository $cart
    ) {
    }

    public function index()
    {
        return view('store.cart', [
            'cart' => $this->cart,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::query()
            ->where('status', 'Active')
            ->findOrFail($validated['product_id']);

        $this->cart->add(
            $product,
            $validated['quantity'] ?? 1
        );

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product Added Successfully.');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'action' => ['required', 'in:plus,minus'],
        ]);

        $quantity = $validated['quantity'];

        if ($validated['action'] === 'plus') {
            $quantity++;
        } elseif ($validated['action'] === 'minus') {
            $quantity = max(1, $quantity - 1);
        }

        $this->cart->update($id, $quantity);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart updated successfully!');
    }

    public function destroy(string $id)
    {
        $this->cart->delete($id);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product Deleted Successfully.');
    }
}