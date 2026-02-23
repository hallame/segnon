<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insertOrIgnore([
            [
                'name' => 'Guinée',
                'iso_code' => 'GN', // Code ISO du pays
                'language_id' => 1, // ID de la langue par défaut
                'country_code' => '+224', // Indicatif téléphonique
                'status' => true, // Statut actif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guinea',
                'iso_code' => 'GUI', // Code ISO du pays
                'language_id' => 1,
                'country_code' => '+224',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
