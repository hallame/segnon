<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        // 1) Un admin déterministe
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL','admin@admin.com')],
            [
                'lastname' => 'Admin',
                'firstname' => 'Main',
                'password' => Hash::make(env('ADMIN_PASSWORD','password')),
                'email_verified_at' => now(),
            ]
        );

        // 2) Un gros lot de users aléatoires
        User::factory()->count(50)->create();
    }
}
