@extends('frontend.layouts.master')
@section('title','Paiement')

@php
  use Illuminate\Support\Str;
  $fmt = fn($n) => number_format((float)$n, 0, ',', ' ') . ' ' . $currency;

  $status = Str::of($order->status ?? 'pending')->lower()->toString();
  $statusMap = [
    'paid'          => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => 'Payée'],
    'succeeded'     => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => 'Réussie'],
    'pending'       => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'label' => 'En attente'],
    'under_review'  => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'label' => 'En cours de vérification'],
    'failed'        => ['bg' => 'bg-rose-50',    'text' => 'text-rose-700',    'label' => 'Échouée'],
    'rejected'      => ['bg' => 'bg-rose-50',    'text' => 'text-rose-700',    'label' => 'Rejetée'],
    'cancelled'     => ['bg' => 'bg-gray-100',   'text' => 'text-gray-700',    'label' => 'Annulée'],
  ];
  $s = $statusMap[$status] ?? $statusMap['pending'];

    // Dernier paiement
  $paymentStatus = null;
  if (isset($payment) && $payment) {
    $ps = Str::of($payment->status ?? 'pending')->lower()->toString(); // ✅
    $paymentStatus = $statusMap[$ps] ?? $statusMap['pending'];
  }

   $icon = function (string $type): string {
        return match ($type) {
            'card' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 9h20"/><rect x="6" y="13" width="5" height="3" rx="0.5"/><path d="M14.5 14h3.5"/></svg>',
            'mobile_money' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="2" width="10" height="20" rx="2"/><path d="M10 6h4"/><path d="M9 12h6"/><path d="M12 18h.01"/><path d="M20 8l2 2-2 2"/></svg>',
            'cash','cod' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="12" cy="12" r="3"/><path d="M7 9v0M17 15v0"/></svg>',
            'bank_transfer' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10V8l8-5 8 5v2"/><path d="M3 10h18"/><path d="M6 10v8M10 10v8M14 10v8M18 10v8"/><path d="M4 22h16"/></svg>',
            default => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/></svg>',
        };
    };


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

