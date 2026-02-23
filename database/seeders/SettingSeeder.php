<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {
    public function run(): void {
        $settings = [
            ['key' => 'site_name', 'value' => 'Zaly Merveille'],
            ['key' => 'site_description', 'value' => 'Plateforme culturelle et touristique de Guinée'],
            ['key' => 'email', 'value' => 'info@zalymerveille.org'],
            ['key' => 'phone', 'value' => '+224 620 96 91 07'],
            ['key' => 'address', 'value' => 'Conakry, Guinée'],
            ['key' => 'currency', 'value' => 'GNF'],
            ['key' => 'currency_name', 'value' => 'Franc guinéen'],
            ['key' => 'locale', 'value' => 'fr'],
            ['key' => 'available_locales', 'value' => 'fr,en'],
            ['key' => 'default_timezone', 'value' => 'Africa/Conakry'],
            ['key' => 'maintenance_mode', 'value' => '0'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
