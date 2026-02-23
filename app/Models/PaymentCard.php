<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PaymentCard extends Model {
    protected $fillable = ['payment_method_id','provider','public_key','secret_key'];
    public function method() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
}
