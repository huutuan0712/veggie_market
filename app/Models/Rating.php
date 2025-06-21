<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->belongsTo(Product::class);
    }

}
