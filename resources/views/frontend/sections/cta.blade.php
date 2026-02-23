 <!-- CTA VENDEUR -->
    <section id="cta-vendeur" class="scroll-mt-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-8 md:pb-10">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-green via-emerald-800 to-slate-900 text-slate-50 shadow-soft p-5 md:p-7 ">
          <div class="pointer-events-none absolute inset-y-0 right-0 w-40 opacity-40 bg-[radial-gradient(circle_at_0_0,#f97316,transparent_60%)]"></div>
          <div class="grid md:grid-cols-[minmax(0,1.3fr)_minmax(0,0.9fr)] gap-6 items-center relative z-10">
            <div class="space-y-3">
              <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-emerald-100">
                Vendeurs & ateliers
              </p>
              <h2 class="text-lg md:text-xl font-semibold">
                Vous êtes vendeur ou artisan ? Ouvrez votre boutique.
              </h2>
              <p class="text-[11px] md:text-xs text-emerald-100/90 max-w-xl">
                Présentez vos produits au-delà de votre ville, sans perdre votre identité. MYLMARK vous offre un espace
                dédié, une gestion simplifiée et un accompagnement humain.
              </p>
              <ul class="space-y-1.5 text-[11px] text-emerald-50/90">
                <li class="flex gap-2">
                  <i class="ri-check-line mt-[2px] text-emerald-200"></i>
                  <span>Boutique personnalisée avec vos collections, vos textes et vos photos.</span>
                </li>
                <li class="flex gap-2">
                  <i class="ri-check-line mt-[2px] text-emerald-200"></i>
                  <span>Vous gardez votre style, vos tarifs et votre identité.</span>
                </li>
                <li class="flex gap-2">
                  <i class="ri-check-line mt-[2px] text-emerald-200"></i>
                  <span>Tableau de bord pour suivre vos ventes, vos clients et vos livraisons.</span>
                </li>
              </ul>
            </div>
            <div class="space-y-3 md:text-right text-left text-[11px]">
              <div
                class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-[10px] font-medium text-emerald-50">
                <i class="ri-store-3-line text-xs"></i>
                Inscription en quelques minutes
              </div>
              <div>
                <a href="{{ route('partners.register') }}?module=shop"
                class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-5 py-2.5 text-xs font-semibold text-slate-900 shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                  <i class="ri-store-fill text-sm"></i>
                  Devenir vendeur
              </a>
              </div>
              <p class="text-emerald-100/90">
                Nous sélectionnons des vendeurs engagés, prêts à livrer une expérience de qualité à leurs clients.
                <br>Vous gardez la propriété de vos créations, nous renforçons leur visibilité.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
