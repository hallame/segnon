<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'details',
        'address',
        'phone',
        'email',
        'map_link',
        'status',
    ];
}
