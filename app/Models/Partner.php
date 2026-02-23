<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Partner extends Model {
    use HasFactory;
    protected $fillable = [
        'lastname',
        'firstname',
        'username',
        'contact',
        'slug',
        'email',
        'phone',
        'address',
        'description',
        'website',
        'logo',
        'status',
        'site_id',
        'category_id',
        'language_id',
        'company',
        'position',
        'image',

    ];

    /**
     * Relation avec le site (si applicable)
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function reviews() {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
