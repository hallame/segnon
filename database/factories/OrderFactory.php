<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory {
    protected $model = Order::class;

    public function definition(): array {
        $user = User::inRandomOrder()->first();

        return [
            'reference' => strtoupper('ZMS'.$this->faker->unique()->bothify('########')),
            'user_id' => $user->id,
            'customer_lastname' => $user->lastname,
            'customer_firstname' => $user->firstname,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone,
            'subtotal' => 0,
            'discount' => 0,
            'shipping' => 0,
            'tax' => 0,
            'total' => 0,
            'currency' => 'XOF',
            'shipping_address' => null,
            'status' => 0,
        ];
    }

    public function configure() {
        return $this->afterCreating(function (Order $order) {
            $items = Product::inRandomOrder()->take(rand(1, 3))->get();
            $subtotal = 0;

            foreach ($items as $product) {
                if ($product->type === 'variable') {
                    $sku = ProductSku::where('product_id', $product->id)->inRandomOrder()->first()
                        ?? ProductSku::factory()->create(['product_id' => $product->id]);
                    $unit = $sku->price; $attrs = $sku->attributes; $skuId = $sku->id;
                } else {
                    $unit = $product->price; $attrs = null; $skuId = null;
                }

                $qty = rand(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_sku_id' => $skuId,
                    'product_name' => $product->name,
                    'sku_attributes' => $attrs,
                    'unit_price' => $unit,
                    'qty' => $qty,
                    'total_price' => $unit * $qty,
                ]);

                $subtotal += $unit * $qty;
            }

            $order->update([
                'subtotal' => $subtotal,
                'tax' => 0,
                'total' => $subtotal,
            ]);
        });
    }
}
