@extends('frontend.layouts.master')

@section('title', 'Contact')

@section('meta_title', 'Contactez-nous')

@section('meta_description', "Une question, une demande de partenariat ou besoin d’aide pour une commande ? Contactez l’équipe MYLMARK, marketplace de vendeurs et créateurs.")
@section('meta_image', asset('assets/images/contact.jpg'))

@section('meta_url', route('contact'))

@section('content')

<div class="min-h-[70vh] bg-slate-50 text-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 lg:py-10">

        {{-- HEADER --}}
        <header class="mb-7">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-700">
                        Contact & support
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                        Une question ? Parlons-en.
                    </h1>
                    <p class="mt-1 text-[12px] text-slate-600 max-w-xl">
                        Que ce soit pour une commande, un problème technique ou une future collaboration,
                        notre équipe vous répond dans les plus brefs délais.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 text-[11px]">
                    <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 text-emerald-700 px-3 py-1">
                        <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-600 text-white text-[11px]">
                            i
                        </span>
                        <span>Temps de réponse moyen : 24–48h</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- BANDEAU INFOS RAPIDES --}}
        {{-- <section class="mb-7">
            <div class="grid gap-3 md:grid-cols-4">
                <div class="flex items-center gap-3 rounded-2xl bg-white border border-slate-100 px-4 py-3 shadow-sm">
                    <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 7l9 6 9-6"/>
                        </svg>
                    </div>
                    <div class="text-[11px]">
                        <p class="font-semibold text-slate-900">Email support</p>
                        <p class="text-slate-600">contact@mylmark.com</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 rounded-2xl bg-emerald-600 text-emerald-50 p-2 shadow-sm">
                    <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="8"/>
                            <path d="M12 8v4l2 2"/>
                        </svg>
                    </div>
                    <div class="text-[11px]">
                        <p class="font-semibold">Horaires</p>
                        <p class="text-emerald-100">Lun – Ven : 9h – 18h (GMT)</p>
                    </div>
                </div>
            </div>
        </section> --}}

        {{-- LAYOUT : FORMULAIRE + INFO --}}
        <section class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.6fr)_minmax(0,1.1fr)] gap-6 items-start">

            {{-- FORMULAIRE DE CONTACT --}}
            <div>
                @if(session('status'))
                    <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[12px] text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-[12px] text-rose-700">
                        <div class="flex items-start gap-2">
                            <svg class="h-4 w-4 mt-[2px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 8v5"/>
                                <path d="M12 16h.01"/>
                            </svg>
                            <div>
                                <p class="font-semibold mb-1">Merci de corriger les champs indiqués.</p>
                                <ul class="list-disc list-inside space-y-0.5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif









                <form method="POST" action="{{ route('contact.send') }}"
                    class="rounded-3xl border border-slate-100 bg-white shadow-sm px-4 py-5 sm:px-5 sm:py-6 space-y-4"
                    novalidate>
                    @csrf

                    <div class="hidden">
                        <label for="website"></label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <input type="hidden" name="time_start" value="{{ microtime(true) }}">


                    <div class="flex items-center justify-between gap-2 mb-1">
                        <div>
                            <h2 class="text-[14px] font-semibold text-slate-900">Écrivez-nous</h2>
                            <p class="text-[11px] text-slate-500">
                                Précisez votre demande pour que nous puissions vous répondre efficacement.
                            </p>
                        </div>
                        <div class="hidden sm:flex h-8 w-8 items-center justify-center rounded-2xl bg-slate-900 text-slate-50">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 4h16v16H4z"/>
                                <path d="M4 7l8 5 8-5"/>
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="lastname" class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                Nom <span class="text-rose-500">*</span>
                            </label>
                            <input
                                id="lastname"
                                name="lastname"
                                type="text"
                                value="{{ old('lastname') }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>

                        <div>
                            <label for="firstname" class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                Prénom
                            </label>
                            <input
                                id="firstname"
                                name="firstname"
                                type="text"
                                value="{{ old('firstname') }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>

                        <div>
                            <label for="phone" class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                Téléphone (WhatsApp)
                            </label>
                            <input
                                id="phone"
                                name="phone"
                                type="text"
                                value="{{ old('phone') }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                            Sujet de votre demande <span class="text-rose-500">*</span>
                        </label>
                        <select
                            id="subject"
                            name="subject"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required>
                            <option value="">Choisissez une option</option>
                            <option value="Commande" {{ old('subject') === 'commande' ? 'selected' : '' }}>
                                Suivi ou question sur une commande
                            </option>
                            <option value="Compte" {{ old('subject') === 'compte' ? 'selected' : '' }}>
                                Problème de compte ou connexion
                            </option>
                            <option value="Partenariat" {{ old('subject') === 'partenariat' ? 'selected' : '' }}>
                                Devenir vendeur / partenaire
                            </option>
                            <option value="Autre" {{ old('subject') === 'autre' ? 'selected' : '' }}>
                                Autre demande
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                            Message <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Expliquez-nous votre demande avec le plus de précision possible."
                            required>{{ old('message') }}</textarea>
                    </div>

                    <div class="flex items-start gap-2 text-[11px] text-slate-600">
                        <input
                            id="consent"
                            name="consent"
                            type="checkbox"
                            value="1"
                            class="mt-[3px] h-3 w-3 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <label for="consent" class="cursor-pointer">
                            J’accepte que mes informations soient utilisées uniquement dans le cadre du traitement de ma demande.
                        </label>
                    </div>

                    <div class="pt-1">
                        <button
                            type="submit"
                            id="submitBtn"
                            class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-2.5 text-[13px] font-semibold text-white shadow-md hover:shadow-lg hover:scale-[1.02] transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 4l16 8-16 8 3-8z"/>
                            </svg>
                            <span id="submitText">Envoyer mon message</span>
                        </button>
                    </div>


                    <script>
                        // Désactiver le double-clic
                        document.getElementById('contactForm').addEventListener('submit', function(e) {
                            const btn = document.getElementById('submitBtn');
                            const text = document.getElementById('submitText');

                            btn.disabled = true;
                            text.classList.add('hidden');

                        });
                    </script>
                </form>
            </div>


            {{-- BLOC INFO / FAQ / CARTE --}}
            <aside class="space-y-4">
                {{-- Bloc "Pourquoi nous contacter ?" --}}
                <div class="rounded-3xl bg-white border border-slate-100 shadow-sm px-4 py-4 sm:px-5 sm:py-5 text-[12px]">
                    <h2 class="text-[13px] font-semibold text-slate-900 mb-2">
                        Les demandes les plus fréquentes
                    </h2>
                    <ul class="space-y-2.5">
                        <li class="flex gap-2">
                            <span class="mt-[3px] inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 text-[10px]">1</span>
                            <div>
                                <p class="font-semibold text-slate-900">Suivi d’une commande</p>
                                <p class="text-slate-600 text-[11px]">
                                    Numéro de suivi, délai, modification d’adresse, problème de livraison…
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 text-[10px]">2</span>
                            <div>
                                <p class="font-semibold text-slate-900">Problème de compte</p>
                                <p class="text-slate-600 text-[11px]">
                                    Mot de passe oublié, accès, fiches produits, etc.
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 text-[10px]">3</span>
                            <div>
                                <p class="font-semibold text-slate-900">Devenir vendeur</p>
                                <p class="text-slate-600 text-[11px]">
                                    Informations sur les conditions.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>


                {{-- Bloc "Solutions rapides" --}}
                <div class="rounded-3xl bg-white border border-slate-100 shadow-sm px-4 py-4 sm:px-5 sm:py-5 text-[12px]">
                    <h2 class="text-[13px] font-semibold text-slate-900 mb-3">
                        💡 Solutions rapides
                    </h2>
                    <div class="space-y-2.5">
                        {{-- <a href="#" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 transition group">
                            <div class="flex items-center gap-2.5">
                                <div class="p-1.5 rounded-lg bg-white border border-slate-200 group-hover:border-emerald-200">
                                    <svg class="w-4 h-4 text-slate-600 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-800">Consulter la FAQ</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <a href="#" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 transition group">
                            <div class="flex items-center gap-2.5">
                                <div class="p-1.5 rounded-lg bg-white border border-slate-200 group-hover:border-emerald-200">
                                    <svg class="w-4 h-4 text-slate-600 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-800">Suivre une commande</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a> --}}

                        <a href="{{ route('password.request') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 transition group">
                            <div class="flex items-center gap-2.5">
                                <div class="p-1.5 rounded-lg bg-white border border-slate-200 group-hover:border-emerald-200">
                                    <svg class="w-4 h-4 text-slate-600 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-800">Réinitialiser mon mot de passe</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Bloc WhatsApp  --}}
                {{-- <div class="rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-emerald-50 shadow-md px-4 py-4 sm:px-5 sm:py-5 text-[12px]">
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-100">
                                Besoin d’une réponse rapide ?
                            </p>
                            <p class="text-[13px] font-semibold">
                                Contact direct via WhatsApp.
                            </p>
                        </div>
                        <div class="hidden sm:flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10">
                            <svg class="h-4 w-4 text-emerald-100" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 00-8.94 14.49L2 22l5.7-1.96A10 10 0 1012 2zm5.19 14.09c-.22.62-1.11 1.13-1.55 1.2-.4.06-.9.11-1.46-.09-.34-.13-.78-.25-1.35-.49-2.39-1.03-3.94-3.44-4.06-3.6-.12-.17-.97-1.29-.97-2.47 0-1.18.61-1.76.83-2 .22-.24.48-.3.64-.3.16 0 .32 0 .46.01.15.01.35-.06.55.42.22.53.74 1.84.8 1.97.06.13.1.28.02.45-.08.17-.12.27-.24.42-.12.14-.25.32-.36.43-.12.12-.24.25-.11.49.13.24.59.96 1.26 1.55.87.78 1.6 1.03 1.84 1.15.24.12.39.1.53-.06.14-.16.61-.71.77-.96.16-.25.32-.2.55-.12.23.08 1.46.69 1.71.82.25.13.41.19.47.3.06.11.06.64-.16 1.26z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-emerald-50/90 text-[11px] mb-3">
                        Pour les situations urgentes (commande bloquée, problème de livraison important…),
                        privilégiez le contact direct.
                    </p>
                    <a href="#"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-white text-emerald-700 px-4 py-2.5 text-[12px] font-semibold shadow-sm hover:bg-emerald-50 transition">
                        <span>Écrire sur WhatsApp</span>
                    </a>
                    <p class="mt-2 text-[10px] text-emerald-100">
                        Merci de mentionner votre nom complet et, si possible, le numéro de commande.
                    </p>
                </div> --}}

            </aside>
        </section>
    </div>
</div>
@endsection
