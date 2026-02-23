<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductSku;
use App\Models\Category;
use App\Models\ModerationStatus;
use App\Support\CurrentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SubmissionService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{Auth, DB, Route, Storage};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use App\Models\ContentSubmission;
use App\Models\Country;
use App\Models\Language;
use App\Models\Order;


class PartnerProductController extends Controller {

    protected function authorizeProduct(Product $p): void {
        $accountId = (int) app(CurrentAccount::class)->id();
        abort_if((int) $p->account_id !== $accountId, 403, 'Accès refusé.');
    }


    /** Query scoppée compte + filtres simples */
    protected function scopedQuery(Request $r) {
        $accountId = (int) app(CurrentAccount::class)->id();
        $q        = trim($r->get('q',''));
        $status   = $r->get('status');
        $type     = $r->get('type');
        $category = $r->get('category_id');

        return Product::with(['category','media','firstActiveSku'])
            ->where('account_id', $accountId)
            ->withCount(['views'])
            ->withSum(['activeSkus as active_skus_stock_sum'],'stock')
            ->withMin(['activeSkus as active_skus_min_price'],'price')
            ->withMax(['activeSkus as active_skus_max_price'],'price')
            ->when($q, fn($b)=>$b->where(fn($w)=>
                $w->where('name','like',"%{$q}%")
                  ->orWhere('sku','like',"%{$q}%")
                  ->orWhere('slug','like',"%{$q}%")
            ))
            ->when(isset($status) && $status!=='', fn($b)=>$b->where('status',(int)$status))
            ->when($type, fn($b)=>$b->where('type',$type))
            ->when($category, fn($b)=>$b->where('category_id',$category))
            ->orderByDesc('id');
    }

    public function dashboard(Request $request, CurrentAccount $ctx) {
        $account = $ctx->get();

        if (!$account) {
            return redirect()->route('partners.pending')->with('warning', "Votre compte est en attente.");
        }

        // -------- BOUTIQUE D’ART --------
        $totalProducts = Product::where('account_id', $account->id)->count();
        $totalOrders   = Order::where('account_id', $account->id)->count();
        $totalSubs = ContentSubmission::with(['model','status'])
                ->where('account_id', $account->id)
                ->where('user_id', Auth::id())->count();

        $data = [
            'totalSubs' => $totalSubs,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
        ];

        // Orders
        $orders = tap(Order::where('account_id', $account->id)->latest()->get(), function ($orders) {
            $orders->display = $orders->take(5);
        });
        $totalOrders = $orders->count();
        $ordersData = [
            'orders' => $orders,
            'totalOrders' => $totalOrders
        ];


        //  Statistiques produits
        $products = tap(Product::where('account_id', $account->id)->latest()->get(), function ($products) {
            $products->display = $products->take(6);
        });

        $totalProducts = $products->count();
        $productsData = [
            'products' => $products,
            'totalProducts' => $totalProducts,
        ];


        /// Return ///////////////
        return view('backend.shop.dashboard', array_merge(
            $productsData,
            $ordersData,
            $data,

        ));

    }

    public function index(Request $r) {
        $products   = $this->scopedQuery($r)->paginate(20)->withQueryString();
        $accountId  = (int) app(CurrentAccount::class)->id();
        // Stats du compte
        $stats = [
            'total'    => Product::where('account_id',$accountId)->count(),
            'active'   => Product::where('account_id',$accountId)->where('status',1)->count(),
            'inactive' => Product::where('account_id',$accountId)->where('status',0)->count(),
            'variants' => ProductSku::where('account_id',$accountId)->count(),
        ];

        $categories = Category::where('model','Product')->orderBy('name')->get(['id','name']);

        return view('backend.shop.products.index', [
            'products'   => $products,
            'categories' => $categories,
            'q'          => $r->get('q',''),
            'status'     => $r->get('status',''),
            'type'       => $r->get('type',''),
            'category'   => $r->get('category_id',''),
            'stats'      => $stats,
        ]);
    }

    public function create() {
        $categories = Category::where('model','Product')->where('status', 1)->orderBy('name')->get();
        $accounts = Account::query()
        ->where('status',1)
        ->whereHas('modules', fn($m)=>$m->where('slug','artisan'))
        ->orderBy('name')
        ->get();
        return view('backend.shop.products.create', compact('categories', 'accounts'));
    }

