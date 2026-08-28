<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizational_members', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('role');
            $table->string('contact_info')->nullable()->after('photo_path');
            $table->string('period')->nullable()->after('contact_info');
            $table->boolean('is_active')->default(true)->after('period');
        });

        Schema::table('residents_statistics', function (Blueprint $table) {
            $table->integer('total_kk')->nullable()->after('total_count');
        });
    }

    public function down(): void
    {
        Schema::table('organizational_members', function (Blueprint $table) {
            $table->dropColumn(['photo_path', 'contact_info', 'period', 'is_active']);
        });

        Schema::table('residents_statistics', function (Blueprint $table) {
            $table->dropColumn(['total_kk']);
        });
    }
};
