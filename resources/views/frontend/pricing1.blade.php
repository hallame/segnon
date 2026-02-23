@extends('frontend.layouts.master')

@section('title', 'Abonnements vendeurs • MYLMARK')
@section('meta_title', 'Abonnements vendeurs MYLMARK')
@section('meta_description', "Deux formules simples pour vendre sur MYLMARK : Standard pour bien démarrer, Premium pour accélérer avec plus de visibilité.")
@section('meta_image', asset('assets/images/pricing2.png'))

@section('content')
<section class="bg-slate-950 text-slate-50">
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-10 pb-14">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-32 -left-10 h-56 w-56 rounded-full bg-emerald-500/18 blur-3xl"></div>
            <div class="absolute -bottom-40 right-0 h-72 w-72 rounded-full bg-orange-500/14 blur-3xl"></div>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent"></div>
        </div>

        <div class="relative text-center max-w-3xl mx-auto">
            <p class="inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.24em] text-emerald-100 mb-3">
                <span class="h-px w-8 bg-emerald-400/80"></span>
                Offres
                <span class="h-px w-8 bg-emerald-400/80"></span>
            </p>

            <h1 class="text-[24px] sm:text-[30px] font-semibold leading-tight text-white">
                Choisissez l’Offre qui colle à votre réalité.
            </h1>

            <p class="mt-3 text-[13px] text-slate-200/90">
                Des tarifs pensés pour les vendeurs : démarrer sans pression,
                puis monter en puissance quand vos ventes suivent.
            </p>
        </div>
    </div>
</section>

