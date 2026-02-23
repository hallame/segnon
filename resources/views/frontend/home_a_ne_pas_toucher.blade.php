@extends('frontend.layouts.master')
@section('title', 'Marketplace moderne de vendeurs et créateurs')
@section('meta_title', 'Marketplace moderne pour vendeurs, créateurs et marques')
@section('meta_description', "Vendeurs, créateurs et marques connectés à des clients partout dans le monde : pièces singulières, séries limitées et essentiels du quotidien revisités.")
@section('meta_image', asset('assets/images/mk.png'))
@section('content')

    <!-- HERO -->
    {{-- <section class="relative overflow-hidden">
      <!-- Background shapes -->
      <div
        class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_0%_0%,rgba(34,197,94,0.11),transparent_60%),radial-gradient(circle_at_100%_0%,rgba(249,115,22,0.10),transparent_55%)]">
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 lg:py-14 relative">
        <div class="grid lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-10 lg:gap-14 items-center">
          <!-- Left -->
          <div class="space-y-5 md:space-y-6 reveal opacity-0 translate-y-6">
            <div
              class="inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50/80 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-700">
              <i class="ri-sparkling-2-line text-xs text-brand-orange"></i>
              Artisans & créateurs africains
            </div>
            <div class="space-y-3">
              <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight">
                Le marché digital des
                <span class="bg-gradient-to-r from-brand-green to-brand-orange bg-clip-text text-transparent">
                  artisans & créateurs d’Afrique
                </span>
              </h1>
              <p class="text-sm md:text-[15px] text-slate-600 max-w-xl">
                Pièces uniques, savoir-faire authentique, paiement sécurisé et livraison jusqu’à chez vous.
                MYLMARK connecte les articles d’Afrique au reste du monde.
              </p>
            </div>

            <div class="flex flex-wrap gap-2">
              <span
                class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-[11px] text-slate-700 shadow-sm border border-slate-100">
                <i class="ri-hand-heart-line text-brand-green text-sm"></i>
                Sélection 100% fait main
              </span>
              <span
                class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-[11px] text-slate-700 shadow-sm border border-slate-100">
                <i class="ri-smartphone-line text-brand-green text-sm"></i>
                Paiement Mobile Money & cartes
              </span>
              <span
                class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-[11px] text-slate-700 shadow-sm border border-slate-100">
                <i class="ri-earth-line text-brand-green text-sm"></i>
                Créateurs dans plusieurs pays d’Afrique
              </span>
            </div>

            <div class="flex flex-wrap items-center gap-3">
              <a href="{{ route('shop.products.index') }}"
                class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-brand-orange to-amber-500 px-5 py-2.5 text-xs md:text-[13px] font-semibold text-white shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                <i class="ri-compass-3-line text-sm"></i>
                Découvrir les créations
            </a>
              <a  href="{{ route('partners.register') }}?module=shop"
                class="inline-flex items-center gap-2 rounded-full border border-brand-green/40 bg-white/80 px-5 py-2.5 text-xs md:text-[13px] font-semibold text-brand-green shadow-sm hover:bg-brand-green/5 transition">
                <i class="ri-store-fill text-sm"></i>
                Ouvrir ma boutique
            </a>
            </div>

            <div class="flex items-center gap-2 text-[11px] text-slate-500">
              <i class="ri-shield-check-line text-brand-green text-sm"></i>
              <span>Vos achats soutiennent directement les artisans, sans intermédiaires opaques.</span>
            </div>
          </div>

          <!-- Right: mockup cards -->
          <div class="reveal opacity-0 translate-y-6">
            <div
              class="relative rounded-3xl bg-white/90 shadow-soft border border-slate-100/70 p-4 sm:p-5 lg:p-6 backdrop-blur">
              <div class="flex items-center justify-between mb-3">
                <div>
                  <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                    Tendances du marché
                  </p>
                  <p class="text-[11px] text-slate-400">Sélection MYLMARK du moment</p>
                </div>
                <span
                  class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-semibold text-brand-green">
                  <i class="ri-flashlight-line text-xs"></i>
                  En hausse
                </span>
              </div>

              <div class="grid grid-cols-2 gap-3 mb-4">
                <!-- Mini product -->

                @foreach ($trends as $product)
                    @php
                        $media = $product->getFirstMedia('gallery');
                        $img = $media ? asset('storage/'.$media->getPathRelativeToRoot()) : asset('assets/images/products.png');
                    @endphp

                    <article  class="group grid grid-cols-[40%,1fr] gap-2 rounded-2xl bg-white shadow-card overflow-hidden text-[11px]">
                            <div  class="relative h-20 bg-cover bg-center">
                                <img src="{{ $img }}"  alt="{{ $product->name }}"  class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-tr from-black/40 via-transparent to-transparent"></div>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('shop.products.show', $product) }}">
                                    <h3 class="font-semibold text-slate-900 text-[11px] leading-snug">{{ $product->name ?? 'Article' }}</h3>
                                </a>


                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[9px] text-brand-green">
                                        <i class="ri-star-smile-line text-[11px]"></i>
                                        Edition limitée
                                    </span>
                                <div class="flex items-center gap-1 mt-1.5">
                                    <span class="text-[11px] font-semibold text-amber-500">{{ number_format($product->price, 0, ',', ' ') }} {{ $currency }}</span>

                                </div>
                            </div>
                    </article>
                @endforeach




              </div>

              <div
                class="lg:absolute lg:-right-3 lg:-bottom-6 w-full lg:w-60 rounded-2xl bg-slate-900 text-slate-50 px-4 py-3 text-[11px] shadow-card">
                <p class="font-semibold flex items-center gap-1 text-[12px]">
                  <i class="ri-sparkling-2-line text-amber-400"></i>
                  + de 500 créations uniques
                </p>
                <p class="mt-1 text-slate-300">
                  MYLMARK met en avant les articles d’Afrique : mode, déco, cosmétiques, gastronomie… Le tout géré en
                  ligne, livré chez vous.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> --}}

     {{-- HERO FULL SCREEN, NOIR / DÉGRADÉS --}}
    <section class="relative overflow-hidden bg-slate-950 text-slate-50 min-h-[90dvh] flex items-center">
        {{-- Tissages / halos --}}
        <div class="pointer-events-none absolute inset-0 opacity-80">
            <div class="absolute -left-24 -top-24 h-80 w-80 rounded-full bg-[radial-gradient(circle_at_center,rgba(34,197,94,0.45),transparent_65%)]"></div>
            <div class="absolute right-[-6rem] top-10 h-96 w-72 rotate-12 bg-[linear-gradient(135deg,rgba(248,250,252,0.08)_0%,rgba(248,250,252,0.02)_40%,transparent_100%)]"></div>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-slate-950 via-slate-950/10 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 lg:py-10 relative">
            <div class="grid lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-10 lg:gap-16 items-center">
                {{-- LEFT --}}
                <div class="space-y-6 lg:space-y-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/40 bg-slate-900/70 px-4 py-1.5 text-[11px] font-semibold tracking-[0.22em] uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Vendeurs & créateurs
                    </div>

                    <div class="space-y-4">
                        <h1 class="text-3xl sm:text-4xl  font-extrabold leading-tight">
                            La marketplace professionnelle pour vendre vos produits en ligne,
                            <span class="bg-gradient-to-r from-amber-300 via-amber-400 to-orange-400 bg-clip-text text-transparent">
                                en toute simplicité.
                            </span>
                        </h1>
                        <p class="text-sm sm:text-[15px] text-slate-300 max-w-xl">
                            Une seule plateforme pour centraliser vos produits, présenter votre univers,
                            gérer vos commandes et toucher plus de clients, sans complexité technique.
                        </p>
                    </div>


                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('shop.products.index') }}"
                           class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-4 py-2.5 text-[13px] font-semibold text-slate-900 shadow-[0_18px_45px_rgba(15,23,42,0.45)] hover:bg-amber-300 hover:scale-[1.02] transition">
                            <i class="ri-compass-3-line text-base"></i>
                            Voir la sélection
                        </a>
                        <a href="{{ route('partners.register') }}?module=shop"
                           class="inline-flex items-center gap-2 rounded-full border border-emerald-300/60 bg-slate-900/60 px-3 py-2.5 text-[13px] font-semibold text-emerald-100 hover:bg-emerald-900/40 hover:border-emerald-200 transition">
                            <i class="ri-store-3-line text-base"></i>
                            Ouvrir ma boutique
                        </a>
                    </div>

                     <div class="mt-5 flex flex-wrap items-center gap-4 text-[11px] text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-800">
                                <i class="ri-shield-check-line text-xs text-emerald-300"></i>
                            </span>
                            <span>Paiements sécurisés & commandes suivies</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-800">
                                <i class="ri-global-line text-xs text-amber-300"></i>
                            </span>
                            <span>Vendeurs & artisans de plusieurs pays</span>
                        </div>
                    </div>

                    {{-- <div class="flex flex-wrap gap-4 text-[11px] text-slate-300">
                        <div class="flex items-center gap-2">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-900/80">
                                <i class="ri-hand-heart-line text-xs text-emerald-300"></i>
                            </span>
                            <span>Chaque achat soutient directement des créateurs indépendants.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-900/80">
                                <i class="ri-shield-check-line text-xs text-emerald-300"></i>
                            </span>
                            <span>Paiements sécurisés, suivi transparent.</span>
                        </div>
                    </div> --}}
                </div>

                {{-- RIGHT : MOSAÏQUE DE PRODUITS --}}
                <div class="lg:pl-4">
                    <div class="relative max-w-md mx-auto">
                        <div class="absolute -left-10 -top-8 h-20 w-20 rounded-full bg-[radial-gradient(circle_at_center,rgba(250,250,250,0.8),transparent_60%)] opacity-40"></div>
                        <div class="absolute -right-6 bottom-2 h-24 w-24 bg-[conic-gradient(from_220deg,rgba(248,250,252,0.05),rgba(16,185,129,0.6),rgba(249,115,22,0.5),rgba(15,23,42,0.2))] rounded-3xl opacity-40 blur-sm"></div>

                        <div class="space-y-4">
                            {{-- Carte principale --}}
                            <article class="relative rounded-3xl bg-slate-900/80 border border-slate-700/70 shadow-2xl overflow-hidden">
                                @php
                                    $colors = [
                                        'from-emerald-500 to-emerald-600',
                                        'from-amber-400 to-orange-500',
                                        'from-sky-500 to-indigo-500',
                                    ];
                                @endphp

                                <div class="flex items-center justify-between gap-2 p-2 pb-0">
                                    {{-- Avatars vendeurs récents --}}
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex -space-x-2">
                                            @forelse($topVendors as $idx => $vendor)
                                                @php
                                                    $name = trim((string) $vendor->name);
                                                    $parts = preg_split('/\s+/', $name);
                                                    if (count($parts) >= 2) {
                                                        $initials = mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1);
                                                    } else {
                                                        $initials = mb_substr($name, 0, 2);
                                                    }
                                                    $initials = mb_strtoupper($initials);
                                                    $gradient = $colors[$idx] ?? 'from-slate-500 to-slate-700';
                                                @endphp

                                                <a href="{{ route('shop.vendors.show', $vendor) }}"
                                                class="group relative block h-8 w-8 rounded-full border border-slate-900/80 bg-slate-900 overflow-hidden shadow-sm hover:-translate-y-0.5 hover:shadow-md transition">
                                                    @if(!empty($vendor->image))
                                                        <img src="{{ asset('storage/'.$vendor->image) }}"
                                                            alt="{{ $vendor->name }}"
                                                            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-200">
                                                    @else
                                                        <span class="flex h-full w-full items-center justify-center text-[11px] font-semibold text-emerald-50 bg-gradient-to-br {{ $gradient }}">
                                                            {{ $initials }}
                                                        </span>
                                                    @endif

                                                    {{-- Tooltip nom boutique --}}
                                                    <span class="pointer-events-none absolute left-1/2 -bottom-7 -translate-x-1/2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0.5 transition
                                                                whitespace-nowrap rounded-full bg-slate-900 text-[10px] text-slate-50 px-2 py-0.5 border border-slate-700 shadow-lg z-10">
                                                        {{ \Illuminate\Support\Str::limit($vendor->name, 18) }}
                                                    </span>
                                                </a>
                                            @empty
                                                <span class="h-8 w-8 rounded-full border border-slate-900/80 bg-slate-700 flex items-center justify-center text-[11px] font-semibold text-slate-100">
                                                    MK
                                                </span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="text-[10px] text-slate-300">
                                        <p class="font-semibold text-emerald-200">En ligne</p>
                                        <p>En ce moment</p>
                                    </div>
                                    <div class="ml-auto text-right text-[11px]">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/10 px-2 py-0.5 text-[11px] text-emerald-200">
                                            <span class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-500/20">
                                                <i class="ri-flashlight-line text-[10px]"></i>
                                            </span>
                                            En stock
                                        </span>
                                    </div>
                                </div>





                                <div class="relative min-h-[300px] md:min-h-[350px] flex items-center justify-center px-2 py-4 perspective-1000">
                                    <!-- Conteneur du cube -->
                                    <div class="cube-container relative w-full max-w-sm md:max-w-md h-64 md:h-80 mx-auto transform-style-preserve-3d transition-transform duration-1000 ease-out"
                                        id="product-cube">

                                        @foreach($trends->take(6) as $index => $product)
                                            @php
                                                $cover = $product->getFirstMedia('cover');
                                                $gallery = $product->getFirstMedia('gallery');

                                                if ($cover) {
                                                    $img = $cover->getUrl();
                                                } elseif ($gallery) {
                                                    $img = $gallery->getUrl();
                                                } elseif ($product->image) {
                                                    $img = asset('storage/'.$product->image);
                                                } else {
                                                    $img = asset('assets/images/products.png');
                                                }

                                                // Définir la position de chaque face
                                                $positions = [
                                                    ['rotateY(0deg) translateZ(160px)', 'front'],
                                                    ['rotateY(90deg) translateZ(160px)', 'right'],
                                                    ['rotateY(180deg) translateZ(160px)', 'back'],
                                                    ['rotateY(-90deg) translateZ(160px)', 'left'],
                                                    ['rotateX(90deg) translateZ(160px)', 'top'],
                                                    ['rotateX(-90deg) translateZ(160px)', 'bottom']
                                                ];
                                                [$transform, $faceClass] = $positions[$index] ?? ['translateZ(160px)', 'front'];
                                            @endphp

                                            <!-- Face du cube -->
                                            <div class="cube-face absolute w-full h-full rounded-2xl overflow-hidden cursor-pointer transform-style-preserve-3d transition-all duration-500 hover:scale-105 hover:z-10"
                                                style="transform: {{ $transform }};"
                                                data-face="{{ $faceClass }}"
                                                data-product-id="{{ $product->id }}">

                                                <!-- Lien produit avec effets -->
                                                <a href="{{ route('shop.products.show', $product) }}"
                                                class="group block w-full h-full relative">

                                                    <!-- Overlay gradient -->
                                                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 via-slate-900/40 to-transparent z-10"></div>

                                                    <!-- Image de fond -->
                                                    <div class="absolute inset-0">
                                                        <img src="{{ $img }}"
                                                            alt="{{ $product->name }}"
                                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                                                        <!-- Effet de brillance -->
                                                        <div class="absolute inset-0 bg-gradient-to-tr from-amber-500/10 via-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                                    </div>

                                                    <!-- Contenu de la face -->
                                                    <div class="relative z-20 h-full flex flex-col justify-between p-4 md:p-6">
                                                    </div>

                                                    <!-- Effets de bordure -->
                                                    <div class="absolute inset-0 rounded-2xl border-2 border-transparent group-hover:border-amber-400/30 transition-colors duration-300"></div>

                                                    <!-- Éclats de lumière -->
                                                    <div class="absolute -inset-1 bg-gradient-to-r from-transparent via-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>
                                                </a>
                                            </div>
                                        @endforeach

                                        <!-- Ombre portée du cube -->
                                        <div class="absolute inset-0 transform-style-preserve-3d">
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/0 via-slate-900/20 to-slate-900/0 rounded-2xl shadow-2xl shadow-slate-900/50"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Indicateur de chargement -->
                                <div class="cube-loader absolute inset-0 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm z-30 transition-opacity duration-500 opacity-0 pointer-events-none">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="relative">
                                            <div class="w-12 h-12 border-4 border-slate-700 border-t-amber-400 rounded-full animate-spin"></div>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <i class="ri-cube-line text-xl text-amber-300"></i>
                                            </div>
                                        </div>
                                        <span class="text-sm text-slate-300">Chargement ...</span>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const cube = document.getElementById('product-cube');
                                        const controls = document.querySelectorAll('.cube-control');
                                        const faceIndicators = document.querySelectorAll('.cube-face-indicator');
                                        const cubeLoader = document.querySelector('.cube-loader');
                                        const pausePlayBtn = document.querySelector('.cube-pause-play');
                                        const cubeFaces = document.querySelectorAll('.cube-face');

                                        let currentRotation = { x: 0, y: 0 };
                                        let isAutoRotating = true;
                                        let autoRotateInterval;
                                        let isAnimating = false;

                                        // Angles de rotation pour chaque face
                                        const faceRotations = {
                                            'front': { x: 0, y: 0 },
                                            'right': { x: 0, y: -90 },
                                            'back': { x: 0, y: -180 },
                                            'left': { x: 0, y: 90 },
                                            'top': { x: -90, y: 0 },
                                            'bottom': { x: 90, y: 0 }
                                        };

                                        // Initialiser le cube
                                        function initCube() {
                                            // Afficher le loader
                                            cubeLoader.style.opacity = '1';
                                            cubeLoader.style.pointerEvents = 'all';

                                            // Rotation initiale aléatoire
                                            const randomY = Math.floor(Math.random() * 4) * 90;
                                            cube.style.transform = `rotateX(-10deg) rotateY(${randomY}deg)`;
                                            currentRotation.y = randomY;

                                            // Cacher le loader après un délai
                                            setTimeout(() => {
                                                cubeLoader.style.opacity = '0';
                                                cubeLoader.style.pointerEvents = 'none';
                                                startAutoRotation();
                                            }, 1000);

                                            // Initialiser les indicateurs de face
                                            updateFaceIndicators();
                                        }

                                        // Faire tourner le cube
                                        function rotateCube(x = 0, y = 0, duration = 1000) {
                                            if (isAnimating) return;
                                            isAnimating = true;

                                            currentRotation.x = (currentRotation.x + x) % 360;
                                            currentRotation.y = (currentRotation.y + y) % 360;

                                            cube.style.transitionDuration = `${duration}ms`;
                                            cube.style.transform = `rotateX(${currentRotation.x}deg) rotateY(${currentRotation.y}deg)`;

                                            // Mettre à jour les indicateurs de face
                                            updateFaceIndicators();

                                            // Réactiver les contrôles après l'animation
                                            setTimeout(() => {
                                                isAnimating = false;
                                            }, duration);
                                        }

                                        // Aller à une face spécifique
                                        function goToFace(face) {
                                            if (!faceRotations[face] || isAnimating) return;

                                            isAnimating = true;
                                            const targetRotation = faceRotations[face];

                                            // Animation fluide vers la face
                                            cube.style.transitionDuration = '800ms';
                                            cube.style.transform = `rotateX(${targetRotation.x}deg) rotateY(${targetRotation.y}deg)`;

                                            currentRotation.x = targetRotation.x;
                                            currentRotation.y = targetRotation.y;

                                            // Mettre à jour les indicateurs
                                            updateFaceIndicators();

                                            setTimeout(() => {
                                                isAnimating = false;
                                            }, 800);
                                        }

                                        // Mettre à jour les indicateurs de face
                                        function updateFaceIndicators() {
                                            // Trouver quelle face est devant
                                            const normalizedX = ((currentRotation.x % 360) + 360) % 360;
                                            const normalizedY = ((currentRotation.y % 360) + 360) % 360;

                                            let currentFace = 'front';

                                            // Déterminer la face visible
                                            if (Math.abs(normalizedX - 90) < 45) currentFace = 'bottom';
                                            else if (Math.abs(normalizedX + 90) < 45) currentFace = 'top';
                                            else if (Math.abs(normalizedY) < 45) currentFace = 'front';
                                            else if (Math.abs(normalizedY - 90) < 45) currentFace = 'left';
                                            else if (Math.abs(normalizedY + 90) < 45) currentFace = 'right';
                                            else if (Math.abs(Math.abs(normalizedY) - 180) < 45) currentFace = 'back';

                                            // Mettre à jour les indicateurs
                                            faceIndicators.forEach(indicator => {
                                                const face = indicator.getAttribute('data-face');
                                                if (face === currentFace) {
                                                    indicator.classList.add('bg-amber-400', 'scale-125');
                                                    indicator.classList.remove('bg-slate-700');
                                                } else {
                                                    indicator.classList.remove('bg-amber-400', 'scale-125');
                                                    indicator.classList.add('bg-slate-700');
                                                }
                                            });
                                        }

                                        // Rotation automatique
                                        function startAutoRotation() {
                                            if (!isAutoRotating) return;

                                            autoRotateInterval = setInterval(() => {
                                                if (!isAnimating) {
                                                    rotateCube(0, 5, 2000); // Rotation lente et continue
                                                }
                                            }, 3000);
                                        }

                                        function stopAutoRotation() {
                                            clearInterval(autoRotateInterval);
                                        }

                                        // Gestion des contrôles
                                        controls.forEach(control => {
                                            control.addEventListener('click', function() {
                                                if (isAnimating) return;

                                                const direction = this.getAttribute('data-direction');

                                                switch(direction) {
                                                    case 'left':
                                                        rotateCube(0, 90, 800);
                                                        break;
                                                    case 'right':
                                                        rotateCube(0, -90, 800);
                                                        break;
                                                    case 'up':
                                                        rotateCube(90, 0, 800);
                                                        break;
                                                    case 'down':
                                                        rotateCube(-90, 0, 800);
                                                        break;
                                                }

                                                // Arrêter la rotation auto temporairement
                                                if (isAutoRotating) {
                                                    stopAutoRotation();
                                                    setTimeout(startAutoRotation, 5000);
                                                }
                                            });
                                        });

                                        // Bouton pause/play
                                        pausePlayBtn.addEventListener('click', function() {
                                            isAutoRotating = !isAutoRotating;

                                            if (isAutoRotating) {
                                                this.innerHTML = '<i class="ri-pause-line text-lg md:text-xl text-slate-300 group-hover:text-amber-300 transition-colors"></i>';
                                                startAutoRotation();
                                            } else {
                                                this.innerHTML = '<i class="ri-play-line text-lg md:text-xl text-slate-300 group-hover:text-amber-300 transition-colors"></i>';
                                                stopAutoRotation();
                                            }

                                            // Effet de confirmation
                                            this.classList.add('scale-90');
                                            setTimeout(() => this.classList.remove('scale-90'), 150);
                                        });

                                        // Navigation par indicateurs de face
                                        faceIndicators.forEach(indicator => {
                                            indicator.addEventListener('click', function() {
                                                const face = this.getAttribute('data-face');
                                                goToFace(face);

                                                if (isAutoRotating) {
                                                    stopAutoRotation();
                                                    setTimeout(startAutoRotation, 5000);
                                                }
                                            });
                                        });

                                        // Navigation clavier
                                        document.addEventListener('keydown', (e) => {
                                            if (isAnimating) return;

                                            switch(e.key) {
                                                case 'ArrowLeft':
                                                    rotateCube(0, 90, 800);
                                                    e.preventDefault();
                                                    break;
                                                case 'ArrowRight':
                                                    rotateCube(0, -90, 800);
                                                    e.preventDefault();
                                                    break;
                                                case 'ArrowUp':
                                                    rotateCube(90, 0, 800);
                                                    e.preventDefault();
                                                    break;
                                                case 'ArrowDown':
                                                    rotateCube(-90, 0, 800);
                                                    e.preventDefault();
                                                    break;
                                                case ' ':
                                                    isAutoRotating = !isAutoRotating;
                                                    if (isAutoRotating) startAutoRotation();
                                                    else stopAutoRotation();
                                                    e.preventDefault();
                                                    break;
                                            }
                                        });

                                        // Support tactile (swipe)
                                        let touchStartX = 0;
                                        let touchStartY = 0;
                                        let touchEndX = 0;
                                        let touchEndY = 0;

                                        cube.addEventListener('touchstart', (e) => {
                                            touchStartX = e.changedTouches[0].clientX;
                                            touchStartY = e.changedTouches[0].clientY;
                                        });

                                        cube.addEventListener('touchend', (e) => {
                                            if (isAnimating) return;

                                            touchEndX = e.changedTouches[0].clientX;
                                            touchEndY = e.changedTouches[0].clientY;

                                            const diffX = touchStartX - touchEndX;
                                            const diffY = touchStartY - touchEndY;
                                            const threshold = 50;

                                            if (Math.abs(diffX) > Math.abs(diffY)) {
                                                // Swipe horizontal
                                                if (Math.abs(diffX) > threshold) {
                                                    if (diffX > 0) {
                                                        rotateCube(0, 90, 800); // Swipe gauche
                                                    } else {
                                                        rotateCube(0, -90, 800); // Swipe droite
                                                    }
                                                }
                                            } else {
                                                // Swipe vertical
                                                if (Math.abs(diffY) > threshold) {
                                                    if (diffY > 0) {
                                                        rotateCube(-90, 0, 800); // Swipe haut
                                                    } else {
                                                        rotateCube(90, 0, 800); // Swipe bas
                                                    }
                                                }
                                            }
                                        });

                                        // Effet de survol sur les faces
                                        cubeFaces.forEach(face => {
                                            face.addEventListener('mouseenter', () => {
                                                if (isAutoRotating) {
                                                    stopAutoRotation();
                                                }
                                            });

                                            face.addEventListener('mouseleave', () => {
                                                if (isAutoRotating) {
                                                    startAutoRotation();
                                                }
                                            });
                                        });

                                        // Initialiser
                                        initCube();
                                    });
                                </script>

                                <style>
                                    .perspective-1000 {
                                        perspective: 1000px;
                                    }

                                    .transform-style-preserve-3d {
                                        transform-style: preserve-3d;
                                    }

                                    .cube-container {
                                        transform: rotateX(-10deg);
                                    }

                                    .cube-face {
                                        backface-visibility: visible;
                                        box-shadow:
                                            inset 0 0 20px rgba(0, 0, 0, 0.3),
                                            0 0 30px rgba(0, 0, 0, 0.2);
                                    }

                                    .cube-face:hover {
                                        box-shadow:
                                            inset 0 0 30px rgba(251, 191, 36, 0.2),
                                            0 0 40px rgba(251, 191, 36, 0.3);
                                    }

                                    @keyframes spin {
                                        from { transform: rotate(0deg); }
                                        to { transform: rotate(360deg); }
                                    }

                                    .animate-spin {
                                        animation: spin 1s linear infinite;
                                    }

                                    /* Responsive adjustments */
                                    @media (max-width: 768px) {
                                        .cube-container {
                                            width: 280px;
                                            height: 280px;
                                        }

                                        .cube-face {
                                            transform-style: preserve-3d !important;
                                        }

                                        /* Adjust cube size for mobile */
                                        .cube-container > div {
                                            transform: translateZ(120px) !important;
                                        }

                                        .cube-control {
                                            width: 36px !important;
                                            height: 36px !important;
                                        }
                                    }

                                    /* Smooth transitions */
                                    .cube-container,
                                    .cube-face,
                                    .cube-control {
                                        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                                    }

                                    /* Shine effect on hover */
                                    @keyframes shine {
                                        0% { transform: translateX(-100%) rotate(45deg); }
                                        100% { transform: translateX(100%) rotate(45deg); }
                                    }

                                    .cube-face:hover::before {
                                        content: '';
                                        position: absolute;
                                        top: -50%;
                                        left: -50%;
                                        width: 200%;
                                        height: 200%;
                                        background: linear-gradient(
                                            to right,
                                            transparent 20%,
                                            rgba(255, 255, 255, 0.1) 50%,
                                            transparent 80%
                                        );
                                        transform: rotate(45deg);
                                        animation: shine 2s infinite;
                                        pointer-events: none;
                                        z-index: 1;
                                    }
                                </style>






                                {{-- <div class="relative px-2 py-4">
                                    @php
                                        $cubeProducts = $trends->take(12);
                                    @endphp

                                    @if($cubeProducts->isNotEmpty())
                                        <div class="mx-auto flex flex-col items-center gap-4">


                                            <!-- Cube wrapper -->
                                            <div class="cube-wrapper relative mx-auto pt-2">
                                                <div class="cube" id="trending-cube">
                                                    @foreach($cubeProducts as $idx => $product)
                                                        @php
                                                            $cover   = $product->getFirstMedia('cover');
                                                            $gallery = $product->getFirstMedia('gallery');

                                                            if ($cover) {
                                                                $img = $cover->getUrl();
                                                            } elseif ($gallery) {
                                                                $img = $gallery->getUrl();
                                                            } elseif ($product->image) {
                                                                $img = asset('storage/'.$product->image);
                                                            } else {
                                                                $img = asset('assets/images/products.png');
                                                            }

                                                            $faces = ['front','right','back','left'];
                                                            $face  = $faces[$idx] ?? 'front';
                                                        @endphp

                                                        <a href="{{ route('shop.products.show', $product) }}"
                                                        class="cube-face cube-face-{{ $face }}">
                                                            <article class="relative h-full w-full overflow-hidden rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 border border-slate-700/60 shadow-xl">
                                                                <div class="absolute inset-0">
                                                                    <img src="{{ $img }}"
                                                                        alt="{{ $product->name }}"
                                                                        class="h-full w-full object-cover opacity-90">
                                                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent"></div>
                                                                </div>

                                                                <div class="absolute top-2 left-2 flex flex-col gap-1">
                                                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-500 text-slate-950 text-[10px] font-semibold px-2 py-0.5 shadow-md">
                                                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-950"></span>
                                                                        Tendance
                                                                    </span>
                                                                </div>

                                                                <div class="relative z-10 flex h-full flex-col justify-end p-3">
                                                                    <h4 class="text-[13px] font-semibold text-slate-50 line-clamp-2 mb-1">
                                                                        {{ $product->name }}
                                                                    </h4>
                                                                    <p class="text-[11px] text-emerald-100/90">
                                                                        À découvrir sur MYLMARK
                                                                    </p>
                                                                </div>

                                                                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-amber-500/15 via-transparent to-transparent"></div>
                                                            </article>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @if($cubeProducts->count() > 1)
                                                <div class="flex items-center gap-2">
                                                    @foreach($cubeProducts as $idx => $p)
                                                        <button type="button"
                                                                class="cube-dot h-1.5 rounded-full bg-slate-600 transition-all duration-300 {{ $idx === 0 ? 'w-6 bg-amber-400' : 'w-1.5' }}"
                                                                data-index="{{ $idx }}">
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <style>
                                    /* Wrapper : taille responsive */
                                    .cube-wrapper {
                                        --cube-size: min(280px, 80vw);
                                        width: var(--cube-size);
                                        height: calc(var(--cube-size) * 0.75);
                                        perspective: 1200px;
                                    }

                                    @media (min-width: 640px) {
                                        .cube-wrapper {
                                            --cube-size: 320px;
                                        }
                                    }

                                    @media (min-width: 1024px) {
                                        .cube-wrapper {
                                            --cube-size: 360px;
                                        }
                                    }

                                    /* Cube de base */
                                    .cube {
                                        position: relative;
                                        width: 100%;
                                        height: 100%;
                                        transform-style: preserve-3d;
                                        transition: transform 0.9s ease-in-out;
                                    }

                                    .cube-face {
                                        position: absolute;
                                        inset: 0;
                                        backface-visibility: hidden;
                                        transform-origin: center center;
                                        display: block;
                                    }

                                    /* Faces du cube */
                                    .cube-face-front {
                                        transform: rotateY(0deg) translateZ(calc(var(--cube-size) / 2));
                                    }
                                    .cube-face-right {
                                        transform: rotateY(90deg) translateZ(calc(var(--cube-size) / 2));
                                    }
                                    .cube-face-back {
                                        transform: rotateY(180deg) translateZ(calc(var(--cube-size) / 2));
                                    }
                                    .cube-face-left {
                                        transform: rotateY(-90deg) translateZ(calc(var(--cube-size) / 2));
                                    }

                                    /* Dots */
                                    .cube-dot {
                                        border-radius: 9999px;
                                    }
                                </style>

                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const cube = document.getElementById('trending-cube');
                                        if (!cube) return;

                                        const facesCount = cube.querySelectorAll('.cube-face').length;
                                        const dots = document.querySelectorAll('.cube-dot');
                                        let currentIndex = 0;
                                        let timer;

                                        function updateCube() {
                                            const angle = currentIndex * -90;
                                            cube.style.transform = `rotateY(${angle}deg)`;

                                            dots.forEach((dot, idx) => {
                                                if (idx === currentIndex) {
                                                    dot.classList.add('w-6', 'bg-amber-400');
                                                    dot.classList.remove('w-1.5', 'bg-slate-600');
                                                } else {
                                                    dot.classList.remove('w-6', 'bg-amber-400');
                                                    dot.classList.add('w-1.5', 'bg-slate-600');
                                                }
                                            });
                                        }

                                        function nextFace() {
                                            currentIndex = (currentIndex + 1) % facesCount;
                                            updateCube();
                                        }

                                        function goTo(index) {
                                            currentIndex = index % facesCount;
                                            if (currentIndex < 0) currentIndex += facesCount;
                                            updateCube();
                                        }

                                        // Dots click
                                        dots.forEach(dot => {
                                            dot.addEventListener('click', () => {
                                                const idx = parseInt(dot.dataset.index, 10);
                                                goTo(idx);
                                                restartAuto();
                                            });
                                        });

                                        // Auto-rotation
                                        function startAuto() {
                                            if (facesCount <= 1) return;
                                            timer = setInterval(nextFace, 4500);
                                        }
                                        function stopAuto() {
                                            if (timer) clearInterval(timer);
                                        }
                                        function restartAuto() {
                                            stopAuto();
                                            startAuto();
                                        }

                                        // Pause au survol
                                        cube.addEventListener('mouseenter', stopAuto);
                                        cube.addEventListener('mouseleave', startAuto);

                                        // Swipe mobile
                                        let startX = null;
                                        cube.addEventListener('touchstart', e => {
                                            startX = e.changedTouches[0].screenX;
                                        });
                                        cube.addEventListener('touchend', e => {
                                            if (startX === null) return;
                                            const endX = e.changedTouches[0].screenX;
                                            const diff = startX - endX;
                                            const threshold = 40;
                                            if (Math.abs(diff) > threshold) {
                                                if (diff > 0) nextFace();
                                                else goTo(currentIndex - 1);
                                                restartAuto();
                                            }
                                            startX = null;
                                        });

                                        // Init
                                        updateCube();
                                        startAuto();
                                    });
                                </script> --}}





                                {{-- <div class="relative px-2 py-3">

                                    <!-- Carousel container with 3D perspective -->
                                    <div class="relative h-[340px] overflow-hidden">
                                        <div class="carousel-container"
                                            id="trending-carousel"
                                            data-current="0">

                                            @foreach($trends as $index => $product)
                                                @php
                                                    $cover = $product->getFirstMedia('cover');
                                                    $gallery = $product->getFirstMedia('gallery');

                                                    if ($cover) {
                                                        $img = $cover->getUrl();
                                                    } elseif ($gallery) {
                                                        $img = $gallery->getUrl();
                                                    } elseif ($product->image) {
                                                        $img = asset('storage/'.$product->image);
                                                    } else {
                                                        $img = asset('assets/images/products.png');
                                                    }
                                                @endphp

                                                <div class="carousel-item absolute inset-0 transition-all duration-500 ease-out"
                                                    data-index="{{ $index }}"
                                                    style="transform: translateX({{ $index * 100 }}%)">

                                                    <!-- Card with 3D tilt effect -->
                                                    <div class="card-3d h-full w-full perspective-1000">
                                                        <div class="relative h-full w-full transform-style-preserve-3d transition-transform duration-300 hover:rotate-y-5 hover:scale-105">
                                                            <!-- Front of card -->
                                                            <a href="{{ route('shop.products.show', $product) }}"
                                                                class="group block h-full rounded-2xl overflow-hidden bg-gradient-to-br from-slate-900/90 to-slate-800/90 border-2 border-slate-700/30 hover:border-amber-400/30 shadow-2xl shadow-slate-900/30 hover:shadow-amber-900/20 transition-all duration-500">

                                                                <!-- Image container with parallax effect -->
                                                                <div class="relative h-48 overflow-hidden">
                                                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent z-10"></div>

                                                                    <!-- Floating badge -->
                                                                    <span class="absolute top-3 left-3 z-20 animate-pulse">
                                                                        <span class="relative flex h-6 items-center justify-center rounded-full bg-gradient-to-r from-amber-500 to-amber-600 px-3 py-1 text-[10px] font-bold text-slate-950 shadow-lg">
                                                                            <span class="absolute -inset-1 rounded-full bg-amber-400/30 blur-sm"></span>
                                                                            <i class="ri-fire-fill ml-1"></i>
                                                                        </span>
                                                                    </span>

                                                                    <!-- Price badge -->
                                                                    <span class="absolute top-3 right-3 z-20">
                                                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500/20 backdrop-blur-sm border border-emerald-400/30">
                                                                            <i class="ri-verified-badge-fill text-sm text-emerald-300"></i>
                                                                        </span>
                                                                    </span>

                                                                    <!-- Main image with hover zoom -->
                                                                    <div class="h-full overflow-hidden">
                                                                        <img src="{{ $img }}"
                                                                            alt="{{ $product->name }}"
                                                                            class="h-full w-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-1">
                                                                    </div>

                                                                    <!-- Glow effect -->
                                                                    <div class="absolute inset-0 bg-gradient-to-tr from-amber-500/10 via-transparent to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                                                </div>

                                                                <!-- Content -->
                                                                <div class="p-2 space-y-2 relative">
                                                                    <!-- Animated underline -->
                                                                    <div class="relative">
                                                                        <h3 class="text-sm font-bold text-slate-100 line-clamp-2 group-hover:text-amber-100 transition-colors">
                                                                            {{ $product->name }}
                                                                        </h3>
                                                                        <div class="absolute -bottom-1 left-0 h-0.2 w-0 bg-gradient-to-r from-amber-400 to-amber-600 group-hover:w-full transition-all duration-500"></div>
                                                                    </div>
                                                                </div>

                                                                <!-- Corner accents -->
                                                                <div class="absolute top-0 left-0 h-8 w-8 border-t-2 border-l-2 border-amber-400/30 rounded-tl-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                                                <div class="absolute bottom-0 right-0 h-8 w-8 border-b-2 border-r-2 border-amber-400/30 rounded-br-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Navigation dots -->
                                    <div class="flex justify-center items-center gap-2 mt-6">
                                        @foreach($trends as $index => $product)
                                            <button type="button"
                                                    class="carousel-dot w-2 h-2 rounded-full bg-slate-700 hover:bg-amber-400 transition-all duration-300 {{ $index === 0 ? 'w-8 bg-amber-400' : '' }}"
                                                    data-slide-to="{{ $index }}">
                                                <span class="sr-only">Slide {{ $index + 1 }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const carousel = document.getElementById('trending-carousel');
                                        const items = carousel.querySelectorAll('.carousel-item');
                                        const dots = document.querySelectorAll('.carousel-dot');
                                        const prevBtn = document.querySelector('[data-carousel-prev]');
                                        const nextBtn = document.querySelector('[data-carousel-next]');
                                        const totalItems = items.length;
                                        let currentIndex = 0;
                                        let autoSlideInterval;

                                        function updateCarousel() {
                                            // Update items position
                                            items.forEach((item, index) => {
                                                const offset = (index - currentIndex) * 100;
                                                item.style.transform = `translateX(${offset}%)`;

                                                // Add parallax effect for side items
                                                const distance = Math.abs(index - currentIndex);
                                                if (distance === 1) {
                                                    item.style.opacity = '0.7';
                                                    item.style.scale = '0.9';
                                                    item.style.filter = 'blur(2px)';
                                                } else if (distance > 1) {
                                                    item.style.opacity = '0.3';
                                                    item.style.scale = '0.8';
                                                    item.style.filter = 'blur(4px)';
                                                } else {
                                                    item.style.opacity = '1';
                                                    item.style.scale = '1';
                                                    item.style.filter = 'blur(0)';
                                                }
                                            });

                                            // Update dots
                                            dots.forEach((dot, index) => {
                                                if (index === currentIndex) {
                                                    dot.classList.add('w-8', 'bg-amber-400');
                                                    dot.classList.remove('bg-slate-700');
                                                } else {
                                                    dot.classList.remove('w-8', 'bg-amber-400');
                                                    dot.classList.add('bg-slate-700');
                                                }
                                            });

                                            // Update data attribute
                                            carousel.setAttribute('data-current', currentIndex);
                                        }

                                        function nextSlide() {
                                            currentIndex = (currentIndex + 1) % totalItems;
                                            updateCarousel();
                                        }

                                        function prevSlide() {
                                            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
                                            updateCarousel();
                                        }

                                        function goToSlide(index) {
                                            currentIndex = index;
                                            updateCarousel();
                                        }

                                        // Event listeners
                                        nextBtn.addEventListener('click', nextSlide);
                                        prevBtn.addEventListener('click', prevSlide);

                                        dots.forEach(dot => {
                                            dot.addEventListener('click', () => {
                                                const index = parseInt(dot.getAttribute('data-slide-to'));
                                                goToSlide(index);
                                            });
                                        });

                                        // Keyboard navigation
                                        document.addEventListener('keydown', (e) => {
                                            if (e.key === 'ArrowLeft') prevSlide();
                                            if (e.key === 'ArrowRight') nextSlide();
                                        });

                                        // Auto-slide
                                        function startAutoSlide() {
                                            autoSlideInterval = setInterval(nextSlide, 5000);
                                        }

                                        function stopAutoSlide() {
                                            clearInterval(autoSlideInterval);
                                        }

                                        // Pause auto-slide on hover
                                        carousel.addEventListener('mouseenter', stopAutoSlide);
                                        carousel.addEventListener('mouseleave', startAutoSlide);

                                        // Swipe support for mobile
                                        let touchStartX = 0;
                                        let touchEndX = 0;

                                        carousel.addEventListener('touchstart', (e) => {
                                            touchStartX = e.changedTouches[0].screenX;
                                        });

                                        carousel.addEventListener('touchend', (e) => {
                                            touchEndX = e.changedTouches[0].screenX;
                                            handleSwipe();
                                        });

                                        function handleSwipe() {
                                            const swipeThreshold = 50;
                                            const diff = touchStartX - touchEndX;

                                            if (Math.abs(diff) > swipeThreshold) {
                                                if (diff > 0) {
                                                    nextSlide();
                                                } else {
                                                    prevSlide();
                                                }
                                            }
                                        }

                                        // Initialize
                                        updateCarousel();
                                        startAutoSlide();

                                        // Add CSS for perspective
                                        const style = document.createElement('style');
                                        style.textContent = `
                                            .perspective-1000 { perspective: 1000px; }
                                            .transform-style-preserve-3d { transform-style: preserve-3d; }
                                            .hover\\:rotate-y-5:hover { transform: rotateY(5deg); }
                                            .delay-100 { transition-delay: 100ms; }
                                            .delay-200 { transition-delay: 200ms; }
                                            .delay-300 { transition-delay: 300ms; }
                                            .delay-400 { transition-delay: 400ms; }
                                        `;
                                        document.head.appendChild(style);
                                    });
                                </script>

                                <style>
                                    /* Animation pour le badge trending */
                                    @keyframes float {
                                        0%, 100% { transform: translateY(0px); }
                                        50% { transform: translateY(-5px); }
                                    }

                                    .animate-pulse {
                                        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                                    }

                                    /* Effet de transition fluide pour le carousel */
                                    .carousel-item {
                                        will-change: transform, opacity, filter;
                                    }

                                    /* Gradient text */
                                    .text-gradient {
                                        background-clip: text;
                                        -webkit-background-clip: text;
                                        color: transparent;
                                    }

                                    /* Effet de brillance sur les bordures */
                                    .hover\:shine:hover::after {
                                        content: '';
                                        position: absolute;
                                        top: -50%;
                                        left: -50%;
                                        width: 200%;
                                        height: 200%;
                                        background: linear-gradient(
                                            to right,
                                            transparent 20%,
                                            rgba(255, 255, 255, 0.1) 50%,
                                            transparent 80%
                                        );
                                        transform: rotate(30deg);
                                        animation: shine 3s infinite;
                                    }

                                    @keyframes shine {
                                        0% { transform: translateX(-100%) rotate(30deg); }
                                        100% { transform: translateX(100%) rotate(30deg); }
                                    }
                                </style> --}}



                                {{-- <div class="grid grid-cols-2 gap-2 p-3 pt-2">
                                    @foreach($trends as $product)
                                        @php
                                            $cover   = $product->getFirstMedia('cover');
                                            $gallery = $product->getFirstMedia('gallery');

                                            if ($cover) {
                                                // Image principale (upload via le champ "image")
                                                $img = $cover->getUrl();
                                            } elseif ($gallery) {
                                                // Fallback : première image de la galerie
                                                $img = $gallery->getUrl();
                                            } elseif ($product->image) {
                                                // Si jamais tu as encore un chemin stocké en base
                                                $img = asset('storage/'.$product->image);
                                            } else {
                                                // Image par défaut
                                                $img = asset('assets/images/products.png');
                                            }
                                        @endphp
                                        <a href="{{ route('shop.products.show', $product) }}"
                                           class="group rounded-2xl overflow-hidden bg-slate-900/80 border border-slate-700/80 flex flex-col">
                                            <div class="relative h-28">
                                                <img src="{{ $img }}" alt="{{ $product->name }}"
                                                     class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                                                <span class="absolute left-2 top-2 rounded-full bg-amber-400/90 px-2 py-0.5 text-[10px] font-semibold text-slate-950">
                                                    En vue
                                                </span>
                                            </div>
                                            <div class="p-2 space-y-1">
                                                <h3 class="text-[12px] font-semibold text-slate-50 line-clamp-2">
                                                    {{ $product->name }}
                                                </h3>
                                                <div class="flex items-center justify-between pt-1 text-[11px]">
                                                    <span class="font-semibold text-amber-300">
                                                        {{ number_format($product->price, 0, ',', ' ') }} {{ $currency }}
                                                    </span>
                                                    <span class="inline-flex items-center gap-1 text-emerald-200">
                                                      <i class="ri-verified-badge-fill text-[14px] text-emerald-300"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div> --}}


                            </article>

                            {{-- Bandeau statistiques --}}
                            <div class="rounded-2xl border border-slate-700/70 bg-slate-900/70 px-4 py-3 flex items-center justify-between text-[11px]">
                                <div class="space-y-0.5">
                                    <p class="text-slate-300">Satisfaction</p>
                                    <p class="text-xl font-semibold text-emerald-300 leading-none">
                                        <i class="ri-star-fill text-sm text-amber-300"></i>
                                        4,9 <span class="text-xs text-slate-400">/ 5</span>
                                    </p>
                                </div>
                                <div class="h-10 w-px bg-slate-700/70"></div>
                                <div class="space-y-0.5 text-right">
                                    <p class="text-slate-300">Commandes accompagnées</p>
                                    <p class="text-xs text-slate-400">Suivi jusqu’à la livraison</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     {{-- UNIVERS / BANDES COLORÉES --}}
    <section class="bg-slate-50 py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-brand-green">
                        Univers MYLMARK
                    </p>
                    <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-1">
                        Des collections sélectives
                    </h2>
                    <p class="text-[13px] md:text-sm text-slate-600 max-w-xl mt-2">
                        Plutôt déco, mode, cosmétiques ou saveurs ? Naviguez par ambiances et laissez-vous guider
                        par ce qui vous parle.
                    </p>
                </div>
                <p class="text-[11px] md:text-xs text-slate-500 max-w-xs">
                    Chaque univers est conçu pour raconter une histoire : celle des matières, des gestes et des territoires.
                </p>
            </div>

            <div class="grid gap-3 md:grid-cols-4 text-[12px]">
                <article class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-100 via-amber-50 to-white border border-amber-200/70 shadow-soft hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute inset-y-0 right-0 w-16 bg-[radial-gradient(circle_at_top,rgba(249,115,22,0.35),transparent_60%)] opacity-70"></div>
                    <div class="p-4 space-y-2 relative">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-slate-900">Bijoux & détails</h3>
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-white/80 border border-amber-200">
                                <i class="ri-brush-line text-amber-500 text-[17px]"></i>
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-600">
                            Perles, bracelets, boucles, pièces fines inspirées des savoir-faire ancestraux.
                        </p>
                        <p class="text-[11px] font-medium text-amber-700">
                            +140 créations à découvrir
                        </p>
                    </div>
                </article>

                <article class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-100 via-green-50 to-white border border-emerald-200/70 shadow-soft hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute inset-y-0 right-0 w-16 bg-[radial-gradient(circle_at_top,rgba(34,197,94,0.4),transparent_60%)] opacity-70"></div>
                    <div class="p-4 space-y-2 relative">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-slate-900">Mode & silhouettes</h3>
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-white/80 border border-emerald-200">
                                <i class="ri-t-shirt-line text-emerald-600 text-[17px]"></i>
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-600">
                            Pagnes, boubous, ensembles sur-mesure pour un style qui a du sens.
                        </p>
                        <p class="text-[11px] font-medium text-emerald-700">
                            Ateliers couture partenaires
                        </p>
                    </div>
                </article>

                <article class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 border border-slate-900/80 text-slate-50 shadow-soft hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute inset-y-0 right-0 w-16 bg-[radial-gradient(circle_at_top,rgba(248,250,252,0.5),transparent_60%)] opacity-50"></div>
                    <div class="p-4 space-y-2 relative">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold">Art & déco</h3>
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-slate-800">
                                <i class="ri-palette-line text-amber-300 text-[17px]"></i>
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-200">
                            Tableaux, sculptures, textiles muraux pour des intérieurs habités.
                        </p>
                        <p class="text-[11px] font-medium text-emerald-200">
                            Pièces à faible tirage
                        </p>
                    </div>
                </article>

                <article class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-50 via-amber-50 to-white border border-orange-200/70 shadow-soft hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute inset-y-0 right-0 w-16 bg-[radial-gradient(circle_at_top,rgba(248,173,49,0.45),transparent_60%)] opacity-70"></div>
                    <div class="p-4 space-y-2 relative">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-slate-900">Saveurs & rituels</h3>
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-white/80 border border-orange-200">
                                <i class="ri-restaurant-line text-orange-500 text-[17px]"></i>
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-600">
                            Épices, thés, soins naturels : tout ce qui vient nourrir corps & maison.
                        </p>
                        <p class="text-[11px] font-medium text-orange-700">
                            Sélections saisonnières
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- PRODUITS EN AVANT -->
    <section class="scroll-mt-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 md:py-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-brand-green">
                        Sélection MYLMARK
                    </p>
                    <h2 class="text-xl md:text-2xl font-semibold text-slate-900 mt-1">
                        Une sélection qui ne ressemble qu’à vous.
                    </h2>
                    <p class="text-[13px] md:text-sm text-slate-600 max-w-xl mt-2">
                        Une vitrine resserrée des pièces qui font parler d’elles : qualité, histoire, intention.
                    </p>
                </div>
                <a href="{{ route('shop.products.index') }}"
                   class="inline-flex items-center gap-1 text-[12px] font-semibold text-brand-green">
                    Voir plus
                    <i class="ri-arrow-right-line text-xs"></i>
                </a>
            </div>

        <div class="grid gap-4 sm:gap-5 md:grid-cols-2 lg:grid-cols-4 reveal opacity-0 translate-y-6">
          @foreach ($bestSellers as $p)
            @php
                $media = $p->getFirstMedia('gallery');
                $img = $media ? asset('storage/'.$media->getPathRelativeToRoot()) : asset('assets/images/products.png');
            @endphp
            <article class="flex flex-col rounded-2xl bg-white shadow-card overflow-hidden border border-slate-100/80">
                <a href="{{ route('shop.products.show', $p) }}" class="block">
                    <div class="relative h-40">
                        <img src="{{ $img }}"
                            alt="{{ $p->name }}" class="h-full w-full object-cover">
                        {{-- <span
                            class="absolute left-2 top-2 inline-flex items-center gap-1 rounded-full bg-slate-900/85 px-2.5 py-1 text-[10px] font-semibold text-amber-200">
                            <i class="ri-fire-line text-xs"></i>
                            Best-seller
                        </span> --}}
                    </div>
                    <div class="p-3.5 space-y-2">
                        <h3 class="text-[13px] font-semibold text-slate-900">
                            {{ $p->name }}
                        </h3>
                        <div class="flex items-center justify-between gap-2 text-[11px] text-slate-500">
                            <span class="flex items-center gap-1">
                            {{ Str::limit(strip_tags($p->description), 80) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between gap-2 pt-1">
                            <div class="text-[13px] font-semibold text-amber-500">
                                {{ number_format($p->price, 0, ',', ' ') }} {{ $currency }}
                            </div>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] text-brand-green">
                                <i class="ri-shield-check-line text-xs"></i>
                            </span>

                        </div>
                    </div>
                </a>
            </article>
          @endforeach



        </div>
      </div>
    </section>


    <!-- COMMENT ÇA MARCHE -->
    <section id="how" class="scroll-mt-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
          <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-brand-green">
              Parcours d’achat simplifié
            </p>
            <h2 class="text-lg md:text-xl font-semibold text-slate-900 mt-1">
              Comment fonctionne MYLMARK ?
            </h2>
            <p class="text-xs md:text-sm text-slate-600 max-w-xl mt-1.5">
              En quelques clics, vous passez de la découverte d’un atelier au suivi de votre colis – tout en soutenant
              directement les créateurs.
            </p>
          </div>
          <p class="text-[11px] md:text-xs text-slate-500 max-w-xs">
            Une interface claire, des étapes guidées, des paiements sécurisés. Pas de complexité inutile.
          </p>
        </div>

        <div class="grid md:grid-cols-[minmax(0,1.2fr)_minmax(0,0.9fr)] gap-6 md:gap-8 items-start reveal opacity-0 translate-y-6">
          <div class="space-y-4">
            <!-- Step -->
            <div class="flex gap-3">
              <div
                class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-brand-green text-lg">
                <i class="ri-compass-3-line"></i>
              </div>
              <div class="space-y-1">
                <h3 class="text-[13px] font-semibold text-slate-900">
                  1. Découvrez des créations uniques
                </h3>
                <p class="text-[11px] text-slate-600">
                  Parcourez les catégories, filtrez par pays, ambiance, gamme de prix ou type de produit. Chaque fiche
                  raconte l’histoire de l’artisan derrière l’objet.
                </p>
              </div>
            </div>

            <div class="flex gap-3">
              <div
                class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-brand-green text-lg">
                <i class="ri-shopping-bag-3-line"></i>
              </div>
              <div class="space-y-1">
                <h3 class="text-[13px] font-semibold text-slate-900">
                  2. Commandez en quelques clics
                </h3>
                <p class="text-[11px] text-slate-600">
                  Ajoutez vos coups de cœur au panier, choisissez votre mode de paiement (Mobile Money, carte,
                  virement) et validez en toute confiance.
                </p>
              </div>
            </div>

            <div class="flex gap-3">
              <div
                class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-brand-green text-lg">
                <i class="ri-truck-line"></i>
              </div>
              <div class="space-y-1">
                <h3 class="text-[13px] font-semibold text-slate-900">
                  3. Livraison sécurisée chez vous
                </h3>
                <p class="text-[11px] text-slate-600">
                  Suivez l’avancement de votre commande depuis votre espace MYLMARK. Nous travaillons avec des
                  partenaires logistiques fiables pour acheminer vos colis.
                </p>
              </div>
            </div>
          </div>

          <!-- Stats card -->
          <div
            class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 space-y-2 text-[11px] text-slate-700">
            {{-- <div class="flex items-center justify-between rounded-full bg-emerald-50 px-3 py-2">
              <span class="font-semibold text-brand-green">Panier moyen</span>
              <span class="font-semibold text-slate-900">≈ 38 000 FCFA</span>
            </div> --}}
            <div class="flex items-center justify-between rounded-full bg-emerald-50 px-3 py-2">
              <span class="font-semibold text-brand-green">Taux de satisfaction</span>
              <span class="font-semibold text-slate-900">4,9 / 5</span>
            </div>
            <div class="flex items-center justify-between rounded-full bg-emerald-50 px-3 py-2">
              <span class="font-semibold text-brand-green">Commandes récurrentes</span>
              <span class="font-semibold text-slate-900">+ 63%</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">
              MYLMARK fluidifie la relation entre vendeurs et clients : communications centralisées, notifications
              claires, historique d’achats structuré.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ARTISANS EN VEDETTE -->
    {{-- <section id="artisans" class="scroll-mt-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
          <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-brand-green">
              Artisans en vedette
            </p>
            <h2 class="text-lg md:text-xl font-semibold text-slate-900 mt-1">
              Des ateliers ancrés dans leurs territoires
            </h2>
            <p class="text-xs md:text-sm text-slate-600 max-w-xl mt-1.5">
              MYLMARK met en avant des artisans qui allient savoir-faire ancestral et exigence moderne : traçabilité,
              qualité, respect du client.
            </p>
          </div>
          <p class="text-[11px] md:text-xs text-slate-500 max-w-xs">
            Chaque artisan dispose d’une boutique dédiée, avec ses collections, ses histoires et ses engagements.
          </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 reveal opacity-0 translate-y-6">
          <article
            class="grid grid-cols-[auto,1fr] gap-3 items-center rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5">
            <div
              class="h-12 w-12 rounded-full bg-gradient-to-br from-brand-green to-emerald-900 text-white flex items-center justify-center text-xl">
              <i class="ri-scissors-2-line"></i>
            </div>
            <div class="space-y-0.5 text-[11px]">
              <h3 class="font-semibold text-slate-900 text-[12px]">
                Atelier N'Dolo Couture
              </h3>
              <p class="text-slate-600">Création de tenues en wax & bogolan sur-mesure.</p>
              <div class="flex items-center justify-between gap-2 text-[10px] text-slate-500 mt-1">
                <span class="flex items-center gap-1">
                  <i class="ri-map-pin-line text-brand-green text-xs"></i>
                  Abidjan, Côte d’Ivoire
                </span>
                <span
                  class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[9px] text-brand-green">
                  <i class="ri-award-line text-[11px]"></i>
                  Top artisan
                </span>
              </div>
            </div>
          </article>

          <article
            class="grid grid-cols-[auto,1fr] gap-3 items-center rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5">
            <div
              class="h-12 w-12 rounded-full bg-gradient-to-br from-brand-orange to-rose-500 text-white flex items-center justify-center text-xl">
              <i class="ri-brush-3-line"></i>
            </div>
            <div class="space-y-0.5 text-[11px]">
              <h3 class="font-semibold text-slate-900 text-[12px]">
                Kora Art Studio
              </h3>
              <p class="text-slate-600">Peintures contemporaines inspirées des scènes de vie africaines.</p>
              <div class="flex items-center justify-between gap-2 text-[10px] text-slate-500 mt-1">
                <span class="flex items-center gap-1">
                  <i class="ri-map-pin-line text-brand-green text-xs"></i>
                  Dakar, Sénégal
                </span>
                <span
                  class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[9px] text-amber-700">
                  <i class="ri-star-smile-line text-[11px]"></i>
                  Coup de cœur
                </span>
              </div>
            </div>
          </article>

          <article
            class="grid grid-cols-[auto,1fr] gap-3 items-center rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5">
            <div
              class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-600 to-brand-green text-white flex items-center justify-center text-xl">
              <i class="ri-leaf-line"></i>
            </div>
            <div class="space-y-0.5 text-[11px]">
              <h3 class="font-semibold text-slate-900 text-[12px]">
                Karité & Racines
              </h3>
              <p class="text-slate-600">Soins corporels au karité, huiles & rituels de beauté traditionnels.</p>
              <div class="flex items-center justify-between gap-2 text-[10px] text-slate-500 mt-1">
                <span class="flex items-center gap-1">
                  <i class="ri-map-pin-line text-brand-green text-xs"></i>
                  Parakou, Bénin
                </span>
                <span
                  class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[9px] text-brand-green">
                  <i class="ri-shield-check-line text-[11px]"></i>
                  Top artisan
                </span>
              </div>
            </div>
          </article>

          <article
            class="grid grid-cols-[auto,1fr] gap-3 items-center rounded-2xl bg-white shadow-card border border-slate-100/80 p-3.5">
            <div
              class="h-12 w-12 rounded-full bg-gradient-to-br from-brand-orange to-amber-500 text-white flex items-center justify-center text-xl">
              <i class="ri-restaurant-2-line"></i>
            </div>
            <div class="space-y-0.5 text-[11px]">
              <h3 class="font-semibold text-slate-900 text-[12px]">
                Saveurs de Lomé
              </h3>
              <p class="text-slate-600">Épices, thés & mélanges artisanaux pour une cuisine pleine de caractère.</p>
              <div class="flex items-center justify-between gap-2 text-[10px] text-slate-500 mt-1">
                <span class="flex items-center gap-1">
                  <i class="ri-map-pin-line text-brand-green text-xs"></i>
                  Lomé, Togo
                </span>
                <span
                  class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[9px] text-amber-700">
                  <i class="ri-fire-line text-[11px]"></i>
                  Très demandé
                </span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section> --}}
    {{-- POURQUOI MYLMARK ? --}}
    {{-- <section class="bg-slate-900 text-slate-50 py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-300">
                        Pourquoi MYLMARK ?
                    </p>
                    <h2 class="text-xl md:text-2xl font-semibold mt-1">
                        Une plateforme pensée pour les clients, les artisans et le continent.
                    </h2>
                </div>
                <p class="text-[11px] md:text-xs text-slate-400 max-w-xs">
                    Pas juste un catalogue d’articles, mais une véritable scène pour les créateurs africains.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3 text-[12px]">
                <article class="rounded-2xl border border-slate-700 bg-slate-900/80 p-4 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center">
                            <i class="ri-user-smile-line text-emerald-300 text-lg"></i>
                        </span>
                        <h3 class="font-semibold">Pour les clients</h3>
                    </div>
                    <p class="text-slate-300">
                        Découvrir, comprendre, choisir : fiches claires, visuels travaillés, suivi transparent,
                        service client joignable.
                    </p>
                    <ul class="space-y-1 text-slate-400 text-[11px] mt-2">
                        <li>• Paiements Mobile Money & cartes, sécurisés.</li>
                        <li>• Notifications et suivi jusqu’à la livraison.</li>
                        <li>• Historiques d’achats et favoris conservés.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-slate-700 bg-slate-900/80 p-4 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center">
                            <i class="ri-store-3-line text-amber-300 text-lg"></i>
                        </span>
                        <h3 class="font-semibold">Pour les artisans</h3>
                    </div>
                    <p class="text-slate-300">
                        Une boutique, des outils, un accompagnement. Vous gardez votre identité, on amplifie votre portée.
                    </p>
                    <ul class="space-y-1 text-slate-400 text-[11px] mt-2">
                        <li>• Gestion des stocks, commandes & messages au même endroit.</li>
                        <li>• Statistiques simples à comprendre (ventes, clients).</li>
                        <li>• Équipe à l’écoute pour optimiser votre présence.</li>
                    </ul>
                </article>

                <article class="rounded-2xl border border-slate-700 bg-slate-900/80 p-4 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center">
                            <i class="ri-earth-line text-emerald-300 text-lg"></i>
                        </span>
                        <h3 class="font-semibold">Pour l’Afrique</h3>
                    </div>
                    <p class="text-slate-300">
                        Valoriser le travail, la créativité et les matières du continent, avec une vision durable.
                    </p>
                    <ul class="space-y-1 text-slate-400 text-[11px] mt-2">
                        <li>• Visibilité internationale pour les artisans locaux.</li>
                        <li>• Transmission de savoir-faire via des collections éditorialisées.</li>
                        <li>• Une plateforme basée sur le respect des créateurs.</li>
                    </ul>
                </article>
            </div>
        </div>
    </section> --}}

    {{-- POURQUOI MYLMARK ? --}}
    <section class="bg-slate-900 text-slate-50 py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-300">
                        Pourquoi MYLMARK ?
                    </p>
                    <h2 class="text-xl md:text-2xl font-semibold mt-1">
                        Une plateforme pensée pour les clients, les vendeurs et le continent.
                    </h2>
                </div>
                <p class="text-[11px] md:text-xs text-slate-400 max-w-xs">
                    Une marketplace moderne, avec une expérience fluide, claire et adaptée au marché africain.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3 text-[12px]">
                {{-- Clients --}}
                <article class="rounded-2xl border border-slate-700 bg-slate-900/80 p-4 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center">
                            <i class="ri-user-smile-line text-emerald-300 text-lg"></i>
                        </span>
                        <h3 class="font-semibold">Pour les clients</h3>
                    </div>
                    <p class="text-slate-300">
                        Trouver facilement ce qu’on cherche, comprendre ce qu’on achète, suivre sa commande sans stress.
                    </p>
                    <ul class="space-y-1 text-slate-400 text-[11px] mt-2">
                        <li>• Paiements Mobile Money & cartes, sécurisés.</li>
                        <li>• Suivi clair de la commande jusqu’à la réception.</li>
                        <li>• Historique d’achats et produits favoris toujours accessibles.</li>
                    </ul>
                </article>

                {{-- Vendeurs --}}
                <article class="rounded-2xl border border-slate-700 bg-slate-900/80 p-4 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center">
                            <i class="ri-store-3-line text-amber-300 text-lg"></i>
                        </span>
                        <h3 class="font-semibold">Pour les vendeurs</h3>
                    </div>
                    <p class="text-slate-300">
                        Une boutique en ligne prête à l’emploi, des outils simples et une équipe qui accompagne vraiment.
                    </p>
                    <ul class="space-y-1 text-slate-400 text-[11px] mt-2">
                        <li>• Gestion des produits, stocks et commandes au même endroit.</li>
                        <li>• Statistiques claires sur les ventes et les clients.</li>
                        <li>• Conseils et support pour mieux vendre en ligne.</li>
                    </ul>
                </article>

                {{-- Continent / Écosystème --}}
                <article class="rounded-2xl border border-slate-700 bg-slate-900/80 p-4 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center">
                            <i class="ri-earth-line text-emerald-300 text-lg"></i>
                        </span>
                        <h3 class="font-semibold">Pour le continent</h3>
                    </div>
                    <p class="text-slate-300">
                        Digitaliser la vente, raccourcir les circuits et donner plus de place aux marques africaines.
                    </p>
                    <ul class="space-y-1 text-slate-400 text-[11px] mt-2">
                        <li>• Visibilité pour les boutiques et marques basées en Afrique.</li>
                        <li>• Un outil concret pour structurer et professionnaliser la vente en ligne.</li>
                        <li>• Une plateforme qui met en avant la valeur du travail, pas seulement le prix.</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>


    <!-- AVIS / TÉMOIGNAGES -->
    <section id="reviews" class="scroll-mt-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
          <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-brand-green">
              Ils parlent de MYLMARK
            </p>
            <h2 class="text-lg md:text-xl font-semibold text-slate-900 mt-1">
              Avis de clients
            </h2>
            <p class="text-xs md:text-sm text-slate-600 max-w-xl mt-1.5">
              Une marketplace n’a de sens que si elle crée de la confiance. Voici ce que la communauté partage à propos
              de MYLMARK.
            </p>
          </div>
          <p class="text-[11px] md:text-xs text-slate-500 max-w-xs">
            Des retours vérifiés, visibles sur chaque fiche produit et sur chaque boutique artisan.
          </p>
        </div>

        <div class="grid md:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-6 items-start reveal opacity-0 translate-y-6">
          <!-- Testimonials -->
          <div class="space-y-3">
            <article class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 text-[11px]">
              <div class="flex items-center gap-1 text-amber-400 text-xs mb-1.5">
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-half-fill"></i>
              </div>
              <p class="text-slate-700">
                « J’ai commandé un set de paniers et un tableau, le suivi était très clair et les produits encore plus
                beaux en vrai. On sent que les vendeurs sont mis au centre. »
              </p>
              <div class="mt-2 flex items-center justify-between text-[10px] text-slate-500">
                <span>Alice – Cotonou, cliente</span>
                <span>2 commandes déjà</span>
              </div>
            </article>

            <article class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 text-[11px]">
              <div class="flex items-center gap-1 text-amber-400 text-xs mb-1.5">
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
              </div>
              <p class="text-slate-700">
                « J’avais du mal à vendre en ligne. Avec MYLMARK j’ai une boutique claire, des
                paiements sécurisés et je garde la main sur mes prix. »
              </p>
              <div class="mt-2 flex items-center justify-between text-[10px] text-slate-500">
                <span>Luc, artisan</span>
                <span>+ 48% de ventes</span>
              </div>
            </article>

            <article class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 text-[11px]">
              <div class="flex items-center gap-1 text-amber-400 text-xs mb-1.5">
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
              </div>
              <p class="text-slate-700">
                « J’apprécie la transparence : délais annoncés, frais de livraison clairs, et un service client qui
                répond rapidement. »
              </p>
              <div class="mt-2 flex items-center justify-between text-[10px] text-slate-500">
                <span>David – Bohicon, client MYLMARK</span>
                <span>Livraison</span>
              </div>
            </article>
          </div>

          <!-- Rating summary -->
          <aside
            class="rounded-2xl bg-gradient-to-br from-brand-green to-emerald-900 text-slate-50 shadow-card p-5 text-[11px] space-y-3">
            <div class="flex items-center justify-between gap-3">
              <div>
                <div class="text-2xl font-semibold leading-none">
                  4,9 <span class="text-xs font-medium opacity-80">/ 5</span>
                </div>
                <p class="mt-1 text-[11px] opacity-90">
                  Basé sur les évaluations vérifiées des clients & vendeurs actifs sur MYLMARK.
                </p>
              </div>
              <div class="flex flex-col items-end gap-1">
                <div class="flex items-center gap-0.5 text-amber-300 text-sm">
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-fill"></i>
                  <i class="ri-star-half-fill"></i>
                </div>
                <span class="text-[10px] opacity-80">+ 3 000 commandes</span>
              </div>
            </div>
            <ul class="space-y-1 text-[11px] opacity-90">
              <li>• Taux de litiges très faible, suivi et médiation intégrés.</li>
              <li>• Accompagnement dédié pour les vendeurs nouvellement inscrits.</li>
              <li>• Fiches produits structurées pour mieux raconter l’histoire derrière chaque création.</li>
            </ul>
          </aside>
        </div>
      </div>
    </section>

    <!-- CTA VENDEUR -->
    <section id="cta-vendeur" class="scroll-mt-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-8 md:pb-10">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-green via-emerald-800 to-slate-900 text-slate-50 shadow-soft p-5 md:p-7 reveal opacity-0 translate-y-6">
          <div class="pointer-events-none absolute inset-y-0 right-0 w-40 opacity-40 bg-[radial-gradient(circle_at_0_0,#f97316,transparent_60%)]"></div>
          <div class="grid md:grid-cols-[minmax(0,1.3fr)_minmax(0,0.9fr)] gap-6 items-center relative z-10">
            <div class="space-y-3">
              <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-100">
                Vendeurs & ateliers
              </p>
              <h2 class="text-lg md:text-xl font-semibold">
                Vous êtes vendeur ou artisan ? Ouvrez votre boutique sur MYLMARK.
              </h2>
              <p class="text-[11px] md:text-xs text-emerald-100/90 max-w-xl">
                Présentez vos créations au-delà de votre ville, sans perdre votre identité. MYLMARK vous offre un espace
                dédié, une gestion simplifiée et un accompagnement humain.
              </p>
              <ul class="space-y-1.5 text-[11px] text-emerald-50/90">
                <li class="flex gap-2">
                  <i class="ri-check-line mt-[2px] text-emerald-200"></i>
                  <span>Boutique personnalisée avec vos collections, vos textes et vos photos.</span>
                </li>
                <li class="flex gap-2">
                  <i class="ri-check-line mt-[2px] text-emerald-200"></i>
                  <span>Paiements Mobile Money & cartes, sécurisés et suivis.</span>
                </li>
                <li class="flex gap-2">
                  <i class="ri-check-line mt-[2px] text-emerald-200"></i>
                  <span>Tableau de bord pour suivre vos ventes, vos clients et vos livraisons.</span>
                </li>
              </ul>
            </div>
            <div class="space-y-3 md:text-right text-left text-[11px]">
              <div
                class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-[10px] font-medium text-emerald-50">
                <i class="ri-store-3-line text-xs"></i>
                Inscription artisan en quelques minutes
              </div>
              <div>
                <a href="{{ route('partners.register') }}?module=shop"
                class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-5 py-2.5 text-xs font-semibold text-slate-900 shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                  <i class="ri-store-fill text-sm"></i>
                  Devenir vendeur sur MYLMARK
              </a>
              </div>
              <p class="text-emerald-100/90">
                Nous sélectionnons des vendeurs engagés, prêts à livrer une expérience de qualité à leurs clients.
                <br>Vous gardez la propriété de vos créations, nous renforçons leur visibilité.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
