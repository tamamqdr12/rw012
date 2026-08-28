<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('category')->default('Lainnya')->after('title');
            $table->date('date')->nullable()->after('category');
        });

        Schema::table('organizational_members', function (Blueprint $table) {
            $table->boolean('is_karang_taruna')->default(false)->after('rt_id');
        });

        Schema::create('karang_taruna_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('profile_text')->nullable();
            $table->text('programs_text')->nullable();
            $table->timestamps();
        });

        // Insert initial data for karang_taruna_profiles
        DB::table('karang_taruna_profiles')->insert([
            'profile_text' => 'Wadah pembinaan dan pengembangan generasi muda RW 012.',
            'programs_text' => '1. Kegiatan Kepemudaan\n2. Olahraga Bersama\n3. Pengabdian Masyarakat',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['category', 'date']);
        });

        Schema::table('organizational_members', function (Blueprint $table) {
            $table->dropColumn('is_karang_taruna');
        });

        Schema::dropIfExists('karang_taruna_profiles');
    }
};
