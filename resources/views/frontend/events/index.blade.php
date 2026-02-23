{{-- resources/views/frontend/events/index.blade.php --}}
@extends('frontend.layouts.master')
@section('title') Événements @endsection

@section('content')
@php
    use Illuminate\Database\Eloquent\Collection as EloquentCollection;

    // ==== Helpers robustes ====
    $heroImage = asset('assets/front/images/guine.jpg');
    $placeholder = asset('assets/front/images/danse-tradi.jpg');
    $activeCategory = request('category');

    // Récup nom de catégorie même si la relation "category" renvoie une Collection
    $categoryNameOf = function ($event) {
        $rel = $event->category ?? null;
        if ($rel instanceof EloquentCollection) return optional($rel->first())->name;
        return optional($rel)->name;
    };

    // Image: Spatie (collection "events" / "gallery" avec conversion "preview" / "thumb"), puis champ image, puis placeholder
    $imageOf = function ($event) use ($placeholder) {
        $url = '';
        if (method_exists($event, 'getFirstMediaUrl')) {
            $url = $event->getFirstMediaUrl('events', 'preview')
                ?: $event->getFirstMediaUrl('events')
                ?: $event->getFirstMediaUrl('gallery', 'preview')
                ?: $event->getFirstMediaUrl('gallery');
        }
        if (!$url && $event->image) $url = asset('storage/' . ltrim($event->image, '/'));
        return $url ?: $placeholder;
    };

    // Vues: colonne int -> ok, withCount('views') -> ok, sinon count() (fallback)
    $viewsOf = function ($event) {
        if (is_numeric($event->views ?? null)) return (int) $event->views;
        if (isset($event->views_count) && is_numeric($event->views_count)) return (int) $event->views_count;
        if (method_exists($event, 'views')) return (int) $event->views()->count();
        return 0;
    };

    // Format court 1.2k / 3.4M
    $short = function ($n) {
        $n = (int) ($n ?? 0);
        if ($n >= 1_000_000) return rtrim(rtrim(number_format($n/1_000_000, 1), '0'), '.') . 'M';
        if ($n >= 1_000)     return rtrim(rtrim(number_format($n/1_000, 1), '0'), '.') . 'k';
        return number_format($n, 0, ',', ' ');
    };

    // Texte date : "12 févr. 2026" ou "12–14 févr. 2026"
    $dateText = function ($event) {
        $start = $event->start_date;
        $end   = $event->end_date;

        if ($start && $end) {
            $sameMonth = $start->format('mY') === $end->format('mY');
            if ($sameMonth) {
                return $start->translatedFormat('d') . '–' . $end->translatedFormat('d M Y');
            }
            return $start->translatedFormat('d M Y') . ' — ' . $end->translatedFormat('d M Y');
        }
        if ($start) return $start->translatedFormat('d M Y');
        return '';
    };

    // Catégories disponibles (à partir des events)
    $eventCategories = $events->map(fn($e) => $categoryNameOf($e))
        ->filter()->unique()->values();

    // Filtrage initial par catégorie (?category=)
    $filtered = $activeCategory
        ? $events->filter(fn($e) => $categoryNameOf($e) === $activeCategory)
        : $events;

    $totalEvents = $events->count();
    $totalViews  = $events->sum(fn($e) => $viewsOf($e));
@endphp

{{-- ===== HERO ===== --}}
<section class="relative isolate overflow-hidden">
  <div class="relative w-full h-[42vh] md:h-[52vh] flex items-center justify-center text-center">
    <img src="{{ $heroImage }}" alt="Événements" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/35 to-black/60"></div>

    <div class="relative z-10 max-w-3xl px-6">
      <h1 class="text-white text-3xl md:text-5xl font-extrabold uppercase tracking-tight">
        Événements
      </h1>
      <p class="mt-3 text-white/90 text-sm md:text-lg">
        Restez informé des grands rendez-vous culturels, artistiques et touristiques de la région.
      </p>
      <div class="mt-5 flex items-center justify-center gap-2 text-white/90 text-sm">
        <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
          <i class="ri-calendar-event-line"></i> {{ $totalEvents }} événements
        </span>
        <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 backdrop-blur">
          <i class="ri-eye-line"></i> {{ $short($totalViews) }} vues
        </span>
      </div>
    </div>
  </div>
