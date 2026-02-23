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
                            • Recherche : <span class="font-medium">“{{ $query }}”</span>
                        @else
                            • Filtre : <span class="font-medium">Tous les univers</span>
                        @endif
                    </span>
                    <span class="inline-flex items-center gap-1 text-slate-500">
                        <i class="ri-information-line text-xs text-brand-green"></i>
                        {{ $currentCount }} articles affichés sur cette page.
                    </span>
                </div>

                {{-- GRID / LISTE PRODUITS --}}
                <div id="productsContainer"
                     class="grid gap-4 sm:gap-5 md:grid-cols-2 lg:grid-cols-3 ">
                    @foreach($products as $p)
                        @php
                            $minSku = $p->type === 'variable' ? optional($p->skus)->min('price') : null;
                            $price  = $p->type === 'simple' ? $p->price : $minSku;

                            $inStock = $p->type === 'simple'
                                ? $p->stock > 0
                                : optional($p->skus)->sum('stock') > 0;
                        @endphp

                        <article
                            class="group flex flex-col rounded-2xl bg-white/90 shadow-card border border-slate-100/80 overflow-hidden hover:-translate-y-1.5 hover:shadow-[0_20px_45px_rgba(15,23,42,0.13)] transition">
                            <a href="{{ route('shop.products.show', $p) }}" class="block">
                                <div class="relative h-44">
                                    <img
                                        src="{{ $p->featured_image }}"
                                        alt="{{ $p->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/5 to-transparent"></div>

                                    {{-- Badge stock --}}
                                    <span
                                        class="absolute left-2 top-2 inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-semibold
                                            @if($inStock)
                                                bg-emerald-600/95 text-emerald-50
                                            @else
                                                bg-rose-600/95 text-rose-50
                                            @endif">
                                        @if($inStock)
                                            <i class="ri-check-line text-[11px]"></i>
                                            En stock
                                        @else
                                            <i class="ri-close-line text-[11px]"></i>
                                            Rupture
                                        @endif
                                    </span>

                                    {{-- Badge type variable --}}
                                    @if($p->type === 'variable')
                                        <span
                                            class="absolute right-2 top-2 inline-flex items-center gap-1 rounded-full bg-white/95 px-2 py-1 text-[10px] text-slate-800">
                                            <i class="ri-scissors-cut-line text-[11px] text-brand-orange"></i>
                                            Options disponibles
                                        </span>
                                    @endif

                                    @if($p->old_price && $p->type === 'simple' && $p->price && $p->old_price > $p->price)
                                        @php
                                            $discount = max(0, round(100 - ($p->price * 100 / $p->old_price)));
                                        @endphp
                                        <span class="absolute left-2 bottom-2 inline-flex items-center gap-1 rounded-full bg-amber-400/95 px-2 py-0.5 text-[10px] font-semibold text-slate-900">
                                            -{{ $discount }}%
                                        </span>
                                    @endif
                                </div>
                            </a>

                            <div class="p-3.5 space-y-2 text-[11px]">
                                <h2 class="text-[13px] font-semibold text-slate-900 line-clamp-2">
                                    {{ $p->name }}
                                </h2>

                                <p class="text-slate-500 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($p->description), 100) }}
                                </p>

                                <div class="flex items-center justify-between gap-2 pt-1">
                                    <div class="space-y-0.5">
                                        <div class="text-[13px] font-semibold text-amber-500">
                                            @if($p->type === 'variable')
                                                @if(!is_null($price))
                                                    À partir de {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                                @else
                                                    Prix variable
                                                @endif
                                            @else
                                                @if($p->old_price)
                                                    <div class="text-[10px] text-slate-400">
                                                        <s>{{ number_format($p->old_price, 0, ',', ' ') }} {{ $currency }}</s>
                                                    </div>
                                                @endif
                                                @if(!is_null($price))
                                                    {{ number_format($price, 0, ',', ' ') }} {{ $currency }}
                                                @endif
                                            @endif
                                        </div>
                                        {{-- <div class="flex items-center gap-1 text-[10px] text-slate-400">
                                            <i class="ri-shield-check-line text-[11px] text-brand-green"></i>
                                            <span>Achat sécurisé</span>
                                        </div> --}}
                                    </div>

                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('shop.products.show', $p) }}"
                                           class="inline-flex items-center gap-1 rounded-full bg-slate-900 text-slate-50 px-3 py-1.5 text-[10px] font-semibold group-hover:bg-slate-800">
                                            Voir
                                            <i class="ri-arrow-right-line text-[11px]"></i>
                                        </a>

                                        @if($p->type === 'simple' && $p->stock > 0)
                                            <form method="POST" action="{{ route('shop.cart.add') }}" class="hidden sm:inline-block">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                                <input type="hidden" name="qty" id="qty-{{ $p->id }}" value="1">
                                                <button type="submit"
                                                        aria-label="Ajouter {{ $p->name }} au panier"
                                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-600 px-3 py-1.5 text-[10px] font-semibold text-white hover:bg-emerald-700">
                                                    <i class="ri-shopping-cart-2-line text-[11px]"></i>
                                                    Ajouter
                                                </button>
                                            </form>
                                        @elseif($p->type !== 'simple')
                                            <a href="{{ route('shop.products.show', $p) }}"
                                               class="hidden sm:inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-[10px] font-semibold text-slate-700 hover:text-slate-900">
                                                Choisir options
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6 flex justify-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>
