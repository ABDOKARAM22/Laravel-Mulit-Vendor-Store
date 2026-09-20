<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'Pending';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_INACTIVE = 'Inactive';
    public const STATUS_REJECTED = 'Rejected';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_image',
        'cover_image',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function vendor()
    {
        return $this->hasOne(Admin::class)
            ->where('role', Admin::ROLE_VENDOR);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}