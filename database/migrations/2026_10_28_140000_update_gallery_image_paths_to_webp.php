<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['photo_5976571529715716019_y', 'photo_5976571529715716016_y', 'photo_5976571529715716017_y'] as $name) {
            DB::table('gallery_images')->where('image_path', $name.'.jpg')->update(['image_path' => $name.'.webp']);
        }
    }

    public function down(): void
    {
        foreach (['photo_5976571529715716019_y', 'photo_5976571529715716016_y', 'photo_5976571529715716017_y'] as $name) {
            DB::table('gallery_images')->where('image_path', $name.'.webp')->update(['image_path' => $name.'.jpg']);
        }
    }
};
