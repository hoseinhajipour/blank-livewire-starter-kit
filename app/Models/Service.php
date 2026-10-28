<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Service extends Model
{
    protected $fillable = ['slug', 'title', 'desc', 'content', 'image', 'is_active', 'sort_order'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function scopeVisible($query) { return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id'); }
}
