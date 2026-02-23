<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model {
    use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'language_id', 'slug', 'type', 'model', 'position', 'video'];

    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }


    
    public function activeProducts() {
        return $this->hasMany(Product::class, 'category_id')
                    ->where('status', 1);
    }

    public function hotels() {
        return $this->hasMany(Hotel::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }
}
