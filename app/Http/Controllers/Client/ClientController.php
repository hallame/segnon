<?php

namespace App\Http\Controllers\Client;

use App\Models\Payment;
use App\Models\Review;
use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller{

    public function dashboard(){
        $client = Auth::user();
        // Statistiques sur les réservations
        $clientSites = $client->reservations()->whereNotNull('site_id')->with('site')->get();
        $totalSites = $client->reservations()->whereNotNull('site_id')->count();
        $upcomingSites = $client->reservations()->whereNotNull('site_id')->where('start_date', '>', now())->count();
        $canceledSites = $client->reservations()->whereNotNull('site_id')->where('status', 2)->count();

        // Statistiques sur les avis
        $totalReviews = $client->reviews()->count();
        $averageRating = $client->reviews()->avg('rating');

        // Statistiques sur les événements
        $clientEvents = $client->reservations()
            ->whereNotNull('event_id')
            ->with('event')
            ->latest()
            ->take(15)
            ->get();

        $totalEvents = $client->reservations()->whereNotNull('event_id')->count();
        $reservations = $client->reservations()->latest()->take(5)->get();

        // Statistiques sur les paiements
        $totalPayments = $client->payments()->count();
        $totalAmountPaid = $client->payments()->sum('amount');

        return view('frontend.client.dashboard', compact(
            'client',
            'reservations',
            'totalSites',
            'upcomingSites',
            'canceledSites',
            'totalReviews',
            'averageRating',
            'totalEvents',
            'clientEvents',
            'totalPayments',
            'totalAmountPaid',
            'clientSites'
        ));
    }

    public function profile(){

        $client = Auth::user();
        return view('frontend.client.profile', compact('client'));
    }

    public function updateProfile(Request $request){
        $client = Auth::user();
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|confirmed|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Mise à jour des informations
        $client->firstname = $request->firstname;
        $client->lastname = $request->lastname;
        $client->city = $request->city;
        $client->country = $request->country;
        $client->company = $request->company;
        $client->position = $request->position;
        $client->email = $request->email;
        $client->phone = $request->phone;

        // Mot de passe s'il est fourni
        if ($request->filled('password')) {
            $client->password = Hash::make($request->password);
        }
        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            if ($client->avatar && Storage::exists($client->avatar)) {
                Storage::delete($client->avatar);
            }
            $client->avatar = $request->file('avatar')->store('avatars', 'public');
        }
        $client->save();
        return redirect()->route('client.profile')->with('success', 'Profil mis à jour avec succès.');
    }

    public function history(){
        $client = Auth::user();
        return view('frontend.client.history', compact('client'));
    }

    public function tickets(){
        $client = Auth::user();
        return view('frontend.client.tickets', compact('client'));
    }

    public function support(){
        $client = Auth::user();
        return view('frontend.client.support', compact('client'));
    }

    public function reviews(){
        $client = Auth::user();
        $reviews = Review::with('reviewable')->where('client_id', $client->id)->latest()->get();
        return view('frontend.client.reviews', compact('reviews', 'client'));

    }

    public function payments(){
        $client = Auth::user();
        $payments = Payment::with(['reservation', 'hotel'])
            ->where('client_id', $client->id)
            ->latest()
            ->get();

        return view('frontend.client.payments', compact('client', 'payments'));
    }

    public function submitContact(Request $request){
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'subject.required' => 'Le sujet est obligatoire.',
            'subject.string' => 'Le sujet doit être une chaîne de caractères valide.',
            'subject.max' => 'Le sujet ne peut pas dépasser 255 caractères.',

            'message.required' => 'Le message est obligatoire.',
            'message.string' => 'Le message doit être une chaîne de caractères valide.',
        ]);


        $client = Auth::user();

        // Enregistrement
        SupportRequest::create([
            'client_id' => $client->id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        try {
            // Envoi de l'email au client
            $subject = $request->subject;
            $message = $request->message;

            Mail::send('emails.client.contact.received', ['client' => $client, 'subject' => $subject, 'message' => $message], function ($message) use ($client) {
                $message->to($client->email)
                        ->subject('Votre message a bien été reçu');
            });

            // Envoi de l'email à l'admin (support)
            Mail::send('emails.admin.contact.new', ['client' => $client, 'subject' => $subject, 'message' => $message], function ($message) {
                $message->to('webzaly@zalymerveille.org')
                        ->subject('Nouveau message support');
            });

            return redirect()->route('client.dashboard')
                             ->with('success', 'Votre message a été envoyé avec succès. Vous serez bientôt contacté.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi des emails: ' . $e->getMessage());
            // return back()->withErrors(['email' => 'Impossible d\'envoyer l\'email. Veuillez réessayer plus tard.']);
            return back()->with('success', 'Votre message a bien été envoyé.');

        }

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons sous peu.');
    }

}
