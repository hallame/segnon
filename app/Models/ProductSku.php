<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ProductSku extends Model {

    use HasFactory;
    protected $fillable = [
        'product_id', 'sku', 'attributes', 'price',
        'old_price', 'currency', 'stock', 'weight',
        'unit', 'status', 'image', 'account_id', 'description'
    ];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getHasPendingSubmissionAttribute(): bool {
        $pendingId = ModerationStatus::idFor('pending'); // helper déjà ajouté
        return $pendingId
            ? $this->submissions()->where('status_id', $pendingId)->exists()
            : false;
    }

    public function views() {
        return $this->morphMany(View::class, 'viewable');
    }

    public function submissions() {
        return $this->morphMany(ContentSubmission::class, 'model');
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

    public function getFeaturedImageAttribute() {
        $cover = $this->getFirstMedia('cover');
        $gallery = $this->getFirstMedia('gallery');

        if ($cover) {
            return $cover->getUrl();
        }

        if ($gallery) {
            return $gallery->getUrl();
        }

        if ($this->image) {
            return asset('storage/'.$this->image);
        }

        return asset('assets/images/products.png');
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
