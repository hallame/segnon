@extends('frontend.layouts.master')

@section('title', 'Tous nos produits - Segnon Shop')
@section('meta_description', 'Découvrez tous nos produits : rideaux, draps, quincaillerie et décoration. Qualité premium et service personnalisé.')
@section('og_image', asset('assets/images/produits-segnon.jpg'))

@section('content')

<!-- ===== HERO PRODUITS ===== -->
<section class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-terracotta-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-safari-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float-slow"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 lg:py-24">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold mt-6 mb-8 leading-[1.1]">
                Des produits <span class="gradient-text">d'exception</span><br>pour votre intérieur
            </h1>
            <p class="text-xl text-night-600 max-w-3xl mx-auto">
                Plus de 200 références soigneusement sélectionnées pour sublimer chaque pièce de votre maison.
            </p>
        </div>
    </div>
</section>

<!-- ===== BARRE DE RECHERCHE AVANCÉE ===== -->
<section class="py-8 bg-white border-b border-sand-200 sticky top-20 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
            <!-- Recherche -->
            <div class="relative w-full lg:w-96">
                <input type="text" 
                       placeholder="Rechercher un produit..." 
                       class="w-full px-6 py-4 rounded-full border-2 border-sand-200 focus:border-terracotta-500 outline-none transition pl-14">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-night-400"></i>
            </div>
            
            <!-- Filtres et tri -->
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-night-600 text-sm whitespace-nowrap">Filtrer par :</span>
                    <select class="px-4 py-3 rounded-xl border-2 border-sand-200 bg-white focus:border-terracotta-500 outline-none">
                        <option>Catégorie</option>
                        <option>Rideaux</option>
                        <option>Draps</option>
                        <option>Quincaillerie</option>
                        <option>Décoration</option>
                    </select>
                    
                    <select class="px-4 py-3 rounded-xl border-2 border-sand-200 bg-white focus:border-terracotta-500 outline-none">
                        <option>Prix</option>
                        <option>Moins de 10 000 F</option>
                        <option>10 000 - 25 000 F</option>
                        <option>25 000 - 50 000 F</option>
                        <option>Plus de 50 000 F</option>
                    </select>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-night-600 text-sm">Trier par :</span>
                    <select class="px-4 py-3 rounded-xl border-2 border-sand-200 bg-white focus:border-terracotta-500 outline-none">
                        <option>Popularité</option>
                        <option>Nouveautés</option>
                        <option>Prix croissant</option>
                        <option>Prix décroissant</option>
                        <option>Notes</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Filtres actifs -->
        <div class="flex flex-wrap items-center gap-2 mt-6">
            <span class="text-sm text-night-500">Filtres actifs :</span>
            <span class="bg-sand-100 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                Rideaux <i class="fas fa-times cursor-pointer hover:text-terracotta-500"></i>
            </span>
            <span class="bg-sand-100 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                10 000 - 25 000 F <i class="fas fa-times cursor-pointer hover:text-terracotta-500"></i>
            </span>
            <button class="text-terracotta-500 text-sm hover:underline">Effacer tout</button>
        </div>
    </div>
</section>

