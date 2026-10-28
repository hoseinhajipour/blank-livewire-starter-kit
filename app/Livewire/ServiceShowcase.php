<?php

namespace App\Livewire;

use App\Support\SiteCatalog;
use Livewire\Component;

class ServiceShowcase extends Component
{
    public function render()
    {
        return view('livewire.service-showcase', ['services' => SiteCatalog::services()]);
    }
}
