<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory {

    protected $model = Cart::class;

    public function definition(): array {
        // 60% client connecté, 40% invité
        $useUser = $this->faker->boolean(60);
        $userId = null;

        if ($useUser) {
            $userId = User::inRandomOrder()->value('id');
        }


        return [
            'user_id' => $userId,
            'session_id' => $useUser ? null : $this->faker->uuid(),
            'currency' => 'GNF',
        ];
    }
}
