<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class GuidePlace extends MorphPivot {


    protected $casts = [
        'price'       => 'decimal:2',
        'min_people'  => 'integer',
        'max_people'  => 'integer',
        'is_active'   => 'bool',
        'approved'    => 'bool',
        'is_primary'  => 'bool',
    ];

     public $incrementing = true; // on a un id()
    public $timestamps = true;


    protected $table = 'guide_places';

    protected $fillable = [
        'guide_id','placeable_type','placeable_id',
        'price','currency','pricing_type','min_people','max_people',
        'is_active','approved','is_primary',
    ];

    public function guide(){ return $this->belongsTo(Guide::class); }
    public function placeable(){ return $this->morphTo(); }




}
