@extends('frontend.layouts.master')

@section('title', 'Comment augmenter ses ventes avec MYLMARK • Guide pratique')
@section('meta_title', 'Comment augmenter vos ventes')
@section('meta_description', 'Les étapes concrètes pour booster vos ventes avec MYLMARK. Guide pour vendre plus et mieux.')
@section('meta_image', asset('assets/images/boost.png'))

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-white">
    <div class="relative max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 pt-10 pb-12">
        <!-- Animated background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <!-- Content -->
        <div class="relative text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="h-px w-8 bg-gradient-to-r from-transparent to-emerald-400"></div>
                <span class="text-sm uppercase tracking-[0.3em] font-bold text-emerald-300">GUIDE PRATIQUE</span>
                <div class="h-px w-8 bg-gradient-to-r from-emerald-400 to-transparent"></div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-tight mb-6">
                <span class="block">Comment <span class="bg-gradient-to-r from-emerald-400 via-cyan-300 to-blue-400 bg-clip-text text-transparent">augmenter</span></span>
                <span class="block">vos ventes</span>
            </h1>

            <!-- Description -->
            <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto mb-8">
                Les étapes simples pour transformer votre vitrine en machine à vendre
            </p>
            <!-- CTA -->
            <a href="#step1"
               class="group inline-flex items-center justify-center gap-3 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 text-base font-bold shadow-xl hover:shadow-2xl hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300">
                <i class="ri-play-circle-line text-xl"></i>
                Découvrir la méthode
                <i class="ri-arrow-right-line text-xl group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
    </div>
</section>


<!-- Introduction - Version clean et directe -->
<section class="py-8 md:py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Carte principale -->
        <div class="relative rounded-3xl bg-white shadow-lg border border-slate-100 overflow-hidden">
            <!-- Décorations minimales -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-blue-500"></div>

            <div class="relative p-6 md:p-8">
                <!-- En-tête -->
                <div class="flex flex-col md:flex-row md:items-center gap-6 md:gap-8 mb-8">

                    <!-- Titre -->
                    <div>
                        <span class="inline-block text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-2">
                            Le véritable rôle de MYLMARK
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">
                            Nous optimisons votre processus de vente
                        </h2>
                    </div>
                </div>

                <!-- Grid d'avantages -->
                <div class="grid md:grid-cols-3 gap-6 mb-6">
                    <!-- Avantage 1 -->
                    <div class="flex flex-col items-center text-center p-6 rounded-xl bg-emerald-50/50">
                        <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-4">
                            <i class="ri-time-line text-emerald-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Gain de temps</h3>
                        <p class="text-sm text-slate-600">Votre multiplicateur d'efficacité</p>
                    </div>

                    <!-- Avantage 2 -->
                    <div class="flex flex-col items-center text-center p-6 rounded-xl bg-blue-50/50">
                        <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                            <i class="ri-presentation-line text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Présentation pro</h3>
                        <p class="text-sm text-slate-600">Vitrine 24h/24 optimisée</p>
                    </div>

                    <!-- Avantage 3 -->
                    <div class="flex flex-col items-center text-center p-6 rounded-xl bg-purple-50/50">
                        <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                            <i class="ri-arrow-up-line text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-2">Plus de conversions</h3>
                        <p class="text-sm text-slate-600">Transformez plus d'opportunités</p>
                    </div>
                </div>

                <!-- Message clé -->
                <div class="text-center">
                    <div class="inline-flex items-center gap-3 px-4 py-2.5 rounded-xl bg-white border border-slate-100 shadow-sm">
                        <i class="ri-user-star-line text-emerald-500 text-sm"></i>
                        <p class="text-sm text-slate-700">
                            <span class="italic text-slate-600">Nous optimisons,</span>
                            <span class="font-semibold text-emerald-700">vous décidez</span>
                        </p>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

{{-- <style>
    @media (max-width: 768px) {
        .grid-cols-3 {
            grid-template-columns: 1fr;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }
    }
</style> --}}


