@extends('frontend.layouts.master')

@section('title', 'Politique de Confidentialité - Segnon Shop')
@section('meta_description', 'Découvrez comment Segnon Shop protège vos données personnelles et respecte votre vie privée.')
@section('og_image', asset('assets/images/confidentialite-segnon.jpg'))
@section('robots', 'index, follow')

@section('content')

<!-- ===== HERO CONFIDENTIALITÉ ===== -->
<section class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden py-16 md:py-20">
    <!-- Formes décoratives légères -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-terracotta-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-safari-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float-slow"></div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <!-- Icône de protection -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-terracotta-100 rounded-2xl mb-6">
                <i class="fas fa-shield-alt text-4xl text-terracotta-600"></i>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold mb-6">
                Politique de <span class="gradient-text">confidentialité</span>
            </h1>
            
            <p class="text-lg text-night-600 max-w-3xl mx-auto">
                Chez Segnon Shop, la protection de vos données personnelles est une priorité. 
                Cette page vous explique quelles informations nous collectons et comment nous les utilisons.
            </p>
            
            <!-- Date de mise à jour -->
            <div class="mt-8 inline-flex items-center gap-2 bg-white/80 backdrop-blur px-4 py-2 rounded-full text-sm text-night-500">
                <i class="far fa-calendar-alt text-terracotta-500"></i>
                Dernière mise à jour : 25 février 2025
            </div>
        </div>
    </div>
</section>

<!-- ===== SOMMAIRE (ancres rapides) ===== -->
{{-- <section class="py-8 bg-white border-b border-sand-200 sticky top-20 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-4 text-sm">
            <span class="text-night-500 font-medium">Accès rapide :</span>
            <a href="#collecte" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Collecte</a>
            <a href="#utilisation" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Utilisation</a>
            <a href="#cookies" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Cookies</a>
            <a href="#partage" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Partage</a>
            <a href="#droits" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Vos droits</a>
            <a href="#securite" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Sécurité</a>
            <a href="#contact" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Contact</a>
        </div>
    </div>
</section> --}}

