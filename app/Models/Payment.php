<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Payment extends Model implements HasMedia {
    use InteractsWithMedia,  HasFactory;

    protected $fillable = [
        'payable_id', 'payable_type', 'payment_method_id',
        'amount', 'currency', 'transaction_number',
        'status', 'submitted_at', 'verified_at', 'verified_by', 'note',
        'user_id', 'reference'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];


    const STATUS_SUBMITTED = 0;
    const STATUS_VERIFIED = 1;
    const STATUS_REJECTED = 2;

    public function payable() {
        return $this->morphTo();
    }

    public function method() {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function client() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submittedPayment() {
        return $this->morphOne(Payment::class, 'payable')
            ->where('status', Payment::STATUS_SUBMITTED)
            ->latestOfMany();
    }

    public function verifiedPayment() {
        return $this->morphOne(Payment::class, 'payable')
            ->where('status', Payment::STATUS_VERIFIED)
            ->latestOfMany();
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('receipt')->useDisk('public');
    }

}