<!-- ===== SECTION PROMO FLASH ===== -->
<section class="py-8 bg-gradient-to-r from-terracotta-600 to-saffron-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <span class="bg-white/20 px-4 py-2 rounded-full text-sm font-semibold animate-pulse">🔥 -30%</span>
                <span class="font-medium">Livraison gratuite dès 50 000 F d'achat</span>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock"></i>
                    <span class="font-medium">Fin dans :</span>
                </div>
                <div class="flex gap-2">
                    <div class="bg-white/20 backdrop-blur px-3 py-1 rounded-lg text-center min-w-[50px]">
                        <span class="text-xl font-bold" id="flash-days">02</span>
                        <span class="text-xs block">Jours</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur px-3 py-1 rounded-lg text-center min-w-[50px]">
                        <span class="text-xl font-bold" id="flash-hours">14</span>
                        <span class="text-xs block">Heures</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur px-3 py-1 rounded-lg text-center min-w-[50px]">
                        <span class="text-xl font-bold" id="flash-minutes">35</span>
                        <span class="text-xs block">Minutes</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur px-3 py-1 rounded-lg text-center min-w-[50px]">
                        <span class="text-xl font-bold" id="flash-seconds">42</span>
                        <span class="text-xs block">Secondes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== GRILLE PRODUITS ===== -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec résultats -->
        <div class="flex flex-wrap items-center justify-between mb-8">
            <p class="text-night-600">
                <span class="font-bold text-terracotta-500">156 produits</span> trouvés
            </p>
            <div class="flex items-center gap-2">
                <span class="text-night-600">Vue :</span>
                <button class="p-2 rounded-lg bg-terracotta-500 text-white">
                    <i class="fas fa-grid-2"></i>
                </button>
                <button class="p-2 rounded-lg bg-sand-100 text-night-600 hover:bg-sand-200 transition">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
        
        <!-- Grille 4 colonnes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Produit 1 - Best-seller -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <!-- Badges -->
                    <span class="absolute top-3 left-3 z-10 bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full">-30%</span>
                    <span class="absolute top-3 right-3 z-10 bg-saffron-500 text-white text-xs px-3 py-1 rounded-full">Best-seller</span>
                    
                    <!-- Wishlist -->
                    <button class="absolute top-3 right-16 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <!-- Image -->
                    <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?w=800&auto=format&fit=crop" 
                         alt="Rideau Velours" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <!-- Overlay Actions (apparaît au hover) -->
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <!-- Infos produit -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-terracotta-500 font-semibold uppercase tracking-wider">Rideaux</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 ml-1">(45)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Rideau Velours Premium</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">24 500 F</span>
                        <span class="text-sm text-night-400 line-through">35 000 F</span>
                    </div>
                    
                    <!-- Disponibilité -->
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-night-500">En stock (12 pièces)</span>
                    </div>
                    
                    <!-- Options couleurs (simulées) -->
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-5 h-5 rounded-full bg-amber-800 border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                        <span class="w-5 h-5 rounded-full bg-gray-800 border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                        <span class="w-5 h-5 rounded-full bg-amber-200 border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                        <span class="text-xs text-night-400">+3</span>
                    </div>
                    
                    <!-- Bouton ajout rapide -->
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i>
                        Ajouter au panier
                    </button>
                </div>
            </div>
            
            <!-- Produit 2 - Nouveau -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-safari-600 text-white text-xs px-3 py-1 rounded-full">Nouveau</span>
                    <span class="absolute top-3 right-3 z-10 bg-emerald-500 text-white text-xs px-3 py-1 rounded-full">Bio</span>
                    
                    <button class="absolute top-3 right-16 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=800&auto=format&fit=crop" 
                         alt="Drap Satin" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-safari-600 font-semibold uppercase tracking-wider">Draps</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(32)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Parure de lit 5 pièces</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">32 000 F</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-night-500">En stock (8 pièces)</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-5 h-5 rounded-full bg-white border border-night-300 shadow-sm cursor-pointer hover:scale-110 transition"></span>
                        <span class="w-5 h-5 rounded-full bg-slate-200 border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                        <span class="w-5 h-5 rounded-full bg-amber-100 border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                    </div>
                    
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i>
                        Ajouter au panier
                    </button>
                </div>
            </div>
            
            <!-- Produit 3 - En promotion -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full">-20%</span>
                    <span class="absolute top-3 right-3 z-10 bg-purple-500 text-white text-xs px-3 py-1 rounded-full">Exclusif</span>
                    
                    <button class="absolute top-3 right-16 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800&auto=format&fit=crop" 
                         alt="Poignée design" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-purple-600 font-semibold uppercase tracking-wider">Quincaillerie</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 ml-1">(18)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Poignée de porte design</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">8 500 F</span>
                        <span class="text-sm text-night-400 line-through">10 500 F</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-night-500">En stock (24 pièces)</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-5 h-5 rounded-full bg-amber-600 border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                        <span class="w-5 h-5 rounded-full bg-gray-400 border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                        <span class="w-5 h-5 rounded-full bg-black border-2 border-white shadow-sm cursor-pointer hover:scale-110 transition"></span>
                    </div>
                    
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i>
                        Ajouter au panier
                    </button>
                </div>
            </div>
            
            <!-- Produit 4 - Décoration -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-amber-600 text-white text-xs px-3 py-1 rounded-full">Pièce unique</span>
                    
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <img src="https://images.unsplash.com/photo-1567225591450-0605936a7f2c?w=800&auto=format&fit=crop" 
                         alt="Miroir doré" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-amber-600 font-semibold uppercase tracking-wider">Décoration</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(27)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Miroir doré sculpté</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">18 000 F</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-night-500">En stock (3 pièces)</span>
                    </div>
                    
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i>
                        Ajouter au panier
                    </button>
                </div>
            </div>
            
            <!-- Produit 5 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full">-15%</span>
                    
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?w=800&auto=format&fit=crop" 
                         alt="Rideau lin" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-terracotta-500 font-semibold">Rideaux</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(38)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Rideau en lin naturel</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">29 900 F</span>
                        <span class="text-sm text-night-400 line-through">35 000 F</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                        <span class="text-xs text-night-500">Bientôt disponible</span>
                    </div>
                    
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2 opacity-50 cursor-not-allowed" disabled>
                        <i class="fas fa-bell"></i>
                        Me prévenir
                    </button>
                </div>
            </div>
            
            <!-- Produit 6 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-safari-600 text-white text-xs px-3 py-1 rounded-full">Nouveau</span>
                    
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=800&auto=format&fit=crop" 
                         alt="Drap microfibre" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-safari-600 font-semibold">Draps</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 ml-1">(12)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Drap microfibre 180cm</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">12 500 F</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-night-500">En stock (15 pièces)</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-5 h-5 rounded-full bg-white border border-night-300"></span>
                        <span class="w-5 h-5 rounded-full bg-blue-200 border-2 border-white"></span>
                        <span class="w-5 h-5 rounded-full bg-pink-200 border-2 border-white"></span>
                    </div>
                    
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i>
                        Ajouter au panier
                    </button>
                </div>
            </div>
            
            <!-- Produit 7 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-purple-600 text-white text-xs px-3 py-1 rounded-full">Exclusif</span>
                    
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800&auto=format&fit=crop" 
                         alt="Tringle design" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-purple-600 font-semibold">Quincaillerie</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(9)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Tringle design noire</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">15 500 F</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-night-500">En stock (6 pièces)</span>
                    </div>
                    
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i>
                        Ajouter au panier
                    </button>
                </div>
            </div>
            
            <!-- Produit 8 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift border border-sand-100">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-amber-600 text-white text-xs px-3 py-1 rounded-full">Artisanal</span>
                    
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?w=800&auto=format&fit=crop" 
                         alt="Coussin" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-eye"></i> Aperçu
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-amber-600 font-semibold">Décoration</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(21)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-display font-bold text-lg">Coussin wax 45x45cm</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">7 500 F</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-night-500">En stock (20 pièces)</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-5 h-5 rounded-full bg-red-800 border-2 border-white"></span>
                        <span class="w-5 h-5 rounded-full bg-blue-800 border-2 border-white"></span>
                        <span class="w-5 h-5 rounded-full bg-yellow-600 border-2 border-white"></span>
                    </div>
                    
                    <button class="w-full mt-3 bg-sand-100 text-night-900 py-2 rounded-xl text-sm font-medium hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i>
                        Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
        
        <!-- PAGINATION -->
        <div class="flex justify-center mt-16 gap-2">
            <a href="#" class="w-10 h-10 rounded-full bg-terracotta-500 text-white flex items-center justify-center hover:bg-terracotta-600 transition">1</a>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">2</a>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">3</a>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">4</a>
            <span class="w-10 h-10 flex items-center justify-center text-night-500">...</span>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">12</a>
            <a href="#" class="w-10 h-10 rounded-full bg-sand-200 text-night-700 hover:bg-terracotta-500 hover:text-white transition flex items-center justify-center">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- ===== CATÉGORIES POPULAIRES ===== -->
