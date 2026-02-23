<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Country extends Model {
    use HasFactory;

    protected $fillable = ['name', 'iso_code', 'country_code', 'status', 'language_id', 'slug',];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
