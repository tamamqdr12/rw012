<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RwProfile;
use App\Models\Rt;
use App\Models\Contact;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Data RW
        RwProfile::create([
            'name' => 'RW 012',
            'village' => 'Kelurahan Bugel',
            'district' => 'Kecamatan Karawaci',
            'city' => 'Kota Tangerang',
        ]);

        // Data RT
        $rts = [
            ['name' => 'RT 001'],
            ['name' => 'RT 002'],
            ['name' => 'RT 003'],
        ];

        foreach ($rts as $rt) {
            Rt::create($rt);
        }

        // Data Kontak
        $contacts = [
            ['name' => 'RW 012', 'phone_number' => '+62 831-6801-3075'],
            ['name' => 'RT 001', 'phone_number' => '+62 858-1730-6337'],
            ['name' => 'RT 002', 'phone_number' => '+62 813-8551-9262'],
            ['name' => 'RT 003', 'phone_number' => '+62 856-9417-1037'],
            ['name' => 'Karang Taruna', 'phone_number' => '+62 812-8330-3615'],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }

        $this->call(UserSeeder::class);
    }
}
