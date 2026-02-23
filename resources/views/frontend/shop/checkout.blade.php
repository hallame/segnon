@extends('frontend.layouts.master')
@section('title', 'Finaliser la commande')

@section('content')
@php
    $items    = $cart->items ?? collect();
    $subtotal = $items->sum('total_price');
    $count    = $items->sum('qty');
@endphp

<div class="min-h-[70vh] bg-slate-50 text-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 lg:py-8">

        {{-- HEADER / ÉTAPES --}}
        <header class="mb-6">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-700">
                        Validation de votre commande
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                        Coordonnées & confirmation
                    </h1>
                    <p class="mt-1 text-[12px] text-slate-600">
                        Renseignez vos informations pour le suivi de votre commande.
                    </p>
                </div>

                {{-- Steps --}}
                <ol class="flex items-center gap-2 text-[11px] text-slate-600">
                    <li class="flex items-center gap-1">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-[11px] font-semibold text-white">
                            1
                        </span>
                        <span class="font-semibold text-slate-900">Panier</span>
                    </li>
                    <span class="h-px w-6 bg-slate-300"></span>
                    <li class="flex items-center gap-1">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-[11px] font-semibold text-white">
                            2
                        </span>
                        <span class="font-semibold text-slate-900">Coordonnées</span>
                    </li>
                    <span class="h-px w-6 bg-slate-300"></span>
                    <li class="flex items-center gap-1">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-[11px] font-semibold text-slate-600">
                            3
                        </span>
                        <span>Paiement</span>
                    </li>
                </ol>
            </div>
        </header>

        {{-- SI PANIER VIDE --}}
        @if($items->isEmpty())
            <section
                class="rounded-3xl border border-dashed border-slate-200 bg-white/90 shadow-sm px-6 py-10 text-center">
                <div
                    class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <i class="ri-shopping-bag-3-line text-xl"></i>
                </div>
                <h2 class="text-lg font-semibold text-slate-900">Aucun article à valider</h2>
                <p class="mt-1 text-[13px] text-slate-600">
                    Votre panier est vide. Ajoutez des produits avant de finaliser votre commande.
                </p>
                <a href="{{ route('shop.products.index') }}"
                   class="inline-flex items-center justify-center gap-2 mt-5 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-500 px-5 py-2.5 text-[13px] font-semibold text-white shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                    <i class="ri-store-2-line text-sm"></i>
                    Retourner à la boutique
                </a>
            </section>
        @else
            {{-- LAYOUT : FORM + RÉCAP --}}
            <section class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.6fr)_minmax(0,1.05fr)] gap-6 lg:gap-7 items-start">

                {{-- FORMULAIRE DE CHECKOUT --}}
                <div>
                    {{-- Erreurs globales éventuelles --}}
                    @if($errors->any())
                        <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-[12px] text-rose-700">
                            <div class="flex items-start gap-2">
                                <i class="ri-alert-line mt-[2px] text-[16px]"></i>
                                <div>
                                    <p class="font-semibold mb-1">Merci de vérifier les informations saisies.</p>
                                    <ul class="list-disc list-inside space-y-0.5">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('shop.checkout.store') }}" {{-- ajuste si ton POST est différent --}}
                        class="space-y-5"
                        novalidate>
                        @csrf

                        {{-- BLOC 1 : Infos client --}}
                        <section class="rounded-3xl border border-slate-100 bg-white shadow-sm px-4 py-4 sm:px-5 sm:py-5">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <div>
                                    <h2 class="text-[14px] font-semibold text-slate-900">Vos coordonnées</h2>
                                    <p class="text-[11px] text-slate-500">
                                        Ces informations permettent à la boutique de vous contacter et de livrer la commande.
                                    </p>
                                </div>
                                <div
                                    class="hidden sm:flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                    <i class="ri-user-line text-[16px]"></i>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                {{-- Nom --}}
                                <div>
                                    <label for="lastname"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
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

                                {{-- Prénom --}}
                                <div>
                                    <label for="firstname"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Prénom <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        id="firstname"
                                        name="firstname"
                                        type="text"
                                        value="{{ old('firstname') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Adresse email <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        value="{{ old('email') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>

                                {{-- Téléphone --}}
                                <div>
                                    <label for="phone"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Téléphone (WhatsApp de préférence) <span class="text-rose-500">*</span>
                                    </label>
                                    <input required
                                        id="phone"
                                        name="phone"
                                        type="number"
                                        value="{{ old('phone') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                            </div>
                        </section>

                        {{-- BLOC 2 : Adresse / Livraison --}}
                        <section class="rounded-3xl border border-slate-100 bg-white shadow-sm px-4 py-4 sm:px-5 sm:py-5">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <div>
                                    <h2 class="text-[14px] font-semibold text-slate-900">Adresse & livraison</h2>
                                    <p class="text-[11px] text-slate-500">
                                        Ville, pays et précisions pour organiser la livraison ou le retrait.
                                    </p>
                                </div>
                                <div
                                    class="hidden sm:flex h-8 w-8 items-center justify-center rounded-2xl bg-slate-900 text-slate-50">
                                    <i class="ri-map-pin-line text-[16px]"></i>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                                <div>
                                    <label for="state"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Pays
                                    </label>
                                    <input id="country" name="shipping_address[country]" type="text"
                                        value="{{ old('shipping_address.country') }}"
                                        placeholder="...."
                                        autocomplete="country-name"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>

                                <div>
                                    <label for="city"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Ville
                                    </label>
                                    <input id="city" name="shipping_address[city]" type="text" value="{{ old('shipping_address.city') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>

                                <div>
                                    <label for="state"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Région
                                    </label>
                                    <input id="state" name="shipping_address[state]" type="text" value="{{ old('shipping_address.state') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>

                                <div>
                                    <label for="city"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Code Postal
                                    </label>
                                    <input id="zip" name="shipping_address[zip]" type="text"
                                        value="{{ old('shipping_address.zip') }}"
                                        placeholder="00000"
                                        autocomplete="postal-code"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                            </div>

                            {{-- Adresse ligne + compléments --}}




                            <div class="mt-3 space-y-3">
                                <div>
                                    <label for="address"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Adresse détaillée / point de repère
                                    </label>
                                    <input id="line1" name="shipping_address[line1]"  type="text"
                                        value="{{ old('shipping_address.line1') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>

                                <div>
                                    <label for="note"
                                           class="block text-[11px] font-semibold text-slate-800 mb-1.5">
                                        Informations complémentaires (optionnel)
                                    </label>
                                    <textarea id="note"  name="note" rows="3"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-[12px] text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Ex. : créneau de livraison souhaité, indications pour trouver l’adresse…">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </section>

                        {{-- BLOC 3 : Mode de paiement (simple placeholder, logique côté backend existante) --}}
                        {{-- <section class="rounded-3xl border border-slate-100 bg-white shadow-sm px-4 py-4 sm:px-5 sm:py-5">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <div>
                                    <h2 class="text-[14px] font-semibold text-slate-900">Mode de paiement</h2>

                                </div>
                                <div
                                    class="hidden sm:flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                    <i class="ri-bank-card-line text-[16px]"></i>
                                </div>
                            </div>

                            <div class="space-y-2 text-[12px]">
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="radio" name="payment_method" value="mobile_money"
                                           class="mt-[3px] h-3 w-3 border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                           checked>
                                    <span>
                                        <span class="font-semibold text-slate-900">Mobile Money / transfert</span>

                                    </span>
                                </label>
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash_on_delivery"
                                           class="mt-[3px] h-3 w-3 border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                    <span>
                                        <span class="font-semibold text-slate-900">Paiement à la livraison / retrait</span>
                                    </span>
                                </label>
                            </div>
                        </section> --}}

                        {{-- BOUTON PRINCIPAL MOBILE (en doublon avec sidebar) --}}
                        <div class="lg:hidden">
                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-500 px-5 py-3 text-[13px] font-semibold text-white shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                                <i class="ri-lock-2-line text-sm"></i>
                                Confirmer ma commande
                            </button>
                            <p class="mt-2 text-[11px] text-slate-500 flex items-start gap-1.5">
                                <i class="ri-shield-check-line text-[14px] text-emerald-600 mt-[1px]"></i>
                                <span>Vous recevrez un récapitulatif de commande par email.</span>
                            </p>
                        </div>
                    </form>
                </div>

                {{-- RÉCAPITULATIF COMMANDE --}}
                <aside class="lg:sticky lg:top-20">
                    <div class="rounded-3xl border border-slate-100 bg-white shadow-soft px-4 py-4 sm:px-5 sm:py-5">
                        <h2 class="text-[14px] font-semibold text-slate-900">Récapitulatif</h2>
                        <p class="mt-1 text-[11px] text-slate-500">
                            {{ $count }} article{{ $count>1 ? 's' : '' }} dans votre commande.
                        </p>

                        {{-- Liste compacte des articles --}}
                        <div class="mt-3 space-y-2 max-h-64 overflow-y-auto pr-1">
                            @foreach($items as $item)
                                @php
                                    $media = $item->product->getFirstMedia('gallery');
                                    $img   = $media ? asset('storage/'.$media->getPathRelativeToRoot()) : asset('assets/images/box.png');
                                    $attrs = $item->sku && $item->sku->attributes
                                        ? collect($item->sku->attributes)->map(fn($v,$k)=>ucfirst($k).': '.$v)->implode(' • ')
                                        : null;
                                @endphp
                                <div class="flex items-center gap-2 rounded-2xl border border-slate-100 bg-slate-50 px-2 py-2">
                                    <div class="h-12 w-12 rounded-xl overflow-hidden bg-slate-200 shrink-0">
                                        <img
                                            src="{{ $img }}"
                                            alt="{{ $item->product->name }}"
                                            class="h-full w-full object-cover"
                                            onerror="this.src='{{ asset('assets/images/box.png') }}'">
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[12px] font-semibold text-slate-900 truncate">
                                            {{ $item->product->name }}
                                        </p>
                                        @if($attrs)
                                            <p class="text-[10px] text-slate-500 truncate">
                                                {{ $attrs }}
                                            </p>
                                        @endif
                                        <p class="text-[10px] text-slate-500">
                                            Qté : {{ $item->qty }}
                                        </p>
                                    </div>
                                    <div class="text-right text-[11px] font-semibold text-slate-900">
                                        {{ number_format($item->total_price, 0, ',', ' ') }} {{ $currency }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total --}}
                        <dl class="mt-4 space-y-2 text-[13px]">
                            <div class="flex items-center justify-between">
                                <dt class="text-slate-600">Sous-total</dt>
                                <dd class="font-semibold text-slate-900">
                                    {{ number_format($subtotal, 0, ',', ' ') }} {{ $currency }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-slate-600">Livraison</dt>
                                <dd class="text-[12px] text-slate-500">
                                    Veuillez contacter le vendeur
                                </dd>
                            </div>
                            <div class="mt-2 border-t border-dashed border-slate-200 pt-2 flex items-center justify-between text-[14px]">
                                <dt class="font-semibold text-slate-900">Total estimé</dt>
                                <dd class="text-[17px] font-extrabold text-emerald-700">
                                    {{ number_format($subtotal, 0, ',', ' ') }} {{ $currency }}
                                </dd>
                            </div>
                        </dl>

                        {{-- CTA principal desktop --}}
                        <button
                            form="{{-- pas besoin, même form au-dessus --}}"
                            type="submit"
                            onclick="this.closest('aside').previousElementSibling.querySelector('form').submit();"
                            class="hidden lg:flex mt-4 w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-500 px-5 py-3 text-[13px] font-semibold text-white shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                            <i class="ri-lock-2-line text-sm"></i>
                            Confirmer ma commande
                        </button>

                        <p class="hidden lg:flex mt-2 text-[11px] text-slate-500 items-start gap-1.5">
                            <i class="ri-shield-check-line text-[14px] text-emerald-600 mt-[1px]"></i>
                            <span>Vos informations sont utilisées uniquement pour la gestion de cette commande.</span>
                        </p>
                    </div>
                </aside>
            </section>
        @endif
    </div>
</div>
@endsection
