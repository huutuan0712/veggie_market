<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use SoftDeletes;

    protected $table = 'payments';
    protected $fillable = ['order_id', 'payment_method', 'transaction_id', 'amount', 'status', 'paid_at'];

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
