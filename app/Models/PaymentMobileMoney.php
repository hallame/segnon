<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMobileMoney extends Model {
    protected $fillable = ['payment_method_id', 'operator','wallet_number','wallet_name','qr','reference_hint'];

    public function method() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
}
