<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Hero slider (section 1)
        |--------------------------------------------------------------------------
        */
        Schema::create('home_sliders', function (Blueprint $table) {
            $table->id();

            $table->string('image');                              // storage path
            $table->string('image_alt')->nullable();

            // Top pill: "EXPLORE & IMAGINE • PLAYTIME SPECIALS"
            $table->string('badge_text')->nullable();
            $table->string('badge_icon')->nullable();             // fontawesome, e.g. fa-sparkles
            $table->string('badge_color', 30)->default('orange'); // orange | mint | sky | blue ...

            // Heading: line 1 + highlighted line 2 ("BIG FUN" / "STARTS HERE")
            $table->string('title_line1');
            $table->string('title_line2')->nullable();
            $table->string('highlight_color', 30)->default('yellow'); // yellow | mint | sky | orange

            $table->text('description')->nullable();

            // Two buttons (second one is optional)
            $table->string('btn1_text')->nullable();
            $table->string('btn1_link')->nullable();
            $table->string('btn2_text')->nullable();
            $table->string('btn2_link')->nullable();

            $table->string('nav_label', 40)->nullable();          // dot label: TOYS / STEM / ...

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['status', 'sort_order']);
        });

        /*
        |--------------------------------------------------------------------------
        | 2. Trust / USP strip (section 2)
        |--------------------------------------------------------------------------
        */
        Schema::create('home_usps', function (Blueprint $table) {
            $table->id();

            $table->string('icon');                               // fa-shield-halved
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('color', 30)->default('blue');         // blue | orange | mint | yellow | purple | coral

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['status', 'sort_order']);
        });

        /*
        |--------------------------------------------------------------------------
        | 3. Shop by interest (section 7)
        |--------------------------------------------------------------------------
        */
        Schema::create('home_interests', function (Blueprint $table) {
            $table->id();

            $table->string('icon');                               // fa-cubes
            $table->string('title');                              // BUILD
            $table->string('subtitle')->nullable();               // Blocks & Magnetics
            $table->string('color', 30)->default('orange');

            // Link to a category, or a custom link if no category is picked
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('custom_link')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['status', 'sort_order']);
        });

        /*
        |--------------------------------------------------------------------------
        | 4. Why families love us (section 11)
        |--------------------------------------------------------------------------
        */
        Schema::create('home_features', function (Blueprint $table) {
            $table->id();

            $table->string('icon');                               // fa-award
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('color', 30)->default('blue');

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['status', 'sort_order']);
        });

        /*
        |--------------------------------------------------------------------------
        | 5. Testimonials (section 12)
        |--------------------------------------------------------------------------
        */
        Schema::create('home_testimonials', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name');                      // initials are built from this
            $table->string('customer_title')->nullable();         // "Parent of 2, Bengaluru"
            $table->text('review');
            $table->unsignedTinyInteger('rating')->default(5);

            // Small product pill on the card: icon + "Magnetic 3D Tiles"
            $table->string('product_tag')->nullable();
            $table->string('tag_icon')->nullable();

            $table->string('color', 30)->default('yellow');       // yellow | blue | mint | orange | purple | sky
            $table->boolean('is_verified')->default(true);

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['status', 'sort_order']);
        });

        /*
        |--------------------------------------------------------------------------
        | 6. Section headings + promo banner (one row per section)
        |--------------------------------------------------------------------------
        | section_key values: categories, trending, favourites, interests,
        |                     promo_banner, why_us, testimonials
        */
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();

            $table->string('section_key', 50)->unique();

            $table->string('badge_text')->nullable();             // "DISCOVER PLAYTIME"
            $table->string('badge_icon')->nullable();
            $table->string('title')->nullable();                  // "WHAT DO THEY LOVE?"
            $table->string('title_highlight')->nullable();        // 2nd highlighted line (promo: "MORE MEMORIES.")
            $table->text('subtitle')->nullable();

            $table->string('button_text')->nullable();            // promo banner: "SHOP NOW →"
            $table->string('button_link')->nullable();

            // Section specific extras, e.g. testimonials rating badge {"rating":"4.9/5","reviews":"(1,200+ Reviews)"}
            $table->json('extra')->nullable();

            $table->boolean('status')->default(true);             // lets you hide a whole section
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sections');
        Schema::dropIfExists('home_testimonials');
        Schema::dropIfExists('home_features');
        Schema::dropIfExists('home_interests');
        Schema::dropIfExists('home_usps');
        Schema::dropIfExists('home_sliders');
    }
};