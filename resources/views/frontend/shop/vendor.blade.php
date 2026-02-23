@extends('frontend.layouts.master')

@section('title', ' '.$account->name.' | MYLMARK')
@section('meta_title', ' '.$account->name.' | MYLMARK')
@section('meta_description', "Découvrez {$account->name} sur MYLMARK : sélection de produits, idées cadeaux et essentiels du quotidien.")
@section('meta_image', asset('assets/images/catalogue.png'))

@section('content')
@php
    use Illuminate\Support\Str;
    $city     = $account->city;
    $country  = $account->country;
    $location = trim(($city ? $city.' · ' : '').($country ?: ''));
    $email    = $account->email;
    $phone    = $account->phone;
    $whatsapp = $account->whatsapp;

    $waNumber = $whatsapp ? preg_replace('/\D+/', '', $whatsapp) : null;

    $waMessage = "Bonjour {$account->name},\n"
        ."Je découvre votre boutique sur MYLMARK et je souhaite en savoir plus sur vos produits.\n\n"
        ."Lien de votre boutique : ".url()->current()."\n\n"
        ."Merci !";

    $waLink = $waNumber
        ? 'https://wa.me/'.$waNumber.'?text='.urlencode($waMessage)
        : null;

    $productsCount = $products->total();
    $currencyLabel = $currency ?? 'FCFA';
@endphp

