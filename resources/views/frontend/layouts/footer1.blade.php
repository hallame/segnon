<!-- FOOTER -->
  <footer id="contact" class="mt-auto bg-slate-900 text-slate-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 md:py-7">
      <div class="grid gap-6 md:grid-cols-3 text-[11px]">
        <div>
          <h3 class="text-[18px] font-extrabold tracking-[0.1em] uppercase group-hover:tracking-[0.3em] transition-all mb-2">
            <a href="{{ route('home') }}">MYLMARK</a>
          </h3>
          <p class="text-slate-300">
            Marketplace nouvelle génération pour vendeurs, artisans & créateurs. On rend vos produits visibles, vos ventes fluides et vos clients accessibles partout, sans complication.
          </p>
        </div>
        <div>





            <h3 class="text-[12px] font-semibold mb-2">Liens utiles</h3>
            <ul class="space-y-1 text-slate-300">
                <li>
                    <a href="{{ route('contact') }}" class="hover:text-white transition">
                        Nous contacter
                    </a>
                </li>
                <li>
                    <a href="{{ route('partners.register') }}?module=shop" class="hover:text-white transition">
                        Ouvrir ma boutique
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales.guide') }}" class="hover:text-white transition">
                        <span class="inline-flex items-center gap-1">
                            {{-- <i class="ri-rocket-line text-xs"></i> --}}
                            Boostez vos ventes
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('shop.pricing') }}" class="hover:text-white transition">
                        Tarifs vendeurs
                    </a>
                </li>

            </ul>

        </div>
        <div>
          <h3 class="text-[12px] font-semibold mb-2">Réseaux & contact</h3>
          <p class="text-slate-300">
            Une question, un projet ou une collaboration ?<br>
            Écrivez-nous : <span class="font-semibold">contact@mylmark.com</span>
          </p>



          <div class="flex items-center gap-2 mt-3">
            <a href="https://www.facebook.com/mylmark1"
            class="h-7 w-7 flex items-center justify-center rounded-full bg-slate-800 text-slate-100
                    hover:bg-slate-700 hover:scale-105 hover:-translate-y-[1px]
                    transition-transform transition-colors duration-150 ease-out"
            aria-label="Page Facebook MYLMARK">
                <i class="ri-facebook-fill text-sm"></i>
            </a>

            <a href="mailto:contact@mylmark.com"
            class="h-7 w-7 flex items-center justify-center rounded-full bg-slate-800 text-slate-100
                    hover:bg-slate-700 hover:scale-105 hover:-translate-y-[1px]
                    transition-transform transition-colors duration-150 ease-out"
            aria-label="Contacter MYLMARK par email">
                <i class="ri-mail-line text-sm"></i>
            </a>
        </div>



        </div>
      </div>
        <div
            class="mt-5 pt-3 px-2 border-t border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-[10px] text-slate-500">
            <span>© <span id="yearSpan"></span> MYLMARK. Tous droits réservés.</span>
            <span>Les produits d’ici, les commandes de partout.</span>
        </div>

    </div>
  </footer>
