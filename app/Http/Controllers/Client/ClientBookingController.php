<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\Booking;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientWelcomeMail;
use App\Mail\ClientBookingConfirmedMail;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\BookingService;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientBookingController extends Controller {

    protected function resolveModel($type) {
        return match ($type) {
            'room'    => \App\Models\Room::class,
            'event'   => \App\Models\Event::class,
            default   => abort(404)
        };
    }

    public function create($type, $slug) {
        $model = $this->resolveModel($type);
        $bookable = $model::where('slug', $slug)->firstOrFail();
        $type = match (get_class($bookable)) {
            \App\Models\Room::class => 'room',
            \App\Models\Hotel::class => 'hotel',
            \App\Models\Event::class => 'event',
            default => 'autre'
        };


        $methods = PaymentMethod::with(['mobileMoney','bank','cash','card','cod'])
            ->where('active', true)
            ->orderBy('position')
            ->get();

        return view('frontend.booking.create', compact('bookable', 'type', 'methods'));
    }

    public function store(Request $request, $type, $slug, BookingService $bookingService, PaymentService $payments) {
        $model = $this->resolveModel($type);
        $bookable = $model::where('slug', $slug)->firstOrFail();

        if (strtolower($request->input('type')) === 'event') {
            $request->merge([
                'check_in'  => optional($bookable->start_date)->toDateString(),
                'check_out' => optional($bookable->end_date)->toDateString(),
            ]);
        }

        $rules = [
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after:check_in',
            'firstname'        => 'required|string|max:100',
            'lastname'         => 'required|string|max:100',
            'email'            => 'required|email',
            'phone'            => 'required|string|max:30',
            'special_requests' => 'nullable|string|max:255',
            'note'             => 'nullable|string|max:500',
            'receipt'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        // Si ce n’est pas un event, on ajoute la validation de la capacité
        if ($request->input('type') === 'room') {
            $rules['guests'] = 'required|integer|min:1|max:' . ($bookable->capacity ?? 0);
        } else {
            $rules['guests'] = 'required|integer|min:1';
        }

        $request->validate($rules);



        // Vérifie si le client existe
        $user = User::where('email', $request->email)->first();
        $password = null;

        if (!$user) {
            $password = Str::random(8);
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'password'  => bcrypt($password),
            ]);

            try {
                Mail::to($user->email)->send(new ClientWelcomeMail($user, $password));
            } catch (\Exception $e) {
                Log::error("Erreur mail de bienvenue : " . $e->getMessage());
            }
        }

        // Crée la réservation via le service
        try {
            $booking = $bookingService->createBooking($bookable, [
                'user_id'            => $user->id,
                'check_in'          => $request->check_in,
                'check_out'         => $request->check_out,
                'guests'            => $request->guests,
                'is_group'          => $request->guests > 3,
                'unit_price'        => $bookable->price,
                'pricing_details'   => [
                    'days'           => \Carbon\Carbon::parse($request->check_in)->diffInDays($request->check_out),
                    'special_requests' => $request->special_requests,
                ],
                'note'              => $request->note,
                'source'            => 'web',
                'language_id'       => app()->getLocale() === 'fr' ? 1 : 2,
                'type'              => $request->input('type'),
            ]);

            try {
                Mail::to($user->email)->send(new ClientBookingConfirmedMail($booking, $user));
            } catch (\Exception $e) {
                Log::error('Erreur envoi mail confirmation réservation : ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            Log::error('Erreur création réservation : ' . $e->getMessage());
            return back()->withInput()->with('error', "Erreur : " . $e->getMessage());
        }


        // Attache le reçu si présent
        if ($request->hasFile('receipt')) {
            $bookingService->attachReceipt($booking, $request->file('receipt'));
        }

        // Stocke la session client
        Auth::login($user);
        return redirect()->route('booking.success', ['reference' => $booking->reference])->with('success', 'Votre réservation a bien été enregistrée.');

    }

    public function success($reference) {
        $booking = Booking::where('reference', $reference)->firstOrFail();
        $user = Auth::user();
        if (!$user || $booking->user_id !== $user->id) {
            return redirect()->route('home')->withErrors([
                'error' => 'Accès non autorisé à cette réservation.',
            ]);
        }

        return view('frontend.booking.success', [
            'booking' => $booking,
            'client'  => $user,
        ])->with('success', 'Votre réservation a été confirmée avec succès.');
    }



    public function downloadReceiptPdf($reference) {
        $booking = Booking::where('reference', $reference)->firstOrFail();

        $qrUrl = match ($booking->bookable_type) {
            \App\Models\Event::class  => route('events.show', $booking->bookable),
            \App\Models\Event::class  => route('museums.show', $booking->bookable),
            default                   => route('home'),
        };

        $writer = new PngWriter();
        $qr = QrCode::create($qrUrl)->setSize(140)->setMargin(2);
        $result = $writer->write($qr);
        $qrPngBase64 = base64_encode($result->getString());

        $pdf = Pdf::loadView('frontend.booking.receipt', [
            'booking' => $booking,
            'client'  => $booking->user,
            'qrPng'   => $qrPngBase64,
            'qrUrl'   => $qrUrl,
        ]);
        return $pdf->download('receipt_' . $booking->reference . '.pdf');
    }


}
