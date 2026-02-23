<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Account extends Model {


    const PLAN_FREE     = 'free';
    const PLAN_STANDARD = 'standard';
    const PLAN_PREMIUM  = 'premium';

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'whatsapp',
        'country',
        'city',
        'address',
        'about',
        'is_verified',
        'status',
        'subscription_plan',
        'subscription_ends_at',
        'on_trial',
        'moneroo_subscription_transaction_id',
    ];

    protected $casts = [
        'is_verified'   => 'boolean',
        'status'        => 'integer',
        'on_trial'      => 'boolean',
        'subscription_ends_at' => 'date',
    ];

    protected static function booted(): void {
        static::creating(function ($a) {
            if ($a->slug) return;
            $base = Str::slug($a->name) ?: 'account';
            $slug = $base; $i = 2;
            while (static::where('slug',$slug)->exists()) $slug = $base.'-'.$i++;
            $a->slug = $slug;
        });
    }

    public const STATUS_PENDING = 0;
    public const STATUS_ACTIVE  = 1;
    public const STATUS_BLOCKED = 2;

    public function isActive(): bool { return $this->status === self::STATUS_ACTIVE; }


    public function views(){
        return $this->morphMany(View::class, 'viewable');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class, 'account_id');
    }

    public function orders() {
        return $this->hasManyThrough(
            Order::class,
            OrderItem::class,
            'account_id',  // order_items.account_id -> accounts.id
            'id',          // orders.id
            'id',          // accounts.id
            'order_id'     // order_items.order_id -> orders.id
        )->distinct();
    }



    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }

    public function hotels() {
        return $this->hasMany(Hotel::class);
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'account_users')
            ->withPivot(['is_owner'])
            ->withTimestamps();
    }

    
    public function modules(){
        return $this->belongsToMany(Module::class, 'account_modules')
            ->withPivot(['is_enabled','activated_at'])
            ->withTimestamps();
    }

    public function hasModule(string $slug, bool $onlyEnabled = true): bool {
        $q = $this->modules()->where('slug', $slug);
        if ($onlyEnabled) $q->wherePivot('is_enabled', true);
        return $q->exists();
    }

}
