<?php
// app/Services/BookingNotifier.php
namespace App\Services;

use App\Models\Booking;
use App\Mail\ClientBookingConfirmedMail;
use App\Mail\BookingAdminAlertMail;
use Illuminate\Support\Facades\Mail;

class BookingNotifier {
    public function send(Booking $booking): void {
        // Charger juste ce qu’il faut
        $booking->loadMissing([
            'user:id,email,firstname,lastname',
            'bookable.account:id,email,name'
        ]);

        // 1) Client
        $customerEmail = $booking->user?->email ?? $booking->customer_email;
        if ($customerEmail) {
            Mail::to($customerEmail)->queue(new ClientBookingConfirmedMail($booking, $booking->user));
        }

        // 2) Proprio (compte du contenu)
        $accountEmail = $booking->bookable?->account?->email;
        if ($accountEmail) {
            Mail::to($accountEmail)->queue(new BookingAdminAlertMail($booking));
        }

        // 3) Plateforme (liste .env)
        $platformAdmins = array_filter(
            explode(',', (string) config('mail.booking_admins', ''))
        );
        if (!empty($platformAdmins)) {
            Mail::to($platformAdmins)->queue(new BookingAdminAlertMail($booking, /*isPlatform*/ true));
        }
    }
}

