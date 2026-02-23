@extends('frontend.layouts.master')
@section('title', $product->name)

@php
    use Illuminate\Support\Str;
    $media = $product->getFirstMedia('gallery');
    $main  = $product->image;
    $mainUrl = $main
        ? asset('storage/' . $main)
        : ($media
            ? asset('storage/' . $media->getPathRelativeToRoot())
            : asset('assets/images/products.png'));
            

    $metaTitle = $product->meta_title ?: $product->name;
    $metaDesc  = $product->meta_description ?: Str::limit(strip_tags($product->description ?? ''), 160);
    $metaUrl   = url()->current();
    $priceSeo  = isset($product->price) ? number_format($product->price, 2, '.', '') : null;
    $availability = (isset($product->in_stock) && $product->in_stock) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';

    // Logique produit
    $isVariable = $product->type === 'variable';
    $fmt        = fn($n) => number_format((float)$n, 0, ',', ' ') . ' ' . $currency;

    $inStock = $isVariable
        ? ($product->skus?->sum('stock') > 0)
        : ($product->stock > 0);

    $minSku   = $isVariable ? (float)$product->skus->min('price') : null;
    $maxSku   = $isVariable ? (float)$product->skus->max('price') : null;
    $base     = $isVariable ? $minSku : (float)$product->price;
    $oldBase  = $isVariable ? (float)$product->skus->min('old_price') : (float)($product->old_price ?? 0);
    $hasPromo = $oldBase && $oldBase > $base;
    $discount = $hasPromo && $oldBase > 0 ? round((1 - ($base / $oldBase)) * 100) : null;



    // Galerie : URLs des médias "gallery"
    $gallery = $product->getMedia('gallery')->map(function ($m) {
        return $m->getUrl(); // Spatie génère déjà l'URL publique
    });

    $cover = $product->getFirstMedia('cover');

    if ($cover) {
        $gallery->prepend($cover->getUrl());
    } elseif ($product->image) {
        $gallery->prepend(asset('storage/' . $product->image));
    }


    $metaDescription = $metaDesc;
    $cartCount = session('cart') ? collect(session('cart'))->sum('qty') : 0;
    $priceOf = fn($p) => optional($p->skus)->min('price') ?? $p->price ?? null;
@endphp

{{-- Basic SEO --}}
<meta name="description" content="{{ $metaDesc }}">
<link rel="canonical" href="{{ $metaUrl }}">
<meta name="robots" content="{{ isset($product->is_published) && $product->is_published ? 'index,follow' : 'noindex,nofollow' }}">

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:type" content="product">
<meta property="og:url" content="{{ $metaUrl }}">
<meta property="og:image" content="{{ $mainUrl }}">
<meta property="og:image:alt" content="{{ $product->name ?? '' }}">
@if($priceSeo)
    <meta property="product:price:amount" content="{{ $priceSeo }}">
    <meta property="product:price:currency" content="{{ $currency }}">
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">
<meta name="twitter:image" content="{{ $mainUrl }}">

