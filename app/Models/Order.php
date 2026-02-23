<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    use HasFactory;
    protected $fillable = [
        'reference', 'user_id', 'customer_lastname', 'customer_firstname', 'customer_email', 'customer_phone',
        'subtotal', 'discount', 'shipping', 'tax', 'total', 'currency',
        'shipping_address', 'status', 'note', 'account_id', 'moneroo_transaction_id', 'payment_id'
    ];


    protected $casts = [
        'shipping_address' => 'array',
    ];


    const STATUS_PENDING = 0;
    const STATUS_UNDER_REVIEW = 1;
    const STATUS_PAID = 2;
    const STATUS_REJECTED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_FULFILLED = 5;

    public static $statusLabels = [
        self::STATUS_PENDING          => 'En Attente',
        self::STATUS_UNDER_REVIEW     => 'Vérification',
        self::STATUS_PAID             => 'Payée',
        self::STATUS_REJECTED         => 'Rejetée',
        self::STATUS_CANCELLED        => 'Annulée',
        self::STATUS_FULFILLED        => 'Ok',
    ];

    public function getStatusLabelAttribute() {
        return self::$statusLabels[$this->status] ?? 'Inconnu';
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

    public function client() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function payments() {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function paymentMethod() { return $this->belongsTo(PaymentMethod::class); }

}
