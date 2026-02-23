<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderTicket extends Model {
    use HasFactory;


    protected $fillable = [
        'reference','event_id','account_id','user_id',
        'customer_firstname','customer_lastname','customer_email','customer_phone',
        'subtotal','discount','tax','total','currency',
        'status','expires_at', 'payment_id', 'moneroo_transaction_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];


    protected $table = 'order_tickets'; // si pas déjà


    const ST_DRAFT = 'draft';
    const ST_AWAITING = 'awaiting_payment';
    const ST_UNDER_REVIEW = 'under_review';
    const ST_PAID = 'paid';
    const ST_EXPIRED = 'expired';
    const ST_CANCELLED = 'cancelled';

    public function items()   { return $this->hasMany(OrderTicketItem::class); }
    public function event()   { return $this->belongsTo(Event::class); }
    public function payments(){ return $this->morphMany(Payment::class, 'payable'); }
    public function tickets() { return $this->hasMany(Ticket::class); }



    // Relations
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }



    public function markAsPaidAndAssignTickets(): void {
        DB::transaction(function () {
            $this->refresh();
            if ($this->status === self::ST_PAID) {
                return;
            }
            $this->loadMissing('items');

            foreach ($this->items as $item) {
                $needed = (int) $item->qty;
                if ($needed <= 0) {
                    continue;
                }

                // On cherche des tickets dispo pour CE type
                $tickets = Ticket::where('ticket_type_id', $item->ticket_type_id)
                    ->where('status', 'available')
                    ->whereNull('order_ticket_id') // pour éviter de réutiliser un ticket déjà attaché
                    ->lockForUpdate()
                    ->limit($needed)
                    ->get();

                if ($tickets->count() < $needed) {
                    throw new \RuntimeException(
                        "Plus assez de tickets disponibles pour « {$item->ticket_type_name} »."
                    );
                }

                // On assigne les tickets trouvés à CETTE commande
                foreach ($tickets as $t) {
                    $t->update([
                        'status'          => 'sold',
                        'order_ticket_id' => $this->id,
                    ]);
                }
            }

            // Statut commande = payée
            $this->update([
                'status' => self::ST_PAID,
            ]);
        });
    }

}
