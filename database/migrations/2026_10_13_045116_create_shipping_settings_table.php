<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();

            $table->enum('shipping_type', ['order_value', 'weight', 'pcs'])->default('order_value');
            $table->decimal('free_delivery_threshold', 10, 2)->nullable();

            // Weight based (grams)
            $table->unsignedInteger('min_weight')->nullable();
            $table->unsignedInteger('weight_step')->default(500);

            $table->decimal('weight_local_charge', 10, 2)->default(0);
            $table->decimal('weight_local_extra', 10, 2)->default(0);
            $table->decimal('weight_state_charge', 10, 2)->default(0);
            $table->decimal('weight_state_extra', 10, 2)->default(0);
            $table->decimal('weight_inter_charge', 10, 2)->default(0);
            $table->decimal('weight_inter_extra', 10, 2)->default(0);

            // Pcs based
            $table->unsignedInteger('min_pcs')->nullable();

            $table->decimal('pcs_local_charge', 10, 2)->default(0);
            $table->decimal('pcs_local_extra', 10, 2)->default(0);
            $table->decimal('pcs_state_charge', 10, 2)->default(0);
            $table->decimal('pcs_state_extra', 10, 2)->default(0);
            $table->decimal('pcs_inter_charge', 10, 2)->default(0);
            $table->decimal('pcs_inter_extra', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};