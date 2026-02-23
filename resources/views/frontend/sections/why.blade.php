<!-- Section: La Révolution -->
<section class="relative py-10 md:py-14 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 overflow-hidden">
    <!-- Animated background -->
    <div class="absolute inset-0">
        <!-- Gradient lines -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-emerald-500/30 via-30% to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-amber-500/30 via-70% to-transparent"></div>

        <!-- Glow orbs -->
        <div class="absolute top-1/4 -left-20 h-64 w-64 rounded-full bg-rose-500/5 blur-3xl"></div>
        <div class="absolute bottom-1/4 -right-20 h-64 w-64 rounded-full bg-emerald-500/5 blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Title -->
        {{-- <div class="text-center mb-8 md:mb-12">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="h-px w-6 sm:w-8 bg-gradient-to-r from-transparent to-rose-500"></div>
                <span class="text-rose-400 font-bold text-xs sm:text-sm uppercase tracking-[0.2em]">LA TRANSFORMATION</span>
                <div class="h-px w-6 sm:w-8 bg-gradient-to-r from-emerald-500 to-transparent"></div>
            </div>

            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3">
                <span class="bg-gradient-to-r from-rose-400 via-amber-400 to-emerald-400 bg-clip-text text-transparent">Révolutionnez</span>
                <br class="hidden sm:block">votre façon de vendre
            </h2>
            <p class="text-base sm:text-lg text-slate-300 max-w-xl mx-auto">
                Comparez l'ancienne méthode vs la nouvelle approche MYLMARK
            </p>
        </div> --}}

           <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">
                    Avant/Après <span class="text-emerald-300">MYLMARK</span>
                </h2>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto">
                    Comparez la différence sur une journée type
                </p>
            </div>

        <!-- Dual cards -->
        <div class="grid lg:grid-cols-2 gap-6 md:gap-8">
            <!-- Avant -->
            <div class="h-full">
                <div class="h-full bg-gradient-to-br from-rose-900/20 via-rose-900/10 to-rose-800/5 backdrop-blur-sm border border-rose-800/30 rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 hover:border-rose-600/50 transition-all duration-300">
                    <!-- Header -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-rose-700 to-rose-900 flex items-center justify-center flex-shrink-0">
                            <i class="ri-close-circle-line text-xl sm:text-2xl text-rose-300"></i>
                        </div>
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-white">Ancienne Méthode</h3>
                            <p class="text-rose-300 text-sm flex items-center gap-2 mt-1">
                                <i class="ri-alert-line"></i>
                                Chaos & pertes de temps
                            </p>
                        </div>
                    </div>

                    <!-- Pain points -->
                    <div class="space-y-3 sm:space-y-4">
                        @foreach([
                            ['icon' => 'ri-time-line', 'text' => '2h/jour perdues en envoi de photos'],
                            ['icon' => 'ri-arrow-down-line', 'text' => '30% des ventes abandonnées'],
                            ['icon' => 'ri-image-2-line', 'text' => 'Photos floues, présentations médiocres'],
                            ['icon' => 'ri-user-line', 'text' => 'Audience limitée à mes contacts'],

                            ['icon' => 'ri-price-tag-3-line', 'text' => 'Confusions constantes sur les prix'],
                            ['icon' => 'ri-gallery-line', 'text' => 'WhatsApp saturées de 500+ photos'],
                            ['icon' => 'ri-question-line', 'text' => 'Mêmes questions à répétition'],
                            ['icon' => 'ri-award-line', 'text' => 'Image amateur, peu crédible'],
                            ['icon' => 'ri-user-unfollow-line', 'text' => 'Client méfiant, hésite à acheter'],
                            ['icon' => 'ri-share-line', 'text' => 'Partage catalogue multi-réseaux difficile'],
                            ['icon' => 'ri-alarm-warning-line', 'text' => 'Stocks mal gérés, ventes ratées'],
                            ['icon' => 'ri-bar-chart-box-line', 'text' => 'Aucune analyse des produits les plus populaires']
                        ] as $point)
                        <div class="flex items-center gap-3 p-3 sm:p-4 rounded-xl bg-gradient-to-r from-rose-900/20 to-rose-900/10 border border-rose-800/20 hover:border-rose-700/40 transition-colors">
                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-rose-800/40 to-rose-700/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="{{ $point['icon'] }} text-base sm:text-lg text-rose-300"></i>
                            </div>
                            <span class="text-sm sm:text-base text-rose-100 leading-relaxed">{{ $point['text'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <!-- Warning badge -->
                    <div class="mt-6 pt-5 border-t border-rose-800/30">
                        <div class="inline-flex items-center gap-2 rounded-full bg-rose-900/30 border border-rose-800/40 px-3 sm:px-4 py-1.5 sm:py-2">
                            <i class="ri-alert-line text-rose-300 text-sm"></i>
                            <span class="text-xs sm:text-sm text-rose-200">Perte moyenne : <strong>43%</strong> d'efficacité</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Après -->
            <div class="h-full">
                <div class="h-full bg-gradient-to-br from-emerald-900/20 via-emerald-900/10 to-emerald-800/5 backdrop-blur-sm border border-emerald-800/30 rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 hover:border-emerald-600/50 transition-all duration-300">
                    <!-- Header -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center flex-shrink-0">
                            <i class="ri-check-double-line text-xl sm:text-2xl text-emerald-300"></i>
                        </div>
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-white">Avec MYLMARK</h3>
                            <p class="text-emerald-300 text-sm flex items-center gap-2 mt-1">
                                <i class="ri-flashlight-line"></i>
                                Efficacité & croissance
                            </p>
                        </div>
                    </div>
                    <!-- Benefits -->
                    <div class="space-y-3 sm:space-y-4">
                        @foreach([
                            ['icon' => 'ri-flashlight-line', 'text' => 'Gain de 89% de temps', 'value' => '+89%'],
                            ['icon' => 'ri-arrow-up-line', 'text' => '+73% de ventes conclues', 'value' => '+73%'],
                            ['icon' => 'ri-image-edit-line', 'text' => 'Photos pro optimisées', 'value' => 'Pro'],
                            ['icon' => 'ri-global-line', 'text' => '+ nouveaux clients', 'value' => 'Audience élargie'],
                            ['icon' => 'ri-price-tag-3-line', 'text' => 'Prix clairs et visibles', 'value' => 'Transparent'],
                            ['icon' => 'ri-inbox-unarchive-line', 'text' => 'Catalogue unique organisé', 'value' => '500→1 lien'],
                            ['icon' => 'ri-file-text-line', 'text' => 'Toutes infos accessibles', 'value' => 'Détaillé'],
                            ['icon' => 'ri-award-line', 'text' => 'Image professionnelle crédible', 'value' => '5/5'],
                            ['icon' => 'ri-shield-check-line', 'text' => 'Confiance client boostée', 'value' => '98%'],
                            ['icon' => 'ri-share-forward-line', 'text' => 'Partage instant multi-réseaux', 'value' => '✓'],
                            ['icon' => 'ri-store-line', 'text' => 'Gestion des stocks en temps réel', 'value' => 'Live'],
                            ['icon' => 'ri-bar-chart-line', 'text' => 'Statistiques des produits les plus vus', 'value' => 'Analytics']


                        ] as $benefit)
                        <div class="flex items-center justify-between gap-3 p-3 sm:p-4 rounded-xl bg-gradient-to-r from-emerald-900/20 to-emerald-900/10 border border-emerald-800/20 hover:border-emerald-700/40 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-emerald-800/40 to-emerald-700/30 flex items-center justify-center flex-shrink-0">
                                    <i class="{{ $benefit['icon'] }} text-base sm:text-lg text-emerald-300"></i>
                                </div>
                                <span class="text-sm sm:text-base text-emerald-100 leading-relaxed">{{ $benefit['text'] }}</span>
                            </div>
                            <div class="text-emerald-300 font-bold text-sm sm:text-base bg-emerald-900/30 px-2 sm:px-3 py-1 rounded-lg whitespace-nowrap">
                                {{ $benefit['value'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Success badge -->
                    <div class="mt-6 pt-5 border-t border-emerald-800/30">
                        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-900/30 border border-emerald-800/40 px-3 sm:px-4 py-1.5 sm:py-2">
                            <i class="ri-trophy-line text-amber-300 text-sm"></i>
                            <span class="text-xs sm:text-sm text-emerald-200">Gain moyen : <strong class="text-amber-300">x2.7</strong> d'efficacité</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comparison stats -->
        <div class="mt-8 sm:mt-10">
            <div class="bg-gradient-to-r from-rose-900/10 via-slate-900/20 to-emerald-900/10 backdrop-blur-sm border border-white/5 rounded-xl sm:rounded-2xl p-5 sm:p-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-rose-400 mb-1 sm:mb-2">2h</div>
                        <div class="text-xs sm:text-sm text-slate-300">Temps perdu/jour</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-emerald-400 mb-1 sm:mb-2">15min</div>
                        <div class="text-xs sm:text-sm text-slate-300">Avec MYLMARK</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-rose-400 mb-1 sm:mb-2">30%</div>
                        <div class="text-xs sm:text-sm text-slate-300">Ventes abandonnées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-emerald-400 mb-1 sm:mb-2">8%</div>
                        <div class="text-xs sm:text-sm text-slate-300">Avec MYLMARK</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-8 sm:mt-10 text-center">
            <a href="{{ route('partners.register') }}?module=shop"
               class="group inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-5 sm:px-6 py-3 text-sm sm:text-base font-semibold shadow-lg hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300 active:scale-95">
                <i class="ri-flashlight-line text-lg group-hover:animate-pulse"></i>
                Commencer la transformation
                <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
            </a>
            <p class="text-xs sm:text-sm text-slate-400 mt-3">
                Rejoignez +20 vendeurs qui ont déjà adopté la nouvelle méthode
            </p>
        </div>
    </div>
</section>

<style>
    /* Animations minimales pour la performance */
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

    .scroll-trigger {
        animation: fade-in 0.6s ease-out forwards;
    }

    /* Optimisations pour mobile */
    @media (max-width: 640px) {
        .grid-cols-2 > * {
            min-height: auto;
        }
    }

    /* Prévenir le flash de contenu non-stylisé */
    .no-js .scroll-trigger {
        opacity: 1;
        transform: none;
    }
</style>

<script>
    // Simple intersection observer pour les animations
    document.addEventListener('DOMContentLoaded', function() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });

            document.querySelectorAll('.scroll-trigger').forEach(el => {
                observer.observe(el);
            });
        } else {
            // Fallback pour les vieux navigateurs
            document.querySelectorAll('.scroll-trigger').forEach(el => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            });
        }
    });
</script>
