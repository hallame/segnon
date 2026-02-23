@extends('frontend.layouts.master')

@section('title', 'Boostez vos ventes • MYLMARK')
@section('meta_title', 'Abonnements vendeurs MYLMARK')
@section('meta_description', "Choisissez votre formule : Standard pour démarrer, Premium pour accélérer. 1 mois gratuit pour tester.")
@section('meta_image', asset('assets/images/pricing2.png'))

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-white">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 sm:pt-24 sm:pb-28">
        <!-- Animated background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="relative text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="h-px w-8 bg-gradient-to-r from-transparent to-emerald-400"></div>
                <span class="text-sm uppercase tracking-[0.3em] font-bold text-emerald-300 animate-pulse">INVESTISSEZ DANS VOS VENTES</span>
                <div class="h-px w-8 bg-gradient-to-r from-emerald-400 to-transparent"></div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-tight mb-6">
                <span class="block">Boostez vos ventes</span>
                <span class="bg-gradient-to-r from-emerald-400 via-cyan-300 to-amber-300 bg-clip-text text-transparent">
                    pour <span class="text-7xl">3 500</span> FCFA
                </span>
            </h1>

            <!-- Description -->
            <p class="text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto mb-8">
                Payez moins que le prix d'un repas, gagnez des heures chaque jour et vendez 73% plus.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 max-w-md mx-auto mb-10">
                <div class="text-center">
                    <div class="text-2xl font-bold text-emerald-300">89%</div>
                    <div class="text-sm text-slate-400">Temps gagné</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-emerald-300">73%</div>
                    <div class="text-sm text-slate-400">+ de ventes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-emerald-300">20+</div>
                    <div class="text-sm text-slate-400">Vendeurs actifs</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Free Trial Banner -->
<section class="relative -mt-8 sm:-mt-12 pb-6 sm:pb-8">
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
                            30 jours pour tester sans risque
                        </h2>
                        <p class="text-slate-300 text-sm">
                            Créez votre boutique, ajoutez vos produits, vendez. Annulez avant 30 jours sans rien payer.
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
</section>