    public function store(Request $request, SubmissionService $submissions) {
        $data = $request->validate([
            'category_id'      => ['nullable','exists:categories,id'],
            'sku'              => ['nullable','string','max:64','unique:products,sku'],
            'name'             => ['required','string','max:255'],
            'slug'             => ['nullable','string','max:255','unique:products,slug'],
            'description'      => ['nullable','string'],

            'price'            => ['nullable','numeric','min:0'],
            'old_price'        => ['nullable','numeric','min:0','gt:price'],
            'currency'         => ['nullable','string','size:3'],
            'stock'            => ['nullable','integer','min:0'],
            'type'             => ['required','in:simple,variable'],
            'weight'           => ['nullable','numeric','min:0'],
            'unit'             => ['nullable','string','max:20'],
            'meta_title'       => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string'],
            'status'           => ['nullable'],

            'image'            => ['nullable','image','max:2048'],
            'video'            => ['nullable','file','mimes:mp4,mov,avi,wmv','max:20480'],
            'video_url'        => ['nullable','url','max:255'],
            'gallery.*'        => ['nullable','file','mimes:jpg,jpeg,png,webp','max:2048'],

            'skus'                     => ['nullable','array'],
            'skus.*.id'                => ['nullable','integer','exists:product_skus,id'],
            'skus.*.sku'               => ['nullable','string','max:64','distinct'],
            'skus.*.attributes_input'  => ['nullable','string','max:500'],
            'skus.*.currency'          => ['nullable','string','size:3'],
            'skus.*.stock'             => ['nullable','integer','min:0'],
            'skus.*.weight'            => ['nullable','numeric','min:0'],
            'skus.*.unit'              => ['nullable','string','max:20'],
            'skus.*.status'            => ['nullable','boolean'],
            'skus.*.price'             => ['nullable','numeric','min:0'],
            'skus.*.old_price'         => [
                'nullable','numeric','min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if (is_null($value)) return;
                    $index = explode('.', $attribute)[1];
                    $price = $request->input("skus.$index.price");
                    if (!is_null($price) && $value <= $price) {
                        $fail('Le prix ancien doit être supérieur au prix actuel pour cette variante.');
                    }
                },
            ],
        ]);

        if (($data['type'] ?? 'simple') === 'variable') {
            $skus = collect($data['skus'] ?? [])
                ->filter(fn($row) => filled($row['price'] ?? null) && isset($row['stock']));
            if ($skus->isEmpty()) {
                return back()
                    ->withErrors(['skus' => 'Pour un produit variable, vous devez définir au moins une variante avec prix et stock.'])
                    ->withInput();
            }
        }

        $accountId = (int) app(CurrentAccount::class)->id();
        $currency  = filled($data['currency'] ?? null) ? strtoupper($data['currency']) : 'XOF';
        $slug = filled($data['slug'] ?? null)
            ? $this->makeUniqueSlug(Str::slug($data['slug']))
            : $this->makeUniqueSlug($data['name']);
        $sku  = filled($data['sku'] ?? null)
            ? $this->sanitizeSku($data['sku'])
            : $this->generateUniqueSku($data['name'], $data['category_id'] ?? null);

        DB::transaction(function () use ($request, $data, $slug, $sku, $currency, $accountId, $submissions) {
            /** @var \App\Models\Product $product */
            $product = Product::create([
                'account_id'       => $accountId ?: null,
                'category_id'      => $data['category_id'] ?? null,
                'sku'              => $this->ensureSkuUniqueness($sku),
                'name'             => $data['name'],
                'slug'             => $slug,
                'description'      => $data['description'] ?? null,
                'price'            => $data['price'],
                'old_price'        => $data['old_price'] ?? null,
                'currency'         => $currency,
                'stock'            => $data['stock'],
                'type'             => $data['type'],
                'weight'           => $data['weight'] ?? null,
                'unit'             => $data['unit'] ?? null,
                'meta_title'       => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'status'           => 0,
            ]);

            // 🔹 Image principale → via Spatie (cover)
            if ($request->hasFile('image')) {
                $media = $product->addMediaFromRequest('image')
                                ->toMediaCollection('cover'); // disk = public par défaut

                // si tu veux remplir la colonne image avec le chemin physique :
                $product->update([
                    'image' => $media->getPathRelativeToRoot(),
                ]);
            }

            // 🔹 Vidéo → stockage direct (si tu en as vraiment besoin)
            if ($request->hasFile('video')) {
                $path = $request->file('video')->store('products/videos', 'public');
                $product->update(['video' => $path]);
            }

            // 🔹 Galerie
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    if ($file) {
                        $product->addMedia($file)->toMediaCollection('gallery');
                    }
                }
            }

