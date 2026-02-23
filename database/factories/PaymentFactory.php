<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory {
   protected $model = Payment::class;

    public function definition(): array {
        $order = Order::factory()->create();
        return [
            'payable_id' => $order->id,
            'payable_type' => Order::class,
            // 'payment_method_id' => 1,
            'payment_method_id' => PaymentMethod::where('active', 1)->inRandomOrder()->value('id'),
            'amount' => $order->total,
            'currency' => $order->currency,
            'transaction_number' => $this->faker->numerify('TX########'),
            'status' => 0, // submitted
            'submitted_at' => now(),
            'verified_at' => null,
            'verified_by' => null,
            'note' => null,
        ];
    }

    public function verified(): self {
        return $this->state(fn() => ['status' => 1, 'verified_at' => now()]);
    }

    public function rejected(): self {
        return $this->state(fn() => ['status' => 2, 'note' => 'Reçu non lisible']);
    }
}
