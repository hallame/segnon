@extends('frontend.layouts.master')

@section('title', 'Conditions Générales d\'Utilisation - Segnon Shop')
@section('meta_description', 'Consultez les conditions générales d\'utilisation de Segnon Shop. Informations légales sur l\'utilisation de notre site et services.')
@section('og_image', asset('assets/images/cgu-segnon.jpg'))
@section('robots', 'index, follow')

@section('content')

<!-- ===== HERO CGU ===== -->
<section class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden py-8 md:py-10">
    <!-- Formes décoratives légères -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-terracotta-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-safari-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float-slow"></div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <!-- Icône -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-terracotta-100 rounded-2xl mb-6">
                <i class="fas fa-file-contract text-4xl text-terracotta-600"></i>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold mb-6">
                Conditions Générales <span class="gradient-text">d'Utilisation</span>
            </h1>
            
            <p class="text-lg text-night-600 max-w-3xl mx-auto">
                Les présentes conditions régissent l'utilisation du site Segnon Shop. En naviguant sur notre site, vous acceptez ces conditions sans réserve.
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
            <a href="#champ-application" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Champ d'application</a>
            <a href="#acces-services" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Accès aux services</a>
            <a href="#propriete-intellectuelle" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Propriété intellectuelle</a>
            <a href="#responsabilite" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Responsabilité</a>
            <a href="#donnees" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Données personnelles</a>
            <a href="#liens" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Liens externes</a>
            <a href="#modifications" class="px-4 py-2 rounded-full bg-sand-100 text-night-700 hover:bg-terracotta-500 hover:text-white transition">Modifications</a>
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
                Bienvenue sur le site de <strong class="text-night-900">Segnon Shop</strong> (ci-après "le Site"). Les présentes Conditions Générales d'Utilisation (CGU) ont pour objet de définir les modalités et conditions dans lesquelles les utilisateurs accèdent au Site et utilisent ses services.
            </p>
            <p>
                En accédant au Site et en l'utilisant, vous reconnaissez avoir pris connaissance des présentes CGU et les accepter sans réserve. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser notre Site.
            </p>
        </div>

        <!-- SECTION 1: CHAMP D'APPLICATION -->
        <div id="champ-application" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-globe text-2xl text-terracotta-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 1 : Champ d'application</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <p>Les présentes CGU s'appliquent à toute utilisation du Site, que vous soyez simple visiteur, client potentiel ou client enregistré. Elles sont accessibles à tout moment sur le Site et prévalent, le cas échéant, sur toute autre version ou document contradictoire.</p>
                <p>Segnon Shop se réserve le droit de modifier les présentes CGU à tout moment. Les modifications entrent en vigueur à compter de leur mise en ligne. Il est de votre responsabilité de consulter régulièrement les CGU.</p>
            </div>
        </div>

        <!-- SECTION 2: ACCÈS AUX SERVICES -->
        <div id="acces-services" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-saffron-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-sign-in-alt text-2xl text-saffron-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 2 : Accès aux services</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <p>Le Site est accessible gratuitement à tout utilisateur disposant d'un accès à Internet. Tous les frais supportés pour accéder au Service (connexion Internet, matériel, etc.) sont à la charge de l'utilisateur.</p>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-6 mb-3">2.1 Inscription</h3>
                <p>Certains services peuvent nécessiter une inscription préalable. Lors de l'inscription, vous vous engagez à fournir des informations exactes, complètes et à jour. Vous êtes responsable de la confidentialité de vos identifiants et de toutes les activités effectuées depuis votre compte.</p>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-6 mb-3">2.2 Suspension ou interruption</h3>
                <p>Segnon Shop s'efforce de maintenir le Site accessible 7j/7 et 24h/24, mais n'est tenu à aucune obligation d'y parvenir. Nous pouvons suspendre l'accès au Site pour des raisons de maintenance, de mises à jour ou pour toute autre raison, sans préavis ni indemnité.</p>
            </div>
        </div>

        <!-- SECTION 3: PROPRIÉTÉ INTELLECTUELLE -->
        <div id="propriete-intellectuelle" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-safari-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-copyright text-2xl text-safari-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 3 : Propriété intellectuelle</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <p>L'ensemble du contenu du Site (textes, images, vidéos, logos, marques, etc.) est la propriété exclusive de Segnon Shop ou de ses partenaires et est protégé par les lois sur la propriété intellectuelle.</p>
                
                <p>Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du Site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de Segnon Shop.</p>
                
                <div class="bg-sand-50 p-5 rounded-xl mt-4">
                    <p class="text-sm flex items-start gap-2">
                        <i class="fas fa-exclamation-triangle text-terracotta-500 mt-0.5"></i>
                        <span>Toute exploitation non autorisée du Site ou de son contenu engagera la responsabilité de l'utilisateur et pourra donner lieu à des poursuites judiciaires.</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- SECTION 4: RESPONSABILITÉ -->
        <div id="responsabilite" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-balance-scale text-2xl text-terracotta-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 4 : Responsabilité</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <h3 class="text-xl font-display font-semibold text-night-800 mt-2 mb-3">4.1 Limitations de responsabilité</h3>
                <p>Segnon Shop s'efforce de fournir des informations précises et à jour, mais ne garantit pas l'exactitude, l'exhaustivité ou l'actualité des contenus. L'utilisation du Site se fait sous votre seule responsabilité.</p>
                
                <p>Segnon Shop ne pourra être tenu responsable :</p>
                <ul class="list-disc pl-6 space-y-2 mt-2">
                    <li>Des dommages directs ou indirects liés à l'utilisation du Site</li>
                    <li>Des interruptions temporaires du service</li>
                    <li>Des virus ou autres infections informatiques</li>
                    <li>Des pertes de données ou d'opportunités commerciales</li>
                </ul>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-6 mb-3">4.2 Obligations de l'utilisateur</h3>
                <p>Vous vous engagez à :</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Utiliser le Site conformément aux lois et règlements en vigueur</li>
                    <li>Ne pas porter atteinte à l'intégrité du Site (tentatives de piratage, diffusion de virus, etc.)</li>
                    <li>Ne pas collecter ou utiliser les données des autres utilisateurs sans autorisation</li>
                    <li>Ne pas diffuser de contenus illicites, diffamatoires ou contraires à l'ordre public</li>
                </ul>
            </div>
        </div>

        <!-- SECTION 5: DONNÉES PERSONNELLES -->
        <div id="donnees" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-saffron-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-user-shield text-2xl text-saffron-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 5 : Données personnelles</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <p>Segnon Shop accorde une importance particulière à la protection de vos données personnelles. La collecte et le traitement de vos informations sont régis par notre <a href="/confidentialite" class="text-terracotta-500 hover:underline">Politique de Confidentialité</a>, que nous vous invitons à consulter.</p>
                
                <p>Conformément à la réglementation, vous disposez d'un droit d'accès, de rectification et de suppression de vos données. Pour l'exercer, contactez-nous à <a href="mailto:contact@segnonshop.com" class="text-terracotta-500 hover:underline">contact@segnonshop.com</a>.</p>
            </div>
        </div>

        <!-- SECTION 6: LIENS EXTERNES -->
        <div id="liens" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-safari-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-external-link-alt text-2xl text-safari-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 6 : Liens externes</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <p>Le Site peut contenir des liens vers des sites tiers. Ces liens sont fournis pour votre commodité et n'impliquent aucune approbation de notre part quant au contenu de ces sites.</p>
                
                <p>Segnon Shop n'exerce aucun contrôle sur ces sites et décline toute responsabilité concernant leur contenu, leurs pratiques en matière de confidentialité ou leur disponibilité. L'utilisation de ces sites relève de votre seule responsabilité.</p>
            </div>
        </div>

        <!-- SECTION 7: MODIFICATIONS -->
        <div id="modifications" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-sync-alt text-2xl text-terracotta-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 7 : Modifications des CGU</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <p>Segnon Shop se réserve le droit de modifier les présentes CGU à tout moment, notamment pour s'adapter aux évolutions législatives, réglementaires ou techniques.</p>
                
                <p>Les modifications entrent en vigueur dès leur publication sur le Site. En continuant à utiliser le Site après ces modifications, vous acceptez les CGU révisées. Si vous n'acceptez pas les modifications, vous devez cesser d'utiliser le Site.</p>
            </div>
        </div>

        <!-- SECTION 8: DROIT APPLICABLE ET JURIDICTION -->
        <div id="droit" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-saffron-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-gavel text-2xl text-saffron-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 8 : Droit applicable et juridiction</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <p>Les présentes CGU sont régies par le droit béninois. Tout litige relatif à leur interprétation et/ou à leur exécution relève des tribunaux compétents de Cotonou.</p>
                
                <p>En cas de litige, les parties s'efforceront de trouver une solution amiable avant toute action judiciaire.</p>
            </div>
        </div>

        <!-- SECTION 9: DIVERS -->
        <div id="divers" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-safari-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-ellipsis-h text-2xl text-safari-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 9 : Dispositions diverses</h2>
            </div>
            
            <div class="space-y-4 text-night-600">
                <h3 class="text-xl font-display font-semibold text-night-800 mt-2 mb-3">9.1 Nullité partielle</h3>
                <p>Si une disposition des présentes CGU est jugée invalide ou inapplicable par une juridiction compétente, les autres dispositions resteront en vigueur.</p>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-6 mb-3">9.2 Non-renonciation</h3>
                <p>Le fait pour Segnon Shop de ne pas se prévaloir d'un manquement aux présentes CGU ne vaut pas renonciation à s'en prévaloir ultérieurement.</p>
                
                <h3 class="text-xl font-display font-semibold text-night-800 mt-6 mb-3">9.3 Intégralité</h3>
                <p>Les présentes CGU constituent l'intégralité de l'accord entre vous et Segnon Shop concernant l'utilisation du Site.</p>
            </div>
        </div>

        <!-- SECTION 10: CONTACT -->
        <div id="contact" class="mb-16 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-headset text-2xl text-terracotta-600"></i>
                </div>
                <h2 class="text-3xl font-display font-bold">Article 10 : Contact</h2>
            </div>
            
            <div class="bg-sand-50 p-8 rounded-3xl">
                <p class="text-night-600 mb-6">Pour toute question relative aux présentes CGU, vous pouvez nous contacter :</p>
                
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
                    
                    <div class="flex items-start gap-3">
                        <i class="fab fa-whatsapp text-terracotta-500 mt-1"></i>
                        <div>
                            <span class="font-medium text-night-800">WhatsApp :</span>
                            <a href="https://wa.me/22900000000" class="text-terracotta-500 hover:underline block">+229 00 00 00 00</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SECTION ACCEPTATION ===== -->
{{-- <section class="py-10 bg-sand-50 border-y border-sand-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-6">
            <i class="fas fa-check-circle text-3xl text-terracotta-500"></i>
        </div>
        <h3 class="text-2xl font-display font-bold mb-4">En utilisant notre site, vous acceptez ces conditions</h3>
        <p class="text-night-600 max-w-3xl mx-auto">
            Si vous avez des questions concernant ces conditions, n'hésitez pas à nous contacter. Notre équipe est à votre disposition.
        </p>
        
        <!-- Liens utiles -->
        <div class="flex flex-wrap justify-center gap-6 mt-8">
            <a href="/confidentialite" class="text-terracotta-500 hover:underline flex items-center gap-2">
                <i class="fas fa-shield-alt"></i>
                Politique de confidentialité
            </a>
            <a href="/mentions-legales" class="text-terracotta-500 hover:underline flex items-center gap-2">
                <i class="fas fa-gavel"></i>
                Mentions légales
            </a>
            <a href="/cookies" class="text-terracotta-500 hover:underline flex items-center gap-2">
                <i class="fas fa-cookie-bite"></i>
                Gestion des cookies
            </a>
        </div>
        
        <!-- Bouton d'acceptation simulé -->
        <div class="mt-10">
            <button class="bg-terracotta-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-terracotta-600 transition shadow-lg hover:shadow-xl inline-flex items-center gap-2">
                <i class="fas fa-check"></i>
                J'accepte les conditions
            </button>
            <p class="text-xs text-night-400 mt-4">
                En cliquant, vous confirmez avoir lu et accepté nos conditions générales d'utilisation.
            </p>
        </div>
    </div>
</section> --}}


@endsection