            // 🔹 Variantes
            if ($product->type === 'variable') {
                foreach ($request->input('skus', []) as $row) {
                    $attrs   = $this->parseAttributesString($row['attributes_input'] ?? '');
                    $skuCode = filled($row['sku'] ?? null)
                        ? $this->ensureSkuUniqueness($this->sanitizeSku($row['sku']))
                        : $this->generateUniqueSku($product->name, $product->category_id, $product->id);

                    ProductSku::create([
                        'account_id' => $accountId ?: null,
                        'product_id' => $product->id,
                        'sku'        => $skuCode,
                        'attributes' => $attrs ?: null,
                        'price'      => $row['price']     ?? $product->price,
                        'old_price'  => $row['old_price'] ?? null,
                        'currency'   => strtoupper($row['currency'] ?? $product->currency),
                        'stock'      => $row['stock']     ?? 0,
                        'weight'     => $row['weight']    ?? null,
                        'unit'       => $row['unit']      ?? $product->unit,
                        'status'     => !empty($row['status']) ? 1 : 0,
                    ]);
                }
            }

            // 🔹 Payload normalisé pour la modération (sans images pending)
            $payload = Arr::only($data, [
                'category_id','sku','name','slug','description','price','old_price','currency',
                'stock','type','weight','unit','meta_title','meta_description','status',
            ]);

