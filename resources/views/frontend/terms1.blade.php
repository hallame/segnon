@extends('frontend.layouts.master')

@section('title', 'Conditions Générales d\'Utilisation • MYLMARK')
@section('meta_title', 'CGU • Conditions d\'utilisation MYLMARK')
@section('meta_description', 'Conditions Générales d\'Utilisation de la plateforme MYLMARK. Règles, droits et obligations des vendeurs et acheteurs.')
@section('meta_image', asset('assets/images/legal-og.png'))

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-12">
        <!-- Background effect -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-slate-800/30 blur-3xl"></div>
        </div>

        <div class="relative text-center">
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="h-px w-6 bg-gradient-to-r from-transparent to-slate-400"></div>
                <span class="text-sm uppercase tracking-[0.3em] font-semibold text-slate-300">CGU</span>
                <div class="h-px w-6 bg-gradient-to-r from-slate-400 to-transparent"></div>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                Conditions Générales<br>
                <span class="text-emerald-300">d'Utilisation</span>
            </h1>

            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-8">
                Dernière mise à jour : {{ date('d/m/Y') }}
            </p>

            <div class="flex flex-wrap justify-center gap-4 text-sm">

                <div class="flex items-center gap-2">
                    <i class="ri-shield-check-line text-emerald-400"></i>
                    <span>Protection des droits</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-time-line text-emerald-400"></i>
                    <span>Lecture : 10 min</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Articles -->
        <div class="space-y-16">
            <!-- Article 1 -->
            <article id="article1" class="scroll-mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-emerald-700">1</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Objet des CGU</h2>
                        <p class="text-slate-600 text-sm">Définition du cadre d'utilisation</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-6">
                    <p class="text-slate-700 leading-relaxed">
                        Les présentes Conditions Générales d'Utilisation définissent les modalités d'utilisation de la plateforme MYLMARK,
                        accessible à l'adresse <strong class="text-slate-900">
                            <a href="{{ route('home') }}">https://mylmark.com</a></strong>, ainsi que les droits et obligations des utilisateurs.
                    </p>

                    <div class="mt-6 grid sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 p-4 bg-white rounded-lg">
                            <i class="ri-store-3-line text-emerald-600 mt-0.5"></i>
                            <div>
                                <p class="font-medium text-slate-900">Pour les vendeurs</p>
                                <p class="text-sm text-slate-600">Plateforme de vente en ligne</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-white rounded-lg">
                            <i class="ri-shopping-cart-2-line text-emerald-600 mt-0.5"></i>
                            <div>
                                <p class="font-medium text-slate-900">Pour les acheteurs</p>
                                <p class="text-sm text-slate-600">Accès aux produits des vendeurs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 2 -->
            <article id="article2" class="scroll-mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-emerald-700">2</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Acceptation des CGU</h2>
                        <p class="text-slate-600 text-sm">Conditions d'utilisation obligatoires</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-6">
                    <div class="flex items-start gap-4 p-4 bg-white rounded-lg mb-4">
                        <i class="ri-checkbox-circle-line text-emerald-600 text-xl"></i>
                        <div>
                            <p class="font-medium text-slate-900 mb-1">Consentement obligatoire</p>
                            <p class="text-slate-700">
                                L'utilisation de MYLMARK implique l'acceptation pleine et entière des présentes CGU.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <i class="ri-check-line text-emerald-500"></i>
                            <span class="text-slate-700">Toute inscription vaut acceptation des conditions</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="ri-check-line text-emerald-500"></i>
                            <span class="text-slate-700">Lecture préalable recommandée</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="ri-check-line text-emerald-500"></i>
                            <span class="text-slate-700">Acceptation sans réserve requise</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 3 -->
            <article id="article3" class="scroll-mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-emerald-700">3</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Inscription et compte</h2>
                        <p class="text-slate-600 text-sm">Conditions d'accès à la plateforme</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Vendeurs -->
                    <div class="bg-gradient-to-b from-emerald-50 to-white rounded-xl p-6 border border-emerald-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                <i class="ri-store-3-line text-emerald-600"></i>
                            </div>
                            <h3 class="font-bold text-slate-900">Pour les vendeurs</h3>
                        </div>

                        <ul class="space-y-2">
                            <li class="flex items-start gap-2">
                                <i class="ri-check-line text-emerald-500 mt-1"></i>
                                <span class="text-sm text-slate-700">Statut professionnel requis</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ri-check-line text-emerald-500 mt-1"></i>
                                <span class="text-sm text-slate-700">Informations exactes obligatoires</span>
                            </li>

                            <li class="flex items-start gap-2">
                                <i class="ri-check-line text-emerald-500 mt-1"></i>
                                <span class="text-sm text-slate-700">Respect des règles de qualité</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Acheteurs -->
                    <div class="bg-gradient-to-b from-blue-50 to-white rounded-xl p-6 border border-blue-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="ri-user-line text-blue-600"></i>
                            </div>
                            <h3 class="font-bold text-slate-900">Pour les acheteurs</h3>
                        </div>

                        <ul class="space-y-2">

                            <li class="flex items-start gap-2">
                                <i class="ri-check-line text-blue-500 mt-1"></i>
                                <span class="text-sm text-slate-700">Informations exactes</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ri-check-line text-blue-500 mt-1"></i>
                                <span class="text-sm text-slate-700">Confidentialité des identifiants</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ri-check-line text-blue-500 mt-1"></i>
                                <span class="text-sm text-slate-700">Compte personnel</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>

            <!-- Article 4 -->
            <article id="article4" class="scroll-mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-emerald-700">4</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Services proposés</h2>
                        <p class="text-slate-600 text-sm">Fonctionnalités disponibles</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="ri-store-3-line text-emerald-600"></i>
                            Services vendeurs
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-emerald-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Boutique en ligne</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-emerald-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Gestion de catalogue</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-emerald-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Outils de commandes</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-emerald-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Tableau de bord</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="ri-shopping-cart-2-line text-blue-600"></i>
                            Services acheteurs
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-blue-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Recherche de produits</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-blue-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Achat sécurisé</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-blue-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Suivi de commande</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ri-checkbox-blank-circle-fill text-blue-500 text-xs"></i>
                                <span class="text-sm text-slate-700">Service client</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>

            <!-- Article 5 -->
            <article id="article5" class="scroll-mt-10">
                <div class="flex items-center gap-4 mb-3">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-emerald-700">5</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Obligations des vendeurs</h2>
                        <p class="text-slate-600 text-sm">Règles de conformité</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-4">
                    <div class="space-y-4">
                        <div class="p-4 bg-white rounded-lg">
                            <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                                <i class="ri-information-line text-emerald-600"></i>
                                Informations légales
                            </h4>
                            <p class="text-sm text-slate-700">
                                Affichage des mentions légales • Description précise des produits • Respect de la propriété intellectuelle
                            </p>
                        </div>

                        <div class="p-4 bg-white rounded-lg">
                            <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                                <i class="ri-box-3-line text-emerald-600"></i>
                                Produits et services
                            </h4>
                            <p class="text-sm text-slate-700">
                                Conformité des produits • Respect des délais • Gestion des retours • Service après-vente
                            </p>
                        </div>

                        <div class="p-4 bg-white rounded-lg">
                            <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                                <i class="ri-money-dollar-circle-line text-emerald-600"></i>
                                Prix et facturation
                            </h4>
                            <p class="text-sm text-slate-700">
                                Prix TTC clairs • Facturation conforme
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 6 -->
            <article id="article6" class="scroll-mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-emerald-700">6</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Tarifs et paiement</h2>
                        <p class="text-slate-600 text-sm">Conditions financières</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-6 border border-slate-200">
                        <div class="h-12 w-12 rounded-lg bg-emerald-100 flex items-center justify-center mb-4">
                            <i class="ri-calendar-line text-emerald-600"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Abonnements</h3>
                        <ul class="space-y-2 text-sm text-slate-700">
                            <li>Essai gratuit 30 jours</li>
                            <li>Mensuel/annuel</li>
                            <li>Facturation post-essai</li>
                            <li>Pas de renouvellement automatique</li>
                        </ul>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-slate-200">
                        <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center mb-4">
                            <i class="ri-percent-line text-blue-600"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Commissions</h3>
                        <ul class="space-y-2 text-sm text-slate-700">
                            <li>Selon formule choisie</li>
                            <li>Paiement mensuel</li>
                            <li>Facturation détaillée</li>
                            <li>Transparence garantie</li>
                        </ul>
                    </div>


                </div>
            </article>

            <!-- Article 7-8 -->
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Article 7 -->
                <article id="article7" class="scroll-mt-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <span class="font-bold text-emerald-700">7</span>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900">Propriété intellectuelle</h2>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-slate-200">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-2">Plateforme MYLMARK</h4>
                                <p class="text-sm text-slate-700">
                                    Éléments protégés • Reproduction interdite
                                </p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-2">Contenu vendeurs</h4>
                                <p class="text-sm text-slate-700">
                                    Droits conservés • Accord de diffusion • Responsabilité du contenu
                                </p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Article 8 -->
                <article id="article8" class="scroll-mt-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <span class="font-bold text-emerald-700">8</span>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900">Données personnelles</h2>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-slate-200">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-2">Protection RGPD</h4>
                                <p class="text-sm text-slate-700">
                                    Politique de confidentialité • Droits d'accès • Suppression possible
                                </p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-2">Utilisation</h4>
                                <p class="text-sm text-slate-700">
                                    Amélioration services • Non-vente à tiers
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 9 -->
            <article id="article9" class="scroll-mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-emerald-700">9</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Responsabilités</h2>
                        <p class="text-slate-600 text-sm">Engagements de chaque partie</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-6">
                    <div class="space-y-6">
                        <div class="p-4 bg-white rounded-lg">
                            <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="ri-building-line text-emerald-600"></i>
                                MYLMARK
                            </h4>
                            <ul class="space-y-2 text-sm text-slate-700">
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-emerald-500 mt-1"></i>
                                    Hébergement et maintenance technique
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-emerald-500 mt-1"></i>
                                    Support utilisateur disponible
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="ri-close-line text-rose-500 mt-1"></i>
                                    Non responsable des litiges entre utilisateurs
                                </li>
                            </ul>
                        </div>

                        <div class="p-4 bg-white rounded-lg">
                            <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="ri-store-3-line text-blue-600"></i>
                                Vendeurs
                            </h4>
                            <ul class="space-y-2 text-sm text-slate-700">
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-blue-500 mt-1"></i>
                                    Responsables de leurs produits
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-blue-500 mt-1"></i>
                                    Conformité légale obligatoire
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-blue-500 mt-1"></i>
                                    Service clientèle à assurer
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Contact Section -->
            <div class="bg-gradient-to-r from-emerald-50 to-blue-50 rounded-2xl p-6 border border-emerald-100">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Questions sur les CGU ?</h3>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="mailto:contact@mylmark.com"
                           class="inline-flex items-center gap-2 bg-white text-slate-800 px-6 py-3 rounded-lg font-medium hover:bg-slate-50 transition-colors border border-slate-300">
                            <i class="ri-mail-line"></i>
                            contact@mylmark.com
                        </a>
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                            <i class="ri-message-3-line"></i>
                            Formulaire de contact
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

<style>
    html {
        scroll-behavior: smooth;
    }

    .scroll-mt-10 {
        scroll-margin-top: 3rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .grid-cols-2, .grid-cols-3 {
            grid-template-columns: 1fr;
        }

        .sticky {
            position: relative;
            top: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight current section in TOC
        const articles = document.querySelectorAll('article, [id^="article"]');
        const links = document.querySelectorAll('a[href^="#article"]');

        function highlightCurrentArticle() {
            let currentArticle = '';

            articles.forEach(article => {
                const rect = article.getBoundingClientRect();
                if (rect.top <= 150 && rect.bottom >= 150) {
                    currentArticle = article.id;
                }
            });

            links.forEach(link => {
                link.classList.remove('text-emerald-600', 'font-medium');
                link.classList.add('text-slate-700');

                if (link.getAttribute('href') === `#${currentArticle}`) {
                    link.classList.add('text-emerald-600', 'font-medium');
                    link.classList.remove('text-slate-700');
                }
            });
        }

        window.addEventListener('scroll', highlightCurrentArticle);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });


    });
</script>
@endsection
