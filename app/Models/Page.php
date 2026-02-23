<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;

class Page extends Model {
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'content',
        'excerpt',
        'status',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'parent_id',
        'published_at',
        'language_id',
        'banner',
        'video',
        'video_url',
        'type',
        'info',

    ];


  
    public function images() {
        return $this->media()->where('type', 'image');
    }
    public function videos() {
        return $this->media()->where('type', 'video');
    }

    // Relation pour obtenir les pages parente et enfant
    public function parent() {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    // Relation pour obtenir les sous-pages d'une page
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }


    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }



    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function galleries(){
        return $this->morphMany(Gallery::class, 'galleryable');
    }

}
