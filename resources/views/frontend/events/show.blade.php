@extends('frontend.layouts.master')

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\URL;

    // --------- TITRE / INFOS DE BASE ---------
    $title         = $event->title ?? $event->name;
    $categoryName  = optional($event->category)->name;
    $languageName  = optional($event->language)->name;
    $countryName   = optional($event->country)->name;

    $dateText = '';
    if (!empty($event->start_date) && !empty($event->end_date)) {
        $sameMonth = $event->start_date->format('mY') === $event->end_date->format('mY');
        $dateText  = $sameMonth
            ? $event->start_date->translatedFormat('d') . '–' . $event->end_date->translatedFormat('d M Y')
            : $event->start_date->translatedFormat('d M Y') . ' — ' . $event->end_date->translatedFormat('d M Y');
    } elseif (!empty($event->start_date)) {
        $dateText = $event->start_date->translatedFormat('d M Y');
    }

    $viewsCount = is_numeric($event->views_count ?? null) ? (int)$event->views_count : 0;

    // --------- IMAGES (HERO + GALERIE) ---------
    $heroPlaceholder   = asset('assets/front/images/guine.jpg');       // hero par défaut
    $thumbPlaceholder  = asset('assets/front/images/danse-tradi.jpg'); // miniatures / galerie

    // Couverture (Spatie -> image -> fallback heroPlaceholder -> image storage)
    $coverUrl = $heroPlaceholder;
    if (method_exists($event, 'getFirstMediaUrl')) {
        $u = $event->getFirstMediaUrl('events', 'og');
        if (!$u) $u = $event->getFirstMediaUrl('events');
        if (!$u) $u = $event->getFirstMediaUrl('gallery', 'og');
        if (!$u) $u = $event->getFirstMediaUrl('gallery');
        if ($u)  $coverUrl = $u;
    }
    if ($coverUrl === $heroPlaceholder && !empty($event->image)) {
        $coverUrl = asset('storage/' . ltrim($event->image, '/'));
    }

    // Galerie (tableau d'URLs)
    $gallery = [];
    if (method_exists($event, 'getMedia')) {
        $media = $event->getMedia('events');
        if ($media->isEmpty()) $media = $event->getMedia('gallery');
        foreach ($media as $m) {
            $gallery[] = $m->hasGeneratedConversion('preview') ? $m->getUrl('preview') : $m->getUrl();
        }
    }
    if (empty($gallery) && !empty($event->image)) {
        $gallery[] = asset('storage/' . ltrim($event->image, '/'));
    }
    if (empty($gallery)) {
        $gallery[] = $thumbPlaceholder;
    }

    // --------- TICKETS (injectés par le controller idéalement) ---------
    // $types, $minPrice, $eventEnded doivent être fournis par le controller.
    // On met des fallback pour éviter les erreurs si jamais.
    $types      = $types      ?? collect();
    $minPrice   = $minPrice   ?? null;
    $eventEnded = $eventEnded ?? false;

    // --------- META PARTAGE ---------
    $descRaw = $event->description ?? '';
    $ogDesc  = Str::limit(trim(strip_tags($descRaw)), 160);
    $ogImage = Str::startsWith($coverUrl, ['http://','https://']) ? $coverUrl : URL::to($coverUrl);

    // --------- COUNTDOWN ---------
    $hasCountdown = false;
    $countdownTs  = null;
    if (!empty($event->start_date) && now()->lt($event->start_date)) {
        $hasCountdown = true;
        $countdownTs  = $event->start_date->timestamp;
    }
@endphp

@section('title') {{ $title ?? 'Événement' }} @endsection
@section('og_title', $title ?? 'Événement')
@section('og_desc',  $ogDesc)
@section('og_image', $ogImage)
@section('og_image_alt', $title ?? 'Événement')
@section('og_image_width','1200')
@section('og_image_height','630')

@section('meta')
  @parent
  <meta property="og:type" content="article">
  <meta property="og:site_name" content="Zaly Merveille">
  <meta property="og:image:secure_url" content="{{ preg_replace('/^http:/','https:', $ogImage) }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $title }}">
  <meta name="twitter:description" content="{{ $ogDesc }}">
  <meta name="twitter:image" content="{{ $ogImage }}">
@endsection

