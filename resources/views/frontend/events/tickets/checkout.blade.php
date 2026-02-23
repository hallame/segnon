{{-- resources/views/frontend/events/checkout.blade.php --}}
@extends('frontend.layouts.master')
@section('title', 'Finaliser ma commande — '.$event->name)

@php
    $today = now()->toDateString();

    /** Détails sérialisés par TYPE (pour data-details) */
    $detailsFor = function ($m) {
        $out = ['instructions' => $m->instructions];
        switch ($m->type) {
            case 'mobile_money':
                $x = $m->mobileMoney;
                $out += [
                    'operator'       => $x->operator ?? null,
                    'wallet_number'  => $x->wallet_number ?? null,
                    'wallet_name'    => $x->wallet_name ?? null,
                    'reference_hint' => $x->reference_hint ?? null,
                ];
                break;
            case 'bank_transfer':
                $x = $m->bank;
                $out += [
                    'bank_name'      => $x->bank_name ?? null,
                    'holder'         => $x->holder ?? null,
                    'iban'           => $x->iban ?? null,
                    'bic'            => $x->bic ?? null,
                    'reference_hint' => $x->reference_hint ?? null,
                ];
                break;
            case 'cash':
                $x = $m->cash;
                $out += [
                    'address' => $x->address ?? null,
                    'hours'   => $x->hours ?? null,
                    'phone'   => $x->phone ?? null,
                ];
                break;
            case 'cod':
                $x = $m->cod;
                $out += [
                    'phone' => $x->phone ?? null,
                    'note'  => $x->note ?? null,
                ];
                break;
            case 'card':
                $x = $m->card;
                $out += [
                    'provider' => $x->provider ?? null,
                ];
                break;
        }
        return $out;
    };

    $icon = function (string $method): string {
        return match ($method) {
            'card' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 9h20"/><rect x="6" y="13" width="5" height="3" rx="0.5"/><path d="M14.5 14h3.5"/></svg>',
            'mobile_money' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="2" width="10" height="20" rx="2"/><path d="M10 6h4"/><path d="M9 12h6"/><path d="M12 18h.01"/><path d="M20 8l2 2-2 2"/></svg>',
            'cash','cod' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="12" cy="12" r="3"/><path d="M7 9v0M17 15v0"/></svg>',
            'bank_transfer' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10V8l8-5 8 5v2"/><path d="M3 10h18"/><path d="M6 10v8M10 10v8M14 10v8M18 10v8"/><path d="M4 22h16"/></svg>',
            default => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/></svg>',
        };
    };
@endphp

