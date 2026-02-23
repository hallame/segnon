<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientBookingConfirmedMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking, public $client) {}

    public function build() {
        $room  = $this->booking->bookable instanceof Room ? $this->booking->bookable : null;
        $hotel = $room?->hotel;

        $subject = 'Confirmation de votre réservation ' . $this->booking->reference;
        if ($hotel?->name || $room?->name) {
            $subject .= ' — ' . trim(($hotel?->name ?? '').' / '.($room?->name ?? ''), ' /');
        }

        return $this->subject($subject)
            ->view('emails.bookings.confirmation')
            ->with([
                'booking' => $this->booking,
                'client'  => $this->client,
                'room'    => $room,
                'hotel'   => $hotel,
            ]);
    }
}
