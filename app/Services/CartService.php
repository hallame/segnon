<?php

namespace App\Services;

use App\Models\{Cart, CartItem, Product, ProductSku, Setting};
use Illuminate\Support\Str;

class CartService {

    public function current(?int $clientId, ?string $sessionId): Cart {
        if ($sessionId) {
            $cart = Cart::where('session_id', $sessionId)->first();
            if ($cart) {
                if ($clientId && (int)$cart->user_id !== (int)$clientId) {
                    // Si un panier user existe déjà --> merge.
                    $cart->user_id = $clientId;
                    $cart->session_id = null;
                    $cart->save();
                }
                return $cart;
            }
        }

        if ($clientId) {
            return Cart::firstOrCreate(['user_id' => $clientId]);
        }

        return Cart::firstOrCreate(
            ['session_id' => $sessionId ?: Str::uuid()->toString()],
            ['currency' => Setting::where('key', 'currency')->value('value')]
        );
    }

    public function add(Cart $cart, Product $product, ?ProductSku $sku, int $qty = 1): CartItem {
        $qty = max(1, (int)$qty);

        // (Optionnel) sécurité : le SKU doit appartenir au produit
        if ($sku && (int)$sku->product_id !== (int)$product->id) {
            session()->flash('error', 'Variation invalide pour ce produit.');
            // On renvoie un CartItem “virtuel” pour respecter la signature
            return new CartItem();
        }

        $available = $sku ? max(0, (int)$sku->stock) : max(0, (int)$product->stock);

        $unit     = $sku ? (float)$sku->price : (float)$product->price;
        $currency = Setting::where('key', 'currency')->value('value');

        // Récupère ou crée la ligne (qty=0 si nouvelle)
        $item = CartItem::firstOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product->id, 'product_sku_id' => $sku?->id],
            ['qty' => 0, 'unit_price' => $unit, 'total_price' => 0, 'currency' => $currency],
        );

        if ((float)$item->unit_price !== $unit) {
            $item->unit_price = $unit;
        }

        // Cap de la quantité totale par le stock disponible
        $newQty = min($item->qty + min($qty, $available), $available);

        if ($available <= 0 || $newQty <= 0) {
            // pas de stock : nettoyer si la ligne est nouvelle/vidée
            if ($item->exists && (int)$item->qty === 0) {
                $item->delete();
            }
            session()->flash('error', 'Stock insuffisant ou produit en rupture.');
            return $item; // (modèle potentiellement supprimé, mais on ne le manipule plus après)
        }

        $item->qty = $newQty;
        $item->total_price = $newQty * $item->unit_price;
        $item->save();

        return $item;
    }

    public function updateQty(CartItem $item, int $qty): void {
        $available = $item->sku?->stock ?? $item->product?->stock ?? 0;
        $qty = max(1, min($qty, (int)$available));
        $item->qty = $qty;
        $item->total_price = $qty * $item->unit_price;
        $item->save();
    }

    public function remove(CartItem $item): void {
        $item->delete();
    }
}
