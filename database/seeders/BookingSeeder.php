<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingDay;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class BookingSeeder extends Seeder {
    /** Nombre total de réservations à générer */
    private int $TOTAL = 80;

    public function run(): void {
        $faker = fake('fr_FR');

        // Déclare ici les modèles "réservables" qui existent VRAIMENT chez toi
        $bookables = collect([
            ['label'=>'Room',    'class'=> \App\Models\Room::class,    'duration'=>'nights', 'rate'=>[150000, 600000], 'guests'=>[1,4]],
            ['label'=>'Event',   'class'=> \App\Models\Event::class,   'duration'=>'hours',  'rate'=>[ 50000, 250000], 'guests'=>[1,6]],
            // tu peux en rajouter : Monument, Activity, etc.
        ])->filter(function($b){
            return class_exists($b['class']) && method_exists($b['class'], 'query') && $b['class']::query()->exists();
        })->map(function($b){
            $b['ids'] = $b['class']::query()->pluck('id')->all();
            return $b;
        })->filter(fn($b)=>count($b['ids'])>0)->values();

        if ($bookables->isEmpty()) {
            $this->command->warn('Aucun modèle réservable trouvé (Site/Circuit/Room/Event…). Abandon.');
            return;
        }

        // Clients (supposés exister)
        $userIds = User::query()->pluck('id')->all();
        if (empty($userIds)) {
            $this->command->warn('Aucun client trouvé. Création de 8 clients factices.');
            $userIds = User::factory()->count(8)->create()->pluck('id')->all();
        }

        // Langue (si contrainte FK)
        $languageId = 1;
        if (class_exists(\App\Models\Language::class)) {
            $languageId = \App\Models\Language::query()->value('id') ?? 1;
        }

        $payMethods = ['mobile_money','bank_transfer','cash','card','cod'];
        $sources    = ['web','mobile','admin'];

        DB::transaction(function() use ($bookables, $userIds, $payMethods, $sources, $languageId, $faker) {
            $created = 0; $tries = 0;

            while ($created < $this->TOTAL && $tries < $this->TOTAL * 5) {
                $tries++;

                /** 1) Choisir un type réservable + un ID existant */
                $b = $bookables->random();
                $bookableType = $b['class'];
                $bookableId   = Arr::random($b['ids']);

                /** 2) Générer des dates (mélange passé/futur) */
                // start entre J-20 et J+60
                $start = Carbon::now()->addDays(rand(-20, 60))->setTime(rand(12,18), [0,15,30,45][array_rand([0,1,2,3])]);
                $end   = (clone $start);

                $durationKind = $b['duration']; // nights/days/hours
                $n = match($durationKind) {
                    'nights' => rand(1, 5),
                    'days'   => rand(1, 3),
                    'hours'  => rand(2, 6),
                    default  => 1
                };

                if ($durationKind === 'hours') {
                    $end->addHours($n)->setTime($end->hour, 0);
                } elseif ($durationKind === 'days' || $durationKind === 'nights') {
                    $end->addDays($n)->setTime(rand(8,11), 0);
                }

                /** 3) Éviter (optionnel) des conflits de jours sur la même ressource */
                if ($this->hasDayConflicts($bookableType, $bookableId, $start, $end)) {
                    // on tente juste autre chose
                    continue;
                }

                /** 4) Tarifs, participants */
                $guests = rand($b['guests'][0], $b['guests'][1]);
                $unit   = rand($b['rate'][0], $b['rate'][1]);
                $nightsOrDays = max(1, ($durationKind === 'hours') ? 1 : $start->diffInDays($end));
                $amount = (int) round($unit * $nightsOrDays * max(1, (int)ceil($guests/2)));

                /** 5) Statuts cohérents vs temporalité */
                $isPast   = $end->lt(now());
                $status   = $isPast ? Arr::random([Booking::STATUS_COMPLETED, Booking::STATUS_CANCELLED, Booking::STATUS_CONFIRMED])
                                    : Arr::random([Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED]);
                $payStat  = $isPast
                            ? Arr::random([Booking::PAY_VERIFIED, Booking::PAY_REJECTED, Booking::PAY_AWAITING_VERIF])
                            : Arr::random([Booking::PAY_UNPAID, Booking::PAY_AWAITING_VERIF, Booking::PAY_VERIFIED]);

                // petit alignement : si terminé → souvent payé vérifié
                if ($status === Booking::STATUS_COMPLETED && $payStat !== Booking::PAY_VERIFIED && rand(0,1)) {
                    $payStat = Booking::PAY_VERIFIED;
                }

                /** 6) Création */
                $booking = Booking::create([
                    'bookable_type'       => $bookableType,
                    'bookable_id'         => $bookableId,
                    'user_id'           => Arr::random($userIds),
                    'check_in'            => $start,
                    'check_out'           => $end,
                    'guests'              => $guests,
                    'is_group'            => $guests >= 6,
                    'unit_price'          => $unit,
                    'amount'              => $amount,
                    'pricing_details'     => [
                        'duration_kind' => $durationKind,
                        'segments'      => $nightsOrDays,
                        'base'          => $unit,
                        'guests'        => $guests,
                        'computed'      => $amount,
                    ],
                    'status'              => $status,
                    'payment_status'      => $payStat,
                    'payment_method'      => Arr::random($payMethods),
                    'payment_due_at'      => (clone $start)->subDays(rand(1,3)),
                    'payment_receipt_path'=> null,
                    'payment_reference'   => $faker->optional(0.4)->bothify('PAY-####-????'),
                    'reference'           => Booking::generateUniqueReference(),
                    'confirmation_code'   => strtoupper(Str::random(8)),
                    'source'              => Arr::random($sources),
                    'note'                => $faker->optional(0.25)->sentence(),
                    'cancellation_reason' => null,
                    'language_id'         => $languageId,
                ]);

                /** 7) Booking days (par jour, hors checkout) */
                $this->createDays($booking, $start, $end);

                $created++;
            }
        });

        $this->command->info("Bookings seedés : {$this->TOTAL}");
    }

    /** Y a-t-il des jours déjà occupés pour ce bookable ? */
    private function hasDayConflicts(string $type, int $id, Carbon $start, Carbon $end): bool {
        $d1 = $start->copy()->startOfDay();
        $d2 = $end->copy()->startOfDay();
        if ($d1->gte($d2)) $d2 = $d1->copy()->addDay(); // min 1 jour

        return BookingDay::query()
            ->where('bookable_type', $type)
            ->where('bookable_id', $id)
            ->whereBetween('day', [$d1->toDateString(), $d2->subDay()->toDateString()])
            ->exists();
    }

    /** Crée les lignes BookingDay (jour par jour, sans inclure le checkout) */
    private function createDays(Booking $booking, Carbon $start, Carbon $end): void {
        $d = $start->copy()->startOfDay();
        $last = $end->copy()->startOfDay();
        if ($d->gte($last)) {
            // Cas “événement” sur une seule journée : on bloque juste le jour de départ
            BookingDay::create([
                'booking_id'   => $booking->id,
                'bookable_type'=> $booking->bookable_type,
                'bookable_id'  => $booking->bookable_id,
                'day'          => $d->toDateString(),
            ]);
            return;
        }

        while ($d < $last) {
            BookingDay::create([
                'booking_id'   => $booking->id,
                'bookable_type'=> $booking->bookable_type,
                'bookable_id'  => $booking->bookable_id,
                'day'          => $d->toDateString(),
            ]);
            $d->addDay();
        }
    }
}
