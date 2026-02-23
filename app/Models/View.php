<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model {
    use HasFactory;
    protected $fillable = ['viewable_id', 'viewable_type', 'viewer_id', 'viewer_type', 'ip', 'slug',];

   // Relation polymorphique vers les entités vues (Articles ou Profils Experts)
    public function viewable(){
        return $this->morphTo();
    }

    
    // Relation polymorphique vers l'utilisateur qui a vu
    public function viewer(){
        return $this->morphTo();
    }
}
