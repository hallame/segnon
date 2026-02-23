@extends('frontend.layouts.master')

@section('title', 'Contact • MYLMARK')
@section('meta_title', 'Contactez notre équipe • MYLMARK')
@section('meta_description', 'Contactez l\'équipe MYLMARK pour toute question sur nos services, tarifs, ou support technique.')
@section('meta_image', asset('assets/images/contact-og.png'))

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-white">
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24">
        <!-- Background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-emerald-500/10 blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 rounded-full bg-blue-500/10 blur-3xl"></div>
        </div>

        <div class="relative text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="h-px w-6 bg-gradient-to-r from-transparent to-emerald-400"></div>
                <span class="text-sm uppercase tracking-[0.3em] font-semibold text-emerald-300">SUPPORT</span>
                <div class="h-px w-6 bg-gradient-to-r from-emerald-400 to-transparent"></div>
            </div>

            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                Nous sommes là<br>
                <span class="bg-gradient-to-r from-emerald-400 via-cyan-300 to-blue-400 bg-clip-text text-transparent">
                    pour vous aider
                </span>
            </h1>

            <!-- Description -->
            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-8">
                Une question sur nos services ? Besoin d'aide technique ? Notre équipe vous répond rapidement.
            </p>

            <!-- Stats -->
            <div class="flex flex-wrap justify-center gap-6 text-sm">
                <div class="flex items-center gap-2">
                    <i class="ri-time-line text-emerald-400"></i>
                    <span>Réponse sous 24h</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-shield-check-line text-emerald-400"></i>
                    <span>Support personnalisé</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-user-smile-line text-emerald-400"></i>
                    <span>25+ vendeurs accompagnés</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Options -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Option 1 : Email -->
            <div class="text-center p-8 rounded-2xl border border-slate-200 hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
                <div class="h-16 w-16 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-6">
                    <i class="ri-mail-line text-emerald-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Par email</h3>
                <p class="text-slate-600 mb-4">Pour toutes vos questions générales</p>
                <a href="mailto:contact@mylmark.com"
                   class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium">
                    contact@mylmark.com
                    <i class="ri-external-link-line text-sm"></i>
                </a>
                <p class="text-sm text-slate-500 mt-3">Réponse sous 24h ouvrées</p>
            </div>

            <!-- Option 2 : WhatsApp -->
            <div class="text-center p-8 rounded-2xl border border-slate-200 hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2 bg-gradient-to-b from-white to-slate-50">
                <div class="h-16 w-16 rounded-2xl bg-green-100 flex items-center justify-center mx-auto mb-6">
                    <i class="ri-whatsapp-line text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">WhatsApp</h3>
                <p class="text-slate-600 mb-4">Pour un support rapide et direct</p>
                <a href="https://wa.me/221771234567"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium">
                    +221 77 123 45 67
                    <i class="ri-external-link-line text-sm"></i>
                </a>
                <p class="text-sm text-slate-500 mt-3">Lundi à Vendredi • 9h-18h</p>
            </div>

            <!-- Option 3 : Formulaire -->
            <div class="text-center p-8 rounded-2xl border border-emerald-200 bg-gradient-to-b from-emerald-50/30 to-white">
                <div class="h-16 w-16 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-6">
                    <i class="ri-chat-3-line text-emerald-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Formulaire</h3>
                <p class="text-slate-600 mb-4">Pour les demandes détaillées</p>
                <a href="#contact-form"
                   class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    <i class="ri-edit-line"></i>
                    Remplir le formulaire
                </a>
                <p class="text-sm text-slate-500 mt-3">Traitement prioritaire</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section id="contact-form" class="py-16 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-6 text-white">
                <h2 class="text-2xl font-bold mb-2">Envoyez-nous votre message</h2>
                <p class="text-emerald-100">Nous vous répondrons rapidement</p>
            </div>

            <!-- Form Content -->
            <div class="p-6 md:p-8">
                @if(session('success'))
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

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name & Email -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-900 mb-2">
                                Votre nom *
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                   placeholder="Votre nom complet">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-900 mb-2">
                                Email *
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                   placeholder="votre@email.com">
                        </div>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-slate-900 mb-2">
                            Sujet *
                        </label>
                        <select id="subject"
                                name="subject"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all bg-white">
                            <option value="" disabled selected>Choisir un sujet</option>
                            <option value="support">Support technique</option>
                            <option value="sales">Question commerciale</option>
                            <option value="billing">Facturation & paiement</option>
                            <option value="partnership">Partenariat</option>
                            <option value="other">Autre demande</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-900 mb-2">
                            Votre message *
                        </label>
                        <textarea id="message"
                                  name="message"
                                  rows="6"
                                  required
                                  class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                  placeholder="Décrivez-nous votre demande..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="group w-full md:w-auto inline-flex items-center justify-center gap-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-8 py-4 rounded-lg font-bold hover:shadow-xl hover:shadow-emerald-500/30 transition-all duration-300 hover:scale-105">
                            <i class="ri-send-plane-line text-xl group-hover:translate-x-1 transition-transform"></i>
                            Envoyer le message
                        </button>
                        <p class="text-sm text-slate-500 mt-3">
                            * Champs obligatoires. Nous respectons votre vie privée.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- FAQ Preview -->
        <div class="mt-12 text-center">
            <h3 class="text-xl font-bold text-slate-900 mb-6">Questions fréquentes</h3>
            <div class="grid md:grid-cols-2 gap-4 max-w-2xl mx-auto">
                <a href="/faq#tarifs"
                   class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:border-emerald-300 transition-colors">
                    <span class="text-slate-700">Quels sont les tarifs ?</span>
                    <i class="ri-arrow-right-line text-slate-400"></i>
                </a>
                <a href="/faq#inscription"
                   class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:border-emerald-300 transition-colors">
                    <span class="text-slate-700">Comment m'inscrire ?</span>
                    <i class="ri-arrow-right-line text-slate-400"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-gradient-to-b from-white to-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Notre équipe support</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Des experts dédiés à votre réussite sur MYLMARK
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Support Tech -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="ri-tools-line text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">Support technique</h3>
                        <p class="text-sm text-slate-600">Amina & David</p>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-center gap-2">
                        <i class="ri-check-line text-blue-500"></i>
                        Configuration de votre boutique
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ri-check-line text-blue-500"></i>
                        Problèmes techniques
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ri-check-line text-blue-500"></i>
                        Optimisation de la plateforme
                    </li>
                </ul>
            </div>

            <!-- Support Commercial -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                        <i class="ri-user-voice-line text-emerald-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">Support commercial</h3>
                        <p class="text-sm text-slate-600">Karim & Sophie</p>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-center gap-2">
                        <i class="ri-check-line text-emerald-500"></i>
                        Questions sur les tarifs
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ri-check-line text-emerald-500"></i>
                        Conseils pour vendre plus
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="ri-check-line text-emerald-500"></i>
                        Assistance personnalisée
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="py-16 bg-gradient-to-br from-slate-900 to-slate-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-400/10 border border-emerald-400/20 px-4 py-2 mb-6">
            <i class="ri-flashlight-line text-emerald-400"></i>
            <span class="text-sm font-semibold text-emerald-300">PRÊT À COMMENCER ?</span>
        </div>

        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Testez MYLMARK gratuitement
        </h2>

        <p class="text-lg text-slate-300 mb-8 max-w-xl mx-auto">
            30 jours d'essai complet. Aucune carte bancaire requise.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('partners.register') }}"
               class="group inline-flex items-center justify-center gap-3 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-8 py-4 text-base font-bold shadow-xl hover:shadow-2xl hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300">
                <i class="ri-rocket-2-line text-xl group-hover:rotate-45 transition-transform"></i>
                Démarrer l'essai gratuit
            </a>

            <a href="tel:+221771234567"
               class="group inline-flex items-center justify-center gap-3 rounded-full bg-white/10 text-white px-8 py-4 text-base font-bold hover:bg-white/20 transition-all duration-300 border border-white/20">
                <i class="ri-phone-line text-xl"></i>
                Nous appeler
            </a>
        </div>
    </div>
