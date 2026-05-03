<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fairs', function (Blueprint $table) {
            $table->string('video')->nullable()->after('image');
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('fairs', function (Blueprint $table) {
            $table->dropColumn('video');
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
