<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentBank extends Model {


    protected $fillable = ['payment_method_id', 'bank_name','holder','iban','bic','reference_hint'];

    public function method() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
}
