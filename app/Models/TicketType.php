<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model {
    use HasFactory;

    protected $fillable = [
        'event_id',
        'account_id',
        'name',
        'sku',
        'price',
        'quantity',
        'description',
        'features',
        'is_refundable',
        'is_active',
        'sales_start',
        'sales_end',
        'max_per_order',
        'metadata',
    ];

    protected $casts = [
        'price' => 'decimal:2',        // ou 'string' si tu préfères
        'quantity' => 'integer',
        'features' => 'array',
        'metadata' => 'array',
        'is_refundable' => 'boolean',
        'is_active' => 'boolean',
        'sales_start' => 'datetime',
        'sales_end' => 'datetime',
        'max_per_order' => 'integer',
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function getRemainingTicketsCountAttribute(): int {
        // Nombre de tickets encore disponibles pour ce type
        return $this->tickets()
            ->where('status', 'available')
            ->count();
    }



    // helper : quantité illimitée si null
    public function isUnlimited(): bool
    {
        return $this->quantity === null;
    }
}


// class TicketType extends Model {
//     use HasFactory;

// protected $fillable = [
//     'event_id','account_id','name','sku','price','quantity','description',
//     'features','is_refundable','is_active','sales_start','sales_end','max_per_order','metadata'
// ];

//     public function event() {
//         return $this->belongsTo(Event::class);
//     }

//     public function account(){
//         return $this->belongsTo(Account::class);
//     }


//     public function tickets() {
//         return $this->hasMany(Ticket::class);
//     }
// }

