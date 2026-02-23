@extends('frontend.layouts.master')

@section('title', 'Les offres MYLMARK')
@section('meta_title', 'Tarifs & Abonnements vendeurs MYLMARK')
@section('meta_description', "Deux formules simples pour vendre sur MYLMARK : Standard pour bien démarrer, Premium pour accélérer avec plus de visibilité.")
@section('meta_image', asset('assets/images/pricing1.png'))

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-900 text-slate-50">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16 sm:pt-16 sm:pb-20">
        <!-- Background Effects -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -left-20 h-60 w-60 rounded-full bg-emerald-500/10 blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-20 -right-20 h-72 w-72 rounded-full bg-amber-500/10 blur-3xl animate-pulse-slow animation-delay-1000"></div>
        </div>

        <!-- Content -->
        <div class="relative text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 mb-4 animate-fade-in">
                <div class="h-px w-6 sm:w-8 bg-gradient-to-r from-transparent to-emerald-400"></div>
                <span class="text-xs sm:text-sm uppercase tracking-[0.3em] font-semibold text-emerald-300">TARIFS TRANSPARENTS</span>
                <div class="h-px w-6 sm:w-8 bg-gradient-to-r from-emerald-400 to-transparent"></div>
            </div>

            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-4 animate-fade-in animation-delay-200">
                Choisissez l'offre qui <span class="bg-gradient-to-r from-emerald-400 to-amber-400 bg-clip-text text-transparent">colle à votre réalité</span>
            </h1>

            <!-- Description -->
            <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto animate-fade-in animation-delay-400">
                Des tarifs pensés pour vous : démarrer sans pression,
                puis monter en puissance quand vos ventes suivent.
            </p>
        </div>
    </div>
</section>


