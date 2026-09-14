<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository{
    
    public $items;

    public function __construct() {
        $this->items = collect([]);
    }

    public function get() :Collection{

        if(! $this->items->count()){
            $this->items = Cart::with('product')->get();
        }
        return $this->items;
    }

    public function add(Product $product , $quantity = 1){
        $quantity = max(1, (int) $quantity);

        $item = cart::where('product_id','=',$product->id)->first();

        if(! $item){

            $cart = Cart::create([
                'cookie_id' => Cart::get_cookie_id(),
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);

            $this->get()->push($cart);
            return $cart;
        }
        
       return $item->increment('quantity',$quantity); 

    }

    public function update($id ,$quantity){
        Cart::whereKey($id)->update(['quantity'=>max(1, (int) $quantity)]);
        
    }
    
    public function delete($id){
        Cart::findOrFail($id)->delete();
    }
    
    public function empty(?array $ids = null){
        $query = Cart::query();

        if ($ids !== null) {
            $query->whereIn('id', $ids);
        }

        $query->delete();
    }
    
    public function total() : float{
        
    return (float) Cart::join('products', 'products.id' ,'=','carts.product_id')
    ->selectRaw('SUM(products.price * carts.quantity) as total')
    ->value('total');

    }


}