<!-- Pricing Comparison -->
<section class="bg-slate-900 py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Simple Toggle -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-4 bg-slate-800 rounded-full p-1 mb-4">
                <span class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                      :class="monthlyActive ? 'bg-emerald-500 text-white' : 'text-slate-300'"
                      @click="switchToMonthly">
                    Mensuel
                </span>
                <span class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                      :class="!monthlyActive ? 'bg-emerald-500 text-white' : 'text-slate-300'"
                      @click="switchToAnnual">
                    Annuel (-17%)
                </span>
            </div>
            <p class="text-slate-400 text-sm">
                <i class="ri-gift-line text-emerald-400"></i>
                <span class="font-medium text-emerald-300">2 mois offerts</span> avec l'abonnement annuel
            </p>
        </div>

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Standard -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-3xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>
                <div class="relative bg-slate-800 rounded-3xl p-6 sm:p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-emerald-400 bg-emerald-400/10 px-3 py-1 rounded-full mb-4">
                            STANDARD
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-bold text-white mb-4">
                            Pour démarrer fort
                        </h3>

                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl sm:text-5xl font-bold text-white">3 500</span>
                                <span class="text-lg text-slate-300">FCFA</span>
                                <span class="text-lg text-slate-400">/mois</span>
                            </div>
                            <p class="text-emerald-300 text-sm mt-2">
                                <i class="ri-check-line"></i> 35 000 FCFA / an
                            </p>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="mb-8">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="h-10 w-10 rounded-xl bg-emerald-400/10 flex items-center justify-center flex-shrink-0">
                                <i class="ri-check-double-line text-emerald-400"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white mb-1">Idéal pour commencer</h4>
                                <p class="text-sm text-slate-300">Avec jusqu'à 50 produits actifs</p>
                            </div>
                        </div>

                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">Boutique professionnelle</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">50 produits maximum</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">Gestion des stocks</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">Tableau de bord</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">Support standard</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <a href="{{ route('partners.register') }}?module=shop&plan=standard"
                       class="group w-full inline-flex items-center justify-center gap-3 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-6 py-4 text-sm font-bold transition-all duration-300 hover:scale-105">
                        <i class="ri-store-3-line text-lg"></i>
                        Choisir Standard
                        <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Premium -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-3xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>
                <div class="relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-6 sm:p-8 border border-amber-500/20">
                    <!-- Popular Badge -->
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
                        <div class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-2 text-xs font-bold shadow-lg">
                            <i class="ri-fire-fill animate-pulse"></i>
                            LE PLUS POPULAIRE
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="mb-6">
                        <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-amber-400 bg-amber-400/10 px-3 py-1 rounded-full mb-4">
                            PREMIUM
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-bold text-white mb-4">
                            Pour maximiser
                        </h3>

                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl sm:text-5xl font-bold text-white">9 900</span>
                                <span class="text-lg text-slate-300">FCFA</span>
                                <span class="text-lg text-slate-400">/mois</span>
                            </div>
                            <p class="text-amber-300 text-sm mt-2">
                                <i class="ri-check-line"></i> 99 000 FCFA / an
                            </p>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="mb-8">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="h-10 w-10 rounded-xl bg-amber-400/10 flex items-center justify-center flex-shrink-0">
                                <i class="ri-rocket-line text-amber-400"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white mb-1">Pour aller plus loin</h4>
                                <p class="text-sm text-slate-300">Avec produits illimités et visibilité</p>
                            </div>
                        </div>

                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300"><strong>Produits illimités</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300"><strong>Mise en avant prioritaire</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">Badges exclusifs</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">Statistiques avancées</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-star-fill text-amber-400 text-lg mt-0.5"></i>
                                <span class="text-slate-300">Support prioritaire</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <a href="{{ route('partners.register') }}?module=shop&plan=premium"
                       class="group w-full inline-flex items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-6 py-4 text-sm font-bold transition-all duration-300 hover:scale-105 shadow-lg shadow-amber-500/20">
                        <i class="ri-flashlight-fill text-lg"></i>
                        Choisir Premium
                        <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
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

<!-- FAQs Minimal -->
<section class="bg-slate-50 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">
                Questions simples, <span class="text-emerald-600">réponses claires</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-calendar-line text-emerald-600"></i>
                    Quand commence la facturation ?
                </h4>
                <p class="text-slate-600 text-sm">
                    Après 30 jours gratuits. Annulez avant sans rien payer.
                </p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-refresh-line text-emerald-600"></i>
                    Puis-je changer de formule ?
                </h4>
                <p class="text-slate-600 text-sm">
                    Oui, à tout moment depuis votre tableau de bord.
                </p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-close-circle-line text-emerald-600"></i>
                    Comment annuler ?
                </h4>
                <p class="text-slate-600 text-sm">
                    2 clics depuis votre compte. Aucun frais.
                </p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-300 transition-colors">
                <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i class="ri-question-line text-emerald-600"></i>
                    Autres frais ?
                </h4>
                <p class="text-slate-600 text-sm">
                    Non, juste l'abonnement. Pas de commissions cachées.
                </p>
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

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

<script>
    // Simple Vue.js-like toggle for pricing
    document.addEventListener('DOMContentLoaded', function() {
        let monthlyActive = true;

        function switchToMonthly() {
            monthlyActive = true;
            updateUI();
        }

        function switchToAnnual() {
            monthlyActive = false;
            updateUI();
        }

        function updateUI() {
            // In a real app, you would update prices here
            console.log(monthlyActive ? 'Monthly active' : 'Annual active');
        }

        // Add event listeners for demo
        document.querySelector('[onclick="switchToMonthly()"]')?.addEventListener('click', switchToMonthly);
        document.querySelector('[onclick="switchToAnnual()"]')?.addEventListener('click', switchToAnnual);

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Animate elements on scroll
        document.querySelectorAll('.group').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            observer.observe(el);
        });
    });
</script>
@endsection
