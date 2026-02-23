<?php

// App\Mail\BookingAdminAlertMail.php
namespace App\Mail;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingAdminAlertMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking) {}

    public function build() {
        $room  = $this->booking->bookable instanceof Room ? $this->booking->bookable : null;
        $hotel = $room?->hotel;

        $subject = 'Nouvelle réservation : ' . $this->booking->reference;
        if ($hotel?->name || $room?->name) {
            $subject .= ' — ' . trim(($hotel?->name ?? '').' / '.($room?->name ?? ''), ' /');
        }

        return $this->subject($subject)
            ->view('emails.bookings.admin_alert')
            ->with([
                'booking' => $this->booking,
                'room'    => $room,
                'hotel'   => $hotel,
            ]);
    }
}
