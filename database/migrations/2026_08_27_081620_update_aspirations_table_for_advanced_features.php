<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            $table->string('contact_info')->nullable()->after('sender_name');
            $table->string('category')->default('Lainnya')->after('contact_info');
            $table->string('title')->default('Aspirasi Warga')->after('category');
            $table->string('photo_path')->nullable()->after('message');
            $table->text('response')->nullable()->after('photo_path');
            $table->string('status')->default('Baru')->change();
        });
    }

    public function down(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            $table->dropColumn(['contact_info', 'category', 'title', 'photo_path', 'response']);
        });
    }
};
