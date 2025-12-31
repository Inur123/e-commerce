<?php

namespace App\Livewire\Landingpage;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.landingpage')]
#[Title('Home')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.landing-page.home');
    }
}
