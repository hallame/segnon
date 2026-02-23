<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModerationStatus;

class ModerationStatusSeeder extends Seeder {
    public function run(): void {
        
        $rows = [
            ['slug' => 'pending',  'status' => 'En attente', 'is_final' => false, 'sort' => 10],
            ['slug' => 'approved', 'status' => 'Approuvé',   'is_final' => true,  'sort' => 20],
            ['slug' => 'rejected', 'status' => 'Rejeté',     'is_final' => true,  'sort' => 30],
        ];
        
        foreach ($rows as $r) {
            ModerationStatus::updateOrCreate(['slug' => $r['slug']], $r);
        }
    }
}
