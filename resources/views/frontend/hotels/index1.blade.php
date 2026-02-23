@extends('frontend.layouts.master')
@section('title', 'Nos Hôtels')
@section('content')

<!-- HERO - Premium Experience -->
<div class="relative w-full h-[70vh] bg-cover bg-center flex items-center justify-center"
     style="background-image: url('{{ asset('assets/front/images/hotel2.jpg') }}');">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm shadow-inner shadow-black/50"></div>
    <div class="relative z-10 text-center text-white px-6 max-w-4xl animate-fadein-slow">
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight tracking-wide mb-6">
            <span class="bg-white/10 px-4 py-2 rounded-xl backdrop-blur-md border border-white/20">
                Séjournez avec <span class="text-yellow-400">élégance</span>
            </span>
        </h1>
        <p class="text-lg md:text-xl font-light text-white/90 max-w-xl mx-auto">
            Découvrez nos hôtels partenaires nichés au cœur de la magnifique Guinée Forestière.
        </p>

        <div class="mt-10">
            {{-- <a href="{{ route('rooms.index') }}"
               class="inline-block bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 text-black font-semibold px-4 py-2 rounded-lg text-lg shadow-lg transition-all duration-300">
                Explorer les chambres
            </a> --}}
            <a href="{{ route('rooms.index') }}"
                class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-lg text-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                    Explorer les chambres
            </a>

        </div>
    </div>
</div>

<!-- Liste des hôtels -->
<section class="bg-gray-100 py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($hotels->isEmpty())
            <div class="text-center text-gray-600 text-lg">
                <p>Aucun hôtel disponible pour le moment.</p>
            </div>
        @else
            {{-- <div class="grid gap-10 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1"> --}}
            <div class="flex flex-wrap gap-8 justify-center">
                @foreach($hotels as $hotel)
                    {{-- <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col h-full"> --}}
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col h-full basis-[300px] md:basis-[340px] lg:basis-[360px] grow-0">
                        <a href="{{ route('rooms.index', array_merge(request()->except('page'), ['hotel'=>$hotel->slug])) }}" class="block relative">
                            <div class="relative h-60 overflow-hidden">
                                <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('assets/front/images/hotel.jpg') }}"
                                     alt="{{ $hotel->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                @if(!is_null($hotel->average_rating))
                                    <span class="absolute top-3 right-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                                        {{ number_format($hotel->average_rating, 1) }} ★
                                    </span>
                                @endif
                            </div>
                        </a>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $hotel->name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ $hotel->city }}@if($hotel->country?->name), {{ $hotel->country?->name }}@endif
                            </p>


                            <p class="text-gray-700 text-sm mb-4 line-clamp-4">{!! Str::limit($hotel->description, 150) !!}</p>
                            <div class="mt-auto flex items-center justify-between pt-4 border-t">

                                @if($hotel->min_price)
                                    <span class="text-base font-semibold text-red-600">
                                        À partir de {{ $hotel->min_price }} {{ $currency }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500 italic">Pas de chambre disponible</span>
                                @endif
                                <a href="{{ route('hotels.show', $hotel->slug) }}"
                                   class="bg-green-700 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="my-6 flex justify-center">
                {{ $hotels->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</section>

@endsection
