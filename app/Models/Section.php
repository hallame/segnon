<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Section extends Model {

    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'type',
        'page',
        'content',
        'btn_text',
        'btn_link',
        'video_url',
        'video',
        'status',
        'image',
        'position',
        'language_id',
        'info',
        'page_id',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }


    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }
}
