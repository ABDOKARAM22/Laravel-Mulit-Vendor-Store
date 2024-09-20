<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name' , 'description','image','status','parent_id','slug'];

    static function CategoriesVlaidate($id=0){
        return [
            'name' => "required|string|min:3|max:255|unique:categories,name,$id",
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status'=> 'required|in:Active,Archived',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    static function ScopeFilters(Builder $query, $filters){

        if( isset($filters['name']) ) {
            $query->where("categories.name","like","%{$filters['name']}%");
        }
        if( isset($filters['status']) && $filters['status'] != null) {
            $query->where('categories.status','=',$filters['status']);
        }

    }

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }

}