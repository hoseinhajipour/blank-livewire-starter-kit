<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['title', 'image_path', 'alt', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeVisible($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->latest('id');
    }
}
