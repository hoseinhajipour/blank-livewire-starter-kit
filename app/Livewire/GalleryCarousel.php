<?php

namespace App\Livewire;

use App\Models\GalleryImage;
use Livewire\Component;

class GalleryCarousel extends Component
{
    public function render()
    {
        return view('livewire.gallery-carousel', [
            'images' => GalleryImage::visible()->get(),
        ]);
    }
}
