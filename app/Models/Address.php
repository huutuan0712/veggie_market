<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'shipping_addresses';
    protected $fillable = ['user_id', 'full_name', 'phone', 'province', 'district', 'ward', 'address', 'default'];
}
