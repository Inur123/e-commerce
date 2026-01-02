<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; //  tambah ini

#[Layout('components.layouts.super-admin')]
#[Title('Manajemen User')]
class Users extends Component
{
    use WithPagination;

    public string $action = 'index';
    public ?string $userId = null;

    public ?string $deleteId = null;

    public string $search = '';
    public string $filterRole = '';
    public string $filterStatus = '';

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'buyer';
    public string $status = 'active';

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
        'role.required' => 'Role wajib dipilih',
        'status.required' => 'Status wajib dipilih',
    ];

    public function mount()
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Akses ditolak');
        }
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterRole() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function create()
    {
        $this->resetForm();
        $this->action = 'create';
    }

    public function save()
    {
        $this->validate($this->rulesCreate());

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'status' => $this->status,
        ]);

        session()->flash('success', 'User berhasil ditambahkan.');
        $this->back();
    }

    public function edit(string $id)
    {
        $u = User::findOrFail($id);

        $this->userId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->role = $u->role;
        $this->status = $u->status;
        $this->password = '';

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate($this->rulesEdit());

        $u = User::findOrFail($this->userId);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $u->update($data);

        session()->flash('success', 'User berhasil diupdate.');
        $this->back();
    }

    public function confirmDelete(string $id): void
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm-delete');
    }

    public function delete(): void
    {
        if (!$this->deleteId) return;

        if (Auth::user() && (string) Auth::user()->id === (string) $this->deleteId) {
            session()->flash('error', 'Tidak bisa menghapus akun yang sedang login.');
            $this->deleteId = null;

            $this->dispatch('swal:done', type: 'error', message: 'Tidak bisa menghapus akun yang sedang login.');
            return;
        }

        User::where('id', $this->deleteId)->delete();

        session()->flash('success', 'User berhasil dihapus.');
        $this->dispatch('swal:done', type: 'success', message: 'User berhasil dihapus.');
        $this->deleteId = null;
    }

    public function back()
    {
        $this->action = 'index';
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'role', 'status']);
        $this->role = 'buyer';
        $this->status = 'active';
        $this->resetValidation();
    }

    private function rulesCreate(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'seller', 'buyer'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    private function rulesEdit(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($this->userId, 'id'),
            ],
            'password' => ['nullable', 'min:6'],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'seller', 'buyer'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function render()
    {
        // query utama (mengikuti search + filter)
        $filtered = User::query()
            ->when($this->search, function ($q) {
                $s = '%' . $this->search . '%';
                $q->where(fn($qq) => $qq->where('name', 'like', $s)->orWhere('email', 'like', $s));
            })
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus));

        $users = (clone $filtered)->latest()->paginate(10);

        //  statistik untuk card
        $stats = [
            'total' => (clone $filtered)->count(),
            'active' => (clone $filtered)->where('status', 'active')->count(),
            'inactive' => (clone $filtered)->where('status', 'inactive')->count(),
            'roles' => (clone $filtered)
                ->select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->pluck('total', 'role')
                ->toArray(),
        ];

        return match ($this->action) {
            'create' => view('livewire.super-admin.user.create'),
            'edit'   => view('livewire.super-admin.user.edit', [
                'user' => User::findOrFail($this->userId),
            ]),
            default  => view('livewire.super-admin.user.index', [
                'users' => $users,
                'stats' => $stats,
            ]),
        };
    }
}