<!-- Steps Timeline -->
<section class="bg-gradient-to-b from-white to-slate-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-4">
                Les <span class="text-emerald-600">4 étapes</span> pour multiplier vos ventes
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Une méthode simple qui fonctionne
            </p>
        </div>

        <!-- Steps Container -->
        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-px bg-gradient-to-b from-emerald-300 to-blue-300 hidden md:block"></div>

            <!-- Step 1 -->
            <div id="step1" class="relative mb-16 md:mb-24">
                <div class="md:flex items-center gap-8">
                    <!-- Visual -->
                    <div class="md:w-1/2 mb-8 md:mb-0 md:pr-12">
                        <div class="bg-gradient-to-br from-emerald-50 to-blue-50 rounded-2xl p-6 border border-emerald-100">
                            <div class="text-center mb-6">
                                <div class="inline-flex h-16 w-16 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 text-white items-center justify-center text-2xl font-bold mb-4">
                                    1
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">1 lien unique</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
                                    <i class="ri-check-line text-emerald-500"></i>
                                    <span class="text-sm">Finies les 100 photos WhatsApp</span>
                                </div>
                                <div class="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
                                    <i class="ri-check-line text-emerald-500"></i>
                                    <span class="text-sm">Tout dans une seule vitrine pro</span>
                                </div>
                                <div class="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm">
                                    <i class="ri-check-line text-emerald-500"></i>
                                    <span class="text-sm">Informations toujours à jour</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:w-1/2 md:pl-12">
                        <div class="inline-flex items-center gap-2 mb-4">
                            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-sm font-bold text-emerald-700 uppercase tracking-wider">ÉTAPE 1</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">
                            Centralisez tous vos produits
                        </h3>
                        <p class="text-slate-600 mb-6">
                            Remplacez les échanges WhatsApp interminables par un <span class="font-semibold text-emerald-700">lien unique et professionnel.</span>
                        </p>

                        <div class="bg-emerald-50 rounded-xl p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <i class="ri-time-line text-emerald-600 text-xl mt-1"></i>
                                <div>
                                    <p class="font-bold text-emerald-900">Gagnez 2 heures par jour</p>
                                    <p class="text-sm text-emerald-800">Moins de messages, plus de ventes</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center gap-4">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-emerald-600">×10</div>
                                <div class="text-xs text-slate-600">Plus pro</div>
                            </div>
                            <div class="h-8 w-px bg-slate-300"></div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-emerald-600">-85%</div>
                                <div class="text-xs text-slate-600">De questions</div>
                            </div>
                            <div class="h-8 w-px bg-slate-300"></div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-emerald-600">+40%</div>
                                <div class="text-xs text-slate-600">Confiance client</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div id="step2" class="relative mb-16 md:mb-24">
                <div class="md:flex items-center gap-8 flex-row-reverse">
                    <!-- Visual -->
                    <div class="md:w-1/2 mb-8 md:mb-0 md:pl-12">
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-100">
                            <div class="text-center mb-6">
                                <div class="inline-flex h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white items-center justify-center text-2xl font-bold mb-4">
                                    2
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">Partagez partout</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-4 bg-white rounded-xl">
                                    <i class="ri-whatsapp-line text-green-500 text-2xl mb-2"></i>
                                    <div class="text-sm font-medium">WhatsApp</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-xl">
                                    <i class="ri-facebook-line text-blue-600 text-2xl mb-2"></i>
                                    <div class="text-sm font-medium">Facebook</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-xl">
                                    <i class="ri-instagram-line text-pink-500 text-2xl mb-2"></i>
                                    <div class="text-sm font-medium">Instagram</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-xl">
                                    <i class="ri-link text-slate-600 text-2xl mb-2"></i>
                                    <div class="text-sm font-medium">Partout</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:w-1/2 md:pr-12">
                        <div class="inline-flex items-center gap-2 mb-4">
                            <div class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></div>
                            <span class="text-sm font-bold text-blue-700 uppercase tracking-wider">ÉTAPE 2</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">
                            Partagez votre lien partout
                        </h3>
                        <p class="text-slate-600 mb-6">
                            Votre lien MYLMARK voyage pour vous. <span class="font-semibold text-blue-700">Plus il est vu, plus vous vendez.</span>
                        </p>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-blue-500"></i>
                                <span class="text-slate-700">Dans vos statuts WhatsApp</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-blue-500"></i>
                                <span class="text-slate-700">En bio Instagram</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-blue-500"></i>
                                <span class="text-slate-700">Sur Facebook </span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-blue-500"></i>
                                <span class="text-slate-700">Par SMS à vos contacts</span>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="font-bold text-blue-900 mb-2">
                                <i class="ri-lightbulb-flash-line text-blue-600"></i>
                                Pro tip
                            </p>
                            <p class="text-sm text-blue-800">
                                Gardez votre lien dans les favoris de votre téléphone pour un partage ultra-rapide.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div id="step3" class="relative mb-16 md:mb-24">
                <div class="md:flex items-center gap-8">
                    <!-- Visual -->
                    <div class="md:w-1/2 mb-8 md:mb-0 md:pr-12">
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
                            <div class="text-center mb-6">
                                <div class="inline-flex h-16 w-16 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 text-white items-center justify-center text-2xl font-bold mb-4">
                                    3
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">Vendez en 1 clic</h3>
                            </div>
                            <div class="text-center">
                                <div class="inline-flex items-center gap-2 mb-4">
                                    <div class="h-12 w-12 rounded-xl bg-white shadow flex items-center justify-center">
                                        <i class="ri-shopping-cart-2-line text-purple-600 text-xl"></i>
                                    </div>
                                    <div class="text-3xl font-bold text-purple-600">→</div>
                                    <div class="h-12 w-12 rounded-xl bg-white shadow flex items-center justify-center">
                                        <i class="ri-money-dollar-circle-line text-green-600 text-xl"></i>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-700">
                                    Moins de questions, plus d'achats
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:w-1/2 md:pl-12">
                        <div class="inline-flex items-center gap-2 mb-4">
                            <div class="h-2 w-2 rounded-full bg-purple-500 animate-pulse"></div>
                            <span class="text-sm font-bold text-purple-700 uppercase tracking-wider">ÉTAPE 3</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">
                            Vendez sans friction
                        </h3>
                        <p class="text-slate-600 mb-6">
                            Vos clients peuvent <span class="font-semibold text-purple-700">commander ou vous contacter directement</span> depuis votre boutique.
                        </p>

                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-xl p-4 border border-slate-200">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-message-2-line text-purple-600"></i>
                                    <h4 class="font-bold text-slate-900">Contact direct</h4>
                                </div>
                                <p class="text-xs text-slate-600">
                                    Le client voit déjà le produit, le prix, la description
                                </p>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-slate-200">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-shopping-bag-line text-purple-600"></i>
                                    <h4 class="font-bold text-slate-900">Commande rapide</h4>
                                </div>
                                <p class="text-xs text-slate-600">
                                    Coordonnées pré-remplies, confirmation instantanée
                                </p>
                            </div>
                        </div>

                        <div class="bg-purple-50 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-purple-900 mb-1">-67% de questions</p>
                                    <p class="text-xs text-purple-800">Clients mieux informés = moins d'échanges</p>
                                </div>
                                <div class="text-2xl font-bold text-purple-600">⬆️</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div id="step4" class="relative">
                <div class="md:flex items-center gap-8 flex-row-reverse">
                    <!-- Visual -->
                    <div class="md:w-1/2 mb-8 md:mb-0 md:pl-12">
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100">
                            <div class="text-center mb-6">
                                <div class="inline-flex h-16 w-16 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 text-white items-center justify-center text-2xl font-bold mb-4">
                                    4
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">Croissance continue</h3>
                            </div>
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center gap-4 mb-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-amber-600">J1</div>
                                        <div class="text-xs text-slate-600">Démarrage</div>
                                    </div>
                                    <i class="ri-arrow-right-line text-slate-400"></i>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-amber-600">JT</div>
                                        <div class="text-xs text-slate-600">Premières ventes</div>
                                    </div>
                                    <i class="ri-arrow-right-line text-slate-400"></i>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-amber-600">JX</div>
                                        <div class="text-xs text-slate-600">+30% ventes</div>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-700">
                                    La régularité paie toujours
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="md:w-1/2 md:pr-12">
                        <div class="inline-flex items-center gap-2 mb-4">
                            <div class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></div>
                            <span class="text-sm font-bold text-amber-700 uppercase tracking-wider">ÉTAPE 4</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">
                            Communiquez et grandissez
                        </h3>
                        <p class="text-slate-600 mb-6">
                            Une vitrine active crée la confiance. <span class="font-semibold text-amber-700">La régularité fait vendre.</span>
                        </p>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <i class="ri-megaphone-line text-amber-600"></i>
                                    <span class="text-sm font-medium">Publiez régulièrement</span>
                                </div>
                                <span class="text-xs text-slate-500">2-3×/semaine</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <i class="ri-chat-3-line text-amber-600"></i>
                                    <span class="text-sm font-medium">Répondez vite</span>
                                </div>
                                <span class="text-xs text-slate-500">< 1 heure</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <i class="ri-refresh-line text-amber-600"></i>
                                    <span class="text-sm font-medium">Mettez à jour</span>
                                </div>
                                <span class="text-xs text-slate-500">Stocks, prix</span>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-200">
                            <p class="font-bold text-amber-900">
                                <i class="ri-trophy-line text-amber-600"></i>
                                Résultat : <span class="text-amber-700">+73% de ventes</span> en moyenne
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.sections.why')

