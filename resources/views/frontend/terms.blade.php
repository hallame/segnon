@extends('frontend.layouts.master')

@section('title', 'Conditions Générales d\'Utilisation • MYLMARK')
@section('meta_title', 'CGU • MYLMARK')
@section('meta_description', 'Conditions Générales d\'Utilisation de la plateforme MYLMARK.')
@section('meta_image', asset('assets/images/terms.png'))

@section('content')

<!-- HERO -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">
    <div class="max-w-6xl mx-auto px-4 pt-12 pb-14 text-center relative">
        <h1 class="mt-4 text-4xl font-bold">
            Conditions Générales <span class="text-emerald-300">d’Utilisation</span>
        </h1>
        <p class="mt-4 text-slate-300">
            Dernière mise à jour : {{ date('d/m/Y') }}
        </p>
    </div>
</section>

<!-- CONTENT -->
<section class="bg-white py-8">
    <div class="max-w-4xl mx-auto px-4 space-y-10">

        <!-- ARTICLE 1 -->
        <article id="article1">
            <h2 class="text-2xl font-bold mb-4">1. Objet</h2>
            <p class="text-slate-700 leading-relaxed">
                Les présentes Conditions Générales d’Utilisation (CGU) ont pour objet de définir les modalités
                d’accès et d’utilisation de la plateforme <strong>MYLMARK</strong>, accessible à l’adresse
                <strong><a href="{{ route('home') }}">https://mylmark.com</a></strong>.
            </p>
            <p class="mt-3 text-slate-700">
                MYLMARK est une plateforme permettant la mise en relation entre vendeurs et acheteurs,
                sans intervenir directement dans la vente des produits.
            </p>
        </article>

        <!-- ARTICLE 2 -->
        <article id="article2">
            <h2 class="text-2xl font-bold mb-4">2. Acceptation des CGU</h2>
            <p class="text-slate-700">
                L’accès ou l’utilisation de la plateforme implique l’acceptation pleine et entière
                des présentes CGU.
            </p>
            <p class="mt-2 text-slate-700">
                En cas de désaccord avec tout ou partie des CGU, l’utilisateur est invité à ne pas utiliser la plateforme.
            </p>
        </article>

        <!-- ARTICLE 3 -->
        <article id="article3">
            <h2 class="text-2xl font-bold mb-4">3. Inscription et comptes utilisateurs</h2>
            <p class="text-slate-700">
                L’inscription est gratuite et nécessite la fourniture d’informations exactes et à jour.
                Chaque utilisateur est responsable de la confidentialité de ses identifiants.
            </p>
            <ul class="list-disc list-inside mt-3 text-slate-700 space-y-1">
                <li>Un compte est strictement personnel</li>
                <li>Toute usurpation est interdite</li>
                <li>MYLMARK se réserve le droit de suspendre tout compte abusif</li>
            </ul>
        </article>

        <!-- ARTICLE 4 -->
        <article id="article4">
            <h2 class="text-2xl font-bold mb-4">4. Services proposés</h2>
            <p class="text-slate-700">
                MYLMARK met à disposition des outils permettant :
            </p>
            <ul class="list-disc list-inside mt-3 text-slate-700 space-y-1">
                <li>La création et la gestion de boutiques en ligne</li>
                <li>La mise en ligne de produits</li>
                <li>La gestion des commandes</li>
                <li>Un tableau de bord de suivi</li>
            </ul>
        </article>

        <!-- ARTICLE 5 -->
        <article id="article5">
            <h2 class="text-2xl font-bold mb-4">5. Obligations des vendeurs</h2>
            <p class="text-slate-700">
                Les vendeurs sont seuls responsables des produits proposés sur la plateforme.
            </p>
            <ul class="list-disc list-inside mt-3 text-slate-700 space-y-1">
                <li>Exactitude des descriptions</li>
                <li>Conformité légale des produits</li>
                <li>Respect des délais et du service client</li>
                <li>Respect des droits de propriété intellectuelle</li>
            </ul>
        </article>

        <!-- ARTICLE 6 -->
        <article id="article6">
            <h2 class="text-2xl font-bold mb-4">6. Tarifs et services payants</h2>
            <p class="text-slate-700">
                L’accès à la plateforme peut inclure des services gratuits et/ou payants,
                selon les formules proposées.
            </p>
            <p class="mt-3 text-slate-700">
                MYLMARK se réserve la possibilité de proposer, à terme, des services optionnels payants,
                notamment des solutions de mise en avant ou de publicité en ligne (SEA) des produits des vendeurs.
            </p>
            <p class="mt-3 text-slate-700">
                Les modalités, tarifs et conditions de ces services feront l’objet d’une communication spécifique.
            </p>
        </article>

        <!-- ARTICLE 7 -->
        <article id="article7">
            <h2 class="text-2xl font-bold mb-4">7. Propriété intellectuelle</h2>
            <p class="text-slate-700">
                L’ensemble des éléments composant la plateforme MYLMARK est protégé par le droit de la propriété intellectuelle.
            </p>
            <p class="mt-3 text-slate-700">
                Les vendeurs conservent l’intégralité des droits sur leurs contenus.
                Ils accordent à MYLMARK une licence non exclusive d’utilisation pour les besoins du service.
            </p>
        </article>

        <!-- ARTICLE 8 -->
        <article id="article8">
            <h2 class="text-2xl font-bold mb-4">8. Données personnelles</h2>
            <p class="text-slate-700">
                Les données personnelles sont traitées conformément à la réglementation en vigueur.
            </p>
            <p class="mt-3 text-slate-700">
                Chaque utilisateur dispose d’un droit d’accès, de rectification et de suppression
                de ses données.
            </p>
        </article>

        <!-- ARTICLE 9 -->
        <article id="article9">
            <h2 class="text-2xl font-bold mb-4">9. Responsabilité</h2>
            <p class="text-slate-700">
                MYLMARK agit exclusivement en tant que plateforme technique d’intermédiation.
            </p>
            <p class="mt-3 text-slate-700">
                MYLMARK ne saurait être tenue responsable des litiges, transactions ou différends
                intervenant entre vendeurs et acheteurs.
            </p>
        </article>

        <!-- ARTICLE 10 -->
        <article id="article10">
            <h2 class="text-2xl font-bold mb-4">10. Modification des CGU</h2>
            <p class="text-slate-700">
                MYLMARK se réserve le droit de modifier les présentes CGU à tout moment.
                Les utilisateurs seront informés de toute modification significative.
            </p>
        </article>

        <!-- CONTACT - Version améliorée -->
        <div class="bg-gradient-to-r from-emerald-50 to-blue-50 rounded-xl p-6 text-center border border-emerald-100">
            <p class="text-slate-700 font-medium mb-3">Une question sur les conditions ?</p>
            <a href="{{ route('contact') }}"
            class="group inline-flex items-center gap-2 bg-white text-slate-800 px-5 py-2.5 rounded-lg font-medium hover:bg-slate-50 transition-all duration-300 border border-slate-300 hover:border-slate-400 shadow-sm hover:shadow">
                <i class="ri-question-line text-emerald-600 group-hover:scale-110 transition-transform"></i>
                Nous contacter
            </a>
        </div>


    </div>
</section>

@endsection
