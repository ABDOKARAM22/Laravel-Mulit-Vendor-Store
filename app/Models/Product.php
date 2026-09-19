<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory , SoftDeletes;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
        ];
    }

    protected $fillable  = ['name','category_id','description','image','options','price','rating','featured','status'];

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }


    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when(
            $search,
            fn (Builder $query) => $query->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
        );
    }


    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $query->when(
            $category,
            fn (Builder $query) => $query->whereHas(
                'category',
                fn (Builder $query) => $query
                    ->where('slug', $category)
                    ->where('status', 'Active')
            )
        );
    }


    public function scopeTag(Builder $query, ?string $tag): Builder
    {
        return $query->when(
            $tag,
            fn (Builder $query) => $query->whereHas(
                'tags',
                fn (Builder $query) => $query->where('slug', $tag)
            )
        );
    }

    public function scopeSortBy(Builder $query, ?string $sort): Builder
    {
        return $query->when(
            $sort,
            function (Builder $query) use ($sort) {
                match ($sort) {
                    'newest' => $query->latest(),
                    'price_low' => $query->orderBy('price', 'asc'),
                    'price_high' => $query->orderBy('price', 'desc'),
                    'featured' => $query->where('featured', true),
                    default => $query->latest(),
                };
            }
        );
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
