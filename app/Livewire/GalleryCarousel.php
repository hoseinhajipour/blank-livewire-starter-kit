<?php

namespace App\Livewire;

use App\Models\GalleryImage;
use Livewire\Component;

class GalleryCarousel extends Component
{
    public function render()
    {
        $images = GalleryImage::visible()->get();

        return view('livewire.gallery-carousel', [
            'images' => $images,
        ]);
    }
}
