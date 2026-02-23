@extends('frontend.layouts.master')
@section('title','Panier')

@section('content')
@php
    $items    = $cart->items;
    $subtotal = $items->sum('total_price');
    $count    = $items->sum('qty');
@endphp

<div class="min-h-[60vh] bg-slate-50 text-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 lg:py-8">

        {{-- HEADER PANIER --}}
        <header class="mb-6">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-700">
                        Panier
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                        Votre sélection d’articles
                    </h1>
                    <p class="mt-1 text-[12px] text-slate-600">
                        Récapitulatif de vos produits.
                    </p>
                </div>

                {{-- Étapes (indicatif) --}}
                <ol class="flex items-center gap-2 text-[11px] text-slate-600">
                    <li class="flex items-center gap-1">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-[11px] font-semibold text-white">
                            1
                        </span>
                        <span class="font-semibold text-slate-900">Panier</span>
                    </li>
                    <span class="h-px w-6 bg-slate-300"></span>
                    <li class="flex items-center gap-1">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-[11px] font-semibold text-slate-600">
                            2
                        </span>
                        <span>Coordonnées</span>
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

        {{-- PANIER VIDE --}}
        @if($items->isEmpty())
            <section
                class="rounded-3xl border border-dashed border-slate-200 bg-white/90 shadow-sm px-6 py-10 text-center">
                <div
                    class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <i class="ri-shopping-bag-3-line text-xl"></i>
                </div>
                <h2 class="text-lg font-semibold text-slate-900">Votre panier est vide</h2>

                <a href="{{ route('shop.products.index') }}"
                   class="inline-flex items-center justify-center gap-2 mt-5 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-500 px-5 py-2.5 text-[13px] font-semibold text-white shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                    <i class="ri-store-2-line text-sm"></i>
                    Continuer mes achats
                </a>
            </section>
        @else
            {{-- PANIER AVEC ARTICLES --}}
            <section
                class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.6fr)_minmax(0,1.05fr)] gap-6 lg:gap-7 items-start">

                {{-- LISTE ARTICLES --}}
                <div class="space-y-4">
                    @foreach($items as $item)
                        @php
                            $media = $item->product->getFirstMedia('gallery');
                            $img   = $media ? asset('storage/'.$media->getPathRelativeToRoot()) : asset('assets/images/box.png');
                            $attrs = $item->sku && $item->sku->attributes
                                ? collect($item->sku->attributes)->map(fn($v,$k)=>ucfirst($k).': '.$v)->implode(' • ')
                                : null;
                        @endphp

                        <article
                            class="rounded-2xl border border-slate-100 bg-white shadow-sm hover:shadow-md hover:-translate-y-[1px] transition transform">
                            <div class="grid grid-cols-12 gap-4 p-4 sm:p-4.5 items-center">
                                {{-- IMAGE --}}
                                <div class="col-span-4 sm:col-span-3">
                                    <a href="{{ route('shop.products.show', $item->product->slug) }}"
                                       class="block group">
                                        <div class="relative h-24 sm:h-24 rounded-2xl overflow-hidden bg-slate-100">
                                            <img
                                                src="{{ $img }}"
                                                alt="{{ $item->product->name }}"
                                                class="h-full w-full object-cover group-hover:scale-[1.04] transition-transform"
                                                loading="lazy"
                                                onerror="this.src='{{ asset('assets/images/box.png') }}'">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/15 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                                        </div>
                                    </a>
                                </div>

                                {{-- INFOS + ACTIONS --}}
                                <div class="col-span-8 sm:col-span-9">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <a href="{{ route('shop.products.show', $item->product->slug) }}"
                                               class="text-[13px] font-semibold text-slate-900 hover:underline line-clamp-2">
                                                {{ $item->product->name }}
                                            </a>

                                            @if($attrs)
                                                <div class="mt-1 text-[11px] text-slate-500">
                                                    {{ $attrs }}
                                                </div>
                                            @endif

                                            <div class="mt-1 flex flex-wrap items-center gap-2 text-[11px] text-slate-500">
                                                <span class="inline-flex items-center gap-1">
                                                    <i class="ri-price-tag-3-line text-xs text-emerald-600"></i>
                                                    <span>Prix unitaire :
                                                        <span class="font-semibold text-slate-800">
                                                            {{ number_format($item->unit_price, 0, ',', ' ') }} {{ $currency }}
                                                        </span>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>

                                        {{-- SUPPRIMER --}}
                                        <form method="POST" action="{{ route('shop.cart.items.remove', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 transition"
                                                aria-label="Supprimer l’article">
                                                <i class="ri-delete-bin-6-line text-[15px]"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- bas de carte : QTE + TOTAL --}}
                                    <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3 items-center">
                                        {{-- QUANTITÉ --}}
                                        <div>
                                            <div class="text-[11px] text-slate-500 mb-1">Quantité</div>
                                            <form method="POST" action="{{ route('shop.cart.items.update', $item) }}"
                                                  class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <div
                                                    class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-1.5 py-0.5">
                                                    <button type="button"
                                                            class="h-7 w-7 flex items-center justify-center text-slate-500 hover:text-slate-900"
                                                            onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.dispatchEvent(new Event('change')); this.form.submit()">
                                                        <i class="ri-subtract-line text-xs"></i>
                                                    </button>
                                                    <input
                                                        name="qty"
                                                        type="number"
                                                        min="1"
                                                        value="{{ $item->qty }}"
                                                        class="w-9 text-center bg-transparent text-[12px] text-slate-800 focus:outline-none"
                                                        inputmode="numeric"
                                                        onchange="if(this.value < 1){ this.value = 1; }">
                                                    <button type="button"
                                                            class="h-7 w-7 flex items-center justify-center text-slate-500 hover:text-slate-900"
                                                            onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.dispatchEvent(new Event('change')); this.form.submit()">
                                                        <i class="ri-add-line text-xs"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- PRIX UNIT. (mobile) --}}
                                        <div class="sm:hidden">
                                            <div class="text-[11px] text-slate-500 mb-1">Prix unitaire</div>
                                            <div class="text-[13px] font-semibold text-slate-900">
                                                {{ number_format($item->unit_price, 0, ',', ' ') }} {{ $currency }}
                                            </div>
                                        </div>

                                        {{-- TOTAL LIGNE --}}
                                        <div class="text-right sm:text-right">
                                            <div class="text-[11px] text-slate-500 mb-1">Total</div>
                                            <div class="text-[15px] sm:text-[17px] font-extrabold text-emerald-700">
                                                {{ number_format($item->total_price, 0, ',', ' ') }} {{ $currency }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    {{-- CTA CONTINUER --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-[12px]">
                        {{-- <div class="flex items-center gap-2 text-slate-600">
                            <i class="ri-information-line text-[16px] text-emerald-600"></i>
                            <span>
                                Les frais et options de livraison seront précisés lors de l’étape suivante.
                            </span>
                        </div> --}}
                        <a href="{{ route('shop.products.index') }}"
                           class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-[11px] font-medium text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition">
                            ← Continuer mes achats
                        </a>
                    </div>
                </div>

                {{-- RÉCAP / TOTAL --}}
                <aside class="lg:sticky lg:top-20">
                    <div class="rounded-3xl border border-slate-100 bg-white shadow-soft px-4 py-4 sm:px-5 sm:py-5">
                        <h2 class="text-[15px] font-semibold text-slate-900">Récapitulatif</h2>
                        <p class="mt-1 text-[11px] text-slate-500">
                            {{ $count }} article{{ $count>1 ? 's' : '' }} dans votre panier.
                        </p>

                        <dl class="mt-4 space-y-2 text-[13px]">
                            <div class="flex items-center justify-between">
                                <dt class="text-slate-600">Sous-total</dt>
                                <dd class="font-semibold text-slate-900">
                                    {{ number_format($subtotal, 0, ',', ' ') }} {{ $currency }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-slate-600">Livraison</dt>
                                <dd class="text-slate-500 text-[12px]">
                                    Veuillez contacter le vendeur
                                </dd>
                            </div>
                            {{-- Taxes si besoin plus tard --}}
                            <div class="mt-2 border-t border-dashed border-slate-200 pt-2 flex items-center justify-between text-[14px]">
                                <dt class="font-semibold text-slate-900">Total estimé</dt>
                                <dd class="text-[17px] font-extrabold text-emerald-700">
                                    {{ number_format($subtotal, 0, ',', ' ') }} {{ $currency }}
                                </dd>
                            </div>
                        </dl>

                        <a href="{{ route('shop.checkout.index') }}"
                           class="mt-4 block w-full text-center rounded-full bg-gradient-to-r from-emerald-600 to-emerald-500 px-5 py-3 text-[13px] font-semibold text-white shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                            Finaliser la commande
                        </a>

                        <p class="mt-3 text-[11px] text-slate-500 flex items-start gap-1.5">
                            <i class="ri-shield-check-line text-[14px] text-emerald-600 mt-[1px]"></i>
                            <span>
                                Paiements sécurisés.
                            </span>
                        </p>
                    </div>
                </aside>
            </section>
        @endif

        {{-- COMMANDES EN COURS (IMPAYÉES) --}}
        @if(($unpaidOrders ?? collect())->isNotEmpty())
            @php
                $statusMap = [
                    0 => ['label'=>'En attente','bg'=>'bg-amber-50','text'=>'text-amber-700'],
                    1 => ['label'=>'Vérification en cours','bg'=>'bg-indigo-50','text'=>'text-indigo-700'],
                ];
            @endphp

            <section class="mt-8">
                <div
                    class="rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-50/70 via-white to-emerald-50/30 p-5 sm:p-6 shadow-sm">
                    <div class="mb-4 flex items-center gap-2">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-600 text-white">
                            <i class="ri-file-list-3-line text-[18px]"></i>
                        </div>
                        <div>
                            <h3 class="text-[15px] font-semibold text-slate-900">Commandes en cours de paiement</h3>
                            <p class="text-[11px] text-slate-600">
                                Vous avez des commandes déjà créées mais dont le paiement n’est pas encore finalisé.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($unpaidOrders as $o)
                            @php
                                $st = $statusMap[$o->status] ?? ['label'=>'En attente','bg'=>'bg-slate-100','text'=>'text-slate-700'];
                            @endphp

                            <a href="{{ route('shop.payment.show', $o) }}"
                               class="group rounded-2xl border border-slate-100 bg-white p-4 hover:border-emerald-200 hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[13px] font-semibold truncate">
                                                {{ $o->reference }}
                                            </span>
                                            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $st['bg'] }} {{ $st['text'] }}">
                                                {{ $st['label'] }}
                                            </span>
                                        </div>
                                        <div class="mt-1 text-[11px] text-slate-500">
                                            Créée le {{ optional($o->created_at)->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[13px] font-bold text-slate-900">
                                            {{ number_format($o->total, 0, ',', ' ') }} {{ $currency }}
                                        </div>
                                        <div
                                            class="mt-1 inline-flex items-center gap-1 text-[11px] text-emerald-700 font-semibold">
                                            Vérifier & payer
                                            <i class="ri-arrow-right-line text-[13px] transition group-hover:translate-x-0.5"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>
</div>
@endsection
