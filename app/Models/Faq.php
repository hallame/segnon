<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Faq extends Model {

      use HasFactory;

    protected $casts = [
        'active' => 'boolean',
        'position' => 'integer',
    ];

    protected $fillable = [
        'slug', 'question', 'answer', 'account_id', 'category_id', 'position', 'active',
    ];


    // Relations
    public function account() {
        return $this->belongsTo(Account::class);
    }

    // Scopes
    public function scopeSearch($q, ?string $term) {
        if (!empty($term)) {
        $q->where(function($qq) use ($term) {
        $qq->where('question', 'like', "%{$term}%")
        ->orWhere('answer', 'like', "%{$term}%")
        ->orWhere('slug', 'like', "%{$term}%");
        });
        }
        return $q;
    }

    public function scopeActive($q){ return $q->where('active', true); }
    public function scopeOrdered($q){ return $q->orderBy('position')->orderBy('id'); }



    public function category() {
        return $this->belongsTo(Category::class);
    }

}
