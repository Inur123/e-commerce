<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.super-admin')]
#[Title('Super Admin Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.super-admin.dashboard');
    }
}