<!-- ===== CONTENU PRINCIPAL ===== -->
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- INTRODUCTION -->
        <div class="prose prose-lg max-w-none text-night-600 mb-16">
            <p class="lead">
                La présente politique de confidentialité décrit comment <strong class="text-night-900">Segnon Shop</strong> (ci-après "nous", "notre" ou "nos") collecte, utilise et protège les informations que vous nous fournissez lorsque vous utilisez notre site web et nos services.
            </p>
            <p>
                Nous nous engageons à garantir que votre vie privée est protégée. Si nous vous demandons de fournir certaines informations permettant de vous identifier lors de votre navigation sur ce site, vous pouvez être assuré qu'elles ne seront utilisées que conformément à la présente déclaration de confidentialité.
            </p>
        </div>

        <!-- SECTION 1: COLLECTE -->
        <div id="collecte" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-database text-2xl text-terracotta-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">1. Informations que nous collectons</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Nous pouvons collecter les types d'informations suivants :</p>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-6 mb-3">a) Informations que vous nous fournissez directement</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong class="text-night-800">Coordonnées :</strong> nom, prénom, adresse email, numéro de téléphone lorsque vous remplissez nos formulaires de contact ou passez commande.</li>
                    <li><strong class="text-night-800">Informations de commande :</strong> adresse de livraison, préférences de produits, historique d'achat.</li>
                    <li><strong class="text-night-800">Messages :</strong> tout contenu que vous nous envoyez via nos formulaires, WhatsApp ou email.</li>
                </ul>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-6 mb-3">b) Informations collectées automatiquement</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong class="text-night-800">Données de navigation :</strong> pages visitées, temps passé, liens cliqués.</li>
                    <li><strong class="text-night-800">Informations techniques :</strong> adresse IP, type de navigateur, système d'exploitation.</li>
                    <li><strong class="text-night-800">Cookies :</strong> nous utilisons des cookies pour améliorer votre expérience (voir section dédiée).</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 2: UTILISATION -->
        <div id="utilisation" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-saffron-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-cogs text-2xl text-saffron-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">2. Utilisation de vos informations</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Nous utilisons vos informations pour :</p>
                
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-sand-50 p-5 rounded-xl">
                        <i class="fas fa-check-circle text-terracotta-500 mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800 mb-1">Traitement des commandes</h4>
                        <p class="text-sm">Gérer vos achats, livraisons et retours.</p>
                    </div>
                    <div class="bg-sand-50 p-5 rounded-xl">
                        <i class="fas fa-check-circle text-terracotta-500 mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800 mb-1">Service client</h4>
                        <p class="text-sm">Répondre à vos questions et traiter vos demandes.</p>
                    </div>
                    <div class="bg-sand-50 p-5 rounded-xl">
                        <i class="fas fa-check-circle text-terracotta-500 mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800 mb-1">Communication</h4>
                        <p class="text-sm">Vous envoyer des informations sur vos commandes ou nos offres.</p>
                    </div>
                    <div class="bg-sand-50 p-5 rounded-xl">
                        <i class="fas fa-check-circle text-terracotta-500 mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800 mb-1">Amélioration du site</h4>
                        <p class="text-sm">Analyser la navigation pour optimiser votre expérience.</p>
                    </div>
                </div>
                
                <p class="mt-4 text-sm italic">Nous ne vendons jamais vos données personnelles à des tiers.</p>
            </div>
        </div>

        <!-- SECTION 3: COOKIES -->
        <div id="cookies" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-safari-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-cookie-bite text-2xl text-safari-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">3. Cookies et technologies similaires</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Notre site utilise des cookies pour améliorer votre expérience de navigation. Les cookies sont de petits fichiers texte stockés sur votre appareil.</p>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-4 mb-3">Types de cookies utilisés :</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-sand-50 rounded-xl">
                        <thead class="bg-sand-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-night-800">Type</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-night-800">Objectif</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-night-800">Durée</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sand-200">
                            <tr>
                                <td class="px-4 py-3 text-sm">Essentiels</td>
                                <td class="px-4 py-3 text-sm">Navigation, panier, connexion</td>
                                <td class="px-4 py-3 text-sm">Session</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm">Fonctionnels</td>
                                <td class="px-4 py-3 text-sm">Mémoriser vos préférences</td>
                                <td class="px-4 py-3 text-sm">1 an</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm">Analytiques</td>
                                <td class="px-4 py-3 text-sm">Fréquentation du site</td>
                                <td class="px-4 py-3 text-sm">13 mois</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <p class="mt-4">Vous pouvez configurer votre navigateur pour refuser les cookies, mais certaines fonctionnalités du site pourraient être altérées.</p>
            </div>
        </div>

        <!-- SECTION 4: PARTAGE -->
        <div id="partage" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-share-alt text-2xl text-terracotta-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">4. Partage de vos informations</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Nous ne partageons vos informations personnelles que dans les cas suivants :</p>
                
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong class="text-night-800">Prestataires de services :</strong> transporteurs (livraison), solutions de paiement, hébergeur du site.</li>
                    <li><strong class="text-night-800">Obligations légales :</strong> si nous y sommes contraints par la loi ou une autorité administrative.</li>
                    <li><strong class="text-night-800">Consentement :</strong> avec votre autorisation explicite.</li>
                </ul>
                
                <div class="bg-sand-50 p-5 rounded-xl mt-4">
                    <p class="text-sm flex items-start gap-2">
                        <i class="fas fa-info-circle text-terracotta-500 mt-0.5"></i>
                        <span>Tous nos prestataires sont tenus de respecter la confidentialité de vos données et ne peuvent les utiliser à d'autres fins.</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- SECTION 5: VOS DROITS -->
        <div id="droits" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-saffron-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-gavel text-2xl text-saffron-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">5. Vos droits</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Conformément à la réglementation en vigueur, vous disposez des droits suivants :</p>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="border border-sand-200 p-5 rounded-xl">
                        <i class="fas fa-eye text-terracotta-500 text-xl mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800">Droit d'accès</h4>
                        <p class="text-sm">Obtenir une copie des données que nous détenons.</p>
                    </div>
                    <div class="border border-sand-200 p-5 rounded-xl">
                        <i class="fas fa-eraser text-terracotta-500 text-xl mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800">Droit d'effacement</h4>
                        <p class="text-sm">Demander la suppression de vos données.</p>
                    </div>
                    <div class="border border-sand-200 p-5 rounded-xl">
                        <i class="fas fa-pen text-terracotta-500 text-xl mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800">Droit de rectification</h4>
                        <p class="text-sm">Corriger des informations inexactes.</p>
                    </div>
                    <div class="border border-sand-200 p-5 rounded-xl">
                        <i class="fas fa-ban text-terracotta-500 text-xl mb-2"></i>
                        <h4 class="font-display font-semibold text-night-800">Droit d'opposition</h4>
                        <p class="text-sm">Vous opposer à certains traitements.</p>
                    </div>
                </div>
                
                <p class="mt-4">Pour exercer ces droits, contactez-nous à l'adresse <a href="mailto:contact@segnonshop.com" class="text-terracotta-500 hover:underline">contact@segnonshop.com</a>. Nous répondrons dans un délai de 30 jours.</p>
            </div>
        </div>

        <!-- SECTION 6: SÉCURITÉ -->
        <div id="securite" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-safari-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-lock text-2xl text-safari-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">6. Sécurité des données</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Nous mettons en œuvre des mesures techniques et organisationnelles pour protéger vos données :</p>
                
                <ul class="list-disc pl-6 space-y-2">
                    <li>Cryptage SSL sur toutes les pages du site</li>
                    <li>Accès restreint aux données (personnel habilité uniquement)</li>
                    <li>Sauvegardes régulières</li>
                    <li>Pare-feu et systèmes de détection d'intrusion</li>
                </ul>
                
                <p class="text-sm italic">Malgré ces mesures, aucun système n'est infaillible. En cas de violation de données, nous vous en informerons dans les meilleurs délais.</p>
            </div>
        </div>

        <!-- SECTION 7: CONSERVATION -->
        <div id="conservation" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-clock text-2xl text-terracotta-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">7. Durée de conservation</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Nous conservons vos données aussi longtemps que nécessaire :</p>
                
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong class="text-night-800">Comptes clients :</strong> 3 ans après votre dernière activité.</li>
                    <li><strong class="text-night-800">Commandes :</strong> 5 ans (obligations fiscales).</li>
                    <li><strong class="text-night-800">Messages de contact :</strong> 1 an après le dernier échange.</li>
                    <li><strong class="text-night-800">Données de navigation :</strong> 13 mois maximum.</li>
                </ul>
                
                <p>Au-delà de ces périodes, vos données sont anonymisées ou supprimées.</p>
            </div>
        </div>

        <!-- SECTION 8: COORDONNÉES -->
        <div id="contact" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-saffron-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-envelope text-2xl text-saffron-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">8. Nous contacter</h2>
            </div>
            
            <div class="bg-sand-50 p-8 rounded-3xl">
                <p class="text-night-600 mb-6">Pour toute question relative à cette politique ou pour exercer vos droits, vous pouvez nous joindre :</p>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-envelope text-terracotta-500 mt-1"></i>
                        <div>
                            <span class="font-medium text-night-800">Email :</span>
                            <a href="mailto:contact@segnonshop.com" class="text-terracotta-500 hover:underline block">contact@segnonshop.com</a>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <i class="fas fa-phone-alt text-terracotta-500 mt-1"></i>
                        <div>
                            <span class="font-medium text-night-800">Téléphone :</span>
                            <a href="tel:+22900000000" class="text-terracotta-500 hover:underline block">+229 00 00 00 00</a>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-terracotta-500 mt-1"></i>
                        <div>
                            <span class="font-medium text-night-800">Adresse :</span>
                            <p class="text-night-600">123 Rue des Artisans, Cotonou, Bénin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 9: MODIFICATIONS -->
        <div class="mb-16">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-safari-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-sync-alt text-2xl text-safari-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">9. Modifications de la politique</h2>
            </div>
            
            <div class="space-y-6 text-night-600">
                <p>Nous pouvons modifier cette politique de confidentialité de temps à autre. La version en vigueur est toujours disponible sur cette page avec sa date de mise à jour.</p>
                <p>En cas de modification importante, nous vous en informerons par email ou via un bandeau sur notre site.</p>
            </div>
        </div>
    </div>
