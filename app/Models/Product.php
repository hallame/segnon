<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;

class Product extends Model implements HasMedia {
    use InteractsWithMedia, HasFactory;

    protected $fillable = [
        'category_id', 'sku', 'name', 'slug', 'description',
        'price', 'old_price', 'currency', 'stock',
        'type', 'weight', 'unit',
        'meta_title', 'meta_description', 'status', 'image', 'account_id',
        'video',
        'video_url',
    ];


    protected $casts = [
        'status' => 'boolean',
    ];

    public function registerMediaConversions(?Media $media = null): void {
        $this->addMediaConversion('og')
            ->fit(Fit::Crop, 1200, 630)
            ->performOnCollections('products', 'gallery')
            ->nonQueued(); // à retirer si tu préfères passer par la queue

        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 400, 300)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->fit(Fit::Crop, 736, 464)
            ->sharpen(10);

        $this->addMediaConversion('webp')->format('webp');
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('products')->useDisk('public');
        $this->addMediaCollection('gallery')->useDisk('public');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function views() {
        return $this->morphMany(View::class, 'viewable');
    }

    public function skus() {
        return $this->hasMany(ProductSku::class);
    }

    public function account(){
        return $this->belongsTo(Account::class)->withDefault();
    }

    public function getHasPendingSubmissionAttribute(): bool {
        $pendingId = ModerationStatus::idFor('pending'); // helper déjà ajouté
        return $pendingId
            ? $this->submissions()->where('status_id', $pendingId)->exists()
            : false;
    }

    public function submissions() {
        return $this->morphMany(ContentSubmission::class, 'model');
    }

    public function activeSkus() {
        return $this->hasMany(ProductSku::class)->where('status', 1);
    }

    // Récupère 1 SKU actif (le 1er) pour la devise (Laravel 8.42+ ofMany)
    public function firstActiveSku() {
        return $this->hasOne(ProductSku::class)->where('status', 1)->ofMany([], 'min'); // min(id)
    }

    /** Devise d’affichage (variable => devise du 1er SKU actif, sinon devise produit) */
    public function currency(): string {
        return $this->type === 'variable'
            ? ($this->firstActiveSku->currency ?? $this->currency)
            : $this->currency;
    }

    /** Stock total d’affichage */
    public function totalStock(): int {
        return $this->type === 'variable'
            ? (int) ($this->active_skus_stock_sum ?? 0)
            : (int) $this->stock;
    }

    /** Plage de prix (min, max) ; pour simple => [price, price] */
    public function priceRange(): array {
        if ($this->type === 'variable') {
            return [
                $this->active_skus_min_price, // peut être null si aucun SKU actif
                $this->active_skus_max_price,
            ];
        }
        return [$this->price, $this->price];
    }




    public function getFeaturedImageAttribute() {
        // Essayer plusieurs méthodes pour obtenir l'URL
        $getUrlMethods = [
            // Méthode 1: Priorité cover avec getUrl()
            fn() => $this->getFirstMedia('cover')?->getUrl(),

            // Méthode 2: Priorité gallery avec getUrl()
            fn() => $this->getFirstMedia('gallery')?->getUrl(),

            // Méthode 3: Priorité cover avec asset(storage/path)
            fn() => ($cover = $this->getFirstMedia('cover'))
                ? asset('storage/' . $cover->getPathRelativeToRoot())
                : null,

            // Méthode 4: Priorité gallery avec asset(storage/path)
            fn() => ($gallery = $this->getFirstMedia('gallery'))
                ? asset('storage/' . $gallery->getPathRelativeToRoot())
                : null,

            // Méthode 5: Image stockée en base de données
            fn() => $this->image
                ? asset('storage/' . $this->image)
                : null,
        ];

        // Essayer chaque méthode jusqu'à trouver une URL valide
        foreach ($getUrlMethods as $method) {
            if ($url = $method()) {
                // Vérifier si l'URL est accessible (optionnel)
                if ($this->isValidImageUrl($url)) {
                    return $url;
                }
            }
        }

        // Dernier recours: image par défaut
        return asset('assets/images/products.png');
    }

    /**
     * Vérifie si une URL d'image est valide
     */
    protected function isValidImageUrl($url){
        // Pour les URL locales, vérifier si le fichier existe
        if (strpos($url, asset('')) === 0) {
            $path = str_replace(asset(''), '', $url);
            $fullPath = public_path($path);

            // Si c'est une URL storage, adapter le chemin
            if (strpos($path, 'storage/') === 0) {
                $relativePath = str_replace('storage/', '', $path);
                $fullPath = storage_path('app/public/' . $relativePath);
            }

            return file_exists($fullPath);
        }

        // Pour les URL externes ou CDN, retourner true (à adapter selon besoins)
        return true;
    }

    // Méthode pour obtenir le prix d'affichage
    public function getDisplayPriceAttribute() {
        if ($this->type === 'simple') {
            return $this->price;
        }

        // Pour variable, retourner le prix minimum des SKUs actifs
        return $this->skus->where('status', 1)->min('price');
    }

    // Méthode pour vérifier la disponibilité
    public function getIsInStockAttribute() {
        if ($this->type === 'simple') {
            return $this->stock > 0;
        }
        // Pour variable, vérifier le stock total des SKUs actifs
        return $this->skus->where('status', 1)->sum('stock') > 0;
    }

    public function registerView(){
        $sessionUserId = Session::get('user_id'); // ID de l'utilisateur depuis la session
        $sessionUserType = Session::get('user_type'); // Type de l'utilisateur depuis la session
        // Vérifier si l'utilisateur a déjà vu l'article aujourd'hui
        $existingView = View::where('viewable_type', self::class)
            ->where('viewable_id', $this->id)
            ->when($sessionUserId, fn($query) =>
                $query->where('viewer_id', $sessionUserId)
                    ->where('viewer_type', $sessionUserType))
            ->when(!$sessionUserId, fn($query) => $query->where('ip', request()->ip()))
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if (!$existingView) {
            View::create([
                'viewable_type' => self::class,
                'viewable_id' => $this->id,
                'viewer_type' => $sessionUserId ? $sessionUserType : null,
                'viewer_id' => $sessionUserId ?: null,
                'ip' => $sessionUserId ? null : request()->ip(), // Si non connecté, stocker l'IP
            ]);
        }
    }

}

