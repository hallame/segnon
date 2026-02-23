<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model {

    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'status',
        'image',
    ];

    public function rooms(){
        return $this->belongsToMany(Room::class, 'facility_rooms');
    }


    public function hotels() {
        return $this->belongsToMany(Hotel::class, 'facility_hotels');
    }

}
