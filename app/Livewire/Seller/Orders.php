<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

#[Layout('components.layouts.seller')]
#[Title('Manajemen Pesanan')]
class Orders extends Component
{
    use WithPagination;

    public string $action = 'index';
    public ?string $orderId = null;

    public string $search = '';
    public string $filterStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        if (!Auth::user() || Auth::user()->role !== 'seller') {
            abort(403, 'Akses ditolak');
        }
    }

    // =========================
    // Actions
    // =========================
    public function detail(string $id)
    {
        $this->orderId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->orderId = null;
    }

    public function updateStatus(string $orderId, string $status)
    {
        $order = Order::whereHas('items', fn($q) => $q->where('seller_id', Auth::id()))
            ->findOrFail($orderId);

        $order->update(['status' => $status]);

        session()->flash('success', "Status order berhasil diubah menjadi {$status}");
    }

    // =========================
    // Render
    // =========================
    public function render()
    {
        $baseQuery = Order::query()
            ->whereHas('items', fn($q) => $q->where('seller_id', Auth::id()))
            ->when($this->search, fn($q) => $q->where('order_code', 'like', "%{$this->search}%"))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus));

        $orders = (clone $baseQuery)->latest()->paginate(10);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending_payment' => (clone $baseQuery)->where('status', 'pending_payment')->count(),
            'paid' => (clone $baseQuery)->where('status', 'paid')->count(),
            'shipped' => (clone $baseQuery)->where('status', 'shipped')->count(),
        ];

        return match ($this->action) {
            'detail' => view('livewire.seller.order.detail', [
                'order' => Order::with(['buyer', 'payment', 'items.product'])
                    ->whereHas('items', fn($q) => $q->where('seller_id', Auth::id()))
                    ->findOrFail($this->orderId),
            ]),
            default => view('livewire.seller.order.index', [
                'orders' => $orders,
                'stats' => $stats,
            ]),
        };
    }
}
