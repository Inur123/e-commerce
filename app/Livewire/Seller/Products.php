<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use App\Models\ProductImage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.seller')]
#[Title('Manajemen Produk')]
class Products extends Component
{
    use WithPagination, WithFileUploads;

    public string $action = 'index';
    public ?string $productId = null;
    public ?string $deleteId = null;

    public string $search = '';
    public string $filterStatus = '';

    public string $name = '';
    public $price = null;
    public $sale_price = null;
    public $stock = 0;
    public string $status = 'active';
    public ?string $description = null;

    public $thumbnailUpload = null;
    public ?string $thumbnailPath = null;

    public array $galleryUploads = [];
    public array $existingImages = [];

    public array $detailGallery = [];
    public ?string $detailThumbnailUrl = null;

    protected $messages = [
        'name.required' => 'Nama produk wajib diisi',
        'price.required' => 'Harga wajib diisi',
        'price.min' => 'Harga tidak boleh negatif',
        'thumbnailUpload.required' => 'Thumbnail wajib diupload',
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function mount()
    {
        if (!Auth::user() || Auth::user()->role !== 'seller') {
            abort(403, 'Akses ditolak');
        }
    }

    // ======================
    // Helper Block Delete Active
    // ======================
    private function denyDeleteIfActive(Product $p): bool
    {
        if ($p->status === 'active') {
            session()->flash('error', "Produk berstatus ACTIVE tidak bisa dihapus. Nonaktifkan dulu jika ingin menghapus.");

            // ✅ redirect supaya flash muncul
            $this->deleteId = null;
            $this->action = 'index';

            $this->redirect(route('seller.products'), navigate: true);
            return true;
        }

        return false;
    }

    // ======================
    // ACTIONS
    // ======================
    public function create()
    {
        $this->resetForm();
        $this->action = 'create';
    }

    public function edit(string $id)
    {
        $p = Product::where('seller_id', Auth::id())
            ->with('images')
            ->findOrFail($id);

        $this->productId = $p->id;
        $this->name = $p->name;
        $this->price = $p->price;
        $this->sale_price = $p->sale_price;
        $this->stock = $p->stock;
        $this->status = $p->status;
        $this->description = $p->description;
        $this->thumbnailPath = $p->thumbnail;

        $this->existingImages = $p->images
            ->sortBy('sort_order')
            ->map(fn($img) => [
                'id' => $img->id,
                'image_path' => $img->image_path,
                'url' => asset('storage/'.$img->image_path),
            ])
            ->values()
            ->toArray();

        $this->action = 'edit';
    }

    public function detail(string $id)
    {
        $p = Product::where('seller_id', Auth::id())
            ->with('images')
            ->findOrFail($id);

        $this->productId = $p->id;

        $this->detailThumbnailUrl = $p->thumbnail
            ? asset('storage/'.$p->thumbnail)
            : 'https://via.placeholder.com/240';

        $this->detailGallery = $p->images
            ->sortBy('sort_order')
            ->map(fn($img) => asset('storage/'.$img->image_path))
            ->values()
            ->toArray();

        $this->action = 'detail';
    }

    public function back()
    {
        $this->resetForm();
        $this->action = 'index';
        $this->resetPage();
    }

    // ======================
    // SAVE
    // ======================
    public function save()
    {
        $this->validate($this->rulesCreate());

        $thumbPath = $this->thumbnailUpload
            ? $this->thumbnailUpload->store('products/thumbnails', 'public')
            : null;

        $salePrice = ($this->sale_price === '' || $this->sale_price === null)
            ? null
            : (int) $this->sale_price;

        $product = Product::create([
            'seller_id'   => Auth::id(),
            'name'        => $this->name,
            'price'       => (int) $this->price,
            'sale_price'  => $salePrice,
            'stock'       => (int) $this->stock,
            'status'      => $this->status,
            'description' => $this->description,
            'thumbnail'   => $thumbPath,
        ]);

        $this->storeGallery($product);

        session()->flash('success', 'Produk berhasil ditambahkan.');

        return $this->redirect(route('seller.products'), navigate: true);
    }

    // ======================
    // UPDATE
    // ======================
    public function update()
    {
        $this->validate($this->rulesEdit());

        $p = Product::where('seller_id', Auth::id())->findOrFail($this->productId);

        if ($this->thumbnailUpload) {
            if ($p->thumbnail && Storage::disk('public')->exists($p->thumbnail)) {
                Storage::disk('public')->delete($p->thumbnail);
            }
            $p->thumbnail = $this->thumbnailUpload->store('products/thumbnails', 'public');
            $p->save();
        }

        $salePrice = ($this->sale_price === '' || $this->sale_price === null)
            ? null
            : (int) $this->sale_price;

        $p->update([
            'name'        => $this->name,
            'price'       => (int) $this->price,
            'sale_price'  => $salePrice,
            'stock'       => (int) $this->stock,
            'status'      => $this->status,
            'description' => $this->description,
        ]);

        $this->storeGallery($p);

        session()->flash('success', 'Produk berhasil diperbarui.');

        return $this->redirect(route('seller.products'), navigate: true);
    }

    // ======================
    // DELETE
    // ======================
    public function confirmDelete(string $id)
    {
        $p = Product::where('seller_id', Auth::id())->findOrFail($id);

        if ($this->denyDeleteIfActive($p)) return;

        $this->deleteId = $id;
        $this->dispatch('swal:confirm-delete');
    }

    public function delete()
    {
        if (!$this->deleteId) return;

        $p = Product::where('seller_id', Auth::id())
            ->with('images')
            ->findOrFail($this->deleteId);

        if ($this->denyDeleteIfActive($p)) return;

        if ($p->thumbnail && Storage::disk('public')->exists($p->thumbnail)) {
            Storage::disk('public')->delete($p->thumbnail);
        }

        foreach ($p->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        }

        $p->delete();

        session()->flash('success', 'Produk berhasil dihapus.');

        return $this->redirect(route('seller.products'), navigate: true);
    }

    // ======================
    // Rules
    // ======================
    private function rulesCreate(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'integer', 'min:0'],
            'sale_price' => ['nullable', 'integer', 'min:0', 'lte:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'thumbnailUpload' => ['required', 'image', 'max:2048'],
            'galleryUploads.*' => ['nullable', 'image', 'max:2048'],
        ];
    }

