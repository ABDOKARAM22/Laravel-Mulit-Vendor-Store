<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'user_id',
        'number',
        'payment_method',
        'status',
        'payment_status',
    ];

    
    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id','id','id')
        ->using(OrderItem::class)
        ->withPivot(['product_name','price','quantity','options']);
    }

    public function addresses(){

        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress(){

        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','=','billing');
    }

    public function shippingAddress(){

        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','=','shipping');
    }

    protected static function booted()
    {
        static::creating(function(Order $order){
            $order->number = Order::GetNextOrderNumber();
        });
    }

    public static function GetNextOrderNumber(){
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at',$year)->max('number');

        if($number){
            return $number + 1 ;
        }

        return $year . '0001';
    }
}
