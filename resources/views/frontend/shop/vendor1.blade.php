@extends('frontend.layouts.master')
@section('title', 'Boutique '.$account->name.' | MYLMARK')
@section('meta_title', 'Boutique '.$account->name.' | MYLMARK')
@section('meta_description', "Découvrez les produits de {$account->name} sur MYLMARK : pièces uniques, séries limitées et objets du quotidien revisités.")
@section('meta_image', asset('assets/images/products.png'))

@section('content')

@php
    $city     = $account->city;
    $country  = $account->country;
    $location = trim(($city ? $city.' · ' : '').($country ?: ''));
    $email    = $account->email;
    $phone    = $account->phone;
    $whatsapp = $account->whatsapp;

    $waNumber = $whatsapp ? preg_replace('/\D+/', '', $whatsapp) : null;

    $waMessage = "Bonjour {$account->name},\n"
        ."Je découvre votre boutique sur MYLMARK et je souhaite en savoir plus sur vos produits.\n\n"
        ."Voici le lien de votre boutique : ".url()->current()."\n\n"
        ."Merci !";

    $waLink = $waNumber
        ? 'https://wa.me/'.$waNumber.'?text='.urlencode($waMessage)
        : null;
@endphp

{{-- HERO BOUTIQUE --}}
<section class="bg-slate-950 text-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div class="flex items-start gap-4">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-brand-green flex items-center justify-center text-2xl">
                    <i class="ri-store-2-line"></i>
                </div>
                <div>
                    <p class="text-[11px] tracking-[0.22em] uppercase text-emerald-200/80 mb-1">
                        Boutique MYLMARK
                    </p>
                    <h1 class="text-[20px] sm:text-[24px] font-semibold text-white leading-snug">
                        {{ $account->name }}
                    </h1>

                    @if($location)
                        <p class="mt-1 text-[12px] text-slate-300 flex items-center gap-1.5">
                            <i class="ri-map-pin-line text-emerald-300 text-xs"></i>
                            {{ $location }}
                        </p>
                    @endif

                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        @if($account->is_verified)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/60 px-2.5 py-1 text-[10px] text-emerald-100">
                                <i class="ri-shield-check-line text-[11px]"></i>
                                Compte vérifié
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-800 border border-slate-600 px-2.5 py-1 text-[10px] text-slate-200/90">
                                <i class="ri-time-line text-[11px]"></i>
                                Boutique en cours de validation
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Boutons contact rapides --}}
            <div class="flex flex-wrap gap-2 justify-start md:justify-end">
                @if($email)
                    <a href="mailto:{{ $email }}"
                       class="inline-flex items-center gap-1.5 rounded-full border border-slate-700 bg-slate-900/40 px-3 py-1.5 text-[11px] text-slate-100 hover:border-emerald-400 hover:text-emerald-100 transition">
                        <i class="ri-mail-line text-xs"></i>
                        Email
                    </a>
                @endif

                @if($phone)
                    <a href="tel:{{ $phone }}"
                       class="inline-flex items-center gap-1.5 rounded-full border border-slate-700 bg-slate-900/40 px-3 py-1.5 text-[11px] text-slate-100 hover:border-emerald-400 hover:text-emerald-100 transition">
                        <i class="ri-phone-line text-xs"></i>
                        Appeler
                    </a>
                @endif

                @if($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500 text-[11px] text-slate-900 font-semibold px-3.5 py-1.5 hover:bg-emerald-400 transition">
                        <i class="ri-whatsapp-line text-xs"></i>
                        Contacter sur WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- CONTENU BOUTIQUE --}}
