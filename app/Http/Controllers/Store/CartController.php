<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public $cart;

    public function __construct(CartModelRepository $cart) {
        $this->cart = $cart;
    }

    public function index()
    {
        return view('store.cart', ['cart' => $this->cart] );   
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $this->cart->add($product,$request->post('quantity'));

        return redirect()->route('cart.index')->with('success','Product Added Successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $this->cart->update($product,$request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cart->delete($id);
    }
}