</section>

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
        // Form validation
        const contactForm = document.querySelector('form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const subject = document.getElementById('subject').value;
                const message = document.getElementById('message').value.trim();

                let isValid = true;

                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                document.querySelectorAll('.border-red-500').forEach(el => {
                    el.classList.remove('border-red-500');
                    el.classList.add('border-slate-300');
                });

                // Validate name
                if (!name) {
                    showError('name', 'Veuillez entrer votre nom');
                    isValid = false;
                }

                // Validate email
                if (!email || !validateEmail(email)) {
                    showError('email', 'Veuillez entrer un email valide');
                    isValid = false;
                }

                // Validate subject
                if (!subject) {
                    showError('subject', 'Veuillez choisir un sujet');
                    isValid = false;
                }

                // Validate message
                if (!message || message.length < 10) {
                    showError('message', 'Veuillez écrire un message d\'au moins 10 caractères');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        }

        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-sm text-rose-600 mt-2';
            errorDiv.textContent = message;

            field.classList.remove('border-slate-300');
            field.classList.add('border-red-500');
            field.parentNode.appendChild(errorDiv);
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Auto-resize textarea
        const textarea = document.getElementById('message');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }

        // Add animation to contact options
        const contactCards = document.querySelectorAll('.hover\\:-translate-y-2');
        contactCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s ease';
            });
        });
    });
</script>
@endsection
