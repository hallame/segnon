@extends('frontend.layouts.master')
@section('title', 'Marketplace moderne de vendeurs et créateurs')
@section('meta_title', 'Marketplace moderne pour vendeurs, créateurs et marques')
@section('meta_description', "Vendeurs, créateurs et marques connectés à des clients partout dans le monde : pièces singulières, séries limitées et essentiels du quotidien revisités.")
@section('meta_image', asset('assets/images/mk.png'))
@section('content')
    <!-- HERO -->
    <section class="relative overflow-hidden bg-slate-950 text-slate-50 min-h-[95dvh] flex items-center">
       

        {{-- Effet 3D Minimaliste & Élégant --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            <!-- Orb géométrique central (effet 3D) -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px]">
                <!-- Anneau externe rotatif -->
                <div class="absolute inset-0 rounded-full border border-emerald-500/20 animate-spin-slow"></div>

                <!-- Anneau moyen -->
                <div class="absolute inset-12 rounded-full border border-amber-500/15 animate-spin-slow-reverse"></div>

                <!-- Anneau interne -->
                <div class="absolute inset-24 rounded-full border border-cyan-500/10 animate-spin-slow"></div>

                <!-- Points orbitaux -->
                <div class="absolute inset-0">
                    @for($i = 0; $i < 12; $i++)
                        @php
                            $angle = ($i / 12) * 360;
                            $rad = deg2rad($angle);
                            $x = cos($rad) * 280;
                            $y = sin($rad) * 280;
                        @endphp
                        <div class="absolute w-2 h-2 rounded-full bg-emerald-400/70 animate-pulse"
                            style="
                                left: calc(50% + {{ $x }}px);
                                top: calc(50% + {{ $y }}px);
                                transform: translate(-50%, -50%);
                                animation-delay: {{ $i * 0.2 }}s;
                            ">
                            <div class="absolute -inset-1 rounded-full bg-emerald-400/20 animate-ping"
                                style="animation-delay: {{ $i * 0.2 }}s"></div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Éclats de lumière directionnels -->
            <div class="absolute -left-20 -top-20 h-64 w-64 rounded-full bg-gradient-to-br from-emerald-500/10 to-transparent blur-3xl"></div>
            <div class="absolute -right-20 -bottom-20 h-64 w-64 rounded-full bg-gradient-to-tl from-amber-500/10 to-transparent blur-3xl"></div>

            <!-- Gradient de transition bas -->
            <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
        </div>

        <style>
            @keyframes spin-slow {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }

            @keyframes spin-slow-reverse {
                from { transform: translate(-50%, -50%) rotate(360deg); }
                to { transform: translate(-50%, -50%) rotate(0deg); }
            }

            .animate-spin-slow {
                animation: spin-slow 20s linear infinite;
            }

            .animate-spin-slow-reverse {
                animation: spin-slow-reverse 25s linear infinite;
            }

            /* Effet de parallaxe subtil */
            @media (min-width: 768px) {
                .min-h-[95dvh] {
                    transform-style: preserve-3d;
                    perspective: 1000px;
                }

                .pointer-events-none {
                    transform: translateZ(-20px);
                }
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 lg:py-10 relative">
            <div class="grid lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-10 lg:gap-16 items-center">
                {{-- LEFT --}}
                <div class="space-y-6 lg:space-y-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/40 bg-slate-900/70 px-4 py-1.5 text-[11px] font-semibold tracking-[0.22em] uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Vendeurs & créateurs
                    </div>

                    <div class="space-y-4">

                        <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight">
                            La marketplace professionnelle
                            <br class="hidden sm:block">
                            pour vendre vos produits en ligne,
                            <span class="bg-gradient-to-r from-amber-300 via-amber-400 to-orange-400 bg-clip-text text-transparent">
                                en toute simplicité.
                            </span>
                        </h1>

                        <p class="text-sm sm:text-[15px] text-slate-300 max-w-xl">
                            Une seule plateforme pour centraliser vos produits, présenter votre univers,
                            gérer vos commandes et toucher plus de clients, sans complexité technique.
                        </p>
                    </div>


                    <div class="flex flex-nowrap items-center gap-2 overflow-x-auto no-scrollbar">
                        <a href="{{ route('shop.products.index') }}"
                        class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full
                                bg-amber-400 px-3 py-2 text-[12px] font-semibold text-slate-900
                                shadow-[0_18px_45px_rgba(15,23,42,0.45)]
                                hover:bg-amber-300 transition
                                sm:px-4 sm:py-2.5 sm:text-[13px] sm:gap-2">
                            <i class="ri-compass-3-line text-[15px] sm:text-base"></i>
                            Voir la sélection
                        </a>

                        <a href="{{ route('partners.register') }}?module=shop"
                        class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full
                                border border-emerald-300/60 bg-slate-900/60 px-3 py-2 text-[12px] font-semibold text-emerald-100
                                hover:bg-emerald-900/40 hover:border-emerald-200 transition
                                sm:px-4 sm:py-2.5 sm:text-[13px] sm:gap-2 ">
                            <i class="ri-store-3-line text-[15px] sm:text-base"></i>
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
                </div>

                {{-- RIGHT --}}
                <div class="lg:pl-4">
                    <div class="relative max-w-md mx-auto overflow-hidden">
                        <div class="space-y-2">
                            {{-- Carte principale --}}
                            <article class="relative rounded-3xl bg-slate-900/80 shadow-2xl overflow-hidden">
                                @php
                                    $colors = [
                                        'from-emerald-500 to-emerald-600',
                                        'from-amber-400 to-orange-500',
                                        'from-sky-500 to-indigo-500',
                                        'from-purple-500 to-fuchsia-500',
                                        'from-rose-500 to-pink-600',
                                        'from-teal-400 to-cyan-500',
                                        'from-lime-400 to-green-500',
                                        'from-red-500 to-orange-600',
                                        'from-violet-500 to-indigo-600',
                                        'from-blue-500 to-cyan-600',
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
                                                    $gradient = $colors[$idx % count($colors)];

                                                @endphp

                                                <a href="{{ route('shop.vendors.show', $vendor) }}" aria-label="Voir la boutique {{ $vendor->name }}"
                                                    class="group relative block h-8 w-8 rounded-full border border-slate-900/80 bg-slate-900 overflow-hidden shadow-sm hover:-translate-y-0.5 hover:shadow-md transition">
                                                    @if(!empty($vendor->image) && file_exists(public_path('storage/'.$vendor->image)))
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

                                    {{-- <span class="inline-flex items-center gap-0.5">
                                        <i class="ri-star-fill text-yellow-400"></i>
                                        <i class="ri-star-fill text-yellow-400"></i>
                                        <i class="ri-star-fill text-yellow-400"></i>
                                        <i class="ri-star-fill text-yellow-400"></i>
                                        <i class="ri-star-fill text-yellow-400"></i>
                                    </span> --}}

                                    <span class="flex items-center gap-1">
                                        <i class="ri-trophy-fill text-amber-400 animate-bounce"></i>
                                        <span class="relative flex h-3 w-3">
                                            <span class="absolute h-full w-full rounded-full bg-green-400 animate-ping opacity-50"></span>
                                            <span class="relative h-3 w-3 rounded-full bg-green-500"></span>
                                        </span>
                                    </span>





                                    <div class="ml-auto text-right text-[11px]">
                                        <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px]">
                                            <span class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-800">
                                                <i class="ri-flashlight-line text-[10px]"></i>
                                            </span>
                                            Disponibles
                                        </span>
                                    </div>
                                </div>



                                <div class="relative min-h-[300px] overflow-hidden bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 rounded-3xl  shadow-2xl shadow-slate-900/50 group">

                                    <!-- Galaxy background effect -->
                                    <div class="absolute inset-0 z-0 overflow-hidden">
                                        <!-- Star field -->
                                        <div class="absolute inset-0">
                                            @for($i = 0; $i < 50; $i++)
                                                <div class="star absolute rounded-full bg-white/30"
                                                    style="
                                                        width: {{ rand(1, 3) }}px;
                                                        height: {{ rand(1, 3) }}px;
                                                        top: {{ rand(0, 100) }}%;
                                                        left: {{ rand(0, 100) }}%;
                                                        animation: twinkle {{ rand(3, 8) }}s ease-in-out infinite;
                                                        animation-delay: {{ $i * 9 }}s;
                                                    ">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>

                                    <!-- Multi-Sphere Container -->
                                    <div class="relative h-[200px] md:h-[300px] flex items-center justify-center z-10" id="sphere-container">

                                        <!-- Central glowing sphere -->
                                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-full bg-gradient-to-r from-amber-500/20 to-purple-500/20 blur-2xl animate-pulse-slow opacity-70"></div>

                                        <!-- Product spheres (orbiting) -->
                                        @foreach($trends->take(8) as $index => $product)
                                            @php
                                                $img = $product->featured_image;
                                                //Position orbitale calculée

                                                $angle = ($index / 8) * 360;
                                                $orbitRadius = 140;
                                                $x = cos(deg2rad($angle)) * $orbitRadius;
                                                $z = sin(deg2rad($angle)) * $orbitRadius;
                                                // CHANGER CETTE LIGNE : Supprimer le $y
                                                $y = 0; // REMPLACER par 0 pour centrer verticalement
                                                $scale = 0.8 + sin(deg2rad($angle)) * 0.2;
                                                $rotation = $angle * 2;
                                            @endphp

                                            <!-- Product Sphere -->
                                            <div class="product-sphere absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform-style-preserve-3d transition-all duration-1000 ease-out"
                                                data-index="{{ $index }}"
                                                style="
                                                    transform: translate(-50%, -50%)
                                                                translate3d({{ $x }}px, {{ $y }}px, {{ $z }}px)
                                                                scale({{ $scale }})
                                                                rotateY({{ $rotation }}deg);
                                                    z-index: {{ round($scale * 100) }};
                                                    ">

                                                <a href="{{ route('shop.products.show', $product) }}"
                                                    class="group block relative w-32 h-32 md:w-48 md:h-48 rounded-2xl overflow-hidden cursor-pointer transform-style-preserve-3d transition-all duration-500 hover:!scale-110 md:hover:!scale-115 hover:!z-50">



                                                    <!-- Outer glow -->
                                                    <div class="absolute -inset-3 bg-gradient-to-r from-amber-500/30 via-purple-500/20 to-cyan-500/30 rounded-2xl blur-lg opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>

                                                    <!-- Sphere container -->
                                                    <div class="relative w-full h-full rounded-2xl overflow-hidden border border-white/10 bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-sm">

                                                        <!-- Image avec effet glassmorphism -->
                                                        <div class="absolute inset-0 overflow-hidden">
                                                            <img src="{{ $img }}"
                                                                alt="{{ $product->name }}"
                                                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-3"
                                                                loading="lazy">

                                                            <!-- Gradient overlay -->
                                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/60 to-transparent"></div>

                                                            <!-- Shine effect -->
                                                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-amber-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                                        </div>

                                                        <!-- Content overlay -->
                                                        <div class="relative z-20 h-full flex flex-col justify-between p-3">

                                                            <!-- Product info (appears on hover) -->
                                                            <div class="transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                                                <h3 class="text-xs font-bold text-white line-clamp-2 mb-1 drop-shadow-lg">
                                                                    {{ \Illuminate\Support\Str::limit($product->name, 20) }}
                                                                </h3>
                                                                <div class="flex items-center justify-between">
                                                                    <span class="text-sm font-bold text-amber-300 drop-shadow-lg">
                                                                        {{ number_format($product->price, 0, ',', ' ') }} {{ $currency }}
                                                                    </span>
                                                                    <span class="inline-flex items-center justify-center w-5 h-5 md:w-6 md:h-6 rounded-full bg-emerald-500/20 backdrop-blur-sm border border-emerald-400/30">
                                                                        <i class="ri-arrow-right-up-line text-[10px] md:text-xs text-emerald-300"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Seller info (visible toujours) -->
                                                        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 z-20 opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                                                            <div class="flex items-center gap-2 bg-slate-900/80 backdrop-blur-sm rounded-full px-3 py-1.5 border border-slate-700/50 shadow-lg whitespace-nowrap">
                                                                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                                                <span class="text-[10px] md:text-xs text-slate-300">
                                                                    @if($product->account)
                                                                        {{ \Illuminate\Support\Str::limit($product->account->name, 15) }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <!-- Reflection effect -->
                                                        <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-white/5 to-transparent opacity-50 rounded-t-2xl"></div>
                                                    </div>

                                                    <!-- Orbital trail effect -->
                                                    <div class="absolute -inset-1 rounded-full border border-amber-400/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Simple indicator for mobile -->
                                    {{-- <div class="absolute top-4 left-1/2 -translate-x-1/2 z-20">
                                        <div class="flex items-center gap-2 bg-gradient-to-r from-amber-500/20 via-orange-500/20 to-amber-500/20 backdrop-blur-xl rounded-full px-4 py-2 border border-amber-400/30 shadow-lg shadow-amber-900/20">
                                            <i class="ri-sparkling-2-fill text-amber-300 text-sm"></i>
                                            <span class="text-xs font-semibold text-amber-100">L'Exclusif</span>
                                            <i class="ri-fire-fill text-orange-300 text-sm ml-1"></i>
                                        </div>
                                    </div> --}}
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const container = document.getElementById('sphere-container');
                                        const spheres = document.querySelectorAll('.product-sphere');

                                        // Configuration simplifiée

                                        const isMobile = window.innerWidth < 768;
                                        const config = {
                                            orbitRadius: isMobile ? 140 : 190,
                                            orbitSpeed: 0.8,
                                            rotationSpeed: 0.5,
                                            inertia: 0.92,
                                            sensitivity: 1.2,
                                            autoOrbit: true,
                                            verticalAmplitude: 40
                                        };


                                        let currentRotation = { x: 0, y: 0 };
                                        let targetRotation = { x: -10, y: 0 }; // Légère inclinaison initiale
                                        let velocity = { x: 0, y: 0 };
                                        let isOrbiting = config.autoOrbit;
                                        let orbitAngle = 0;
                                        let animationId = null;
                                        let isDragging = false;
                                        let lastMouse = { x: 0, y: 0 };

                                        // Initialisation
                                        function initSpheres() {
                                            updateSpheres();

                                            if (isOrbiting) {
                                                startOrbit();
                                            }

                                            // Sphere hover effects
                                            spheres.forEach(sphere => {
                                                const link = sphere.querySelector('a');

                                                link.addEventListener('mouseenter', () => {
                                                    sphere.style.zIndex = '100';
                                                });

                                                link.addEventListener('mouseleave', () => {
                                                    const index = parseInt(sphere.getAttribute('data-index'));
                                                    sphere.style.zIndex = index.toString();
                                                });
                                            });
                                        }

                                        // Update sphere positions
                                        function updateSpheres() {
                                            spheres.forEach((sphere, index) => {
                                                const angle = ((index / spheres.length) * 360) + orbitAngle;
                                                const x = Math.cos(deg2rad(angle)) * config.orbitRadius;
                                                const z = Math.sin(deg2rad(angle)) * config.orbitRadius;
                                                const y = 0;
                                                // const y = Math.sin(deg2rad(angle * 2)) * config.verticalAmplitude;
                                                const scale = 0.8 + Math.sin(deg2rad(angle)) * 0.2;

                                                // Opacité dynamique selon la position Z
                                                const depth = (z + config.orbitRadius) / (config.orbitRadius * 2);
                                                sphere.style.opacity = 0.7 + depth * 0.3;

                                                // Transformation

                                                sphere.style.transform = `
                                                    translate(-50%, -50%)
                                                    translate3d(${x}px, ${y}px, ${z}px)
                                                    scale(${scale})
                                                    rotateY(${currentRotation.y * 0.5}deg)
                                                    rotateX(${currentRotation.x * 0.3}deg)
                                                    `;



                                                // sphere.style.transform = `
                                                //     translate3d(${x}px, ${y}px, ${z}px)
                                                //     scale(${scale})
                                                //     rotateY(${currentRotation.y * 0.5}deg)
                                                //     rotateX(${currentRotation.x * 0.3}deg)
                                                // `;
                                            });

                                            // Rotation de la scène
                                            container.style.transform = `
                                                rotateX(${currentRotation.x}deg)
                                                rotateY(${currentRotation.y}deg)
                                            `;

                                            container.style.transform = `
                                                translateY(-10px)
                                                rotateX(${currentRotation.x}deg)
                                                rotateY(${currentRotation.y}deg)
                                            `;

                                        }

                                        // Orbit animation
                                        function startOrbit() {
                                            function orbit() {
                                                if (isOrbiting && !isDragging) {
                                                    orbitAngle += config.orbitSpeed * 0.1;
                                                    updateSpheres();
                                                }
                                                requestAnimationFrame(orbit);
                                            }
                                            orbit();
                                        }

                                        // Mouse drag interaction
                                        container.addEventListener('mousedown', function(e) {
                                            isDragging = true;
                                            lastMouse.x = e.clientX;
                                            lastMouse.y = e.clientY;
                                            container.style.cursor = 'grabbing';

                                            document.addEventListener('mousemove', onMouseMove);
                                            document.addEventListener('mouseup', function onMouseUp() {
                                                isDragging = false;
                                                container.style.cursor = 'grab';
                                                document.removeEventListener('mousemove', onMouseMove);
                                                document.removeEventListener('mouseup', onMouseUp);
                                            });
                                        });

                                        function onMouseMove(e) {
                                            if (!isDragging) return;

                                            const deltaX = e.clientX - lastMouse.x;
                                            const deltaY = e.clientY - lastMouse.y;

                                            velocity.y = deltaX * config.sensitivity;
                                            velocity.x = deltaY * config.sensitivity;

                                            lastMouse.x = e.clientX;
                                            lastMouse.y = e.clientY;
                                        }

                                        // Touch support
                                        container.addEventListener('touchstart', function(e) {
                                            if (e.touches.length === 1) {
                                                isDragging = true;
                                                lastMouse.x = e.touches[0].clientX;
                                                lastMouse.y = e.touches[0].clientY;

                                                document.addEventListener('touchmove', onTouchMove, { passive: true });
                                                document.addEventListener('touchend', function onTouchEnd() {
                                                    isDragging = false;
                                                    document.removeEventListener('touchmove', onTouchMove);
                                                    document.removeEventListener('touchend', onTouchEnd);
                                                }, { passive: true });
                                            }
                                        }, { passive: true });

                                        function onTouchMove(e) {
                                            if (!isDragging || e.touches.length !== 1) return;

                                            const deltaX = e.touches[0].clientX - lastMouse.x;
                                            const deltaY = e.touches[0].clientY - lastMouse.y;

                                            velocity.y = deltaX * config.sensitivity * 0.8;
                                            velocity.x = deltaY * config.sensitivity * 0.8;

                                            lastMouse.x = e.touches[0].clientX;
                                            lastMouse.y = e.touches[0].clientY;
                                        }

                                        // Animation loop with inertia
                                        function animate() {
                                            // Apply inertia
                                            velocity.x *= config.inertia;
                                            velocity.y *= config.inertia;

                                            // Update rotation
                                            currentRotation.x += velocity.x;
                                            currentRotation.y += velocity.y;

                                            // Smooth rotation towards target
                                            currentRotation.x += (targetRotation.x - currentRotation.x) * 0.05;
                                            currentRotation.y += (targetRotation.y - currentRotation.y) * 0.05;

                                            updateSpheres();
                                            animationId = requestAnimationFrame(animate);
                                        }

                                        // Utility function
                                        function deg2rad(degrees) {
                                            return degrees * (Math.PI / 180);
                                        }

                                        // Pause orbit on hover
                                        container.addEventListener('mouseenter', () => {
                                            isOrbiting = false;
                                        });

                                        container.addEventListener('mouseleave', () => {
                                            isOrbiting = config.autoOrbit;
                                        });

                                        // Initialize
                                        initSpheres();
                                        animate();

                                        // Auto-rotate on idle
                                        let idleTimeout;
                                        function resetIdleTimer() {
                                            clearTimeout(idleTimeout);
                                            idleTimeout = setTimeout(() => {
                                                if (!isDragging) {
                                                    velocity.y = -0.5; // Légère rotation automatique
                                                }
                                            }, 3000);
                                        }

                                        document.addEventListener('mousemove', resetIdleTimer);
                                        document.addEventListener('touchstart', resetIdleTimer);
                                        resetIdleTimer();
                                    });
                                </script>

                                <style>
                                    /* Reset pour éliminer l'espace vide */
                                    #sphere-container {
                                        perspective: 1000px;
                                        transform-style: preserve-3d;
                                        width: 100%;
                                        height: 300px;
                                        margin: 0;
                                        padding: 0;
                                        transform: translateY(-20px); /* Soulève légèrement le système orbital */

                                    }

                                    .product-sphere {
                                        transition: transform 1.2s cubic-bezier(0.34, 1.56, 0.64, 1),
                                                    opacity 0.8s ease,
                                                    z-index 0.3s ease;
                                        margin: 0;
                                        padding: 0;
                                        will-change: transform, opacity;
                                    }

                                    /* Animations */
                                    @keyframes twinkle {
                                        0%, 100% { opacity: 0.3; transform: scale(1); }
                                        50% { opacity: 1; transform: scale(1.2); }
                                    }

                                    @keyframes pulse-slow {
                                        0%, 100% { opacity: 0.5; }
                                        50% { opacity: 0.8; }
                                    }

                                    .animate-pulse-slow {
                                        animation: pulse-slow 4s ease-in-out infinite;
                                    }

                                    .star {
                                        animation: twinkle var(--duration) ease-in-out infinite;
                                    }

                                    @media (max-width: 768px) {
                                        /* #sphere-container {
                                            height: 300px !important;
                                        }
                                        .product-sphere {
                                            transform-origin: center center;
                                        } */
                                    }

                                    @media (max-width: 640px) {
                                        /* #sphere-container {
                                            height: 180px !important;
                                            transform: scale(0.9) translateY(-10px);
                                        } */
                                        .product-sphere h3 {
                                            font-size: 9px !important;
                                        }

                                        .product-sphere .text-sm {
                                            font-size: 10px !important;
                                        }
                                    }



                                    /* Optimisations de performance */
                                    .product-sphere img {
                                        will-change: transform;
                                        image-rendering: -webkit-optimize-contrast;
                                        backface-visibility: hidden;
                                    }

                                    /* Scrollbar personnalisée */
                                    ::-webkit-scrollbar {
                                        width: 6px;
                                    }

                                    ::-webkit-scrollbar-track {
                                        background: rgba(15, 23, 42, 0.2);
                                    }

                                    ::-webkit-scrollbar-thumb {
                                        background: linear-gradient(to bottom, #fbbf24, #f59e0b);
                                        border-radius: 3px;
                                    }

                                    /* Fix pour l'espace vide */
                                    .group {
                                        overflow: hidden;
                                    }

                                    /* Amélioration du hover */
                                    .product-sphere a:hover {
                                        transform: scale(1.15) !important;
                                        filter: brightness(1.2) drop-shadow(0 10px 20px rgba(251, 191, 36, 0.2));
                                    }

                                    /* Smooth transitions */
                                    .product-sphere,
                                    .product-sphere a {
                                        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                                    }
                                </style>

                            </article>

                            {{-- Bandeau statistiques --}}
                            <div class="rounded-2xl bg-gradient-to-r from-slate-900/90 to-slate-800/90 backdrop-blur-sm border border-slate-700/50 px-5 py-3 flex items-center justify-between shadow-xl">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-emerald-300">4,9</div>
                                    <div class="text-[10px] text-slate-400 uppercase tracking-wider">Satisfaction</div>
                                </div>
                                <div class="h-8 w-px bg-gradient-to-b from-transparent via-slate-700 to-transparent"></div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-amber-300">100%</div>
                                    <div class="text-[10px] text-slate-400 uppercase tracking-wider">Suivi</div>
                                </div>
                                <div class="h-8 w-px bg-gradient-to-b from-transparent via-slate-700 to-transparent"></div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-cyan-300">24/7</div>
                                    <div class="text-[10px] text-slate-400 uppercase tracking-wider">Support</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

     <!-- UNIVERS -->
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
                    Chaque univers est conçu pour raconter une histoire : celle des matières et des gestes.
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
                            +40 articles à découvrir
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
                            <h3 class="font-semibold text-slate-900">Saveurs</h3>
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

        <div class="grid gap-4 sm:gap-5 md:grid-cols-2 lg:grid-cols-4 ">
          @foreach ($bestSellers as $p)

            @php
                $price = $p->display_price;
                $inStock = $p->is_in_stock;
            @endphp

            <article class="group flex flex-col rounded-2xl bg-white shadow-sm hover:shadow-2xl overflow-hidden border border-slate-100 transition-all duration-300">
                <a href="{{ route('shop.products.show', $p) }}" class="block">
                    <!-- Image avec effet hover -->
                    <div class="relative h-40 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent z-10"></div>
                        <img src="{{ $p->featured_image }}" alt="{{ $p->name }}"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">

                        <!-- Overlay au hover -->
                        <div class="absolute inset-0 bg-amber-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-4 space-y-2.5">
                        <!-- Titre et description -->
                        <div class="space-y-1.5">
                            <h3 class="text-sm font-semibold text-slate-900 line-clamp-1">
                                {{ $p->name }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2">
                                {{ Str::limit(strip_tags($p->description), 80) }}
                            </p>
                        </div>

                        <!-- Prix élégant -->
                        <div class="flex items-end justify-between pt-1">
                            <div class="min-w-0">
                                @if($p->type === 'variable')
                                    @if(!is_null($price))
                                        <div class="space-y-0.5">
                                            <div class="text-[11px] text-slate-500">À partir de</div>
                                            <div class="text-lg font-bold text-amber-700 truncate">
                                                {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm text-slate-400">Prix sur demande</div>
                                    @endif
                                @else
                                    <div class="space-y-0.5">
                                        @if($p->old_price && $p->old_price > $price)
                                            <div class="flex items-center gap-2">
                                                <s class="text-xs text-slate-400">
                                                    {{ number_format($p->old_price, 0, ',', ' ') }} {{ $currency }}
                                                </s>
                                                @php
                                                    $discount = round((($p->old_price - $price) / $p->old_price) * 100);
                                                @endphp
                                                @if($discount > 0)
                                                    <span class="text-[10px] font-bold bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded">
                                                        -{{ $discount }}%
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                        @if(!is_null($price))
                                            <div class="text-lg font-bold @if($p->old_price && $p->old_price > $price) text-emerald-700 @else text-slate-900 @endif">
                                                {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Badge discret -->
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 shrink-0">
                                <i class="ri-shield-check-line text-sm"></i>
                            </span>
                        </div>

                        <!-- Indicateur de disponibilité subtil -->
                        {{-- @if(!$inStock)
                            <div class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded text-center">
                                <i class="ri-error-warning-line align-middle"></i>
                                <span class="align-middle">Rupture de stock</span>
                            </div>
                        @endif --}}
                    </div>
                </a>
            </article>

            {{-- <article class="flex flex-col rounded-2xl bg-white shadow-card overflow-hidden border border-slate-100/80">
                <a href="{{ route('shop.products.show', $p) }}" class="block">
                    <div class="relative h-40">
                        <img src="{{ $p->featured_image }}" alt="{{ $p->name }}" class="h-full w-full object-cover">
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

                                @if($p->type === 'variable')
                                    @if(!is_null($price))
                                        À partir de {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                    @else
                                        Prix variable
                                    @endif
                                @else
                                    @if($p->old_price)
                                        <s>{{ number_format($p->old_price, 0, ',', ' ') }} {{ $currency }}</s>
                                    @endif
                                    @if(!is_null($price))
                                        {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                    @endif
                                @endif
                            </div>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] text-brand-green">
                                <i class="ri-shield-check-line text-xs"></i>
                            </span>

                        </div>
                    </div>
                </a>
            </article> --}}
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

        <div class="grid md:grid-cols-[minmax(0,1.2fr)_minmax(0,0.9fr)] gap-6 md:gap-8 items-start ">
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

            <div class="flex items-center justify-between rounded-full bg-emerald-50 px-3 py-2">
              <span class="font-semibold text-brand-green">Taux de satisfaction</span>
              <span class="font-semibold text-slate-900">4,9 / 5</span>
            </div>
            <div class="flex items-center justify-between rounded-full bg-emerald-50 px-3 py-2">
              <span class="font-semibold text-brand-green">Commandes récurrentes</span>
              <span class="font-semibold text-slate-900">+ 63%</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">
              MYLMARK est votre vitrine numérique : présentez mieux, gérez facilement, vendez efficacement.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- POURQUOI MYLMARK ? -->
    <section class="bg-slate-900 text-slate-50 py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-300">
                        Pourquoi MYLMARK ?
                    </p>
                    <h2 class="text-xl md:text-2xl font-semibold mt-1">
                        Une plateforme pensée pour les clients et les vendeurs.
                    </h2>
                </div>
                <p class="text-[11px] md:text-xs text-slate-400 max-w-xs">
                    Une marketplace moderne, avec une expérience fluide, claire et adaptée au marché local.
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
                        <h3 class="font-semibold">Pour le marché local</h3>
                    </div>
                    <p class="text-slate-300">
                        Digitaliser la vente, raccourcir les circuits et donner plus de place aux marques locales.
                    </p>
                    <ul class="space-y-1 text-slate-400 text-[11px] mt-2">
                        <li>• Visibilité pour les boutiques et toutes marques.</li>
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
            Des retours vérifiés.
          </p>
        </div>

        <div class="grid md:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-6 items-start ">
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

            {{-- <article class="rounded-2xl bg-white shadow-card border border-slate-100/80 p-4 text-[11px]">
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
            </article> --}}
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
                  Basé sur les évaluations vérifiées des clients & vendeurs actifs.
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
                <span class="text-[10px] opacity-80">+ 100 commandes</span>
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
   @include('frontend.sections.cta')
@endsection