<!-- Quick Tips -->
<section class="bg-slate-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-4">
                <span class="text-emerald-600">3 astuces</span> pour maximiser vos résultats
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Petits ajustements, grands impacts
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-4">
                    <i class="ri-camera-3-line text-emerald-600 text-xl"></i>
                </div>
                <h4 class="font-bold text-slate-900 mb-3">Photos de qualité</h4>
                <p class="text-slate-600 text-sm">
                    Une photo claire vaut 10 messages. Prenez le temps de bien présenter vos produits.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                    <i class="ri-speed-up-line text-blue-600 text-xl"></i>
                </div>
                <h4 class="font-bold text-slate-900 mb-3">Réactivité</h4>
                <p class="text-slate-600 text-sm">
                    Répondez sous 1 heure. Un client qui attend trop longtemps part ailleurs.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                    <i class="ri-refresh-line text-purple-600 text-xl"></i>
                </div>
                <h4 class="font-bold text-slate-900 mb-3">Mises à jour</h4>
                <p class="text-slate-600 text-sm">
                    Gardez vos stocks et prix à jour. Rien ne tue plus une vente qu'un produit "déjà vendu".
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Success Story -->
<section class="bg-gradient-to-br from-emerald-900/20 to-slate-900 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 sm:p-8 border border-emerald-800/30">
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 mb-4">
                    <i class="ri-star-fill text-amber-400"></i>
                    <span class="text-sm font-bold text-amber-300 uppercase tracking-wider">TÉMOIGNAGE</span>
                    <i class="ri-star-fill text-amber-400"></i>
                </div>
                <h3 class="text-2xl sm:text-3xl font-bold text-white mb-4">
                    "J'ai multiplié mes ventes par 2 en 1 mois"
                </h3>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="md:w-1/3 text-center">
                    <div class="inline-flex h-20 w-20 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 items-center justify-center text-2xl font-bold text-white mb-4">
                        S.B.
                    </div>
                    <p class="text-white font-medium">Samuel, vendeur</p>
                    <p class="text-slate-400 text-sm">Bohicon</p>
                </div>

                <div class="md:w-2/3">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="ri-checkbox-circle-fill text-emerald-400 text-lg mt-1"></i>
                            <p class="text-slate-300">
                                "Avant, je passais 3 heures par jour à envoyer des photos sur WhatsApp. Maintenant, j'envoie juste mon lien."
                            </p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="ri-checkbox-circle-fill text-emerald-400 text-lg mt-1"></i>
                            <p class="text-slate-300">
                                "Mes clients sont plus confiants parce qu'ils voient une vraie boutique. J'ai perdu moins de ventes."
                            </p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="ri-checkbox-circle-fill text-emerald-400 text-lg mt-1"></i>
                            <p class="text-slate-300">
                                "Pour 3 500 FCFA par mois, je gagne du temps et je vends plus. Le meilleur investissement de mon business."
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="text-center bg-slate-800/50 rounded-xl p-3">
                            <div class="text-xl font-bold text-emerald-300">×2</div>
                            <div class="text-xs text-slate-400">Ventes</div>
                        </div>
                        <div class="text-center bg-slate-800/50 rounded-xl p-3">
                            <div class="text-xl font-bold text-emerald-300">-70%</div>
                            <div class="text-xs text-slate-400">Temps perdu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="bg-gradient-to-br from-slate-50 to-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-200 px-4 py-2 mb-6">
            <i class="ri-fire-fill text-emerald-600"></i>
            <span class="text-sm font-semibold text-emerald-700">20+ VENDEURS ONT DÉJÀ ADOPTÉ LA MÉTHODE</span>
        </div>

        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-6">
            Prêt à augmenter vos ventes ?
        </h2>

        <p class="text-lg text-slate-600 mb-8 max-w-xl mx-auto">
            Commencez gratuitement pendant 30 jours. Aucun engagement.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('partners.register') }}?module=shop"
               class="group inline-flex items-center justify-center gap-3 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 text-base font-bold shadow-xl hover:shadow-2xl hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300">
                <i class="ri-rocket-2-line text-xl group-hover:rotate-45 transition-transform"></i>
                Démarrer gratuitement
            </a>

            <a href="/pricing"
               class="group inline-flex items-center justify-center gap-3 rounded-full bg-white border-2 border-slate-300 text-slate-700 px-4 py-2 text-base font-bold hover:border-slate-400 hover:bg-slate-50 transition-all duration-300">
                <i class="ri-price-tag-3-line text-xl"></i>
                Voir les tarifs
            </a>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4 text-sm text-slate-500 max-w-md mx-auto">
            <div class="flex items-center gap-2 justify-center">
                <i class="ri-shield-check-line text-emerald-500"></i>
                <span>30 jours gratuits</span>
            </div>
            <div class="flex items-center gap-2 justify-center">
                <i class="ri-time-line text-emerald-500"></i>
                <span>5 min de setup</span>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }

    /* Step animations */
    .step-enter {
        opacity: 0;
        transform: translateY(20px);
    }

    .step-enter-active {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate steps on scroll
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('step-enter-active');
                }
            });
        }, observerOptions);

        // Observe each step
        document.querySelectorAll('[id^="step"]').forEach(step => {
            step.classList.add('step-enter');
            observer.observe(step);
        });

        // Add hover effect to cards
        document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Stats counter animation (optional)
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current) + (element.textContent.includes('%') ? '%' : '');
            }, 20);
        }

        // Animate stats when they come into view
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statElements = entry.target.querySelectorAll('.text-2xl.font-bold');
                    statElements.forEach(el => {
                        const text = el.textContent;
                        const value = parseInt(text.replace(/[^0-9]/g, ''));
                        if (!isNaN(value)) {
                            animateCounter(el, value);
                        }
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        // Observe stats section
        const statsSection = document.querySelector('.grid.grid-cols-2.md\\:grid-cols-4.gap-4');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
    });
</script>
@endsection
