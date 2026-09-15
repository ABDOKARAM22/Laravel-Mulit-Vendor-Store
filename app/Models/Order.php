<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_DELIVERING = 'delivering';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PROCESSING,
        self::STATUS_DELIVERING,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    public const TRANSITIONS = [
        self::STATUS_PENDING => [self::STATUS_PROCESSING, self::STATUS_CANCELLED],
        self::STATUS_PROCESSING => [self::STATUS_DELIVERING, self::STATUS_CANCELLED],
        self::STATUS_DELIVERING => [self::STATUS_COMPLETED],
        self::STATUS_COMPLETED => [],
        self::STATUS_CANCELLED => [],
    ];

    protected $fillable = [
        'number',
        'payment_method',
        'status',
        'payment_status',
        'shipping',
        'tax',
        'discount',
        'subtotal',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'shipping' => 'decimal:2',
            'tax' => 'decimal:2',
            'discount' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    
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

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function canTransitionTo(string $status): bool
    {
        return in_array($status, self::TRANSITIONS[$this->status] ?? [], true);
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

        return DB::transaction(function () use ($year) {
            $sequence = DB::table('order_number_sequences')
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                DB::table('order_number_sequences')->insertOrIgnore([
                    'year' => $year,
                    'next_number' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $sequence = DB::table('order_number_sequences')
                    ->where('year', $year)
                    ->lockForUpdate()
                    ->first();
            }

            $number = (int) $sequence->next_number;

            DB::table('order_number_sequences')
                ->where('year', $year)
                ->update([
                    'next_number' => $number + 1,
                    'updated_at' => now(),
                ]);

            return $year . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
        });
    }
}
