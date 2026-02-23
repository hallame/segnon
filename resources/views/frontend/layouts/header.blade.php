<!-- HEADER -->
<header id="siteHeader" class="sticky top-0 z-40 border-b border-slate-200/60 bg-white/80 backdrop-blur-md transition-shadow">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="h-14 flex items-center justify-between gap-6">
            <!-- Logo + nav -->
            <div class="flex items-center gap-8">
                {{-- Logo : icône + texte --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-white shadow-sm">
                        <img src="{{ asset('assets/images/logo.png') }}"  alt="MYLMARK"  class="h-10 w-10 object-contain">
                    </div>
                    <div class="leading-tight">
                        <div class="flex items-center gap-2">
                            <span class="text-[20px] font-extrabold tracking-[0.1em] uppercase text-slate-900 group-hover:tracking-[0.3em] transition-all">
                                MYLMARK
                            </span>
                        </div>
                        <div class="text-[11px] uppercase text-slate-600">
                            Marketplace créative
                        </div>
                    </div>
                </a>

                <!-- Desktop Nav -->
                @php
                    $navItems = [
                        ['route' => 'home', 'label' => 'Accueil', 'match' => 'home'],
                        ['route' => 'shop.products.index', 'label' => 'Catalogue', 'match' => 'shop.products.*'],
                        ['route' => 'contact', 'label' => 'Contact', 'match' => 'contact'],
                    ];
                @endphp

                {{-- <nav class="hidden md:flex items-center gap-6 text-[12px] font-medium">
                    @foreach($navItems as $item)
                        @php $active = request()->routeIs($item['match']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="relative pb-0.5 transition-colors
                                  {{ $active ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">
                            <span>{{ $item['label'] }}</span>
                            @if($active)
                                <span class="pointer-events-none absolute left-0 -bottom-0.5 h-[2px] w-full rounded-full bg-brand-green"></span>
                            @endif
                        </a>
                    @endforeach
                </nav> --}}
            </div>


             <form action="{{ route('shop.products.index') }}" method="GET"
                  class="hidden md:flex flex-1 max-w-md items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-[13px] text-slate-600 shadow-sm focus-within:border-brand-green focus-within:ring-1 focus-within:ring-brand-green/30">
                <i class="ri-search-line text-sm text-slate-400"></i>
                <input type="text"
                       name="q"
                       class="w-full bg-transparent border-0 outline-none focus:ring-0 placeholder:text-slate-400 text-[13px]"
                       placeholder="Rechercher un produit...">
            </form>
            <!-- Actions desktop -->
            <div class="hidden md:flex items-center gap-2">

                <a href="{{ route('shop.products.index') }}"
                   class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-brand-green/60 hover:text-brand-green transition">
                    <i class="ri-box-2-line text-[18px]"></i>
                </a>

                <a href="{{ route('shop.cart.index') }}"
                    class="relative inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-brand-green/60 hover:text-brand-green transition">
                    <i class="ri-shopping-cart-2-line text-[18px]"></i>
                    {{-- @if($cartCount > 0)
                        <span class="cart-badge absolute -top-0.5 -right-0.5 text-[11px] px-1.5 py-0.5 rounded-full bg-brand-green text-white font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif --}}
                </a>


                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 rounded-full border border-brand-green/40 bg-white py-2 px-3 text-xs font-semibold text-brand-green shadow-sm hover:border-brand-green hover:bg-brand-green/5 transition">
                    @auth
                        <i class="ri-user-3-fill text-sm"></i>
                        <span>Mon compte</span>
                    @else
                        <i class="ri-user-line text-sm"></i>
                        <span>Se connecter</span>
                    @endauth
                </a>


                @guest
                    <a href="{{ route('partners.register') }}?module=shop"
                    class="inline-flex items-center gap-2 rounded-full bg-brand-green py-2 px-3 text-xs font-semibold text-white shadow-md hover:bg-emerald-700 transition">
                        <i class="ri-store-3-line text-sm"></i>
                        Devenir vendeur
                    </a>
                @else
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-full bg-slate-800 py-2 px-3 text-xs font-semibold text-white shadow-md hover:bg-slate-900 transition">
                            <i class="ri-logout-circle-r-line text-sm"></i>
                            Se déconnecter
                        </button>
                    </form>
                @endguest


            </div>

            <!-- Burger -->
            <button id="burgerBtn"
                    class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white shadow-sm"
                    aria-label="Ouvrir le menu" aria-expanded="false">
                <i id="burgerIcon" class="ri-menu-3-line text-[20px] text-slate-900"></i>
            </button>
        </div>
    </div>

    <!-- Mobile menu (slide-down) -->
    <div id="mobileMenu" class="md:hidden hidden border-t border-slate-200 bg-white/98 backdrop-blur-sm shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 space-y-3 text-xs font-medium text-slate-700">
            <nav class="flex flex-col gap-2">
                <a href="{{ route('home') }}"
                   class="flex items-center justify-between rounded-xl px-3 py-2
                          {{ request()->routeIs('home') ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    <span>Accueil</span>
                </a>
                <a href="{{ route('shop.products.index') }}"
                   class="flex items-center justify-between rounded-xl px-3 py-2
                          {{ request()->routeIs('shop.products.*') ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    <span>Catalogue</span>
                </a>
                <a href="{{ route('contact') }}"
                   class="flex items-center justify-between rounded-xl px-3 py-2
                          {{ request()->routeIs('contact') ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    <span>Contact</span>
                </a>
            </nav>
            <div class="flex flex-wrap gap-2 pt-2">
                <a href="{{ route('login') }}"
                   class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-brand-green/40 bg-white px-3 py-2 text-[11px] font-semibold text-brand-green shadow-sm hover:border-brand-green hover:bg-brand-green/5 transition">
                    @auth
                        <i class="ri-user-3-fill text-sm"></i>
                        <span>Mon compte</span>
                    @else
                        <i class="ri-user-line text-sm"></i>
                        <span>Se connecter</span>
                    @endauth
                </a>


                @guest
                    <a href="{{ route('partners.register') }}?module=shop"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-brand-green px-3 py-2 text-[11px] font-semibold text-white shadow-md hover:bg-emerald-700 transition">
                        <i class="ri-store-3-line text-sm"></i>
                        Devenir vendeur
                    </a>
                @else
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-800 px-3 py-2 text-[11px] font-semibold text-white shadow-md hover:bg-slate-900 transition">
                            <i class="ri-logout-circle-r-line text-sm"></i>
                            Se déconnecter
                        </button>
                    </form>
                @endguest


                {{-- <a href="{{ route('partners.register') }}?module=shop"
                   class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-brand-green px-3 py-2 text-[11px] font-semibold text-white shadow-md hover:bg-emerald-700 transition">
                    <i class="ri-store-3-line text-sm"></i>
                    Devenir vendeur
                </a> --}}
            </div>
        </div>
    </div>
</header>

{{-- NAVIGATION BAS D’ÉCRAN MOBILE (mode app, conservé) --}}
<nav class="md:hidden fixed bottom-0 inset-x-0 z-40 border-t border-slate-200 bg-white/95 backdrop-blur-md">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-stretch justify-between h-14 text-[10px] font-medium">
            {{-- Accueil --}}
            <a href="{{ route('home') }}"
               class="relative flex-1 flex flex-col items-center justify-center gap-0.5
                      {{ request()->routeIs('home') ? 'text-brand-green' : 'text-slate-500' }}">
                <i class="ri-home-5-line text-lg"></i>
                <span>Accueil</span>
                @if(request()->routeIs('home'))
                    <span class="absolute -top-0.5 h-[2px] w-7 rounded-full bg-brand-green/90"></span>
                @endif
            </a>

            {{-- Créations --}}
            <a href="{{ route('shop.products.index') }}"
               class="relative flex-1 flex flex-col items-center justify-center gap-0.5
                      {{ request()->routeIs('shop.products.*') ? 'text-brand-green' : 'text-slate-500' }}">
                <i class="ri-apps-line text-lg"></i>
                <span>Catalogue</span>
                @if(request()->routeIs('shop.products.*'))
                    <span class="absolute -top-0.5 h-[2px] w-7 rounded-full bg-brand-green/90"></span>
                @endif
            </a>

            {{-- Panier --}}
            <a href="{{ route('shop.cart.index') }}"
                class="relative flex-1 flex flex-col items-center justify-center gap-0.5
                        {{ request()->routeIs('shop.cart.*') ? 'text-brand-green' : 'text-slate-500' }}">

                    <div class="relative inline-flex items-center justify-center">
                        <i class="ri-shopping-cart-2-line text-lg"></i>

                        {{-- @if($cartCount > 0)
                            <span class="cart-badge absolute -top-1 -right-2 text-[11px] px-1.5 py-0.5
                                        rounded-full bg-brand-green text-white font-bold leading-none">
                                {{ $cartCount }}
                            </span>
                        @endif --}}
                    </div>

                    <span>Panier</span>

                    @if(request()->routeIs('shop.cart.*'))
                        <span class="absolute -top-0.5 h-[2px] w-7 rounded-full bg-brand-green/90"></span>
                    @endif
            </a>


            {{-- Compte / Connexion --}}
            <a href="{{ route('login') }}"
               class="relative flex-1 flex flex-col items-center justify-center gap-0.5
                      {{ request()->routeIs('login') ? 'text-brand-green' : 'text-slate-500' }}">

                @auth
                    <i class="ri-user-3-fill text-lg"></i>
                    <span>Mon Compte</span>
                @else
                    <i class="ri-user-line text-lg"></i>
                    <span>Compte</span>
                @endauth

                @if(request()->routeIs('login'))
                    <span class="absolute -top-0.5 h-[2px] w-7 rounded-full bg-brand-green/90"></span>
                @endif
            </a>
        </div>
    </div>
</nav>

{{-- JS pour burger + ombre au scroll --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const header     = document.getElementById('siteHeader');
        const burgerBtn  = document.getElementById('burgerBtn');
        const burgerIcon = document.getElementById('burgerIcon');
        const mobileMenu = document.getElementById('mobileMenu');

        // Ombre au scroll
        if (header) {
            const onScroll = () => {
                if (window.scrollY > 0) header.classList.add('shadow-md');
                else header.classList.remove('shadow-md');
            };
            onScroll();
            window.addEventListener('scroll', onScroll);
        }

        // Burger toggle
        if (burgerBtn && mobileMenu && burgerIcon) {
            burgerBtn.addEventListener('click', () => {
                const willOpen = mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden', !willOpen);
                burgerBtn.setAttribute('aria-expanded', String(willOpen));

                // icône menu <-> close
                if (willOpen) {
                    burgerIcon.classList.remove('ri-menu-line');
                    burgerIcon.classList.add('ri-close-line');
                } else {
                    burgerIcon.classList.remove('ri-close-line');
                    burgerIcon.classList.add('ri-menu-line');
                }
            });
        }
    });
</script>


