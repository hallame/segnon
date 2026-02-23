<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
 use Illuminate\Support\Facades\Mail;
use App\Mail\BookingAdminAlertMail;
use App\Mail\ClientBookingConfirmedMail;
use App\Models\Room;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Address;
use Illuminate\Support\Arr;

class BookingService {
    /**
     * Vérifie la disponibilité d'une ressource pour une période donnée.
     */
    public function isAvailable($bookable, Carbon $start, Carbon $end): bool {
        return !BookingDay::where('bookable_type', get_class($bookable))
            ->where('bookable_id', $bookable->id)
            ->whereBetween('day', [
                $start->toDateString(),
                $end->copy()->subDay()->toDateString()
            ])
            ->exists();
    }

    /**
     * Crée une réservation et réserve les jours associés.
     */
    public function createBooking($bookable, array $data): Booking {
        return DB::transaction(function () use ($bookable, $data) {
            $start = Carbon::parse($data['check_in']);
            $end   = Carbon::parse($data['check_out']);

            // Vérifie la disponibilité
            if ($data['type'] === 'room') {
                if (!$this->isAvailable($bookable, $start, $end)) {
                    throw new \Exception('Intervalle de date indisponible.');
                }
            }


            $unit = $data['unit_price'] ?? ($bookable->price ?? 0);
            if (strtolower($data['type'] ?? '') === 'event') {
                $count = max(1, (int)($data['guests'] ?? 1));   // quantité = invités
            } else {
                $start = Carbon::parse($data['check_in']);
                $end   = Carbon::parse($data['check_out']);
                $count = $start->diffInDays($end);              // nuits (validation garantit end > start)
            }
            $total = $count * $unit;

            if ($total > 999999999999999999.99) {
                throw new \Exception('Montant trop élevé pour être enregistré.');
            }

            // Création de la réservation
            $booking = Booking::create([
                'bookable_type'     => get_class($bookable),
                'bookable_id'       => $bookable->id,
                'user_id'         => $data['user_id'] ?? null,
                'check_in'          => $start,
                'check_out'         => $end,
                'guests'            => $data['guests'] ?? 1,
                'is_group'          => $data['is_group'] ?? false,
                'unit_price'        => $unit,
                'amount'            => $total,
                'pricing_details' => $data['pricing_details'] ?? [],

                'status'            => Booking::STATUS_PENDING,
                'payment_status'    => Booking::PAY_UNPAID,
                'payment_method'    => $data['payment_method'] ?? null,
                'payment_due_at'    => now()->addHours(24),
                'source'            => $data['source'] ?? 'web',
                'note'              => $data['note'] ?? null,
                'language_id'       => $data['language_id'] ?? 1,
                'reference' => Booking::generateUniqueReference(),
            ]);

            // Réservation des jours
            for ($day = $start->copy(); $day->lt($end); $day->addDay()) {
                BookingDay::create([
                    'booking_id'    => $booking->id,
                    'bookable_type' => get_class($bookable),
                    'bookable_id'   => $bookable->id,
                    'day'           => $day->toDateString(),
                ]);
            }

            $this->sendNotifications($booking);
            return $booking;
        });
    }

    /**
     * Attache un reçu de paiement à une réservation.
     */
    public function attachReceipt(Booking $booking, UploadedFile $file, ?string $reference = null): void {
        $path = $file->store('payment_receipts', 'public');

        $booking->update([
            'payment_receipt_path' => $path,
            'payment_reference'    => $reference,
            'payment_status'       => Booking::PAY_AWAITING_VERIF,
        ]);
    }

    /**
     * Confirme une réservation après validation du paiement.
     */
    public function confirmBooking(Booking $booking): void {
        $booking->update([
            'status'         => Booking::STATUS_CONFIRMED,
            'payment_status' => Booking::PAY_VERIFIED,
        ]);
    }

    /**
     * Annule une réservation et libère les jours réservés.
     */
    public function cancelBooking(Booking $booking, ?string $reason = null): void {
        DB::transaction(function () use ($booking, $reason) {
            $booking->update([
                'status'              => Booking::STATUS_CANCELLED,
                'cancellation_reason' => $reason,
            ]);
            BookingDay::where('booking_id', $booking->id)->delete();
        });
    }


    private function sendNotifications(Booking $booking): void {
        try {
            // Relations nécessaires pour les sujets/contenus (Room → hotel/account)
            $booking->loadMissing([
                'user',
                'bookable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        Room::class => ['hotel', 'account'],
                    ]);
                },
            ]);

            // --- helpers locaux ---
            $parseCsv = function ($v): array {
                if (!$v) return [];
                $parts = preg_split('/[,\s;|]+/', (string) $v, -1, PREG_SPLIT_NO_EMPTY);
                $parts = array_map('trim', $parts ?: []);
                // Garde uniquement de vrais emails
                return array_values(array_filter($parts, fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL)));
            };
            $dedup     = fn (array $arr) => array_values(array_unique(array_filter($arr)));
            $arrDiff   = fn (array $a, array $b) => array_values(array_diff($a, $b));

            // 1) Construire To / CC / BCC
            $to = $dedup(array_merge(
                $parseCsv(config('mail.reservation_alerts.to')),
                array_filter([config('mail.super_admin_address')]) // garde si défini
            ));

            $cc = $dedup(array_merge(
                $parseCsv(config('mail.reservation_alerts.cc')),
                array_filter([$booking->bookable?->account?->email]) // copie visible au propriétaire (Room->account)
            ));

            $bcc = $dedup($parseCsv(config('mail.reservation_alerts.bcc')));

            // 2) Enlever les doublons inter-listes (priorité: To > CC > BCC)
            $cc  = $arrDiff($cc,  $to);
            $bcc = $arrDiff($bcc, array_merge($to, $cc));

            // 3) Si "To" est vide mais on a CC/BCC, on promeut le premier pour respecter les MTA
            if (empty($to) && (!empty($cc) || !empty($bcc))) {
                if (!empty($cc)) {
                    $to[] = array_shift($cc);
                } else {
                    $to[] = array_shift($bcc);
                }
            }

            // 4) Envoi ADMIN (un seul envoi avec To + CC + BCC)
            if (!empty($to)) {
                Mail::to($to)
                    ->cc($cc)
                    ->bcc($bcc)
                    ->send(new BookingAdminAlertMail($booking));
            }

            // 5) Envoi CLIENT (séparé)
            $customerEmail = $booking->user?->email
                ?? $booking->client_email
                ?? $booking->customer_email
                ?? null;

            if ($customerEmail && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($customerEmail)
                    ->send(new ClientBookingConfirmedMail($booking, $booking->user));
            }
        } catch (\Throwable $e) {
            Log::error('Erreur envoi mail réservation: ' . $e->getMessage(), [
                'booking_id' => $booking->id ?? null,
            ]);
        }
    }

}