@section('content')
    <div class="min-h-screen bg-slate-50 text-slate-900">
        {{-- BREADCRUMB --}}
        <section class="bg-white/80 border-b border-slate-200/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-2 text-[11px]">
                <div class="flex items-center gap-1 text-slate-500">
                    <a href="{{ route('home') }}" class="hover:text-slate-900">Accueil</a>
                    {{-- <span>/</span>
                    <a href="{{ route('shop.products.index') }}" class="hover:text-slate-900">Boutique</a> --}}
                    @if($product->category_id)
                        <span>/</span>
                        <a href="{{ route('shop.products.index', ['category' => $product->category?->slug]) }}" class="hover:text-slate-900">
                            {{ $product->category?->name }}
                        </a>
                    @endif
                    <span>/</span>
                    <span class="text-slate-700 font-medium truncate max-w-[160px] sm:max-w-xs">
                        {{ $product->name }}
                    </span>
                </div>
                <a href="{{ route('shop.products.index') }}"
                class="inline-flex items-center gap-1 text-slate-500 hover:text-slate-900">
                    <i class="ri-arrow-left-line text-xs"></i>
                    Retour aux produits
                </a>
            </div>
        </section>

        {{-- HERO PRODUIT --}}
        <section class="relative overflow-hidden" id="product">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_0%_0%,rgba(22,101,52,0.10),transparent_55%),radial-gradient(circle_at_100%_0%,rgba(249,115,22,0.10),transparent_55%)]"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 lg:py-8 relative">
                <div
                    class="grid lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.95fr)] gap-6 lg:gap-8 items-start bg-white/90 rounded-3xl shadow-soft border border-slate-100/80 p-4 sm:p-5 lg:p-6 reveal opacity-0 translate-y-6">

                    {{-- GAUCHE : GALERIE --}}


                    <div class="space-y-3">
                        <div class="relative rounded-3xl overflow-hidden bg-slate-900">
                            <img
                                id="mainImage"
                                src="{{ $mainUrl }}"
                                alt="{{ $product->name }}"
                                class="w-full h-72 sm:h-80 lg:h-[360px] object-cover cursor-zoom-in transition-transform duration-500 hover:scale-[1.03]"
                                loading="lazy" decoding="async"
                                onerror="this.src='{{ asset('assets/images/products.png') }}'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/10 pointer-events-none"></div>

                            <div class="absolute left-3 top-3 flex flex-wrap gap-1.5 text-[10px]">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-slate-900/90 px-2.5 py-1 font-semibold text-emerald-100">
                                    <i class="ri-home-6-line text-xs"></i>
                                    {{ $product->category?->name ?? 'Article' }}
                                </span>
                                @if($inStock)
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50/90 px-2.5 py-1 text-brand-green">
                                        <i class="ri-checkbox-circle-line text-xs"></i>
                                        En stock
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-rose-50/90 px-2.5 py-1 text-rose-700">
                                        <i class="ri-close-line text-xs"></i>
                                        Rupture
                                    </span>
                                @endif
                            </div>

                            @if($discount)
                                <div
                                    class="absolute right-3 top-3 rounded-full bg-emerald-600 text-white text-[11px] font-bold px-3 py-1 shadow">
                                    -{{ $discount }}%
                                </div>
                            @endif

                            {{-- <button
                                class="absolute right-3 bottom-3 inline-flex items-center gap-1 rounded-full bg-white/90 px-3 py-1.5 text-[10px] font-semibold text-slate-800 shadow-sm hover:bg-white"
                                onclick="window.open('{{ $mainUrl }}','_blank')">
                                <i class="ri-expand-line text-xs"></i>
                                Voir en grand
                            </button> --}}
                        </div>


                        {{-- Thumbnails --}}
                        @if($gallery instanceof \Illuminate\Support\Collection && $gallery->isNotEmpty())
                            @php $thumbs = $gallery->take(-6); @endphp

                            <div class="grid grid-cols-6 gap-2">
                                @foreach($thumbs as $index => $url)
                                    <button type="button"
                                            data-image="{{ $url }}"
                                            data-index="{{ $index }}"
                                            class="group relative rounded-xl overflow-hidden border-2 border-transparent hover:border-emerald-500 transition">
                                        <img
                                            src="{{ $url }}"
                                            alt=""
                                            class="w-full h-16 object-cover group-hover:scale-[1.05] transition-transform"
                                            loading="lazy"
                                            onerror="this.src='{{ asset('assets/images/products.png') }}'">
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        {{-- @if($product->video || $product->video_url)
                            <div class="mt-4">
                                <h3 class="text-sm font-semibold mb-2">Vidéo du produit</h3>
                                @if($product->video && Str::startsWith($product->video, 'http'))
                                    <div class="relative aspect-video rounded-xl overflow-hidden bg-black">
                                        <iframe src="{{ $product->video_url }}"
                                                class="absolute inset-0 w-full h-full"
                                                frameborder="0" allowfullscreen>
                                        </iframe>
                                    </div>
                                @elseif($product->video)
                                    <video src="{{ asset('storage/'.$product->video) }}"
                                        controls
                                        class="w-full rounded-xl">
                                    </video>
                                @endif
                            </div>
                        @endif --}}


                    </div>

                    {{-- DROITE : RÉSUMÉ / PANIER --}}
                    <aside class="space-y-3 lg:sticky lg:top-24">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                            <div class="space-y-1">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-brand-green">
                                    {{ $product->category?->name }}
                                </p>
                                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-snug">
                                    {{ $product->name }}
                                </h1>
                                <p class="text-[12px] text-slate-600">
                                    {{ Str::limit(strip_tags($product->description ?? ''), 140) }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2 sm:gap-3">
                                <a href="{{ route('shop.cart.index') }}"
                                class="relative inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full border border-slate-200 bg-white text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
                                aria-label="Voir le panier">
                                    <i class="ri-shopping-bag-3-line text-[18px]"></i>
                                    @if(($cartCount ?? 0) > 0)
                                        <span class="absolute -top-1 -right-1 flex items-center justify-center w-4 h-4 rounded-full bg-red-600 text-white text-[10px] font-semibold">
                                            {{ $cartCount }}
                                        </span>
                                    @endif
                                </a>

                                <span
                                    class="shrink-0 rounded-full px-3 py-1 text-[11px] sm:text-[12px] font-semibold {{ $inStock ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                    {{ $inStock ? 'En stock' : 'Rupture' }}
                                </span>
                            </div>
                        </div>

                        {{-- Prix --}}
                        <div class="mt-2 border-t border-slate-200 pt-3">
                            @if($isVariable)
                                <div id="priceBlock" class="flex flex-wrap items-baseline gap-1 sm:gap-2">
                                    <span id="livePrice" class="whitespace-nowrap leading-none text-2xl sm:text-3xl font-extrabold tracking-tight">
                                        {{ $fmt($minSku) }}
                                    </span>
                                    @if($maxSku && $maxSku > $minSku)
                                        <span class="whitespace-nowrap leading-none text-xs sm:text-sm text-slate-500">
                                            — {{ $fmt($maxSku) }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div id="priceBlock" class="flex flex-wrap items-center gap-1 sm:gap-3">
                                    @if($hasPromo)
                                        <span class="whitespace-nowrap leading-none text-xs sm:text-sm text-slate-500 line-through">
                                            {{ $fmt($oldBase) }}
                                        </span>
                                    @endif
                                    <span id="livePrice" class="whitespace-nowrap leading-none text-2xl sm:text-3xl font-extrabold tracking-tight">
                                        {{ $fmt($base) }}
                                    </span>
                                    @if($discount)
                                        <span class="self-start sm:self-auto rounded-full bg-emerald-50 text-emerald-700 text-[10px] sm:text-[11px] font-bold px-2 py-0.5">
                                            -{{ $discount }}%
                                        </span>
                                    @endif
                                </div>
                            @endif

                            {{-- <p class="mt-1 text-[11px] text-slate-500">
                                📦 Livraison estimée selon votre adresse.
                            </p> --}}
                        </div>

                        {{-- Badges --}}
                        <div class="flex flex-wrap items-center gap-2 text-[11px] text-slate-600">
                            <span class="rounded-full bg-slate-100 px-2.5 py-1">⭐ Note</span>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1">Paiement sécurisé</span>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1">Support client</span>
                        </div>

                        {{-- FORM PANIER --}}
                        <form method="POST" action="{{ route('shop.cart.add') }}" class="mt-5 space-y-5" novalidate>
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            {{-- VARIANTES --}}
                            @if($isVariable && $product->skus->count())
                                @php
                                    $skus = $product->skus->values();
                                    $hasColor = $skus->contains(fn($s) => isset($s->attributes['color']));
                                @endphp

                                <div>
                                    <label class="block text-sm font-medium mb-2" for="product_sku_id">Variante</label>

                                    {{-- Pills --}}
                                    <div class="flex flex-wrap gap-2 mb-2" role="group" aria-label="Choix de la variante">
                                        @foreach($skus as $sku)
                                            @php
                                                $attrs = collect($sku->attributes ?? [])->map(fn($v,$k)=>ucfirst($k).': '.$v)->implode(' • ');
                                                $pill  = $attrs ?: $sku->sku;
                                                $cid   = 'sku-pill-'.$sku->id;
                                            @endphp

                                            <input type="radio" name="sku_pill" id="{{ $cid }}" class="peer hidden"
                                                value="{{ $sku->id }}"
                                                data-price="{{ (float)$sku->price }}"
                                                data-old="{{ (float)($sku->old_price ?? 0) }}"
                                                data-stock="{{ (int)$sku->stock }}"
                                                data-currency="{{ $currency }}">
                                            <label for="{{ $cid }}"
                                                class="peer-checked:border-emerald-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-700
                                                        cursor-pointer rounded-2xl border border-slate-200 px-3 py-2 text-[12px] flex items-center gap-2">
                                                @if($hasColor && ($sku->attributes['color'] ?? false))
                                                    <span class="h-3 w-3 rounded-full"
                                                        style="background: {{ $sku->attributes['color'] }}"></span>
                                                @endif
                                                <span>{{ $pill }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    {{-- Select fallback --}}
                                    <select id="product_sku_id" name="product_sku_id"
                                            class="w-full rounded-2xl border border-slate-200 p-3 text-sm focus:ring-2 focus:ring-emerald-500"
                                            aria-describedby="skuStockHint" @disabled(!$inStock)>
                                        @foreach($skus as $sku)
                                            @php $attrs = collect($sku->attributes ?? [])->map(fn($v,$k)=>ucfirst($k).': '.$v)->implode(' • '); @endphp
                                            <option value="{{ $sku->id }}"
                                                    data-price="{{ (float)$sku->price }}"
                                                    data-old="{{ (float)($sku->old_price ?? 0) }}"
                                                    data-stock="{{ (int)$sku->stock }}"
                                                    data-currency="{{ $currency }}">
                                                {{ $attrs ?: $sku->sku }} — {{ $fmt($sku->price) }}
                                                @if($sku->old_price && $sku->old_price > $sku->price)
                                                    ({{ $fmt($sku->old_price) }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <p id="skuStockHint" class="mt-1 text-xs text-slate-600" aria-live="polite"></p>
                                </div>
                            @endif

                            {{-- QUANTITÉ + CTA --}}
                            <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                                <div>
                                    <label for="qty" class="block text-sm font-medium mb-2">Quantité</label>
                                    <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2 py-1">
                                        <button type="button"
                                                class="h-7 w-7 flex items-center justify-center text-slate-500 hover:text-slate-900"
                                                aria-label="Diminuer" onclick="qtyStep(-1)">
                                            <i class="ri-subtract-line text-xs"></i>
                                        </button>
                                        <input id="qty" name="qty" type="number" min="1" value="1"
                                            class="w-10 text-center bg-transparent text-[12px] text-slate-800 focus:outline-none"
                                            {{ $inStock ? '' : 'disabled' }} inputmode="numeric">
                                        <button type="button"
                                                class="h-7 w-7 flex items-center justify-center text-slate-500 hover:text-slate-900"
                                                aria-label="Augmenter" onclick="qtyStep(1)">
                                            <i class="ri-add-line text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex-1 flex flex-col sm:flex-row gap-2">
                                    <button type="submit" id="addToCartBtn"
                                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-500 px-3 py-2 text-xs font-semibold text-slate-50 shadow-md hover:shadow-lg hover:scale-[1.02] transition disabled:opacity-60"
                                            {{ $inStock ? '' : 'disabled' }}>
                                        <i class="ri-shopping-bag-3-line text-sm"></i>
                                        Ajouter
                                    </button>

                                    <button type="submit" name="buy_now" value="1" id="buyNowBtn"
                                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-3 py-2 text-xs font-semibold text-slate-50 shadow-sm hover:bg-slate-800 transition disabled:opacity-60"
                                            {{ $inStock ? '' : 'disabled' }}>
                                        Acheter maintenant
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Trust cards --}}
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3 text-[11px]">
                            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 text-lg">🔒</span>
                                <span class="font-medium text-slate-700">Paiement sécurisé</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-lg">↺</span>
                                <span class="font-medium text-slate-700">Retour sous conditions</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-orange-50 text-orange-600 text-lg">🚚</span>
                                <span class="font-medium text-slate-700">Livraison & retrait</span>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        {{-- TABS : DESCRIPTION / DÉTAILS / LIVRAISON --}}
        <section class="scroll-mt-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-7 lg:pb-9">
                {{-- Tabs --}}
                <div
                    class="flex flex-wrap items-center gap-2 rounded-2xl bg-white shadow-card border border-slate-100/80 px-3.5 py-2.5 text-[11px] reveal opacity-0 translate-y-6">
                    <button
                        class="tab-btn inline-flex items-center gap-1 rounded-full bg-slate-900 text-slate-50 px-3.5 py-1.5 font-semibold"
                        data-tab="description">
                        <i class="ri-file-text-line text-xs"></i>
                        Description
                    </button>
                    <button
                        class="tab-btn inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-700 px-3.5 py-1.5"
                        data-tab="details">
                        <i class="ri-list-check-2 text-xs"></i>
                        Détails & caractéristiques
                    </button>
                    <button
                        class="tab-btn inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-700 px-3.5 py-1.5"
                        data-tab="shop">
                        <i class="ri-user-3-line text-xs"></i>
                        À propos du vendeur
                    </button>
                    <button
                        class="tab-btn inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-700 px-3.5 py-1.5"
                        data-tab="shipping">
                        <i class="ri-truck-line text-xs"></i>
                        Livraison & retours
                    </button>

                </div>

                <div class="mt-4 grid gap-4 lg:grid-cols-[minmax(0,1.5fr)_minmax(0,1.1fr)] items-start text-[12px]">
                    {{-- Contenu principal --}}
                    <div
                        id="tab-description"
                        class="tab-content rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 space-y-3">
                        <h2 class="text-[13px] font-semibold text-slate-900">
                            Description du produit
                        </h2>
                        <div class="prose prose-sm max-w-none text-slate-700">
                            {!! $product->description ?: '<p class="text-slate-500">Aucune description fournie.</p>' !!}
                        </div>

                        {{-- VIDEO --}}
                        @if($product->video || $product->video_url)
                            <div class="mb-4">
                                {{-- <h3 class="text-sm font-semibold mb-2">Vidéo de présentation</h3> --}}
                                @if($product->video && Str::startsWith($product->video, 'http'))
                                    <div class="relative aspect-video rounded-xl overflow-hidden bg-black">
                                        <iframe src="{{ $product->video_url }}"
                                                class="absolute inset-0 w-full h-full"
                                                frameborder="0" allowfullscreen>
                                        </iframe>
                                    </div>
                                @elseif($product->video)
                                    <video src="{{ asset('storage/'.$product->video) }}"
                                        controls
                                        class="w-full rounded-xl">
                                    </video>
                                @endif
                            </div>
                        @endif

                        {{-- <div class="prose prose-sm max-w-none text-slate-700">
                            {!! $product->description !!}
                        </div> --}}


                    </div>

                    <div
                        id="tab-details"
                        class="tab-content hidden rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 space-y-3">
                        <h2 class="text-[13px] font-semibold text-slate-900">
                            Détails & caractéristiques
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            @if($product->sku)
                                <div class="rounded-xl border border-slate-200 p-2">
                                    <div class="text-[11px] text-slate-500">Référence</div>
                                    <div class="mt-1 font-medium text-slate-800">{{ $product->sku }}</div>
                                </div>
                            @endif
                            <div class="rounded-xl border border-slate-200 p-2">
                                <div class="text-[11px] text-slate-500">Catégorie</div>
                                <div class="mt-1 font-medium text-slate-800">{{ $product->category?->name ?? '—' }}</div>
                            </div>
                            @if($product->weight)
                                <div class="rounded-xl border border-slate-200 p-2">
                                    <div class="text-[11px] text-slate-500">Poids</div>
                                    <div class="mt-1 font-medium text-slate-800">
                                        {{ $product->weight }} {{ $product->unit }}
                                    </div>
                                </div>
                            @endif
                            <div class="rounded-xl border border-slate-200 p-2">
                                <div class="text-[11px] text-slate-500">Disponibilité</div>
                                <div class="mt-1 font-medium {{ $inStock ? 'text-emerald-700' : 'text-rose-700' }}">
                                    {{ $inStock ? 'En stock' : 'Rupture de stock' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-shipping"  class="tab-content hidden rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 space-y-3">
                        <h2 class="text-[13px] font-semibold text-slate-900">
                            Livraison & retours
                        </h2>
                        {{-- <p class="text-slate-600 text-[12px]">
                            Les délais et tarifs exacts de livraison seront affichés au moment de la commande.
                        </p> --}}
                        <ul class="space-y-1.5 text-slate-600 text-[12px]">
                            <li class="flex gap-2">
                                <i class="ri-information-line mt-[3px] text-emerald-600"></i>
                                <span>Livraison disponible selon les zones desservies par la boutique.</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="ri-information-line mt-[3px] text-emerald-600"></i>
                                <span>Retours possibles sous conditions, en cas de produit non conforme ou défectueux.</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="ri-information-line mt-[3px] text-emerald-600"></i>
                                <span>Pour toute question, contactez le support via la page de contact.</span>
                            </li>
                        </ul>
                    </div>


                    <div id="tab-shop"
                        class="tab-content hidden rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5 text-[11px]">

                        {{-- En-tête boutique --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-9 w-9 rounded-full bg-gradient-to-br from-emerald-600 to-brand-green text-white flex items-center justify-center text-lg">
                                    <i class="ri-store-2-line"></i>
                                </div>
                                <div>
                                    <p class="text-[15px] font-extrabold uppercase text-slate-900">
                                        <a href="{{ route('shop.vendors.show', $product->account) }}">
                                            {{ $product->account?->name ?? 'Boutique' }}
                                        </a>

                                    </p>

                                    @php
                                        $city    = $product->account?->city;
                                        $country = $product->account?->country;
                                    @endphp

                                    @if($city || $country)
                                        <p class="text-slate-500 flex items-center gap-1 mt-0.5">
                                            <i class="ri-map-pin-line text-brand-green text-xs"></i>
                                            {{ $city ?: '' }}@if($city && $country), @endif{{ $country ?: '' }}
                                        </p>
                                    @else
                                        <p class="text-slate-400 flex items-center gap-1 mt-0.5">
                                            <i class="ri-map-pin-line text-slate-300 text-xs"></i>
                                            Localisation non renseignée
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- <div class="text-right">
                                <div class="flex items-center justify-end gap-1 text-amber-400 text-xs">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-half-fill"></i>
                                </div>
                                <p class="text-[10px] text-slate-500">
                                    4,8 / 5 · {{ $product->account?->city ? 'Avis clients' : 'Note indicative' }}
                                </p>
                            </div> --}}
                        </div>

                        {{-- Badges / statut --}}
                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            @if($product->account?->is_verified)
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] text-brand-green">
                                    <i class="ri-shield-check-line text-[11px]"></i>
                                    Compte vérifié
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] text-slate-600">
                                    <i class="ri-shield-check-line text-[11px]"></i>
                                    Compte en cours de vérification
                                </span>
                            @endif

                            {{-- Exemple de badge catégorie / style (optionnel) --}}
                            @if($product->category)
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] text-amber-700">
                                    <i class="ri-brush-line text-[11px]"></i>
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Grille infos boutique --}}
                        <div class="mt-3 grid gap-3 grid-cols-1 sm:grid-cols-5">
                            {{-- À propos --}}
                            <div class="sm:col-span-3 rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                                <p class="font-semibold text-slate-900 text-[12px] mb-1.5">
                                    À propos de la boutique
                                </p>
                                <p class="text-slate-600 leading-relaxed">
                                    @if(trim((string) $product->account?->about))
                                        {{ $product->account ? Str::limit($product->account->about, 500) : '' }}
                                    @else
                                        <span class="text-slate-400">
                                            Le vendeur n’a pas encore renseigné de description détaillée.
                                        </span>
                                    @endif
                                </p>
                            </div>

                            {{-- Coordonnées --}}
                            <div class="sm:col-span-2 rounded-xl border border-slate-100 bg-white p-3">
                                <p class="font-semibold text-slate-900 text-[12px] mb-1.5">
                                    Coordonnées
                                </p>

                                @php
                                    $account   = $product->account;
                                    $email     = $account?->email;
                                    $phone     = $account?->phone;
                                    $whatsapp  = $account?->whatsapp;

                                    // Nettoyage simple pour WhatsApp (garde uniquement les chiffres)
                                    $waNumber  = $whatsapp ? preg_replace('/\D+/', '', $whatsapp) : null;

                                    // Lien de la fiche produit (tu peux adapter si tu as une route dédiée)
                                    $productUrl = url()->current();

                                    // Message pré-rempli pour WhatsApp
                                    $waMessage = "Bonjour {$account->name},\n"
                                        ."Je suis intéressé(e) par l'article « {$product->name} »";

                                    if ($product->sku) {
                                        $waMessage .= " (réf : {$product->sku})";
                                    }

                                    $waMessage .= " que j'ai vu sur MYLMARK.\n\n"
                                        ."Lien de l'article : {$productUrl}\n\n"
                                        ."Je souhaiterais avoir plus d'informations sur :\n"
                                        ."- la disponibilité\n"
                                        ."- les options \n"
                                        ."- les modalités de livraison et de paiement.\n\n"
                                        ."Merci !";

                                    $waLink = $waNumber
                                        ? 'https://wa.me/'.$waNumber.'?text='.urlencode($waMessage)
                                        : null;
                                @endphp

                                <ul class="space-y-1.5 text-slate-600">
                                    {{-- Email --}}
                                    <li class="flex items-center gap-2">
                                        <i class="ri-mail-line text-[13px] text-brand-green"></i>
                                        @if($email)
                                            <a href="mailto:{{ $email }}"
                                            class="text-[11px] text-slate-700 hover:text-brand-green hover:underline break-all">
                                                {{ $email }}
                                            </a>
                                        @else
                                            <span class="text-[11px] text-slate-400">
                                                Non renseigné
                                            </span>
                                        @endif
                                    </li>

                                    {{-- Téléphone --}}
                                    <li class="flex items-center gap-2">
                                        <i class="ri-phone-line text-[13px] text-brand-green"></i>
                                        @if($phone)
                                            <a href="tel:{{ $phone }}"
                                            class="text-[11px] text-slate-700 hover:text-brand-green hover:underline">
                                                {{ $phone }}
                                            </a>
                                        @else
                                            <span class="text-[11px] text-slate-400">
                                                Non renseigné
                                            </span>
                                        @endif
                                    </li>

                                    {{-- WhatsApp --}}
                                    <li class="flex items-center gap-2">

                                        @if($waLink)
                                            <i class="ri-whatsapp-line text-[13px] text-emerald-500"></i>
                                            <a href="{{ $waLink }}" target="_blank" rel="noopener"
                                            class="text-[11px] text-slate-700 hover:text-emerald-600 hover:underline">
                                                {{ $whatsapp }}
                                            </a>
                                        @else
                                            {{-- <i class="ri-whatsapp-line text-[13px] text-emerald-500"></i>
                                            <span class="text-[11px] text-slate-400">
                                                Non renseigné
                                            </span> --}}
                                        @endif
                                    </li>

                                    <li class="flex items-center gap-2">
                                        <i class="ri-store-2-line text-xs"></i>

                                        <a href="{{ route('shop.vendors.show', $product->account) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2 py-1 text-[11px] text-slate-800 hover:border-brand-green hover:text-brand-green transition">
                                            Voir la boutique
                                        </a>

                                    </li>
                                </ul>


                            </div>

                        </div>
                    </div>


                    {{-- Encadré engagement --}}
                    <aside
                        class="rounded-2xl bg-gradient-to-br from-brand-green via-emerald-800 to-slate-900 text-slate-50 shadow-card p-4 space-y-3 reveal opacity-0 translate-y-6">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-100">
                                    Engagement MYLMARK
                                </p>
                                <p class="text-[12px] font-semibold">
                                    Un achat qui valorise le savoir-faire.
                                </p>
                            </div>
                            <div
                                class="h-9 w-9 rounded-2xl bg-white/10 flex items-center justify-center text-xl text-emerald-100">
                                <i class="ri-hand-heart-line"></i>
                            </div>
                        </div>
                        <ul class="space-y-1.5 text-[11px] text-emerald-50/95">
                            <li class="flex gap-2">
                                <i class="ri-check-line mt-[3px] text-emerald-200"></i>
                                <span>Boutique vérifiée.</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="ri-check-line mt-[3px] text-emerald-200"></i>
                                <span>Transparence sur le prix et les conditions.</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="ri-check-line mt-[3px] text-emerald-200"></i>
                                <span>Accompagnement en cas de souci avec la commande.</span>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <!-- ARTISAN SECTION -->
        {{-- <section id="artisan" class="scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-7 lg:pb-9">
            <div
            class="grid md:grid-cols-[minmax(0,1.1fr)_minmax(0,1.2fr)] gap-5 items-center rounded-3xl bg-white shadow-soft border border-slate-100/80 p-4 sm:p-5 reveal opacity-0 translate-y-6">
            <div class="space-y-3 text-[12px]">
                <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-brand-green">
                Artisan en vedette
                </p>
                <h2 class="text-lg font-semibold text-slate-900">
                Atelier Dogon – Bogolan contemporain, Bamako (Mali)
                </h2>
                <p class="text-slate-600">
                L’atelier Dogon réunit des artisans qui perpétuent la tradition du bogolan tout en explorant des
                compositions contemporaines. Chaque pièce sort de l’atelier après validation collective.
                </p>
                <div class="grid sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <p class="text-[11px] font-semibold text-slate-800">Années d’activité</p>
                    <p class="text-slate-600">+ 12 ans de création textile.</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-semibold text-slate-800">Pièces vendues via MYLMARK</p>
                    <p class="text-slate-600">+ 260 tentures et textiles.</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-semibold text-slate-800">Note moyenne</p>
                    <p class="text-slate-600">4,9 / 5 (clients MYLMARK).</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-semibold text-slate-800">Engagement</p>
                    <p class="text-slate-600">Formation d’apprentis & transmission des savoirs.</p>
                </div>
                </div>
                <button
                class="inline-flex items-center gap-1 rounded-full border border-brand-green/40 bg-brand-green/5 px-3.5 py-1.5 text-[11px] font-semibold text-brand-green hover:bg-brand-green/10">
                <i class="ri-store-3-line text-xs"></i>
                Voir la boutique de l’atelier Dogon
                </button>
            </div>
            <div
                class="relative h-48 sm:h-56 rounded-3xl overflow-hidden bg-slate-900">
                <img
                src="https://images.pexels.com/photos/3738088/pexels-photo-3738088.jpeg?auto=compress&cs=tinysrgb&w=1200"
                alt="Atelier de bogolan à Bamako"
                class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-tr from-black/55 via-black/10 to-transparent"></div>
                <div class="absolute left-4 bottom-4 space-y-1 text-[11px] text-slate-50">
                <p class="font-semibold text-[12px]">Dans l’atelier</p>
                <p class="text-emerald-100/90">
                    Les tissus sont teintés, séchés au soleil puis retravaillés motif par motif. Chaque pièce est
                    soigneusement contrôlée avant envoi.
                </p>
                </div>
            </div>
            </div>
        </div>
        </section> --}}

        <!-- REVIEWS -->
        {{-- <section id="reviews" class="scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-7 lg:pb-9">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-4">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-brand-green">
                Avis clients
                </p>
                <h2 class="text-lg font-semibold text-slate-900">
                Ils ont adopté la tenture “Savanes”
                </h2>
                <p class="text-[12px] text-slate-600">
                Les témoignages de clients ayant installé cette pièce dans leur salon, bureau ou espace culturel.
                </p>
            </div>
            <div class="text-[11px] text-slate-600">
                <p class="flex items-center gap-1">
                <span class="flex items-center gap-0.5 text-amber-400 text-xs">
                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                </span>
                <span>4,8 / 5 – 32 avis</span>
                </p>
            </div>
            </div>

            <div class="grid md:grid-cols-[minmax(0,1.4fr)_minmax(0,1.2fr)] gap-4 items-start reveal opacity-0 translate-y-6">
            <!-- Reviews list -->
            <div class="space-y-3">
                <article class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5 text-[12px]">
                <div class="flex items-center justify-between gap-2 mb-1.5">
                    <div class="flex items-center gap-2">
                    <div
                        class="h-7 w-7 rounded-full bg-slate-900 text-slate-100 flex items-center justify-center text-xs">
                        AK
                    </div>
                    <div>
                        <p class="font-semibold text-[12px]">Aïcha – Dakar</p>
                        <p class="text-[11px] text-slate-500">Salon, mur principal</p>
                    </div>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    <i class="ri-star-half-fill"></i>
                    </div>
                </div>
                <p class="text-slate-600">
                    « La tenture change complètement l’ambiance de mon salon. Les teintes sont profondes, et on sent
                    vraiment que ce n’est pas un produit industriel. »
                </p>
                <p class="mt-1 text-[11px] text-slate-400">
                    Acheteur vérifié – il y a 2 mois
                </p>
                </article>

                <article class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5 text-[12px]">
                <div class="flex items-center justify-between gap-2 mb-1.5">
                    <div class="flex items-center gap-2">
                    <div
                        class="h-7 w-7 rounded-full bg-brand-green text-slate-50 flex items-center justify-center text-xs">
                        LM
                    </div>
                    <div>
                        <p class="font-semibold text-[12px]">Lamine – Paris</p>
                        <p class="text-[11px] text-slate-500">Bureau / home office</p>
                    </div>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    </div>
                </div>
                <p class="text-slate-600">
                    « J’avais besoin d’une pièce forte derrière mon bureau pour mes visioconférences. Résultat : on me
                    demande souvent d’où vient la tenture. »
                </p>
                <p class="mt-1 text-[11px] text-slate-400">
                    Acheteur vérifié – il y a 3 semaines
                </p>
                </article>

                <article class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5 text-[12px]">
                <div class="flex items-center justify-between gap-2 mb-1.5">
                    <div class="flex items-center gap-2">
                    <div
                        class="h-7 w-7 rounded-full bg-brand-orange text-slate-900 flex items-center justify-center text-xs">
                        EM
                    </div>
                    <div>
                        <p class="font-semibold text-[12px]">Emmanuel – Lomé</p>
                        <p class="text-[11px] text-slate-500">Coin lecture</p>
                    </div>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    <i class="ri-star-fill"></i>
                    </div>
                </div>
                <p class="text-slate-600">
                    « Très satisfait, le tissu est épais et les motifs sont encore plus beaux en vrai. La livraison était
                    bien suivie. »
                </p>
                <p class="mt-1 text-[11px] text-slate-400">
                    Acheteur vérifié – il y a 1 mois
                </p>
                </article>
            </div>

            <!-- Summary -->
            <aside
                class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 text-[11px] space-y-2">
                <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="font-semibold text-slate-900">Synthèse des avis</p>
                    <p class="text-slate-500">Pour cette tenture “Savanes”.</p>
                </div>
                <div class="text-right">
                    <p class="text-[18px] font-semibold text-amber-500 leading-none">
                    4,8 <span class="text-[11px] text-slate-500">/ 5</span>
                    </p>
                    <p class="text-[10px] text-slate-500 mt-0.5">32 avis vérifiés</p>
                </div>
                </div>
                <div class="space-y-1.5 pt-1">
                <div class="flex items-center gap-2">
                    <span class="w-12 text-right text-[10px]">5 ★</span>
                    <div class="flex-1 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full w-[70%] bg-amber-400"></div>
                    </div>
                    <span class="w-6 text-[10px] text-right text-slate-500">70%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-12 text-right text-[10px]">4 ★</span>
                    <div class="flex-1 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full w-[22%] bg-amber-400"></div>
                    </div>
                    <span class="w-6 text-[10px] text-right text-slate-500">22%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-12 text-right text-[10px]">3 ★</span>
                    <div class="flex-1 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full w-[5%] bg-amber-400"></div>
                    </div>
                    <span class="w-6 text-[10px] text-right text-slate-500">5%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-12 text-right text-[10px]">2 ★</span>
                    <div class="flex-1 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full w-[2%] bg-amber-400"></div>
                    </div>
                    <span class="w-6 text-[10px] text-right text-slate-500">2%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-12 text-right text-[10px]">1 ★</span>
                    <div class="flex-1 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full w-[1%] bg-amber-400"></div>
                    </div>
                    <span class="w-6 text-[10px] text-right text-slate-500">1%</span>
                </div>
                </div>
                <p class="pt-2 text-slate-500">
                Vous avez déjà acheté ce produit ? Partagez votre expérience pour aider d’autres clients à choisir.
                </p>
                <button
                class="inline-flex items-center gap-1 rounded-full bg-slate-900 text-slate-50 px-3.5 py-1.5 text-[11px] font-semibold hover:bg-slate-800">
                <i class="ri-pencil-line text-xs"></i>
                Rédiger un avis
                </button>
            </aside>
            </div>
        </div>
        </section> --}}

        {{-- PRODUITS SIMILAIRES --}}
        @if($similarProducts->isNotEmpty())
            <section id="related" class="scroll-mt-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-9">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-4">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-brand-green">
                                Vous aimeriez aussi
                            </p>
                            <h2 class="text-lg font-semibold text-slate-900">
                                Autres suggestions ...
                            </h2>
                        </div>
                        <a href="{{ route('shop.products.index') }}"
                        class="inline-flex items-center gap-1 text-[11px] text-slate-600 hover:text-slate-900">
                            Voir la boutique
                            <i class="ri-arrow-right-line text-xs"></i>
                        </a>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 reveal opacity-0 translate-y-6">
                        @foreach($similarProducts as $p)
                            @php
                                $mediaSim = $p->getFirstMedia('gallery');
                                $img  = $p->image;
                                $imgSim = $img ? asset('storage/' . $img) : ($mediaSim ? asset('storage/' . $mediaSim->getPathRelativeToRoot()) : asset('assets/images/products.png'));
                                $priceSim = $priceOf($p);
                            @endphp
                            <article
                                class="group flex flex-col rounded-2xl bg-white shadow-card border border-slate-100/80 overflow-hidden hover:-translate-y-1.5 hover:shadow-soft transition">
                                <a href="{{ route('shop.products.show', $p) }}" class="block">
                                    <div class="relative h-40">
                                        <img
                                            src="{{ $imgSim }}"
                                            alt="{{ $p->name }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.src='{{ asset('assets/images/products.png') }}'">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-transparent"></div>
                                    </div>
                                </a>
                                <div class="p-3.5 space-y-1.5 text-[11px]">
                                    <h3 class="text-[13px] font-semibold text-slate-900 line-clamp-2">
                                        {{ $p->name }}
                                    </h3>
                                    <p class="text-slate-500 line-clamp-2">
                                        {{ Str::limit(strip_tags($p->description ?? ''), 120) }}
                                    </p>
                                    <p class="text-slate-500 flex items-center gap-1">
                                        <i class="ri-user-3-line text-brand-green text-xs"></i>
                                        {{ $p->account?->name }} – {{ $p->account?->city }}
                                    </p>
                                    <div class="flex items-center justify-between pt-1">
                                        <div class="text-[13px] font-semibold text-amber-500">
                                            @if(!is_null($priceSim))
                                                {{ number_format($priceSim, 0, ',', ' ') }} {{ $currency }}
                                            @else
                                                Prix
                                            @endif
                                        </div>
                                        <a href="{{ route('shop.products.show', $p) }}"
                                        class="inline-flex items-center gap-1 rounded-full bg-slate-900 text-slate-50 px-3 py-1.5 text-[10px] font-semibold group-hover:bg-slate-800">
                                            Voir
                                            <i class="ri-arrow-right-line text-[11px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

    {{-- MODAL ZOOM PRODUIT --}}
    <div id="zoomModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="relative max-w-5xl w-full mx-4">
            {{-- Fermer --}}
            <button type="button" id="closeZoomBtn"
                    class="absolute -top-10 right-0 inline-flex items-center justify-center rounded-full bg-white/90 text-slate-800 w-8 h-8 shadow">
                <i class="ri-close-line text-lg"></i>
            </button>

            <div class="relative bg-black rounded-2xl overflow-hidden">
                {{-- Navigation gauche/droite --}}
                <button type="button" id="prevZoom"
                        class="absolute left-2 top-1/2 -translate-y-1/2 z-10 inline-flex items-center justify-center w-9 h-9 rounded-full bg-black/50 text-white hover:bg-black/70">
                    <i class="ri-arrow-left-s-line text-lg"></i>
                </button>
                <button type="button" id="nextZoom"
                        class="absolute right-2 top-1/2 -translate-y-1/2 z-10 inline-flex items-center justify-center w-9 h-9 rounded-full bg-black/50 text-white hover:bg-black/70">
                    <i class="ri-arrow-right-s-line text-lg"></i>
                </button>

                <img id="zoomImage"
                    src="{{ $mainUrl }}"
                    alt="{{ $product->name }}"
                    class="w-full max-h-[80vh] object-contain bg-black">
            </div>

            {{-- Thumbnails dans le zoom --}}
            <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                @foreach($gallery as $index => $url)
                    <button type="button"
                            class="zoom-thumb flex-shrink-0 rounded-xl border-2 border-transparent overflow-hidden"
                            data-index="{{ $index }}">
                        <img src="{{ $url }}"
                            alt=""
                            class="h-14 w-14 object-cover"
                            onerror="this.src='{{ asset('assets/images/products.png') }}'">
                    </button>
                @endforeach
            </div>

        </div>
    </div>

    <script>
        const currencyDefault   = @json($currency);
        const galleryImages     = @json($gallery->values()->all());
        const fmt = (n, c) => new Intl.NumberFormat('fr-FR').format(parseFloat(n || 0)) + ' ' + (c || currencyDefault);

        function applySkuDatasets(el) {
            const price = parseFloat(el.dataset.price || '0');
            const old   = parseFloat(el.dataset.old || '0');
            const stock = parseInt(el.dataset.stock || '0', 10);
            const curr  = el.dataset.currency || currencyDefault;

            const priceEl = document.getElementById('livePrice');
            const hint    = document.getElementById('skuStockHint');
            const qty     = document.getElementById('qty');
            const btn     = document.getElementById('addToCartBtn');
            const buyNow  = document.getElementById('buyNowBtn');

            if (priceEl) {
                if (old && old > price) {
                    priceEl.innerHTML =
                        `<span class="text-xs sm:text-sm text-slate-500 line-through mr-2">${fmt(old, curr)}</span>` +
                        `<span class="text-2xl sm:text-3xl font-extrabold tracking-tight">${fmt(price, curr)}</span>`;
                } else {
                    priceEl.innerHTML =
                        `<span class="text-2xl sm:text-3xl font-extrabold tracking-tight">${fmt(price, curr)}</span>`;
                }
            }
            if (hint) {
                hint.textContent = stock > 0 ? `${stock} en stock` : 'Rupture pour cette variante';
                hint.className = 'mt-1 text-xs ' + (stock > 0 ? 'text-emerald-600' : 'text-rose-600');
            }
            if (qty) qty.disabled = stock <= 0;
            if (btn) btn.disabled = stock <= 0;
            if (buyNow) buyNow.disabled = stock <= 0;
        }

        (function initSkus() {
            const pills  = document.querySelectorAll('input[name="sku_pill"]');
            const select = document.getElementById('product_sku_id');

            function selectById(id) {
                if (!select) return;
                [...select.options].forEach(o => o.selected = (o.value === id));
                const opt = select.options[select.selectedIndex];
                if (opt) applySkuDatasets(opt);
            }

            pills.forEach(p => p.addEventListener('change', e => selectById(e.target.value)));

            if (select) {
                if (pills.length) {
                    pills[0].checked = true;
                    selectById(pills[0].value);
                } else if (select.options.length) {
                    applySkuDatasets(select.options[select.selectedIndex]);
                }

                select.addEventListener('change', () => {
                    const v = select.value;
                    const target = [...pills].find(p => p.value === v);
                    if (target) target.checked = true;
                    applySkuDatasets(select.options[select.selectedIndex]);
                });
            }
        })();

        // ===== GALERIE PRINCIPALE + ZOOM SLIDER =====
        let currentIndex = 0;
        const mainImage   = document.getElementById('mainImage');
        const zoomModal   = document.getElementById('zoomModal');
        const zoomImage   = document.getElementById('zoomImage');
        const openZoomBtn = document.getElementById('openZoomBtn');
        const closeZoomBtn= document.getElementById('closeZoomBtn');
        const prevZoomBtn = document.getElementById('prevZoom');
        const nextZoomBtn = document.getElementById('nextZoom');

        function showZoomImage() {
            if (!zoomImage || !galleryImages.length) return;
            currentIndex = (currentIndex + galleryImages.length) % galleryImages.length;
            zoomImage.src = galleryImages[currentIndex];
        }

        function openZoom(index = null) {
            if (!zoomModal || !galleryImages.length) return;

            if (typeof index === 'number' && !Number.isNaN(index)) {
                currentIndex = index;
            } else if (mainImage) {
                const src = mainImage.src;
                const found = galleryImages.findIndex(u => src.includes(u));
                if (found >= 0) currentIndex = found;
            }

            showZoomImage();
            zoomModal.classList.remove('hidden');
            zoomModal.classList.add('flex');
        }

        function closeZoom() {
            if (!zoomModal) return;
            zoomModal.classList.add('hidden');
            zoomModal.classList.remove('flex');
        }

        // Thumbnails de la page principale
        document.querySelectorAll('[data-image]').forEach(btn => {
            btn.addEventListener('click', () => {
                const u   = btn.dataset.image;
                const idx = parseInt(btn.dataset.index ?? '0', 10);
                if (mainImage && u) {
                    mainImage.src = u;
                    if (!Number.isNaN(idx)) currentIndex = idx;
                }
            });
        });

        // Thumbnails dans le zoom
        document.querySelectorAll('.zoom-thumb').forEach(btn => {
            btn.addEventListener('click', () => {
                const idx = parseInt(btn.dataset.index ?? '0', 10);
                if (!Number.isNaN(idx)) {
                    currentIndex = idx;
                    showZoomImage();
                }
            });
        });

        if (openZoomBtn)   openZoomBtn.addEventListener('click', () => openZoom());
        if (mainImage)     mainImage.addEventListener('click', () => openZoom());
        if (closeZoomBtn)  closeZoomBtn.addEventListener('click', closeZoom);
        if (prevZoomBtn)   prevZoomBtn.addEventListener('click', () => { currentIndex--; showZoomImage(); });
        if (nextZoomBtn)   nextZoomBtn.addEventListener('click', () => { currentIndex++; showZoomImage(); });

        if (zoomModal) {
            zoomModal.addEventListener('click', (e) => {
                if (e.target === zoomModal) closeZoom();
            });
            document.addEventListener('keydown', (e) => {
                if (zoomModal.classList.contains('flex')) {
                    if (e.key === 'Escape') closeZoom();
                    if (e.key === 'ArrowLeft') { currentIndex--; showZoomImage(); }
                    if (e.key === 'ArrowRight'){ currentIndex++; showZoomImage(); }
                }
            });
        }

        // ===== STEPPER QUANTITÉ =====
        function qtyStep(delta) {
            const el = document.getElementById('qty');
            if (!el || el.disabled) return;
            const v = Math.max(1, parseInt(el.value || '1', 10) + delta);
            el.value = v;
        }
        window.qtyStep = qtyStep;

        // ===== TABS =====
        (function initTabs() {
            const tabButtons  = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            if (!tabButtons.length || !tabContents.length) return;

            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.dataset.tab;

                    tabButtons.forEach(b => {
                        b.classList.remove('bg-slate-900', 'text-slate-50', 'font-semibold');
                        b.classList.add('bg-slate-100', 'text-slate-700');
                    });
                    btn.classList.add('bg-slate-900', 'text-slate-50', 'font-semibold');
                    btn.classList.remove('bg-slate-100', 'text-slate-700');

                    tabContents.forEach(content => content.classList.add('hidden'));
                    const el = document.getElementById('tab-' + target);
                    if (el) el.classList.remove('hidden');
                });
            });
        })();

        // ===== REVEAL ANIMATION =====
        (function initReveal() {
            const reveals = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                reveals.forEach(el => el.classList.remove('opacity-0', 'translate-y-6'));
                return;
            }
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-6');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            reveals.forEach(el => observer.observe(el));
        })();

    </script>

    <script>
        document.querySelector('form[action*="cart"]').addEventListener('submit', async (e) => {
            const btn = e.submitter;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i>';
            btn.disabled = true;
        });
    </script>


    {{-- <script type="application/ld+json"> {
            "@context": "https://schema.org",
            "@type": "Product",
            "name": "{{ $product->name }}",
            "description": "{{ $metaDesc }}",
            "image": "{{ $mainUrl }}",
            "sku": "{{ $product->sku }}",
            "offers": {
                "@type": "Offer",
                "availability": "{{ $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
                "price": "{{ $priceSeo }}",
                "priceCurrency": "{{ $currency }}"
            }
        }
    </script> --}}

@endsection