<section class="py-16 bg-sand-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-wider">Catégories</span>
            <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                Nos univers <span class="gradient-text">phares</span>
            </h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#" class="group relative overflow-hidden rounded-2xl aspect-square">
                <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=400" alt="Rideaux" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                    <h3 class="font-display font-bold text-lg">Rideaux</h3>
                    <p class="text-white/70 text-sm">120+ modèles</p>
                </div>
            </a>
            <a href="#" class="group relative overflow-hidden rounded-2xl aspect-square">
                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=400" alt="Draps" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                    <h3 class="font-display font-bold text-lg">Draps</h3>
                    <p class="text-white/70 text-sm">45+ modèles</p>
                </div>
            </a>
            <a href="#" class="group relative overflow-hidden rounded-2xl aspect-square">
                <img src="https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=400" alt="Quincaillerie" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                    <h3 class="font-display font-bold text-lg">Quincaillerie</h3>
                    <p class="text-white/70 text-sm">80+ références</p>
                </div>
            </a>
            <a href="#" class="group relative overflow-hidden rounded-2xl aspect-square">
                <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?w=400" alt="Décoration" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                    <h3 class="font-display font-bold text-lg">Décoration</h3>
                    <p class="text-white/70 text-sm">60+ pièces</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ===== PRODUITS RÉCEMMENT CONSULTÉS ===== -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-display font-bold">Récemment consultés</h3>
            <a href="#" class="text-terracotta-500 hover:underline text-sm flex items-center gap-1">
                Voir tout <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <!-- Mini produit 1 -->
            <a href="#" class="group">
                <div class="aspect-square rounded-xl overflow-hidden mb-2 bg-sand-100">
                    <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?w=200" alt="Produit" class="w-full h-full object-cover group-hover:scale-110 transition">
                </div>
                <p class="text-sm font-medium truncate">Rideau velours</p>
                <p class="text-xs text-terracotta-500">24 500 F</p>
            </a>
            <a href="#" class="group">
                <div class="aspect-square rounded-xl overflow-hidden mb-2 bg-sand-100">
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=200" alt="Produit" class="w-full h-full object-cover group-hover:scale-110 transition">
                </div>
                <p class="text-sm font-medium truncate">Drap satin</p>
                <p class="text-xs text-terracotta-500">32 000 F</p>
            </a>
            <a href="#" class="group">
                <div class="aspect-square rounded-xl overflow-hidden mb-2 bg-sand-100">
                    <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=200" alt="Produit" class="w-full h-full object-cover group-hover:scale-110 transition">
                </div>
                <p class="text-sm font-medium truncate">Poignée design</p>
                <p class="text-xs text-terracotta-500">8 500 F</p>
            </a>
            <a href="#" class="group">
                <div class="aspect-square rounded-xl overflow-hidden mb-2 bg-sand-100">
                    <img src="https://images.unsplash.com/photo-1567225591450-0605936a7f2c?w=200" alt="Produit" class="w-full h-full object-cover group-hover:scale-110 transition">
                </div>
                <p class="text-sm font-medium truncate">Miroir doré</p>
                <p class="text-xs text-terracotta-500">18 000 F</p>
            </a>
            <a href="#" class="group">
                <div class="aspect-square rounded-xl overflow-hidden mb-2 bg-sand-100">
                    <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=200" alt="Produit" class="w-full h-full object-cover group-hover:scale-110 transition">
                </div>
                <p class="text-sm font-medium truncate">Rideau occultant</p>
                <p class="text-xs text-terracotta-500">28 000 F</p>
            </a>
            <a href="#" class="group">
                <div class="aspect-square rounded-xl overflow-hidden mb-2 bg-sand-100">
                    <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?w=200" alt="Produit" class="w-full h-full object-cover group-hover:scale-110 transition">
                </div>
                <p class="text-sm font-medium truncate">Coussin wax</p>
                <p class="text-xs text-terracotta-500">7 500 F</p>
            </a>
        </div>
    </div>
