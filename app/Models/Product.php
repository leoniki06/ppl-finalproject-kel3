<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'description', 'image_url', 'price', 'original_price',
        'category', 'rating', 'rating_count', 'discount_percent', 'expiry_date',
        'stock', 'is_flash_sale', 'is_recommended', 'seller_id'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    // Relasi dengan seller (user)
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Scope untuk produk yang masih tersedia
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0)
                    ->where('expiry_date', '>', now());
    }

    // Hitung impact wasting food
    public function calculateImpact()
    {
        // Misal: setiap pembelian menyelamatkan 1kg CO2
        return [
            'co2_saved' => 1.5, // kg CO2
            'water_saved' => 500, // liter air
            'food_saved' => 1, // kg makanan
        ];
    }
}
