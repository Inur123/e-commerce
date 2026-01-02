<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Voucher;
use App\Models\Product;

#[Layout('components.layouts.seller')]
#[Title('Manajemen Voucher')]
class Vouchers extends Component
{
    use WithPagination;

    public string $action = 'index';
    public ?string $voucherId = null;
    public ?string $deleteId = null;

    public string $search = '';
    public string $filterStatus = '';

    // FORM
    public string $code = '';
    public string $discount_type = 'percentage';
    public $discount_value = null;
    public $max_usage = 0;
    public $max_usage_per_user = null;
    public $min_purchase = null;
    public string $start_date = '';
    public string $end_date = '';
    public string $applies_to = 'all';
    public string $status = 'active';

    // PRODUCTS
    public array $selectedProducts = [];
    public array $availableProducts = [];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function mount()
    {
        if (!Auth::user() || Auth::user()->role !== 'seller') {
            abort(403, 'Akses ditolak');
        }
    }

    // =========================
    // ACTIONS
    // =========================
    public function create()
    {
        $this->resetForm();
        $this->loadProducts();
        $this->action = 'create';
    }

    public function edit(string $id)
    {
        $v = Voucher::where('owner_type', 'seller')
            ->where('seller_id', Auth::id())
            ->with('products')
            ->findOrFail($id);

        $this->voucherId = $v->id;
        $this->code = $v->code;
        $this->discount_type = $v->discount_type;
        $this->discount_value = $v->discount_value;
        $this->max_usage = $v->max_usage;
        $this->max_usage_per_user = $v->max_usage_per_user;
        $this->min_purchase = $v->min_purchase;
        $this->start_date = $v->start_date->format('Y-m-d\TH:i');
        $this->end_date = $v->end_date->format('Y-m-d\TH:i');
        $this->applies_to = $v->applies_to;
        $this->status = $v->status;

        $this->selectedProducts = $v->products->pluck('id')->toArray();

        $this->loadProducts();
        $this->action = 'edit';
    }

    public function detail(string $id)
    {
        $this->voucherId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->voucherId = null;
        $this->deleteId = null;
        $this->resetForm();
        $this->resetPage(); //  penting agar kembali ke page 1
    }

    // =========================
    // PRODUCTS
    // =========================
    private function loadProducts()
    {
        $this->availableProducts = Product::where('seller_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id','name'])
            ->toArray();
    }

    // =========================
    // SAVE / UPDATE
    // =========================
  public function save()
{
    $this->validate($this->rules());

    $voucher = Voucher::create([
        'owner_type' => 'seller',
        'seller_id' => Auth::id(),
        'code' => strtoupper($this->code),
        'discount_type' => $this->discount_type,
        'discount_value' => (int)$this->discount_value,
        'max_usage' => (int)$this->max_usage,
        'used_count' => 0,
        'max_usage_per_user' => $this->max_usage_per_user ? (int)$this->max_usage_per_user : null,
        'min_purchase' => $this->min_purchase ? (int)$this->min_purchase : null,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
        'applies_to' => $this->applies_to,
        'status' => $this->status,
    ]);

    if ($this->applies_to === 'selected') {
        $voucher->products()->sync($this->selectedProducts);
    }

    session()->flash('success', 'Voucher berhasil dibuat ');

    return $this->redirect(route('seller.vouchers'), navigate: true);
}


    public function update()
{
    $this->validate($this->rules(true));

    $v = Voucher::where('owner_type', 'seller')
        ->where('seller_id', Auth::id())
        ->findOrFail($this->voucherId);

    $v->update([
        'code' => strtoupper($this->code),
        'discount_type' => $this->discount_type,
        'discount_value' => (int)$this->discount_value,
        'max_usage' => (int)$this->max_usage,
        'max_usage_per_user' => $this->max_usage_per_user ? (int)$this->max_usage_per_user : null,
        'min_purchase' => $this->min_purchase ? (int)$this->min_purchase : null,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
        'applies_to' => $this->applies_to,
        'status' => $this->status,
    ]);

    if ($this->applies_to === 'selected') {
        $v->products()->sync($this->selectedProducts);
    } else {
        $v->products()->detach();
    }

    session()->flash('success', 'Voucher berhasil diperbarui ');

    return $this->redirect(route('seller.vouchers'), navigate: true);
}


    // =========================
    // DELETE
    // =========================
    public function confirmDelete(string $id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm-delete');
    }

  public function delete()
{
    if (!$this->deleteId) return;

    $v = Voucher::where('owner_type', 'seller')
        ->where('seller_id', Auth::id())
        ->findOrFail($this->deleteId);

    $v->delete();

    session()->flash('success', 'Voucher berhasil dihapus ');

    return $this->redirect(route('seller.vouchers'), navigate: true);
}


    // =========================
    // RULES
    // =========================
    private function rules(bool $isUpdate = false): array
    {
        return [
            'code' => [
                'required', 'string', 'max:30',
                $isUpdate
                    ? Rule::unique('vouchers', 'code')->ignore($this->voucherId)
                    : Rule::unique('vouchers', 'code')
            ],
            'discount_type' => ['required', Rule::in(['percentage','fixed'])],
            'discount_value' => ['required','integer','min:1'],
            'max_usage' => ['required','integer','min:0'],
            'max_usage_per_user' => ['nullable','integer','min:1'],
            'min_purchase' => ['nullable','integer','min:0'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date','after:start_date'],
            'applies_to' => ['required', Rule::in(['all','selected'])],
            'status' => ['required', Rule::in(['active','inactive'])],

            //  wajib jika applies_to = selected
            'selectedProducts' => [
                Rule::requiredIf(fn() => $this->applies_to === 'selected'),
                'array'
            ],
        ];
    }

    private function resetForm()
    {
        $this->reset([
            'voucherId','deleteId',
            'code','discount_type','discount_value',
            'max_usage','max_usage_per_user','min_purchase',
            'start_date','end_date','applies_to','status',
            'selectedProducts'
        ]);

        $this->discount_type = 'percentage';
        $this->applies_to = 'all';
        $this->status = 'active';
    }

    // =========================
    // RENDER
    // =========================
    public function render()
    {
        $query = Voucher::query()
            ->where('owner_type', 'seller')
            ->where('seller_id', Auth::id())
            ->when($this->search, fn($q) => $q->where('code', 'like', "%{$this->search}%"))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus));

        $vouchers = (clone $query)->latest()->paginate(10);

        $stats = [
            'total' => (clone $query)->count(),
            'active' => (clone $query)->where('status','active')->count(),
            'inactive' => (clone $query)->where('status','inactive')->count(),
        ];

        return match ($this->action) {
            'create' => view('livewire.seller.voucher.create'),
            'edit' => view('livewire.seller.voucher.edit'),
            'detail' => view('livewire.seller.voucher.detail', [
                'voucher' => Voucher::where('seller_id', Auth::id())
                    ->where('owner_type','seller')
                    ->with('products')
                    ->findOrFail($this->voucherId)
            ]),
            default => view('livewire.seller.voucher.index', [
                'vouchers' => $vouchers,
                'stats' => $stats,
            ]),
        };
    }
}
