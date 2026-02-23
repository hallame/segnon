<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;

class Event extends Model implements HasMedia {


    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'image',
        'category_id',
        'latitude',
        'longitude',
        'map_url',
        'map_description',
        'language_id',
        'video',
        'slug',
        'video_url',
        'status',
        'price'
    ];


    protected static function booted() {
        // Garantir un slug lors de la création (si absent)
        static::creating(function (Event $e) {
            if (empty($e->slug)) {
                $base = $e->name ?: Str::random(8);
                $e->slug = static::generateUniqueSlug($base);
            }
        });

        // Ne jamais écraser un slug existant
        static::updating(function (Event $e) {
            if ($e->isDirty('slug') && !empty($e->getOriginal('slug'))) {
                // si un slug existait déjà, on le restaure
                $e->slug = $e->getOriginal('slug');
            }
            // et si slug est (malgré tout) vide, on en régénère un
            if (empty($e->slug)) {
                $base = $e->name ?: Str::random(8);
                $e->slug = static::generateUniqueSlug($base);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string {
        $slug = Str::slug($name);
        if ($slug === '') {
            $slug = 'evt-'.Str::lower(Str::random(6));
        }

        $original = $slug;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $original.'-'.(++$i);
            if ($i > 50) { // sécurité
                $slug = $original.'-'.Str::lower(Str::random(5));
                break;
            }
        }
        return $slug;
    }



    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public const STATUS_INACTIVE = 0; // non publié
    public const STATUS_ACTIVE   = 1; // publié

    public function isPublished(): bool { return (int)$this->status === self::STATUS_ACTIVE; }


    public function bookings() {
        return $this->morphMany(Booking::class, 'bookable');
    }


    public function registerMediaConversions(?Media $media = null): void {
        $this->addMediaConversion('og')
            ->fit(Fit::Crop, 1200, 630)
            ->performOnCollections('events', 'gallery')
            ->nonQueued(); // retire-le si tu préfères la queue

        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 400, 300)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->fit(Fit::Crop, 736, 464)
            ->sharpen(10);

        $this->addMediaConversion('webp')->format('webp');
    }

    // (optionnel mais propre)
    public function registerMediaCollections(): void {
        $this->addMediaCollection('events')->useDisk('public');
        $this->addMediaCollection('gallery')->useDisk('public');
    }


    public function client() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submissions() {
        return $this->morphMany(ContentSubmission::class, 'model');
    }
    public function user() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function ticketTypes() {
        return $this->hasMany(TicketType::class);
    }

    public function orderTickets() {
        return $this->hasMany(OrderTicket::class);
    }



    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function averageRating(){
        return $this->reviews()->avg('rating') ?? 0; // Si pas d'avis, retourner 0
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

    public function galleries(){
        return $this->morphMany(Gallery::class, 'galleryable');
    }

    public function images() {
        return $this->media()->where('type', 'image');
    }
    public function videos() {
        return $this->media()->where('type', 'video');
    }

    public function registerView(){
        $sessionUserId = Session::get('user_id');
        $sessionUserType = Session::get('user_type');
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
                'ip' => $sessionUserId ? null : request()->ip(),
            ]);
        }
    }

}
