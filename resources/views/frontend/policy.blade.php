@extends('frontend.layouts.master')

@section('title', 'Politique de Confidentialité • MYLMARK')
@section('meta_title', 'Politique de Confidentialité • MYLMARK')
@section('meta_description', 'Découvrez comment MYLMARK protège et traite vos données personnelles conformément au RGPD.')
@section('meta_image', asset('assets/images/privacy.png'))

@section('content')

<!-- HERO -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">
    <div class="max-w-6xl mx-auto px-4 py-8 text-center relative">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-500/10 mb-6">
            <i class="ri-shield-keyhole-line text-2xl text-emerald-400"></i>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Politique de <span class="text-emerald-300">Confidentialité</span>
        </h1>
        <p class="text-slate-300 text-lg max-w-2xl mx-auto">
            Comment nous protégeons et traitons vos données personnelles
        </p>
        <div class="mt-6 text-sm text-slate-400">
            <i class="ri-time-line mr-2"></i>Dernière mise à jour : 02/02/2026
        </div>
    </div>
</section>

<!-- CONTENT -->
<section class="bg-slate-50 py-6 md:py-8">
    <div class="max-w-4xl mx-auto px-2">

        <!-- Introduction -->
        <div class="mb-6 p-2 bg-white rounded-xl shadow-sm border border-slate-100">
            <p class="text-slate-700 leading-relaxed">
                Chez <strong class="text-slate-900">MYLMARK</strong>, la protection de vos données personnelles est une priorité absolue.
                Cette politique explique quelles données nous collectons, comment nous les utilisons et quels sont vos droits.
            </p>
        </div>

        <div class="space-y-2">
            <!-- ARTICLE 1 -->
            <article id="article1" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                        <span class="text-blue-600 font-bold">1</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Données que nous collectons</h2>
                        <p class="text-slate-700 mb-4">
                            Nous collectons uniquement les données nécessaires au bon fonctionnement de nos services :
                        </p>
                        <div class="grid md:grid-cols-2 gap-4 mt-4">
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <i class="ri-user-line text-emerald-500 mt-1"></i>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Données personnelles</h4>
                                        <p class="text-sm text-slate-600">Nom, prénom, email, téléphone</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="ri-briefcase-line text-emerald-500 mt-1"></i>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Données professionnelles</h4>
                                        <p class="text-sm text-slate-600">Pour les vendeurs et partenaires</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <i class="ri-shopping-cart-line text-emerald-500 mt-1"></i>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Données transactionnelles</h4>
                                        <p class="text-sm text-slate-600">Commandes, paiements, historique</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="ri-computer-line text-emerald-500 mt-1"></i>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Données techniques</h4>
                                        <p class="text-sm text-slate-600">Adresse IP, navigateur</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- ARTICLE 2 -->
            <article id="article2" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <span class="text-emerald-600 font-bold">2</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Utilisation de vos données</h2>
                        <p class="text-slate-700 mb-4">
                            Vos données sont traitées dans le cadre des finalités suivantes :
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-500 mt-1"></i>
                                <span class="text-slate-700">Fournir et améliorer nos services</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-500 mt-1"></i>
                                <span class="text-slate-700">Traiter vos commandes et sécuriser les transactions</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-500 mt-1"></i>
                                <span class="text-slate-700">Vous assister via notre service client</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-check-line text-emerald-500 mt-1"></i>
                                <span class="text-slate-700">Prévenir la fraude et assurer la sécurité de la plateforme</span>
                            </li>
                        </ul>
                        <div class="mt-6 p-4 bg-amber-50 border border-amber-100 rounded-lg">
                            <div class="flex items-start gap-3">
                                <i class="ri-shield-check-line text-amber-600 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-medium text-amber-900">Engagement de confidentialité</p>
                                    <p class="text-sm text-amber-800 mt-1">
                                        Nous ne vendons, ne louons ni ne partageons vos données personnelles à des fins commerciales.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- ARTICLE 3 -->
            <article id="article3" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                        <span class="text-purple-600 font-bold">3</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Cookies</h2>
                        <p class="text-slate-700 mb-4">
                            Nous utilisons des cookies pour :
                        </p>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start gap-3">
                                <i class="ri-fingerprint-line text-purple-500"></i>
                                <span class="text-slate-700">Maintenir votre session de connexion en toute sécurité</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-settings-3-line text-purple-500"></i>
                                <span class="text-slate-700">Mémoriser vos préférences et paramètres</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="ri-line-chart-line text-purple-500"></i>
                                <span class="text-slate-700">Analyser l'utilisation de la plateforme pour l'améliorer</span>
                            </li>
                        </ul>
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <p class="text-sm text-slate-700">
                                <i class="ri-information-line text-slate-500 mr-2"></i>
                                Vous pouvez gérer vos préférences cookies à tout moment via les paramètres de votre navigateur.
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- ARTICLE 4 -->
            <article id="article4" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                        <span class="text-red-600 font-bold">4</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Sécurité des données</h2>
                        <p class="text-slate-700 mb-6">
                            Nous mettons en œuvre des mesures techniques robustes pour protéger vos données :
                        </p>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <i class="ri-lock-line text-red-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Chiffrement SSL/TLS</h4>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <i class="ri-shield-star-line text-red-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Accès restreint</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <i class="ri-server-line text-red-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Sauvegardes régulières</h4>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <i class="ri-alarm-warning-line text-red-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Surveillance continue</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- ARTICLE 5 -->
            <article id="article5" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                        <span class="text-green-600 font-bold">5</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Vos droits</h2>
                        <p class="text-slate-700 mb-6">
                            Vous disposez des droits suivants sur vos données :
                        </p>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="p-4 bg-green-50 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="ri-eye-line text-green-600"></i>
                                        <h4 class="font-medium text-slate-900">Droit d'accès</h4>
                                    </div>
                                    <p class="text-sm text-slate-600">Consulter les données que nous détenons sur vous</p>
                                </div>
                                <div class="p-4 bg-green-50 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="ri-edit-line text-green-600"></i>
                                        <h4 class="font-medium text-slate-900">Droit de rectification</h4>
                                    </div>
                                    <p class="text-sm text-slate-600">Corriger des informations inexactes</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="p-4 bg-green-50 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="ri-delete-bin-line text-green-600"></i>
                                        <h4 class="font-medium text-slate-900">Droit à l'effacement</h4>
                                    </div>
                                    <p class="text-sm text-slate-600">Supprimer vos données ("droit à l'oubli")</p>
                                </div>
                                <div class="p-4 bg-green-50 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="ri-download-line text-green-600"></i>
                                        <h4 class="font-medium text-slate-900">Droit à la portabilité</h4>
                                    </div>
                                    <p class="text-sm text-slate-600">Récupérer vos données dans un format lisible</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-slate-700">
                                Pour exercer ces droits, contactez-nous à l'adresse ci-dessous.
                                Nous nous engageons à répondre dans un délai court.
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- ARTICLE 6 -->
            <article id="article6" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                        <span class="text-blue-600 font-bold">6</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Partage avec des tiers</h2>
                        <p class="text-slate-700 mb-6">
                            Vos données peuvent être partagées uniquement dans les cas suivants :
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                                <i class="ri-government-line text-blue-600 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-slate-900 mb-1">Obligations légales</h4>
                                    <p class="text-sm text-slate-600">Aux autorités compétentes lorsque la loi l'exige</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                                <i class="ri-store-line text-blue-600 mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-slate-900 mb-1">Vendeurs partenaires</h4>
                                    <p class="text-sm text-slate-600">Aux vendeurs concernés pour le traitement de vos commandes</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </article>

            <!-- ARTICLE 7 -->
            <article id="article7" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                        <span class="text-slate-600 font-bold">7</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Modifications de cette politique</h2>
                        <p class="text-slate-700 mb-4">
                            Cette politique de confidentialité peut être mise à jour pour refléter l'évolution de nos pratiques ou des obligations légales.
                        </p>

                    </div>
                </div>
            </article>

            {{-- <!-- ARTICLE 8 -->
            <article id="article8" class="bg-whiterounded-xl shadow-sm border border-slate-100">
                <div class="flex items-start gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <span class="text-emerald-600 font-bold">8</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Nous contacter</h2>
                        <p class="text-slate-700 mb-6">
                            Pour toute question concernant cette politique ou pour exercer vos droits :
                        </p>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="p-5 bg-emerald-50 rounded-xl">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                        <i class="ri-mail-line text-emerald-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Par email</h4>
                                        <a href="mailto:contact@mylmark.com" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                                            contact@mylmark.com
                                        </a>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-600">Réponse sous 48h ouvrées</p>
                            </div>
                            <div class="p-5 bg-emerald-50 rounded-xl">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                        <i class="ri-chat-3-line text-emerald-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">Formulaire de contact</h4>
                                        <a href="{{ route('contact') }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                                            Accéder au formulaire
                                        </a>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-600">Pour une assistance personnalisée</p>
                            </div>
                        </div>

                    </div>
                </div>
            </article> --}}

        </div>
    </div>
</section>

<!-- CTA -->
<section class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white py-6">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-500/20 mb-6">
            <i class="ri-question-line text-emerald-300 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold mb-4">Des questions sur la protection de vos données ?</h2>
        <p class="text-slate-300 mb-6 max-w-2xl mx-auto">
            Notre équipe est là pour vous accompagner et répondre à toutes vos interrogations concernant votre vie privée.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}"
               class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                <i class="ri-chat-3-line"></i> Nous contacter
            </a>
            <a href="{{ route('terms') }}"
               class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                <i class="ri-file-text-line"></i> Voir les CGU
            </a>
        </div>
    </div>
</section>

@endsection
