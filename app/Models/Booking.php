<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Booking extends Model {
    use HasFactory;
    protected $fillable = [
        'bookable_type',
        'bookable_id',
        'user_id',
        'check_in',
        'check_out',
        'guests',
        'is_group',
        'unit_price',
        'amount',
        'pricing_details',
        'status',
        'payment_status',
        'payment_method',
        'payment_due_at',
        'payment_receipt_path',
        'payment_reference',
        'reference',
        'confirmation_code',
        'source',
        'note',
        'cancellation_reason',
        'language_id',
        'assigned_guide_id'
    ];

    protected $casts = [
        'check_in'       => 'datetime',
        'check_out'         => 'datetime',
        'payment_due_at'   => 'datetime',
        'pricing_details'  => 'array',
        'is_group'         => 'boolean',
    ];


     /** Status réservation **/
    public const STATUS_PENDING   = 0;
    public const STATUS_CONFIRMED = 1;
    public const STATUS_CANCELLED = 2;
    public const STATUS_COMPLETED = 3;

    /** Status paiement **/
    public const PAY_UNPAID        = 0;
    public const PAY_AWAITING_VERIF = 1;
    public const PAY_VERIFIED       = 2;
    public const PAY_REJECTED       = 3;



    // Libellés centralisés
    public const STATUS_LABELS = [
        self::STATUS_PENDING   => 'En attente',
        self::STATUS_CONFIRMED => 'Confirmée',
        self::STATUS_CANCELLED => 'Annulée',
        self::STATUS_COMPLETED => 'Terminée',
    ];
    public const PAYMENT_LABELS = [
        self::PAY_UNPAID         => 'Impayé',
        self::PAY_AWAITING_VERIF => 'À vérifier',
        self::PAY_VERIFIED       => 'Payé (vér.)',
        self::PAY_REJECTED       => 'Rejeté',
    ];

    protected static function booted() {
        static::creating(function (Booking $b) {
            if (empty($b->reference)) {
                $b->reference = self::generateUniqueReference();
            }
            // essaie de déduire l’account_id s’il n’est pas fourni
            if (empty($b->account_id) && $b->bookable_type && $b->bookable_id) {
                try {
                    $class = $b->bookable_type;
                    $bk = $class::find($b->bookable_id);
                    if ($bk) {
                        // room -> hotel.account_id ; sinon -> account_id direct
                        $b->account_id = data_get($bk, 'account_id')
                                    ?? data_get($bk, 'hotel.account_id')
                                    ?? app(\App\Support\CurrentAccount::class)->id();
                    }
                } catch (\Throwable $e) {
                    // no-op
                }
            }
        });
    }


    public function payments() {
        return $this->morphMany(Payment::class, 'payable');
    }
    
     // Helpers pratiques (pour contrôleurs/blades)
    public static function statusOptions(): array   { return self::STATUS_LABELS; }
    public static function paymentOptions(): array  { return self::PAYMENT_LABELS; }
    public static function statusLabel(int $v): string  { return self::STATUS_LABELS[$v]  ?? '—'; }
    public static function paymentLabel(int $v): string { return self::PAYMENT_LABELS[$v] ?? '—'; }


    public function client() {
        // alias “client” -> users.user_id
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getClientNameAttribute(): ?string {
        $u = $this->client;
        if (!$u) return null;

        // Essaie first/last, sinon fallback sur name
        $first = $u->firstname ?? $u->first_name ?? null;
        $last  = $u->lastname  ?? $u->last_name  ?? null;

        $full = trim(($first ?? '').' '.($last ?? ''));
        return $full !== '' ? $full : ($u->name ?? null);
    }

    public function getClientEmailAttribute(): ?string {
        return $this->client->email ?? null;
    }

    public function getClientPhoneAttribute(): ?string {
        return $this->client->phone ?? null;
    }


    public function getStatusLabelAttribute(): string {
        return self::statusLabel((int)$this->status);
    }

    public function getPaymentLabelAttribute(): string {
        return self::paymentLabel((int)$this->payment_status);
    }



    public function getNightsAttribute(): ?int {
        if (!$this->check_in || !$this->check_out) return null;
        return $this->check_in->diffInDays($this->check_out);
    }

    public function getStatusBadgeClassAttribute(): string {
        return [
            self::STATUS_PENDING   => 'badge bg-warning text-dark',
            self::STATUS_CONFIRMED => 'badge bg-info',
            self::STATUS_CANCELLED => 'badge bg-danger',
            self::STATUS_COMPLETED => 'badge bg-success',
        ][$this->status] ?? 'badge bg-light text-dark';
    }

    public function getPaymentBadgeClassAttribute(): string {
        return [
            self::PAY_UNPAID         => 'badge bg-secondary',
            self::PAY_AWAITING_VERIF => 'badge bg-warning text-dark',
            self::PAY_VERIFIED       => 'badge bg-success',
            self::PAY_REJECTED       => 'badge bg-danger',
        ][$this->payment_status] ?? 'badge bg-light text-dark';
    }


    // Quel type ?
    public function getBookableTypeLabelAttribute(): string {
        return [
            \App\Models\Site::class    => 'Site',
            \App\Models\Circuit::class => 'Circuit',
            \App\Models\Room::class    => 'Chambre',
            \App\Models\Event::class   => 'Événement',
        ][$this->bookable_type] ?? class_basename($this->bookable_type ?? '') ?: '—';
    }

    // Nom lisible de l’élément
    public function getBookableNameAttribute(): string {
        $b = $this->bookable;
        return $b->name ?? $b->title ?? $b->label ?? '—';
    }



    public static function generateUniqueReference(): string {
        do {
            $reference = 'ZMB' . strtoupper(Str::random(6));
        } while (self::where('reference', $reference)->exists());
        return $reference;
    }

    /** Relation polymorphe vers l'élément réservé **/
    public function bookable() {
        return $this->morphTo();
    }

    /** Jours réservés **/
    public function days() {
        return $this->hasMany(BookingDay::class);
    }



    public function getHotelAttribute(): ?\App\Models\Hotel {
        return $this->bookable instanceof \App\Models\Room ? $this->bookable->hotel : null;
    }

    public function getHotelNameAttribute(): ?string {
        return $this->hotel?->name;
    }

    public function getRoomNameAttribute(): ?string {
        return $this->bookable instanceof \App\Models\Room ? $this->bookable->name : null;
    }


    public function guide() {
        return $this->belongsTo(\App\Models\Guide::class, 'assigned_guide_id');
    }

    /** Lieu éligible pour l’assignation (Site/Museum/Monument via Outing ou direct) */
    public function assignablePlace() {
        $bookable = $this->bookable;
        if (!$bookable) return null;

        if ($bookable instanceof \App\Models\Outing) {
            $bookable->loadMissing('outable');
            return $bookable->outable; // Site|Museum|Monument
        }
        if ($bookable instanceof \App\Models\Site
            || $bookable instanceof \App\Models\Museum
            || $bookable instanceof \App\Models\Monument) {
            return $bookable;
        }
        return null;
    }


}
