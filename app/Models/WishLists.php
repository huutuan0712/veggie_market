<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishLists extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