<section class="bg-slate-50 -mt-8 pb-5">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="relative overflow-hidden rounded-3xl border border-emerald-100 bg-white shadow-soft">
            <div class="absolute inset-y-0 right-0 w-40 pointer-events-none hidden sm:block">
                <div class="h-full w-full opacity-80"
                     style="background: radial-gradient(circle at 0% 0%, rgba(16,185,129,0.18), transparent 60%),
                                      radial-gradient(circle at 100% 100%, rgba(248,171,56,0.18), transparent 55%);">
                </div>
            </div>

            <div class="relative flex flex-col sm:flex-row gap-4 sm:gap-6 items-start sm:items-center px-4 py-4 sm:px-6 sm:py-5">
                {{-- Badge / titre --}}
                <div class="flex-1 space-y-2">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        <span class="text-[11px] font-semibold uppercase tracking-[0.22em] text-emerald-700">
                            Offre spéciale
                        </span>
                    </div>

                    <h2 class="text-[18px] sm:text-[20px] font-semibold text-slate-900 leading-snug">
                        1 mois d’abonnement <span class="text-emerald-600">offert</span> après votre inscription.
                    </h2>

                    <p class="text-[12px] sm:text-[13px] text-slate-600 max-w-xl">
                        Ouvrez votre boutique, ajoutez vos produits et testez MYLMARK en conditions réelles.
                    </p>
                </div>

                {{-- Bloc droite (CTA + petit rappel) --}}
                <div class="w-full sm:w-auto flex flex-col gap-2 sm:items-end">
                    <a href="{{ route('partners.register') }}?module=shop"
                       class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-[12px] font-semibold text-white shadow-md hover:bg-emerald-700 hover:shadow-lg transition w-full sm:w-auto">
                        <i class="ri-store-3-line text-sm"></i>
                        Ouvrir ma boutique
                    </a>
                    <p class="text-[11px] text-slate-500 sm:text-right">
                        Aucun engagement : vous pouvez arrêter avant la fin du mois d’essai.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="bg-slate-50 py-5 sm:py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        {{-- Toggle mensuel / annuel --}}
        <div class="flex flex-col items-center gap-2 mb-8">
            <div id="billingToggle"
                 class="inline-flex items-center rounded-full border border-slate-200 bg-white p-1 text-[11px]">
                <button type="button"
                        data-billing="monthly"
                        class="px-4 py-1.5 rounded-full font-semibold bg-slate-900 text-slate-50 shadow-sm">
                    Mensuel
                </button>
                <button type="button"
                        data-billing="annual"
                        class="px-4 py-1.5 rounded-full font-semibold text-slate-600">
                    Annuel <span class="ml-1 text-emerald-600 font-semibold">≈ 2 mois offerts</span>
                </button>
            </div>
            {{-- <p class="text-[11px] text-slate-500 text-center max-w-md">
                Changez juste l’option ci-dessus : les prix s’adaptent automatiquement entre mensualité
                et facturation annuelle.
            </p> --}}
        </div>

        {{-- Grille responsive --}}
        <div class="grid gap-6 md:grid-cols-2 items-stretch">
            {{-- STANDARD (le plus populaire) --}}
            <article class="relative flex flex-col rounded-3xl bg-white border border-emerald-500/50 shadow-[0_18px_55px_rgba(15,23,42,0.18)] overflow-hidden">
                {{-- Badge le plus populaire --}}
                <div class="absolute top-2 right-4 inline-flex items-center gap-1 rounded-full bg-emerald-600 text-[10px] font-semibold uppercase tracking-[0.16em] text-white px-3 py-1 shadow-sm">
                    <i class="ri-fire-line text-xs"></i>
                    Populaire
                </div>

                <div class="px-5 pt-6 pb-3 border-b border-emerald-100 bg-emerald-50/70">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700">
                        Standard
                    </p>
                    <h2 class="mt-1 text-[18px] sm:text-[20px] font-semibold text-slate-900">
                        Pour commencer sérieusement, sans compliquer.
                    </h2>

                    <div class="mt-4 flex flex-wrap items-end justify-between gap-3">
                        <div>
                            <p class="text-[26px] sm:text-[28px] font-semibold text-slate-900 leading-none">
                                <span data-price-main
                                      data-monthly="3 500"
                                      data-annual="35 000">3 500</span>
                                <span data-price-suffix class="text-[13px] font-normal text-slate-600">
                                    FCFA / mois
                                </span>
                            </p>
                            <p class="mt-1 text-[11px] text-slate-600"
                               data-price-sub
                               data-sub-monthly="ou 35 000 FCFA / an (≈ 2 mois offerts)"
                               data-sub-annual="≈ 2 mois offerts">
                                ou 35 000 FCFA / an (≈ 2 mois offerts)
                            </p>
                        </div>
                        <div class="text-[11px] text-slate-600 bg-white/80 border border-emerald-100 rounded-xl px-3 py-2 max-w-[220px]">
                            <span class="block font-semibold text-emerald-700">Idéal si :</span>
                            <span>vous avez un petit catalogue ou vous testez la vente en ligne.</span>
                        </div>
                    </div>
                </div>

                <div class="flex-1 px-5 py-5">
                    <p class="text-[11px] font-semibold text-slate-500 mb-2">
                        Ce que ce plan inclut :
                    </p>
                    <ul class="space-y-2.5 text-[12px] text-slate-700">
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-emerald-500/60 flex items-center justify-center">
                                <i class="ri-check-line text-[10px] text-emerald-700"></i>
                            </span>
                            <span>Boutique MYLMARK dédiée (page vitrine + listing de vos produits)</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-emerald-500/60 flex items-center justify-center">
                                <i class="ri-check-line text-[10px] text-emerald-700"></i>
                            </span>
                            <span><strong>Jusqu’à 50 produits actifs</strong> en même temps</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-emerald-500/60 flex items-center justify-center">
                                <i class="ri-check-line text-[10px] text-emerald-700"></i>
                            </span>
                            <span>Gestion des stocks, variations (taille, couleur…), prix promo</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-emerald-500/60 flex items-center justify-center">
                                <i class="ri-check-line text-[10px] text-emerald-700"></i>
                            </span>
                            <span>Réception & suivi des commandes (historique, statuts, notifications)</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-emerald-500/60 flex items-center justify-center">
                                <i class="ri-pie-chart-2-line text-[10px] text-emerald-700"></i>
                            </span>
                            <span>Tableau de bord simple : ventes, commandes, chiffre d’affaires</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-emerald-500/60 flex items-center justify-center">
                                <i class="ri-customer-service-2-line text-[10px] text-emerald-700"></i>
                            </span>
                            <span>Support standard</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-emerald-500/60 flex items-center justify-center">
                                <i class="ri-percent-line text-[10px] text-emerald-700"></i>
                            </span>
                            <span>Commission standard : <strong>5% par vente</strong></span>
                        </li>
                    </ul>
                </div>

                <div class="px-5 pb-5 border-t border-emerald-100 bg-emerald-50/80">
                    <a href="{{ route('partners.register') }}?module=shop&plan=standard"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-900 text-slate-50 text-[13px] font-semibold px-4 py-2.5 hover:bg-slate-800 transition">
                        <i class="ri-store-3-line text-[16px]"></i>
                        Commencer avec Standard
                    </a>
                    <p class="mt-1.5 text-[11px] text-slate-600 text-center">
                        Recommandé pour vendeurs et créateurs qui démarrent.
                    </p>
                </div>
            </article>

            {{-- PREMIUM --}}
            <article class="flex flex-col rounded-3xl bg-white border border-slate-200 shadow-[0_16px_45px_rgba(15,23,42,0.14)] overflow-hidden">
                <div class="px-5 pt-6 pb-3 border-b border-slate-100 bg-slate-50">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-600">
                        Premium
                    </p>
                    <h2 class="mt-1 text-[18px] sm:text-[20px] font-semibold text-slate-900">
                        Pour plus de volume & plus de visibilité.
                    </h2>

                    <div class="mt-4 flex flex-wrap items-end justify-between gap-3">
                        <div>
                            <p class="text-[26px] sm:text-[28px] font-semibold text-slate-900 leading-none">
                                <span data-price-main
                                      data-monthly="9 900"
                                      data-annual="99 000">9 900</span>
                                <span data-price-suffix class="text-[13px] font-normal text-slate-600">
                                    FCFA / mois
                                </span>
                            </p>
                            <p class="mt-1 text-[11px] text-slate-600"
                               data-price-sub
                               data-sub-monthly="ou 99 000 FCFA / an (≈ 2 mois offerts)"
                               data-sub-annual="≈ 2 mois offerts">
                                ou 99 000 FCFA / an (≈ 2 mois offerts)
                            </p>
                        </div>
                        <div class="text-[11px] text-slate-600 bg-white border border-slate-200 rounded-xl px-3 py-2 max-w-[220px]">
                            <span class="block font-semibold text-slate-800">Idéal si :</span>
                            <span>MYLMARK devient un vrai canal de vente régulier pour votre activité.</span>
                        </div>
                    </div>
                </div>

                <div class="flex-1 px-5 py-5">
                    <p class="text-[11px] font-semibold text-slate-500 mb-2">
                        Ce que ce plan inclut :
                    </p>
                    <p class="text-[11px] text-slate-600 mb-2">
                        <em>Tout ce qui est inclus dans Standard, plus :</em>
                    </p>

                    <ul class="space-y-2.5 text-[12px] text-slate-700">
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-slate-300 flex items-center justify-center">
                                <i class="ri-check-line text-[10px] text-slate-800"></i>
                            </span>
                            <span><strong>Produits illimités</strong> dans votre catalogue</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-slate-300 flex items-center justify-center">
                                <i class="ri-rocket-line text-[10px] text-slate-800"></i>
                            </span>
                            <span>Mise en avant prioritaire (“À la une”, “Sélection MYLMARK”, etc.)</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-slate-300 flex items-center justify-center">
                                <i class="ri-shield-check-line text-[10px] text-slate-800"></i>
                            </span>
                            <span>Badges de confiance sur la boutique et les fiches produits</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-slate-300 flex items-center justify-center">
                                <i class="ri-bar-chart-2-line text-[10px] text-slate-800"></i>
                            </span>
                            <span>Statistiques avancées : meilleures ventes, panier moyen, clients récurrents…</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-slate-300 flex items-center justify-center">
                                <i class="ri-megaphone-line text-[10px] text-slate-800"></i>
                            </span>
                            <span>Participation aux campagnes marketing (newsletters, réseaux sociaux, etc.)</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-slate-300 flex items-center justify-center">
                                <i class="ri-headphone-line text-[10px] text-slate-800"></i>
                            </span>
                            <span>Support prioritaire</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] h-4 w-4 rounded-full border border-slate-300 flex items-center justify-center">
                                <i class="ri-percent-line text-[10px] text-slate-800"></i>
                            </span>
                            <span>Commission réduite : <strong>2% par vente</strong></span>
                        </li>
                    </ul>
                </div>

                <div class="px-5 pb-5 border-t border-slate-100 bg-slate-50/90">
                    <a href="{{ route('partners.register') }}?module=shop&plan=premium"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-900 text-white text-[13px] font-semibold px-4 py-2.5 hover:bg-slate-800 transition">
                        <i class="ri-flashlight-line text-[16px]"></i>
                        Passer en Premium
                    </a>
                    <p class="mt-1.5 text-[11px] text-slate-600 text-center">
                        À privilégier si vous publiez souvent et visez des ventes régulières.
                    </p>
                </div>
            </article>
        </div>


        <div class="mt-9">
            <div class="relative overflow-hidden rounded-2xl border border-emerald-100 bg-gradient-to-r from-emerald-50 via-emerald-50/60 to-slate-50 px-4 py-3.5 sm:px-5 sm:py-4 shadow-soft">
                {{-- Halo décoratif --}}
                <div class="pointer-events-none absolute -right-8 -top-10 h-24 w-24 rounded-full bg-emerald-300/30 blur-2xl"></div>

                <div class="relative flex flex-col sm:flex-row sm:items-center gap-3">
                    {{-- Bloc gauche : icône + label --}}
                    <div class="flex items-center gap-2.5">
                        <div class="h-9 w-9 rounded-xl bg-emerald-600 flex items-center justify-center shadow-md">
                            <i class="ri-secure-payment-line text-[18px] text-emerald-50"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700">
                                Commissions
                            </p>
                            <p class="mt-1 text-[11px] text-slate-700 flex flex-wrap gap-1">
                                <span class="inline-flex items-center gap-1 rounded-full bg-white/90 px-2 py-0.5">
                                    <span class="text-[11px] font-semibold text-emerald-700">5%</span>
                                    <span class="text-[10px] text-slate-500">Standard</span>
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-white/90 px-2 py-0.5">
                                    <span class="text-[11px] font-semibold text-emerald-700">2%</span>
                                    <span class="text-[10px] text-slate-500">Premium</span>
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Bloc droite : phrase rassurante --}}
                    <p class="text-[11px] text-slate-600 sm:text-right sm:ml-auto">
                        Ces commissions s’appliquent
                        <strong>uniquement sur les ventes réellement payées</strong>.
                        Aucun frais caché.
                    </p>
                </div>
            </div>
        </div>





        {{-- Bandeau parrainage --}}
        {{-- <div class="mt-9 rounded-2xl border border-dashed border-slate-300 bg-white px-4 py-3 sm:px-5 sm:py-4 flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-2xl bg-slate-900 text-slate-50 flex items-center justify-center">
                    <i class="ri-gift-line text-lg"></i>
                </div>
                <div>
                    <p class="text-[12px] font-semibold text-slate-900">
                        Programme de parrainage MYLMARK
                    </p>
                    <p class="text-[11px] text-slate-600">
                        Invitez un vendeur : lors de son premier abonnement payant,
                        <strong>vous gagnez des jours d’abonnement offerts</strong>
                        et <strong>il profite d’une réduction sur son 1er mois</strong>.
                    </p>
                </div>
            </div>
        </div> --}}
    </div>
