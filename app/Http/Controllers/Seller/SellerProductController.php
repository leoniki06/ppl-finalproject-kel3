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

        // kalau sellerId null, lebih baik jelas daripada hasil kosong
        if (!$sellerId) {
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        $q    = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'latest');

        $products = Product::query()
            ->where('seller_id', $sellerId)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%")
                        ->orWhere('brand', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->when(true, function ($query) use ($sort) {
                return match ($sort) {
                    'name_asc'   => $query->orderBy('name', 'asc'),
                    'name_desc'  => $query->orderBy('name', 'desc'),
                    'price_asc'  => $query->orderBy('price', 'asc'),
                    'price_desc' => $query->orderBy('price', 'desc'),
                    default      => $query->latest(),
                };
            })
            ->paginate(10)
            ->withQueryString();

        return view('seller.products.index', compact('products', 'q', 'sort'));
    }

    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        // ✅ pastikan login
        $sellerId = Auth::id();
        if (!$sellerId) {
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login sebagai seller terlebih dahulu.']);
        }

        // ✅ validasi: checkbox jangan boolean strict (biar tidak gagal karena format input)
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

            'is_flash_sale' => 'nullable',
            'is_recommended' => 'nullable',

            'image' => 'required|image|max:2048',
        ]);

        // ✅ upload image
        try {
            $path = $request->file('image')->store('products', 'public');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors(['image' => 'Upload gambar gagal. Pastikan sudah menjalankan: php artisan storage:link dan folder storage writable.']);
        }

        // ✅ create product
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

            'is_flash_sale' => $request->boolean('is_flash_sale'),
            'is_recommended' => $request->boolean('is_recommended'),

            'is_active' => true,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sellerId = Auth::id();
        if (!$sellerId) {
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        $product = Product::where('seller_id', $sellerId)->findOrFail($id);
        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $sellerId = Auth::id();
        if (!$sellerId) {
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        $product = Product::where('seller_id', $sellerId)->findOrFail($id);

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

            'is_flash_sale' => 'nullable',
            'is_recommended' => 'nullable',

            'image' => 'nullable|image|max:2048',
        ]);

        // ✅ kalau upload gambar baru
        if ($request->hasFile('image')) {
            try {
                if ($product->image_url) {
                    Storage::disk('public')->delete($product->image_url);
                }
                $product->image_url = $request->file('image')->store('products', 'public');
            } catch (\Throwable $e) {
                return back()
                    ->withInput()
                    ->withErrors(['image' => 'Upload gambar baru gagal. Pastikan storage sudah benar.']);
            }
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

            'is_flash_sale' => $request->boolean('is_flash_sale'),
            'is_recommended' => $request->boolean('is_recommended'),
        ]);

        $product->save();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy($id)
    {
        $sellerId = Auth::id();
        if (!$sellerId) {
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        $product = Product::where('seller_id', $sellerId)->findOrFail($id);

        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $sellerId = Auth::id();
        if (!$sellerId) {
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        $product = Product::where('seller_id', $sellerId)->findOrFail($id);

        $product->is_active = ! (bool) $product->is_active;
        $product->save();

        return back()->with('success', 'Status produk diubah jadi ' . ($product->is_active ? 'Aktif' : 'Nonaktif') . '.');
    }
}
