<?php

namespace App\Http\Controllers\Store;

use App\Events\OrderCreated;
use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

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

    public function store(Request $request , CartModelRepository $cart){

        // $request->validate();

        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try{
            
            foreach($items as $store_id => $cart_items){
                
                    $order = Order::create([
                        'store_id' => $store_id,
                        'user_id' => Auth::id(),
                        'payment_method' => 'cod',
                    ]);
                    
                    foreach($cart_items as $item){
                        
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'product_name' => $item->product->name,
                            'price' => $item->product->price,
                            'quantity' => $item->quantity,
                        ]);
                    }
                    
                    foreach ($request->post('addr') as $type => $address){
                        
                        $address['type'] = $type;
                        $order->addresses()->create($address);
                    }

        }

        DB::commit();
        event(new OrderCreated($order));

    }catch(Throwable $e){

        DB::rollBack();

        throw $e;
    }
        
    }
}
