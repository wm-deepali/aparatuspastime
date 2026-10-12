<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->boolean('show_in_header')->default(false);
            $table->unsignedInteger('header_order')->default(0);
            $table->string('header_icon')->nullable();            // fa-fire
            $table->string('header_color')->default('amber');     // emerald | amber | blue | rose | purple | orange
            $table->string('header_badge', 10)->nullable();       // NEW, HOT (optional)
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn(['show_in_header', 'header_order', 'header_icon', 'header_color', 'header_badge']);
        });
    }
};