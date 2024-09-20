<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Product extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable  = ['name','category_id','store_id','slug','description','image','options','price','rating','featured','status'];

    protected static function booted()
    {
        static::addGlobalScope('scope',function (Builder $builder){
            $user = Auth::user();
            if($user->store_id){
                $builder->where('store_id','=', $user->store_id);
            }
        });
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function tags(){
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
    }
}
