<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SiteSetting extends Model
{
    protected $fillable = ['site_title', 'site_description', 'meta_description', 'favicon_path', 'site_icon_path', 'og_image_path', 'sitemap_enabled', 'llms_enabled', 'responsive_mode'];
    protected function casts(): array { return ['sitemap_enabled' => 'boolean', 'llms_enabled' => 'boolean', 'responsive_mode' => 'boolean']; }
}
