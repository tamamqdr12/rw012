<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('map_locations', function (Blueprint $table) {
            $table->string('name')->after('id');
            // Change latitude and longitude to string to allow nullable empty strings if admin hasn't inputted them yet, or make them nullable string
            $table->string('latitude')->nullable()->change();
            $table->string('longitude')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('map_locations', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
