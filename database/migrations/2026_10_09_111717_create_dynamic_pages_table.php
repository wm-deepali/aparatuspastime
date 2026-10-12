<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_pages', function (Blueprint $table) {
            $table->id();

            // URL key, e.g. "cancellation-policy", "terms"
            $table->string('slug', 100)->unique();

            // Small pill above the heading, e.g. "ORDER FLEXIBILITY", "TERMS OF SERVICE"
            $table->string('badge_text', 60)->nullable();

            $table->string('heading');

            // Line under the heading: "{date_label}: {effective_date as Month Year} • Aparatus Pastime"
            $table->string('date_label', 30)->default('Last Updated'); // or "Effective Date"
            $table->date('effective_date')->nullable();

            // Page body (HTML from the admin editor)
            $table->longText('content');

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('status')->default(true);

            // The 7 built-in policy pages are linked from the footer by route name,
            // so they can be edited or hidden but not deleted
            $table->boolean('is_system')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_pages');
    }
};