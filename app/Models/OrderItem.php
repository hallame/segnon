<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'product_sku_id', 'product_name',
        'sku_attributes', 'unit_price', 'qty', 'total_price'
    ];

    protected $casts = [
        'sku_attributes' => 'array',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function sku() {
        return $this->belongsTo(ProductSku::class, 'product_sku_id');
    }
}