</section>

<!-- ===== SECTION AIDE & CONTACT ===== -->
<section class="py-16 bg-night-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Aide 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-terracotta-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-question-circle text-2xl text-terracotta-500"></i>
                </div>
                <h4 class="font-display font-bold text-lg mb-2">Une question ?</h4>
                <p class="text-white/70 text-sm mb-4">Consultez notre FAQ ou contactez-nous directement.</p>
                <a href="/faq" class="text-terracotta-500 hover:underline">Voir la FAQ →</a>
            </div>
            
            <!-- Aide 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-saffron-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fab fa-whatsapp text-2xl text-saffron-500"></i>
                </div>
                <h4 class="font-display font-bold text-lg mb-2">WhatsApp direct</h4>
                <p class="text-white/70 text-sm mb-4">Réponse sous 1h en moyenne.</p>
                <a href="https://wa.me/22900000000" class="text-terracotta-500 hover:underline">+229 00 00 00 00 →</a>
            </div>
            
            <!-- Aide 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-safari-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-safari-500"></i>
                </div>
                <h4 class="font-display font-bold text-lg mb-2">Newsletter</h4>
                <p class="text-white/70 text-sm mb-4">Recevez nos offres exclusives.</p>
                <a href="#newsletter" class="text-terracotta-500 hover:underline">S'inscrire →</a>
            </div>
        </div>
    </div>
</section>

<script>
    // Countdown timer pour la promo flash
    function updateFlashTimer() {
        // Exemple : fin dans 2 jours 14h 35min 42s
        // À remplacer par une vraie logique de date
        let d = 2, h = 14, m = 35, s = 42;
        
        s--;
        if (s < 0) { s = 59; m--; }
        if (m < 0) { m = 59; h--; }
        if (h < 0) { h = 23; d--; }
        
        document.getElementById('flash-days').textContent = d.toString().padStart(2, '0');
        document.getElementById('flash-hours').textContent = h.toString().padStart(2, '0');
        document.getElementById('flash-minutes').textContent = m.toString().padStart(2, '0');
        document.getElementById('flash-seconds').textContent = s.toString().padStart(2, '0');
    }
    
    setInterval(updateFlashTimer, 1000);
</script>

@endsection