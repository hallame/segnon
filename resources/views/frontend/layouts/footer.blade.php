<footer id="contact" class="mt-auto bg-slate-900 text-slate-100 pt-10 sm:pt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Contenu principal avec espacement -->
        <div class="grid lg:grid-cols-4 gap-10 pb-10">
            <!-- Colonne 1: Brand (à gauche) -->
            <div class="lg:col-span-1">
                <div class="space-y-4">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="inline-block group">
                        <h2 class="text-2xl font-bold tracking-tight text-white">
                            MYLMARK<span class="text-emerald-400 pl-1">.</span>
                        </h2>
                    </a>

                    <!-- Texte descriptif -->
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Plus qu'une marketplace : un partenaire pour développer votre activité.
                    </p>

                </div>
            </div>

            <!-- 3 Colonnes à droite avec marge pour le chat -->
            <div class="lg:col-span-3 grid sm:grid-cols-3 gap-8 lg:pr-16 xl:pr-24">
                <!-- Colonne 1: Explorer -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">
                        Explorer
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('partners.register') }}?module=shop"
                               class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">Ouvrir ma boutique</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('shop.pricing') }}"
                               class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">Tarifs & abonnements</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.products.index') }}"
                                class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">Explorer les produits</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Colonne 2: Ressources -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">
                        Ressources
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('contact') }}"
                               class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">Nous contacter</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sales.guide') }}"
                               class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">Booster ses ventes</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('about') }}"
                            class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">À propos</span>
                            </a>
                        </li>

                    </ul>
                </div>

                <!-- Colonne 3: Contacts -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">
                        Informations
                    </h3>
                    <ul class="space-y-3">

                        <li>
                            <a href="{{ route('terms') }}"
                               class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">Conditions d'utilisation</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('policy') }}"
                               class="group flex items-center gap-2 text-slate-300 hover:text-white transition-colors duration-200">
                                <span class="text-sm">Politique de confidentialité</span>
                            </a>
                        </li>


                    </ul>

                    <!-- Réseaux sociaux -->
                    <div class="">
                        {{-- <p class="text-xs text-slate-400 mb-3">Suivez-nous</p> --}}
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/mylmark1"
                               class="h-8 w-8 flex items-center justify-center rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-emerald-600 transition-all duration-200">
                                <i class="ri-facebook-fill text-sm"></i>
                            </a>

                            <a href="{{ route('contact') }}"
                               class="h-8 w-8 flex items-center justify-center rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-blue-500 transition-all duration-200">
                                <i class="ri-mail-fill text-sm"></i>
                            </a>

                            {{-- <a href="#"
                               class="h-8 w-8 flex items-center justify-center rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-blue-500 transition-all duration-200">
                                <i class="ri-linkedin-fill text-sm"></i>
                            </a>
                            <a href="#"
                               class="h-8 w-8 flex items-center justify-center rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-pink-500 transition-all duration-200">
                                <i class="ri-instagram-line text-sm"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ligne de séparation -->
        <div class="h-px bg-gradient-to-r from-transparent via-slate-700 to-transparent"></div>

        <!-- Bas du footer - Version responsive avec marge -->
        <div class="py-6 border-t border-slate-800 lg:pr-5">
            <!-- Version desktop -->
            <div class="hidden md:flex flex-row justify-between items-center gap-4">
                <!-- Copyright à gauche -->
                <div class="text-xs text-slate-400">
                    © {{ date('Y') }} MYLMARK. Tous droits réservés.
                </div>

                <!-- Mentions légales à droite -->
                <div class="flex items-center gap-4 text-xs text-slate-400">
                    {{-- <a href="#" class="hover:text-slate-300 transition-colors">Mentions légales</a>
                    <span class="text-slate-600">•</span> --}}
                    <a href="{{ route('terms') }}" class="hover:text-slate-300 transition-colors">Conditions Générales d'Utilisation</a>
                    {{-- <span class="text-slate-600">•</span>
                    <a href="#" class="hover:text-slate-300 transition-colors">Confidentialité</a> --}}
                </div>
            </div>

            <!-- Version mobile -->
            <div class="md:hidden pb-10 flex flex-col items-center gap-4 text-center">

                <!-- Copyright -->
                <div class="text-xs text-slate-400">
                    © {{ date('Y') }} MYLMARK. Tous droits réservés.
                </div>
            </div>
        </div>

    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const yearElements = document.querySelectorAll('[data-year]');
        const currentYear = new Date().getFullYear();
        yearElements.forEach(el => {
            el.textContent = currentYear;
        });
    });
</script>
