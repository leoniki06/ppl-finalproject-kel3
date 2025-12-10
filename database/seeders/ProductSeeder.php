<?php
// database/seeders/ProductSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->delete();

        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Roti Sisir Cream Cheese Premium',
                'brand' => 'Holland Bakery',
                'description' => 'Roti sisir dengan isian cream cheese premium dari Jerman. Terbuat dari bahan-bahan pilihan dengan tekstur lembut dan rasa yang nikmat. Cocok untuk sarapan atau camilan sehat. Pack isi 4 pcs.',
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'price' => 20000,
                'original_price' => 35000,
                'category' => 'bakery',
                'rating' => 4.5,
                'rating_count' => 3200,
                'discount_percent' => 43,
                'expiry_date' => Carbon::now()->addDays(2),
                'stock' => 50,
                'is_flash_sale' => true,
                'is_recommended' => true,
                'seller_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Fresh Milk Premium 1L',
                'brand' => 'Greenfields Dairy',
                'description' => 'Susu segar murni 1 liter dengan kualitas premium. Diproduksi dari sapi-sapi sehat dengan standar sanitasi tinggi. Mengandung kalsium, vitamin D, dan protein yang baik untuk tulang dan kesehatan tubuh.',
                'image_url' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'price' => 28000,
                'original_price' => 38000,
                'category' => 'dairy',
                'rating' => 4.6,
                'rating_count' => 4200,
                'discount_percent' => 26,
                'expiry_date' => Carbon::now()->addDays(5),
                'stock' => 30,
                'is_flash_sale' => false,
                'is_recommended' => true,
                'seller_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Organic Apples Fuji 1kg',
                'brand' => 'Farm Fresh Organics',
                'description' => 'Apel Fuji organik segar langsung dari petani lokal. Ditanam tanpa pestisida dan bahan kimia berbahaya. Rasa manis alami dengan tekstur renyah yang segar. Cocok untuk diet sehat dan camilan sehari-hari.',
                'image_url' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'price' => 32000,
                'original_price' => 48000,
                'category' => 'fruits',
                'rating' => 4.8,
                'rating_count' => 5200,
                'discount_percent' => 33,
                'expiry_date' => Carbon::now()->addDays(7),
                'stock' => 40,
                'is_flash_sale' => true,
                'is_recommended' => false,
                'seller_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Chicken Breast Fillet 500g',
                'brand' => 'Best Chicken Farm',
                'description' => 'Dada ayam fillet premium tanpa tulang dan kulit. Daging ayam segar dari peternakan terpercaya dengan standar kualitas tinggi. Kaya akan protein dan rendah lemak, cocok untuk menu diet dan olahraga.',
                'image_url' => 'https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'price' => 38000,
                'original_price' => 52000,
                'category' => 'meat',
                'rating' => 4.6,
                'rating_count' => 3800,
                'discount_percent' => 27,
                'expiry_date' => Carbon::now()->addDays(3),
                'stock' => 25,
                'is_flash_sale' => false,
                'is_recommended' => true,
                'seller_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $this->command->info('✅ 4 products created!');
    }
}
