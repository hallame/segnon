@extends('frontend.layouts.master')
@section('title', 'Pièces et articles disponibles')
@section('meta_description', "Parcourez les produits et nouveautés de la marketplace MYLMARK : pièces uniques, séries limitées et objets créatifs pour un style actuel et affirmé")
@section('meta_image', asset('assets/images/catalog.png'))
@section('content')
    @php
        $totalProducts = $products->total();
        $currentCount  = $products->count();
        $query         = request('q');
        $sort          = request('sort');
        $categorySlug  = request('c');
    @endphp

    {{-- HERO PRODUITS --}}
    <section class="relative overflow-hidden bg-slate-950 text-slate-50">
        {{-- Halo & textures --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-32 -top-32 h-72 w-72 rounded-full bg-[radial-gradient(circle_at_center,rgba(34,197,94,0.55),transparent_60%)] opacity-80"></div>
            <div class="absolute right-[-6rem] top-0 h-80 w-60 rotate-12 bg-[linear-gradient(135deg,rgba(248,250,252,0.08)_0%,rgba(248,250,252,0.02)_40%,transparent_100%)]"></div>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-5 pb-5 lg:pt-6 lg:pb-8 relative">

            <div class="grid lg:grid-cols-[minmax(0,1.25fr)_minmax(0,0.95fr)] gap-8 items-start ">
                {{-- Texte principal --}}
                <div class="space-y-5 lg:space-y-6">
                    {{-- <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/50 bg-slate-900/70 px-3.5 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em]">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Catalogue MYLMARK
                    </div> --}}

                    <div class="space-y-3">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-tight">
                            Votre nouveau
                            <span class="bg-gradient-to-r from-amber-300 via-amber-400 to-orange-400 bg-clip-text text-transparent">
                                 repaire
                            </span>
                            pour des achats.
                        </h1>
                        <p class="text-sm text-slate-300 max-w-xl">
                            Une destination unique pour tous vos achats, où diversité et qualité s'allient pour offrir le meilleur choix.
                    </div>

                    <div class="grid grid-cols-2 sm:inline-flex sm:flex-wrap gap-3 text-[11px]">
                        <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1.5 border border-slate-700/80">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-800">
                                <i class="ri-store-3-line text-emerald-300 text-[14px]"></i>
                            </span>
                            <span>Meilleure Sélection</span>
                        </div>
                        {{-- <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1.5 border border-slate-700/80">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-800">
                                <i class="ri-hand-heart-line text-amber-300 text-[14px]"></i>
                            </span>
                            <span>Fait main & authentique</span>
                        </div> --}}
                        <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1.5 border border-slate-700/80">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-800">
                                <i class="ri-earth-line text-emerald-300 text-[14px]"></i>
                            </span>
                            <span>Commandes rapides</span>
                        </div>
                    </div>
                </div>

                {{-- Carte filtres / stats / vue --}}
                <aside class="rounded-3xl bg-slate-900/80 border border-slate-700/70 shadow-[0_22px_60px_rgba(15,23,42,0.6)] p-4 sm:p-5 space-y-4 text-[11px]">
                    {{-- <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-slate-400">Créations disponibles</p>
                            <p class="text-[20px] font-semibold text-emerald-300 leading-none">
                                {{ number_format($totalProducts, 0, ',', ' ') }}
                                <span class="text-[11px] text-slate-400 font-normal">produits</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center justify-end gap-0.5 text-amber-300 text-xs">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-fill"></i>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                Expérience MYLMARK appréciée
                            </p>
                        </div>
                    </div> --}}

                    <div class="h-px bg-gradient-to-r from-transparent via-slate-700/70 to-transparent"></div>

                    {{-- Barre recherche + tri --}}
                    <div class="space-y-3">
                        {{-- Recherche --}}
                        <form action="{{ route('shop.products.index') }}" method="GET" class="w-full">
                            <label for="q" class="sr-only">Rechercher</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-sm">
                                    <i class="ri-search-2-line"></i>
                                </span>
                                <input
                                    type="text"
                                    id="q"
                                    name="q"
                                    value="{{ $query }}"
                                    placeholder="Rechercher un produit..."
                                    class="w-full rounded-full border border-slate-700 bg-slate-900/80 pl-9 pr-3 py-1.5 text-[11px] text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-emerald-400/70 focus:border-emerald-400/70"
                                >
                            </div>

                            @if(request('c'))
                                <input type="hidden" name="c" value="{{ request('c') }}">
                            @endif
                            @if($sort)
                                <input type="hidden" name="sort" value="{{ $sort }}">
                            @endif
                        </form>

                        {{-- Tri + vue --}}
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <form method="GET" action="{{ route('shop.products.index') }}" class="flex items-center gap-2">
                                <label for="sort" class="text-slate-400 hidden sm:inline">Trier par</label>
                                <select
                                    id="sort"
                                    name="sort"
                                    class="rounded-full border border-slate-700 bg-slate-900/80 px-2.5 py-1 text-[11px] text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-400/70 focus:border-emerald-400/70"
                                    onchange="this.form.submit()">
                                    <option value="">Recommandés</option>
                                    <option value="new" @selected($sort === 'new')>Nouveautés</option>
                                    <option value="price_asc" @selected($sort === 'price_asc')>Prix croissant</option>
                                    <option value="price_desc" @selected($sort === 'price_desc')>Prix décroissant</option>
                                </select>

                                @if(request('c'))
                                    <input type="hidden" name="c" value="{{ request('c') }}">
                                @endif
                                @if($query)
                                    <input type="hidden" name="q" value="{{ $query }}">
                                @endif
                            </form>

                            {{-- Boutons vue grid / liste --}}
                            {{-- <div class="inline-flex items-center gap-1 rounded-full bg-slate-900/80 px-1.5 py-0.5 border border-slate-700/80">
                                <!-- Supprime tout ça -->
                            </div> --}}

                            {{-- Par juste un espace vide ou une info --}}
                            <div class="text-[10px] text-slate-400">
                                {{ $currentCount }} produits affichés
                            </div>
                        </div>
                    </div>


                    {{-- Select principal pour toutes les catégories --}}
                    <select
                        id="categorySelect"
                        class="w-full rounded-full border border-slate-700 bg-slate-900/80 px-4 py-2 text-[11px] text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-400/70"
                        onchange="window.location.href = this.value">
                        <option value="{{ route('shop.products.index', array_merge(request()->except(['page','c']), [])) }}">
                            Toutes les catégories
                        </option>
                        @foreach($categories as $cat)
                            <option value="{{ route('shop.products.index', array_merge(request()->except('page'), ['c' => $cat->slug])) }}"
                                    {{ request('c') === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->products_count }})
                            </option>
                        @endforeach
                    </select>

                    {{--  catégories les plus populaires en tags rapides --}}
                    @php $topCat = $categories->take(6); @endphp
                    @if($topCat->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($topCat as $cat)
                                <a href="{{ route('shop.products.index', array_merge(request()->except('page'), ['c' => $cat->slug])) }}"
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full border text-[10px]
                                        {{ request('c') === $cat->slug
                                                ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'
                                                : 'bg-slate-800/50 text-slate-300 border-slate-700 hover:border-emerald-400/50' }}">
                                    <i class="ri-fire-fill text-xs text-amber-400"></i>
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                </aside>
            </div>
        </div>
    </section>


    {{-- LISTE PRODUITS --}}
    <section class="scroll-mt-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 md:py-9">
            @if($products->isEmpty())
                <div class="rounded-3xl border border-dashed border-slate-200 p-10 text-center bg-white shadow-soft">
                    <p class="text-sm text-slate-600">Aucun produit pour le moment.</p>
                    <a href="{{ route('shop.products.index') }}"
                    class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 rounded-2xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                        <i class="ri-refresh-line text-sm"></i>
                        Actualiser
                    </a>
                </div>
            @else
                {{-- Résumé --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5 text-[11px]">
                    <span class="text-slate-600">
                        <span class="font-semibold text-slate-900">{{ number_format($totalProducts, 0, ',', ' ') }}</span>
                        produits trouvés
                        @if($query)
                            • Recherche : <span class="font-medium">"{{ $query }}"</span>
                        @endif
                    </span>
                    <span class="inline-flex items-center gap-1 text-slate-500">
                        <i class="ri-information-line text-xs text-brand-green"></i>
                        {{ $currentCount }} articles affichés
                    </span>
                </div>

                {{-- GRID PRODUITS - 2 par ligne sur mobile --}}
                <div id="productsContainer"
                    class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-5">
                    @foreach($products as $p)
                        @php
                            $minSku = $p->type === 'variable' ? optional($p->skus)->min('price') : null;
                            $price  = $p->type === 'simple' ? $p->price : $minSku;
                            $inStock = $p->type === 'simple'
                                ? $p->stock > 0
                                : optional($p->skus)->sum('stock') > 0;
                        @endphp

                        <article  class="group h-full flex flex-col rounded-xl md:rounded-2xl bg-white shadow-sm md:shadow-card border border-slate-100 overflow-hidden hover:-translate-y-1 hover:shadow-md md:hover:shadow-[0_15px_35px_rgba(15,23,42,0.1)] transition-all duration-300">
                            <a href="{{ route('shop.products.show', $p) }}" class="block">
                                <div class="relative h-36 sm:h-40 md:h-44">
                                    <img
                                        src="{{ $p->featured_image }}"
                                        alt="{{ $p->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>

                                    {{-- Badge stock - optimisé mobile --}}
                                    <span
                                        class="absolute left-1.5 top-1.5 inline-flex items-center gap-0.5 rounded-full px-1.5 py-0.5 md:px-2 md:py-1 text-[9px] md:text-[10px] font-semibold
                                            @if($inStock)
                                                bg-emerald-600/95 text-white
                                            @else
                                                bg-rose-600/95 text-white
                                            @endif">
                                        @if($inStock)
                                            <i class="ri-check-line text-[9px] md:text-[10px]"></i>
                                            <span class="hidden sm:inline">En stock</span>
                                            <span class="sm:hidden">Stock</span>
                                        @else
                                            <i class="ri-close-line text-[9px] md:text-[10px]"></i>
                                            <span class="hidden sm:inline">Rupture</span>
                                            <span class="sm:hidden">Rupt</span>
                                        @endif
                                    </span>

                                    {{-- Badge type variable - simplifié mobile --}}
                                    @if($p->type === 'variable')
                                        <span
                                            class="absolute right-1.5 top-1.5 inline-flex items-center gap-0.5 rounded-full bg-white/95 px-1.5 py-0.5 md:px-2 md:py-1 text-[9px] md:text-[10px] text-slate-800">
                                            <i class="ri-scissors-cut-line text-[9px] md:text-[11px] text-brand-orange"></i>
                                            <span class="hidden sm:inline">Options</span>
                                        </span>
                                    @endif

                                    {{-- Badge promo - optimisé mobile --}}
                                    @if($p->old_price && $p->type === 'simple' && $p->price && $p->old_price > $p->price)
                                        @php
                                            $discount = max(0, round(100 - ($p->price * 100 / $p->old_price)));
                                        @endphp
                                        <span class="absolute left-1.5 bottom-1.5 inline-flex items-center gap-0.5 rounded-full bg-amber-400/95 px-1.5 py-0.5 text-[9px] md:text-[10px] font-semibold text-slate-900">
                                            -{{ $discount }}%
                                        </span>
                                    @endif
                                </div>
                            </a>

                            <div class="p-2.5 md:p-3.5 space-y-1 md:space-y-2 flex flex-col flex-grow">
                                {{-- Titre optimisé mobile --}}
                                <h2 class="text-xs md:text-[13px] font-semibold text-slate-900 line-clamp-2 leading-tight">
                                    {{ $p->name }}
                                </h2>

                                {{-- Description seulement sur desktop --}}
                                <p class="text-slate-500 line-clamp-2 hidden md:block text-[11px]">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($p->description), 80) }}
                                </p>

                                <div class="flex-grow"></div>
                                <div class="flex items-center justify-between gap-1 md:gap-2 pt-1 md:pt-2">
                                    <div class="space-y-0.5">
                                        <div class="text-xs md:text-[13px] font-semibold text-amber-600">
                                            @if($p->type === 'variable')
                                                @if(!is_null($price))
                                                    <div class="text-[9px] md:text-[10px] text-slate-500">
                                                        À partir de
                                                    </div>
                                                    {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                                @else
                                                    <span class="text-[10px] text-slate-400">Prix variable</span>
                                                @endif
                                            @else
                                                @if($p->old_price)
                                                    <div class="text-[9px] md:text-[10px] text-slate-400 line-through">
                                                        {{ number_format($p->old_price, 0, ',', ' ') }} {{ $currency }}
                                                    </div>
                                                @endif
                                                @if(!is_null($price))
                                                    {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Boutons optimisés mobile --}}
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('shop.products.show', $p) }}"
                                        class="inline-flex items-center gap-0.5 md:gap-1 rounded-full bg-slate-900 text-white px-2.5 py-1 md:px-3 md:py-1.5 text-[10px] font-semibold hover:bg-slate-800 min-w-[50px] md:min-w-[60px] justify-center">
                                            <span>Voir</span>
                                            <i class="ri-arrow-right-line text-[10px] hidden md:inline"></i>
                                        </a>

                                        {{-- Bouton ajouter panier seulement sur desktop --}}
                                        @if($p->type === 'simple' && $p->stock > 0)
                                            <form method="POST" action="{{ route('shop.cart.add') }}" class="hidden md:inline-block">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                                <input type="hidden" name="qty" value="1">
                                                <button type="submit"
                                                        aria-label="Ajouter au panier"
                                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-600 px-2.5 py-1.5 text-[10px] font-semibold text-white hover:bg-emerald-700">
                                                    <i class="ri-shopping-cart-2-line text-[11px]"></i>
                                                    <span class="hidden lg:inline">Ajouter</span>
                                                </button>
                                            </form>
                                        @elseif($p->type !== 'simple')
                                            <a href="{{ route('shop.products.show', $p) }}"
                                            class="hidden md:inline-flex items-center gap-1 rounded-full px-2.5 py-1.5 text-[10px] font-semibold text-slate-700 hover:text-slate-900">
                                                <i class="ri-arrow-right-s-line text-[11px]"></i>
                                                Options
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6 md:mt-8 flex justify-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>



    @include('frontend.sections.cta')


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn  = document.getElementById('moreCatsBtn');
            const menu = document.getElementById('moreCatsMenu');

            if (btn && menu) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });

                document.addEventListener('click', () => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>

@endsection