</section>

{{-- ===== Barre outils : recherche + tri + catégories (responsive) ===== --}}
<section class="bg-white">
  <div class="max-w-7xl mx-auto px-5 py-6 rounded-3xl ring-1 ring-zinc-200/70 bg-white shadow-sm">

    <div class="flex flex-col md:flex-row md:items-center gap-4">
      {{-- Recherche --}}
      <div class="relative flex-1">
        <input id="searchInput" type="text" placeholder="Rechercher un événement ou une localité…"
               class="w-full rounded-2xl border border-zinc-200 bg-white/60 px-4 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-emerald-300">
        <i class="ri-search-line absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400"></i>
      </div>

      {{-- Tri --}}
      <div>
        <select id="sortSelect"
                class="rounded-2xl border border-zinc-200 px-3 py-2 bg-white/60 focus:outline-none focus:ring-2 focus:ring-emerald-300">
          <option value="soonest">Bientôt</option>
          <option value="name_asc">A → Z</option>
          <option value="name_desc">Z → A</option>
          <option value="views_desc">+ vues</option>
        </select>
      </div>
    </div>

    {{-- Catégories (scroll horizontal mobile + wrap desktop) --}}
    <div class="mt-4 relative">
      <div class="pointer-events-none absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-white to-transparent sm:hidden"></div>
      <div class="pointer-events-none absolute inset-y-0 right-0 w-8 bg-gradient-to-l from-white to-transparent sm:hidden"></div>

      {{-- <button id="catPrev"
              class="sm:hidden absolute left-1 top-1/2 -translate-y-1/2 z-10 grid place-items-center h-8 w-8 rounded-full bg-white ring-1 ring-zinc-200 shadow hover:bg-zinc-50"
              type="button" aria-label="Catégories précédentes">
        <i class="ri-arrow-left-s-line"></i>
      </button>
      <button id="catNext"
              class="sm:hidden absolute right-1 top-1/2 -translate-y-1/2 z-10 grid place-items-center h-8 w-8 rounded-full bg-white ring-1 ring-zinc-200 shadow hover:bg-zinc-50"
              type="button" aria-label="Catégories suivantes">
        <i class="ri-arrow-right-s-line"></i>
      </button> --}}

      <div id="catScroll"
           class="flex items-center gap-2 overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap sm:overflow-visible scroll-px-4 snap-x snap-mandatory">
        <a href="{{ route('events.index') }}"
           class="shrink-0 snap-start px-3 py-1.5 rounded-full text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-300
                  {{ $activeCategory ? 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200' : 'bg-[#579459] text-white hover:bg-[#477a49]' }}">
          Tout ({{ $totalEvents }})
        </a>
        @foreach ($eventCategories as $cat)
          @php $selected = $activeCategory === $cat; @endphp
          <a href="{{ route('events.index') }}?category={{ urlencode($cat) }}"
             class="shrink-0 snap-start px-3 py-1.5 rounded-full text-sm font-medium transition border focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-300
                    {{ $selected
                        ? 'bg-[#579459] text-white border-[#579459] hover:bg-[#477a49]'
                        : 'bg-white text-zinc-700 border-zinc-200 hover:bg-zinc-50' }}">
            {{ $cat }}
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- ===== Cards Événements ===== --}}
<section class="bg-white py-8">
  <div class="max-w-7xl mx-auto px-5">
    @php $list = $filtered->values(); @endphp

    <div id="eventGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse ($list as $event)
        @php
          $img     = $imageOf($event);
          $catName = $categoryNameOf($event);
          $views   = $viewsOf($event);
          $dateStr = $dateText($event);
          $startISO = optional($event->start_date)->format('Y-m-d') ?: '';
        @endphp

        <a href="{{ route('events.show', $event) }}"
           class="event-card group relative block rounded-3xl overflow-hidden bg-white ring-1 ring-zinc-200/70 shadow hover:shadow-2xl transition"
           data-name="{{ strtolower($event->title ?? $event->name ?? '') }}"
           data-location="{{ strtolower($event->location ?? '') }}"
           data-views="{{ $views }}"
           data-date="{{ $startISO }}">
          <div class="relative h-56">
            <img src="{{ $img }}" alt="Affiche — {{ $event->title ?? $event->name }}"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                 loading="lazy" decoding="async">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

            {{-- Catégorie --}}
            @if($catName)
              <span class="absolute top-3 left-3 rounded-full bg-white/90 text-zinc-800 text-xs font-semibold px-3 py-1 ring-1 ring-white/70 backdrop-blur">
                <i class="ri-price-tag-3-line mr-1"></i>{{ $catName }}
              </span>
            @endif

            {{-- Vues --}}
            <span class="absolute top-3 right-3 rounded-full bg-black/55 text-white text-xs font-semibold px-3 py-1 backdrop-blur-sm">
              <i class="ri-eye-line mr-1"></i>{{ $short($views) }}
            </span>

            {{-- Date badge --}}
            @if($dateStr)
              <span class="absolute bottom-3 left-3 rounded-xl bg-white/95 text-zinc-800 text-xs font-semibold px-3 py-1 ring-1 ring-zinc-200 shadow">
                <i class="ri-calendar-line mr-1"></i>{{ $dateStr }}
              </span>
            @endif
          </div>

          <div class="p-4">
            <h3 class="text-lg md:text-xl font-semibold text-zinc-900 line-clamp-2">
              {{ $event->title ?? $event->name }}
            </h3>
            @if($event->location)
              <div class="mt-1 text-sm text-zinc-600 inline-flex items-center gap-1">
                <i class="ri-map-pin-2-line"></i> {{ \Illuminate\Support\Str::limit($event->location, 70) }}
              </div>
            @endif
            @if($event->description)
              <p class="mt-3 text-sm text-zinc-600 line-clamp-3">
                {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 150) }}
              </p>
            @endif

            <div class="mt-4 flex items-center justify-between">
              <span class="inline-flex items-center gap-1 text-[#579459] font-semibold">
                Voir détails <i class="ri-arrow-right-line"></i>
              </span>
              {{-- Note moyenne si tu veux (optionnel, peut être coûteux sans eager) --}}
              @php
                // $avg = round($event->reviews()->avg('rating') ?? 0, 1);
                // $cnt = $event->reviews()->count();
              @endphp
              {{-- <span class="text-xs text-amber-600 font-medium">★ {{ $avg }} ({{ $cnt }})</span> --}}
            </div>
          </div>
        </a>
      @empty
        <div class="col-span-full text-center text-zinc-500 py-16">
          Aucun événement trouvé.
        </div>
      @endforelse
    </div>
  </div>
