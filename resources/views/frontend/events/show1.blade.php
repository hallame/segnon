{{-- resources/views/frontend/events/show.blade.php --}}
@extends('frontend.layouts.master')
@section('title') {{ $title ?? 'Événement' }} @endsection

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\URL;

    $placeholder = asset('assets/front/images/danse-tradi.jpg');

    // Couverture (Spatie -> image -> placeholder)
    $coverUrl = $placeholder;
    if (method_exists($event, 'getFirstMediaUrl')) {
        $u = $event->getFirstMediaUrl('events', 'og');
        if (!$u) $u = $event->getFirstMediaUrl('events');
        if (!$u) $u = $event->getFirstMediaUrl('gallery', 'og');
        if (!$u) $u = $event->getFirstMediaUrl('gallery');
        if ($u)   $coverUrl = $u;
    }
    if ($coverUrl === $placeholder && !empty($event->image)) {
        $coverUrl = asset('storage/'.ltrim($event->image,'/'));
    }

    // Galerie
    $gallery = [];
    if (method_exists($event, 'getMedia')) {
        $media = $event->getMedia('events');
        if ($media->isEmpty()) $media = $event->getMedia('gallery');
        foreach ($media as $m) {
            $gallery[] = $m->hasGeneratedConversion('preview') ? $m->getUrl('preview') : $m->getUrl();
        }
    }
    if (empty($gallery) && !empty($event->image)) {
        $gallery[] = asset('storage/'.ltrim($event->image,'/'));
    }
    if (empty($gallery)) $gallery[] = $placeholder;

    $viewsCount = is_numeric($event->views_count ?? null) ? (int)$event->views_count : 0;

    // Meta partage
    $descRaw = $event->description ?? '';
    $ogDesc  = Str::limit(trim(strip_tags($descRaw)), 160);
    $ogImage = Str::startsWith($coverUrl, ['http://','https://']) ? $coverUrl : URL::to($coverUrl);

    // Countdown (si l'event n'a pas commencé)
    $hasCountdown = false;
    $countdownTs  = null;
    if (!empty($event->start_date) && now()->lt($event->start_date)) {
        $hasCountdown = true;
        $countdownTs  = $event->start_date->timestamp;
    }
@endphp

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
{{-- ===================== HERO IMMERSIF ===================== --}}
<section class="relative overflow-hidden">
  {{-- BACKGROUND FX --}}
  <div class="absolute inset-0">
    <img src="{{ $coverUrl }}" alt="{{ $title }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/70"></div>
    {{-- blobs animés --}}
    <div class="absolute -top-24 -left-24 w-[360px] h-[360px] rounded-full bg-emerald-500/30 blur-[80px] animate-[float_10s_ease-in-out_infinite]"></div>
    <div class="absolute -bottom-24 -right-24 w-[360px] h-[360px] rounded-full bg-amber-400/30 blur-[90px] animate-[float_12s_ease-in-out_infinite_reverse]"></div>
  </div>

  <div class="relative z-10 max-w-6xl mx-auto px-5 pt-16 pb-10">
    <div class="flex flex-col lg:flex-row lg:items-end gap-6">
      <div class="flex-1">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 text-white/90 text-xs backdrop-blur">
          @if(!empty($categoryName)) <span class="truncate">{{ $categoryName }}</span> @endif
          @if(!empty($languageName)) <span>• {{ $languageName }}</span> @endif
          @if(!empty($countryName))  <span>• {{ $countryName }}</span> @endif
        </div>

        <h1 class="text-white text-3xl sm:text-5xl font-extrabold leading-tight mt-3">{{ $title }}</h1>

        <div class="mt-3 flex flex-wrap items-center gap-3 text-white/90">
          @if(!empty($dateText))
            <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
              <i class="ri-calendar-line"></i> {{ $dateText }}
            </span>
          @endif

          @if(!empty($event->location))
            <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
              <i class="ri-map-pin-2-line"></i> {{ Str::limit($event->location, 80) }}
            </span>
          @endif

          <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
            <i class="ri-eye-line"></i> {{ number_format($viewsCount, 0, ',', ' ') }} vues
          </span>
        </div>
      </div>

      <div class="w-full lg:w-auto">
        <div class="backdrop-blur bg-white/10 border border-white/20 rounded-2xl p-4 text-white shadow-2xl">
          <div class="text-xs uppercase tracking-wide opacity-80">À partir de</div>
          <div class="text-3xl font-extrabold leading-none">
            @if(!is_null($minPrice))
              {{ number_format($minPrice, 0, ',', ' ') }} <span class="text-base font-bold">GNF</span>
            @else
              Gratuit
            @endif
          </div>

          @if(!$eventEnded)
            <a href="{{ route('events.buy', $event) }}"
               class="mt-3 inline-flex items-center justify-center gap-2 w-full rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-4 py-2 transition">
              <i class="ri-ticket-2-line"></i> Acheter mon billet
            </a>
          @else
            <div class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gray-400 text-white font-semibold px-4 py-2">
              <i class="ri-calendar-close-line"></i> Événement terminé
            </div>
          @endif

          @if($hasCountdown)
            <div class="mt-3 text-center">
              <div class="text-xs opacity-80">Débute dans</div>
              <div id="countdown" class="font-bold text-lg tracking-wider">—</div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===================== SECTION PRINCIPALE ===================== --}}
