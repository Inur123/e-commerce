<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.seller')]
#[Title('Seller Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.seller.dashboard');
    }
}
