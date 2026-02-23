<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            LanguageSeeder::class,
            CountrySeeder::class,
            FacilitySeeder::class,
            SettingSeeder::class,
            ModulesRolesPermissionsSeeder::class,
            RoleAndPermissionSeeder::class,
            ModerationStatusSeeder::class,
            ZalyMerveillePartnerSeeder::class,
            FaqSeeder::class,

        ]);
    }
}
