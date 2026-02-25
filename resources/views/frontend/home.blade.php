
@extends('frontend.layouts.master')

@section('title', 'Segnon Shop – L\'Élégance Africaine pour votre Intérieur')
@section('meta_description', 'Rideaux premium, draps de luxe, quincaillerie design et décoration d\'exception. Découvrez des pièces uniques qui racontent une histoire.')
@section('og_image', asset('assets/images/segnon.png'))

@section('content')

    <!-- ===== HERO SECTION ===== -->
    <section id="accueil" class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden">
        <!-- Formes décoratives -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-terracotta-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-safari-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float-slow"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 lg:py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8 text-center lg:text-left">
                    
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-['Clash_Display'] font-bold leading-[1.1] tracking-tight">
                        <span class="block text-night-900">L'élégance</span>
                        <span class="gradient-text">africaine</span>
                        <span class="block text-night-900">réinventée</span>
                    </h1>
                    
                    <p class="text-lg text-night-600 max-w-xl mx-auto lg:mx-0">
                        Rideaux premium, draps de luxe, quincaillerie design et décoration d'exception. 
                        Des pièces uniques qui racontent une histoire.
                    </p>
                    
                    <!-- CTA Group - Simple et efficace -->
                    <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                        
                        <!-- Bouton Explorer -->
                        <a href="#collections" 
                        class="bg-terracotta-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-terracotta-600 transition flex items-center gap-2 text-sm sm:text-base shadow-lg">
                            Explorer
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        
                        <!-- Bouton WhatsApp -->
                        <a href="https://wa.me/22900000000" 
                        class="bg-white text-night-900 px-6 py-3 rounded-full font-semibold border-2 border-sand-300 hover:border-terracotta-500 transition flex items-center gap-2 text-sm sm:text-base">
                            <i class="fab fa-whatsapp text-terracotta-500"></i>
                            WhatsApp
                        </a>
                        
                    </div>


                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-8 border-t border-sand-200 max-w-md mx-auto lg:mx-0">
                        <div>
                            <div class="text-2xl font-['Clash_Display'] font-bold text-terracotta-500">5000+</div>
                            <div class="text-xs text-night-500">Clients</div>
                        </div>
                        <div>
                            <div class="text-2xl font-['Clash_Display'] font-bold text-safari-600">200+</div>
                            <div class="text-xs text-night-500">Produits</div>
                        </div>
                        <div>
                            <div class="text-2xl font-['Clash_Display'] font-bold text-saffron-600">4.9/5</div>
                            <div class="text-xs text-night-500">Avis</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Images Grid -->
                <div class="grid grid-cols-2 gap-4 relative">
                    <!-- Image 1 -->
                    <div class="space-y-4">
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="{{ asset('assets/images/hero/deco3.jpg') }}" 
                                 alt="Décoration" class="w-full h-64 object-cover hover:scale-110 transition duration-700">
                        </div>
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="{{ asset('assets/images/hero/rideau.jpg') }}" 
                                 alt="Draps" class="w-full h-48 object-cover hover:scale-110 transition duration-700">
                        </div>
                    </div>
                    <!-- Image 2 -->
                    <div class="space-y-4 mt-8">
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="{{ asset('assets/images/hero/draps.jpg') }}" 
                                 alt="Rideaux" class="w-full h-48 object-cover hover:scale-110 transition duration-700">
                        </div>
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="{{ asset('assets/images/hero/deco.jpg') }}" 
                                 alt="Décoration" class="w-full h-64 object-cover hover:scale-110 transition duration-700">
                        </div>
                    </div>
                    
                    <!-- Badge flottant -->
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-2xl p-4 animate-float hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-terracotta-500 rounded-xl flex items-center justify-center text-white text-xl">
                                <i class="fas fa-star"></i>
                            </div>
                            <div>
                                <div class="font-bold text-night-900">4.9/5</div>
                                <div class="text-sm text-night-500">1500+ avis</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MARQUEE BANNER ===== -->
    <div class="bg-night-900 text-white py-5 overflow-hidden border-y-4 border-terracotta-500">
        <div class="animate-marquee whitespace-nowrap flex">
            <div class="inline-flex items-center gap-8 mx-4">
                <span class="text-xl font-semibold">✨ RIDEAUX PREMIUM</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">🛏️ DRAPS DE LUXE</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
                <span class="text-xl font-semibold">🔧 QUINCAILLERIE DESIGN</span>
                <span class="w-2 h-2 bg-safari-500 rounded-full"></span>
                <span class="text-xl font-semibold">🏺 DÉCORATION UNIQUE</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">⭐ SATISFACTION CLIENT</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
            </div>
            <!-- Duplicate pour effet infini -->
            <div class="inline-flex items-center gap-8 mx-4">
                <span class="text-xl font-semibold">✨ RIDEAUX PREMIUM</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">🛏️ DRAPS DE LUXE</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
                <span class="text-xl font-semibold">🔧 QUINCAILLERIE DESIGN</span>
                <span class="w-2 h-2 bg-safari-500 rounded-full"></span>
                <span class="text-xl font-semibold">🏺 DÉCORATION UNIQUE</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">⭐ SATISFACTION CLIENT</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
            </div>
        </div>
    </div>

    <!-- ===== CATEGORIES SECTION ===== -->
    <section id="collections" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-white py-8">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mt-4 mb-6">
                Explorez nos <span class="gradient-text">univers</span>
            </h2>
            <p class="text-night-600">
                Quatre univers distincts pour sublimer chaque pièce de votre intérieur.
            </p>
        </div>
        
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Catégorie 1 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=800&auto=format&fit=crop" 
                        alt="Rideaux" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">120+ modèles</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Rideaux</h3>
                    <p class="text-white/70 text-sm mb-4">Voilages, occultants, sur-mesure</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 2 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800&auto=format&fit=crop" 
                        alt="Draps" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-safari-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Nouveauté</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Draps</h3>
                    <p class="text-white/70 text-sm mb-4">Coton, satin, microfibre</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 3 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=800&auto=format&fit=crop" 
                        alt="Quincaillerie" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-saffron-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Jusqu'à -20%</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Quincaillerie</h3>
                    <p class="text-white/70 text-sm mb-4">Tringles, crochets, rails</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 4 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?w=800&auto=format&fit=crop" 
                        alt="Décoration" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Pièces uniques</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Décoration</h3>
                    <p class="text-white/70 text-sm mb-4">Coussins, tapis, art déco</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURED PRODUCTS ===== -->
    <section id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-sand-50 py-8">
        <!-- Section Header avec tabs -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mt-4">
                    Nos <span class="gradient-text">incontournables</span>
                </h2>
            </div>
            
            <!-- Tabs -->
            <div class="flex flex-wrap gap-2 mt-6 lg:mt-0 p-1 bg-white rounded-2xl shadow-sm">
                <button class="tab-btn active px-6 py-3 rounded-xl bg-terracotta-500 text-white font-medium transition">Tous</button>
                <button class="tab-btn px-6 py-3 rounded-xl text-night-600 hover:bg-sand-200 font-medium transition">Rideaux</button>
                <button class="tab-btn px-6 py-3 rounded-xl text-night-600 hover:bg-sand-200 font-medium transition">Draps</button>
                <button class="tab-btn px-6 py-3 rounded-xl text-night-600 hover:bg-sand-200 font-medium transition">Déco</button>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Produit 1 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full">-30%</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?w=800&auto=format&fit=crop" 
                            alt="Rideau velours" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <!-- Overlay Actions -->
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-terracotta-500 font-semibold">Rideaux</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 ml-1">(45)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Rideau Velours Premium</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">24 500 F</span>
                        <span class="text-sm text-night-400 line-through">35 000 F</span>
                    </div>
                </div>
            </div>
            
            <!-- Produit 2 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-safari-600 text-white text-xs px-3 py-1 rounded-full">Nouveau</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=800&auto=format&fit=crop" 
                            alt="Drap satin" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-safari-600 font-semibold">Draps</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(32)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Parure de lit 5 pièces</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">32 000 F</span>
                    </div>
                </div>
            </div>
            
            <!-- Produit 3 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-saffron-600 text-white text-xs px-3 py-1 rounded-full">Top vente</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800&auto=format&fit=crop" 
                            alt="Poignée" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-saffron-600 font-semibold">Quincaillerie</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 ml-1">(18)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Poignée de porte design</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">8 500 F</span>
                    </div>
                </div>
            </div>
            
            <!-- Produit 4 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full">-25%</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1567225591450-0605936a7f2c?w=800&auto=format&fit=crop" 
                            alt="Miroir" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-terracotta-500 font-semibold">Décoration</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(27)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Miroir doré sculpté</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">18 000 F</span>
                        <span class="text-sm text-night-400 line-through">24 000 F</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center gap-2 bg-night-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-terracotta-500 transition shadow-md hover:shadow-lg">
                Voir tous les produits
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- ===== PROMO BANNER ===== -->
    <section class="py-16 bg-gradient-to-r from-terracotta-600 via-saffron-600 to-safari-600 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">  <!-- AJOUTER CECI -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8 z-10">
                <div class="text-center lg:text-left">
                    <span class="inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-semibold mb-4">⚡ OFFRE EXCEPTIONNELLE</span>
                    <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mb-4">
                        Jusqu'à -50% sur une sélection
                    </h2>
                    <p class="text-white/90 text-lg max-w-2xl">
                        Rideaux, draps et décoration. Livraison offerte.
                    </p>
                </div>
                
                <!-- Timer -->
                <div class="flex gap-3">
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="days">24</div>
                        <div class="text-xs text-white/80">Jours</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="hours">12</div>
                        <div class="text-xs text-white/80">Heures</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="minutes">45</div>
                        <div class="text-xs text-white/80">Minutes</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="seconds">30</div>
                        <div class="text-xs text-white/80">Secondes</div>
                    </div>
                </div>
                
                <a href="#" class="bg-white text-night-900 px-8 py-4 rounded-full font-semibold hover:shadow-2xl hover:scale-105 transition flex items-center gap-2 whitespace-nowrap">
                    J'en profite
                    <i class="fas fa-bolt"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">  <!-- AJOUTER CECI -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-saffron-600 font-semibold text-sm uppercase tracking-wider">Témoignages</span>
                <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mt-4 mb-6">
                    Ils nous font <span class="gradient-text">confiance</span>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-sand-50 p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="flex items-center gap-1 text-saffron-500 text-lg mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-night-600 mb-6 leading-relaxed">
                        "Rideaux magnifiques, qualité exceptionnelle. Le service WhatsApp est ultra rapide, livraison en 24h. Je recommande !"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-terracotta-500 rounded-full flex items-center justify-center text-white font-bold text-xl">A</div>
                        <div>
                            <h4 class="font-bold text-night-900">Aminata Diallo</h4>
                            <p class="text-sm text-night-500">Dakar, Sénégal</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-sand-50 p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="flex items-center gap-1 text-saffron-500 text-lg mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-night-600 mb-6 leading-relaxed">
                        "Draps d'une douceur incroyable. Prix imbattables. Je suis devenue cliente fidèle, toute ma maison est équipée Segnon Shop !"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-safari-600 rounded-full flex items-center justify-center text-white font-bold text-xl">K</div>
                        <div>
                            <h4 class="font-bold text-night-900">Kofi Mensah</h4>
                            <p class="text-sm text-night-500">Abidjan, Côte d'Ivoire</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-sand-50 p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="flex items-center gap-1 text-saffron-500 text-lg mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-night-600 mb-6 leading-relaxed">
                        "Service client exceptionnel. Ils m'ont conseillée pour choisir mes rideaux. Le rendu est magnifique, exactement ce que je voulais."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-saffron-600 rounded-full flex items-center justify-center text-white font-bold text-xl">F</div>
                        <div>
                            <h4 class="font-bold text-night-900">Fatou Ndiaye</h4>
                            <p class="text-sm text-night-500">Dakar, Sénégal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== CTA SECTION ===== -->
    <section class="py-16 bg-night-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">  <!-- AJOUTER CECI -->
            <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mb-6">
                Prêt à transformer votre <span class="text-terracotta-500">intérieur ?</span>
            </h2>
            <p class="text-white/70 text-lg max-w-2xl mx-auto mb-10">
                Nos conseillers sont disponibles 7j/7 pour vous guider dans vos choix.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="https://wa.me/22900000000" class="bg-terracotta-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-terracotta-600 transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fab fa-whatsapp text-xl"></i>
                    WhatsApp direct
                </a>
                <a href="tel:+22900000000" class="bg-white/10 backdrop-blur text-white px-8 py-4 rounded-full font-semibold border-2 border-white/20 hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-phone-alt"></i>
                    Appel rapide
                </a>
                <a href="#" class="bg-white text-night-900 px-8 py-4 rounded-full font-semibold hover:bg-sand-100 transition flex items-center gap-2">
                    <i class="fas fa-envelope"></i>
                    Formulaire
                </a>
            </div>
        </div>
    </section>

      <!-- ===== AVANTAGES ===== -->
    <section class="py-16 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Avantage 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-terracotta-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-2xl text-terracotta-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Livraison gratuite</h3>
                    <p class="text-sm text-night-500">Dès 50 000 F d'achat</p>
                </div>
                
                <!-- Avantage 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-saffron-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-undo-alt text-2xl text-saffron-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Retours faciles</h3>
                    <p class="text-sm text-night-500">Satisfait ou remboursé</p>
                </div>
                
                <!-- Avantage 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-safari-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-safari-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Paiement sécurisé</h3>
                    <p class="text-sm text-night-500">Cartes, mobile money</p>
                </div>
                
                <!-- Avantage 4 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-terracotta-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-terracotta-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Support 7j/7</h3>
                    <p class="text-sm text-night-500">Réponse sous 24h</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ATELIER — SAVOIR-FAIRE ===== -->
    <section class="relative py-12 md:py-16 bg-gradient-to-b from-night-900 to-night-800 text-white overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-terracotta-500 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-sage-500 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-white/5 rounded-full"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                <!-- Contenu texte -->
                <div class="space-y-8 reveal fade-left">
                    <div class="inline-flex items-center gap-3">
                        <span class="w-12 h-0.5 bg-terracotta-500"></span>
                        <span class="text-terracotta-400 text-sm uppercase tracking-[0.3em] font-semibold">L'atelier</span>
                    </div>
                    
                    <h2 class="font-display text-5xl md:text-6xl lg:text-7xl leading-[1.1] font-bold">
                        Ce qui ne <span class="text-terracotta-500 relative inline-block">s'achète
                            <span class="absolute -bottom-2 left-0 w-full h-1 bg-terracotta-500/30 rounded-full"></span>
                        </span> pas
                    </h2>
                    
                    <p class="text-white/70 text-lg md:text-xl leading-relaxed max-w-xl">
                        Le temps, le geste, la rencontre avec la matière. Derrière chaque pièce, 
                        il y a des mains qui savent regarder, des yeux qui savent toucher.
                    </p>
                    
                  
                </div>
                
                <!-- Image avec effets -->
                <div class="relative reveal fade-right">
                    <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&auto=format&fit=crop" 
                            alt="Atelier" 
                            class="w-full h-full object-cover hover:scale-110 transition duration-700">
                    </div>
                    
                    <!-- Badge flottant -->
                    <div class="absolute -bottom-8 -left-8 bg-white/10 backdrop-blur-md text-white p-6 rounded-2xl shadow-2xl border border-white/10 animate-float">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-terracotta-500 rounded-xl flex items-center justify-center text-white">
                                <i class="fab fa-whatsapp text-2xl"></i>
                            </div>
                            <div>
                                <div class="text-sm opacity-70">Conseil privé</div>
                                <div class="text-xl font-display font-semibold">+229 00 00 00 00</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Badge qualité -->
                    <div class="absolute top-8 right-8 bg-white/10 backdrop-blur-md px-6 py-3 rounded-full border border-white/10">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-saffron-500"></i>
                            <span class="font-semibold">Savoir-faire unique</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
    <!-- ===== COLLECTION EXCLUSIVE ===== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header avec style différent -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                Collection <span class="gradient-text">Essentielle</span>
            </h2>
            <p class="text-night-600">Des pièces intemporelles, sélectionnées pour leur qualité exceptionnelle.</p>
        </div>
        
        <!-- Grille différente : 3 colonnes avec mise en avant -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Carte premium 1 -->
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?w=800&auto=format&fit=crop" 
                        alt="Produit" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/60 via-transparent to-transparent"></div>
                    
                    <!-- Badges repositionnés -->
                    <span class="absolute top-4 left-4 bg-terracotta-500 text-white px-4 py-1.5 rounded-full text-xs font-semibold z-10">Exclusivité</span>
                    
                    <!-- Actions flottantes -->
                    <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs text-terracotta-500 font-semibold uppercase tracking-wider">Rideaux</span>
                            <h3 class="font-display font-bold text-xl mt-1">Velours Céleste</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-night-900">24 500 F</span>
                            <span class="text-sm text-night-400 line-through block">35 000 F</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-1 text-saffron-500">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 text-sm ml-1">(45)</span>
                        </div>
                        
                        <a href="#" class="text-terracotta-500 font-semibold text-sm flex items-center gap-1 hover:gap-3 transition-all">
                            Détails <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <!-- WhatsApp direct dans la carte -->
                    <a href="#" class="mt-4 w-full bg-sand-100 text-night-900 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-terracotta-500 hover:text-white transition group">
                        <i class="fab fa-whatsapp text-terracotta-500 group-hover:text-white"></i>
                        <span class="font-medium">Commander sur WhatsApp</span>
                    </a>
                </div>
            </div>
            
            <!-- Carte premium 2 -->
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=800&auto=format&fit=crop" 
                        alt="Produit" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/60 via-transparent to-transparent"></div>
                    
                    <span class="absolute top-4 left-4 bg-safari-600 text-white px-4 py-1.5 rounded-full text-xs font-semibold z-10">Nouveauté</span>
                    
                    <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs text-safari-600 font-semibold uppercase tracking-wider">Draps</span>
                            <h3 class="font-display font-bold text-xl mt-1">Parure 5 pièces</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-night-900">32 000 F</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-1 text-saffron-500">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-night-400 text-sm ml-1">(32)</span>
                        </div>
                        
                        <a href="#" class="text-terracotta-500 font-semibold text-sm flex items-center gap-1 hover:gap-3 transition-all">
                            Détails <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <a href="#" class="mt-4 w-full bg-sand-100 text-night-900 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-terracotta-500 hover:text-white transition group">
                        <i class="fab fa-whatsapp text-terracotta-500 group-hover:text-white"></i>
                        <span class="font-medium">Commander sur WhatsApp</span>
                    </a>
                </div>
            </div>
            
            <!-- Carte premium 3 -->
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800&auto=format&fit=crop" 
                        alt="Produit" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/60 via-transparent to-transparent"></div>
                    
                    <span class="absolute top-4 left-4 bg-saffron-600 text-white px-4 py-1.5 rounded-full text-xs font-semibold z-10">-20%</span>
                    
                    <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs text-saffron-600 font-semibold uppercase tracking-wider">Quincaillerie</span>
                            <h3 class="font-display font-bold text-xl mt-1">Poignée design</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-night-900">8 500 F</span>
                            <span class="text-sm text-night-400 line-through block">10 500 F</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-1 text-saffron-500">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 text-sm ml-1">(18)</span>
                        </div>
                        
                        <a href="#" class="text-terracotta-500 font-semibold text-sm flex items-center gap-1 hover:gap-3 transition-all">
                            Détails <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <a href="#" class="mt-4 w-full bg-sand-100 text-night-900 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-terracotta-500 hover:text-white transition group">
                        <i class="fab fa-whatsapp text-terracotta-500 group-hover:text-white"></i>
                        <span class="font-medium">Commander sur WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Lien vers toute la collection -->
        <div class="text-center mt-8">
            <a href="#" class="inline-flex items-center gap-3 text-night-900 font-semibold group">
                <span>Découvrir toute la collection</span>
                <i class="fas fa-arrow-right group-hover:translate-x-2 transition"></i>
                <span class="w-12 h-0.5 bg-terracotta-500 group-hover:w-20 transition-all"></span>
            </a>
        </div>
    </section>


    <!-- ===== NOS SERVICES ===== -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-wider">Services</span>
                <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                    Un accompagnement <span class="gradient-text">sur mesure</span>
                </h2>
                <p class="text-night-600">De la conception à l'installation, nous sommes à vos côtés.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="text-center p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="w-20 h-20 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-ruler-combined text-3xl text-terracotta-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-3">Conseil & sur-mesure</h3>
                    <p class="text-night-600">Nos experts vous guident pour choisir les bonnes dimensions et matières.</p>
                </div>
                
                <!-- Service 2 -->
                <div class="text-center p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="w-20 h-20 bg-saffron-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-tools text-3xl text-saffron-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-3">Installation à domicile</h3>
                    <p class="text-night-600">Pose de vos rideaux et tringles par nos équipes qualifiées.</p>
                </div>
                
                <!-- Service 3 -->
                <div class="text-center p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="w-20 h-20 bg-safari-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-3xl text-safari-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-3">Suivi après-vente</h3>
                    <p class="text-night-600">Service client disponible 7j/7 pour répondre à vos questions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MARQUES PARTENAIRES ===== -->
    {{-- <section class="py-16 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-saffron-600 font-semibold text-sm uppercase tracking-wider">Ils nous font confiance</span>
                <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                    Nos <span class="gradient-text">partenaires</span>
                </h2>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                <!-- Partenaire 1 -->
                <div class="bg-white p-6 rounded-xl flex items-center justify-center hover:shadow-md transition grayscale hover:grayscale-0">
                    <span class="text-2xl font-display font-bold text-night-400">TISSÔT</span>
                </div>
                <!-- Partenaire 2 -->
                <div class="bg-white p-6 rounded-xl flex items-center justify-center hover:shadow-md transition grayscale hover:grayscale-0">
                    <span class="text-2xl font-display font-bold text-night-400">LINVOS</span>
                </div>
                <!-- Partenaire 3 -->
                <div class="bg-white p-6 rounded-xl flex items-center justify-center hover:shadow-md transition grayscale hover:grayscale-0">
                    <span class="text-2xl font-display font-bold text-night-400">DÉCO+</span>
                </div>
                <!-- Partenaire 4 -->
                <div class="bg-white p-6 rounded-xl flex items-center justify-center hover:shadow-md transition grayscale hover:grayscale-0">
                    <span class="text-2xl font-display font-bold text-night-400">AFRICA HOME</span>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- ===== FAQ ===== -->
    <section class="py-16 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-wider">FAQs</span>
                <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                    Questions <span class="gradient-text">fréquentes</span>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                    <h3 class="font-display font-bold text-lg mb-2">Quels sont les délais de livraison ?</h3>
                    <p class="text-night-600">Livraison sous 24h à Cotonou, 48h en province.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                    <h3 class="font-display font-bold text-lg mb-2">Comment passer commande ?</h3>
                    <p class="text-night-600">Par WhatsApp, téléphone ou formulaire de contact.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                    <h3 class="font-display font-bold text-lg mb-2">Puis-je retourner un article ?</h3>
                    <p class="text-night-600">Retour gratuit sous 14 jours, satisfait ou remboursé.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                    <h3 class="font-display font-bold text-lg mb-2">Proposez-vous du sur-mesure ?</h3>
                    <p class="text-night-600">Oui, contactez-nous pour vos dimensions spécifiques.</p>
                </div>
            </div>
            
            <div class="text-center mt-10">
                <a href="#" class="text-terracotta-500 font-semibold hover:underline">Voir toutes les questions →</a>
            </div>
        </div>
    </section>

@endsection