{{-- HEADER CLAIR & CENTRÉ --}}
{{-- <section class="bg-slate-50 border-b border-slate-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-6 pb-8">
        <div class="rounded-3xl bg-white shadow-soft border border-slate-100 px-4 py-5 sm:px-6 sm:py-6">
            <div class="flex flex-col items-center text-center gap-4 sm:flex-row sm:text-left sm:items-center sm:justify-between">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="h-14 w-14 sm:h-16 sm:w-16 rounded-full bg-gradient-to-br from-emerald-500 to-brand-green flex items-center justify-center text-lg sm:text-xl font-semibold text-white shadow-md">
                        {{ mb_strtoupper(mb_substr($account->name, 0, 1)) }}
                    </div>
                    <div>

                        <h1 class="text-[20px] sm:text-[22px] font-semibold text-slate-900 leading-snug">
                            {{ $account->name }}
                        </h1>
                        @if($location)
                            <p class="text-[12px] text-slate-500 flex items-center gap-1 justify-center sm:justify-start">
                                <i class="ri-map-pin-line text-[13px] text-brand-green"></i>
                                {{ $location }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center sm:justify-end gap-2">
                    @if($account->is_verified)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-[11px] text-emerald-700">
                            <i class="ri-shield-check-line text-[13px]"></i>
                            Compte vérifié
                        </span>
                    @endif

                    @if($productsCount > 0)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 border border-slate-200 px-3 py-1 text-[11px] text-slate-700">
                            <i class="ri-shopping-bag-3-line text-[13px]"></i>
                            {{ $productsCount }} produit{{ $productsCount > 1 ? 's' : '' }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[12px] text-slate-700 leading-relaxed max-w-xl">
                    @if(trim((string) $account->about))
                        {{ Str::limit($account->about, 220) }}
                    @else
                        Cette boutique propose une sélection de produits pour le quotidien, le style et les idées cadeaux, directement disponibles sur MYLMARK.
                    @endif
                </p>

                <div class="flex flex-wrap items-center justify-start sm:justify-end gap-2">
                    @if($email)
                        <a href="mailto:{{ $email }}"
                           class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-[11px] text-slate-800 hover:border-brand-green hover:text-brand-green transition">
                            <i class="ri-mail-line text-xs"></i>
                            Email
                        </a>
                    @endif

                    @if($phone)
                        <a href="tel:{{ $phone }}"
                           class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-[11px] text-slate-800 hover:border-brand-green hover:text-brand-green transition">
                            <i class="ri-phone-line text-xs"></i>
                            Appeler
                        </a>
                    @endif

                    @if($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-3.5 py-1.5 text-[11px] text-white font-semibold hover:bg-emerald-400 transition">
                            <i class="ri-whatsapp-line text-xs"></i>
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section> --}}


<section class="relative overflow-hidden bg-white border-b border-slate-100">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -left-10 h-44 w-44 rounded-full bg-emerald-500/10 blur-2xl"></div>
        <div class="absolute -bottom-24 right-0 h-52 w-52 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-50 via-slate-50/70 to-transparent"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-7 pb-9">
        <div class="grid gap-6 md:grid-cols-[minmax(0,1.4fr)_minmax(0,1.1fr)] items-center">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="h-14 w-14 sm:h-16 sm:w-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-brand-green flex items-center justify-center text-lg sm:text-xl font-semibold text-white shadow-md">
                        {{ mb_strtoupper(mb_substr($account->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-[22px] sm:text-[24px] uppercase font-extrabold text-slate-900 leading-snug">
                            {{ $account->name }}
                        </h1>
                        @if($location)
                            <p class="mt-1 text-[12px] text-slate-500 flex items-center gap-1">
                                <i class="ri-map-pin-line text-[13px] text-brand-green"></i>
                                {{ $location }}
                            </p>
                        @endif
                    </div>
                </div>

                <p class="text-[12px] text-slate-700 leading-relaxed max-w-xl">
                    @if(trim((string) $account->about))
                        {{ Str::limit($account->about, 1000) }}
                    @else
                        Boutique présente sur MYLMARK avec une sélection de produits pour le quotidien, le style et les idées cadeaux.
                    @endif
                </p>

                <div class="flex flex-wrap items-center gap-2">
                    @if($account->is_verified)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-[11px] text-emerald-700">
                            <i class="ri-shield-check-line text-[13px]"></i>
                            Compte vérifié
                        </span>
                    @endif
                    @if($productsCount > 0)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 border border-slate-200 px-3 py-1 text-[11px] text-slate-700">
                            <i class="ri-shopping-bag-3-line text-[13px]"></i>
                            {{ $productsCount }} produit{{ $productsCount > 1 ? 's' : '' }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- carte contact / stats --}}

            <div class="w-full">
                <div class="rounded-2xl bg-slate-900 text-slate-50 shadow-soft px-4 py-4 sm:px-5 sm:py-5">
                    {{-- Titre + petit texte --}}
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.18em] text-emerald-200">
                                Contacter {{ $account->name }}
                            </p>
                            <p class="text-[11px] text-slate-300/90">
                                Échange direct pour toute question.
                            </p>
                        </div>
                        <div class="hidden sm:flex h-7 w-7 items-center justify-center rounded-xl bg-emerald-500/15">
                            <i class="ri-chat-3-line text-[15px] text-emerald-300"></i>
                        </div>
                    </div>

                    {{-- Boutons de contact --}}
                    <div class="flex flex-wrap gap-2">
                        @if($email)
                            <a href="mailto:{{ $email }}"
                            class="inline-flex items-center gap-1.5 rounded-full bg-slate-800/90 px-3.5 py-1.5 text-[11px] hover:bg-slate-700 transition">
                                <i class="ri-mail-line text-xs text-emerald-300"></i>
                                <span>Email</span>
                            </a>
                        @endif

                        @if($phone)
                            <a href="tel:{{ $phone }}"
                            class="inline-flex items-center gap-1.5 rounded-full bg-slate-800/90 px-3.5 py-1.5 text-[11px] hover:bg-slate-700 transition">
                                <i class="ri-phone-line text-xs text-emerald-300"></i>
                                <span>Appeler</span>
                            </a>
                        @endif

                        @if($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-3.5 py-1.5 text-[11px] font-semibold text-slate-950 hover:bg-emerald-400 transition">
                                <i class="ri-whatsapp-line text-xs"></i>
                                <span>WhatsApp</span>
                            </a>
                        @endif

                        <a class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-3.5 py-1.5 text-[11px] font-semibold text-slate-950 hover:bg-emerald-400 transition ">
                            <p class="flex items-center gap-1">
                                <i class="ri-calendar-line text-xs "></i>
                                <span class="text-white">
                                    Depuis
                                    {{ optional($account->created_at)->format('Y') ?? '—' }}
                                </span>
                            </p>
                        </a>
                    </div>

                    {{-- Stats rapides --}}
                    {{-- <div class="grid grid-cols-2 gap-2 text-[11px]">
                        <div class="rounded-xl border border-slate-800 bg-slate-900/80 px-2.5 py-2">
                            <p class="text-slate-400 flex items-center gap-1">
                                <i class="ri-shopping-bag-3-line text-[12px] text-emerald-300"></i>
                                <span>Produits en ligne</span>
                            </p>
                            <p class="mt-0.5 text-[13px] font-semibold">
                                {{ $productsCount }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-800 bg-slate-900/80 px-2.5 py-2">
                            <p class="text-slate-400 flex items-center gap-1">
                                <i class="ri-calendar-line text-[12px] text-emerald-300"></i>
                                <span>Sur MYLMARK depuis</span>
                            </p>
                            <p class="mt-0.5 text-[13px] font-semibold">
                                {{ optional($account->created_at)->format('Y') ?? '—' }}
                            </p>
                        </div>
                    </div> --}}

                    {{-- Petit disclaimer --}}
                    {{-- <p class="mt-3 text-[10px] text-slate-500 leading-snug">
                        Les échanges et ventes se font directement entre vous et la boutique.
                        MYLMARK peut intervenir en cas de problème signalé sur une commande.
                    </p> --}}
                </div>
            </div>
        </div>
    </div>
</section>


{{-- SECTION CONTENU --}}
<section class="bg-slate-50 py-6 sm:py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-5">
        {{-- <div class="rounded-2xl bg-slate-900 text-slate-50 px-4 py-3 sm:px-5 sm:py-3.5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <div class="h-7 w-7 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                    <i class="ri-hand-heart-line text-[16px] text-emerald-300"></i>
                </div>
                <p class="text-[11px] sm:text-[12px]">
                    Les commandes se font directement avec la boutique. MYLMARK reste disponible en cas de problème avec une commande.
                </p>
            </div>
            @if($productsCount > 0)
                <p class="text-[11px] text-emerald-100">
                    {{ $productsCount }} produit{{ $productsCount > 1 ? 's' : '' }} en ligne dans cette boutique.
                </p>
            @endif
        </div> --}}

        {{-- Grille produits --}}
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h2 class="text-[13px] font-semibold text-slate-900">
                        Nos Articles
                    </h2>
                    @if($productsCount > 0)
                        <p class="text-[11px] text-slate-500">
                            Parcours les articles proposés par {{ $account->name }}.
                        </p>
                    @else
                        <p class="text-[11px] text-slate-500">
                            La boutique n’a pas encore publié de produits.
                        </p>
                    @endif
                </div>
                {{-- Petit placeholder tri (UI seulement) --}}
                @if($productsCount > 0)
                    <div class="hidden sm:flex items-center gap-2 text-[11px]">
                        <span class="text-slate-400">Trier</span>
                        <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:border-slate-400">
                            Nouveautés
                        </button>
                    </div>
                @endif
            </div>

            @if($products->count())
                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                    @foreach($products as $p)
                        @php

                            $cover   = $p->getFirstMedia('cover');
                            $gallery = $p->getFirstMedia('gallery');

                            if ($cover) {
                                // Image principale (upload via le champ "image")
                                $img = $cover->getUrl();
                            } elseif ($gallery) {
                                // Fallback : première image de la galerie
                                $img = $gallery->getUrl();
                            } elseif ($p->image) {
                                $img = asset('storage/'.$p->image);
                            } else {
                                $img = asset('assets/images/products.png');
                            }
                            [$min,$max] = $p->priceRange();
                        @endphp

                        <article class="group rounded-2xl bg-white border border-slate-100 shadow-sm overflow-hidden hover:shadow-card hover:-translate-y-0.5 transition">
                            <a href="{{ route('shop.products.show', $p) }}" class="block">
                                <div class="aspect-[4/3] bg-slate-100 overflow-hidden">
                                    <img src="{{ $img }}" alt="{{ $p->name }}"
                                         class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-300">
                                </div>
                                <div class="p-3.5 space-y-1.5">
                                    <h3 class="text-[12px] font-semibold text-slate-900 line-clamp-2">
                                        {{ $p->name }}
                                    </h3>
                                    <p class="text-[11px] text-slate-500">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($p->description), 100) }}
                                    </p>
                                    <p class="text-[12px] font-semibold text-slate-900">
                                        @if($p->type === 'variable')
                                            @if(is_null($min))
                                                —
                                            @elseif($min == $max)
                                                {{ number_format($min, 0, '.', ' ') }} {{ $currencyLabel }}
                                            @else
                                                {{ number_format($min, 0, '.', ' ') }}–{{ number_format($max, 0, '.', ' ') }} {{ $currencyLabel }}
                                            @endif
                                        @else
                                            {{ number_format($min, 0, '.', ' ') }} {{ $currencyLabel }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="rounded-2xl bg-white border border-dashed border-slate-200 p-6 text-center text-[12px] text-slate-500">
                    Cette boutique n’a pas encore publié d'articles.
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
