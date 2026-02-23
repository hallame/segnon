<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Faq;



class FaqFactory extends Factory {
    protected $model = Faq::class;

    public function definition(): array {
        return [
            'question'    => rtrim($this->faker->sentence(8), '.'). ' ?',
            'answer'      => $this->faker->paragraphs(2, true),
            'category_id' => Category::where('model', 'Faq')->inRandomOrder()->value('id'),
            'position'    => $this->faker->numberBetween(0, 100),
            'active'      => $this->faker->boolean(90),
        ];
    }
}