</section>


{{-- COMMISSIONS / MODÈLES --}}
<section class="relative bg-[#0f1f12] text-white py-8">
  <div class="pointer-events-none absolute inset-0 opacity-30" aria-hidden="true">
    <div class="absolute top-16 right-24 w-44 h-44 rounded-full bg-emerald-500/20 blur-2xl"></div>
  </div>
  <div class="relative max-w-7xl mx-auto px-6">
    <div class="max-w-3xl mb-8">
      <p class="text-sm uppercase tracking-widest text-emerald-200/80">Transparence</p>
      <h2 class="text-2xl md:text-3xl font-extrabold">Un modèle simple & sécurisé</h2>
      <p class="mt-2 text-white/80">Pas de frais d'inscription. Commissions adaptées et tarifs exacts fournis.</p>
    </div>
    @php
      $plans = [
        ["t"=>"Réservations hôtel", "m"=>"hotel", "p"=>"Commission sur chaque réservation validée","b"=>["Sans frais d'installation","Gestion des reçus & paiements","Annulations "]],
        ["t"=>"Ventes e‑commerce", "m"=>"shop", "p"=>"Commission par commande payée","b"=>["Produits simples & variables","Stocks & coupons","Suivi des livraisons"]],
        ["t"=>"Prestations & billets", "m"=>"event", "p"=>"Commission par prestation ou billet scanné","b"=>["Agenda & disponibilités","QR de contrôle d’accès","Rapports de ventes"]],
        // ["t"=>"Ventes e‑commerce", "m"=>"shop", "p"=>"Commission par commande payée","b"=>["Produits simples & variables","Stocks & coupons","Suivi des livraisons"]],

      ];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($plans as $pl)
        <div class="rounded-3xl p-[1px] bg-gradient-to-br from-[#6BBE44] via-[#579459] to-[#e67e22]">
          <div class="h-full rounded-3xl bg-[#0f1f12] p-6 ring-1 ring-white/10">
            <h3 class="text-xl font-bold">{{ $pl['t'] }}</h3>
            {{-- <p class="mt-1 text-sm text-white/70">{{ $pl['p'] }}</p> --}}
            <ul class="mt-4 space-y-2 text-sm text-white/85">
              @foreach($pl['b'] as $b)
                <li class="flex items-start gap-2"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="#A7F3D0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>{{ $b }}</li>
              @endforeach
            </ul>
            <a href="{{ route('partners.register') }}?module={{ $pl['m'] }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white text-[#0f1f12] px-4 py-2 font-semibold hover:bg-white/90">Commencer</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== CSS util ===== --}}