@endphp

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header + statut --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold tracking-tight">Commande</h1>
            <span class="rounded-full px-1 py-1 text-xs font-semibold {{ $s['bg'] }} {{ $s['text'] }}">
                    #{{ $order->reference }}
                    {{-- — {{ $s['label'] }} --}}
            </span>
            </div>
        </div>

        @if(isset($payment))
            <div class="mb-4 rounded-2xl border bg-gradient-to-br from-amber-50 to-white p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 22s8-4 8-10V6l-8-4-8 4v6c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span class="font-semibold">Paiement en cours de vérification</span>
                        <svg class="h-5 w-5 text-amber-600 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                    <div class="rounded-xl border bg-white/70 p-3">
                    <div class="text-gray-500">Référence</div>
                        <div class="font-medium flex items-center gap-2">
                            {{ $payment->reference ?? '—' }}
                            @if(!empty($payment->reference))
                            <button type="button" class="text-amber-700 text-xs hover:underline"
                                    onclick="navigator.clipboard.writeText('{{ $payment->reference }}')">Copier</button>
                            @endif
                        </div>
                    </div>
                    <div class="rounded-xl border bg-white/70 p-3">
                        <div class="text-gray-500">Méthode de paiement</div>
                        <div class="font-medium">{{ $payment->method->name ?? '—' }}</div>
                    </div>
                    <div class="rounded-xl border bg-white/70 p-3">
                        <div class="text-gray-500">Montant</div>
                        <div class="font-bold">{{ number_format($payment->amount,0,',',' ') }} {{ $currency }}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Colonne méthodes --}}
                <section class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border bg-white p-3">
                    <h2 class="text-lg font-semibold mb-4">Choisissez votre méthode</h2>

                    @if($methods->isEmpty())
                        <div class="rounded-2xl border border-dashed p-6 text-center text-gray-600">
                            Aucun moyen de paiement disponible pour le moment.
                        </div>
                    @else

                    <form id="paymentForm" method="POST" action="{{ route('shop.payment.store', $order) }}" enctype="multipart/form-data">
                        @csrf
                        {{-- Cartes méthodes --}}
                        @php
                                $hasAmount = ($order->total ?? 0) > 0;
                            @endphp

                            <div class="grid sm:grid-cols-2 gap-4" role="radiogroup" aria-label="Méthodes de paiement">
                                @foreach($methods as $m)
                                    @php
                                        $type    = $m->type; // mobile_money, bank_transfer, cash, cod, card
                                        $id      = 'pm_'.$type.'_'.$m->id;
                                    @endphp

                                    <label for="{{ $id }}"
                                        class="group block cursor-pointer rounded-2xl border p-4 hover:shadow-sm transition
                                                has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                                        <div class="flex items-start gap-3">
                                            <input type="radio"
                                                name="payment_method_id"
                                                id="{{ $id }}"  value="{{ $m->id }}"  data-type="{{ $type }}"
                                                data-details='@json($detailsFor($m))'
                                                class="mt-1 h-4 w-4 text-emerald-600 accent-emerald-600" >
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2">
                                                    {!! $icon($type) !!}
                                                    <span class="font-semibold">{{ $m->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach

                                {{-- Paiement en ligne Moneroo --}}
                                <button type="submit" formnovalidate
                                        @if($hasAmount)
                                            formaction="{{ route('shop.orders.pay.moneroo', $order) }}"
                                        @endif
                                        class="flex items-center gap-2 rounded-2xl border p-4 font-semibold
                                            hover:shadow-sm transition
                                            {{ $hasAmount ? 'cursor-pointer hover:border-emerald-600 hover:bg-emerald-50' : 'opacity-50 cursor-not-allowed pointer-events-none' }}"
                                        @unless($hasAmount) disabled aria-disabled="true" @endunless>
                                    <i class="ri-bank-card-line text-lg"></i>
                                    <span class="font-semibold">PAYER MAINTENANT</span>
                                </button>
                            </div>
                            @if(!$hasAmount)
                                {{-- <p class="mt-1 text-xs text-gray-500">
                                    Le paiement en ligne n’est pas disponible pour un montant nul.
                                </p> --}}
                            @endif

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
                                        <div class="font-medium">{{ $order->reference }}</div>
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
                                    <div class="rounded-xl border p-3 bg-gray-50">
                                        <div class="text-gray-500">Réf. à indiquer</div>
                                        <div class="font-medium">{{ $order->reference }}</div>
                                    </div>
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
                                    <div class="rounded-xl border p-3 bg-gray-50">
                                    <div class="text-gray-500">Numéro de commande</div>
                                    <div class="font-medium">{{ $order->reference }}</div>
                                    </div>
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
                                    <div class="font-medium">{{ $order->reference }}</div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            {{-- Upload reçu (optionnel) --}}
                            {{-- <div class="rounded-2xl border p-4">
                                <label for="receipt" class="block text-sm font-medium mb-2">Reçu de paiement (optionnel)</label>
                                <input id="receipt" name="receipt" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full rounded-2xl border p-3 focus:ring-2 focus:ring-emerald-500">
                                @error('receipt')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            {{-- Référence transaction (optionnel) --}}
                            {{-- <div class="rounded-2xl border p-4">
                                <label for="transaction_number" class="block text-sm font-medium mb-2">N° de transaction (optionnel)</label>
                                <input id="transaction_number" name="transaction_number" type="text"
                                    class="w-full rounded-2xl border p-3 focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Ex: OM-123456...">
                            </div> --}}

                            {{-- Note (optionnel) --}}
                            {{-- <div class="rounded-2xl border p-4">
                                <label for="note" class="block text-sm font-medium mb-2">Note au service comptable (optionnel)</label>
                                <textarea id="note" name="note" rows="3"
                                        class="w-full rounded-2xl border p-3 focus:ring-2 focus:ring-emerald-500"
                                        placeholder="Précisions utiles…"></textarea>
                            </div> --}}
                        </div>

                        {{-- Bouton principal --}}
                        <div class="mt-6">
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-2 py-3 font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect><path d="M2 10h20"/>
                                </svg>
                                Confirmer le paiement
                            </button>
                        {{-- <p class="mt-2 text-xs text-gray-500">En continuant, vous acceptez nos conditions.</p> --}}
                        </div>
                    </form>


                    @endif
                </div>

                {{-- Aide / FAQ courte --}}
                <div class="rounded-3xl border bg-white p-5">
                    <h2 class="text-lg font-semibold mb-3"> <a href="{{ route('contact') }}">Besoin d’aide ?</a></h2>
                    <ul class="grid sm:grid-cols-3 gap-3 text-sm">
                    <li class="rounded-2xl border p-3">🔒 Paiement sécurisé</li>
                    <li class="rounded-2xl border p-3">📞 Support 7J/7</li>
                    <li class="rounded-2xl border p-3">↺ Remboursement si échec</li>
                    </ul>
                </div>
                </section>

                {{-- Récap commande --}}
                <aside class="lg:col-span-1">
                <div class="rounded-3xl border bg-white p-5 lg:sticky lg:top-6">
                    <h2 class="text-lg font-semibold mb-4">Récapitulatif</h2>

                    @php $subtotal = 0; @endphp
                    <ul class="divide-y">
                    @foreach($order->items ?? [] as $it)
                        @php
                        $subtotal += (float)$it->total_price;
                        $media = $it->product?->getFirstMedia('gallery');
                        $img   = $media ? asset('storage/'.$media->getPathRelativeToRoot()) : asset('assets/images/box.png');
                        @endphp
                        <li class="flex items-center gap-3 py-3">
                        <img src="{{ $img }}" alt="{{ $it->product?->name ?? 'Produit' }}"
                            class="h-14 w-14 rounded-xl object-cover" loading="lazy"
                            onerror="this.src='{{ asset('assets/images/box.png') }}'">
                        <div class="flex-1">
                            <div class="text-sm font-medium line-clamp-1">{{ $it->product?->name ?? 'Produit' }}</div>
                            @if($it->sku && $it->sku->attributes)
                            <div class="text-xs text-gray-600">
                                {{ collect($it->sku->attributes)->map(fn($v,$k)=>ucfirst($k).': '.$v)->implode(' • ') }}
                            </div>
                            @endif
                            <div class="text-xs text-gray-500">x{{ $it->qty }}</div>
                        </div>
                        <div class="text-sm font-semibold whitespace-nowrap">
                            {{ $fmt($it->total_price) }}
                        </div>
                        </li>
                    @endforeach
                    </ul>

                    <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">Sous-total</dt>
                        <dd class="font-semibold">{{ $fmt($subtotal) }}</dd>
                    </div>
                    {{-- <div class="flex items-center justify-between">
                        <dt class="text-gray-600">Livraison</dt>
                        <dd class="text-gray-500">{{ $fmt($order->shipping_total ?? 0) }}</dd>
                    </div> --}}
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">Taxes</dt>
                        <dd class="text-gray-500">{{ $fmt($order->tax_total ?? 0) }}</dd>
                    </div>
                    <hr class="my-2">
                    <div class="flex items-center justify-between text-base">
                        <dt class="font-semibold">Total</dt>
                        <dd class="font-extrabold">{{ $fmt($order->total ?? $subtotal) }}</dd>
                    </div>
                    </dl>

                    {{-- <a href="{{ route('shop.cart.index') }}" class="mt-3 block w-full text-center rounded-2xl border border-gray-300 px-3 py-3 font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition">
                    ← Modifier le panier
                    </a> --}}
                </div>
                </aside>
            </div>
        @endif
    </div>

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
        // if (radios.length && !Array.from(radios).some(r => r.checked)) {
        //     radios[0].checked = true;
        //     radios[0].dispatchEvent(new Event('change'));
        // }
        })();
    </script>

@endsection
