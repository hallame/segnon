<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => $name = $this->faker->word . ' Room',
            'slug' => Str::slug($name . '-' . uniqid()),
            'description' => $this->faker->sentence(100),
            'capacity' => rand(1, 10),
            'price' => $this->faker->randomFloat(2, 40, 15000000),
            'type' => Arr::random(['Luxe', 'Standard', 'Eco']),
            'status' => 1,
            'category_id' => Category::where('model', ['Room', 'Hotel'])->inRandomOrder()->value('id'),
            'info' => $this->faker->sentence(),
            'address' => $this->faker->address,
        ];
    }
}
