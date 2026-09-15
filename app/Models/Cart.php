<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    public $fillable = ['cookie_id','user_id','product_id','options','quantity'];

    
    public static function get_cookie_id(){

        $cookie_id = Cookie::get('cart_id');

        if(!$cookie_id){

            $cookie_id = Str::uuid();
            cookie::queue('cart_id',$cookie_id, 30 * 24 * 60 );
        }

        return $cookie_id;
    }
    

    protected static function booted()
    {
        static::creating(function(Cart $cart){

            $cart->id = Str::uuid();
            $cart->cookie_id = Cart::get_cookie_id();

        });


        static::addGlobalScope('cookie_id',function(Builder $builder){
                $builder->where('cookie_id', Cart::get_cookie_id());

                $user = Auth::guard('web')->user();
                if ($user) {
                    $builder->where('user_id', $user->id);
                }
        });
    }

    public static function claimGuestCartForUser(int $userId): void
    {
        $cookieId = static::get_cookie_id();

        static::withoutGlobalScopes()
            ->where('cookie_id', $cookieId)
            ->whereNull('user_id')
            ->update(['user_id' => $userId]);
    }

    public static function releaseCartForGuest(): void
    {
        static::withoutGlobalScopes()
            ->where('cookie_id', static::get_cookie_id())
            ->where('user_id', Auth::guard('web')->id())
            ->update(['user_id' => null]);
    }

    public function user()  {
        return $this->belongsTo(User::class)->withDefault(['name'=>'unknown']);
    }

    public function product(){
        return $this->belongsTo(product::class);
    }


}
