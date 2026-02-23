<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Support\Platform;
use Illuminate\Database\Eloquent\Casts\Attribute;
 /**
  * @method bool hasRole(string|array ...$roles)
  * @method bool hasAnyRole(...$roles)
  * @method bool can($ability, ...$arguments)
  */

class User extends Authenticatable implements MustVerifyEmail {
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'username',
        'password',
        'default_account_id',
        'status',
        'phone', 'locale',
        'address', 'last_login_at',
        'avatar', 'email_verified_at',
         'whatsapp',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    protected $hidden = ['password','remember_token'];

    public const STATUS_PENDING = 0;
    public const STATUS_ACTIVE  = 1;
    public const STATUS_BLOCKED = 2;

    public function isActive(): bool { return $this->status === self::STATUS_ACTIVE; }
    public function isBanned(): bool { return $this->status === self::STATUS_BLOCKED; }

    // IMPORTANT pour Spatie si tu gardes un seul guard:
    protected string $guard_name = 'web';

    protected static function booted() {
        static::saving(function ($user) {
            \Log::info("User saving  {$user->email}", [
                'id' => $user->id,
                'last_login_at' => $user->last_login_at,
                'dirty' => $user->getDirty(),
            ]);
        });
    }

    public function accounts(): BelongsToMany {
        return $this->belongsToMany(Account::class, 'account_users')
            ->withPivot(['is_owner'])
            ->withTimestamps();
    }

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
    }


    public function scopePartner($q) {
        return $q->whereHas('accounts');
    }

    public function getFullNameAttribute(): string {
        return trim($this->lastname . ' ' . $this->firstname) ?: 'Utilisateur inconnu';
    }

    public function scopeNotStaff($q) {
        // rôles internes à exclure du listing partenaires
        $staff = ['super_admin','moderator','finance_admin','support','developer'];
        return $q->whereDoesntHave('roles', fn($r) => $r->whereIn('name', $staff));
    }

    /** Optionnel : exclure l’account “équipe principale” si vous en avez un */
    public function scopeWithoutMainAccount($q, ?int $mainAccountId) {
        if (!$mainAccountId) return $q;
        return $q->whereDoesntHave('accounts', fn($a) => $a->whereKey($mainAccountId));
    }


    public function isSuperAdmin(): bool {
        $teamKey = config('permission.team_foreign_key', 'account_id');
        $platformId = Platform::id();
        if (!$platformId) return false;

        return $this->roles()
            ->where('roles.name', 'super_admin')
            ->where("model_has_roles.$teamKey", $platformId)
            ->exists();
    }

    public function isMega(): bool {
        // bypass dev (voir Gate::before)
        return $this->hasRole('developer') || in_array($this->email, config('mega.emails', []));
    }

   public function getAvatarUrlAttribute(): string {
        $path = $this->avatar;

        if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            // nécessite APP_URL + `php artisan storage:link`
            return asset('storage/'.$path);
        }
        return asset('assets/images/admin.png');
    }


    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function payments() {
        return $this->morphMany(Payment::class, 'payable');
    }


    protected function fullname(): Attribute {
        return Attribute::get(function () {
            $fn = trim((string) $this->firstname);
            $ln = trim((string) $this->lastname);

            $full = trim($fn.' '.$ln);
            if ($full !== '') return $full;

            // fallback si pas de prénom/nom
            if (!empty($this->name))  return (string) $this->name;
            if (!empty($this->email)) return (string) $this->email;

            return '—';
        });
    }

}

