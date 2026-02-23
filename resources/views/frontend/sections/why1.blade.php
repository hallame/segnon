<!-- Section: La Révolution -->
<section class="relative py-4 sm:py-6 md:py-8 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 overflow-hidden">
    <!-- Animated background -->
    <div class="absolute inset-0">
        <!-- Dual gradient lines -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-emerald-500/40 via-30% to-transparent animate-shimmer"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-amber-500/40 via-70% to-transparent animate-shimmer animation-delay-1000"></div>

        <!-- Floating particles - réduit sur mobile -->
        @for ($i = 0; $i < 10; $i++)
        <div class="absolute h-1 w-1 rounded-full bg-emerald-400/20 animate-float-particle hidden sm:block"
             style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ $i * 0.2 }}s;"></div>
        @endfor

        <!-- Glow orbs - réduits sur mobile -->
        <div class="absolute top-1/4 -left-10 sm:-left-20 h-32 sm:h-64 w-32 sm:w-64 rounded-full bg-rose-500/5 sm:bg-rose-500/10 blur-xl sm:blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/4 -right-10 sm:-right-20 h-32 sm:h-64 w-32 sm:w-64 rounded-full bg-emerald-500/5 sm:bg-emerald-500/10 blur-xl sm:blur-3xl animate-float-slow animation-delay-500"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 xl:px-8">
        <!-- Animated title -->
        <div class="text-center mb-6 sm:mb-12 md:mb-20 scroll-trigger">
            <div class="inline-flex items-center gap-2 sm:gap-3 md:gap-4 mb-3 sm:mb-4">
                <div class="h-px w-4 sm:w-6 md:w-12 bg-gradient-to-r from-transparent to-rose-500"></div>
                <span class="text-rose-400 font-bold text-xs sm:text-sm md:text-base uppercase tracking-[0.2em] sm:tracking-[0.3em] animate-pulse-slow">LA TRANSFORMATION</span>
                <div class="h-px w-4 sm:w-6 md:w-12 bg-gradient-to-r from-emerald-500 to-transparent"></div>
            </div>

            <h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-bold text-white mb-2 sm:mb-3">
                <span class="bg-gradient-to-r from-rose-400 via-amber-400 to-emerald-400 bg-clip-text text-transparent animate-gradient-flow">Révolutionnez</span>
                <br class="hidden sm:block">votre façon de vendre
            </h2>
            <p class="text-sm sm:text-base md:text-lg text-slate-300 max-w-2xl mx-auto px-2">
                Comparez l'ancienne méthode vs la nouvelle approche MYLMARK
            </p>
        </div>

        <!-- Dual cards with flip animation -->
        <div class="grid md:grid-cols-2 gap-4 sm:gap-5 md:gap-6 lg:gap-8">
            <!-- Avant - avec effet "shake" -->
            <div class="scroll-trigger">
                <div class="h-full bg-gradient-to-br from-rose-900/30 via-rose-900/20 to-rose-800/10 backdrop-blur-xl border border-rose-800/40 sm:border-2 rounded-xl sm:rounded-2xl md:rounded-3xl p-4 sm:p-5 md:p-6 lg:p-8 hover:border-rose-600/60 hover:shadow-xl sm:hover:shadow-2xl hover:shadow-rose-900/20 transition-all duration-500 group hover:-translate-y-1 sm:hover:-translate-y-2">
                    <!-- Animated header -->
                    <div class="flex items-start sm:items-center gap-3 sm:gap-4 mb-4 sm:mb-6 md:mb-8 relative">
                        <div class="relative flex-shrink-0">
                            <div class="absolute -inset-2 sm:-inset-3 bg-rose-500/20 rounded-full animate-ping-slow"></div>
                            <div class="relative h-12 w-12 sm:h-14 sm:w-14 md:h-16 md:w-16 rounded-lg sm:rounded-xl md:rounded-2xl bg-gradient-to-br from-rose-700 to-rose-900 flex items-center justify-center shadow-lg group-hover:animate-shake">
                                <i class="ri-close-circle-line text-xl sm:text-2xl md:text-3xl text-rose-300"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-white truncate">Ancienne Méthode</h3>
                            <p class="text-rose-300 text-xs sm:text-sm flex items-center gap-1 sm:gap-2 mt-1">
                                <i class="ri-alert-line animate-pulse text-xs sm:text-sm"></i>
                                <span class="truncate">Chaos & pertes de temps</span>
                            </p>
                        </div>
                    </div>

                    <!-- Pain points -->
                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        @foreach([
                            ['icon' => 'ri-time-line', 'text' => '2h/jour perdues en envoi de photos', 'color' => 'rose'],
                            ['icon' => 'ri-chat-delete-line', 'text' => '30% des ventes abandonnées', 'color' => 'rose'],
                            ['icon' => 'ri-image-line', 'text' => 'Photos floues, présentations médiocres', 'color' => 'rose'],
                            ['icon' => 'ri-price-tag-3-line', 'text' => 'Confusions constantes sur les prix', 'color' => 'rose']
                        ] as $point)
                        <div class="flex items-center gap-2 sm:gap-3 md:gap-4 p-2 sm:p-3 md:p-4 rounded-lg sm:rounded-xl md:rounded-2xl bg-gradient-to-r from-rose-900/30 to-rose-900/10 border border-rose-800/30 group-item hover:from-rose-900/40 hover:border-rose-700/50 transition-all duration-300">
                            <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-12 md:w-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-rose-800/50 to-rose-700/30 flex items-center justify-center flex-shrink-0">
                                <i class="{{ $point['icon'] }} text-sm sm:text-base md:text-lg lg:text-xl text-rose-300"></i>
                            </div>
                            <span class="text-rose-100 font-medium text-xs sm:text-sm md:text-base truncate">{{ $point['text'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <!-- Warning badge -->
                    <div class="mt-4 sm:mt-5 md:mt-6 pt-3 sm:pt-4 md:pt-6 border-t border-rose-800/30">
                        <div class="inline-flex items-center gap-1 sm:gap-2 rounded-full bg-rose-900/50 border border-rose-800/50 px-2 sm:px-3 md:px-4 py-1 sm:py-2">
                            <i class="ri-alert-line text-rose-300 animate-pulse text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-rose-200">Perte : <strong>43%</strong> d'efficacité</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Après - avec effets "sparkle" -->
            <div class="scroll-trigger">
                <div class="h-full bg-gradient-to-br from-emerald-900/30 via-emerald-900/20 to-emerald-800/10 backdrop-blur-xl border border-emerald-800/40 sm:border-2 rounded-xl sm:rounded-2xl md:rounded-3xl p-4 sm:p-5 md:p-6 lg:p-8 hover:border-emerald-600/60 hover:shadow-xl sm:hover:shadow-2xl hover:shadow-emerald-900/20 transition-all duration-500 group hover:-translate-y-1 sm:hover:-translate-y-2 relative overflow-hidden">
                    <!-- Sparkle effect -->
                    <div class="absolute -top-6 -right-6 sm:-top-10 sm:-right-10 h-12 w-12 sm:h-20 sm:w-20 rounded-full bg-emerald-500/10 sm:bg-emerald-500/20 blur-lg sm:blur-xl animate-pulse-slow"></div>

                    <!-- Animated header -->
                    <div class="flex items-start sm:items-center gap-3 sm:gap-4 mb-4 sm:mb-6 md:mb-8 relative">
                        <div class="relative flex-shrink-0">
                            <div class="absolute -inset-2 sm:-inset-3 bg-emerald-500/20 rounded-full animate-ping-slow animation-delay-500"></div>
                            <div class="relative h-12 w-12 sm:h-14 sm:w-14 md:h-16 md:w-16 rounded-lg sm:rounded-xl md:rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                                <i class="ri-check-double-line text-xl sm:text-2xl md:text-3xl text-emerald-300"></i>
                                <!-- Mini sparkles -->
                                <div class="absolute -top-1 -right-1 h-2 w-2 sm:h-3 sm:w-3 md:h-4 md:w-4 rounded-full bg-emerald-300 animate-ping"></div>
                                <div class="absolute -bottom-1 -left-1 h-2 w-2 sm:h-3 sm:w-3 rounded-full bg-amber-300 animate-ping animation-delay-300"></div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-white truncate">Avec MYLMARK</h3>
                            <p class="text-emerald-300 text-xs sm:text-sm flex items-center gap-1 sm:gap-2 mt-1">
                                <i class="ri-flashlight-line animate-pulse text-xs sm:text-sm"></i>
                                <span class="truncate">Efficacité & croissance</span>
                            </p>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        @foreach([
                            ['icon' => 'ri-flashlight-line', 'text' => 'Gain de 89% de temps', 'color' => 'emerald', 'value' => '+89%'],
                            ['icon' => 'ri-trending-up-line', 'text' => '+73% de ventes conclues', 'color' => 'emerald', 'value' => '+73%'],
                            ['icon' => 'ri-award-line', 'text' => 'Image professionnelle', 'color' => 'emerald', 'value' => '⭐'],
                            ['icon' => 'ri-shield-check-line', 'text' => 'Confiance client maximisée', 'color' => 'emerald', 'value' => '98%']
                        ] as $benefit)
                        <div class="flex items-center justify-between gap-2 sm:gap-3 md:gap-4 p-2 sm:p-3 md:p-4 rounded-lg sm:rounded-xl md:rounded-2xl bg-gradient-to-r from-emerald-900/30 to-emerald-900/10 border border-emerald-800/30 group-item hover:from-emerald-900/40 hover:border-emerald-700/50 transition-all duration-300">
                            <div class="flex items-center gap-2 sm:gap-3 md:gap-4 min-w-0">
                                <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-12 md:w-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-emerald-800/50 to-emerald-700/30 flex items-center justify-center flex-shrink-0">
                                    <i class="{{ $benefit['icon'] }} text-sm sm:text-base md:text-lg lg:text-xl text-emerald-300"></i>
                                </div>
                                <span class="text-emerald-100 font-medium text-xs sm:text-sm md:text-base truncate">{{ $benefit['text'] }}</span>
                            </div>
                            <div class="text-emerald-300 font-bold text-xs sm:text-sm md:text-base lg:text-lg bg-emerald-900/30 px-2 py-1 sm:px-3 sm:py-1 rounded-lg flex-shrink-0">
                                {{ $benefit['value'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Success badge -->
                    <div class="mt-4 sm:mt-5 md:mt-6 pt-3 sm:pt-4 md:pt-6 border-t border-emerald-800/30">
                        <div class="inline-flex items-center gap-1 sm:gap-2 rounded-full bg-emerald-900/50 border border-emerald-800/50 px-2 sm:px-3 md:px-4 py-1 sm:py-2">
                            <i class="ri-trophy-line text-amber-300 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-emerald-200">Gain : <strong class="text-amber-300">x2.7</strong> d'efficacité</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comparison stats bar -->
        <div class="mt-3 sm:mt-4 md:mt-6 scroll-trigger">
            <div class="bg-gradient-to-r from-rose-900/20 via-slate-900/30 to-emerald-900/20 backdrop-blur-sm border border-white/10 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 lg:p-8">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                    <div class="text-center">
                        <div class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-rose-400 mb-1 sm:mb-2">2h</div>
                        <div class="text-xs sm:text-sm text-slate-300">Temps perdu/jour</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-emerald-400 mb-1 sm:mb-2">15min</div>
                        <div class="text-xs sm:text-sm text-slate-300">Avec MYLMARK</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl sm:text-2-xl md:text-3xl lg:text-4xl font-bold text-rose-400 mb-1 sm:mb-2">30%</div>
                        <div class="text-xs sm:text-sm text-slate-300">Ventes abandonnées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-emerald-400 mb-1 sm:mb-2">8%</div>
                        <div class="text-xs sm:text-sm text-slate-300">Avec MYLMARK</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CSS Animations additionnelles -->
<style>
    @keyframes shimmer {
        0% { background-position: -100% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes float-particle {
        0%, 100% { transform: translateY(0) translateX(0); opacity: 0.2; }
        50% { transform: translateY(-20px) translateX(10px); opacity: 0.5; }
    }

    @keyframes shake {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-5deg); }
        75% { transform: rotate(5deg); }
    }

    .animate-shimmer {
        background-size: 200% 100%;
        animation: shimmer 3s infinite linear;
    }

    .animate-float-particle {
        animation: float-particle 6s ease-in-out infinite;
    }

    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }

    /* Media queries supplémentaires pour un meilleur responsive */
    @media (max-width: 640px) {
        .text-sm-mobile {
            font-size: 0.875rem;
        }

        .text-xs-mobile {
            font-size: 0.75rem;
        }

        .p-mobile {
            padding: 1rem;
        }

        .gap-mobile {
            gap: 0.75rem;
        }
    }

    /* Amélioration de la lisibilité sur très petits écrans */
    @media (max-width: 375px) {
        .text-xs-mobile {
            font-size: 0.7rem;
        }

        h2 {
            font-size: 1.1rem;
        }

        h3 {
            font-size: 1rem;
        }
    }
</style>
