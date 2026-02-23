@extends('frontend.layouts.master')
@section('title', $hotel->name)

@php
    use Illuminate\Support\Str;
    // Meta SEO
    $metaTitle = $hotel->name;
    $metaDescription = $hotel->meta_description ?? Str::limit(strip_tags($hotel->description ?? ''), 160);
    $metaUrl = url()->current();
    $mainImage = $hotel->image ? asset('storage/' . $hotel->image) : asset('assets/front/images/hotel.jpg');

    // Prix et disponibilité
    $price = $hotel->price ?? null;
    $currency = $hotel->currency ?? 'GNF';
    $availability = ($hotel->is_available ?? true) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
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
  <meta property="og:image:alt" content="{{ $hotel->name }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $metaTitle }}">
  <meta name="twitter:description" content="{{ $metaDescription }}">
  <meta name="twitter:image" content="{{ $mainImage }}">
@endsection


@section('content')

<section class="relative min-h-[60vh] flex items-center justify-center bg-cover bg-center"
    style="background-image: url('{{ asset('assets/front/images/hotel.jpg') }}')">
    <!-- Overlay sombre -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-black/90"></div>
    <!-- Contenu -->
    <div class="relative z-10 text-center px-6 max-w-4xl py-5">
        <!-- Badge -->
        <div class="mb-4 inline-block bg-white/10 text-white text-xs px-3 py-1 rounded-full uppercase tracking-widest shadow backdrop-blur">
            Hôtel recommandé ★
        </div>

        <!-- Titre -->
        <h1 class="text-4xl md:text-5xl font-bold text-white drop-shadow-lg mb-4"> {{ $hotel->name }} </h1>

        <div class="my-5 text-sm text-white/90">
            <span class="text-white font-bold">
                +{{ $hotel->rooms->count() ?? rand(50, 100)  }}
            </span>
             chambres disponibles.
        </div>

        <!-- Boutons -->
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('hotels.index') }}"
                class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                <i class="fa-solid fa-hotel mr-2"></i>
                Voir tous les hôtels
            </a>
            <a href="{{ route('rooms.index') }}"
                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-300">
                Voir plus
            </a>
        </div>
    </div>
</section>


<!-- Hotel Cards -->
<section id="hotelListings" class="py-5 bg-gray-50">
    <div class="mx-auto px-4 md:px-10">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($rooms as $room)
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                <a href="{{ route('rooms.show', $room) }}">
                    <div class="relative">
                        <img src="{{ $room->image ? asset('storage/' . $room->image) : asset('assets/front/images/hotel.jpg') }}" alt="{{ $room->name }}" class="w-full h-48 sm:h-64 object-cover">
                        <span class="absolute top-4 left-4 bg-white text-green-500 font-bold px-3 py-1 text-sm font-medium rounded-full shadow-md">{{ $room->type ?? '' }}</span>
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
                        <div class="text-gray-700 text-sm">
                            <p>{!! Str::limit($room->description, 120) !!}</p>
                        </div>

                        <div class="border-t pt-4">
                            <p class="text-xs text-gray-500">à partir de</p>
                            <p class="text-xl font-bold text-accent">{{ number_format($room->price ?? 0, 0, '', ' ') }} {{ $currency }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<div class="my-5 flex justify-center">
    {{ $rooms->links('vendor.pagination.tailwind') }}
</div>

@endsection
