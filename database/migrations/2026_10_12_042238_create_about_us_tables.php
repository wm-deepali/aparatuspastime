<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Hero
            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();            // white line
            $table->string('hero_title_highlight')->nullable();  // yellow line
            $table->text('hero_description')->nullable();

            // Story
            $table->string('story_badge')->nullable();
            $table->string('story_heading')->nullable();
            $table->text('story_paragraph_1')->nullable();
            $table->text('story_paragraph_2')->nullable();
            $table->string('story_image')->nullable();           // upload path OR full URL
            $table->string('story_image_alt')->nullable();

            // Beliefs heading
            $table->string('beliefs_badge')->nullable();
            $table->string('beliefs_heading')->nullable();
            $table->text('beliefs_description')->nullable();

            // Promise banner
            $table->string('promise_badge')->nullable();
            $table->string('promise_heading')->nullable();
            $table->text('promise_description')->nullable();
            $table->string('promise_btn1_text')->nullable();
            $table->string('promise_btn1_url')->nullable();
            $table->string('promise_btn2_text')->nullable();
            $table->string('promise_btn2_url')->nullable();

            $table->timestamps();
        });

        Schema::create('about_stats', function (Blueprint $table) {
            $table->id();
            $table->string('value');                       // 100%, Curated
            $table->string('label');                       // Child-Safe Materials
            $table->string('color')->default('navy');      // navy | orange
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('about_beliefs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();            // fa-shapes
            $table->string('color')->default('blue');      // blue | orange | mint | yellow
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_beliefs');
        Schema::dropIfExists('about_stats');
        Schema::dropIfExists('about_pages');
    }
};