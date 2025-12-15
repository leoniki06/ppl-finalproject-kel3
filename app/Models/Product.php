<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'discount_percent',
        'category',
        'brand',
        'stock',
        'image_url',
        'rating',
        'rating_count',
        'is_flash_sale',
        'expiry_date',
    ];

    protected $casts = [
        'price' => 'integer',
        'original_price' => 'integer',
        'discount_percent' => 'integer',
        'stock' => 'integer',
        'rating' => 'decimal:1',
        'rating_count' => 'integer',
        'is_flash_sale' => 'boolean',
        'expiry_date' => 'datetime',
    ];

    /**
     * Relationship dengan Cart
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relationship dengan OrderItem
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