<section class="bg-white">
  <div class="max-w-6xl mx-auto px-5 py-10 grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- ===== Colonne gauche ===== --}}
    <div class="space-y-8">
        {{-- Description / Programme --}}
        @if(!empty($event->description))
            <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-zinc-900 mb-3">À propos</h2>
            <div class="prose prose-zinc max-w-none">
                {!! nl2br(e($event->description)) !!}
            </div>
            </div>
        @endif

         {{-- Localisation repliable --}}
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
      <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-zinc-900 mb-3">Actions</h2>
        <div class="flex flex-wrap gap-2">
          <a href="{{ route('events.buy', $event) }}"
             class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">
            <i class="ri-shopping-cart-2-line"></i> Acheter mon billet
          </a>
          <button type="button" onclick="shareEvent()"
             class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-white ring-1 ring-zinc-200 hover:bg-zinc-50 font-semibold">
            <i class="ri-share-line"></i> Partager
          </button>

        </div>
      </div>

        {{-- Galerie --}}
        @if(!empty($gallery))
            <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-zinc-900 mb-3">Galerie</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($gallery as $i => $url)
                <button type="button" onclick="openLightbox('{{ $url }}')"
                    class="group relative rounded-2xl overflow-hidden ring-1 ring-zinc-200 hover:ring-emerald-500 transition">
                    <img src="{{ $url }}" alt="Photo {{ $i+1 }} — {{ $title }}" class="w-full h-36 sm:h-40 object-cover group-hover:scale-105 transition">
                    <span class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></span>
                </button>
                @endforeach
            </div>
            </div>
        @endif

        {{-- Pourquoi venir ? (USP) --}}
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-zinc-900 mb-4">Pourquoi venir ?</h2>
            <div class="grid sm:grid-cols-3 gap-4">
            <div class="rounded-2xl border p-4">
                <div class="text-emerald-700 font-semibold">Ambiance</div>
                <p class="text-sm text-zinc-600 mt-1">Une expérience immersive avec musique, danse, et rencontres.</p>
            </div>
            <div class="rounded-2xl border p-4">
                <div class="text-emerald-700 font-semibold">Découverte</div>
                <p class="text-sm text-zinc-600 mt-1">Célébrez les cultures locales, gastronomie et artisanat.</p>
            </div>
            <div class="rounded-2xl border p-4">
                <div class="text-emerald-700 font-semibold">Moments forts</div>
                <p class="text-sm text-zinc-600 mt-1">Showcases, ateliers, et souvenirs uniques à partager.</p>
            </div>
            </div>
        </div>
    </div>

    {{-- ===== Colonne droite ===== --}}
    <div class="space-y-8">


       {{-- Tiers de billets (si types actifs) --}}
      @if($types->isNotEmpty())
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-zinc-900">Billets & formules</h2>
                <a href="{{ route('events.buy', $event) }}" class="text-emerald-700 hover:text-emerald-900 font-semibold text-sm">
                    Voir toutes les options →
                </a>
            </div>

            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($types->take(3) as $t)
                    @php
                        $feat = $t->features;
                        if (is_string($feat)) {
                            $dec = json_decode($feat, true);
                            if (is_array($dec))      $feat = $dec;
                            elseif (trim($feat) !== '') $feat = [$feat];
                            else                     $feat = [];
                        }
                        if (!is_array($feat)) $feat = [];

                        $canBuyThis = true;
                        $now = now();
                        if (!empty($t->sales_start) && $now->lt($t->sales_start)) $canBuyThis = false;
                        if (!empty($t->sales_end)   && $now->gt($t->sales_end))   $canBuyThis = false;

                        $badgeLabel = $loop->first ? 'Meilleur choix' : null;
                    @endphp

                    <div class="relative group rounded-3xl border border-zinc-200/80 bg-gradient-to-br from-white to-zinc-50/60 p-5 hover:shadow-md hover:border-emerald-500/70 transition">
                        @if($badgeLabel)
                            <span class="absolute -top-2 left-4 inline-flex items-center gap-1 rounded-full bg-emerald-600 text-white text-[11px] font-semibold px-2.5 py-1 shadow-sm">
                                <i class="ri-star-smile-line text-xs"></i> {{ $badgeLabel }}
                            </span>
                        @endif

                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-[11px] uppercase tracking-wide text-zinc-500">Formule</p>
                                <h3 class="text-lg font-semibold text-zinc-900 leading-snug">
                                    {{ \Illuminate\Support\Str::limit($t->name, 40) }}
                                </h3>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] uppercase tracking-wide text-zinc-500">À partir de</p>
                                <p class="text-2xl font-extrabold text-zinc-900 leading-none">
                                    {{ number_format($t->price, 0, ',', ' ') }}
                                    <span class="text-xs font-semibold">GNF</span>
                                </p>
                                @if(!is_null($t->quantity))
                                    <p class="text-[11px] text-amber-600 mt-1">
                                        {{ max(0, (int)$t->quantity) }} places prévues
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

                        <a href="{{ route('events.buy', $event) }}?type={{ $t->id }}"
                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white
                                @if($canBuyThis)
                                    bg-emerald-600 hover:bg-emerald-700
                                @else
                                    bg-zinc-400 cursor-not-allowed
                                @endif">
                            <i class="ri-ticket-2-line"></i>
                            <span>Choisir ce billet</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


      {{-- Événements similaires --}}
      {{-- @if($related->isNotEmpty())
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-6 shadow-sm">
          <h2 class="text-xl font-bold text-zinc-900 mb-4">Événements similaires</h2>
          <div class="grid gap-4">
            @foreach($related as $ev)
              @php
                $thumb = $placeholder;
                if (method_exists($ev, 'getFirstMediaUrl')) {
                    $u2 = $ev->getFirstMediaUrl('events','preview');
                    if (!$u2) $u2 = $ev->getFirstMediaUrl('events');
                    if ($u2)  $thumb = $u2;
                }
                if ($thumb === $placeholder && !empty($ev->image)) {
                    $thumb = asset('storage/'.ltrim($ev->image,'/'));
                }
              @endphp
              <a href="{{ route('events.show', $ev) }}" class="flex gap-3 rounded-2xl border p-3 hover:shadow-sm transition">
                <img src="{{ $thumb }}" alt="{{ $ev->name }}" class="w-20 h-20 rounded-xl object-cover">
                <div class="flex-1">
                  <div class="font-semibold">{{ $ev->name }}</div>
                  @if(!empty($ev->start_date))
                    <div class="text-xs text-zinc-600">{{ $ev->start_date->translatedFormat('d M Y') }}</div>
                  @endif
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif --}}
    </div>

  </div>