<style>
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- ===== JS : recherche, tri, scroll cat ===== --}}
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Recherche
    const searchEl = document.getElementById('searchInput');
    const grid = document.getElementById('eventGrid');

    const filterCards = () => {
      const q = (searchEl?.value || '').trim().toLowerCase();
      const cards = Array.from(grid.children);
      cards.forEach(card => {
        const name = card.dataset.name || '';
        const loc  = card.dataset.location || '';
        card.style.display = (!q || name.includes(q) || loc.includes(q)) ? '' : 'none';
      });
    };
    searchEl?.addEventListener('input', filterCards);

    // Tri
    const sortEl = document.getElementById('sortSelect');
    const sortCards = () => {
      const mode = sortEl?.value;
      const cards = Array.from(grid.children);

      const getName  = el => el.dataset.name || '';
      const getViews = el => parseInt(el.dataset.views || '0', 10);
      const getDate  = el => el.dataset.date || '';

    //   if (mode === 'soonest') { // dates proches d'abord (vides à la fin)
    //     cards.sort((a,b) => {
    //       const da = getDate(a), db = getDate(b);
    //       if (!da && !db) return getName(a).localeCompare(getName(b));
    //       if (!da) return 1;
    //       if (!db) return -1;
    //       return da.localeCompare(db);
    //     });


        if (mode === 'soonest') {
            const today = new Date().toISOString().slice(0,10); // YYYY-MM-DD

            cards.sort((a, b) => {
                const da = a.dataset.date || '';
                const db = b.dataset.date || '';

                const aFuture = da >= today;
                const bFuture = db >= today;

                // Futurs avant passés
                if (aFuture && !bFuture) return -1;
                if (!aFuture && bFuture) return 1;

                // Deux futurs → plus proche d'abord
                if (aFuture && bFuture) return da.localeCompare(db);

                // Deux passés → plus récent d'abord
                if (!aFuture && !bFuture) return db.localeCompare(da);

                return 0;
            });
        };


      } else if (mode === 'name_asc') {
        cards.sort((a,b) => getName(a).localeCompare(getName(b)));
      } else if (mode === 'name_desc') {
        cards.sort((a,b) => getName(b).localeCompare(getName(a)));
      } else if (mode === 'views_desc') {
        cards.sort((a,b) => getViews(b) - getViews(a) || getName(a).localeCompare(getName(b)));
      }
      cards.forEach(el => grid.appendChild(el));
    };
    sortEl?.addEventListener('change', sortCards);
    sortCards(); // tri initial "Bientôt"

    // Catégories scroll mobile
    const scroller = document.getElementById('catScroll');
    const prevBtn  = document.getElementById('catPrev');
    const nextBtn  = document.getElementById('catNext');

    const updateArrows = () => {
      if (!scroller) return;
      const maxScroll = scroller.scrollWidth - scroller.clientWidth;
      prevBtn?.classList.toggle('hidden', scroller.scrollLeft <= 4);
      nextBtn?.classList.toggle('hidden', scroller.scrollLeft >= maxScroll - 4);
    };
    prevBtn?.addEventListener('click', () => scroller.scrollBy({ left: -240, behavior: 'smooth' }));
    nextBtn?.addEventListener('click', () => scroller.scrollBy({ left:  240, behavior: 'smooth' }));
    scroller?.addEventListener('scroll', updateArrows);
    window.addEventListener('resize', updateArrows);
    updateArrows();
  });
</script>
@endsection
