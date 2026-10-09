<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->nullable()
                  ->constrained('customers')->nullOnDelete();

            $table->string('user_type')->default('customer'); // admin, customer
            $table->string('email')->nullable();
            $table->string('event');                           // login, login_failed, logout
            $table->string('status');                          // success, failed

            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->string('device_type', 20)->nullable();     // Mobile, Tablet, Desktop
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('isp')->nullable();

            $table->text('error_message')->nullable();
            $table->json('meta')->nullable();

            $table->timestamp('logged_out_at')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();

            $table->timestamps();

            $table->index(['user_type', 'event', 'status']);
            $table->index(['customer_id', 'event', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auth_logs');
    }
};