@section('content')
{{-- ===================== HERO IMMERSIF ZALY ===================== --}}
<section class="relative overflow-hidden">
    {{-- BACKGROUND IMAGE + GRADIENTS --}}
    <div class="absolute inset-0 bg-[#050308]">
        @if(!empty($coverUrl))
            <img src="{{ $coverUrl }}" alt="{{ $title }}"
                class="w-full h-full object-cover opacity-50 mix-blend-luminosity">
        @endif

        {{-- Voile noir principal pour bien faire ressortir le contenu --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/90 to-black"></div>

        {{-- Halo verts / orange Zaly, plus discrets --}}
        <div class="absolute -top-40 left-[-10%] w-[380px] h-[380px] rounded-full bg-emerald-500/25 blur-[100px]"></div>
        <div class="absolute -bottom-40 right-[-10%] w-[380px] h-[380px] rounded-full bg-amber-400/22 blur-[110px]"></div>

        {{-- léger pattern grid très doux --}}
        <div class="absolute inset-0 pointer-events-none opacity-15 mix-blend-soft-light
                    bg-[linear-gradient(135deg,_rgba(255,255,255,0.07)_1px,_transparent_1px)]
                    bg-[length:28px_28px]">
        </div>
    </div>



    <div class="relative z-10 max-w-6xl mx-auto px-5 pt-10 pb-20">
        {{-- Badge ligne au-dessus du titre --}}
        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/20 px-3 py-1 text-[11px] font-medium text-white/90 backdrop-blur">
            @if(!empty($categoryName))
                <span class="inline-flex items-center gap-1">
                    <i class="ri-price-tag-3-line text-[13px]"></i> {{ $categoryName }}
                </span>
            @endif
            @if(!empty($countryName))
                <span class="opacity-80">• {{ $countryName }}</span>
            @endif
            {{-- @if(!empty($languageName))
                <span class="opacity-80">• {{ $languageName }}</span>
            @endif --}}
            <span class="inline-flex items-center gap-1 ms-1 text-emerald-200">
                <i class="ri-sparkling-2-line text-[13px]"></i> Zaly Merveille
            </span>
        </div>

        <div class="mt-4 grid gap-8 lg:grid-cols-[minmax(0,2.1fr)_minmax(260px,1fr)] items-end">
            {{-- =================== COLONNE GAUCHE : TITRE + META =================== --}}
            <div>
                <h1 class="text-white text-3xl sm:text-5xl md:text-[2.9rem] font-extrabold leading-tight tracking-tight">
                    {{ $title }}
                </h1>

                {{-- Meta : date / lieu / vues --}}
                <div class="mt-5 flex flex-wrap gap-3 text-sm text-white/90">
                    @if(!empty($dateText))
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/20 px-3 py-1 backdrop-blur">
                            <i class="ri-calendar-line text-[16px]"></i>
                            {{ $dateText }}
                        </span>
                    @endif

                    @if(!empty($event->location))
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/20 px-3 py-1 backdrop-blur">
                            <i class="ri-map-pin-2-line text-[16px]"></i>
                            {{ Str::limit($event->location, 60) }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/20 px-3 py-1 backdrop-blur">
                        <i class="ri-eye-line text-[16px]"></i>
                        {{ number_format($viewsCount, 0, ',', ' ') }} vues
                    </span>
                </div>

                {{-- Petit “timeline” visuel (date / lieu / ambiance) --}}
                <div class="mt-6 hidden md:block">
                    <div class="flex flex-wrap gap-6 text-xs text-white/80">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-2xl bg-white/10 flex items-center justify-center">
                                <i class="ri-time-line text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold uppercase tracking-wide text-[11px] opacity-80">Quand</p>
                                <p class="text-sm">
                                    @if(!empty($event->start_date))
                                        {{ $event->start_date->translatedFormat('d M Y') }}
                                        @if(!empty($event->end_date))
                                            — {{ $event->end_date->translatedFormat('d M Y') }}
                                        @endif
                                    @else
                                        Dates à venir
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-2xl bg-white/10 flex items-center justify-center">
                                <i class="ri-group-line text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold uppercase tracking-wide text-[11px] opacity-80">Ambiance</p>
                                <p class="text-sm">Musique, rencontres & culture locale</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- =================== COLONNE DROITE : CARTE BILLET =================== --}}
            <div class="w-full lg:w-auto">
                <div class="relative rounded-3xl bg-white/10 border border-white/20 px-5 py-4 shadow-2xl backdrop-blur flex flex-col gap-3">
                    {{-- Perforation style ticket --}}
                    {{-- <div class="pointer-events-none absolute inset-y-4 left-1/2 -translate-x-1/2 w-px border-l border-dashed border-white/25 hidden md:block"></div> --}}

                    <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                        {{-- Prix & statut --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] uppercase tracking-[0.12em] text-white/65 mb-1">
                                À partir de
                            </p>
                            <p class="text-3xl font-extrabold leading-none text-white">
                                @if(!is_null($minPrice))
                                    {{ number_format($minPrice, 0, ',', ' ') }}
                                    <span class="text-sm font-semibold">GNF</span>
                                @else
                                    Gratuit
                                @endif
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-2 text-[11px]">
                                @if(!$eventEnded)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/90 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                                        <span class="relative flex h-2 w-2">
                                            <span class="absolute inline-flex h-full w-full rounded-full bg-orange-700 opacity-90 animate-ping"></span>
                                            <span class="relative inline-flex h-2 w-2 rounded-full bg-green-700"></span>
                                        </span>
                                        Ventes ouvertes
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-zinc-600/90 px-2.5 py-1 text-[11px] font-semibold text-white">
                                        <i class="ri-calendar-close-line text-xs"></i>
                                        Événement terminé
                                    </span>
                                @endif

                                @if(!empty($event->city))
                                    <span class="inline-flex items-center gap-1 rounded-full bg-black/30 px-2 py-1 text-[11px] text-white/85">
                                        <i class="ri-map-pin-range-line text-xs"></i>
                                        {{ Str::limit($event->city, 22) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Countdown / Date courte --}}
                        <div class="w-full md:w-[140px] flex flex-col justify-between">
                            @if($hasCountdown && !$eventEnded)
                                <div class="rounded-2xl bg-black/25 border border-white/15 px-3 py-2 text-center">
                                    <p class="text-[10px] uppercase tracking-[0.18em] text-white/70">
                                        Débute dans
                                    </p>
                                    <p id="countdown" class="mt-1 text-xs font-semibold text-white"></p>
                                </div>
                            @elseif(!empty($event->start_date))
                                <div class="rounded-2xl bg-black/25 border border-white/15 px-3 py-2 text-center">
                                    <p class="text-[10px] uppercase tracking-[0.18em] text-white/70">
                                        Date clé
                                    </p>
                                    <p class="mt-1 text-sm font-semibold text-white">
                                        {{ $event->start_date->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            @endif

                            <div class="mt-3 text-[10px] text-white/70 text-center">
                                <span class="opacity-80">Billets numériques sécurisés Zaly</span>
                            </div>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-3 flex flex-col sm:flex-row gap-2">
                        <a @if(!$eventEnded)
                               href="{{ route('events.buy', $event) }}"
                           @else
                               href="javascript:void(0)"
                           @endif
                           class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition
                                  @if($eventEnded)
                                      bg-zinc-500 cursor-not-allowed text-white
                                  @else
                                      bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/25
                                  @endif">
                            <i class="ri-ticket-2-line text-base"></i>
                            <span>
                                @if($eventEnded)
                                    Billetterie fermée
                                @else
                                    Acheter
                                @endif
                            </span>
                        </a>

                        <button type="button"
                                onclick="shareEvent()"
                                class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold bg-white/10 hover:bg-white/15 text-white border border-white/20">
                            <i class="ri-share-line text-base"></i>
                            <span>Partager</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fondu vers la section blanche suivante --}}
    <div class="pointer-events-none absolute bottom-0 inset-x-0 h-4 bg-gradient-to-t from-zinc-50"></div>
</section>


{{-- ===================== SECTION PRINCIPALE ===================== --}}
<section class="bg-white">
  <div class="max-w-6xl mx-auto px-5 py-10 grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- ===== Colonne gauche ===== --}}
    <div class="space-y-8">
      {{-- Description --}}
      @if(!empty($event->description))
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
          <h2 class="text-xl font-bold text-zinc-900 mb-3">À propos de l’événement</h2>
          <div class="prose prose-zinc max-w-none">
            {!! nl2br(e($event->description)) !!}
          </div>
        </div>
      @endif



      {{-- Pourquoi venir ? --}}
      <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-zinc-900 mb-4">Pourquoi venir ?</h2>
        <div class="grid sm:grid-cols-3 gap-4">
          <div class="rounded-2xl border p-4">
            <div class="text-emerald-700 font-semibold">Ambiance</div>
            <p class="text-sm text-zinc-600 mt-1">Une expérience immersive avec musique, danse et rencontres.</p>
          </div>
          <div class="rounded-2xl border p-4">
            <div class="text-emerald-700 font-semibold">Découverte</div>
            <p class="text-sm text-zinc-600 mt-1">Célébrez les cultures locales, la gastronomie et l’artisanat.</p>
          </div>
          <div class="rounded-2xl border p-4">
            <div class="text-emerald-700 font-semibold">Moments forts</div>
            <p class="text-sm text-zinc-600 mt-1">Shows, ateliers, rencontres et souvenirs uniques.</p>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Colonne droite ===== --}}
    <div class="space-y-8">
        {{-- Billets & formules --}}
        @if($types->isNotEmpty())
            <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-zinc-900">Billets & formules</h2>
                    <a href="{{ route('events.buy', $event) }}" class="text-emerald-700 hover:text-emerald-900 font-semibold text-sm">
                    Voir tout →
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    @foreach($types->take(3) as $t)
                        @php
                            $feat = $t->features;
                            if (is_string($feat)) {
                                $dec = json_decode($feat, true);
                                if (is_array($dec))          $feat = $dec;
                                elseif (trim($feat) !== '')  $feat = [$feat];
                                else                         $feat = [];
                            }
                            if (!is_array($feat)) $feat = [];

                            $canBuyThis = true;
                            $now = now();
                            if (!empty($t->sales_start) && $now->lt($t->sales_start)) $canBuyThis = false;
                            if (!empty($t->sales_end)   && $now->gt($t->sales_end))   $canBuyThis = false;

                            // ⚠️ nombre de billets restants (tickets.status = 'available')

                            $remaining = $t->available_tickets_count;

                            $badgeLabel = $loop->first ? 'Populaire' : null;

                            // Désactivation globale si event terminé
                            $isDisabled = $eventEnded || !$canBuyThis || ($remaining !== null && $remaining <= 0);
                        @endphp

                        <div class="relative group rounded-3xl border border-zinc-200/80 bg-gradient-to-br from-white to-zinc-50/60 p-5 hover:shadow-md hover:border-emerald-500/70 transition flex flex-col h-full">

                            @if($badgeLabel)
                                <span class="absolute -top-2 left-4 inline-flex items-center gap-1 rounded-full bg-emerald-600 text-white text-[11px] font-semibold px-2.5 py-1 shadow-sm">
                                    <i class="ri-star-smile-line text-xs"></i> {{ $badgeLabel }}
                                </span>
                            @endif

                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-[11px] uppercase tracking-wide text-zinc-500">Formule</p>
                                    <h3 class="text-lg font-semibold text-zinc-900 leading-snug">
                                        {{ Str::limit($t->name, 40) }}
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-[11px] uppercase tracking-wide text-zinc-500">À partir de</p>
                                    <p class="text-2xl font-extrabold text-zinc-900 leading-none">
                                        {{ number_format($t->price, 0, ',', ' ') }}
                                        <span class="text-xs font-semibold">GNF</span>
                                    </p>

                                    {{-- Ici : billets restants au lieu de "places prévues" --}}
                                    @if(!is_null($remaining))
                                        <p class="text-[11px] mt-1 {{ $remaining > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $remaining }} ticket{{ $remaining > 1 ? 's' : '' }} restant{{ $remaining > 1 ? 's' : '' }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            @if(!empty($t->description))
                                <p class="mt-2 text-sm text-zinc-600 line-clamp-2">
                                    {{ $t->description }}
                                </p>
                            @endif

                            @if(!empty($feat))
                                <ul class="mt-3 space-y-1.5 text-xs text-zinc-700">
                                    @foreach($feat as $f)
                                        <li class="flex items-start gap-2">
                                            <i class="ri-check-line text-emerald-600 mt-[2px]"></i>
                                            <span>{{ $f }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(!empty($t->sales_start) || !empty($t->sales_end))
                                <p class="mt-3 text-[11px] text-zinc-500">
                                    Vente :
                                    {{ !empty($t->sales_start) ? $t->sales_start->format('d/m/Y H:i') : '—' }}
                                    →
                                    {{ !empty($t->sales_end) ? $t->sales_end->format('d/m/Y H:i') : '∞' }}
                                </p>
                            @endif


                            {{-- ===== Bouton : désactivé si event terminé OU ventes fermées OU plus de billets ===== --}}
                             @if($isDisabled)
                                <button type="button"
                                    class="mt-auto inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white bg-zinc-400 cursor-not-allowed select-none"
                                    disabled>
                                    <i class="ri-lock-line"></i>
                                    <span>Indisponible</span>
                                </button>
                            @else
                                <a href="{{ route('events.buy', $event) }}?type={{ $t->id }}"
                                class="mt-auto inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700">
                                    <i class="ri-ticket-2-line"></i>
                                    <span>Choisir ce ticket</span>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        @endif

        {{-- Localisation --}}
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-zinc-900">Localisation</h2>
            <button id="toggleMap"
                class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-white text-zinc-800 font-medium ring-1 ring-zinc-200 hover:bg-zinc-50 shadow-sm">
                <i class="ri-map-2-line"></i> Afficher
            </button>
            </div>
            <p class="mt-2 text-sm text-zinc-600">{{ $event->map_description ?: ($event->location ?? '') }}</p>

            <div id="mapWrap" class="mt-4 hidden">
            <div class="relative rounded-2xl overflow-hidden ring-1 ring-zinc-200">
                <div id="map" class="w-full h-[320px]"></div>
                <button id="closeMap"
                class="absolute top-3 right-3 bg-white/95 px-3 py-1.5 rounded-full text-sm ring-1 ring-zinc-200 shadow hover:bg-white">
                Fermer
                </button>
            </div>
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
            <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            </div>

            @if(!empty($event->map_url))
            <a href="{{ $event->map_url }}" target="_blank" rel="noopener"
                class="mt-3 inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow">
                <i class="ri-external-link-line"></i> Ouvrir dans Maps
            </a>
            @endif
        </div>

        {{-- Actions rapides --}}
        {{-- <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap gap-2">
            <a href="{{ route('events.buy', $event) }}"
                class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">
                <i class="ri-shopping-cart-2-line"></i> Acheter mon ticket
            </a>
            <button type="button" onclick="shareEvent()"
                class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-white ring-1 ring-zinc-200 hover:bg-zinc-50 font-semibold">
                <i class="ri-share-line"></i> Partager
            </button>
            </div>
        </div> --}}

        {{-- Galerie avec slider lightbox --}}
        @if(!empty($gallery))
            <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-bold text-zinc-900">Galerie</h2>
                <span class="text-xs text-zinc-500">{{ count($gallery) }} photo(s)</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 gap-3">
                @foreach($gallery as $i => $url)
                <button type="button"
                        onclick="openLightbox({{ $i }})"
                        class="group relative rounded-2xl overflow-hidden ring-1 ring-zinc-200 hover:ring-emerald-500 transition">
                    <img src="{{ $url }}" alt="Photo {{ $i+1 }} — {{ $title }}"
                        class="w-full h-36 sm:h-40 object-cover group-hover:scale-105 transition">
                    <span class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></span>
                </button>
                @endforeach
            </div>
            </div>
        @endif
    </div>

  </div>
</section>

{{-- LIGHTBOX SLIDER --}}
<div id="lb" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
  <button onclick="closeLightbox()"
          class="absolute top-4 right-4 bg-white/95 px-3 py-1.5 rounded-full text-sm ring-1 ring-zinc-200 shadow hover:bg-white">
    Fermer
  </button>

  <button id="lbPrev" type="button"
          class="absolute left-4 sm:left-8 text-white/80 hover:text-white text-3xl">
    ‹
  </button>
  <button id="lbNext" type="button"
          class="absolute right-4 sm:right-8 text-white/80 hover:text-white text-3xl">
    ›
  </button>

  <img id="lbImg" src="" alt="Image"
       class="max-w-[92vw] max-h-[86vh] rounded-xl ring-1 ring-white/10 shadow-2xl object-contain">
</div>

<style>
@keyframes float { 0%,100%{ transform:translateY(0) } 50%{ transform:translateY(-16px) } }
</style>

<script>
  // --- Gallerie slider ---
  const galleryUrls = @json($gallery);
  let currentIndex = 0;

  function openLightbox(index){
    currentIndex = index;
    const w = document.getElementById('lb');
    const i = document.getElementById('lbImg');
    i.src = galleryUrls[currentIndex] || '';
    w.classList.remove('hidden');
    w.classList.add('flex');
  }
  function closeLightbox(){
    const w = document.getElementById('lb');
    const i = document.getElementById('lbImg');
    i.src = '';
    w.classList.add('hidden');
    w.classList.remove('flex');
  }
  function showNext(delta){
    if (!galleryUrls.length) return;
    currentIndex = (currentIndex + delta + galleryUrls.length) % galleryUrls.length;
    document.getElementById('lbImg').src = galleryUrls[currentIndex];
  }
  document.getElementById('lbPrev').addEventListener('click', () => showNext(-1));
  document.getElementById('lbNext').addEventListener('click', () => showNext(1));
  window.addEventListener('keydown', e => {
    const lb = document.getElementById('lb');
    if (lb.classList.contains('hidden')) return;
    if (e.key === 'ArrowLeft') showNext(-1);
    if (e.key === 'ArrowRight') showNext(1);
    if (e.key === 'Escape') closeLightbox();
  });

  // Share
  function shareEvent(){
    if (navigator.share) {
      navigator.share({ title: @json($title ?? 'Événement'), url: window.location.href });
    } else {
      navigator.clipboard.writeText(window.location.href);
      alert('Lien copié !');
    }
  }

  // Map repliable + countdown
  document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleMap');
    const wrap      = document.getElementById('mapWrap');
    const closeBtn  = document.getElementById('closeMap');

    let mapInited = false;
    function initMap(){
      if (mapInited) return;
      if (typeof L === 'undefined') { setTimeout(initMap, 80); return; }

      const hasCoords = {{ (!empty($event->latitude) && !empty($event->longitude)) ? 'true' : 'false' }};
      const lat = {{ !empty($event->latitude)  ? $event->latitude  : 'null' }};
      const lng = {{ !empty($event->longitude) ? $event->longitude : 'null' }};

      const center = hasCoords ? [lat, lng] : [9.5, -13.7]; // Guinée fallback
      const map = L.map('map', { scrollWheelZoom: false }).setView(center, hasCoords ? 12 : 6);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ attribution: '' }).addTo(map);
      if (hasCoords) {
        const m = L.marker([lat, lng]).addTo(map);
        m.bindPopup(`<strong>{{ addslashes($title ?? '') }}</strong><br><small>{{ addslashes($event->location ?? '') }}</small>`);
      }
      mapInited = true;
      setTimeout(() => map.invalidateSize(), 120);
    }

    toggleBtn?.addEventListener('click', () => {
      wrap.classList.toggle('hidden');
      toggleBtn.innerHTML = wrap.classList.contains('hidden')
        ? '<i class="ri-map-2-line"></i> Afficher'
        : '<i class="ri-close-line"></i> Masquer';
      if (!wrap.classList.contains('hidden')) initMap();
    });
    closeBtn?.addEventListener('click', () => {
      wrap.classList.add('hidden');
      toggleBtn.innerHTML = '<i class="ri-map-2-line"></i> Afficher';
    });

    // Countdown
    @if($hasCountdown && $countdownTs)
      const ts = {{ $countdownTs }} * 1000;
      const el = document.getElementById('countdown');
      function tick(){
        const now = Date.now();
        let diff = Math.max(0, ts - now);
        const d = Math.floor(diff / (24*3600e3)); diff -= d*24*3600e3;
        const h = Math.floor(diff / 3600e3);      diff -= h*3600e3;
        const m = Math.floor(diff / 60e3);        diff -= m*60e3;
        const s = Math.floor(diff / 1e3);
        el.textContent = `${d}j ${h}h ${m}m ${s}s`;
      }
      tick(); setInterval(tick, 1000);
    @endif
  });
</script>
@endsection