</section>

{{-- <!-- ===== SECTION DE CONFIANCE ===== -->
<section class="py-16 bg-sand-50 border-y border-sand-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-6">
                <i class="fas fa-check-circle text-3xl text-terracotta-500"></i>
            </div>
            <h3 class="text-2xl font-display font-bold mb-4">Votre confiance est notre priorité</h3>
            <p class="text-night-600 max-w-2xl mx-auto">
                Nous nous engageons à traiter vos données avec la plus grande transparence et à respecter votre vie privée.
            </p>
            
            <!-- Liens utiles -->
            <div class="flex flex-wrap justify-center gap-6 mt-8">
                <a href="/cookies" class="text-terracotta-500 hover:underline flex items-center gap-2">
                    <i class="fas fa-cookie-bite"></i>
                    Gestion des cookies
                </a>
                <a href="/cgv" class="text-terracotta-500 hover:underline flex items-center gap-2">
                    <i class="fas fa-file-contract"></i>
                    Conditions générales
                </a>
                <a href="/mentions-legales" class="text-terracotta-500 hover:underline flex items-center gap-2">
                    <i class="fas fa-gavel"></i>
                    Mentions légales
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== BANNIÈRE DE CONSENTEMENT COOKIES (SIMULÉE) ===== -->
<!-- À activer avec JavaScript plus tard -->
<div class="fixed bottom-6 left-6 right-6 md:left-auto md:right-6 md:w-96 bg-white rounded-2xl shadow-2xl border border-sand-200 p-6 z-50 hidden">
    <div class="flex items-start gap-3 mb-4">
        <i class="fas fa-cookie-bite text-2xl text-terracotta-500"></i>
        <div>
            <h4 class="font-display font-semibold">🍪 Nous aimons les cookies</h4>
            <p class="text-sm text-night-600">En poursuivant votre navigation, vous acceptez notre politique de confidentialité.</p>
        </div>
    </div>
    <div class="flex gap-2">
        <button class="flex-1 bg-terracotta-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-terracotta-600 transition">Accepter</button>
        <button class="flex-1 bg-sand-200 text-night-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-sand-300 transition">Personnaliser</button>
    </div>
</div> --}}

@endsection