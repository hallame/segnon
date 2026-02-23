<?php

namespace App\Services;

use App\Models\{Order, OrderItem, Cart, Setting};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use App\Mail\OrderConfirmedMail;
use Illuminate\Support\Facades\Mail;
class CheckoutService {

    public function createOrderFromCart(Cart $cart, array $customer, bool $deleteCartRecord = false): Order {

        return DB::transaction(function () use ($cart, $customer, $deleteCartRecord) {
            // Recharger et verrouiller le panier pour éviter les courses
            $cart = Cart::with(['items.product', 'items.sku'])
                ->whereKey($cart->id)->lockForUpdate()->firstOrFail();

            if ($cart->items->isEmpty()) {
                throw new \RuntimeException('Panier vide'); // garde-fou côté service
            }

            // Générer une référence unique (avec retry si collision)
            $reference = $this->generateUniqueReference();

            // Préparer l’order (on remplit d’abord les champs clients + monétaire à 0)
            $order = Order::create([
                'reference'          => $reference,
                'user_id'               => $customer['user_id'] ?? null,
                'customer_lastname'  => $customer['lastname'],
                'customer_firstname' => $customer['firstname'],
                'customer_email'     => $customer['email'],
                'customer_phone'     => $customer['phone'] ?? null,

                'subtotal'           => 0,
                'discount'           => 0,
                'shipping'           => 0,
                'tax'                => 0,
                'total'              => 0,

                'currency'           => Setting::where('key', 'currency')->value('value'),
                'shipping_address'   => $customer['shipping_address'] ?? null,
                'note'               => $customer['note'] ?? null,
                'status'             => 0, // awaiting_payment
            ]);


            // Lignes + calculs
            $subtotal = 0;

            foreach ($cart->items as $ci) {
                // Toujours recalculer le prix unitaire depuis la source (anti-tampering)
                $unit = $ci->sku ? (float)$ci->sku->price : (float)$ci->product->price;
                $lineTotal = $unit * (int)$ci->qty;

                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $ci->product_id,
                    'product_sku_id' => $ci->product_sku_id,
                    'product_name'   => $ci->product->name,
                    'sku_attributes' => $ci->sku?->attributes,
                    'unit_price'     => $unit,
                    'qty'            => (int)$ci->qty,
                    'total_price'    => $lineTotal,
                ]);

                $subtotal += $lineTotal;

                // (Optionnel) décrémenter le stock de façon atomique
                if ($ci->sku) {
                    $ci->sku()->lockForUpdate()->decrement('stock', (int)$ci->qty);
                } else {
                    $ci->product()->lockForUpdate()->decrement('stock', (int)$ci->qty);
                }
            }

            // Calculs finaux (ajoute shipping/tax/discount si tu en as)
            $order->update([
                'subtotal' => $subtotal,
                // 'discount' => $discount,
                // 'shipping' => $shipping,
                // 'tax'      => $tax,
                'total'    => $subtotal, // + shipping + tax - discount
            ]);


            // Nettoyage panier
            $cart->items()->delete();
            if ($deleteCartRecord) {
                $cart->delete();
            }

            // Mail::to($order->customer_email)->queue(new OrderConfirmedMail($order));
            return $order;
        });
    }

    protected function generateUniqueReference(int $tries = 5): string {
        for ($i = 0; $i < $tries; $i++) {
            $ref = '2MS'.now()->format('Ym') . strtoupper(Str::random(6));

            try {
                if (! Order::where('reference', $ref)->exists()) {
                    return $ref;
                }
            } catch (QueryException $e) {
                Log::warning('Échec temporaire lors de la vérification d’unicité de la référence commande', [
                    'exception' => get_class($e),
                    'code'      => $e->getCode(),
                    'sql_state' => $e->errorInfo[0] ?? null,
                    'message'   => $e->getMessage(),
                ]);
                try { usleep(random_int(10_000, 80_000)); } catch (\Throwable $t) {}
                continue;
            }
        }
        // Dernier recours : référence plus longue pour minimiser toute collision
        return '2MS-'.now()->format('Ym').'-'.strtoupper(Str::random(10));
    }

}

