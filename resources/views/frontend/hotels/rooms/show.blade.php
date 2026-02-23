@extends('frontend.layouts.master')
@section('title', $room->name)

@php
    // Meta SEO
    $metaTitle = $room->meta_title ?: $room->name;
    $metaDescription = $room->meta_description ?: Str::limit(strip_tags($room->description ?? ''), 160);
    $metaUrl = url()->current();
    $mainImage = $mainUrl ?? asset('assets/front/images/hotel.jpg');

    // Disponibilité et prix si nécessaire
    $price = $room->price ?? null;
    $currency = $room->currency ?? 'GNF';
    $availability = ($room->is_available ?? true) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
@endphp

{{-- Injecte les meta dans le master --}}
@section('meta')
  @parent
  <meta name="description" content="{{ $metaDescription }}">
  <link rel="canonical" href="{{ $metaUrl }}">
  <meta name="robots" content="index,follow">

  <!-- Open Graph -->
  <meta property="og:site_name" content="{{ config('app.name') }}">
  <meta property="og:title" content="{{ $metaTitle }}">
  <meta property="og:description" content="{{ $metaDescription }}">
  <meta property="og:type" content="hotel">
  <meta property="og:url" content="{{ $metaUrl }}">
  <meta property="og:image" content="{{ $mainImage }}">
  <meta property="og:image:secure_url" content="{{ preg_replace('/^http:/','https:', $mainImage) }}">
  <meta property="og:image:alt" content="{{ $room->name }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $metaTitle }}">
  <meta name="twitter:description" content="{{ $metaDescription }}">
  <meta name="twitter:image" content="{{ $mainImage }}">
@endsection


@section('content')

<!-- Optionnel : cacher la barre de défilement sur mobile -->
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    #lightboxImage {
    animation: zoomIn .3s ease;
    }
    @keyframes zoomIn {
    from { opacity: 0; transform: scale(.95); }
    to { opacity: 1; transform: scale(1); }
    }
</style>

@php
    // Convertit un média (objet ou string) en URL absolue
    $toUrl = function ($item) {
        if (is_string($item)) {
            return Str::startsWith($item, ['http://', 'https://', '//'])
                ? $item
                : asset('storage/' . ltrim($item, '/'));
        }

        // Spatie Media object → on utilise chemin absolu
        return asset('storage/' . $item->getPathRelativeToRoot());
    };

    // Médias Spatie de la room
    $allMedia = collect($room->getMedia('gallery'));

    // Images d'abord
    $images = $allMedia
        ->filter(fn($media) => Str::startsWith($media->mime_type ?? '', 'image/'))
        ->map(fn($media) => $toUrl($media));

    // Vidéos ensuite
    $videos = $allMedia
        ->filter(fn($media) => Str::startsWith($media->mime_type ?? '', 'video/'))
        ->map(fn($media) => $toUrl($media));

    // Fusion des deux : images d’abord, vidéos ensuite
    $medias = $images->merge($videos)->values();

    // Fallback cover (champ $room->image ou image par défaut)
    $cover = $room->image
        ? asset('storage/' . ltrim($room->image, '/'))
        : asset('assets/front/images/hotel.jpg');

    // Placeholders si aucun média

    $placeholders = collect([
        asset('assets/front/images/hotel.webp'),
        asset('assets/front/images/hotel1.webp'),
        asset('assets/front/images/hotel3.jpg'),
        asset('assets/front/images/hotel4.jpg'),
        asset('assets/front/images/hotel5.jpg'),
    ]);

    // Si vide : on injecte cover + placeholders
    if ($medias->isEmpty()) {
        $medias = collect([$cover])->merge($placeholders)->values();
    } else {
        // Sinon, on ajoute la cover devant si pas déjà dans la liste
        if (!$medias->contains($cover)) {
            $medias->prepend($cover);
        }
    }

    // Répartition
    $mainUrl     = $medias->first();
    $rightTop    = $medias->last();
    $rightBottom = $medias->get((int) floor($medias->count() / 2));
    $thumbs      = $medias;
@endphp