    private function rulesEdit(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'integer', 'min:0'],
            'sale_price' => ['nullable', 'integer', 'min:0', 'lte:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'thumbnailUpload' => ['nullable', 'image', 'max:2048'],
            'galleryUploads.*' => ['nullable', 'image', 'max:2048'],
        ];
    }

    // ======================
    // Reset
    // ======================
    private function resetForm()
    {
        $this->reset([
            'productId','deleteId',
            'name','price','sale_price','stock','status','description',
            'thumbnailUpload','thumbnailPath',
            'galleryUploads','existingImages',
            'detailGallery','detailThumbnailUrl',
        ]);

        $this->stock = 0;
        $this->status = 'active';
        $this->resetValidation();
    }

    // ======================
    // Store Gallery
    // ======================
    private function storeGallery(Product $p): void
    {
        if (empty($this->galleryUploads)) return;

        $sort = (int) ($p->images()->max('sort_order') ?? 0) + 1;

        foreach ($this->galleryUploads as $img) {
            ProductImage::create([
                'product_id' => $p->id,
                'image_path' => $img->store('products/gallery', 'public'),
                'sort_order' => $sort++,
            ]);
        }

        $this->galleryUploads = [];
    }

    // ======================
    // Render
    // ======================
    public function render()
    {
        $filtered = Product::query()
            ->where('seller_id', Auth::id())
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus));

        $products = (clone $filtered)->latest()->paginate(10);

        $products->getCollection()->transform(function ($p) {
            $p->thumbnail_url = $p->thumbnail
                ? asset('storage/'.$p->thumbnail)
                : 'https://via.placeholder.com/80';
            return $p;
        });

        $stats = [
            'total' => (clone $filtered)->count(),
            'active' => (clone $filtered)->where('status', 'active')->count(),
            'inactive' => (clone $filtered)->where('status', 'inactive')->count(),
            'out_of_stock' => (clone $filtered)->where('stock', 0)->count(),
        ];

        return match ($this->action) {
            'create' => view('livewire.seller.product.create'),
            'edit' => view('livewire.seller.product.edit', [
                'product' => Product::where('seller_id', Auth::id())->findOrFail($this->productId),
            ]),
            'detail' => view('livewire.seller.product.detail', [
                'product' => Product::where('seller_id', Auth::id())->findOrFail($this->productId),
                'thumbnailUrl' => $this->detailThumbnailUrl,
                'galleryUrls' => $this->detailGallery,
            ]),
            default => view('livewire.seller.product.index', [
                'products' => $products,
                'stats' => $stats,
            ]),
        };
    }
}
