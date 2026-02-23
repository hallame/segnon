<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outing extends Model {
    use SoftDeletes;

    public const STATUS_DRAFT     = 'draft';
    public const STATUS_PENDING   = 'pending';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_CANCELLED = 'cancelled';

    public const VIS_INTERNAL = 'internal';
    public const VIS_PUBLIC   = 'public';

    protected $fillable = [
        'account_id','guide_id','outable_type','outable_id','title','description',
        'start_at','end_at','capacity','booked_count','price',
        'status','visibility','published_at','cancelled_at','created_by','updated_by'
    ];


    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'published_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function account(){ return $this->belongsTo(Account::class); }
    public function guide(){ return $this->belongsTo(Guide::class); }
    public function outable(){ return $this->morphTo(); }


    // Intégration au Booking polymorphe existant
    public function bookings(){ return $this->morphMany(Booking::class, 'bookable'); }




}
