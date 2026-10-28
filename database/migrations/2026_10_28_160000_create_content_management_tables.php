<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('article_categories', function (Blueprint $table): void { $table->id(); $table->string('name'); $table->string('slug')->unique(); $table->text('description')->nullable(); $table->boolean('is_active')->default(true); $table->timestamps(); });
        Schema::create('articles', function (Blueprint $table): void { $table->id(); $table->foreignId('category_id')->nullable()->constrained('article_categories')->nullOnDelete(); $table->string('slug')->unique(); $table->string('title'); $table->text('excerpt')->nullable(); $table->longText('content')->nullable(); $table->string('featured_image')->nullable(); $table->timestamp('published_at')->nullable(); $table->boolean('is_published')->default(false)->index(); $table->unsignedInteger('sort_order')->default(0); $table->timestamps(); });
        Schema::create('services', function (Blueprint $table): void { $table->id(); $table->string('slug')->unique(); $table->string('title'); $table->text('desc')->nullable(); $table->longText('content')->nullable(); $table->string('image')->nullable(); $table->boolean('is_active')->default(true)->index(); $table->unsignedInteger('sort_order')->default(0); $table->timestamps(); });
        Schema::create('site_settings', function (Blueprint $table): void { $table->id(); $table->string('site_title'); $table->text('site_description')->nullable(); $table->text('meta_description')->nullable(); $table->string('favicon_path')->nullable(); $table->string('site_icon_path')->nullable(); $table->string('og_image_path')->nullable(); $table->boolean('sitemap_enabled')->default(true); $table->boolean('llms_enabled')->default(true); $table->boolean('responsive_mode')->default(true); $table->timestamps(); });
    }
    public function down(): void { Schema::dropIfExists('site_settings'); Schema::dropIfExists('articles'); Schema::dropIfExists('article_categories'); Schema::dropIfExists('services'); }
};
