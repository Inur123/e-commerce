<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.guest')]
#[Title('Register')]
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'buyer',
            'status' => 'active',
        ]);

        session()->flash('success', 'Register berhasil, silahkan login.');

        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
