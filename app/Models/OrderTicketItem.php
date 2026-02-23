<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTicketItem extends Model {
    use HasFactory;

    protected $fillable = [
        'order_ticket_id','ticket_type_id','ticket_type_name',
        'unit_price','qty','total_price'
    ];

    public function orderTicket(){ return $this->belongsTo(OrderTicket::class); }


    public function ticketType() {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }



    public function order() {
        return $this->belongsTo(OrderTicket::class, 'order_ticket_id');
    }




}
