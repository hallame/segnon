@extends('frontend.layouts.master')

@section('title', 'À propos • MYLMARK')
@section('meta_title', 'À propos de MYLMARK • Notre histoire')
@section('meta_description', 'Découvrez MYLMARK : notre mission, notre équipe et notre vision pour révolutionner la vente en ligne des professionnels.')
@section('meta_image', asset('assets/images/about-og.png'))

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-white">
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Background effects -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        </div>

        <div class="relative text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="h-px w-8 bg-gradient-to-r from-transparent to-emerald-400"></div>
                <span class="text-sm uppercase tracking-[0.3em] font-semibold text-emerald-300">NOTRE HISTOIRE</span>
                <div class="h-px w-8 bg-gradient-to-r from-emerald-400 to-transparent"></div>
            </div>

            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black mb-6">
                Nous croyons en
                <span class="bg-gradient-to-r from-emerald-400 via-cyan-300 to-blue-400 bg-clip-text text-transparent">
                    votre réussite
                </span>
            </h1>

            <!-- Description -->
            <p class="text-sm text-slate-300 max-w-3xl mx-auto mb-8">
                Objectif : rendre la vente en ligne accessible et efficace pour tous les professionnels.
            </p>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-10 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Visual -->
            <div class="relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-3xl blur-xl opacity-20"></div>
                <div class="relative bg-gradient-to-br from-emerald-50 to-blue-50 rounded-2xl p-8">
                    <div class="text-center">
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mx-auto mb-6">
                            <i class="ri-focus-3-line text-white text-3xl"></i>   <!-- Focus -->
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">Notre mission</h3>
                        <p class="text-slate-700">
                            Simplifier la vente pour libérer votre potentiel
                        </p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div>
                <h2 class="text-3xl font-bold text-slate-900 mb-6">
                    Pourquoi <span class="text-emerald-600">MYLMARK</span> existe ?
                </h2>

                <div class="space-y-6">
                    <p class="text-lg text-slate-700">
                        Nous avons observé un problème : les artisans, créateurs et commerçants passent
                        <span class="font-semibold text-emerald-700">trop de temps à gérer leur communication commerciale</span>
                        et pas assez à développer leur activité.
                    </p>

                    <div class="bg-emerald-50 rounded-xl p-5">
                        <div class="flex items-start gap-3">
                            <i class="ri-lightbulb-flash-line text-emerald-600 text-xl mt-1"></i>
                            <div>
                                <p class="font-semibold text-emerald-900 mb-2">Notre vision</p>
                                <p class="text-emerald-800">
                                    Devenir l'outil indispensable de tout professionnel qui vend en ligne.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-10 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                Nos <span class="text-emerald-600">valeurs</span>
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Les principes qui guident chaque décision chez MYLMARK
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Value 1 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
                <div class="h-14 w-14 rounded-xl bg-emerald-100 flex items-center justify-center mb-6">
                    <i class="ri-user-smile-line text-emerald-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Simplicité d'abord</h3>
                <p class="text-slate-700">
                    Des outils intuitifs qui fonctionnent du premier coup. Pas besoin d'être expert en technologie.
                </p>
            </div>

            <!-- Value 2 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
                <div class="h-14 w-14 rounded-xl bg-blue-100 flex items-center justify-center mb-6">
                    <i class="ri-shield-check-line text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Transparence totale</h3>
                <p class="text-slate-700">
                    Pas de frais cachés, pas de surprises. Des tarifs clairs et des engagements tenus.
                </p>
            </div>

            <!-- Value 3 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
                <div class="h-14 w-14 rounded-xl bg-purple-100 flex items-center justify-center mb-6">
                    <i class="ri-team-line text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Impact réel</h3>
                <p class="text-slate-700">
                    Nous mesurons notre succès à l'aune du vôtre. Votre croissance est notre priorité.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
{{-- <section class="py-10 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                L'équipe <span class="text-emerald-600">MYLMARK</span>
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Des passionnés réunis par une mission commune : vous aider à réussir
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Founder -->
            <div class="text-center">
                <div class="h-32 w-32 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-4xl font-bold text-white">A</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-1">Amadou</h3>
                <p class="text-emerald-600 font-medium mb-3">Fondateur & CEO</p>
                <p class="text-slate-600 text-sm max-w-xs mx-auto">
                    10 ans d'expérience en e-commerce et solutions digitales pour les PME.
                </p>
            </div>

            <!-- Tech Lead -->
            <div class="text-center">
                <div class="h-32 w-32 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-4xl font-bold text-white">S</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-1">Sophie</h3>
                <p class="text-blue-600 font-medium mb-3">Directrice Technique</p>
                <p class="text-slate-600 text-sm max-w-xs mx-auto">
                    Expert en développement web et expérience utilisateur. Rend le complexe simple.
                </p>
            </div>

            <!-- Growth -->
            <div class="text-center">
                <div class="h-32 w-32 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-4xl font-bold text-white">K</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-1">Karim</h3>
                <p class="text-purple-600 font-medium mb-3">Responsable Croissance</p>
                <p class="text-slate-600 text-sm max-w-xs mx-auto">
                    Spécialiste en marketing digital et développement commercial B2B.
                </p>
            </div>
        </div>

        <!-- Support Team -->
        <div class="mt-16 bg-gradient-to-r from-emerald-50 to-blue-50 rounded-2xl p-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-slate-900 mb-4">Et toute l'équipe support</h3>
                <p class="text-slate-700 max-w-2xl mx-auto mb-6">
                    Nos experts en support, marketing et développement travaillent chaque jour
                    pour améliorer votre expérience sur MYLMARK.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="px-4 py-2 bg-white rounded-full text-sm font-medium text-slate-700">
                        Support technique
                    </span>
                    <span class="px-4 py-2 bg-white rounded-full text-sm font-medium text-slate-700">
                        Service client
                    </span>
                    <span class="px-4 py-2 bg-white rounded-full text-sm font-medium text-slate-700">
                        Développement produit
                    </span>
                    <span class="px-4 py-2 bg-white rounded-full text-sm font-medium text-slate-700">
                        Design UX/UI
                    </span>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Journey Timeline -->
<section class="py-10 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                Notre <span class="text-emerald-600">parcours</span>
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Les étapes clés de notre développement
            </p>
        </div>

        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-gradient-to-b from-emerald-400 to-blue-400 hidden md:block"></div>

            <!-- Timeline items -->
            <div class="space-y-12">
                <!-- 2023 -->
                <div class="relative md:flex items-center gap-8">
                    <div class="md:w-1/2 md:text-right md:pr-12 mb-6 md:mb-0">
                        <div class="inline-flex items-center gap-2 mb-2">
                            <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                            <span class="text-sm font-bold text-emerald-700">2023</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Lancement de MYLMARK</h3>
                    </div>

                    <div class="hidden md:block">
                        <div class="h-6 w-6 rounded-full bg-emerald-500 border-4 border-white"></div>
                    </div>

                    <div class="md:w-1/2 md:pl-12">
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <p class="text-slate-700">
                                Première version de la plateforme.
                                Validation du concept et des premières améliorations.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2024 -->
                <div class="relative md:flex items-center gap-8">
                    <div class="md:w-1/2 md:text-right md:pr-12 mb-6 md:mb-0 order-2">
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <p class="text-slate-700">
                                Lancement des formules Premium.
                                Amélioration significative de l'expérience utilisateur.
                            </p>
                        </div>
                    </div>

                    <div class="hidden md:block order-1">
                        <div class="h-6 w-6 rounded-full bg-blue-500 border-4 border-white"></div>
                    </div>

                    <div class="md:w-1/2 md:pl-12 order-3">
                        <div class="inline-flex items-center gap-2 mb-2">
                            <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                            <span class="text-sm font-bold text-blue-700">2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Croissance & Expansion</h3>
                    </div>
                </div>

                <!-- 2025 -->
                <div class="relative md:flex items-center gap-8">
                    <div class="md:w-1/2 md:text-right md:pr-12 mb-6 md:mb-0">
                        <div class="inline-flex items-center gap-2 mb-2">
                            <div class="h-2 w-2 rounded-full bg-purple-500"></div>
                            <span class="text-sm font-bold text-purple-700">2025</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Prochaines étapes</h3>
                    </div>

                    <div class="hidden md:block">
                        <div class="h-6 w-6 rounded-full bg-purple-500 border-4 border-white"></div>
                    </div>

                    <div class="md:w-1/2 md:pl-12">
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <p class="text-slate-700">
                                Nouveaux marchés, fonctionnalités avancées et objectif :
                                devenir la référence pour les vendeurs professionnels en Afrique.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
{{-- <section class="py-10 bg-gradient-to-br from-slate-900 to-slate-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 mb-4">
                <i class="ri-star-fill text-amber-400"></i>
                <span class="text-sm font-semibold text-amber-300 uppercase tracking-wider">TÉMOIGNAGES</span>
                <i class="ri-star-fill text-amber-400"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">
                Ce que disent nos <span class="text-emerald-300">vendeurs</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <span class="text-lg font-bold text-emerald-300">M</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-white">Mariam</h4>
                        <p class="text-sm text-slate-400">Cotonou</p>
                    </div>
                </div>
                <p class="text-slate-300 italic">
                    "MYLMARK a changé ma façon de vendre. En 2 mois, j'ai doublé mes ventes
                    et gagné 2 heures par jour. La simplicité fait toute la différence."
                </p>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-blue-500/20 flex items-center justify-center">
                        <span class="text-lg font-bold text-blue-300">I</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-white">Ibrahima</h4>
                        <p class="text-sm text-slate-400">Akpakpa</p>
                    </div>
                </div>
                <p class="text-slate-300 italic">
                    "Finies les 100+ photos WhatsApp ! 1 lien MYLMARK = tout mon catalogue visible
                    par tous mes clients. Gain de temps : 2h/jour."
                </p>
            </div>
        </div>
    </div>
</section> --}}

<!-- Final CTA -->
<section class="py-5 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-emerald-50 to-blue-50 rounded-2xl p-4 md:p-6 border border-emerald-100">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
                Rejoignez l'<span class="text-emerald-600">aventure</span>
            </h2>

            <p class="text-lg text-slate-700 mb-8 max-w-2xl mx-auto">
                Devenez l'un de nos vendeurs partenaires et bénéficiez d'un accompagnement personnalisé
                pour développer votre activité en ligne.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('partners.register') }}"
                   class="group inline-flex items-center justify-center gap-3 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 text-base font-bold shadow-xl hover:shadow-2xl hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300">
                    <i class="ri-rocket-2-line text-xl group-hover:rotate-45 transition-transform"></i>
                    Commencer gratuitement
                </a>

                <a href="/contact"
                   class="group inline-flex items-center justify-center gap-3 rounded-full bg-white border-2 border-slate-300 text-slate-700 px-4 py-2 text-base font-bold hover:border-slate-400 hover:bg-slate-50 transition-all duration-300">
                    <i class="ri-question-line text-xl"></i>
                    Une question ?
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Timeline responsive */
    @media (max-width: 768px) {
        .md\:flex {
            flex-direction: column;
        }

        .md\:w-1\/2 {
            width: 100%;
        }

        .md\:text-right, .md\:pl-12, .md\:pr-12 {
            text-align: left;
            padding-left: 0;
            padding-right: 0;
        }

        .md\:block {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate timeline items on scroll
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe timeline items and value cards
        const animatedElements = document.querySelectorAll('.hover\\:-translate-y-2, .relative.md\\:flex');
        animatedElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            observer.observe(el);
        });

        // Add hover effect to team cards
        const teamCards = document.querySelectorAll('.text-center');
        teamCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
                this.style.transition = 'transform 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection
