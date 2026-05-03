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
            $table->string('logo')->nullable()->after('image');
            $table->string('subject')->nullable()->after('name');
            $table->string('venue')->nullable()->after('location');
            $table->string('organizer')->nullable()->after('venue');
            $table->string('edition')->nullable()->after('organizer');
            $table->string('grant_amount')->nullable()->after('edition');
            $table->text('exhibitor_profile')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fairs', function (Blueprint $table) {
            $table->dropColumn(['logo', 'subject', 'venue', 'organizer', 'edition', 'grant_amount', 'exhibitor_profile']);
        });
    }
};
