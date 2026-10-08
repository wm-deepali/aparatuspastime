<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // ── Category ────────────────────────────────────────────
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // ── Identity ────────────────────────────────────────────
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('product_code')->nullable();
            $table->string('hsn_code', 20)->nullable();      // e.g. 950300

            // ── Content ─────────────────────────────────────────────
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('how_to_use')->nullable();       // Care & Setup section
            $table->longText('delivery_returns')->nullable(); // return / replacement / warranty text

            // ── Pricing ─────────────────────────────────────────────
            $table->decimal('mrp', 12, 2)->default(0);

            $table->enum('discount_type', [
                'amount',
                'percentage',
            ])->default('amount');

            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('price', 12, 2)->default(0);      // final selling price

            // ── Stock & delivery ────────────────────────────────────
            $table->integer('stock')->default(0);
            $table->integer('min_qty')->default(1);

            $table->string('delivery_time')->nullable();      // "2 to 7 days"
            $table->decimal('delivery_charge', 12, 2)->default(0);

            // ── Age group (shop filter: 0-2, 3-5, 6-8, 9-12, 12+) ───
            // age_max NULL = no upper limit ("3+", "6+")
            $table->unsignedTinyInteger('age_min')->nullable();
            $table->unsignedTinyInteger('age_max')->nullable();

            // ── Safety badge (gallery "100% Non-Toxic" pill) ────────
            // Off by default - only shown when explicitly ticked.
            $table->boolean('is_non_toxic')->default(false);

            $table->unsignedInteger('sort_order')->default(0);

            // ── Rating cache (updated when a review is approved) ────
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);

            // ── SEO ─────────────────────────────────────────────────
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // ── Indexes for shop filters / sorting ──────────────────
            $table->index(['status', 'category_id']);
            $table->index('price');
            $table->index(['age_min', 'age_max']);
            $table->index('rating_avg');
        });

        Schema::create('product_included_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // "Developmental Benefits" chips (right card). Empty = section hidden.
        Schema::create('product_benefits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('title');                          // e.g. "Motor Skills"
            $table->string('icon', 100)->nullable();          // FA class, e.g. "fa-solid fa-brain"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Overview highlight cards (the 3 cards under the description). Empty = hidden.
        Schema::create('product_highlights', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('title');                          // e.g. "Built For Endless Play"
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();          // FA class
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Child tables first, otherwise the FK blocks dropping products.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_highlights');
        Schema::dropIfExists('product_benefits');
        Schema::dropIfExists('product_included_items');
        Schema::dropIfExists('products');
    }
};