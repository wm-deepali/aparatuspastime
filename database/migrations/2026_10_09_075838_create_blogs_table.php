<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            // Category (name + slug used for ?cat= filter)
            $table->string('category')->nullable();
            $table->string('category_slug')->nullable()->index();

            // Images: URL / assets path / storage path
            $table->string('image')->nullable();          // card thumbnail
            $table->string('banner_image')->nullable();   // detail + featured banner (falls back to image)

            $table->text('short_description')->nullable();   // excerpt
            $table->longText('content');                     // HTML body
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            // Author
            $table->string('author_name')->nullable();
            $table->string('author_role')->nullable();
            $table->string('author_avatar')->nullable();
            $table->text('author_bio')->nullable();

            // Extras (JSON arrays)
            $table->json('key_takeaways')->nullable();           // ["...", "..."]
            $table->json('tags')->nullable();                    // ["OutdoorPlay", ...]
            $table->json('recommended_product_ids')->nullable(); // [12, 15, 18] real product ids

            $table->unsignedSmallInteger('read_time')->nullable(); // minutes; auto-calculated when empty
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamp('published_at')->nullable();

            $table->boolean('is_featured')->default(0);   // featured story on blog page
            $table->boolean('show_home')->default(0);
            $table->boolean('status')->default(1);
            

            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};