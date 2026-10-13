<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2026_10_13_000004_add_shipping_charge_to_carts_and_orders.php
return new class extends Migration
{
    public function up(): void
    {
        foreach (['carts', 'orders'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->decimal('shipping_charge', 10, 2)->default(0)->after('discount');
            });
        }
    }

    public function down(): void
    {
        foreach (['carts', 'orders'] as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->dropColumn('shipping_charge'));
        }
    }
};
