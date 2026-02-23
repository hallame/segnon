<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\HasFilters;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class AdminProductController extends Controller {
       use HasFilters;

    public function index(Request $request) {
        $q         = trim($request->get('q', ''));
        $status    = $request->get('status');
        $type      = $request->get('type');
        $category  = $request->get('category_id');

        $products = Product::with(['category','media','firstActiveSku']) // pas besoin de charger tous les SKUs
            ->withCount(['views'])
            ->withSum(['activeSkus as active_skus_stock_sum'],'stock')
            ->withMin(['activeSkus as active_skus_min_price'],'price')
            ->withMax(['activeSkus as active_skus_max_price'],'price')
            ->when($q, fn($b) => $b->where(fn($w) =>
                $w->where('name','like',"%{$q}%")
                  ->orWhere('sku','like',"%{$q}%")
                  ->orWhere('slug','like',"%{$q}%")
            ))
            ->when(isset($status) && $status!=='', fn($b) => $b->where('status', (int)$status))
            ->when($type, fn($b) => $b->where('type', $type))
            ->when($category, fn($b) => $b->where('category_id', $category))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

            $stats = [
                'total'        => Product::count(),
                'active'       => Product::where('status', 1)->count(),
                'inactive'     => Product::where('status', 0)->count(),
                'variants'     => ProductSku::count(),
                'in_stock'     => Product::where('stock','>',0)->count(),
                'out_of_stock' => Product::where('stock','<=',0)->count(),
            ];

        $categories = Category::orderBy('name')->get(['id','name']);
        return view('backend.admin.products.index', compact('products','categories','q','status','type','category', 'stats'));
    }

    public function create() {
        $accounts = Account::query()
            ->where('status',1)
            ->whereHas('modules', fn($m)=>$m->where('slug','artisan'))
            ->orderBy('name')
            ->get(['id','name','is_verified']);
        $categories = Category::orderBy('name')->get(['id','name']);
        return view('backend.admin.products.create', compact('categories', 'accounts'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'category_id'      => ['nullable','exists:categories,id'],
            'sku'              => ['nullable','string','max:64','unique:products,sku'],
            'name'             => ['required','string','max:255'],
            'slug'             => ['nullable','string','max:255','unique:products,slug'],
            'description'      => ['nullable','string'],
            'price'            => ['nullable','numeric','min:0'],
            'old_price'        => ['nullable','numeric','min:0'],
            'currency'         => ['nullable','string','size:3'],
            'stock'            => ['nullable','integer','min:0'],
            'type'             => ['required','in:simple,variable'],
            'weight'           => ['nullable','numeric','min:0'],
            'unit'             => ['nullable','string','max:20'],
            'meta_title'       => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string'],
            'status'           => ['nullable'],
            'account_id'        => 'nullable','integer',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
            'video_url' => 'nullable|url|max:255',
            // 'account_id' => [
            //     'required','integer',
            //     Rule::exists('accounts','id')->where(function($q){
            //     $q->where('status',1)
            //         ->whereHas('modules', fn($m)=>$m->where('slug','hotel'));
            //     }),
            // ],
            // Galerie
            'gallery.*'        => ['nullable','file','mimes:jpg,jpeg,png,webp','max:5120'],

            // Variantes (si variable)
            'skus'                     => ['array'],
            'skus.*.id'                => ['nullable','integer','exists:product_skus,id'],
            'skus.*.sku'               => ['nullable','string','max:64','distinct'],
            'skus.*.attributes_input'  => ['nullable','string','max:500'], // "Couleur=Noir;Taille=M"
            'skus.*.price'             => ['nullable','numeric','min:0'],
            'skus.*.old_price'         => ['nullable','numeric','min:0'],
            'skus.*.currency'          => ['nullable','string','size:3'],
            'skus.*.stock'             => ['nullable','integer','min:0'],
            'skus.*.weight'            => ['nullable','numeric','min:0'],
            'skus.*.unit'              => ['nullable','string','max:20'],
            'skus.*.status'            => ['nullable','boolean'],
        ]);

        if (($data['type'] ?? 'simple') === 'variable') {
            $skus = collect($data['skus'] ?? [])
                ->filter(function ($row) {
                    return filled($row['price'] ?? null) && isset($row['stock']);
                });

            if ($skus->isEmpty()) {
                return back()
                    ->withErrors(['skus' => 'Pour un produit variable, vous devez définir au moins une variante avec prix et stock.'])
                    ->withInput();
            }
        }
        if (!empty($data['currency'])) {
            $data['currency'] = strtoupper($data['currency']);
        }

        $currency = filled($data['currency'] ?? null) ? strtoupper($data['currency']) : 'XOF';

        $slug = filled($data['slug'] ?? null)
            ? $this->makeUniqueSlug(Str::slug($data['slug']))   // slugifier ce que l’admin tape
            : $this->makeUniqueSlug($data['name']);

        $sku  = filled($data['sku'] ?? null)
            ? $this->sanitizeSku($data['sku'])
            : $this->generateUniqueSku($data['name'], $data['category_id'] ?? null);


        DB::transaction(function () use ($request, $data, $slug, $sku, $currency) {
            $product = Product::create([
                'category_id'      => $data['category_id'] ?? null,
                'sku'              => $sku,
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
                'status' => !empty($row['status']) ? 1 : 0,
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
            // Variantes
            if ($product->type === 'variable') {
                $rows = $request->input('skus', []);
                foreach ($rows as $row) {
                    $attrs = $this->parseAttributesString($row['attributes_input'] ?? '');

                    $skuCode = filled($row['sku'] ?? null)
                    ? $this->ensureSkuUniqueness($this->sanitizeSku($row['sku']))
                    : $this->generateUniqueSku($product->name, $product->category_id, $product->id);

                    ProductSku::create([
                        'product_id' => $product->id,
                        'sku'        => $skuCode,
                        'attributes' => $attrs ?: null,
                        'price'      => $row['price']     ?? $product->price,
                        'old_price'  => $row['old_price'] ?? null,
                        'currency'   => strtoupper($row['currency'] ?? $product->currency),
                        'stock'      => $row['stock']     ?? 0,
                        'weight'     => $row['weight']    ?? null,
                        'unit'       => $row['unit']      ?? $product->unit,
                        'status'     => (bool)($row['status'] ?? 1),
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success','Produit ajouté.');
    }

    public function edit(Product $product) {
        $product->load(['skus','media','category']);
        $categories = Category::orderBy('name')->get(['id','name']);
        return view('backend.admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'category_id'      => ['nullable','exists:categories,id'],
            'account_id' => 'nullable','integer',
            'sku'              => ['nullable','string','max:64','unique:products,sku,'.$product->id],
            'name'             => ['required','string','max:255'],
            'slug'             => ['nullable','string','max:255','unique:products,slug,'.$product->id],
            'description'      => ['nullable','string'],
            'price'            => ['nullable','numeric','min:0'],
            'old_price'        => ['nullable','numeric','min:0'],
            'currency'         => ['nullable','string','size:3'],
            'stock'            => ['nullable','integer','min:0'],
            'type'             => ['required','in:simple,variable'],
            'weight'           => ['nullable','numeric','min:0'],
            'unit'             => ['nullable','string','max:20'],
            'meta_title'       => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string'],
            'status'           => ['nullable'],
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
            'video_url' => 'nullable|url|max:255',
            'gallery.*'        => ['nullable','file','mimes:jpg,jpeg,png,webp','max:5120'],

            'skus'                     => ['array'],
            'skus.*.id'                => ['nullable','integer','exists:product_skus,id'],
            'skus.*.sku'               => ['nullable','string','max:64','distinct'],
            'skus.*.attributes_input'  => ['nullable','string','max:500'],
            'skus.*.price'             => ['nullable','numeric','min:0'],
            'skus.*.old_price'         => ['nullable','numeric','min:0'],
            'skus.*.currency'          => ['nullable','string','size:3'],
            'skus.*.stock'             => ['nullable','integer','min:0'],
            'skus.*.weight'            => ['nullable','numeric','min:0'],
            'skus.*.unit'              => ['nullable','string','max:20'],
            'skus.*.status'            => ['nullable','boolean'],
        ]);
        // $validated['account_id'] = $this->resolveAccountId(null, false);


        if (($data['type'] ?? 'simple') === 'variable') {
            $skus = collect($data['skus'] ?? [])
                ->filter(function ($row) {
                    return filled($row['price'] ?? null) && isset($row['stock']);
                });

            if ($skus->isEmpty()) {
                return back()
                    ->withErrors(['skus' => 'Pour un produit variable, vous devez définir au moins une variante avec prix et stock.'])
                    ->withInput();
            }
        }

        $currency = filled($data['currency'] ?? null)
        ? strtoupper($data['currency'])
        : ($product->currency ?? 'XOF');

        $slug = filled($data['slug'] ?? null)
        ? $this->makeUniqueSlug(Str::slug($data['slug']), $product->id)
        : $this->makeUniqueSlug($data['name'], $product->id);

        $sku = filled($data['sku'] ?? null)
        ? $this->ensureSkuUniqueness($this->sanitizeSku($data['sku']), $product->id, null)   // ignore ce produit
        : ($product->sku ?: $this->generateUniqueSku($data['name'], $data['category_id'] ?? null, $product->id));



        DB::transaction(function () use ($request, $data, $product, $slug, $currency, $sku) {
            $product->update([
                'category_id'      => $data['category_id'] ?? null,
                'name'             => $data['name'],
                'sku'               => $sku,
                'currency'          => $currency,
                'slug'             => $slug,
                'description'      => $data['description'] ?? null,
                'price'            => $data['price'],
                'old_price'        => $data['old_price'] ?? null,
                'currency'         => $data['currency'] ?? 'XOF',
                'stock'            => $data['stock'],
                'type'             => $data['type'],
                'weight'           => $data['weight'] ?? null,
                'unit'             => $data['unit'] ?? null,
                'meta_title'       => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'status' => !empty($row['status']) ? 1 : 0,
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



            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    if ($file) $product->addMedia($file)->toMediaCollection('gallery');
                }
            }

            // Sync variantes
            $existingIds = $product->skus()->pluck('id')->all();
            $keepIds = [];
            $rows = $request->input('skus', []);

            foreach ($rows as $row) {
                $attrs = $this->parseAttributesString($row['attributes_input'] ?? '');
                $payload = [
                    'attributes' => $attrs ?: null,
                    'price'      => $row['price']     ?? $product->price,
                    'old_price'  => $row['old_price'] ?? null,
                    'currency'   => strtoupper($row['currency'] ?? $product->currency),
                    'stock'      => $row['stock']     ?? 0,
                    'weight'     => $row['weight']    ?? null,
                    'unit'       => $row['unit']      ?? $product->unit,
                    'status'     => (bool)($row['status'] ?? 1),
                ];

                $skuCode = filled($row['sku'] ?? null)
                        ? $this->ensureSkuUniqueness($this->sanitizeSku($row['sku']), null, $row['id'] ?? null) // ignorer ce SKU si édition
                        : $this->generateUniqueSku($product->name, $product->category_id, $product->id);

                if (!empty($row['id'])) {
                    $sku = ProductSku::where('product_id',$product->id)->findOrFail($row['id']);
                    $sku->update(array_merge($payload, [
                        'sku' => $skuCode, // au lieu de ($row['sku'] ?? $sku->sku)
                    ]));

                    $keepIds[] = $sku->id;
                } else {
                    $sku = $product->skus()->create(array_merge($payload, ['sku' => $skuCode]));
                    $keepIds[] = $sku->id;
                }
            }

            // Supprimer les variantes non présentes
            $toDelete = array_diff($existingIds, $keepIds);
            if (count($toDelete)) {
                ProductSku::whereIn('id', $toDelete)->delete();
            }
        });

        return redirect()->route('admin.products.edit',$product)->with('success','Produit mis à jour.');
    }



    public function destroy(Product $product){


        // 2) Blocage si le produit (ou une de ses variantes) est utilisé dans des commandes
        $usedInOrders = DB::table('order_items')
            ->where('product_id', $product->id)
            ->orWhereIn('product_sku_id', function($q) use ($product) {
                $q->select('id')->from('product_skus')->where('product_id', $product->id);
            })
            ->exists();

        if ($usedInOrders) {
            return back()->with('warning', 'Impossible de supprimer : produit lié à des commandes. Désactivez-le ou archivez-le.');
        }

        try {
            DB::transaction(function () use ($product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->clearMediaCollection('gallery');
                // 4) Suppression : la FK `cascadeOnDelete` supprimera les SKUs
                $product->delete();
            });

            return back()->with('success', 'Produit supprimé.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Suppression impossible pour le moment.');
        }
    }

    public function toggleStatus(Request $request, Product $product) {
        $request->validate(['status' => ['required','in:0,1']]);
        $product->update(['status' => (bool)$request->status]);
        return response()->json(['success'=>true]);
    }

    // public function storeMedia(Request $request, Product $product) {
    //     $request->validate(['file' => ['required','file','mimes:jpg,jpeg,png,webp','max:5120']]);
    //     $media = $product->addMedia($request->file('file'))->toMediaCollection('gallery');
    //     return response()->json(['success'=>true,'id'=>$media->id,'url'=>$media->getUrl()]);
    // }

    public function destroyMedia(Product $product, $mediaId) {
        $media = $product->media()->where('id',$mediaId)->firstOrFail();
        $media->delete();
        return response()->json(['success'=>true]);
    }

    // ==== Helpers ====
    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (Product::where('slug',$slug)
                ->when($ignoreId, fn($q)=>$q->where('id','!=',$ignoreId))
                ->exists()) {
            $slug = Str::limit($base, 60, '') . '-' . $i;
            $i++;
        }
        return $slug;
    }

    private function makeUniqueSku(string $base): string {
        $base = strtoupper(preg_replace('/[^A-Z0-9]+/','-', Str::slug($base,'-')));
        $code = $base;
        $i=2;
        while (Product::where('sku',$code)->exists() || ProductSku::where('sku',$code)->exists()) {
            $code = $base.'-'.$i;
            $i++;
        }
        return $code;
    }

    /** "Couleur=Noir; Taille=M" => ['Couleur'=>'Noir','Taille'=>'M'] */
    private function parseAttributesString(?string $str): array {
        $out = [];
        if (!$str) return $out;
        foreach (explode(';', $str) as $pair) {
            if (!trim($pair)) continue;
            [$k,$v] = array_map('trim', array_pad(explode('=', $pair, 2), 2, ''));
            if ($k !== '') $out[$k] = $v;
        }
        return $out;
    }

    private function sanitizeSku(string $sku): string {
        $sku = strtoupper(trim($sku));
        $sku = preg_replace('/[^A-Z0-9\-]+/', '-', $sku);
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
            $inProducts = Product::where('sku', $code)
                ->when($ignoreProductId, fn($q) => $q->where('id', '!=', $ignoreProductId))
                ->exists();

            $inSkus = ProductSku::where('sku', $code)
                ->when($ignoreSkuId, fn($q) => $q->where('id', '!=', $ignoreSkuId))
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


}
