<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCod extends Model {
    protected $fillable = ['payment_method_id','phone','note'];

    public function method() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
}
