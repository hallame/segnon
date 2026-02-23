<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'subject', 'message', 'slug',];
    public function client() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
        // now “client” refers to the user who made the booking
        return $this->belongsTo(User::class, 'user_id');
    }
}
