<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fairs', function (Blueprint $table) {
            $table->string('subject_en')->nullable()->after('subject');
            $table->string('location_en')->nullable()->after('location');
            $table->string('venue_en')->nullable()->after('venue');
            $table->string('organizer_en')->nullable()->after('organizer');
            $table->string('edition_en')->nullable()->after('edition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fairs', function (Blueprint $table) {
            $table->dropColumn(['subject_en', 'location_en', 'venue_en', 'organizer_en', 'edition_en']);
        });
    }
};
