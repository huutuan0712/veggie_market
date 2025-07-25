<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = ['name', 'slug', 'description', 'category_id', 'price', 'original_price', 'stock', 'status', 'featured', 'unit', 'benefits'];

    protected $casts = [
        'status' => \App\Enums\ProductStatus::class,
        'benefits' => 'array',
        'featured' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
