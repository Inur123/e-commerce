<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.buyer')]
#[Title('Buyer Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.buyer.dashboard');
    }
}