</section>

{{-- JS toggle mensuel / annuel --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('billingToggle');
        if (!toggle) return;

        let currentMode = 'monthly';

        const applyBillingMode = (mode) => {
            currentMode = mode;

            // Styles des boutons
            toggle.querySelectorAll('button[data-billing]').forEach(btn => {
                const isActive = btn.dataset.billing === mode;
                btn.classList.toggle('bg-slate-900', isActive);
                btn.classList.toggle('text-slate-50', isActive);
                btn.classList.toggle('shadow-sm', isActive);
                btn.classList.toggle('bg-white', !isActive);
                btn.classList.toggle('text-slate-600', !isActive);
            });

            // Prix principaux
            document.querySelectorAll('[data-price-main]').forEach(el => {
                const monthly = el.dataset.monthly;
                const annual  = el.dataset.annual;
                el.textContent = (mode === 'monthly' ? monthly : annual);
            });

            // Suffixes ( /mois vs /an )
            document.querySelectorAll('[data-price-suffix]').forEach(el => {
                el.textContent = (mode === 'monthly'
                    ? 'FCFA / mois'
                    : 'FCFA / an'
                );
            });

            // Sous-texte
            document.querySelectorAll('[data-price-sub]').forEach(el => {
                const subMonthly = el.dataset.subMonthly;
                const subAnnual  = el.dataset.subAnnual;
                el.textContent = (mode === 'monthly' ? subMonthly : subAnnual);
            });
        };

        toggle.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-billing]');
            if (!btn) return;
            const mode = btn.dataset.billing;
            if (mode && mode !== currentMode) {
                applyBillingMode(mode);
            }
        });

        // Mode par défaut
        applyBillingMode('monthly');
    });
</script>
@endsection
