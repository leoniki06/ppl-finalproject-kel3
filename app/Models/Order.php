<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'seller_id',
        'total_amount',
        'status',
        'shipping_address',
        'payment_method',
        'payment_status',
        'processed_at',
        'shipped_at',
        'completed_at',
        'paid_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
