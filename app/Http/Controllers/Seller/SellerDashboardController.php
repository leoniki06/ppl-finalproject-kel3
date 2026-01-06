<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\Order;
use Carbon\Carbon;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();

        if (!$seller || $seller->role !== 'seller') {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak. Halaman ini khusus seller.');
        }

        $sellerId = $seller->id;

        $store = Store::where('user_id', $sellerId)->first();
        if (!$store) {
            $store = $this->createDefaultStore($seller);
        }

        $storeData = [
            'name' => $store->name ?? 'Toko ' . $seller->name,
            'logo_url' => $store->logo_url ?? 'https://via.placeholder.com/150',
            'is_open' => $store->is_open ?? true,
            'rating' => $store->rating ?? 4.5,
            'address' => $store->address ?? 'Alamat belum diisi',
            'today_hours' => $store->operational_hours ?? '08:00 - 22:00',
        ];

        $storeHealth       = $this->getStoreHealth($sellerId);
        $stats             = $this->getOrderStatistics($sellerId);
        $orderStatusCounts = $this->getOrderStatusCounts($sellerId);
        $recentOrders      = $this->getRecentOrders($sellerId);

        $additionalStats = [
            'total_revenue' => $this->calculateTotalRevenue($sellerId),
            'average_order_value' => $this->calculateAverageOrderValue($sellerId),
            'customer_count' => $this->getCustomerCount($sellerId),
        ];

        $quickActions = [
            [
                'title' => 'Tambah Produk',
                'description' => 'Tambah produk baru ke toko Anda',
                'icon' => 'fas fa-plus-circle',
                'color' => 'success'
            ],
            [
                'title' => 'Kelola Pesanan',
                'description' => 'Lihat dan kelola semua pesanan',
                'icon' => 'fas fa-clipboard-list',
                'color' => 'primary'
            ],
            [
                'title' => 'Analisis Penjualan',
                'description' => 'Lihat laporan penjualan',
                'icon' => 'fas fa-chart-line',
                'color' => 'info'
            ],
            [
                'title' => 'Pengaturan Toko',
                'description' => 'Ubah informasi toko',
                'icon' => 'fas fa-store',
                'color' => 'warning'
            ],
        ];

        return view('seller.SellerDashboard', compact(
            'storeData',
            'storeHealth',
            'stats',
            'orderStatusCounts',
            'recentOrders',
            'additionalStats',
            'quickActions',
            'seller'
        ));
    }

    private function createDefaultStore($seller)
    {
        return Store::create([
            'user_id' => $seller->id,
            'name' => 'Toko ' . $seller->name,
            'slug' => 'toko-' . strtolower(str_replace(' ', '-', $seller->name)),
            'description' => 'Toko makanan dan minuman',
            'address' => 'Alamat belum diisi',
            'is_open' => true,
            'rating' => 4.5,
            'operational_hours' => '08:00 - 22:00',
        ]);
    }

    private function getStoreHealth($sellerId)
    {
        try {
            $lowStockProducts = \App\Models\Product::where('seller_id', $sellerId)
                ->where('stock', '<', 5)
                ->count();

            $pendingOrders = Order::where('seller_id', $sellerId)
                ->where('status', 'pending')
                ->count();

            if ($lowStockProducts > 10 || $pendingOrders > 20) {
                return ['label' => 'Perlu Perhatian', 'level' => 'danger'];
            } elseif ($lowStockProducts > 5 || $pendingOrders > 10) {
                return ['label' => 'Perlu Monitor', 'level' => 'warning'];
            } else {
                return ['label' => 'Semua Berjalan Baik', 'level' => 'good'];
            }
        } catch (\Exception $e) {
            return ['label' => 'Data sedang diproses', 'level' => 'info'];
        }
    }

    private function getOrderStatistics($sellerId)
    {
        try {
            return [
                'today' => Order::where('seller_id', $sellerId)
                    ->whereDate('created_at', Carbon::today())
                    ->count(),

                'week' => Order::where('seller_id', $sellerId)
                    ->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])
                    ->count(),

                'month' => Order::where('seller_id', $sellerId)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count(),

                'today_change' => 0,
                'week_change' => 0,
                'month_change' => 0,
            ];
        } catch (\Exception $e) {
            return [
                'today' => 0,
                'week' => 0,
                'month' => 0,
                'today_change' => 0,
                'week_change' => 0,
                'month_change' => 0,
            ];
        }
    }

    private function getOrderStatusCounts($sellerId)
    {
        try {
            return [
                'pending' => Order::where('seller_id', $sellerId)->where('status', 'pending')->count(),
                'processing' => Order::where('seller_id', $sellerId)->where('status', 'processing')->count(),
                'completed' => Order::where('seller_id', $sellerId)->where('status', 'completed')->count(),
                'cancelled' => Order::where('seller_id', $sellerId)->where('status', 'cancelled')->count(),
            ];
        } catch (\Exception $e) {
            return [
                'pending' => 0,
                'processing' => 0,
                'completed' => 0,
                'cancelled' => 0,
            ];
        }
    }

    private function getRecentOrders($sellerId)
    {
        try {
            $orders = Order::where('seller_id', $sellerId)
                ->with(['user', 'items'])
                ->withCount('items')
                ->latest()
                ->take(5)
                ->get();

            return $orders->map(function ($order) {
                $calculatedTotal = $order->items->sum(function ($item) {
                    return ($item->price ?? 0) * ($item->quantity ?? 1);
                });

                $finalTotal = ($order->total_amount && $order->total_amount > 0)
                    ? $order->total_amount
                    : $calculatedTotal;

                return (object) [
                    'id' => $order->id,
                    'order_number' => $order->order_number ?? 'ORD-' . $order->id,
                    'customer_name' => $order->user->name ?? 'Pelanggan',
                    'total_amount' => $finalTotal,
                    'status' => $order->status ?? 'pending',
                    'items_count' => $order->items_count ?? 0,
                    'created_at' => $order->created_at ?? now(),
                ];
            });
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function calculateTotalRevenue($sellerId)
    {
        try {
            return Order::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->sum('total_amount');
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function calculateAverageOrderValue($sellerId)
    {
        try {
            $completedCount = Order::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->count();

            if ($completedCount === 0) return 0;

            $totalRevenue = $this->calculateTotalRevenue($sellerId);
            return round($totalRevenue / $completedCount);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getCustomerCount($sellerId)
    {
        try {
            return Order::where('seller_id', $sellerId)
                ->distinct('user_id')
                ->count('user_id');
        } catch (\Exception $e) {
            return 0;
        }
    }
}
