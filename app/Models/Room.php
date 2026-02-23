<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;

class Room extends Model implements HasMedia {


    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'hotel_id',
        'category_id',
        'description',
        'capacity',
        'price',
        'image',
        'status',
        'video',
        'video_url',
        'type',
        'info',
        'address',
        'account_id',
    ];

    protected static function booted(){
        static::creating(function($room){
            $room->account_id ??= optional($room->hotel)->account_id;

            $baseSlug = Str::slug($room->name);
            $slug = $baseSlug;
            $i = 1;
            while (Room::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
            $room->slug = $slug;
        });

    }

    protected $casts = [
        'has_pending_submission' => 'boolean', // pour sérialiser proprement
    ];

    public function account(){
        // account_id est nullable → withDefault() évite les null checks côté Blade
        return $this->belongsTo(Account::class)->withDefault();
    }

    public function getAccountIdAttribute(): ?int {
        return $this->hotel?->account_id;
    }

    function modelAccountId($model): ?int {
        return data_get($model, 'account_id')
            ?? data_get($model, 'hotel.account_id')     // Room -> Hotel
            ?? null;
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


    public function bookings() {
        return $this->morphMany(Booking::class, 'bookable');
    }


    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function images() {
        return $this->media();
    }
    // Optionnel : définir des conversions
    public function registerMediaConversions(?Media $media = null): void {
        $this->addMediaConversion('thumb')->width(400)->height(300)->sharpen(10);
        $this->addMediaConversion('webp')->format('webp');
    }

    public function facilities(){
        return $this->belongsToMany(Facility::class, 'facility_rooms');
    }


    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function averageRating(){
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function reviewsCount(){
        return $this->reviews()->count();
    }

    protected $appends = ['average_rating'];

    public function getAverageRatingAttribute() {
        return round($this->reviews->avg('rating') ?? 0, 2);
    }

    public function views() {
        return $this->morphMany(View::class, 'viewable');
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
