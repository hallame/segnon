<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model {
    use HasFactory;

    protected $fillable = ['ticket_type_id','qr_code','status','event_id', 'order_ticket_id'];

    public function ticketType() {
        return $this->belongsTo(TicketType::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function type() {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }



    public function orderTicket() {
        return $this->belongsTo(OrderTicket::class, 'order_ticket_id');
    }



    public function orderItem() {
        return $this->belongsTo(OrderItem::class);
    }

}
