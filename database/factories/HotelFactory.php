<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => $name = $this->faker->company . ' Hotel',
            'slug' => Str::slug($name . '-' . uniqid()),
            'location' => $this->faker->city,
            'phone' => '+22967617769',
            'email' => "omizix@gmail.com",
            'description' => $this->faker->paragraph,
            'free_rooms' => $free = rand(5, 20),
            'total_rooms' => $free + rand(1, 10),
            'info' => $this->faker->sentence,
            'type' => Arr::random(['Luxe', 'Standard', 'Eco']),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country_id' => 1,
            'category_id' => Category::where('model', 'Hotel')->inRandomOrder()->value('id'),
            'language_id' => 1,
            'status' => 1,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
