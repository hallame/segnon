<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('languages')->insert([
            [
                'name' => 'Français',
                'code' => 'fr',
                'locale' => 'fr_FR',
                'display_name' => 'Français',
                'status' => 1,
                'image' => null
            ],
            [
                'name' => 'English',
                'code' => 'en',
                'locale' => 'en_US',
                'display_name' => 'English',
                'status' => 1,
                'image' => null
            ],
        ]);
    }
}
