<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'address',        // aktifkan kalau kolomnya sudah ada di DB
        'profile_photo',  // aktifkan kalau kolomnya sudah ada di DB
        'company_based',
        'industry',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }


    // Optional: biar tetap kompatibel kalau kamu udah terlanjur pakai nama isBuyer() di banyak tempat
    public function isBuyer(): bool
    {
        return $this->isCustomer();
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if (!empty($this->profile_photo)) {
            return asset('storage/profile-photos/' . $this->profile_photo);
        }

        $initial = strtoupper(substr($this->name, 0, 1));
        $colors = ['#3F2305', '#6E3F0C', '#2A1703', '#FF9F1C', '#FF4757'];
        $color = $colors[ord($initial) % count($colors)];

        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) .
            "&color=FFFFFF&background=" . substr($color, 1) .
            "&size=200&bold=true&font-size=0.8";
    }
}
