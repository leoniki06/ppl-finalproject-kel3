<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = Auth::id();
        $q = $request->query('q');
        $sort = $request->query('sort', 'latest');

        $products = Product::query()
            ->where('seller_id', $sellerId)
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%")
                        ->orWhere('brand', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->when($sort, function ($query) use ($sort) {
                return match ($sort) {
                    'name_asc' => $query->orderBy('name', 'asc'),
                    'name_desc' => $query->orderBy('name', 'desc'),
                    'price_asc' => $query->orderBy('price', 'asc'),
                    'price_desc' => $query->orderBy('price', 'desc'),
                    default => $query->latest(),
                };
            })
            ->paginate(10)
            ->withQueryString();

        return view('seller.products.index', compact('products', 'q', 'sort'));


    }
    public function create()
{
    return view('seller.products.create'); // ✅ ini harus sesuai lokasi file blade
}



    public function store(Request $request)
    {
        $sellerId = Auth::id();

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'brand' => 'required|string|max:120',
            'category' => 'required|string|max:80',
            'description' => 'required|string|max:2000',

            'price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',

            'expiry_date' => 'required|date',
            'stock' => 'required|integer|min:0',

            'is_flash_sale' => 'nullable|boolean',
            'is_recommended' => 'nullable|boolean',


            // image_url kita isi dari upload file biar aman
            'image' => 'required|image|max:2048',
        ]);


        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'seller_id' => $sellerId,
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'category' => $validated['category'],
            'description' => $validated['description'],

            'image_url' => $path,

            'price' => $validated['price'],
            'original_price' => $validated['original_price'],
            'discount_percent' => $validated['discount_percent'] ?? 0,

            'expiry_date' => $validated['expiry_date'],
            'stock' => $validated['stock'],

            'is_flash_sale' => (bool) ($request->input('is_flash_sale') ?? false),
            'is_recommended' => (bool) ($request->input('is_recommended') ?? false),

            'is_active' => true,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);
        return view('seller.products.edit', compact('product'));
    }


    public function update(Request $request, $id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'brand' => 'required|string|max:120',
            'category' => 'required|string|max:80',
            'description' => 'required|string|max:2000',

            'price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',

            'expiry_date' => 'required|date',
            'stock' => 'required|integer|min:0',

            'is_flash_sale' => 'nullable|boolean',
            'is_recommended' => 'nullable|boolean',

            // edit boleh tidak upload image
            'image' => 'nullable|image|max:2048',
        ]);

        // ✅ kalau upload gambar baru, hapus yg lama lalu simpan yg baru
        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $product->image_url = $request->file('image')->store('products', 'public');
        }

        $product->fill([
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'category' => $validated['category'],
            'description' => $validated['description'],

            'price' => $validated['price'],
            'original_price' => $validated['original_price'],
            'discount_percent' => $validated['discount_percent'] ?? 0,

            'expiry_date' => $validated['expiry_date'],
            'stock' => $validated['stock'],

            'is_flash_sale' => (bool) $request->boolean('is_flash_sale'),
            'is_recommended' => (bool) $request->boolean('is_recommended'),
        ])->save();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);

        if ($product->image_url) Storage::disk('public')->delete($product->image_url);

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);
        $product->is_active = ! $product->is_active;
        $product->save();

        return back()->with('success', 'Status produk diubah jadi ' . ($product->is_active ? 'Aktif' : 'Nonaktif') . '.');
    }
}
