<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model {

    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'type',
        'page',
        'status',
        'image',
        'position',
        'language_id',
        'page_id',
        'link',
    ];

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function views() {
        return $this->morphMany(View::class, 'viewable');
    }

    public function getFirstWordsAttribute() {
        $words = explode(' ', $this->title);
        $count = count($words);
        if ($count <= 2) {
            return '';
        }
        return implode(' ', array_slice($words, 0, $count - 2));
    }

    public function getLastWordsAttribute() {
        $words = explode(' ', $this->title);
        $count = count($words);
        if ($count <= 2) {
            return $this->title;
        }
        return implode(' ', array_slice($words, -2));
    }
}
