<!-- ===== FOOTER ===== -->
<footer class="bg-night-800 text-white/70 mt-8 md:mt-10">
    <!-- Conteneur interne pour le contenu centré -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-white/10">
            <!-- About -->
            <div>
                <div class="text-2xl font-['Clash_Display'] font-bold text-white mb-6">
                    SEGNON<span class="text-terracotta-500">SHOP</span>
                </div>
                <p class="text-white/60 text-sm leading-relaxed mb-6">
                    Votre boutique premium de rideaux, draps, quincaillerie et décoration. L'élégance africaine réinventée.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
            
            <!-- Links -->
            <div>
                <h4 class="text-white font-bold mb-6">Liens rapides</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Collections</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Nouveautés</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Promotions</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Contact</a></li>
                </ul>
            </div>
            
            <!-- Categories -->
            <div>
                <h4 class="text-white font-bold mb-6">Catégories</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Rideaux</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Draps</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Quincaillerie</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Décoration</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="text-white font-bold mb-6">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1"></i>
                        <span>Cotonou, Bénin</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-phone-alt mt-1"></i>
                        <span>+229 00 00 00 00</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-envelope mt-1"></i>
                        <span>contact@segnonshop.com</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-clock mt-1"></i>
                        <span>Lun - Sam : 8h - 19h</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 text-sm">
        <div>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</div>
        <div class="flex gap-6">
            <a href="#" class="hover:text-white transition">Mentions légales</a>
            <a href="#" class="hover:text-white transition">Confidentialité</a>
            <a href="#" class="hover:text-white transition">CGV</a>
        </div>
    </div>
    </div>
    
    
</footer>