<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    /**
     * List products
     */
    public function index()
{
    // Dummy data SUPER LENGKAP (semua field yang biasa dipakai blade)
    $products = [
        [
            'id' => 1,
            'name' => 'Nasi Goreng',
            'category' => 'food',
            'price' => 20000,
            'stock' => 12,
            'active' => true,
            'image_url' => null,
            'is_flash_sale' => true,   // ✅ INI yang bikin error tadi
        ],
        [
            'id' => 2,
            'name' => 'Es Teh',
            'category' => 'drink',
            'price' => 5000,
            'stock' => 2,
            'active' => true,
            'image_url' => null,
            'is_flash_sale' => false,
        ],
        [
            'id' => 3,
            'name' => 'Roti Bakar',
            'category' => 'snack',
            'price' => 15000,
            'stock' => 0,
            'active' => false,
            'image_url' => null,
            'is_flash_sale' => false,
        ],
    ];

    // ✅ Default field list (kalau nanti ada item yang kurang fieldnya, otomatis diisi)
    $defaults = [
        'id' => 0,
        'name' => '-',
        'category' => '-',
        'price' => 0,
        'stock' => 0,
        'active' => true,
        'image_url' => null,
        'is_flash_sale' => false,
    ];

    // ✅ Paksa setiap item punya field lengkap + jadi object (biar blade $p->xxx aman)
    $products = collect($products)->map(function ($p) use ($defaults) {
        $p = array_merge($defaults, $p);  // isi yang kurang
        return (object) $p;
    });

    return view('seller.products', [
        'products' => $products,
        'sort' => request('sort'),
        'q' => request('q'),
    ]);
}



    /**
     * Form create product
     */
    public function create()
    {
        return view('seller.product-create');
    }

    /**
     * Simpan product (dummy)
     */
    public function store(Request $request)
    {
        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Product berhasil ditambahkan (dummy)');
    }

    /**
     * Form edit product
     */
    public function edit($id)
    {
        return view('seller.product-edit', compact('id'));
    }

    /**
     * Update product (dummy)
     */
    public function update(Request $request, $id)
    {
        return redirect()
            ->route('seller.products.index')
            ->with('success', "Product ID $id berhasil diupdate (dummy)");
    }

    /**
     * Delete product (dummy)
     */
    public function destroy($id)
    {
        return redirect()
            ->route('seller.products.index')
            ->with('success', "Product ID $id berhasil dihapus (dummy)");
    }

    /**
     * Toggle status product (dummy)
     */
    public function toggleStatus($id)
    {
        return back()->with('success', "Status product ID $id diubah (dummy)");
    }
}
