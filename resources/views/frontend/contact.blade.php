@extends('frontend.layouts.master')

@section('title', 'Contact - Segnon Shop | Posez-nous vos questions')
@section('meta_description', 'Contactez Segnon Shop pour vos projets de décoration. Réponse sous 24h par téléphone, WhatsApp ou email.')
@section('og_image', asset('assets/images/contact-segnon.jpg'))

@section('content')

<!-- ===== HERO CONTACT ===== -->
<section class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-terracotta-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-safari-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float-slow"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 lg:py-24">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold mt-6 mb-8 leading-[1.1]">
                On reste en <span class="gradient-text">contact</span>
            </h1>
            <p class="text-xl text-night-600 max-w-3xl mx-auto">
                Une question, un projet sur-mesure ? Notre équipe est là pour vous répondre sous 24h.
            </p>
        </div>
    </div>
</section>

<!-- ===== CONTACT GRID ===== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16">
            <!-- LEFT: Formulaire -->
            <div>
                <h2 class="text-3xl md:text-4xl font-display font-bold mb-8">
                    Écrivez<span class="gradient-text">-nous</span>
                </h2>
                
                <!-- Messages de statut -->
                @if(session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                        <div>
                            <p class="font-medium text-emerald-900">Message envoyé !</p>
                            <p class="text-sm text-emerald-800">Nous vous répondrons dans les plus brefs délais.</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-rose-600 text-xl"></i>
                        <div>
                            <p class="font-medium text-rose-900 mb-1">Veuillez corriger les erreurs suivantes :</p>
                            <ul class="text-sm text-rose-800 space-y-1">
                                @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="space-y-6" novalidate>
                    @csrf

                    <!-- Anti-spam (inchangé) -->
                    <div class="hidden">
                        <label for="website"></label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <input type="hidden" name="time_start" value="{{ microtime(true) }}">

                    <!-- Nom et Prénom -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="lastname" class="block text-sm font-medium text-night-700 mb-2">
                                Nom <span class="text-terracotta-500">*</span>
                            </label>
                            <input type="text"
                                   id="lastname"
                                   name="lastname"
                                   value="{{ old('lastname') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border-2 border-sand-200 focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-200 transition-all"
                                   placeholder="Votre nom">
                        </div>

                        <div>
                            <label for="firstname" class="block text-sm font-medium text-night-700 mb-2">
                                Prénom
                            </label>
                            <input type="text"
                                   id="firstname"
                                   name="firstname"
                                   value="{{ old('firstname') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-sand-200 focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-200 transition-all"
                                   placeholder="Votre prénom">
                        </div>
                    </div>

                    <!-- Email et Téléphone -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-night-700 mb-2">
                                Email <span class="text-terracotta-500">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border-2 border-sand-200 focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-200 transition-all"
                                   placeholder="votre@email.com">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-night-700 mb-2">
                                Téléphone (WhatsApp)
                            </label>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-sand-200 focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-200 transition-all"
                                   placeholder="+229 00 00 00 00">
                        </div>
                    </div>

                    <!-- Sujet -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-night-700 mb-2">
                            Sujet de votre demande <span class="text-terracotta-500">*</span>
                        </label>
                        <select id="subject"
                                name="subject"
                                required
                                class="w-full px-4 py-3 rounded-xl border-2 border-sand-200 focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-200 transition-all bg-white">
                            <option value="">Choisissez une option</option>
                            <option value="Commande" {{ old('subject') === 'Commande' ? 'selected' : '' }}>
                                Suivi ou question sur une commande
                            </option>
                            <option value="Compte" {{ old('subject') === 'Compte' ? 'selected' : '' }}>
                                Problème de compte ou connexion
                            </option>
                            <option value="Partenariat" {{ old('subject') === 'Partenariat' ? 'selected' : '' }}>
                                Devenir vendeur / partenaire
                            </option>
                            <option value="Autre" {{ old('subject') === 'Autre' ? 'selected' : '' }}>
                                Autre demande
                            </option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-night-700 mb-2">
                            Message <span class="text-terracotta-500">*</span>
                        </label>
                        <textarea id="message"
                                  name="message"
                                  rows="5"
                                  required
                                  class="w-full px-4 py-3 rounded-xl border-2 border-sand-200 focus:border-terracotta-500 focus:ring-2 focus:ring-terracotta-200 transition-all resize-none"
                                  placeholder="Expliquez-nous votre demande...">{{ old('message') }}</textarea>
                    </div>

                    <!-- Consent -->
                    <div class="flex items-start gap-3">
                        <input type="checkbox"
                               id="consent"
                               name="consent"
                               value="1"
                               class="mt-1 h-5 w-5 rounded border-sand-300 text-terracotta-600 focus:ring-terracotta-500">
                        <label for="consent" class="text-night-600 cursor-pointer">
                            J'accepte que mes informations soient utilisées uniquement dans le cadre du traitement de ma demande.
                        </label>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit"
                                id="submitBtn"
                                class="group inline-flex items-center justify-center gap-3 bg-terracotta-500 text-white px-8 py-4 rounded-xl font-semibold hover:bg-terracotta-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                            Envoyer mon message
                        </button>
                        <p class="text-sm text-night-500 mt-3">
                            * Champs obligatoires
                        </p>
                    </div>
                </form>
            </div>
            
            <!-- RIGHT: Coordonnées -->
            <div>
                <h2 class="text-3xl md:text-4xl font-display font-bold mb-8">
                    Nos <span class="gradient-text">coordonnées</span>
                </h2>
                
                <!-- Contact direct -->
                <div class="space-y-6 mb-10">
                    <!-- WhatsApp -->
                    <div class="flex items-start gap-4 p-6 bg-sand-50 rounded-2xl hover:shadow-md transition hover-lift">
                        <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fab fa-whatsapp text-2xl text-terracotta-600"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg mb-1">WhatsApp</h3>
                            <p class="text-night-600 mb-2">Réponse sous 1h en moyenne</p>
                            <a href="https://wa.me/22900000000" class="text-terracotta-500 font-semibold hover:underline">
                                +229 00 00 00 00
                            </a>
                        </div>
                    </div>
                    
                    <!-- Téléphone -->
                    <div class="flex items-start gap-4 p-6 bg-sand-50 rounded-2xl hover:shadow-md transition hover-lift">
                        <div class="w-12 h-12 bg-saffron-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-phone-alt text-2xl text-saffron-600"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg mb-1">Téléphone</h3>
                            <p class="text-night-600 mb-2">Lun - Sam : 8h - 19h</p>
                            <a href="tel:+22900000000" class="text-terracotta-500 font-semibold hover:underline">
                                +229 00 00 00 00
                            </a>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex items-start gap-4 p-6 bg-sand-50 rounded-2xl hover:shadow-md transition hover-lift">
                        <div class="w-12 h-12 bg-safari-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-envelope text-2xl text-safari-600"></i>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg mb-1">Email</h3>
                            <p class="text-night-600 mb-2">Réponse sous 24h</p>
                            <a href="mailto:contact@segnonshop.com" class="text-terracotta-500 font-semibold hover:underline">
                                contact@segnonshop.com
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Adresse & Horaires -->
                <div class="bg-night-900 text-white p-8 rounded-3xl">
                    <h3 class="text-xl font-display font-bold mb-6">Venir nous voir</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-terracotta-500 mt-1"></i>
                            <div>
                                <p class="font-medium">Boutique & Atelier</p>
                                <p class="text-white/70">123 Rue des Artisans, Cotonou</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-terracotta-500 mt-1"></i>
                            <div>
                                <p class="font-medium">Horaires d'ouverture</p>
                                <p class="text-white/70">Lundi - Vendredi : 9h - 18h</p>
                                <p class="text-white/70">Samedi : 9h - 15h</p>
                            </div>
                        </div>
                    </div>
                    
                  
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FAQ RAPIDE ===== -->
<section class="py-16 bg-sand-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-wider">FAQ</span>
            <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                Questions <span class="gradient-text">fréquentes</span>
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition hover-lift">
                <h3 class="font-display font-bold text-lg mb-2">Quels sont les délais de livraison ?</h3>
                <p class="text-night-600">Livraison sous 24h à Cotonou, 48h en province.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition hover-lift">
                <h3 class="font-display font-bold text-lg mb-2">Comment passer commande ?</h3>
                <p class="text-night-600">Par WhatsApp, téléphone ou formulaire de contact.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition hover-lift">
                <h3 class="font-display font-bold text-lg mb-2">Puis-je retourner un article ?</h3>
                <p class="text-night-600">Retour gratuit sous 14 jours, satisfait ou remboursé.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition hover-lift">
                <h3 class="font-display font-bold text-lg mb-2">Proposez-vous du sur-mesure ?</h3>
                <p class="text-night-600">Oui, contactez-nous pour vos dimensions spécifiques.</p>
            </div>
        </div>
        
        <div class="text-center mt-10">
            <a href="#" class="text-terracotta-500 font-semibold hover:underline">Voir toutes les questions →</a>
        </div>
    </div>
</section>

@endsection