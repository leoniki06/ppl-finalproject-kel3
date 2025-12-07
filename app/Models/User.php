<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_photo', // Tambahkan ini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Cek jika user adalah pembeli
     */
    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    /**
     * Cek jika user adalah penjual
     */
    public function isSeller()
    {
        return $this->role === 'seller';
    }

    /**
     * Get URL foto profil
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/profile-photos/' . $this->profile_photo);
        }

        // Default avatar berdasarkan initial nama
        $initial = strtoupper(substr($this->name, 0, 1));
        $colors = ['#3F2305', '#6E3F0C', '#2A1703', '#FF9F1C', '#FF4757'];
        $color = $colors[ord($initial) % count($colors)];

        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) .
            "&color=FFFFFF&background=" . substr($color, 1) .
            "&size=200&bold=true&font-size=0.8";
    }
}
