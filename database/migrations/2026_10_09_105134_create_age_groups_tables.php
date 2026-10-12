<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('age_groups', function (Blueprint $table) {
            $table->id();

            // Range in years. age_max NULL = open ended (e.g. "12+")
            $table->unsignedTinyInteger('age_min');
            $table->unsignedTinyInteger('age_max')->nullable();

            // URL key used in ?age= (e.g. "3-5", "12+"). Auto-generated from min/max.
            $table->string('slug', 20)->unique();

            $table->string('short_label', 20);          // menu badge, e.g. "0–2"
            $table->string('label', 60);                // e.g. "0–2 Years"
            $table->string('name', 80);                 // e.g. "Little Discoverers"
            $table->string('description', 160)->nullable();

            $table->string('icon', 60)->nullable();     // Font Awesome class, e.g. fa-baby
            $table->string('color', 20)->default('blue'); // blue, orange, purple, rose, mint, yellow

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('age_groups');
    }
};