<section class="py-6 sm:py-8 bg-slate-50/60">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-6">

        {{-- À propos + coordonnées --}}
        <div class="grid gap-4 md:grid-cols-[minmax(0,2fr)_minmax(0,1.3fr)] items-start">
            {{-- À propos --}}
            <div class="rounded-2xl bg-white shadow-soft border border-slate-100/80 p-4">
                <h2 class="text-[13px] font-semibold text-slate-900 mb-2">
                    À propos de cette boutique
                </h2>
                <p class="text-[12px] leading-relaxed text-slate-700">
                    @if(trim((string) $account->about))
                        {{ $account->about }}
                    @else
                        <span class="text-slate-400">
                            Le vendeur n’a pas encore renseigné de description détaillée.
                        </span>
                    @endif
                </p>
            </div>

            {{-- Coordonnées --}}
            <div class="rounded-2xl bg-white shadow-soft border border-slate-100/80 p-4 text-[12px]">
                <h2 class="text-[13px] font-semibold text-slate-900 mb-2">
                    Coordonnées & infos
                </h2>
                <ul class="space-y-1.5 text-slate-600">
                    <li class="flex items-center gap-2">
                        <i class="ri-mail-line text-[13px] text-brand-green"></i>
                        @if($email)
                            <a href="mailto:{{ $email }}" class="hover:text-brand-green hover:underline break-all">
                                {{ $email }}
                            </a>
                        @else
                            <span class="text-slate-400">Email non renseigné</span>
                        @endif
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ri-phone-line text-[13px] text-brand-green"></i>
                        @if($phone)
                            <a href="tel:{{ $phone }}" class="hover:text-brand-green hover:underline">
                                {{ $phone }}
                            </a>
                        @else
                            <span class="text-slate-400">Téléphone non renseigné</span>
                        @endif
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ri-whatsapp-line text-[13px] text-emerald-500"></i>
                        @if($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener"
                               class="hover:text-emerald-600 hover:underline">
                                {{ $whatsapp }}
                            </a>
                        @else
                            <span class="text-slate-400">WhatsApp non renseigné</span>
                        @endif
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ri-map-pin-line text-[13px] text-brand-green"></i>
                        @if($location)
                            <span>{{ $location }}</span>
                        @else
                            <span class="text-slate-400">Localisation non renseignée</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        {{-- PRODUITS DE LA BOUTIQUE --}}
        <div class="mt-2">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-[13px] font-semibold text-slate-900">
                    Produits de cette boutique
                </h2>
                @if($products->total() > 0)
                    <p class="text-[11px] text-slate-500">
                        {{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} trouvé{{ $products->total() > 1 ? 's' : '' }}
                    </p>
                @endif
            </div>

            @if($products->count())
                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach($products as $p)
                        <article class="group rounded-2xl bg-white border border-slate-100/80 shadow-sm overflow-hidden hover:shadow-card hover:-translate-y-0.5 transition">
                            <a href="{{ route('shop.products.show', $p) }}" class="block">
                                {{-- image à adapter à ta logique --}}
                                @php
                                    // Exemple : si tu as un champ image
                                    $img = $p->image
                                        ? asset('storage/'.$p->image)
                                        : asset('assets/images/products.png');
                                @endphp
                                <div class="aspect-[4/3] bg-slate-100 overflow-hidden">
                                    <img src="{{ $img }}" alt="{{ $p->name }}"
                                         class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                                </div>
                                <div class="p-3 space-y-1.5">
                                    <h3 class="text-[12px] font-semibold text-slate-900 line-clamp-2">
                                        {{ $p->name }}
                                    </h3>
                                    <p class="text-[11px] text-slate-500">
                                        {{ $account->name }}
                                    </p>
                                    @php
                                        [$min,$max] = $p->priceRange();
                                    @endphp
                                    <p class="text-[12px] font-semibold text-slate-900">
                                        @if($p->type === 'variable')
                                            @if(is_null($min)) —
                                            @elseif($min == $max)
                                                {{ number_format($min, 0, '.', ' ') }} {{ $currency ?? 'FCFA' }}
                                            @else
                                                {{ number_format($min, 0, '.', ' ') }}–{{ number_format($max, 0, '.', ' ') }} {{ $currency ?? 'FCFA' }}
                                            @endif
                                        @else
                                            {{ number_format($min, 0, '.', ' ') }} {{ $currency ?? 'FCFA' }}
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
                    Cette boutique n’a pas encore publié de produits.
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
