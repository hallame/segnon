<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDay extends Model {
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'bookable_type',
        'bookable_id',
        'day',
    ];

    protected $casts = [
        'day' => 'date',
    ];

    /** Réservation associée **/
    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    /** Ressource réservée (polymorphe) **/
    public function bookable() {
        return $this->morphTo();
    }
}
