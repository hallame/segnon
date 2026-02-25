@extends('frontend.layouts.master')

@section('title', 'Nos Collections - Segnon Shop')
@section('meta_description', 'Découvrez toutes nos collections : rideaux, draps, quincaillerie, décoration et pièces sur-mesure.')

@section('content')

<!-- ===== HERO COLLECTIONS ===== -->
<section class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 lg:py-24">
        <div class="text-center max-w-4xl mx-auto">
            <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-[0.3em]">Nos univers</span>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold mt-6 mb-8 leading-[1.1]">
                Explorez nos <span class="gradient-text">collections</span>
            </h1>
            <p class="text-xl text-night-600 max-w-3xl mx-auto">
                Des univers pensés pour sublimer chaque pièce de votre intérieur.
            </p>
        </div>
    </div>
</section>

<!-- ===== GRILLE DES COLLECTIONS ===== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistiques / Filtre rapide (optionnel) -->
        <div class="flex flex-wrap items-center justify-between mb-12">
            <p class="text-night-600">
                <span class="font-bold text-terracotta-500">6 collections</span> disponibles
            </p>
            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Tous</button>
                <button class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Nouveautés</button>
                <button class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Promos</button>
            </div>
        </div>

        <!-- Grille 3 colonnes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Collection 1: Rideaux -->
            <a href="/collections/rideaux" class="group relative block overflow-hidden rounded-3xl hover-lift">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=800&auto=format&fit=crop" 
                         alt="Rideaux" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">120+ modèles</span>
                    <h2 class="text-3xl font-display font-bold mb-2">Rideaux</h2>
                    <p class="text-white/70 text-sm mb-4">Voilages, occultants, sur-mesure</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
                <!-- Badge nouvelle collection (optionnel) -->
                <span class="absolute top-4 right-4 bg-saffron-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Nouveau</span>
            </a>
            
            <!-- Collection 2: Draps -->
            <a href="/collections/draps" class="group relative block overflow-hidden rounded-3xl hover-lift">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800&auto=format&fit=crop" 
                         alt="Draps" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-safari-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Nouveauté</span>
                    <h2 class="text-3xl font-display font-bold mb-2">Draps</h2>
                    <p class="text-white/70 text-sm mb-4">Coton, satin, microfibre</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>
            
            <!-- Collection 3: Quincaillerie -->
            <a href="/collections/quincaillerie" class="group relative block overflow-hidden rounded-3xl hover-lift">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=800&auto=format&fit=crop" 
                         alt="Quincaillerie" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-saffron-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Jusqu'à -20%</span>
                    <h2 class="text-3xl font-display font-bold mb-2">Quincaillerie</h2>
                    <p class="text-white/70 text-sm mb-4">Tringles, crochets, rails</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>
            
            <!-- Collection 4: Décoration -->
            <a href="/collections/decoration" class="group relative block overflow-hidden rounded-3xl hover-lift">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?w=800&auto=format&fit=crop" 
                         alt="Décoration" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Pièces uniques</span>
                    <h2 class="text-3xl font-display font-bold mb-2">Décoration</h2>
                    <p class="text-white/70 text-sm mb-4">Coussins, tapis, art déco</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>
            
            <!-- Collection 5: Sur-mesure -->
            <a href="/collections/sur-mesure" class="group relative block overflow-hidden rounded-3xl hover-lift">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=800&auto=format&fit=crop" 
                         alt="Sur-mesure" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-safari-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Exclusivité</span>
                    <h2 class="text-3xl font-display font-bold mb-2">Sur-mesure</h2>
                    <p class="text-white/70 text-sm mb-4">Dimensions personnalisées</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>
            
            <!-- Collection 6: Nouveautés -->
            <a href="/collections/nouveautes" class="group relative block overflow-hidden rounded-3xl hover-lift">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1567225591450-0605936a7f2c?w=800&auto=format&fit=crop" 
                         alt="Nouveautés" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-saffron-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Juste arrivé</span>
                    <h2 class="text-3xl font-display font-bold mb-2">Nouveautés</h2>
                    <p class="text-white/70 text-sm mb-4">Collection automne 2025</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Pagination (si plus de 9 collections) -->
        <div class="flex justify-center mt-16 gap-2">
            <a href="#" class="w-10 h-10 rounded-full bg-terracotta-500 text-white flex items-center justify-center">1</a>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">2</a>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">3</a>
            <span class="w-10 h-10 flex items-center justify-center">...</span>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">6</a>
        </div>
    </div>
</section>

<!-- ===== COLLECTION SUR-MESURE ===== -->
<section class="py-16 bg-sand-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-terracotta-600 to-saffron-600 rounded-3xl p-12 text-white text-center">
            <h2 class="text-4xl md:text-5xl font-display font-bold mb-4">Vous ne trouvez pas votre bonheur ?</h2>
            <p class="text-white/90 text-lg max-w-2xl mx-auto mb-8">
                Création sur-mesure selon vos dimensions et vos envies.
            </p>
            <a href="/contact" class="inline-flex items-center gap-2 bg-white text-night-900 px-8 py-4 rounded-full font-semibold hover:shadow-xl transition">
                <i class="fas fa-ruler-combined"></i>
                Demander un devis personnalisé
            </a>
        </div>
    </div>
</section>

<!-- ===== FEATURED COLLECTION (mise en avant) ===== -->
{{-- <section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-wider">Sélection</span>
            <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                La collection <span class="gradient-text">Essentielle</span>
            </h2>
            <p class="text-night-600">Nos pièces intemporelles, sélectionnées pour leur qualité exceptionnelle.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @include('partials.product-card', ['product' => $featured1])
            @include('partials.product-card', ['product' => $featured2])
            @include('partials.product-card', ['product' => $featured3])
        </div>
        
        <div class="text-center mt-12">
            <a href="/collections/essentielle" class="inline-flex items-center gap-2 bg-night-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-terracotta-500 transition">
                Voir toute la collection
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section> --}}

@endsection