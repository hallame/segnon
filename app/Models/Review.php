<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Review extends Model{
    use HasFactory;
    protected $fillable = [
        'reviewable_type',
        'reviewable_id',
        'user_id',
        'rating',
        'slug',
        'comment',
        'language_id',
        'identifier'
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function client() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }
}
