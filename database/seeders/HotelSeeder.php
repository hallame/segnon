<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Hotel::factory()->count(20)->create()->each(function ($hotel) {
            Room::factory()->count(rand(5, 20))->create([
                'hotel_id' => $hotel->id,
            ])->each(function ($room) {
                $room->facilities()->attach(
                    Facility::inRandomOrder()->take(rand(8, 10))->pluck('id')->toArray()
                );
            });
            $hotel->facilities()->attach(
                Facility::inRandomOrder()->take(10)->pluck('id')->toArray()
            );
        });
    }

}
