@extends('frontend.layouts.master')

@section('title', 'Contact • MYLMARK')
@section('meta_title', 'Contactez-nous • MYLMARK')
@section('meta_description', "Une question, une demande de partenariat ou besoin d'aide ? Contactez l'équipe MYLMARK.")
@section('meta_image', asset('assets/images/contact.jpg'))
@section('meta_url', route('contact'))

@section('content')

<div class="min-h-[70vh] bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="h-1 w-6 bg-gradient-to-r from-transparent to-emerald-500"></div>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">
                    CONTACT & SUPPORT
                </span>
                <div class="h-1 w-6 bg-gradient-to-r from-emerald-500 to-transparent"></div>
            </div>

            <!-- Main Title -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                Nous sommes là
                <span class="block text-emerald-600">pour vous aider</span>
            </h1>

            <!-- Description -->
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Une question sur nos services ? Besoin d'assistance ? Notre équipe vous répond rapidement.
            </p>

            <!-- Stats -->
            <div class="flex flex-wrap justify-center gap-6 mt-6">
                <div class="flex items-center gap-2 text-sm text-slate-700">
                    <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span>Réponse sous 24h</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-700">
                    <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span>Support personnalisé</span>
                </div>

            </div>
        </div>

        <!-- Contact Options -->
        <div class="grid md:grid-cols-2 gap-6 mb-12 max-w-5xl mx-auto">
            <!-- Email -->
            <div class="text-center p-6 rounded-2xl bg-white border border-slate-200 hover:border-emerald-300 transition-all duration-300">
                <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                    <i class="ri-mail-line text-emerald-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Par email</h3>
                <p class="text-sm text-slate-600 mb-3">Pour toutes vos questions</p>
                <a href="mailto:contact@mylmark.com" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                    contact@mylmark.com
                </a>
            </div>
            <!-- Formulaire -->
            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-200">
                <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                    <i class="ri-chat-3-line text-emerald-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Formulaire</h3>
                <p class="text-sm text-slate-600 mb-3">Pour les demandes détaillées</p>
                <a href="#contact-form" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                    <span>Remplir le formulaire</span>
                    <i class="ri-arrow-down-line"></i>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <!-- Left Column: Form -->
            <div id="contact-form">
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <!-- Form Header -->
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-6 text-white">
                        <h2 class="text-xl font-bold mb-2">Envoyez-nous votre message</h2>
                        <p class="text-emerald-100 text-sm">Nous vous répondrons rapidement</p>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6 md:p-8">
                        @if(session('status'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-line text-emerald-600 text-xl"></i>
                                <div>
                                    <p class="font-medium text-emerald-900">Message envoyé !</p>
                                    <p class="text-sm text-emerald-800">Nous vous répondrons dans les plus brefs délais.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="ri-alert-line text-rose-600 text-xl"></i>
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

                            <!-- Anti-spam -->
                            <div class="hidden">
                                <label for="website"></label>
                                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                            </div>
                            <input type="hidden" name="time_start" value="{{ microtime(true) }}">

                            <!-- Name -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="lastname" class="block text-sm font-medium text-slate-900 mb-2">
                                        Nom <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text"
                                           id="lastname"
                                           name="lastname"
                                           value="{{ old('lastname') }}"
                                           required
                                           class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                           placeholder="Votre nom">
                                </div>

                                <div>
                                    <label for="firstname" class="block text-sm font-medium text-slate-900 mb-2">
                                        Prénom
                                    </label>
                                    <input type="text"
                                           id="firstname"
                                           name="firstname"
                                           value="{{ old('firstname') }}"
                                           class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                           placeholder="Votre prénom">
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-900 mb-2">
                                        Email <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                           placeholder="votre@email.com">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-slate-900 mb-2">
                                        Téléphone (WhatsApp)
                                    </label>
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                           placeholder="Votre numéro">
                                </div>
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-slate-900 mb-2">
                                    Sujet de votre demande <span class="text-rose-500">*</span>
                                </label>
                                <select id="subject"
                                        name="subject"
                                        required
                                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all bg-white">
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
                                <label for="message" class="block text-sm font-medium text-slate-900 mb-2">
                                    Message <span class="text-rose-500">*</span>
                                </label>
                                <textarea id="message"
                                          name="message"
                                          rows="5"
                                          required
                                          class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                          placeholder="Expliquez-nous votre demande...">{{ old('message') }}</textarea>
                            </div>

                            <!-- Consent -->
                            <div class="flex items-start gap-3">
                                <input type="checkbox"
                                       id="consent"
                                       name="consent"
                                       value="1"
                                       class="mt-1 h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                <label for="consent" class=" text-slate-700 cursor-pointer">
                                    J'accepte que mes informations soient utilisées uniquement dans le cadre du traitement de ma demande.
                                </label>
                            </div>

                            <!-- Submit -->
                            <div>
                                <button type="submit"
                                        id="submitBtn"
                                        class="group w-full md:w-auto inline-flex items-center justify-center gap-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-lg font-bold hover:shadow-xl hover:shadow-emerald-500/30 transition-all duration-300 hover:scale-105">
                                    <i class="ri-send-plane-line text-xl group-hover:translate-x-1 transition-transform"></i>
                                    Envoyer mon message
                                </button>
                                <p class="text-sm text-slate-500 mt-3">
                                    * Champs obligatoires
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: FAQ & Info -->
            <div class="space-y-6">
                <!-- Demandes fréquentes -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ri-question-answer-line text-emerald-600"></i>
                        Questions fréquentes
                    </h3>
                    <div class="space-y-4">
                        <div class="p-4 rounded-xl bg-slate-50">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-6 w-6 rounded-lg bg-emerald-100 flex items-center justify-center">
                                    <span class="text-xs font-bold text-emerald-700">1</span>
                                </div>
                                <h4 class="font-semibold text-slate-900">Suivi de commande</h4>
                            </div>
                            <p class="text-sm text-slate-600">
                                Numéro de suivi, délai, modification d'adresse...
                            </p>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-6 w-6 rounded-lg bg-emerald-100 flex items-center justify-center">
                                    <span class="text-xs font-bold text-emerald-700">2</span>
                                </div>
                                <h4 class="font-semibold text-slate-900">Problème de compte</h4>
                            </div>
                            <p class="text-sm text-slate-600">
                                Mot de passe oublié, accès, fiches produits, etc.
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-6 w-6 rounded-lg bg-emerald-100 flex items-center justify-center">
                                    <span class="text-xs font-bold text-emerald-700">3</span>
                                </div>
                                <h4 class="font-semibold text-slate-900">Devenir vendeur</h4>
                            </div>
                            <p class="text-sm text-slate-600">
                                Informations sur les conditions pour vendre sur MYLMARK.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Solutions rapides -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ri-lightbulb-flash-line text-emerald-600"></i>
                        Solutions rapides
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('password.request') }}"
                           class="group flex items-center justify-between p-3 rounded-lg bg-slate-50 hover:bg-emerald-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center group-hover:border-emerald-200">
                                    <i class="ri-lock-line text-slate-600 group-hover:text-emerald-600"></i>
                                </div>
                                <span class="font-medium text-slate-900">Réinitialiser mon mot de passe</span>
                            </div>
                            <i class="ri-arrow-right-line text-slate-400 group-hover:text-emerald-600"></i>
                        </a>
                    </div>
                </div>

                <!-- Team Support -->
                <div class="bg-gradient-to-r from-emerald-50 to-blue-50 rounded-2xl p-6 border border-emerald-100">
                    <h3 class="font-bold text-slate-900 mb-4">Notre équipe support</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="bg-white/80 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="ri-tools-line text-blue-600"></i>
                                </div>
                                <h4 class="font-semibold text-slate-900">Support technique</h4>
                            </div>
                        </div>
                        <div class="bg-white/80 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-8 w-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                    <i class="ri-user-voice-line text-emerald-600"></i>
                                </div>
                                <h4 class="font-semibold text-slate-900">Support commercial</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Form input focus styles */
    input:focus, textarea:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .grid-cols-2, .grid-cols-3 {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-resize textarea
        const textarea = document.getElementById('message');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }

        // Prevent double form submission
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> Envoi en cours...';
            });
        }
    });
</script>
@endsection