<div class="md:max-w-7xl mx-auto py-10 px-4 md:px-6">
    <!-- Breadcrumb -->
    <div class="mx-auto py-3 px-4">
        <nav class="flex items-center text-sm text-gray-600 space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ route('hotels.index') }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
            <i class="fa-solid fa-hotel mr-1"></i> Hôtels
            </a>
            <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>
            <a href="{{ route('hotels.show', $room->hotel) }}" class="flex items-center hover:text-emerald-600 transition flex-shrink-0">
            <i class="fa-solid fa-building mr-1"></i>
            <span class="truncate max-w-[150px] md:max-w-none">{{ $room->hotel->name }}</span>
            </a>
            <i class="fa-solid fa-chevron-right text-gray-400 text-xs flex-shrink-0"></i>
            <span class="flex items-center text-emerald-600 font-semibold flex-shrink-0">
            <span class="truncate max-w-[150px] md:max-w-none">{{ $room->name }}</span>
            </span>
        </nav>
    </div>

    <!-- Hotel Header -->
    <div class="mx-auto py-6 border-b border-gray-100 px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <!-- Infos -->
            <div class="space-y-3">
            <!-- Titre + badge -->
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ $room->name }}</h1>
                <span class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-3 py-1 rounded-full text-xs md:text-sm font-semibold shadow">
                <i class="fa-solid fa-fire-flame-curved mr-1"></i> {{ $room->type }}
                </span>
            </div>

            <!-- Note + avis -->
            <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-sm">
                <div class="flex items-center">
                <i class="fa-solid fa-star text-amber-500"></i>
                <i class="fa-solid fa-star text-amber-500"></i>
                <i class="fa-solid fa-star text-amber-500"></i>
                <i class="fa-solid fa-star text-amber-500"></i>
                <i class="fa-solid fa-star text-amber-500"></i>
                <span class="ml-2 text-gray-700">Hôtel 5 étoiles</span>
                </div>

                <div class="hidden md:block text-gray-300">|</div>

                {{-- <div class="flex items-center">
                    <span class="font-semibold text-gray-900 mr-1">{{ $room->average_rating; }}</span>
                    <span class="text-gray-600">({{ $room->reviews_count ?? ($room->reviews->count() ?? 0) }} avis)</span>
                </div> --}}
            </div>

            <!-- Localisation -->
            <div class="flex items-center text-gray-600 text-sm">
                <i class="fa-solid fa-location-dot text-emerald-600 mr-1"></i>
                    {{ $room->hotel->city }}, {{ $room->hotel->country->name }}
            </div>
            </div>

            <!-- Prix -->
            <div class="md:text-right">
            <p class="text-xs text-gray-500">À partir de</p>
            <p class="text-3xl md:text-4xl font-extrabold text-emerald-600">{{ number_format($room->price, 0, '', ' ') }} {{ $currency }}</p>
            <p class="text-xs text-gray-500">par nuit</p>
            </div>
        </div>
    </div>


    <!-- Gallerie d'images -->
    <div class="max-w-7xl mx-auto py-6 px-6">
        <div class="grid grid-cols-12 gap-4">
            <!-- Grande image -->
            <div class="col-span-12 md:col-span-8">
            <div class="rounded-xl overflow-hidden shadow-lg aspect-[16/10] bg-gray-100">
                <img id="mainImage"
                    src="{{ $mainUrl }}"
                    alt="{{ $room->name }}"
                    class="w-full h-full object-cover select-none cursor-zoom-in"
                    onclick="openLightbox()">
            </div>
            </div>


            <!-- Deux images à droite : visibles uniquement à partir du desktop -->
            <div class="hidden md:block md:col-span-4">
                <div class="grid grid-rows-2 gap-4 h-full">
                    @if($rightTop)
                    <button type="button"
                            class="group rounded-xl overflow-hidden shadow-lg aspect-[16/10] bg-gray-100"
                            onclick="changeImage('{{ $rightTop }}', 1)">
                        <img src="{{ $rightTop }}" alt="{{ $room->name }}" loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-[1.02] transition">
                    </button>
                    @else
                    <div class="rounded-xl overflow-hidden shadow-lg bg-gray-100 grid place-items-center text-gray-400">Aucune image</div>
                    @endif

                    @if($rightBottom)
                    <button type="button"
                            class="group rounded-xl overflow-hidden shadow-lg aspect-[16/10] bg-gray-100"
                            onclick="changeImage('{{ $rightBottom }}', 2)">
                        <img src="{{ $rightBottom }}" alt="{{ $room->name }}" loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-[1.02] transition">
                    </button>
                    @else
                    <div class="rounded-xl overflow-hidden shadow-lg bg-gray-100 grid place-items-center text-gray-400">Aucune image</div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Miniatures (défilable sur mobile, grille sur desktop) -->
    <div class="mt-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex md:hidden overflow-x-auto gap-3 snap-x snap-mandatory pb-2">
            @foreach($thumbs as $idx => $thumb)
                <button type="button"
                        class="relative flex-none w-24 h-20 rounded-lg overflow-hidden shadow image-gallery-thumb snap-start border-2 border-transparent"
                        onclick="changeImage('{{ $thumb }}', {{ $idx }})"
                        data-idx="{{ $idx }}">
                <img src="{{ $thumb }}" alt="{{ $room->name }}" loading="lazy"  class="w-full h-full object-cover">
                </button>
            @endforeach
            </div>

            <div class="hidden md:grid grid-cols-6 gap-4">
            @foreach($thumbs as $idx => $thumb)
                <button type="button"
                        class="relative rounded-lg overflow-hidden shadow image-gallery-thumb border-2 border-transparent"
                        onclick="changeImage('{{ $thumb }}', {{ $idx }})"
                        data-idx="{{ $idx }}">
                <img src="{{ $thumb }}" alt="{{ $room->name }}" loading="lazy"  class="w-full h-24 object-cover">
                </button>
            @endforeach
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox"
        class="fixed inset-0 z-[999] hidden bg-black/80 backdrop-blur-sm items-center justify-center">
        <!-- Fermer -->
        <button class="absolute top-3 right-3 md:top-4 md:right-4 text-white"
                onclick="closeLightbox()" aria-label="Fermer">
            <span class="inline-flex items-center justify-center w-9 h-9 md:w-10 md:h-10 rounded-full bg-black/40 hover:bg-black/60">
            ✖
            </span>
        </button>

        <!-- Prev -->
        <button class="absolute left-2 md:left-6 top-1/2 -translate-y-1/2 text-white"
                onclick="lightPrev()" aria-label="Précédent">
            <span class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 rounded-full bg-black/40 hover:bg-black/60 text-2xl md:text-3xl">
            ❮
            </span>
        </button>

        <!-- Next -->
        <button class="absolute right-2 md:right-6 top-1/2 -translate-y-1/2 text-white"
                onclick="lightNext()" aria-label="Suivant">
            <span class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 rounded-full bg-black/40 hover:bg-black/60 text-2xl md:text-3xl">
            ❯
            </span>
        </button>

        <!-- Image -->
        <div class="w-full h-full flex items-center justify-center p-4">
            <img id="lightboxImage"
                class="max-w-[92vw] max-h-[88vh] rounded-lg shadow-2xl object-contain"
                src="" alt="Aperçu">
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left -->
            <div class="lg:w-2/3">
            <!-- Description -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">À propos de {{ $room->name }}</h2>
                <p class="text-gray-700 leading-relaxed">
                {!! $room->description ?? "Aucune description disponible pour cette chambre." !!}
                </p>
            </div>

                <!-- Amenities -->
                @php
                    // Map d’icônes pour certaines commodités courantes
                    $iconsMap = [
                        'wifi'      => 'fa-wifi',
                        'piscine'   => 'fa-water-ladder',
                        'parking'   => 'fa-square-parking',
                        'restaurant'=> 'fa-utensils',
                        'bar'       => 'fa-glass-martini-alt',
                        'climatisation' => 'fa-snowflake',
                        'spa'       => 'fa-spa',
                        'gym'       => 'fa-dumbbell',
                        'tv'        => 'fa-tv',
                    ];
                @endphp

                @if(!empty($room->facilities))
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center text-center gap-1">
                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-600">
                            <i class="fa-solid fa-concierge-bell"></i>
                        </span>
                        <span>Commodités</span>
                    </h2>


                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($room->facilities as $facility)
                            @php
                                // Recherche icône correspondante
                                $iconKey = strtolower($facility->name);
                                $icon = $iconsMap[$iconKey] ?? 'fa-check';
                            @endphp
                            <div class="flex flex-col items-center text-center p-4 bg-gray-50 rounded-lg hover:bg-white hover:shadow-md transition">
                                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 mb-2">
                                    <i class="fa-solid {{ $icon }} text-lg"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $facility->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif



            <!-- Other Rooms (de l’hôtel) -->
            @if($room->hotel && $room->hotel->rooms()->where('status',1)->where('id','!=',$room->id)->exists())
                <div class="bg-white rounded-xl shadow-lg p-6 mb-5">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Plus de choix dans cet hôtel</h2>

                @foreach($room->hotel->rooms()->where('status',1)->where('id','!=',$room->id)->take(3)->get() as $r)
                    <div class="border rounded-xl overflow-hidden mb-6 hover:shadow-lg transition">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3">
                        <img src="{{ $r->image ? asset('storage/'.$r->image) : asset('assets/front/images/hotel.jpg') }}"
                            alt="{{ $r->name }}" class="w-full h-full object-cover" loading="lazy" >
                        </div>
                        <div class="md:w-2/3 md:pl-6 p-4 flex flex-col justify-between">
                        <div class="flex justify-between items-start flex-wrap">
                            <div class="min-w-0 md:flex-1">
                            <h3 class="text-xl font-bold text-gray-800 truncate">{{ $r->name }}</h3>
                            <div class="flex items-center mt-3 text-sm text-gray-600 whitespace-nowrap">
                                <i class="fas fa-user-friends mr-1"></i>
                                <span>{{ $r->capacity ?? '—' }} personnes</span>
                            </div>
                            <div class="flex flex-wrap mt-3 gap-2">
                                @if($r->category) <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">{{ $r->category->name }}</span> @endif
                                @if($r->type)     <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">{{ $r->type }}</span> @endif
                            </div>
                            </div>
                            <div class="text-right mt-4 md:mt-0">
                            <p class="text-sm text-gray-500">par nuit</p>
                            @if($r->price)
                                <p class="text-2xl font-bold text-green-700">
                                {{ number_format($r->price, 0, '', ' ') }} {{ $currency }}
                                </p>
                            @endif
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center flex-wrap">
                            <div class="text-sm text-gray-600 whitespace-nowrap">
                            {{-- exemple: petit-déj incl. si info stockée --}}
                            @if($r->description) <i class="fas fa-info-circle text-green-600 mr-2"></i>{!! Str::limit($r->description, 35) !!} @endif
                            </div>
                            <a href="{{ route('rooms.show', $r->slug) }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition mt-4 md:mt-0">
                            Voir détails
                            </a>
                        </div>
                        </div>
                    </div>
                    </div>
                @endforeach

                </div>
            @endif

            <!-- Reviews -->
            @if(isset($room->reviews) && $room->reviews->count())
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Avis des clients</h2>
                    <span class="bg-gray-200 text-gray-800 rounded-full px-2 py-1 font-bold text-sm">{{ $rating ?: '—' }}/5</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($room->reviews->take(4) as $rev)
                    <div class="border rounded-xl p-4">
                        <div class="flex justify-between items-center">
                        <p class="font-semibold text-gray-900">{{ $rev->author ?? 'Client' }}</p>
                        <span class="text-xs text-gray-500">{{ optional($rev->created_at)->format('d/m/Y') }}</span>
                        </div>
                        <p class="mt-2 text-gray-700">{{ $rev->content }}</p>
                    </div>
                    @endforeach
                </div>
                </div>
            @endif
            </div>

            <!-- Right -->
            <div class="lg:w-1/3 space-y-6 ">
                <!-- Bloc infos -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-emerald-600"></i> Informations
                    </h3>
                    <ul class="space-y-3 text-gray-700">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-users text-emerald-500 w-5 text-center"></i>
                        <span><strong>Capacité :</strong> {{ $room->capacity ?? '—' }} pers.</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-tags text-emerald-500 w-5 text-center"></i>
                        <span><strong>Catégorie :</strong> {{ $room->category->name ?? '—' }}</span>
                    </li>
                    @if($room->type)
                        <li class="flex items-center gap-2">
                        <i class="fa-solid fa-bed text-emerald-500 w-5 text-center"></i>
                        <span><strong>Type :</strong> {{ $room->type }}</span>
                        </li>
                    @endif
                    @if($room->hotel)
                        <li class="flex items-center gap-2">
                        <i class="fa-solid fa-building text-emerald-500 w-5 text-center"></i>
                        <span><strong>Hôtel :</strong>
                            <a href="{{ route('hotels.show', $room->hotel->slug) }}" class="text-emerald-700 hover:underline">
                            {{ $room->hotel->name }}
                            </a>
                        </span>
                        </li>
                    @endif
                    @if($room->address)
                        <li class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-emerald-500 w-5 text-center"></i>
                        <span><strong>Adresse :</strong> {{ $room->address }}</span>
                        </li>
                    @endif
                    </ul>
                </div>



                <!-- Bouton réservation -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <a href="{{ route('booking', ['type' => 'room', 'slug' => $room->slug]) }}"
                        class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Réserver maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Liste des images (Blade → JS)
    const GALLERY = @json($thumbs->values());
    let currentIndex = 0;

    const mainEl = document.getElementById('mainImage');
    const lightbox = document.getElementById('lightbox');
    const lightImg = document.getElementById('lightboxImage');

    function setActiveThumb(idx) {
        document.querySelectorAll('.image-gallery-thumb').forEach((el) => {
        el.classList.remove('ring-2','ring-emerald-500');
        const elIdx = parseInt(el.getAttribute('data-idx'));
        if (elIdx === idx) {
            el.classList.add('ring-2','ring-emerald-500');
        }
        });
    }

    function changeImage(src, idx = null) {
        if (mainEl) mainEl.src = src;
        if (typeof idx === 'number') {
        currentIndex = idx;
        setActiveThumb(idx);
        } else {
        // si on n'a pas d'idx, on tente de le retrouver
        const i = GALLERY.indexOf(src);
        if (i >= 0) { currentIndex = i; setActiveThumb(i); }
        }
    }


    function openLightbox() {
    const main = document.getElementById('mainImage');
    const lb   = document.getElementById('lightbox');
    const img  = document.getElementById('lightboxImage');
    if (!main || !lb || !img) return;

    img.src = main.src;

    // Assure display:flex pour centrer correctement
    lb.classList.remove('hidden');
    // si tu veux être sûr :
    if (![...lb.classList].includes('flex')) lb.classList.add('flex');
    }

    function closeLightbox() {
    const lb = document.getElementById('lightbox');
    if (!lb) return;
    lb.classList.add('hidden');
    // garder 'flex' ne gêne pas; 'hidden' prend le dessus
    }


    function lightPrev() {
        if (!GALLERY.length) return;
        currentIndex = (currentIndex - 1 + GALLERY.length) % GALLERY.length;
        const src = GALLERY[currentIndex];
        lightImg.src = src;
        if (mainEl) mainEl.src = src;
        setActiveThumb(currentIndex);
    }

    function lightNext() {
        if (!GALLERY.length) return;
        currentIndex = (currentIndex + 1) % GALLERY.length;
        const src = GALLERY[currentIndex];
        lightImg.src = src;
        if (mainEl) mainEl.src = src;
        setActiveThumb(currentIndex);
    }

    // Navigation clavier
    window.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        if (e.key === 'ArrowLeft') lightPrev();
        if (e.key === 'ArrowRight') lightNext();
        if (e.key === 'Escape') closeLightbox();
    });

    // Swipe (mobile)
    (function enableSwipe() {
        let startX = 0;
        lightImg.addEventListener('touchstart', (e) => { startX = e.changedTouches[0].clientX; }, {passive:true});
        lightImg.addEventListener('touchend', (e) => {
        const dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 40) (dx > 0 ? lightPrev() : lightNext());
        }, {passive:true});
    })();

    // Init état actif
    document.addEventListener('DOMContentLoaded', () => setActiveThumb(0));
</script>

@endsection
