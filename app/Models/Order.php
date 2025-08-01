<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'order_number',
        'discount_amount',
        'amount',
        'status',
        'total_amount',
        'shipping_fee',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_province',
        'shipping_district',
        'shipping_ward',
        'payment_method',
        'paid_at',
        'notes'
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_SHIPPED = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_CANCELLED = 4;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
