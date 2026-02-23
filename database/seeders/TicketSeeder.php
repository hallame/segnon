<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\Event;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder {
    public function run(): void {
        $events = Event::all();

        if ($events->isEmpty()) {
            $this->command->info("Pas d'événements trouvés. Créez-en d'abord !");
            return;
        }

        foreach ($events as $event) {

            // Récupérer les types déjà existants pour cet event
            $typesForEvent = TicketType::where('event_id', $event->id)->get();

            // S'il n'y en a pas, on en crée 2 par défaut
            if ($typesForEvent->isEmpty()) {
                $basePrice = $event->price ?? 10000; // prix de base (fallback si null)

                $definitions = [
                    [
                        'name'     => 'Standard',
                        'mult'     => 1,
                        'features' => ['Accès général'],
                    ],

                    [
                        'name'     => 'VIP',
                        'mult'     => 2,
                        'features' => ['Accès VIP', 'Zone réservée', 'Boisson offerte'],
                    ],
                ];

                foreach ($definitions as $def) {
                    TicketType::create([
                        'event_id'      => $event->id,
                        'account_id'    => $event->account_id ?? null,
                        'name'          => $def['name'],
                        'sku'           => Str::upper(Str::random(8)),
                        'price'         => round($basePrice * $def['mult'], 2),
                        'quantity'      => rand(3, 5),
                        'description'   => null,
                        'features'      => json_encode($def['features']),
                        'is_refundable' => false,
                        'is_active'     => true,
                        'sales_start'   => null,
                        'sales_end'     => null,
                        'max_per_order' => 20,
                        'metadata'      => null,
                    ]);
                }

                // Recharger les types pour cet event après création
                $typesForEvent = TicketType::where('event_id', $event->id)->get();
            }

            // Maintenant on génère les tickets pour chaque type
            foreach ($typesForEvent as $type) {
                // Si des tickets existent déjà pour ce type, on saute (évite les doublons si on reseed)
                $alreadyHasTickets = Ticket::where('ticket_type_id', $type->id)->exists();
                if ($alreadyHasTickets) {
                    continue;
                }

                // Nombre max de tickets à créer pour ce type en fonction de la quantité
                $maxCount = $type->quantity ?? 5; // si quantité null = illimité, on met un max "raisonnable"
                if ($maxCount <= 0) {
                    continue;
                }

                $count = min(rand(3, 5), $maxCount);

                for ($i = 0; $i < $count; $i++) {
                    Ticket::create([
                        'event_id'       => $event->id,
                        'ticket_type_id' => $type->id,
                        'status'         => 'available',
                        'qr_code'        => Str::upper(Str::random(10)),
                    ]);
                }
            }
        }

        $this->command->info("Tickets générés avec succès !");
    }
}
