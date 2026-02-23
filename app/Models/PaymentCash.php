<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCash extends Model
{
    protected $fillable = ['payment_method_id','address','hours','phone'];

    public function method() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
}