<!-- Free Trial Banner -->
{{-- <section class="relative -mt-8 sm:-mt-12 pb-6 sm:pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-500 via-emerald-400 to-amber-400 p-1 shadow-2xl shadow-emerald-500/30">
            <div class="relative bg-slate-900 rounded-2xl p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="h-2 w-2 rounded-full bg-amber-400 animate-pulse"></div>
                            <span class="text-sm font-bold uppercase tracking-[0.2em] text-amber-300">
                                ESSAI GRATUIT
                            </span>
                        </div>
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            30 jours pour tester
                        </h2>
                        <p class="text-slate-300 text-sm">
                            Ouvrez votre boutique, ajoutez vos produits et testez en conditions réelles.
                        </p>
                    </div>

                    <!-- CTA Button -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('partners.register') }}?module=shop"
                           class="group inline-flex items-center justify-center gap-3 rounded-full bg-white text-slate-900 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold hover:scale-105 transition-all duration-300 active:scale-95 shadow-lg">
                            <span>Démarrer gratuitement</span>
                            <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Special Offer Banner -->
{{-- <section class="bg-slate-50 -mt-8 sm:-mt-12 pb-6 sm:pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-r from-emerald-50 via-white to-amber-50 border border-emerald-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-32 h-32 -translate-x-16 -translate-y-16 rounded-full bg-emerald-200/30 blur-2xl"></div>
            <div class="absolute bottom-0 right-0 w-40 h-40 translate-x-10 translate-y-10 rounded-full bg-amber-200/30 blur-2xl"></div>

            <div class="relative flex flex-col sm:flex-row items-center justify-between gap-6 p-6 sm:p-8">
                <!-- Left Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">
                            Offre de lancement
                        </span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">
                        1 mois d'abonnement <span class="text-emerald-600">offert</span>
                    </h2>
                    <p class="text-sm text-slate-600 max-w-2xl">
                        Ouvrez votre boutique, ajoutez vos produits et testez MYLMARK en conditions réelles.
                        Aucun engagement : vous pouvez arrêter avant la fin du mois d'essai.
                    </p>
                </div>

                <!-- CTA Button -->
                <div class="flex-shrink-0">
                    <a href="{{ route('partners.register') }}?module=shop"
                       class="group inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 sm:px-6 py-3 sm:py-3 text-sm sm:text-base font-semibold shadow-lg hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300 active:scale-95">
                            Commencer gratuitement
                        <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Pricing Plans -->
<section class="bg-slate-50 py-8 sm:py-6 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Billing Toggle -->
       <div class="flex flex-col items-center gap-4 mb-10 sm:mb-12">
            <div class="inline-flex items-center gap-3 mb-2">
                <span class="text-sm text-slate-500">Mensuel</span>
                <div id="billingToggle" class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggleBilling" class="sr-only peer">
                    <div class="toggle-switch w-14 h-7 bg-slate-200 rounded-full relative after:absolute after:top-0.5 after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:after:translate-x-full peer-checked:bg-emerald-600"></div>
                    <span class="ml-3 text-sm text-slate-500">Annuel</span>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-200 px-4 py-2 animate-pulse">
                <i class="ri-gift-line text-emerald-600"></i>
                <span class="text-sm font-semibold text-emerald-700">
                    <span id="savingPercent">≈ 2 mois offerts</span> avec l'annuel
                </span>
            </div>
        </div>

        <!-- Pricing Grid -->
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8 items-stretch max-w-5xl mx-auto">
            <!-- Standard Plan -->
            <div class="relative scroll-trigger">
                <!-- Popular Badge -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
                    <div class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-3 py-1.5 text-[12px] font-semibold shadow-lg">
                        <i class="ri-fire-line animate-pulse"></i>
                        Le plus populaire
                    </div>
                </div>

                <div class="h-full flex flex-col rounded-2xl sm:rounded-3xl border border-emerald-500/30 bg-white shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                    <!-- Header -->
                    <div class="px-6 sm:px-8 pt-8 pb-6 bg-gradient-to-b from-emerald-50/80 to-white border-b border-emerald-100">
                        <div class="mb-4">
                            <span class="inline-block text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">
                                Standard
                            </span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-3">
                            Pour commencer sans compliquer
                        </h3>

                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span id="standardPrice" class="text-3xl sm:text-4xl font-bold text-slate-900">3 500</span>
                                <span class="text-base text-slate-600">FCFA</span>
                                <span id="standardPeriod" class="text-base text-slate-500">/mois</span>
                            </div>
                            <p id="standardSaving" class="text-sm text-emerald-600 mt-1">ou 35 000 FCFA / an (≈ 2 mois offerts)</p>
                        </div>

                        <!-- Ideal For -->
                        <div class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <div class="h-8 w-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <i class="ri-user-smile-line text-emerald-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-emerald-800 mb-1">Idéal pour</p>
                                    <p class="text-xs text-slate-700">les vendeurs qui démarrent avec un catalogue limité.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="flex-1 px-6 sm:px-8 py-6">
                        <p class="text-sm font-semibold text-slate-700 mb-4">Ce plan inclut :</p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="ri-checkbox-circle-fill text-emerald-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Boutique MYLMARK dédiée avec page vitrine</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-checkbox-circle-fill text-emerald-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700"><strong>Jusqu'à 50 produits</strong> actifs simultanément</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-checkbox-circle-fill text-emerald-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Gestion complète des stocks et variations</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-checkbox-circle-fill text-emerald-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Suivi des commandes et notifications</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-checkbox-circle-fill text-emerald-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Tableau de bord de ventes et chiffre d'affaires</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-checkbox-circle-fill text-emerald-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Support standard</span>
                            </li>
                        </ul>

                        <!-- Commission -->
                        {{-- <div class="mt-8 pt-6 border-t border-slate-100">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-slate-700">Commission par vente :</span>
                                <span class="text-lg font-bold text-emerald-600">5%</span>
                            </div>
                        </div> --}}
                    </div>

                    <!-- CTA -->
                    <div class="px-6 sm:px-8 pb-8 pt-6 border-t border-emerald-100 bg-emerald-50/30">
                        <a href="{{ route('partners.register') }}?module=shop&plan=standard"
                           class="group w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 text-white px-6 py-3.5 text-sm font-semibold hover:bg-slate-800 hover:shadow-lg transition-all duration-300 active:scale-95">
                            <i class="ri-store-3-line text-lg group-hover:rotate-12 transition-transform"></i>
                            Commencer avec Standard
                            <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <p class="text-xs text-slate-600 text-center mt-3">
                            Recommandé pour 90% des vendeurs débutants
                        </p>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="relative scroll-trigger">
                <div class="h-full flex flex-col rounded-2xl sm:rounded-3xl border-2 border-amber-500/30 bg-gradient-to-b from-amber-50/30 via-white to-white shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">
                    <!-- Header -->
                    <div class="px-6 sm:px-8 pt-8 pb-6 bg-gradient-to-b from-amber-50/50 to-white border-b border-amber-100">
                        <div class="mb-4">
                            <span class="inline-block text-xs font-semibold uppercase tracking-[0.2em] text-amber-700 bg-amber-100 px-3 py-1 rounded-full">
                                Premium
                            </span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-3">
                            Pour plus de volume et plus de visibilité
                        </h3>

                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span id="premiumPrice" class="text-3xl sm:text-4xl font-bold text-slate-900">9 900</span>
                                <span class="text-base text-slate-600">FCFA</span>
                                <span id="premiumPeriod" class="text-base text-slate-500">/mois</span>
                            </div>
                            <p id="premiumSaving" class="text-sm text-amber-600 mt-1">ou 99 000 FCFA / an (≈ 2 mois offerts)</p>
                        </div>

                        <!-- Ideal For -->
                        <div class="bg-amber-50/50 border border-amber-100 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <div class="h-8 w-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                    <i class="ri-rocket-line text-amber-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-amber-800 mb-1">Idéal pour</p>
                                    <p class="text-xs text-slate-700">les vendeurs actifs avec un large catalogue.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="flex-1 px-6 sm:px-8 py-6">
                        <p class="text-sm font-semibold text-slate-700 mb-4">Tout l'essentiel de Standard, plus :</p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700"><strong>Produits illimités</strong> dans votre catalogue</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Mise en avant <strong>prioritaire</strong> sur la plateforme</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Badges de confiance <strong>exclusifs</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Statistiques <strong>avancées</strong> et analyses détaillées</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700">Participation aux <strong>campagnes marketing</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
                                <span class="text-sm text-slate-700"><strong>Support prioritaire</strong> dédié</span>
                            </li>
                        </ul>

                        <!-- Commission -->
                        {{-- <div class="mt-8 pt-6 border-t border-slate-100">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-slate-700">Commission par vente :</span>
                                <span class="text-lg font-bold text-amber-600">2%</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-2">Réduction de 60% par rapport au Standard</p>
                        </div> --}}
                    </div>

                    <!-- CTA -->
                    <div class="px-6 sm:px-8 pb-8 pt-6 border-t border-amber-100 bg-amber-50/30">
                        <a href="{{ route('partners.register') }}?module=shop&plan=premium"
                           class="group w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-white px-6 py-3.5 text-sm font-semibold hover:shadow-lg hover:shadow-amber-500/30 transition-all duration-300 active:scale-95">
                            <i class="ri-flashlight-line text-lg group-hover:animate-pulse"></i>
                            Passer en Premium
                            <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <p class="text-xs text-slate-600 text-center mt-3">
                            Optimisé pour les vendeurs réguliers avec 50+ produits
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commission Info -->
        {{-- <div class="mt-10 sm:mt-12 md:mt-16 scroll-trigger">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-50 via-white to-slate-50 border border-slate-200 p-6 sm:p-8 shadow-lg">
                <div class="absolute top-0 right-0 w-40 h-40 -translate-y-20 translate-x-20 rounded-full bg-emerald-200/30 blur-3xl"></div>

                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <!-- Left -->
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg">
                            <i class="ri-secure-payment-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-1">Commissions transparentes</h4>
                            <p class="text-sm text-slate-600">Uniquement prélevées sur les ventes réellement payées</p>
                        </div>
                    </div>

                    <!-- Right -->
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-slate-900">5%</div>
                            <div class="text-xs text-slate-600">Standard</div>
                        </div>
                        <div class="h-8 w-px bg-slate-300"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-amber-600">2%</div>
                            <div class="text-xs text-slate-600">Premium</div>
                        </div>
                        <div class="h-8 w-px bg-slate-300"></div>
                        <div class="text-sm text-slate-700">
                            <span class="font-semibold">+60% de revenus</span> conservés
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</section>

<!-- Final CTA -->
<section class="bg-gradient-to-br from-slate-50 to-white py-8 sm:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-200 px-4 py-2 mb-6">
            <i class="ri-chat-quote-line text-emerald-600"></i>
            <span class="text-sm font-semibold text-emerald-700">+20 vendeurs nous font déjà confiance</span>
        </div>

        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-4">
            Prêt à vendre plus et mieux ?
        </h2>

        <p class="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Rejoignez notre réseau de vendeurs et maximisez vos performances.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('partners.register') }}?module=shop"
               class="group inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-6 py-3 text-base font-semibold shadow-lg hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300 active:scale-95">
                <i class="ri-rocket-2-line text-xl group-hover:rotate-45 transition-transform"></i>
                Démarrer gratuitement
            </a>

            <a href="{{ route('contact') }}"
               class="group inline-flex items-center justify-center gap-2 rounded-full bg-white border-2 border-slate-300 text-slate-700 px-6 py-3 text-base font-semibold hover:border-slate-400 hover:bg-slate-50 transition-all duration-300">
                <i class="ri-question-line text-xl"></i>
                Une question ?
            </a>
        </div>
    </div>
</section>

<!-- ROI Calculator -->
<section class="bg-gradient-to-br from-slate-950 to-slate-900 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Votre <span class="text-emerald-300">retour sur investissement</span>
            </h2>
            <p class="text-slate-300">Comparez ce que vous gagnez vraiment</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-slate-800/50 rounded-2xl p-6 text-center">
                <div class="h-12 w-12 rounded-full bg-emerald-400/10 flex items-center justify-center mx-auto mb-4">
                    <i class="ri-time-line text-emerald-400 text-xl"></i>
                </div>
                <div class="text-2xl font-bold text-white mb-2">2h/jour</div>
                <div class="text-sm text-slate-300">Gagnées chaque jour</div>
                <div class="text-xs text-emerald-300 mt-2">≈ 60h/mois de temps libre</div>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-6 text-center">
                <div class="h-12 w-12 rounded-full bg-emerald-400/10 flex items-center justify-center mx-auto mb-4">
                    <i class="ri-money-dollar-circle-line text-emerald-400 text-xl"></i>
                </div>
                <div class="text-2xl font-bold text-white mb-2">+73%</div>
                <div class="text-sm text-slate-300">De ventes en plus</div>
                <div class="text-xs text-emerald-300 mt-2">Pour seulement 3 500 FCFA</div>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-6 text-center">
                <div class="h-12 w-12 rounded-full bg-emerald-400/10 flex items-center justify-center mx-auto mb-4">
                    <i class="ri-user-smile-line text-emerald-400 text-xl"></i>
                </div>
                <div class="text-2xl font-bold text-white mb-2">20+</div>
                <div class="text-sm text-slate-300">Vendeurs satisfaits</div>
                <div class="text-xs text-emerald-300 mt-2">Qui ont boosté leurs ventes</div>
            </div>
        </div>
    </div>
</section>


<!-- FAQs -->
<section class="bg-slate-50 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">
                Questions simples, <span class="text-emerald-600">réponses claires</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors hover:shadow-sm">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-calendar-line text-emerald-600"></i>
                    Quand commence la facturation ?
                </h4>
                <p class="text-slate-600 text-sm">
                    Profitez de <span class="font-medium text-slate-800">30 jours d'essai gratuit complet</span>. Passé ce délai, le service devient payant. <span class="font-medium text-emerald-700">Aucun prélèvement automatique</span> : vous déciderez manuellement de souscrire.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors hover:shadow-sm">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-refresh-line text-emerald-600"></i>
                    Puis-je changer de formule ?
                </h4>
                <p class="text-slate-600 text-sm">
                    Oui, vous pouvez <span class="font-medium text-slate-800">monter ou descendre de gamme à tout moment</span>, sans engagement, directement depuis votre tableau de bord. Le changement est effectif au début du prochain cycle de facturation.
                </p>
            </div>


            <!-- FAQ 4 -->
            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors hover:shadow-sm">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-shield-check-line text-emerald-600"></i>
                    Ma donnée est-elle protégée ?
                </h4>
                <p class="text-slate-600 text-sm">
                    Absolument. Nous utilisons un <span class="font-medium text-slate-800">chiffrement de bout en bout.</span> Vos données vous appartiennent.
                </p>
            </div>

            <!-- FAQ 5 -->
            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors hover:shadow-sm">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-question-line text-emerald-600"></i>
                    Y a-t-il des frais cachés ?
                </h4>
                <p class="text-slate-600 text-sm">
                    Non. Le prix annoncé est le prix final. <span class="font-medium text-emerald-700">Pas de commissions, frais d'installation ou de résiliation</span>.
                </p>
            </div>


        </div>
    </div>
</section>

<style>
    /* Animations */
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.5;
        }
        50% {
            opacity: 1;
        }
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s ease-in-out infinite;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
    }

    .animation-delay-600 {
        animation-delay: 0.6s;
    }

    .animation-delay-1000 {
        animation-delay: 1s;
    }

    /* Scroll Trigger */
    .scroll-trigger {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .scroll-trigger.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Custom Shadows */
    .shadow-soft {
        box-shadow: 0 10px 40px -12px rgba(0, 0, 0, 0.08);
    }

    /* Toggle Switch Custom */
    #billingToggle {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }

    #billingToggle input:checked ~ .toggle-switch {
        background-color: #10b981;
    }

    #billingToggle input:checked ~ .toggle-switch:after {
        transform: translateX(100%);
    }

    /* Responsive Improvements */
    @media (max-width: 640px) {
        .text-balance {
            text-wrap: balance;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Billing Period
        const toggle = document.getElementById('toggleBilling');
        const standardPrice = document.getElementById('standardPrice');
        const premiumPrice = document.getElementById('premiumPrice');
        const standardPeriod = document.getElementById('standardPeriod');
        const premiumPeriod = document.getElementById('premiumPeriod');
        const standardSaving = document.getElementById('standardSaving');
        const premiumSaving = document.getElementById('premiumSaving');
        const savingPercent = document.getElementById('savingPercent');

         const billingContainer = document.getElementById('billingToggle');
            if (billingContainer) {
                billingContainer.addEventListener('click', function(e) {
                    // Empêcher le double déclenchement
                    if (e.target !== toggle) {
                        toggle.checked = !toggle.checked;
                        updatePrices(toggle.checked);

                        // Trigger animation
                        [standardPrice, premiumPrice].forEach(el => {
                            el.style.transform = 'scale(1.1)';
                            setTimeout(() => {
                                el.style.transform = 'scale(1)';
                            }, 150);
                        });
                    }
                });
            }




        const prices = {
            standard: { monthly: '3 500', annual: '35 000' },
            premium: { monthly: '9 900', annual: '99 000' }
        };

        const savings = {
            standard: {
                monthly: 'ou 35 000 FCFA / an (≈ 2 mois offerts)',
                annual: '≈ 17% d\'économie mensuelle'
            },
            premium: {
                monthly: 'ou 99 000 FCFA / an (≈ 2 mois offerts)',
                annual: '≈ 17% d\'économie mensuelle'
            }
        };

        function updatePrices(isAnnual) {
            const period = isAnnual ? 'annual' : 'monthly';
            const suffix = isAnnual ? '/an' : '/mois';

            standardPrice.textContent = prices.standard[period];
            premiumPrice.textContent = prices.premium[period];
            standardPeriod.textContent = suffix;
            premiumPeriod.textContent = suffix;
            standardSaving.textContent = savings.standard[period];
            premiumSaving.textContent = savings.premium[period];
            savingPercent.textContent = isAnnual ? '≈ 2 mois offerts' : 'Facturation mensuelle';
        }

        toggle.addEventListener('change', function() {
            updatePrices(this.checked);

            // Animation du changement
            [standardPrice, premiumPrice].forEach(el => {
                el.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    el.style.transform = 'scale(1)';
                }, 150);
            });
        });

        // Initial update
        updatePrices(toggle.checked);

        // Scroll Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-trigger').forEach(el => {
            observer.observe(el);
        });

        // Smooth Scroll for anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add hover effect to pricing cards
        const pricingCards = document.querySelectorAll('.group');
        pricingCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'all 0.3s ease';
            });
        });

        // Add click animation to CTA buttons
        document.querySelectorAll('a[href*="register"]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Performance optimization for mobile
        if ('ontouchstart' in window || navigator.maxTouchPoints) {
            document.querySelectorAll('.animate-fade-in').forEach(el => {
                el.style.animation = 'none';
                el.style.opacity = '1';
                el.style.transform = 'none';
            });
        }

        // Initialize all scroll-trigger elements already in view
        setTimeout(() => {
            document.querySelectorAll('.scroll-trigger').forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.8) {
                    el.classList.add('visible');
                }
            });
        }, 100);
    });
</script>
@endsection
