<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory {
    protected $model = CartItem::class;

    public function definition(): array {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $skuId = null;
        $unit = $product->price;

        if ($product->type === 'variable') {
            $sku = ProductSku::where('product_id', $product->id)->inRandomOrder()->first()
                ?? ProductSku::factory()->create(['product_id' => $product->id]);
            $skuId = $sku->id;
            $unit = $sku->price;
        }

        $qty = $this->faker->numberBetween(1, 20);

        return [
            'cart_id' => Cart::factory(),
            'product_id' => $product->id,
            'product_sku_id' => $skuId,
            'qty' => $qty,
            'unit_price' => $unit,
            'total_price' => $unit * $qty,
        ];
    }
}
