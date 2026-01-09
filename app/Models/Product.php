<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
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
        'is_recommended',
        'is_active',
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
        'is_recommended' => 'boolean',
        'is_active' => 'boolean',
        'expiry_date' => 'date',
    ];

    // ✅ dipakai dashboard: $product->expiry_days (tanpa kolom DB)
    public function getExpiryDaysAttribute(): int
    {
        if (!$this->expiry_date) return 0;

        $today = now()->startOfDay();
        $expiry = Carbon::parse($this->expiry_date)->startOfDay();

        if ($expiry->lt($today)) return 0;
        return $today->diffInDays($expiry);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * ✅ Pakai ini di Blade: {{ $product->image_full_url }}
     */
    protected $appends = ['image_full_url'];

    public function getImageFullUrlAttribute(): ?string
    {
        return $this->resolveImageUrlFromDb($this->image_url);
    }

    /**
     * Resolver URL gambar dari DB -> URL publik yang benar.
     * Mendukung:
     * - URL full: https://...
     * - "storage/products/..." atau "/storage/products/..."
     * - "public/products/..."
     * - "products/...." (seperti DB kamu)
     * - "filename.jpg" (opsional)
     *
     * Prioritas:
     * 1) Jika file ada di public/<path> -> pakai /<path>
     * 2) Jika file ada di storage/app/public/<path> -> pakai /storage/<path>
     */
    private function resolveImageUrlFromDb(?string $path): ?string
    {
        $path = trim((string) $path);
        if ($path === '') return null;

        // 1) kalau sudah URL penuh
        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }

        // rapihin
        $path = ltrim($path, '/');

        // 2) kalau sudah "storage/..."
        if (Str::startsWith($path, 'storage/')) {
            // ini sudah URL publik style
            return asset($path);
        }

        // 3) kalau "public/..." -> buang prefix public/
        if (Str::startsWith($path, 'public/')) {
            $path = Str::after($path, 'public/');
        }

        // 4) kalau cuma filename doang (optional)
        if (!Str::contains($path, '/')) {
            $path = 'products/' . $path; // asumsi folder products
        }

        // === KUNCI PERBAIKAN: cek 2 lokasi file ===

        // A) cek di folder public/
        // contoh: public/products/xxxx.jpg -> akses /products/xxxx.jpg
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // B) cek di storage/app/public/
        // contoh: storage/app/public/products/xxxx.jpg -> akses /storage/products/xxxx.jpg
        if (file_exists(storage_path('app/public/' . $path))) {
            return asset('storage/' . $path);
        }

        // Kalau tidak ketemu di dua tempat: null (tanpa dummy)
        return null;
    }
}
