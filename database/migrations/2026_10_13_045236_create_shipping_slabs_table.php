<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_slabs', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_order_value', 10, 2);
            $table->decimal('max_order_value', 10, 2)->nullable(); // null = "and above"
            $table->decimal('local_charge', 10, 2)->default(0);
            $table->decimal('state_charge', 10, 2)->default(0);
            $table->decimal('inter_charge', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_slabs');
    }
};