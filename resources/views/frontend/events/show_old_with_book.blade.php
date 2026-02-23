@extends('frontend.layouts.master')
@section('title') {{ $event->name ?? 'Détails Événement' }} @endsection

@php
    use Illuminate\Database\Eloquent\Collection as EloquentCollection;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\URL;

    // Helpers + données une seule fois
    $placeholder = asset('assets/front/images/danse-tradi.jpg');

    $categoryNameOf = function ($event) {
        $rel = $event->category ?? null;
        if ($rel instanceof EloquentCollection) return optional($rel->first())->name;
        return optional($rel)->name;
    };


    $coverImageOf = function ($event) use ($placeholder) {
        if (method_exists($event, 'getFirstMediaUrl')) {

            $url = $event->getFirstMediaUrl('events', 'og')
                ?: $event->getFirstMediaUrl('events')
                ?: $event->getFirstMediaUrl('gallery', 'og')
                ?: $event->getFirstMediaUrl('gallery');


            if ($url) return $url;
        }
        if (!empty($event->image)) return asset('storage/' . ltrim($event->image, '/'));
        return $placeholder;
    };

    $galleryOf = function ($event) use ($placeholder) {
        $urls = [];
        if (method_exists($event, 'getMedia')) {
            $media = $event->getMedia('events');
            if ($media->isEmpty()) $media = $event->getMedia('gallery');
            foreach ($media as $m) {
                $urls[] = $m->hasGeneratedConversion('preview') ? $m->getUrl('preview') : $m->getUrl();
            }
        }
        if (empty($urls) && !empty($event->image)) $urls[] = asset('storage/' . ltrim($event->image, '/'));
        if (empty($urls)) $urls[] = $placeholder;
        return $urls;
    };

    $viewsOf = function ($event) {
        if (is_numeric($event->views ?? null)) return (int) $event->views;
        if (isset($event->views_count) && is_numeric($event->views_count)) return (int) $event->views_count;
        if (method_exists($event, 'views')) return (int) $event->views()->count();
        return 0;
    };

    $short = function ($n) {
        $n = (int) ($n ?? 0);
        if ($n >= 1_000_000) return rtrim(rtrim(number_format($n/1_000_000, 1), '0'), '.') . 'M';
        if ($n >= 1_000)     return rtrim(rtrim(number_format($n/1_000, 1), '0'), '.') . 'k';
        return number_format($n, 0, ',', ' ');
    };

    $dateRange = function ($event) {
        $start = $event->start_date;
        $end   = $event->end_date;
        if ($start && $end) {
            $sameMonth = $start->format('mY') === $end->format('mY');
            return $sameMonth
                ? $start->translatedFormat('d') . '–' . $end->translatedFormat('d M Y')
                : $start->translatedFormat('d M Y') . ' — ' . $end->translatedFormat('d M Y');
        }
        return $start ? $start->translatedFormat('d M Y') : '';
    };

    $title     = $event->title ?? $event->name;
    $coverUrl  = $coverImageOf($event);
    $gallery   = $galleryOf($event);
    $category  = $categoryNameOf($event);
    $views     = $viewsOf($event);
    $dateText  = $dateRange($event);
    $country   = optional($event->country)->name;
    $language  = optional($event->language)->name;

    // ---- META PARTAGE ----
    $descRaw = $event->description ?? '';
    $ogDesc  = Str::limit(trim(strip_tags($descRaw)), 160);
    $ogImage = Str::startsWith($coverUrl, ['http://','https://']) ? $coverUrl : URL::to($coverUrl);
@endphp

