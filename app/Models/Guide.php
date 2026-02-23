<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GuidePlace;

class Guide extends Model {

    use SoftDeletes;

    protected $fillable = [
        'account_id','user_id','firstname','lastname','phone','whatsapp','email','validated_by','validated_at','created_by','notes'
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function outings(){ return $this->hasMany(Outing::class); }

    public function getFullnameAttribute(){ return trim($this->firstname.' '.$this->lastname); }

    public function user(){ return $this->belongsTo(User::class); }


    public function account(){ return $this->belongsTo(Account::class); }


    public function sites() {
        return $this->morphedByMany(Site::class, 'placeable', 'guide_places')
            ->using(GuidePlace::class)
            ->withPivot(['price','is_active','approved','is_primary','pricing_type','min_people','max_people'])
            ->withTimestamps();
    }
    public function museums() {
        return $this->morphedByMany(Museum::class, 'placeable', 'guide_places')
            ->using(GuidePlace::class)
            ->withPivot(['price','is_active','approved','is_primary','pricing_type','min_people','max_people'])
            ->withTimestamps();
    }
    public function monuments() {
        return $this->morphedByMany(Monument::class, 'placeable', 'guide_places')
            ->using(GuidePlace::class)
            ->withPivot(['price','is_active','approved','is_primary','pricing_type','min_people','max_people'])
            ->withTimestamps();
    }

}
