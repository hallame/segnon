<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-sand-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-3xl font-['Clash_Display'] font-bold tracking-tight">
                SEGNON<span class="text-terracotta-500">.</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('shop.collections') }}" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                    Collections
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                    <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                </a>
                <a href="{{ route('shop.products.index') }}" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                    Nouveautés
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                    <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                </a>
                <a href="{{ route('shop.promo') }}" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                    Promos
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                    <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                </a>
                <a href="{{ route('about') }}" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                    Notre Histoire
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                    <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                </a>
                <a href="{{ route('contact') }}" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                    Contact
                    <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                    <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                </a>
            </div>

            <!-- Actions Desktop -->
            <div class="hidden lg:flex items-center gap-2">
            
                <a href="{{ route('shop.cart.index') }}" class="p-2 hover:bg-sand-100 rounded-full transition relative">
                    <i class="fas fa-shopping-bag text-night-700"></i>
                    @auth
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-terracotta-500 rounded-full text-white text-[10px] flex items-center justify-center">{{ Cart::count() }}</span>
                    @else
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-terracotta-500 rounded-full text-white text-[10px] flex items-center justify-center">0</span>
                    @endauth
                </a>
                <a href="https://wa.me/2296940510" class="flex items-center gap-2 bg-terracotta-500 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-terracotta-600 transition shadow-lg hover:shadow-xl ml-2">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp
                </a>
            </div>

            <!-- Mobile Menu Button & Icons -->
            <div class="flex lg:hidden items-center gap-1">
                <a href="{{ route('shop.cart.index') }}" class="p-2 hover:bg-sand-100 rounded-full transition relative">
                    <i class="fas fa-shopping-bag text-night-700"></i>
                    @auth
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-terracotta-500 rounded-full text-white text-[10px] flex items-center justify-center">{{ Cart::count() }}</span>
                    @else
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-terracotta-500 rounded-full text-white text-[10px] flex items-center justify-center">0</span>
                    @endauth
                </a>
                <button id="menuToggle" class="p-2 hover:bg-sand-100 rounded-full transition" onclick="toggleMobileMenu()">
                    <i id="menuIcon" class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Panel -->
    <div id="mobileMenu" class="lg:hidden fixed inset-0 bg-white z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <!-- Header mobile menu -->
            <div class="flex items-center justify-between p-4 border-b border-sand-200">
                <a href="{{ route('home') }}" class="text-2xl font-['Clash_Display'] font-bold">
                    SEGNON<span class="text-terracotta-500">.</span>
                </a>
                <button onclick="toggleMobileMenu()" class="p-2 hover:bg-sand-100 rounded-full transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Menu links -->
            <div class="flex-1 overflow-y-auto py-6 px-4">
                <div class="space-y-4">
                    <a href="{{ route('shop.collections') }}" class="block py-3 text-night-700 hover:text-terracotta-500 font-medium text-lg border-b border-sand-100" onclick="toggleMobileMenu()">
                        Collections
                    </a>
                    <a href="{{ route('shop.products.index') }}" class="block py-3 text-night-700 hover:text-terracotta-500 font-medium text-lg border-b border-sand-100" onclick="toggleMobileMenu()">
                        Nouveautés
                    </a>
                    <a href="{{ route('shop.promo') }}" class="block py-3 text-night-700 hover:text-terracotta-500 font-medium text-lg border-b border-sand-100" onclick="toggleMobileMenu()">
                        Promos
                    </a>
                    <a href="{{ route('about') }}" class="block py-3 text-night-700 hover:text-terracotta-500 font-medium text-lg border-b border-sand-100" onclick="toggleMobileMenu()">
                        Notre Histoire
                    </a>
                    <a href="{{ route('contact') }}" class="block py-3 text-night-700 hover:text-terracotta-500 font-medium text-lg border-b border-sand-100" onclick="toggleMobileMenu()">
                        Contact
                    </a>
                </div>

                <!-- WhatsApp Mobile -->
                <div class="mt-8 pt-6 border-t border-sand-200">
                    <a href="https://wa.me/2296940510" class="flex items-center justify-center gap-2 bg-terracotta-500 text-white px-5 py-4 rounded-xl text-base font-semibold hover:bg-terracotta-600 transition" onclick="toggleMobileMenu()">
                        <i class="fab fa-whatsapp text-xl"></i>
                        WhatsApp direct
                    </a>
                </div>
            </div>
        </div>
    </div>

</nav>

<script>
    // Mobile Menu Toggle - Version CORRIGÉE
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        
        if (!menu || !menuIcon) return;
        
        if (menu.classList.contains('translate-x-full')) {
            // Ouvrir le menu
            menu.classList.remove('translate-x-full');
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-times');
            document.body.style.overflow = 'hidden';
        } else {
            // Fermer le menu
            menu.classList.add('translate-x-full');
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
            document.body.style.overflow = 'auto';
        }
    }

    // Fermer le menu avec la touche Echap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const menu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            if (menu && !menu.classList.contains('translate-x-full')) {
                menu.classList.add('translate-x-full');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
                document.body.style.overflow = 'auto';
            }
        }
    });

    // Fermer le menu quand on clique sur un lien
    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Ne pas fermer si c'est un lien externe ou si on veut garder le menu ouvert
            if (this.getAttribute('href').startsWith('http')) return;
            
            const menu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            
            setTimeout(() => {
                if (window.innerWidth < 1024) {
                    menu.classList.add('translate-x-full');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                    document.body.style.overflow = 'auto';
                }
            }, 150); // Petit délai pour laisser le temps à la navigation
        });
    });

    // Gérer le redimensionnement de la fenêtre
    window.addEventListener('resize', function() {
        const menu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        
        if (window.innerWidth >= 1024) {
            // Si on passe en desktop, fermer le menu mobile
            if (menu && !menu.classList.contains('translate-x-full')) {
                menu.classList.add('translate-x-full');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
                document.body.style.overflow = 'auto';
            }
        }
    });

    // Active link highlighting
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('nav a[href]').forEach(link => {
            const linkPath = link.getAttribute('href');
            if (linkPath === currentPath || 
                (currentPath === '/' && linkPath === '{{ route('home') }}')) {
                link.classList.add('text-terracotta-500');
                // Pour les liens avec l'effet de soulignement
                link.classList.add('font-semibold');
            }
        });
    });

    // Navbar scroll effect (optionnel)
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('nav');
        if (window.scrollY > 50) {
            nav.classList.add('shadow-md');
        } else {
            nav.classList.remove('shadow-md');
        }
    });
</script>