            $submissions->upsertPending($product, $payload, 'create');
        });

        return redirect()->route('partners.shop.products.index')
            ->with('success','Produit soumis à validation. Il sera publié après approbation.');
    }

    public function edit(Product $product) {
        $this->authorizeProduct($product);
        $product->load(['skus','media','category']);
        $categories = Category::where('model','Product')->where('status', 1)->orderBy('name')->get();
        $accounts = Account::query()
        ->where('status',1)
        ->whereHas('modules', fn($m)=>$m->where('slug','artisan'))
        ->orderBy('name')
        ->get();
        return view('backend.shop.products.edit', compact('product','categories', 'accounts'));
    }


    public function update(Request $request, Product $product, SubmissionService $submissions) {
        $this->authorizeProduct($product);

        $data = $request->validate([
            'category_id'      => ['nullable','exists:categories,id'],
            'sku'              => [
                'nullable','string','max:64',
                Rule::unique('products','sku')->ignore($product->id),
            ],
            'name'             => ['required','string','max:255'],
            'slug'             => [
                'nullable','string','max:255',
                Rule::unique('products','slug')->ignore($product->id),
            ],
            'description'      => ['nullable','string'],

            'price'            => ['nullable','numeric','min:0'],
            'old_price'        => ['nullable','numeric','min:0','gt:price'],
            'currency'         => ['nullable','string','size:3'],
            'stock'            => ['nullable','integer','min:0'],
            'type'             => ['required','in:simple,variable'],
            'weight'           => ['nullable','numeric','min:0'],
            'unit'             => ['nullable','string','max:20'],
            'meta_title'       => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string'],
            'status'           => ['nullable'],

            'image'            => ['nullable','image','max:2048'],
            'video'            => ['nullable','file','mimes:mp4,mov,avi,wmv','max:20480'],
            'video_url'        => ['nullable','url','max:255'],
            'gallery.*'        => ['nullable','file','mimes:jpg,jpeg,png,webp','max:2048'],

            'skus'                     => ['nullable','array'],
            'skus.*.id'                => ['nullable','integer','exists:product_skus,id'],
            'skus.*.sku'               => ['nullable','string','max:64','distinct'],
            'skus.*.attributes_input'  => ['nullable','string','max:500'],
            'skus.*.price'             => ['nullable','numeric','min:0'],
            'skus.*.currency'          => ['nullable','string','size:3'],
            'skus.*.stock'             => ['nullable','integer','min:0'],
            'skus.*.weight'            => ['nullable','numeric','min:0'],
            'skus.*.unit'              => ['nullable','string','max:20'],
            'skus.*.status'            => ['nullable','boolean'],
            'skus.*.old_price'         => [
                'nullable','numeric','min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if (is_null($value)) return;
                    $index = explode('.', $attribute)[1];
                    $price = $request->input("skus.$index.price");
                    if (!is_null($price) && $value <= $price) {
                        $fail('Le prix ancien doit être supérieur au prix actuel pour cette variante.');
                    }
                },
            ],
        ]);

        if (($data['type'] ?? 'simple') === 'variable') {
            $skus = collect($data['skus'] ?? [])
                ->filter(fn($row) => filled($row['price'] ?? null) && isset($row['stock']));
            if ($skus->isEmpty()) {
                return back()
                    ->withErrors(['skus' => 'Pour un produit variable, vous devez définir au moins une variante avec prix et stock.'])
                    ->withInput();
            }
        }

        $currency = filled($data['currency'] ?? null) ? strtoupper($data['currency']) : ($product->currency ?? 'XOF');
        $slug = filled($data['slug'] ?? null)
            ? $this->makeUniqueSlug(Str::slug($data['slug']), $product->id)
            : $this->makeUniqueSlug($data['name'], $product->id);
        $sku  = filled($data['sku'] ?? null)
            ? $this->ensureSkuUniqueness($this->sanitizeSku($data['sku']), $product->id, null)
            : ($product->sku ?: $this->generateUniqueSku($data['name'], $data['category_id'] ?? null, $product->id));

        DB::transaction(function () use ($request, $data, $product, $slug, $currency, $sku, $submissions) {
            // Base
            $product->update([
                'category_id'      => $data['category_id'] ?? null,
                'name'             => $data['name'],
                'sku'              => $sku,
                'slug'             => $slug,
                'description'      => $data['description'] ?? null,
                'price'            => $data['price'],
                'old_price'        => $data['old_price'] ?? null,
                'currency'         => $currency,
                'stock'            => $data['stock'],
                'type'             => $data['type'],
                'weight'           => $data['weight'] ?? null,
                'unit'             => $data['unit'] ?? null,
                'meta_title'       => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'status'           => 0,
            ]);

            // Image principale via Spatie
            if ($request->hasFile('image')) {
                $product->clearMediaCollection('cover');

                $media = $product->addMediaFromRequest('image')
                                ->toMediaCollection('cover');

                $product->update([
                    'image' => $media->getPathRelativeToRoot(),
                ]);
            }

            // Vidéo
            if ($request->hasFile('video')) {
                if ($product->video) {
                    Storage::disk('public')->delete($product->video);
                }
                $path = $request->file('video')->store('products/videos','public');
                $product->update(['video' => $path]);
            }

            // Galerie
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    if ($file) {
                        $product->addMedia($file)->toMediaCollection('gallery');
                    }
                }
            }

            // SKUs
            $existingIds = $product->skus()->pluck('id')->all();
            $keepIds = [];

            foreach ($request->input('skus', []) as $row) {
                $attrs = $this->parseAttributesString($row['attributes_input'] ?? '');

                $skuPayload = [
                    'attributes' => $attrs ?: null,
                    'price'      => $row['price']     ?? $product->price,
                    'old_price'  => $row['old_price'] ?? null,
                    'currency'   => strtoupper($row['currency'] ?? $product->currency),
                    'stock'      => $row['stock']     ?? 0,
                    'weight'     => $row['weight']    ?? null,
                    'unit'       => $row['unit']      ?? $product->unit,
                    'status'     => !empty($row['status']) ? 1 : 0,
                ];

                $skuCode = filled($row['sku'] ?? null)
                    ? $this->ensureSkuUniqueness($this->sanitizeSku($row['sku']), null, $row['id'] ?? null)
                    : $this->generateUniqueSku($product->name, $product->category_id, $product->id);

                if (!empty($row['id'])) {
                    $skuModel = ProductSku::where('product_id',$product->id)->findOrFail($row['id']);
                    $skuModel->update(array_merge($skuPayload, ['sku' => $skuCode]));
                    $keepIds[] = $skuModel->id;
                } else {
                    $skuModel = $product->skus()->create(array_merge($skuPayload, ['sku' => $skuCode]));
                    $keepIds[] = $skuModel->id;
                }
            }

            $toDelete = array_diff($existingIds, $keepIds);
            if ($toDelete) {
                ProductSku::whereIn('id', $toDelete)->delete();
            }

            $payload = Arr::only($data, [
                'category_id','sku','name','slug','description','price','old_price','currency',
                'stock','type','weight','unit','meta_title','meta_description','status'
            ]);

            $submissions->upsertPending($product, $payload, 'update');
        });

        return redirect()->route('partners.shop.products.edit',$product)
            ->with('success','Modifications soumises à validation.');
    }



    public function destroy(Product $product) {
        $this->authorizeProduct($product);

        $usedInOrders = DB::table('order_items')
            ->where('product_id', $product->id)
            ->orWhereIn('product_sku_id', function($q) use ($product) {
                $q->select('id')->from('product_skus')->where('product_id', $product->id);
            })
            ->exists();

        if ($usedInOrders) {
            return back()->with('warning','Impossible de supprimer : produit lié à des commandes.');
        }

        DB::transaction(function () use ($product) {
            $product->clearMediaCollection('gallery');
            $product->delete();
        });

        return back()->with('success','Produit supprimé.');
    }


    public function toggleStatus(Request $request, Product $product) {
        $this->authorizeProduct($product);
        $request->validate(['status' => ['required','in:0,1']]);

        if ($request->boolean('status') && $product->has_pending_submission) {
            return response()->json([
                'success' => false,
                'error' => 'Validation admin en attente — publication impossible pour l’instant.'
            ], 422);
        }

        // (Optionnel) tu peux aussi refuser totalement côté partners:
        // if ($request->boolean('status')) abort(403);

        $product->update(['status' => (bool)$request->status]);
        return response()->json(['success'=>true]);
    }

    public function destroyMedia(Product $product, $mediaId) {
        $this->authorizeProduct($product);
        $media = $product->media()->where('id',$mediaId)->firstOrFail();
        $media->delete();
        return response()->json(['success'=>true]);
    }

    // ==== Helpers ====
    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string {
        $base = Str::slug($name);
        $slug = $base; $i = 2;
        while (Product::where('slug',$slug)
            ->when($ignoreId, fn($q)=>$q->where('id','!=',$ignoreId))
            ->exists()) {
            $slug = Str::limit($base, 60, '') . '-' . $i++;
        }
        return $slug;
    }
    private function parseAttributesString(?string $str): array {
        $out = []; if (!$str) return $out;
        foreach (explode(';', $str) as $pair) {
            if (!trim($pair)) continue;
            [$k,$v] = array_map('trim', array_pad(explode('=', $pair, 2), 2, ''));
            if ($k !== '') $out[$k] = $v;
        }
        return $out;
    }
    private function sanitizeSku(string $sku): string {
        $sku = strtoupper(trim($sku));
        $sku = preg_replace('/[^A-Z0-9\-]+/','-', $sku);
        return Str::limit(trim($sku, '-'), 64, '');
    }
    private function generateUniqueSku(string $name, ?int $categoryId = null, ?int $ignoreProductId = null): string {
        $prefix = 'ZMP';
        if ($categoryId && ($cat = Category::find($categoryId))) {
            $prefix = strtoupper(Str::slug(Str::substr($cat->name, 0, 3), ''));
        }
        $base = strtoupper(Str::slug($name, '-')) ?: 'ITEM';
        $candidate = $this->sanitizeSku("{$prefix}-{$base}");
        return $this->ensureSkuUniqueness($candidate, $ignoreProductId);
    }

    private function ensureSkuUniqueness(string $candidate, ?int $ignoreProductId = null, ?int $ignoreSkuId = null): string {
        $sku = $candidate; $i = 1;
        $exists = function ($code) use ($ignoreProductId, $ignoreSkuId) {
            $inProducts = Product::where('sku',$code)
                ->when($ignoreProductId, fn($q)=>$q->where('id','!=',$ignoreProductId))
                ->exists();
            $inSkus = ProductSku::where('sku',$code)
                ->when($ignoreSkuId, fn($q)=>$q->where('id','!=',$ignoreSkuId))
                ->exists();
            return $inProducts || $inSkus;
        };
        while ($exists($sku)) {
            $suffix = '-'.str_pad((string)$i, 3, '0', STR_PAD_LEFT);
            $sku = Str::limit($candidate, 64 - strlen($suffix), '').$suffix;
            $i++;
        }
        return $sku;
    }

     //// Profile + Settings
    public function editProfile(CurrentAccount $ctx) {
        $user = Auth::user();
        $account = $ctx->get();
        return view('backend.shop.profile', compact('user','account'));
    }


    public function updateProfile(Request $r, CurrentAccount $ctx) {
        $user = Auth::user();
        $account = $ctx->get();

        $data = $r->validate([
            // User
            'firstname'        => ['required','string','max:120'],
            'lastname'         => ['required','string','max:120'],
            'phone'            => ['nullable','string','max:60'],
            'whatsapp'         => ['nullable','string','max:60'],

            // Account
            'account_name'     => ['required','string','max:255'],
            'account_email'    => ['nullable','email','max:190'],
            'account_phone'    => ['nullable','string','max:60'],
            'account_whatsapp' => ['nullable','string','max:60'],
            'account_country'  => ['nullable','string','max:120'],
            'account_city'     => ['nullable','string','max:120'],
            'account_address'  => ['nullable','string','max:255'],
            'account_about'    => ['nullable','string'],
        ]);

        // 1) Mise à jour User
        $user->fill([
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'phone'     => $data['phone'] ?? null,
            'whatsapp'  => $data['whatsapp'] ?? null,
        ])->save();

        // 2) Mise à jour Account courant (si présent)
        if ($account) {
            $account->fill([
                'name'      => $data['account_name'],
                'email'     => $data['account_email'] ?? null,
                'phone'     => $data['account_phone'] ?? null,
                'whatsapp'  => $data['account_whatsapp'] ?? null,
                'country'   => $data['account_country'] ?? null,
                'city'      => $data['account_city'] ?? null,
                'address'   => $data['account_address'] ?? null,
                'about'     => $data['account_about'] ?? null,
            ])->save();
        }

        return back()->with('success', 'Profil et compte mis à jour.');
    }
    public function updateProfile1(Request $r) {
        $user = Auth::user();

        $data = $r->validate([
            'firstname' => ['required','string','max:120'],
            'lastname'  => ['required','string','max:120'],
            'phone'     => ['nullable','string','max:60'],
            'whatsapp'  => ['nullable','string','max:60'],
            // 'email'     => ['nullable','email','max:190', Rule::unique('users','email')->ignore($user->id)],
        ]);

        // 1) Mise à jour User
        $user->fill($data)->save();
        return back()->with('success', 'Profil mis à jour.');
    }

    public function editSettings() {
        $user = Auth::user();
        return view('backend.shop.settings', compact('user'));
    }
    public function updateSettings(Request $r) {
        $r->validate([
            'current_password' => ['required','current_password'],
            'password'         => ['required','string','min:8','confirmed','different:current_password'],
        ]);
        $r->user()->update(['password' => Hash::make($r->input('password'))]);
        return back()->with('success', 'Mot de passe mis à jour.');
    }

    //submissions
    public function submissions(Request $request) {
        $accountId = app(CurrentAccount::class)->id();
        $subs = ContentSubmission::with(['model','status'])
            ->where('account_id', $accountId)
            ->where('user_id', Auth::id())
            ->when($request->filled('status'), function ($q) use ($request) {
                $statusId = ModerationStatus::idFor((string)$request->string('status'));
                if ($statusId) $q->where('status_id', $statusId);
            })
            ->when($request->filled('type'), function ($q) use ($request) {

                $map = [
                    'hotel'    => \App\Models\Hotel::class,
                    'room'     => \App\Models\Room::class,
                    'product'  => \App\Models\Product::class,
                    'order'    => \App\Models\Order::class,
                    'booking'  => \App\Models\Booking::class,
                    'site'     => \App\Models\Site::class,
                    'event'    => \App\Models\Event::class,

                ];

                if ($request->filled('type')) {
                    $type = strtolower($request->string('type')->toString()); // cast en string
                    $cls  = $map[$type] ?? null;
                    if ($cls) {
                        $q->where('model_type', $cls);
                    }
                }
            })
            ->latest()->paginate(20)->withQueryString();
        return view('backend.shop.submissions.index', compact('subs'));
    }

    public function submissionShow(ContentSubmission $submission) {
        abort_unless((int)$submission->account_id === (int)app(CurrentAccount::class)->id(), 403);
        abort_unless((int)$submission->user_id === (int)Auth::id(), 403); // limiter à l’auteur
        $submission->load(['model','status']);
        return view('backend.shop.submissions.show', compact('submission'));
    }
}
