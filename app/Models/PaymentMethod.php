<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {
    use HasFactory;
    protected $fillable = ['key', 'name', 'instructions', 'active','type', 'position', 'icon'];

    protected $casts = [
        'active' => 'boolean',
    ];
    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function mobileMoney() { return $this->hasOne(PaymentMobileMoney::class); }
    public function bank()        { return $this->hasOne(PaymentBank::class); }
    public function cash()        { return $this->hasOne(PaymentCash::class); }
    public function card()        { return $this->hasOne(PaymentCard::class); }
    public function cod()         { return $this->hasOne(PaymentCod::class); }
}
