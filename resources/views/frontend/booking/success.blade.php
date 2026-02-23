@extends('frontend.layouts.master')
@section('title', 'Réservation confirmée')

@section('content')
<div class="max-w-3xl mx-auto px-4 lg:px-8 py-10 text-center animate-fade-in">

    {{-- Stepper / Barre de progression --}}
    {{-- <div class="flex justify-center mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center">1</div>
                <span class="font-medium">Réservation</span>
            </div>
            <span>→</span>
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center">2</div>
                <span class="font-medium">Paiement</span>
            </div>
            <span>→</span>
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center">3</div>
                <span class="font-medium">Confirmation</span>
            </div>
        </div>
    </div> --}}

    {{-- Icône succès --}}
    <div class="flex justify-center mb-6">
        <div class="bg-emerald-500 text-white flex items-center gap-3 px-5 py-3 rounded-full shadow-lg">
            <i class="fa-solid fa-check fa-lg"></i>
            <span class="text-base font-medium">Réservation réussie</span>
        </div>
    </div>

    <h1 class="text-4xl sm:text-5xl font-extrabold text-emerald-600 mb-2 tracking-tight">Merci pour votre réservation !</h1>

    <p class="text-gray-600 text-lg italic mb-5">
        @switch($booking->bookable_type)
            @case(\App\Models\Room::class)
                Votre chambre a bien été réservée.
                @break
            @case(\App\Models\Event::class)
                Votre participation à l’événement est enregistrée.
                @break
            @case(\App\Models\Site::class)
                Votre réservation du site touristique est confirmée.
                @break
            @case(\App\Models\Circuit::class)
                Votre circuit touristique est réservé avec succès.
                @break
            @default
                Votre réservation est confirmée.
        @endswitch
    </p>

    {{-- Carte des détails --}}
    <div class="bg-white shadow-2xl border border-gray-100 rounded-3xl px-6 py-5 text-left text-sm text-gray-800 mb-6 transition transform hover:scale-[1.01] duration-300">
        <h2 class="text-lg font-semibold mb-6 border-b pb-3 text-emerald-600">Détails de la réservation</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 leading-relaxed">
            <p><strong>Nom :</strong> {{ $client->firstname }} {{ $client->lastname }}</p>
            <p><strong>Email :</strong> {{ $client->email }}</p>
            <p><strong>Téléphone :</strong> {{ $client->phone }}</p>
            <p><strong>Nombre de personnes :</strong> {{ $booking->guests }}</p>
            @if ($booking->check_in->equalTo($booking->check_out))
                <p><strong>Date :</strong> {{ $booking->check_in->translatedFormat('j F Y') }}</p>
            @else
                <p><strong>Dates :</strong> du {{ $booking->check_in->translatedFormat('j F Y') }} au {{ $booking->check_out->translatedFormat('j F Y') }}</p>
            @endif
            <p><strong>Montant total :</strong> {{ number_format($booking->amount, 0, '', ' ') }} {{ $currency }}</p>
            <p><strong>Moyen de paiement :</strong> {{ ucfirst($booking->payment_method) }}</p>
            <p><strong>Statut :</strong>
                @switch($booking->status)
                    @case(0) En attente @break
                    @case(1) Confirmée @break
                    @case(2) Annulée @break
                    @case(3) Terminée @break
                    @default —
                @endswitch
            </p>
            <p><strong>Paiement :</strong>
                @switch($booking->payment_status)
                    @case(0) Non payé @break
                    @case(1) En attente de vérification @break
                    @case(2) Payé @break
                    @case(3) Rejeté @break
                    @default —
                @endswitch
            </p>
            <p><strong>Référence :</strong> #{{ $booking->reference ?? '—' }}</p>
            @if ($booking->note)
                <p class="sm:col-span-2"><strong>Note :</strong> {{ $booking->note }}</p>
            @endif

            {{-- Reçu si disponible --}}
            @if ($booking->payment_receipt_path)
                <p class="sm:col-span-2">
                    <strong>Reçu de paiement :</strong>
                    <a href="{{ Storage::url($booking->payment_receipt_path) }}"
                        target="_blank"
                        class="text-emerald-600 underline hover:text-emerald-800 transition">
                        Voir le fichier
                    </a>
                </p>
            @endif
        </div>
    </div>

    {{-- Boutons actions --}}
    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
        {{-- <a href="{{ route('home') }}"
            class="inline-block bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-semibold px-8 py-3 rounded-full shadow-lg tracking-wide uppercase transition duration-300">
            Retour à l’accueil
        </a> --}}

        @switch($booking->bookable_type)
            @case(\App\Models\Room::class)
                <a href="{{ route('rooms.index') }}"
                    class="inline-block border border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-semibold px-8 py-3 rounded-full shadow transition duration-300">
                    Nouvelle réservation
                </a>
                @break
            @case(\App\Models\Event::class)
                <a href="{{ route('events.index') }}"
                    class="inline-block border border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-semibold px-8 py-3 rounded-full shadow transition duration-300">
                    Nouvelle réservation
                </a>
                @break
            @case(\App\Models\Site::class)
                <a href="{{ route('sites.index') }}"
                    class="inline-block border border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-semibold px-8 py-3 rounded-full shadow transition duration-300">
                    Nouvelle réservation
                </a>
                @break
            @case(\App\Models\Circuit::class)
                <a href="{{ route('circuits.index') }}"
                    class="inline-block border border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-semibold px-8 py-3 rounded-full shadow transition duration-300">
                    Nouvelle réservation
                </a>
                @break
            @default
                <a href="{{ route('home') }}"
                    class="inline-block bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-semibold px-8 py-3 rounded-full shadow-lg tracking-wide uppercase transition duration-300">
                    Retour à l’accueil
                </a>
        @endswitch

        {{-- Bouton télécharger le reçu PDF --}}
        <a href="{{ route('booking.receipt.pdf', $booking->reference) }}"
            class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-full font-medium shadow transition duration-300">
            Télécharger le reçu PDF
        </a>
    </div>
</div>
@endsection
