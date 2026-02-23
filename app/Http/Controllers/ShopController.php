<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Account, Product, ProductSku, CartItem, Order, Payment, Category};
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;
use App\Services\{CartService, CheckoutService};
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services\ClientService;
class ShopController extends Controller {


    public function index(Request $request) {


        $q    = trim((string) $request->get('q'));
        $sort = $request->get('sort');
        $categorySlug = $request->get('c');

        $query = Product::query()
            ->where('status', 1)
            ->with(['media','skus','category'])
            ->withMin('skus', 'price');

        // Filtre par slug de catégorie
        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }


        // Recherche: nom, description, catégorie
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas('category', fn ($qc) =>
                        $qc->where('name', 'like', "%{$q}%")
                    );
            });
        }

        // Tri
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw(
                    'CASE WHEN COALESCE(skus_min_price, products.price) IS NULL THEN 1 ELSE 0 END,
                    COALESCE(skus_min_price, products.price) ASC'
                );
                break;

            case 'price_desc':
                $query->orderByRaw(
                    'CASE WHEN COALESCE(skus_min_price, products.price) IS NULL THEN 1 ELSE 0 END,
                    COALESCE(skus_min_price, products.price) DESC'
                );
                break;

            case 'new':
            default:
                $query->latest('id');
        }

        $products = $query->paginate(24)->withQueryString();

        // ⚡ Catégories dynamiques : actives, avec au moins 2 produits
        $categories = Category::query()
            ->whereHas('products', fn ($q) => $q->where('status', 1))
            ->withCount(['products as products_count' => fn ($q) => $q->where('status', 1)])
            ->having('products_count', '>=', 2)
            ->orderByDesc('products_count')
            ->get();

        return view('frontend.shop.products.index', compact('products', 'categories'));
    }

    public function show(Product $product) {
        if ($product->status != 1) {
            return redirect()->route('shop.products.index')->with('warning', 'Article indisponible');
        }
        $product->load(['skus','media','category', 'account']);
         // 1) Essayer même catégorie
        $similar = Product::query()
            ->where('status', 1)
            ->whereKeyNot($product->id)
            ->when($product->category_id, fn($q) =>
                $q->where('category_id', $product->category_id)
            )
            ->with(['skus','media','category', 'account'])
            ->inRandomOrder()
            ->take(12)
            ->get();

        // 2) Fallback aléatoire si vide
        if ($similar->isEmpty()) {
            $similar = Product::query()
                ->where('status', 1)
                ->whereKeyNot($product->id)
                ->with(['skus','media','category', 'account'])
                ->inRandomOrder()
                ->take(12)
                ->get();
        }
        $product->registerView();

        return view('frontend.shop.products.show', [
            'product' => $product,
            'similarProducts' => $similar,
        ]);
    }

    // Optionnel: méthode dédiée pour les catégories par slug
    public function category(Request $request, $slug) {
        $request->merge(['c' => $slug]);
        return $this->index($request);
    }

    public function showVendor(Account $account, Request $request) {
        if ($account->status !== 1) {
            abort(404);
        }

        $products = $account->products()
            ->where('status', 1)
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('frontend.shop.vendor', [
            'account'  => $account,
            'products' => $products,
        ]);
    }

    // Cart
    public function __construct(private CartService $cartService) {}

    protected function cart(Request $request) {
        return $this->cartService->current(
            clientId: Auth::id(),
            sessionId: $request->session()->getId()   // pour les invités
        );
    }

    public function cartIndex(Request $request) {
        $cart = $this->cart($request)->load('items.product','items.sku');
        $uid   = Auth::id();
        $email = $uid ? null : session('guest_email'); // fallback invité si on la stocke
        $unpaidOrders = Order::query()
            ->when($uid, fn($q)=>$q->where('user_id', $uid))
            ->when(!$uid && $email, fn($q)=>$q->where('customer_email',$email))
            ->whereIn('status', [0,1])
            ->doesntHave('payments')
            ->latest('id')->take(5)->get();
        return view('frontend.shop.cart', compact('cart','unpaidOrders'));
    }

    public function cartAdd(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_sku_id' => 'nullable|exists:product_skus,id',
            'qty' => 'nullable|integer|min:1'
        ]);
        $cart = $this->cart($request);
        $product = Product::findOrFail($data['product_id']);
        $sku = !empty($data['product_sku_id']) ? ProductSku::findOrFail($data['product_sku_id']) : null;

        $this->cartService->add($cart, $product, $sku, $data['qty'] ?? 1);

        if ($request->filled('buy_now')) {
            return redirect()->route('shop.checkout.index');
        }

        // return redirect()->route('shop.cart.index')->with('success','Ajouté au panier');
        return back()->with('success','Ajouté au panier');
    }

    public function cartUpdate(Request $request, CartItem $item) {
        $data = $request->validate(['qty' => 'required|integer|min:1']);
        app(CartService::class)->updateQty($item, $data['qty']);
        return back();
    }

    public function cartRemove(CartItem $item) {
        app(CartService::class)->remove($item);
        return back();
    }


}
