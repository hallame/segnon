@extends('frontend.layouts.master')
@section('title', 'Nos Chambres')
@section('content')

<!-- HERO  -->
<section class="relative min-h-[65vh] lg:min-h-[90vh] flex items-center lg:items-end overflow-hidden"
    {{-- class="relative min-h-[65vh] lg:min-h-[75vh] xl:min-h-[90vh] flex items-end overflow-hidden" --}}

         style="background-image:url('{{ asset('assets/front/images/hotel.jpg') }}'); background-size:cover; background-position:center;">
  <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-black/90"></div>

  <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
    <path fill="rgba(255,255,255,0.08)" d="M0,80 C240,120 480,0 720,40 C960,80 1200,40 1440,80 L1440,120 L0,120 Z"></path>
  </svg>


  <div class="relative z-10 w-full max-w-7xl mx-auto px-4 pb-5 pt-4
            flex flex-col items-center justify-center lg:block">
    <div class="max-w-3xl text-center lg:text-left">
      <span class="inline-block text-[11px] tracking-widest uppercase text-white/90 bg-white/10 border border-white/20 rounded-full px-3 py-1">
        Explorer nos chambres
      </span>

      <h1 class="mt-3 text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight text-white drop-shadow">
        Découvrez toutes nos <span class="text-amber-300">chambres</span>
      </h1>

      <p class="mt-2 text-white/90 text-lg md:text-xl">
        <span class="font-semibold text-white">+{{ $rooms->total() ?? '200' }}</span> disponibles dans nos meilleurs hôtels.
      </p>
    </div>

    <!-- Filters card (compact) -->
    <form method="GET" action="{{ route('rooms.index') }}"
        class="mt-4 bg-green-900/20 backdrop-blur-md rounded-2xl shadow-2xl border border-green-400/30 p-4 md:p-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4">

            @php
                $inputBase = 'w-full h-11 text-sm pl-10 rounded-lg bg-white/90 border border-gray-200 focus:border-green-500 focus:ring-green-500 placeholder-gray-500';
                $selectBase = 'w-full h-11 text-sm pl-10 pr-8 rounded-lg bg-white/90 border border-gray-200 focus:border-green-500 focus:ring-green-500 text-gray-700';
            @endphp

            <!-- Recherche -->
            <div class="md:col-span-3 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input id="q" name="q" value="{{ request('q') }}" placeholder="Recherche..."
                    aria-label="Recherche" class="{{ $inputBase }}">
            </div>

            <!-- Ville -->
            <div class="md:col-span-3 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fa-solid fa-city"></i>
                </span>
                <input id="city" name="city" value="{{ request('city') }}" placeholder="Ville..."
                    aria-label="Ville" class="{{ $inputBase }}">
            </div>

            <!-- Catégorie -->
            <div class="md:col-span-3 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
                <select id="category" name="category" aria-label="Catégorie" class="{{ $selectBase }}">
                    <option value="">Catégorie</option>
                    @foreach($categories ?? [] as $c)
                    <option value="{{ $c->slug }}" @selected(request('category')===$c->slug)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tri -->
            <div class="md:col-span-3 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fa-solid fa-sort"></i>
                </span>
                <select id="sort" name="sort" aria-label="Trier par" class="{{ $selectBase }}">
                    <option value="">Trier par</option>
                    <option value="price_asc"  @selected(request('sort')==='price_asc')>Prix ↑</option>
                    <option value="price_desc" @selected(request('sort')==='price_desc')>Prix ↓</option>
                </select>
            </div>

            <!-- Boutons -->
            <div class="md:col-span-3 flex items-end">
            <div class="w-full grid grid-cols-2 gap-2">
                <button type="submit"
                        class="h-11 inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                <i class="fa-solid fa-filter mr-2"></i> Filtrer
                </button>
                <a href="{{ route('rooms.index') }}"
                    class="h-11 inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition">
                    <i class="fa-solid fa-rotate-left mr-2"></i> Effacer
                </a>
            </div>
            </div>

            <!-- Catégories rapides -->
            @if(!empty($categories))
            <div class="md:col-span-9 hidden sm:flex flex-wrap gap-2 items-center">
                @foreach($categories->take(8) as $c)
                <a href="{{ route('rooms.index', array_merge(request()->except('page'), ['category'=>$c->slug])) }}"
                    class="px-3 py-1 rounded-full text-sm {{ request('category')===$c->slug ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                    {{ $c->name }}
                </a>
                @endforeach
                @if($categories->count() > 8)
                <a href="{{ route('rooms.index') }}"
                    class="px-3 py-1 rounded-full text-sm bg-white/70 text-gray-800 hover:bg-white">
                    +{{ $categories->count() - 8 }} plus
                </a>
                @endif
            </div>
            @endif

        </div>
    </form>
  </div>

</section>

<!-- Liste + pagination (extrait) -->
<section id="roomListings" class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rooms as $room)
             <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                <a href="{{ route('rooms.show', $room) }}">
                    <div class="relative">
                        <img src="{{ $room->image ? asset('storage/' . $room->image) : asset('assets/front/images/hotel.jpg') }}" alt="{{ $room->name }}" class="w-full h-48 sm:h-64 object-cover">
                        <span class="absolute top-4 left-4 bg-white text-green-600 font-bold px-3 py-1 text-sm font-medium rounded-full shadow-md">{{ $room->type ?? '' }}</span>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">{{ $room->name }}</h3>
                                <p class="text-yellow-500">★★★★★</p>
                            </div>
                            <span class="bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">8.5/10</span>
                        </div>

                        <p class="flex items-center text-gray-600 text-sm">
                            <i class="fa-solid fa-location-dot mr-2 text-accent"></i>
                            {{ $room->address ?? $room->hotel->address }}
                        </p>

                        <div class="text-black text-sm">
                            <p>{!! Str::limit($room->description, 120) !!}</p>
                        </div>

                        <div class="border-t pt-4">
                            <p class="text-xs text-gray-500">à partir de</p>
                            <p class="text-xl font-bold text-accent">{{ number_format($room->price ?? 0, 0, '', ' ') }} {{ $currency }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-gray-500 text-center">Aucune chambre trouvée.</p>
        @endforelse
    </div>
    <div class="my-5">
        {{ $rooms->links('vendor.pagination.tailwind') }}
    </div>
</section>


<script>
  // auto-submit sur changement de select (UX)
  document.getElementById('category')?.addEventListener('change', e => e.target.form.submit());
  document.getElementById('sort')?.addEventListener('change', e => e.target.form.submit());
</script>
@endsection