</section>

{{-- LIGHTBOX --}}
<div id="lb" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
  <button onclick="closeLightbox()" class="absolute top-4 right-4 bg-white/95 px-3 py-1.5 rounded-full text-sm ring-1 ring-zinc-200 shadow hover:bg-white">Fermer</button>
  <img id="lbImg" src="" alt="Image" class="max-w-[92vw] max-h-[86vh] rounded-xl ring-1 ring-white/10 shadow-2xl object-contain">
</div>

<style>
@keyframes float { 0%,100%{ transform:translateY(0) } 50%{ transform:translateY(-16px) } }
</style>

{{-- JS --}}
<script>
  // Lightbox
  function openLightbox(url){
    const w=document.getElementById('lb'), i=document.getElementById('lbImg');
    i.src=url; w.classList.remove('hidden'); w.classList.add('flex');
  }
  function closeLightbox(){
    const w=document.getElementById('lb'), i=document.getElementById('lbImg');
    i.src=''; w.classList.add('hidden'); w.classList.remove('flex');
  }

  // Share
  function shareEvent(){
    if (navigator.share) {
      navigator.share({ title: @json($title ?? 'Événement'), url: window.location.href });
    } else {
      navigator.clipboard.writeText(window.location.href);
      alert('Lien copié !');
    }
  }

  // Map repliable
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
