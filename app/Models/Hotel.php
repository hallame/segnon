<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Mews\Purifier\Facades\Purifier;
use Spatie\MediaLibrary\Conversions\Manipulations as ConversionsManipulations;
use App\Support\TextCleaner;
use App\Support\MsoCleaner;
class Hotel extends Model implements HasMedia {

    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'phone',
        'email',
        'description',
        'free_rooms',
        'total_rooms',
        'address',
        'city',
        'country_id',
        'category_id',
        'language_id',
        'image',
        'status',
        'latitude',
        'longitude',
        'type',
        'video',
        'video_url',
        'info',
        'account_id',
    ];

    protected static function booted(){
        static::deleting(function ($hotel) {
            $hotel->facilities()->detach();
            $hotel->reviews()->delete();
            $hotel->views()->delete();
        });

        static::creating(function ($hotel) {
            $baseSlug = Str::slug($hotel->name);
            $slug = $baseSlug;
            $i = 1;
            while (Hotel::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
            $hotel->slug = $slug;
        });


        static::creating(function ($h) {
            // forcer invisibilité par défaut
            if (is_null($h->status)) $h->status = 0;
        });
    }

    protected $casts = [
        'has_pending_submission' => 'boolean', // pour sérialiser proprement
    ];

    public function account(){
        // account_id est nullable → withDefault() évite les null checks côté Blade
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

    public function registerMediaConversions(?Media $media = null): void {
        $this->addMediaConversion('thumb')
            ->fit('crop', 400, 300)
            ->performOnCollections('gallery')      // + 'cover' si tu l'ajoutes
            ->nonQueued(); //  si pas de  worker

        $this->addMediaConversion('web')
            ->format('webp')
            ->width(1600)
            ->performOnCollections('gallery')
            ->nonQueued(); //  si pas de  worker
    }



    public function registerMediaCollections(): void {
        $this->addMediaCollection('cover')->singleFile();   // image principale
        $this->addMediaCollection('gallery');               // galerie
    }


    public function rooms() {
        return $this->hasMany(Room::class);
    }

    public function getMinPriceAttribute() {
        return number_format($this->rooms->min('price') ?? 0, 0, '', ' ');
    }

    public function facilities(){
        return $this->belongsToMany(Facility::class, 'facility_hotels');
    }


    public function latestSubmission() {
        return $this->morphOne(ContentSubmission::class, 'model')->latestOfMany();
    }

    public function bookings() {
        return $this->hasManyThrough(
            Booking::class,   // modèle final
            Room::class,      // modèle intermédiaire
            'hotel_id',       // clé étrangère sur rooms -> hotels.id
            'bookable_id',    // "clé" sur bookings pointant vers rooms.id
            'id',             // clé locale hotels.id
            'id'              // clé locale rooms.id
        )->where('bookable_type', Room::class); // filtre polymorphique
    }


    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function views(){
        return $this->morphMany(View::class, 'viewable');
    }


    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }


    public function averageRating(){
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function reviewsCount(){
        return $this->reviews()->count();
    }

    public function viewsCount(){
        return $this->views()->count();
    }

    public function roomsCount(){
        return $this->rooms()->count();
    }

    public function reservationsCount(){
        return $this->reservations()->count();
    }


    protected $appends = ['average_rating'];

    public function getAverageRatingAttribute() {
        return round($this->reviews->avg('rating') ?? 0, 2);
    }

    public function galleries(){
        return $this->morphMany(Gallery::class, 'galleryable');
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



    public function getExcerptAttribute(): string {
        $plain = MsoCleaner::toTextForHotel(
            $this->description ?? '',
            $this->name ?? null,
            $this->city ?? null,
            optional($this->country)->name
        );

        // Fallback si vide (brutal mais sûr)
        if ($plain === '' && $this->description) {
            $tmp = html_entity_decode(strip_tags($this->description), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $plain = preg_replace('/\s+/u', ' ', trim($tmp));
        }

        return Str::limit(preg_replace("/\R+/u", ' ', $plain), 180);
    }

    public function getSafeDescriptionAttribute(): string {
        $html = MsoCleaner::toSafeHtml($this->description ?? '');

        // Fallback HTML minimal si tout a été vidé
        if (trim(strip_tags($html)) === '' && $this->description) {
            $txt = html_entity_decode(strip_tags($this->description), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $txt = preg_replace('/\s+/u', ' ', trim($txt));
            return '<p>'.e($txt).'</p>';
        }

        return $html;
    }


}

