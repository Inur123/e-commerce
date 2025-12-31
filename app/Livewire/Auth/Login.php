<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

#[Layout('components.layouts.guest')]
#[Title('Login')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if ($user && $user->status !== 'active') {
            $this->addError('email', 'Akun kamu masih inactive.');
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'super_admin' => $this->redirect(route('super_admin.dashboard'), navigate: true),
                'admin'       => $this->redirect(route('admin.dashboard'), navigate: true),
                'seller'      => $this->redirect(route('seller.dashboard'), navigate: true),
                default       => $this->redirect(route('buyer.dashboard'), navigate: true),
            };
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
