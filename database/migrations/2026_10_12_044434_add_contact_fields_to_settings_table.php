<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('working_hours')->nullable();        // Mon–Sat: 9 AM – 7 PM IST
            $table->string('email_response_note')->nullable();  // Fast response within 24h
            $table->string('address_short')->nullable();        // Sector 62, Noida (card headline)
            $table->text('enquiry_subjects')->nullable();       // one subject per line, for the dropdown
            $table->text('popular_searches')->nullable();        // one search term per line, for the suggestions
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['working_hours', 'email_response_note', 'address_short', 'enquiry_subjects', 'popular_searches']);
        });
    }
};