{{-- Injecte dans le master --}}
@section('og_title', $title)
@section('og_desc',  $ogDesc)
@section('og_image', $ogImage)
@section('og_image_alt', $title)

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
{{-- ===== HERO ===== --}}
<section class="relative isolate overflow-hidden">
  <div class="relative w-full h-[44vh] md:h-[56vh] flex items-center justify-center text-center">
    <img src="{{ $coverUrl ?? $placeholder }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-black/75 via-black/40 to-black/60"></div>

    <div class="relative z-10 max-w-5xl px-6">
      <h1 class="text-white text-3xl md:text-5xl font-extrabold leading-tight">{{ $title }}</h1>
      <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-white/90 text-sm">
        @if($category)
          <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
            <i class="ri-price-tag-3-line"></i> {{ $category }}
          </span>
        @endif
        @if($dateText)
          <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
            <i class="ri-calendar-line"></i> {{ $dateText }}
          </span>
        @endif
        @if($event->location)
          <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
            <i class="ri-map-pin-2-line"></i> {{ \Illuminate\Support\Str::limit($event->location, 80) }}
          </span>
        @endif
        <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
          <i class="ri-eye-line"></i> {{ $short($views) }} vues
        </span>
      </div>
      {{-- <div class="mt-5 flex items-center justify-center gap-2">
        <a href="#infos" class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 bg-white/10 hover:bg-white/20 text-white font-semibold border border-white/20 backdrop-blur transition">
          Voir les infos <i class="ri-arrow-down-line"></i>
        </a>
        @if($event->map_url)
          <a href="{{ $event->map_url }}" target="_blank" rel="noopener"
             class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 bg-[#579459] hover:bg-[#477a49] text-white font-semibold shadow transition">
            <i class="ri-map-pin-add-line"></i> Itinéraire
          </a>
        @endif
      </div>
    </div> --}}
  </div>
</section>

{{-- ===== CONTENU ===== --}}
<section id="infos" class="bg-white">
  <div class="max-w-7xl mx-auto px-5 py-8 grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-8">

    {{-- Colonne gauche : Description / Programme / Galerie / Vidéo --}}
    <div class="space-y-8">
      {{-- Description --}}
      @if($event->description)
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-5 md:p-6 shadow-sm">
          <h2 class="text-xl font-bold text-zinc-900 mb-3">{{ $title }}</h2>
          <div class="prose prose-zinc max-w-none">
            {!! nl2br(e($event->description)) !!}
          </div>
        </div>
      @endif

      {{-- Galerie --}}
      @if($gallery && count($gallery) > 0)
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-5 md:p-6 shadow-sm">
          <h2 class="text-xl font-bold text-zinc-900 mb-3">Galerie</h2>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @foreach($gallery as $i => $url)
              <button type="button"
                      class="group relative rounded-2xl overflow-hidden ring-1 ring-zinc-200 hover:ring-[#579459] transition"
                      onclick="openLightbox('{{ $url }}')">
                <img src="{{ $url }}" alt="Photo {{ $i+1 }} — {{ $title }}" class="w-full h-36 sm:h-40 object-cover group-hover:scale-105 transition">
                <span class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></span>
              </button>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Vidéo (YouTube/Vimeo/url direct) --}}
      @if($event->video_url)
        <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-5 md:p-6 shadow-sm">
          <h2 class="text-xl font-bold text-zinc-900 mb-3">Vidéo</h2>
          <div class="aspect-video rounded-2xl overflow-hidden ring-1 ring-zinc-200">
            <iframe src="{{ $event->video_url }}" allowfullscreen class="w-full h-full"></iframe>
          </div>
        </div>
      @endif
    </div>

    {{-- Colonne droite : Carte / Infos pratiques / Liens --}}
    <div class="space-y-8">
      {{-- Carte (repliable) --}}
      <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-5 md:p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <h2 class="text-xl font-bold text-zinc-900">Localisation</h2>
          <button id="toggleMap"
                  class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-white text-zinc-800 font-medium ring-1 ring-zinc-200 hover:bg-zinc-50 shadow-sm">
            <i class="ri-map-2-line"></i> Afficher la carte
          </button>
        </div>
        <p class="mt-2 text-sm text-zinc-600">
          {{ $event->map_description ?: $event->location }}
        </p>

        <div id="mapWrap" class="mt-4 hidden">
          <div class="relative rounded-2xl overflow-hidden ring-1 ring-zinc-200">
            <div id="map" class="w-full h-[340px]"></div>
            <button id="closeMap"
                    class="absolute top-3 right-3 bg-white/95 px-3 py-1.5 rounded-full text-sm ring-1 ring-zinc-200 shadow hover:bg-white">
              Fermer
            </button>
          </div>
          {{-- Leaflet assets (si non inclus ailleurs) --}}
          <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
          <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        </div>

        @if($event->map_url)
          <a href="{{ $event->map_url }}" target="_blank" rel="noopener"
             class="mt-3 inline-flex items-center gap-2 rounded-xl px-3 py-1.5 bg-[#579459] hover:bg-[#477a49] text-white font-semibold shadow">
            <i class="ri-external-link-line"></i> Ouvrir dans Maps
          </a>
        @endif
      </div>


      {{-- Infos pratiques --}}
      <div class="rounded-3xl ring-1 ring-zinc-200/70 bg-white p-5 md:p-6 shadow-sm">
        <h2 class="text-xl font-bold text-zinc-900 mb-3">Infos pratiques</h2>
        <ul class="space-y-3 text-sm text-zinc-700">
          @if($dateText)
            <li class="flex items-center gap-3">
              <i class="ri-calendar-event-line text-[#579459] text-lg"></i>
              <span>{{ $dateText }}</span>
            </li>
          @endif
          @if($event->location)
            <li class="flex items-center gap-3">
              <i class="ri-map-pin-line text-[#579459] text-lg"></i>
              <span>{{ $event->location }}</span>
            </li>
          @endif
          
          @if($country)
            <li class="flex items-center gap-3">
              <i class="ri-flag-line text-[#579459] text-lg"></i>
              <span>Pays : {{ $country }}</span>
            </li>
          @endif

          <li class="flex items-center gap-3">
            <i class="ri-eye-line text-[#579459] text-lg"></i>
            <span>{{ $short($views) }} vues</span>
          </li>
        </ul>

        {{-- Boutons d'action --}}
        <div class="mt-5 flex items-center gap-2">

            @php
                use Illuminate\Support\Carbon;

                $isPaid      = ($event->price ?? 0) > 0 || optional($event->tickets)->min('price') > 0;
                $salesOpen   = $event->sales_open ?? true;
                $hasCapacity = isset($event->capacity) ? ($event->remaining() > 0) : true;
                $soldOut     = isset($event->capacity) && $event->remaining() <= 0;

                // ---- fin d'événement
                $endRaw = $event->end_end ?? $event->end_at ?? $event->ends_at ?? $event->end_date ?? $event->end ?? null;
                $endAt  = $endRaw
                    ? ($endRaw instanceof \Illuminate\Support\Carbon ? $endRaw : Carbon::parse($endRaw))
                    : null;
                if ($endAt && is_string($endRaw) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($endRaw))) {
                    $endAt = $endAt->endOfDay();
                }
                $eventEnded = $endAt ? now()->greaterThan($endAt) : false;

                $ctaHref  = route('booking', ['type'=>'event','slug'=>$event->slug]);

                if ($eventEnded) {
                    $ctaLabel = 'Terminé';
                    $ctaIcon  = 'ri-calendar-close-line';
                } elseif ($soldOut) {
                    $ctaLabel = 'Rejoindre la liste d’attente';
                    $ctaIcon  = 'ri-time-line';
                } elseif ($isPaid && $salesOpen) {
                    $ctaLabel = 'Acheter mon billet';
                    $ctaIcon  = 'ri-ticket-line';
                } elseif ($hasCapacity) {
                    $ctaLabel = 'Réserver';
                    $ctaIcon  = 'ri-calendar-check-line';
                } else {
                    $ctaLabel = 'Réserver';
                    $ctaIcon  = 'ri-check-line';
                }
            @endphp

            <a href="{{ route('events.index') }}" class="inline-flex w-1/2 sm:w-auto items-center gap-2 rounded-xl px-3 py-1.5 bg-white text-zinc-800 font-medium ring-1 ring-zinc-200 hover:bg-zinc-50 shadow-sm">
                <i class="ri-arrow-left-line"></i> <span class="truncate">Voir tout</span>
            </a>

            @if(!$eventEnded)
                <a href="{{ $ctaHref }}"
                    class="inline-flex items-center w-1/2 sm:w-auto gap-2 rounded-xl px-3 py-1.5 bg-[#e67e22] hover:bg-[#c56613] text-white font-semibold shadow">
                    <i class="{{ $ctaIcon }}"></i> <span class="truncate">{{ $ctaLabel }}</span>
                </a>
            @else
                <span class="inline-flex  w-1/2 sm:w-auto items-center gap-2 rounded-xl px-3 py-1.5 bg-zinc-300 text-zinc-600 font-semibold shadow cursor-not-allowed select-none"
                        aria-disabled="true" role="status" title="Cet événement est terminé">
                    <i class="{{ $ctaIcon }}"></i> <span class="truncate">{{ $ctaLabel }}</span>
                </span>
            @endif


        </div>
      </div>

      {{-- Avis (optionnel) --}}
      @php
        $avg = round($event->reviews()->avg('rating') ?? 0, 1);
        $cnt = $event->reviews()->count();
        $lastReviews = $event->reviews()->latest()->take(3)->get();
      @endphp


    </div>
  </div>
</section>

{{-- ===== Lightbox minimaliste ===== --}}
<div id="lb" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
  <button onclick="closeLightbox()" class="absolute top-4 right-4 bg-white/95 px-3 py-1.5 rounded-full text-sm ring-1 ring-zinc-200 shadow hover:bg-white">
    Fermer
  </button>
  <img id="lbImg" src="" alt="Image" class="max-w-[92vw] max-h-[86vh] rounded-xl ring-1 ring-white/10 shadow-2xl object-contain">
</div>

<style>
  /* Cache la scrollbar sur mobile pour un rendu clean */
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- ===== JS ===== --}}
<script>
  // Lightbox
  function openLightbox(url){ const w = document.getElementById('lb'); const i = document.getElementById('lbImg'); i.src = url; w.classList.remove('hidden'); w.classList.add('flex'); }
  function closeLightbox(){ const w = document.getElementById('lb'); const i = document.getElementById('lbImg'); i.src=''; w.classList.add('hidden'); w.classList.remove('flex'); }

  // Carte repliable
  document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleMap');
    const wrap      = document.getElementById('mapWrap');
    const closeBtn  = document.getElementById('closeMap');

    let mapInited = false;
    const initMap = () => {
      if (mapInited) return;
      if (typeof L === 'undefined') return setTimeout(initMap, 80);

      const hasCoords = {{ $event->latitude && $event->longitude ? 'true' : 'false' }};
      const lat = {{ $event->latitude  ?: 'null' }};
      const lng = {{ $event->longitude ?: 'null' }};

      const center = hasCoords ? [lat, lng] : [9.5, -13.7]; // fallback Guinée
      const map = L.map('map', { scrollWheelZoom: false }).setView(center, hasCoords ? 12 : 6);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '' }).addTo(map);

      if (hasCoords) {
        const m = L.marker([lat, lng]).addTo(map);
        m.bindPopup(`<strong>{{ addslashes($title) }}</strong><br><small>{{ addslashes($event->location ?? '') }}</small>`);
      }
      mapInited = true;
      setTimeout(() => map.invalidateSize(), 120);
    };

    toggleBtn?.addEventListener('click', () => {
      wrap.classList.toggle('hidden');
      toggleBtn.innerHTML = wrap.classList.contains('hidden')
        ? '<i class="ri-map-2-line"></i> Afficher la carte'
        : '<i class="ri-close-line"></i> Masquer la carte';
      if (!wrap.classList.contains('hidden')) initMap();
    });

    closeBtn?.addEventListener('click', () => {
      wrap.classList.add('hidden');
      toggleBtn.innerHTML = '<i class="ri-map-2-line"></i> Afficher la carte';
    });
  });
</script>
@endsection
