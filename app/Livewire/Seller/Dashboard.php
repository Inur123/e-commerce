<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

#[Layout('components.layouts.seller')]
#[Title('Seller Dashboard')]
class Dashboard extends Component
{
    public function mount()
    {
        if (!Auth::user() || Auth::user()->role !== 'seller') {
            abort(403, 'Akses ditolak');
        }
    }

    public function render()
    {
        $sellerId = Auth::id();

        // ✅ Produk Stats
        $productQuery = Product::where('seller_id', $sellerId);

        $productStats = [
            'total' => (clone $productQuery)->count(),
            'active' => (clone $productQuery)->where('status', 'active')->count(),
            'inactive' => (clone $productQuery)->where('status', 'inactive')->count(),
            'out_of_stock' => (clone $productQuery)->where('stock', 0)->count(),
        ];

        // ✅ Orders Stats (khusus order yg punya produk seller)
        $orderQuery = Order::query()
            ->whereHas('items', fn($q) => $q->where('seller_id', $sellerId));

        $orderStats = [
            'total' => (clone $orderQuery)->count(),
            'pending_payment' => (clone $orderQuery)->where('status', 'pending_payment')->count(),
            'paid' => (clone $orderQuery)->where('status', 'paid')->count(),
            'shipped' => (clone $orderQuery)->where('status', 'shipped')->count(),
            'completed' => (clone $orderQuery)->where('status', 'completed')->count(),
        ];

        // ✅ Pendapatan seller (paid + shipped + completed)
        $income = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', fn($q) => $q->whereIn('status', ['paid', 'shipped', 'completed']))
            ->sum('subtotal');

        // ✅ Recent Orders
        $recentOrders = (clone $orderQuery)
            ->with('buyer')
            ->latest()
            ->take(5)
            ->get();

        // ✅ Produk stok habis
        $outOfStockProducts = Product::where('seller_id', $sellerId)
            ->where('stock', 0)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.seller.dashboard', [
            'productStats' => $productStats,
            'orderStats' => $orderStats,
            'income' => $income,
            'recentOrders' => $recentOrders,
            'outOfStockProducts' => $outOfStockProducts,
        ]);
    }
}
