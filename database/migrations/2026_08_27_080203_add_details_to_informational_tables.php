<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->string('category')->default('Lainnya')->after('date');
            $table->string('photo_path')->nullable()->after('category');
            $table->string('writer_name')->nullable()->after('author_id');
            $table->boolean('is_published')->default(true)->after('writer_name');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('content');
            $table->boolean('is_pinned')->default(false)->after('photo_path');
            $table->dateTime('publish_date')->nullable()->after('is_pinned');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->time('event_time')->nullable()->after('event_date');
            $table->string('organizer')->nullable()->after('description');
            $table->string('photo_path')->nullable()->after('location');
            $table->enum('status', ['Akan Datang', 'Berlangsung', 'Selesai'])->default('Akan Datang')->after('photo_path');
        });
    }

    public function down(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->dropColumn(['category', 'photo_path', 'writer_name', 'is_published']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['photo_path', 'is_pinned', 'publish_date']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_time', 'organizer', 'photo_path', 'status']);
        });
    }
};
