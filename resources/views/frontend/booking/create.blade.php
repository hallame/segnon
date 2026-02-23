@extends('frontend.layouts.master')
@section('title', 'Réserver — ' . ($bookable->name ?? 'Élément'))
@section('content')

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


<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="mx-auto py-3 px-6">
        <nav class="flex items-center text-sm text-gray-600 space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">

            {{-- Lien vers la liste principale selon type --}}
            @switch($type)
                @case('room')
                    <a href="{{ route('hotels.index') }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
                        Hôtels
                    </a>
                        <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>
                    <a href="{{ route('hotels.show', $bookable->hotel) }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
                        <span class="truncate max-w-[150px] md:max-w-none">{{ $bookable->hotel->name }}</span>
                    </a>
                    <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>
                    @break

                @case('event')
                    <a href="{{ route('events.index') }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
                        <i class="fa-solid fa-calendar mr-1"></i> Événements
                    </a>
                    <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>
                    @break

                @case('site')
                    <a href="{{ route('sites.index') }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
                    <i class="fa-solid fa-tree mr-1"></i> Sites touristiques
                    </a>
                    <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>
                    @break

                @case('circuit')
                    <a href="{{ route('circuits.index') }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
                    <i class="fa-solid fa-route mr-1"></i> Circuits
                    </a>
                    <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>
                    @break

                @default
                {{-- Aucun lien principal connu --}}
            @endswitch

            {{-- Lien vers l'élément réservable --}}
            <a href="{{ url()->previous() }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
                <span class="truncate max-w-[150px] md:max-w-none">{{ $bookable->name }}</span>
            </a>

            <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>

            {{-- Page active --}}
            <span class="flex items-center text-emerald-600 font-semibold flex-shrink-0">
            <span class="truncate max-w-[150px] md:max-w-none">Réservation</span>
            </span>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Formulaire -->
        <div class="md:col-span-2">
        <div class="bg-white shadow-xl rounded-2xl p-4 border border-gray-100">

            <form action="{{ route('booking.store', ['type' => $type, 'slug' => $bookable->slug]) }}" method="POST" enctype="multipart/form-data" id="reservationForm" class="space-y-8">
                @csrf
                <input type="hidden" name="bookable_type" value="{{ get_class($bookable) }}">
                <input type="hidden" name="bookable_id" value="{{ $bookable->id }}">
                <input type="hidden" name="unit_price" value="{{ $bookable->price }}">


                <!-- Coordonnées -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                    <label for="firstname" class="block text-sm font-semibold text-gray-700 mb-1">Prénom</label>
                    <input type="text" name="firstname" autocomplete="given-name" id="firstname" value="{{ old('firstname') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        placeholder="Prénom" required>
                    </div>
                    <div>
                    <label for="lastname" class="block text-sm font-semibold text-gray-700 mb-1">Nom</label>
                    <input type="text" name="lastname" id="lastname" autocomplete="family-name" value="{{ old('lastname') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        placeholder="Nom de famille" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Adresse e-mail</label>
                    <input type="email" name="email" id="email" autocomplete="email" value="{{ old('email') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        placeholder="Ex: nom@mail.com" required>
                    </div>
                    <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" name="phone" id="phone" autocomplete="tel" value="{{ old('phone') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        placeholder="Ex: +123 00 00 00 00" required>
                    </div>
                </div>

                <!-- Dates -->

                @if ($type === 'event')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="check_in" class="block text-sm font-semibold text-gray-700 mb-1">Date d'arrivée</label>
                            <input type="date" name="check_in" id="check_in"
                                value="{{ optional($bookable->start_date)->format('Y-m-d') }}" readonly
                                class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700 shadow-sm focus:outline-none">
                        </div>
                        <div>
                            <label for="check_out" class="block text-sm font-semibold text-gray-700 mb-1">Date de départ</label>
                            <input type="date" name="check_out" id="check_out"
                                value="{{ optional($bookable->end_date)->format('Y-m-d') }}" readonly
                                class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700 shadow-sm focus:outline-none">
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="check_in" class="block text-sm font-semibold text-gray-700 mb-1">Date d'arrivée</label>
                            <input type="date" name="check_in" id="check_in"
                                value="{{ old('check_in') }}"
                                min="{{ $today }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                required>
                        </div>
                        <div>
                            <label for="check_out" class="block text-sm font-semibold text-gray-700 mb-1">Date de départ</label>
                            <input type="date" name="check_out" id="check_out"
                                value="{{ old('check_out') }}"
                                min="{{ $today }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                required>
                        </div>
                    </div>
                @endif


                <!-- Infos voyageurs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="guests" class="block text-sm font-semibold text-gray-700 mb-1">Nombre de personnes</label>
                        <input type="number" name="guests" id="guests" min="1" max="{{ $bookable->capacity ?? 10 }}"
                            value="{{ old('guests', 1) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                            placeholder="Ex: 2 personnes" required>
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-semibold text-gray-700 mb-1">Demande spéciale (optionnel)</label>
                        <input type="text" name="note" id="note" value="{{ old('note') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                            placeholder="Infos additionnelles">
                    </div>
                    {{-- <div>
                        <label for="special_requests" class="block text-sm font-semibold text-gray-700 mb-1">Demande spéciale (optionnel)</label>
                        <input type="text" name="special_requests" id="special_requests"
                            value="{{ old('special_requests') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                            placeholder="Ex: lit bébé, étage élevé...">
                    </div> --}}
                </div>

                <hr class="my-6 border-green-500">

                <!-- Paiement -->

                {{-- <div id="receiptField" class="hidden">
                    <label for="receipt" class="block text-sm font-semibold text-gray-700 mb-1">Reçu de paiement</label>

                    <input type="file" name="receipt" id="receipt" accept=".jpg,.jpeg,.png,.pdf" disabled
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 bg-white shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <p class="text-xs text-gray-400 mt-1">Formats acceptés : JPG, PNG, PDF</p>
                </div> --}}

                @if(!$methods->isEmpty())
                    {{-- Cartes méthodes --}}
                    <h2 class="block text-sm font-semibold text-gray-700 mb-1">Moyen de paiement</h2>
                    <div class="grid sm:grid-cols-2 gap-4" role="radiogroup" aria-label="Méthodes de paiement">
                        @foreach($methods as $m)
                            @php
                                $method = $m->type; // mobile_money, bank_transfer, cash, cod, card
                                $checked = $loop->first ? 'checked' : '';
                                $id = 'pm_'.$method.'_'.$m->id;
                            @endphp
                            <label for="{{ $id }}" class="group block cursor-pointer rounded-2xl border p-4 hover:shadow-sm transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="payment_method_id" id="{{ $id }}" value="{{ $m->id }}"
                                        data-type="{{ $method }}" data-details='@json($detailsFor($m))'
                                        class="mt-1 h-4 w-4 text-emerald-600 accent-emerald-600" {{ $checked }}>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            {!! $icon($method) !!}
                                            <span class="font-semibold">{{ $m->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('payment_method_id')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-6 space-y-4" id="methodPanels">
                        {{-- Mobile Money --}}
                        <div class="method-panel hidden" data-type="mobile_money">
                            <div class="rounded-2xl border p-4">
                            <h3 class="text-sm font-semibold mb-2">Mobile Money</h3>
                            <div class="text-sm text-gray-600" data-html="instructions"></div>

                            <div class="grid sm:grid-cols-2 gap-3 text-sm mt-2">
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="wallet_number">
                                <div class="text-gray-500">Numéro du compte</div>
                                <div class="font-medium" data-text="wallet_number"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="wallet_name">
                                <div class="text-gray-500">Nom du compte</div>
                                <div class="font-medium" data-text="wallet_name"></div>
                                </div>
                                {{-- <div class="rounded-xl border p-3 bg-gray-50" data-if="operator">
                                    <div class="text-gray-500">Opérateur Réseau</div>
                                    <div class="font-medium" data-text="operator"></div>
                                </div> --}}
                                {{-- <div class="rounded-xl border p-3 bg-gray-50">
                                    <div class="text-gray-500">Réf. à indiquer</div>
                                    <div class="font-medium">{{ $bookable->reference }}</div>
                                </div> --}}
                            </div>
                            </div>
                        </div>

                        {{-- Carte bancaire --}}
                        <div class="method-panel hidden" data-type="card">
                            <div class="rounded-2xl border p-4">
                            <h3 class="text-sm font-semibold mb-2">Carte bancaire</h3>
                            <div class="rounded-xl border p-4 text-sm text-gray-600" data-html="instructions">
                                {{-- Fallback si pas d’instructions --}}
                            </div>
                            </div>
                        </div>

                        {{-- Virement bancaire --}}
                        <div class="method-panel hidden" data-type="bank_transfer">
                            <div class="rounded-2xl border p-4">
                            <h3 class="text-sm font-semibold mb-2">Virement bancaire</h3>
                            <div class="text-sm text-gray-600" data-html="instructions"></div>
                            <div class="grid sm:grid-cols-2 gap-3 text-sm mt-2">
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="holder">
                                <div class="text-gray-500">Titulaire</div>
                                <div class="font-medium" data-text="holder"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="iban">
                                <div class="text-gray-500">IBAN / RIB</div>
                                <div class="font-medium" data-text="iban"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="bic">
                                <div class="text-gray-500">BIC / SWIFT</div>
                                <div class="font-medium" data-text="bic"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="bank_name">
                                <div class="text-gray-500">Banque</div>
                                <div class="font-medium" data-text="bank_name"></div>
                                </div>
                                {{-- <div class="rounded-xl border p-3 bg-gray-50">
                                    <div class="text-gray-500">Réf. à indiquer</div>
                                    <div class="font-medium">{{ $bookable->reference }}</div>
                                </div> --}}
                            </div>
                            </div>
                        </div>

                        {{-- Espèces --}}
                        <div class="method-panel hidden" data-type="cash">
                            <div class="rounded-2xl border p-4">
                            <h3 class="text-sm font-semibold mb-2">Paiement en espèce</h3>
                            <div class="text-sm text-gray-600" data-html="instructions"></div>
                            <div class="grid sm:grid-cols-2 gap-3 text-sm mt-2">
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="address">
                                <div class="text-gray-500">Adresse</div>
                                <div class="font-medium" data-text="address"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="hours">
                                <div class="text-gray-500">Horaires</div>
                                <div class="font-medium" data-text="hours"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="phone">
                                <div class="text-gray-500">Téléphone</div>
                                <div class="font-medium" data-text="phone"></div>
                                </div>
                                {{-- <div class="rounded-xl border p-3 bg-gray-50">
                                    <div class="text-gray-500">Numéro de commande</div>
                                    <div class="font-medium">{{ $bookable->reference }}</div>
                                </div> --}}
                            </div>
                            </div>
                        </div>

                        {{-- COD --}}
                        <div class="method-panel hidden" data-type="cod">
                            <div class="rounded-2xl border p-4">
                            <h3 class="text-sm font-semibold mb-2">Paiement à la livraison (COD)</h3>
                            <div class="text-sm text-gray-600" data-html="instructions"></div>
                            <div class="grid sm:grid-cols-2 gap-3 text-sm mt-2">
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="phone">
                                <div class="text-gray-500">Téléphone service</div>
                                <div class="font-medium" data-text="phone"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50" data-if="note">
                                <div class="text-gray-500">Note</div>
                                <div class="font-medium" data-text="note"></div>
                                </div>
                                <div class="rounded-xl border p-3 bg-gray-50">
                                <div class="text-gray-500">Numéro de commande</div>
                                <div class="font-medium">{{ $bookable->reference }}</div>
                                </div>
                            </div>
                            </div>
                        </div>

                        {{-- Upload reçu (Optionnel) --}}
                        <div class="rounded-2xl border p-4">
                            <label for="receipt" class="block text-sm font-medium mb-2">Reçu de paiement (Optionnel)</label>
                            <input id="receipt" name="receipt" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full rounded-2xl border p-3 focus:ring-2 focus:ring-emerald-500">
                            @error('receipt')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif



                <!-- Boutons -->
                <div class="pt-2 flex items-center justify-between">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-2 py-3 font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Confirmer
                    </button>
                    {{-- <a href="{{ url()->previous() ?? route('home') }}" class="text-sm text-gray-500 hover:text-gray-700">Annuler</a> --}}
                </div>
            </form>
        </div>
        </div>

        <!-- Récapitulatif -->
        <aside>
            <div class="bg-white border border-gray-100 shadow rounded-2xl p-6 space-y-4 sticky top-10">
                <div class="flex gap-4 items-center">
                    <img src="{{ $bookable->image ? asset('storage/'.$bookable->image) : asset('assets/front/images/hotel.jpg') }}"
                        alt="{{ $bookable->name }}" class="w-20 h-20 object-cover rounded-lg">
                    <div>
                        @switch($type)
                            @case('room')
                                <p class="text-sm text-gray-500">{{ $bookable->hotel->name }}</p>
                                <p class="text-sm text-gray-500">{{ $bookable->hotel->city }}, {{ $bookable->hotel->country->name }}</p>
                                @break

                            @case('event')
                                <p class="text-sm text-gray-500">{{ $bookable->location }}</p>
                                {{-- <p class="text-sm text-gray-500">{{ $bookable->city }}, {{ $bookable->country->name ?? '—' }}</p> --}}
                                @break

                            @case('site')
                                <p class="text-sm text-gray-500">{{ $bookable->city }}, {{ $bookable->country->name ?? '—' }}</p>
                                @break

                            @case('circuit')
                                <p class="text-sm text-gray-500">Circuit touristique</p>
                                <p class="text-sm text-gray-500">{{ $bookable->city ?? '-' }}</p>
                                @break
                            @case('museum')
                                <p class="text-sm text-gray-500">{{ $bookable->city }}, {{ $bookable->country->name ?? '—' }}</p>
                                @break
                            @default
                                <p class="text-sm text-gray-500">Information indisponible</p>
                        @endSwitch
                        <h3 class="text-lg font-semibold text-gray-800">{{ Str::limit($bookable->name, 30) }}</h3>
                    </div>
                </div>

                <div>
                <p class="text-sm text-gray-500">Tarif par {{ unit_label($bookable) }}</p>
                <p class="text-xl font-bold text-emerald-600">{{ number_format($bookable->price, 0, '', ' ') }} {{ $currency }}</p>
                </div>

                <div class="text-sm text-gray-600 space-y-1">

                <div class="flex justify-between">
                    <span>Nombre</span>
                    <span id="daysLabel">—</span>
                </div>

                <div class="flex justify-between">
                    <span>Total</span>
                    <span id="totalLabel">—</span>
                </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
    (() => {
        const price = {{ (int) $bookable->price }};
        const currency = @json($currency);
        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        const daysLabel = document.getElementById('daysLabel');
        const totalLabel = document.getElementById('totalLabel');
        const totalLabelOrange = document.getElementById('totalLabelOrange');
        const totalLabelMtn = document.getElementById('totalLabelMtn');
        const guests = document.getElementById('guests');
        const toDate = v => v ? new Date(v + 'T00:00:00') : null;
        const type = "{{ $type }}";
        const update = () => {
            const inDate = toDate(checkIn?.value);
            const outDate = toDate(checkOut?.value);
            let total = 0;

            if (type === 'event') {
                const guestCount = parseInt(guests?.value || 0, 10);
                daysLabel.textContent = guestCount;
                total = guestCount * price;
            }
            else if (inDate && outDate && outDate > inDate) {
                const days = Math.round((outDate - inDate) / 86400000);
                daysLabel.textContent = days;
                total = days * price;
            } else {
                daysLabel.textContent =
                totalLabel.textContent =
                totalLabelOrange.textContent =
                totalLabelMtn.textContent = '—';
                return; // évite d'afficher un prix vide
            }

            const formatted = total.toLocaleString('fr-FR') + ' ' + currency;
            totalLabel.textContent = formatted;
            totalLabelOrange.textContent = formatted;
            totalLabelMtn.textContent = formatted;
        };

        checkIn.addEventListener('change', update);
        checkOut.addEventListener('change', update);
        if (guests) guests.addEventListener('input', update);
        document.addEventListener('DOMContentLoaded', update);
    })();
</script>

<script>
    (function(){
    const radios = document.querySelectorAll('input[name="payment_method_id"]');
    const panels = document.querySelectorAll('.method-panel');

    function cap(s){ return (s||'').toString(); }

    function fillPanel(panel, details) {
        // instructions (HTML autorisé)
        const ih = panel.querySelector('[data-html="instructions"]');
        if (ih) {
        const html = details?.instructions || '';
        if (html) { ih.innerHTML = html; ih.classList.remove('hidden'); }
        else { ih.innerHTML = ' '; ih.classList.add('hidden'); }
        }

        // champs textes
        panel.querySelectorAll('[data-text]').forEach(el => {
        const name = el.getAttribute('data-text');
        const val  = details?.[name];
        const box  = el.closest('[data-if]');
        if (val && val !== '') {
            el.textContent = cap(val);
            if (box) box.classList.remove('hidden');
        } else {
            el.textContent = '';
            if (box) box.classList.add('hidden');
        }
        });
    }

    function showPanel(type, details) {
        panels.forEach(p => {
        const match = p.getAttribute('data-type') === type;
        p.classList.toggle('hidden', !match);
        if (match) fillPanel(p, details);
        });
    }

    radios.forEach(r => {
        const onChange = () => {
        const type = r.dataset.type;
        const details = JSON.parse(r.dataset.details || '{}');
        showPanel(type, details);
        };
        r.addEventListener('change', onChange);
        if (r.checked) onChange(); // init
    });

    // Fallback: aucune sélection => première
    if (radios.length && !Array.from(radios).some(r => r.checked)) {
        radios[0].checked = true;
        radios[0].dispatchEvent(new Event('change'));
    }
    })();
</script>

@endsection