@section('content')
<section class="bg-slate-50/70">
    <div class="max-w-5xl mx-auto px-4 py-8 md:py-10">

        {{-- Fil d’ariane / retour --}}
        <div class="flex items-center justify-between gap-3 mb-4">
            <a href="{{ route('events.buy', $event) }}"
               class="inline-flex items-center gap-1 text-xs md:text-sm text-emerald-700 hover:text-emerald-900">
                <i class="ri-arrow-left-line text-sm"></i>
                Retour à la billetterie
            </a>

            <div class="hidden sm:flex items-center gap-1 text-[11px] text-zinc-500">
                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100">Étape 2</span>
                <span>•</span>
                <span>Sélection des billets</span>
                <span>›</span>
                <span class="font-semibold text-zinc-800">Infos & paiement</span>
                <span>›</span>
                <span>Confirmation</span>
            </div>
        </div>

        {{-- Header principal --}}
        <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-50 via-white to-amber-50 border border-emerald-100/60 px-5 py-4 md:px-6 md:py-5 flex flex-col md:flex-row md:items-end md:justify-between gap-4 shadow-sm">
            <div>
                <p class="text-[11px] uppercase tracking-[0.2em] text-emerald-700 font-semibold mb-1">
                    Confirmation de commande
                </p>
                <h1 class="text-xl md:text-2xl font-extrabold text-zinc-900">
                    Finaliser la commande — {{ $event->name }}
                </h1>
                <p class="text-xs md:text-sm text-zinc-600 mt-1 max-w-xl">
                    Vérifiez le récapitulatif, complétez vos coordonnées puis choisissez votre moyen de paiement.
                </p>
            </div>

            <div class="text-right text-xs md:text-sm text-zinc-500 space-y-1 md:space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/80 border border-zinc-200 shadow-xs">
                    <span class="text-[11px] uppercase tracking-wide text-zinc-500">Réf.</span>
                    <span class="font-semibold text-zinc-900">{{ $ot->reference }}</span>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-wide text-zinc-500">Total</span>
                    <div class="text-base md:text-lg font-extrabold text-zinc-900">
                        {{ number_format($ot->total, 0, ',', ' ') }} {{ $ot->currency }}
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50/90 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2">
                <i class="ri-checkbox-circle-line mt-[2px]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif


        @if(session('error'))
            <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50/90 px-4 py-3 text-sm text-rose-800 flex items-start gap-2">
                <i class="ri-error-warning-line mt-[2px]"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif


        {{-- Layout principal : à gauche récap / à droite formulaire --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

             <div class="lg:col-span-2">
                {{-- Formulaire client + paiement --}}
                <form action="{{ route('events.checkout.pay', [$event, $ot]) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    {{-- Coordonnées client --}}
                    <div class="rounded-3xl border border-zinc-200 bg-white/95 backdrop-blur-sm p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-zinc-50 text-zinc-700 text-sm">
                                    <i class="ri-user-line"></i>
                                </span>
                                <h2 class="text-sm font-semibold text-zinc-900">Vos informations</h2>
                            </div>
                            <span class="text-[11px] text-zinc-400">Étape 2/2</span>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            <div class="grid md:grid-cols-2 gap-3">
                                <div>
                                    <label for="customer_firstname" class="block text-xs font-medium text-zinc-700 mb-1">
                                        Prénom
                                    </label>
                                    <input type="text" id="customer_firstname" name="customer_firstname"
                                        value="{{ old('customer_firstname', $ot->customer_firstname) }}"
                                        class="w-full text-sm rounded-xl border border-zinc-200 bg-zinc-50/60 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('customer_firstname')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_lastname" class="block text-xs font-medium text-zinc-700 mb-1">
                                        Nom
                                    </label>
                                    <input type="text" id="customer_lastname" name="customer_lastname"
                                        value="{{ old('customer_lastname', $ot->customer_lastname) }}"
                                        class="w-full text-sm rounded-xl border border-zinc-200 bg-zinc-50/60 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('customer_lastname')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="customer_email" class="block text-xs font-medium text-zinc-700 mb-1">
                                    E-mail de réception des billets
                                </label>
                                <input type="email" id="customer_email" name="customer_email"
                                    value="{{ old('customer_email', $ot->customer_email) }}"
                                    class="w-full text-sm rounded-xl border border-zinc-200 bg-zinc-50/60 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('customer_email')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-xs font-medium text-zinc-700 mb-1">
                                    Téléphone (pour contact rapide)
                                </label>
                                <input type="text" id="customer_phone" name="customer_phone"
                                    value="{{ old('customer_phone', $ot->customer_phone) }}"
                                    class="w-full text-sm rounded-xl border border-zinc-200 bg-zinc-50/60 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('customer_phone')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Paiement --}}
                    <div class="rounded-3xl border border-zinc-200 bg-white/95 backdrop-blur-sm p-5 shadow-sm space-y-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 text-sm">
                                    <i class="ri-bank-card-line"></i>
                                </span>
                                <h2 class="text-sm font-semibold text-zinc-900">Paiement</h2>
                            </div>
                            <span class="text-[11px] text-zinc-400">
                                Montant : <span class="font-semibold text-zinc-700">{{ number_format($ot->total, 0, ',', ' ') }} {{ $ot->currency }}</span>
                            </span>
                        </div>

                        @php
                            $showOfflineMethods = old('payment_method_id') || $errors->has('payment_method_id');
                        @endphp
                        @if(!$methods->isEmpty())
                            <div id="offlineMethods" class="mt-4 {{ $showOfflineMethods ? '' : 'hidden' }}">
                                <h3 class="block text-[11px] font-semibold text-zinc-600 mb-2 uppercase tracking-wide">
                                    Moyen de paiement
                                </h3>

                                <div class="grid sm:grid-cols-2 gap-3 mb-3" role="radiogroup" aria-label="Méthodes de paiement">
                                    @foreach($methods as $m)
                                        @php
                                            $method  = $m->type; // mobile_money, bank_transfer, cash, cod, card
                                            $checked = old('payment_method_id', $loop->first ? $m->id : null) == $m->id ? 'checked' : '';
                                            $id      = 'pm_'.$method.'_'.$m->id;
                                        @endphp
                                        <label for="{{ $id }}" class="group block cursor-pointer rounded-2xl border border-zinc-200/90 bg-zinc-50/60 p-3 hover:shadow-sm transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                                            <div class="flex items-start gap-3">
                                                <input type="radio" name="payment_method_id" id="{{ $id }}" value="{{ $m->id }}"
                                                    data-type="{{ $method }}" data-details='@json($detailsFor($m))'
                                                    class="mt-1 h-4 w-4 text-emerald-600 accent-emerald-600">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 text-sm">
                                                        {!! $icon($method) !!}
                                                        <span class="font-semibold text-zinc-900">{{ $m->name }}</span>
                                                    </div>
                                                    @if($m->label)
                                                        <p class="text-[11px] text-zinc-500 mt-0.5">{{ $m->label }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                @error('payment_method_id')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror

                                <div class="mt-4 space-y-4 text-sm" id="methodPanels">
                                    {{-- Mobile Money --}}
                                    <div class="method-panel hidden" data-type="mobile_money">
                                        <div class="rounded-2xl border border-zinc-200 p-3 bg-zinc-50/80">
                                            <h3 class="text-xs font-semibold mb-2 text-zinc-800">Mobile Money</h3>
                                            <div class="text-xs text-zinc-600" data-html="instructions"></div>
                                            <div class="grid sm:grid-cols-2 gap-2 text-xs mt-2">
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="wallet_number">
                                                    <div class="text-zinc-500 text-[11px]">Numéro du compte</div>
                                                    <div class="font-medium" data-text="wallet_number"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="wallet_name">
                                                    <div class="text-zinc-500 text-[11px]">Nom du compte</div>
                                                    <div class="font-medium" data-text="wallet_name"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Carte bancaire --}}
                                    <div class="method-panel hidden" data-type="card">
                                        <div class="rounded-2xl border border-zinc-200 p-3 bg-zinc-50/80">
                                            <h3 class="text-xs font-semibold mb-2 text-zinc-800">Carte bancaire</h3>
                                            <div class="rounded-xl border border-zinc-200 p-3 text-xs text-zinc-600 bg-white" data-html="instructions"></div>
                                        </div>
                                    </div>

                                    {{-- Virement bancaire --}}
                                    <div class="method-panel hidden" data-type="bank_transfer">
                                        <div class="rounded-2xl border border-zinc-200 p-3 bg-zinc-50/80">
                                            <h3 class="text-xs font-semibold mb-2 text-zinc-800">Virement bancaire</h3>
                                            <div class="text-xs text-zinc-600" data-html="instructions"></div>
                                            <div class="grid sm:grid-cols-2 gap-2 text-xs mt-2">
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="holder">
                                                    <div class="text-zinc-500 text-[11px]">Titulaire</div>
                                                    <div class="font-medium" data-text="holder"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="iban">
                                                    <div class="text-zinc-500 text-[11px]">IBAN / RIB</div>
                                                    <div class="font-medium" data-text="iban"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="bic">
                                                    <div class="text-zinc-500 text-[11px]">BIC / SWIFT</div>
                                                    <div class="font-medium" data-text="bic"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="bank_name">
                                                    <div class="text-zinc-500 text-[11px]">Banque</div>
                                                    <div class="font-medium" data-text="bank_name"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Espèces --}}
                                    <div class="method-panel hidden" data-type="cash">
                                        <div class="rounded-2xl border border-zinc-200 p-3 bg-zinc-50/80">
                                            <h3 class="text-xs font-semibold mb-2 text-zinc-800">Paiement en espèce</h3>
                                            <div class="text-xs text-zinc-600" data-html="instructions"></div>
                                            <div class="grid sm:grid-cols-2 gap-2 text-xs mt-2">
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="address">
                                                    <div class="text-zinc-500 text-[11px]">Adresse</div>
                                                    <div class="font-medium" data-text="address"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="hours">
                                                    <div class="text-zinc-500 text-[11px]">Horaires</div>
                                                    <div class="font-medium" data-text="hours"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="phone">
                                                    <div class="text-zinc-500 text-[11px]">Téléphone</div>
                                                    <div class="font-medium" data-text="phone"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- COD --}}
                                    <div class="method-panel hidden" data-type="cod">
                                        <div class="rounded-2xl border border-zinc-200 p-3 bg-zinc-50/80">
                                            <h3 class="text-xs font-semibold mb-2 text-zinc-800">Paiement à la livraison (COD)</h3>
                                            <div class="text-xs text-zinc-600" data-html="instructions"></div>
                                            <div class="grid sm:grid-cols-2 gap-2 text-xs mt-2">
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="phone">
                                                    <div class="text-zinc-500 text-[11px]">Téléphone service</div>
                                                    <div class="font-medium" data-text="phone"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white" data-if="note">
                                                    <div class="text-zinc-500 text-[11px]">Note</div>
                                                    <div class="font-medium" data-text="note"></div>
                                                </div>
                                                <div class="rounded-xl border border-zinc-200 p-2 bg-white">
                                                    <div class="text-zinc-500 text-[11px]">Numéro de commande</div>
                                                    <div class="font-medium">{{ $ot->reference }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Upload reçu (Optionnel) --}}
                                    {{-- <div class="rounded-2xl border border-zinc-200 p-3 bg-zinc-50/80">
                                        <label for="receipt" class="block text-xs font-medium mb-1 text-zinc-700">
                                            Reçu de paiement (optionnel)
                                        </label>
                                        <input id="receipt" name="receipt" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                            class="w-full rounded-2xl border border-zinc-200 px-3 py-2 text-xs bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        @error('receipt')
                                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div> --}}

                                    {{-- <div class="grid md:grid-cols-2 gap-3">
                                        <div>
                                            <label for="transaction_number" class="block text-xs font-medium text-zinc-700 mb-1">
                                                Référence / numéro de transaction
                                            </label>
                                            <input type="text" id="transaction_number" name="transaction_number"
                                                value="{{ old('transaction_number') }}"
                                                class="w-full text-sm rounded-xl border border-zinc-200 bg-zinc-50/60 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                            @error('transaction_number')
                                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="note" class="block text-xs font-medium text-zinc-700 mb-1">
                                                Note pour l’équipe (optionnel)
                                            </label>
                                            <textarea id="note" name="note" rows="3"
                                                    class="w-full text-sm rounded-xl border border-zinc-200 bg-zinc-50/60 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('note') }}</textarea>
                                            @error('note')
                                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        @endif


                        <div class="pt-4 border-t px-5 border-dashed border-zinc-200 flex flex-col sm:flex-row items-center justify-between gap-3">

                            <button type="submit"
                                    id="btn-offline"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-zinc-800 hover:bg-zinc-900 text-white font-semibold px-5 py-2.5 text-sm shadow-sm mb-2">
                                <i class="ri-check-line text-lg"></i>
                                <span class="btn-offline-label">Payer hors ligne</span>
                            </button>

                            {{-- Paiement en ligne (Moneroo) --}}

                            {{-- @php
                                $hasAmount = $ot->total > 0;
                            @endphp

                            <button  type="submit"
                                @if($hasAmount)
                                    formaction="{{ route('events.orders.pay.moneroo', [$event, $ot]) }}"
                                @endif
                                class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 mb-2 text-sm font-semibold shadow-sm
                                    bg-emerald-600 hover:bg-emerald-700 text-white
                                    @unless($hasAmount) opacity-50 cursor-not-allowed pointer-events-none @endunless"
                                @unless($hasAmount) disabled aria-disabled="true" @endunless >
                                <i class="ri-bank-card-line text-lg"></i>
                                <span>Paiement en ligne</span>
                            </button> --}}


                        </div>

                    </div>

                    {{-- CTA global --}}




                </form>
             </div>

             {{-- Récap des billets --}}
            <div class="lg:col-span-1 space-y-4">
                <div class="rounded-3xl border border-zinc-200 bg-white/90 backdrop-blur-sm shadow-sm">
                    <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 text-sm">
                                <i class="ri-ticket-2-line"></i>
                            </span>
                            <h2 class="text-sm font-semibold text-zinc-900">Vos tickets</h2>
                        </div>
                        {{-- <span class="text-[11px] text-zinc-500">
                            {{ $ot->items->count() }} ligne{{ $ot->items->count() > 1 ? 's' : '' }}
                        </span> --}}
                    </div>

                    <div class="px-5 py-4">
                        @if($ot->items->isEmpty())
                            <p class="text-sm text-zinc-600">Aucun billet dans cette commande.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($ot->items as $item)
                                    <div class="flex items-center justify-between gap-3 text-sm rounded-2xl border border-zinc-100 bg-zinc-50/60 px-3 py-2.5">
                                        <div class="flex-1">
                                            <div class="font-semibold text-zinc-900">
                                                {{ $item->ticket_type_name }}
                                            </div>
                                            <div class="text-[11px] text-zinc-500">
                                                {{ $item->qty }} × {{ number_format($item->unit_price, 0, ',', ' ') }} {{ $ot->currency }}
                                            </div>
                                        </div>
                                        <div class="text-right font-semibold text-zinc-900 text-sm">
                                            {{ number_format($item->total_price, 0, ',', ' ') }} {{ $ot->currency }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-3 border-t border-dashed border-zinc-200 text-sm space-y-1.5">
                                <div class="flex justify-between">
                                    <span class="text-zinc-500">Sous-total</span>
                                    <span class="font-medium text-zinc-900">
                                        {{ number_format($ot->subtotal, 0, ',', ' ') }} {{ $ot->currency }}
                                    </span>
                                </div>

                                @if($ot->discount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-zinc-500">Remise</span>
                                        <span class="font-medium text-emerald-700">
                                            -{{ number_format($ot->discount, 0, ',', ' ') }} {{ $ot->currency }}
                                        </span>
                                    </div>
                                @endif

                                @if($ot->tax > 0)
                                    <div class="flex justify-between">
                                        <span class="text-zinc-500">Taxes</span>
                                        <span class="font-medium text-zinc-900">
                                            {{ number_format($ot->tax, 0, ',', ' ') }} {{ $ot->currency }}
                                        </span>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center mt-2 pt-2 border-t border-zinc-200">
                                    <span class="text-zinc-700 text-sm font-semibold">Total à payer</span>
                                    <span class="text-lg font-extrabold text-zinc-900">
                                        {{ number_format($ot->total, 0, ',', ' ') }} {{ $ot->currency }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Petit bloc infos pratiques --}}
                <div class="rounded-2xl border border-amber-100 bg-amber-50/80 px-4 py-3 text-xs text-amber-800 flex gap-2">
                    <i class="ri-information-line mt-[1px] text-base"></i>
                    <p>
                        Vos billets et la confirmation de paiement seront envoyés
                        à votre adresse e-mail.
                    </p>
                </div>
            </div>


        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radios = document.querySelectorAll('input[name="payment_method_id"]');
        const panels = document.querySelectorAll('.method-panel');
        const offlineBtn = document.getElementById('btn-offline');
        const offlineMethods = document.getElementById('offlineMethods');
        const offlineLabel = offlineBtn ? offlineBtn.querySelector('.btn-offline-label') : null;

        function updatePanel() {
            const checked = document.querySelector('input[name="payment_method_id"]:checked');
            panels.forEach(p => p.classList.add('hidden'));
            if (!checked) return;
            const type = checked.dataset.type;
            const details = JSON.parse(checked.dataset.details || '{}');

            const active = document.querySelector(`.method-panel[data-type="${type}"]`);
            if (active) {
                active.classList.remove('hidden');

                active.querySelectorAll('[data-html]').forEach(el => {
                    const key = el.getAttribute('data-html');
                    el.innerHTML = details[key] || '';
                });

                active.querySelectorAll('[data-text]').forEach(el => {
                    const key = el.getAttribute('data-text');
                    el.textContent = details[key] || '';
                });

                active.querySelectorAll('[data-if]').forEach(el => {
                    const key = el.getAttribute('data-if');
                    const val = details[key] ?? null;
                    el.style.display = val ? '' : 'none';
                });
            }
        }

        radios.forEach(r => r.addEventListener('change', updatePanel));
        updatePanel();

        // --- gestion du bouton hors ligne : 2 états visuels ---

        function setOfflineAsChooser() {
            if (!offlineBtn || !offlineLabel) return;
            offlineLabel.textContent = 'Paiement hors ligne';
            offlineBtn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
            offlineBtn.classList.add('bg-zinc-800', 'hover:bg-zinc-900');
        }

        function setOfflineAsSubmit() {
            if (!offlineBtn || !offlineLabel) return;
            offlineLabel.textContent = 'Valider Paiement';
            offlineBtn.classList.remove('bg-zinc-800', 'hover:bg-zinc-900');
            offlineBtn.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
        }

        if (offlineBtn && offlineMethods) {
            // État initial : si le bloc est déjà visible (erreur de validation), on passe direct en mode "submit"
            if (offlineMethods.classList.contains('hidden')) {
                setOfflineAsChooser();
            } else {
                setOfflineAsSubmit();
            }

            offlineBtn.addEventListener('click', function (e) {
                // 1er clic : on ouvre les moyens de paiement + on change le style/texte du bouton
                if (offlineMethods.classList.contains('hidden')) {
                    e.preventDefault();
                    offlineMethods.classList.remove('hidden');
                    setOfflineAsSubmit();
                    offlineMethods.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                // 2e clic : le bloc est déjà visible → on laisse soumettre normalement
            });
        }
    });
</script>

@endsection
