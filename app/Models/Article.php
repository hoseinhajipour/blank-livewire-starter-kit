<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Article extends Model
{
    protected $fillable = ['category_id', 'slug', 'title', 'excerpt', 'content', 'featured_image', 'published_at', 'is_published', 'sort_order'];
    protected function casts(): array { return ['published_at' => 'datetime', 'is_published' => 'boolean']; }
    public function category() { return $this->belongsTo(ArticleCategory::class, 'category_id'); }
    public function scopePublished($query) { return $query->where('is_published', true)->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now())); }
}
