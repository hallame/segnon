<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Models\User;
use App\Services\{CartService, CheckoutService};
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\ClientService;
use App\Models\Cart;

class ShopCheckoutController extends Controller {
    public function __construct(
        private CartService $cartService,
        private CheckoutService $checkoutService
    ) {}

    public function index(Request $request) {
        $client = Auth::user();
        $cart = $this->cartService->current($client->id ?? null, $request->session()->getId())
            ->load('items.product','items.sku');
        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart.index')->with('warning', 'Votre panier est vide.');
        }

        // On mémorise le panier utilisé pour ce checkout
        session(['checkout_cart_id' => $cart->id]);
        return view('frontend.shop.checkout', compact('cart'));
    }



    public function store(CheckoutRequest $request, ClientService $clients) {
        [$client, $plain] = $clients->ensureFromRequest($request);

        // $cartId = session('checkout_cart_id');
        // $cart = Cart::with(['items.product','items.sku'])->findOrFail($cartId);

        // // petite sécurité : vérifier que ce panier correspond bien à la session / user
        // if ($cart->user_id && $client && $cart->user_id !== $client->id) {
        //     abort(403);
        // }
        // if (!$cart->user_id && $cart->session_id !== $request->session()->getId()) {
        //     abort(403);
        // }

        // // éventuellement rattacher le panier au client
        // if ($client && !$cart->user_id) {
        //     $cart->user_id = $client->id;
        //     $cart->save();
        // }


        // current() va récupérer le panier de session et l'attacher au client
        $cart = $this->cartService
            ->current($client?->id, $request->session()->getId())
            ->loadMissing(['items.product', 'items.sku']);

        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart.index')->with('error', 'Votre panier est vide.');
        }

        $customer = [
            'user_id'           => $client->id,
            'lastname'         => $request->lastname,
            'firstname'        => $request->firstname,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'shipping_address' => (array) $request->input('shipping_address', []),
            'note'             => $request->note,
        ];

        $order = app(CheckoutService::class)->createOrderFromCart($cart, $customer, false);
        return redirect()->route('shop.payment.show', $order);
    }
}
