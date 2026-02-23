@extends('backend.shop.layouts.master')
@section('title','Mon abonnement')

@section('content')
@php
    /** @var \App\Models\Account $account */

    $plan    = $account->subscription_plan;     // 'standard', 'premium' ou null
    $onTrial = (bool) $account->on_trial;
    $endDate = $account->subscription_ends_at;

    $labels = [
        'standard' => 'Standard',
        'premium'  => 'Premium',
    ];

    $badgeClass = 'bg-secondary-subtle text-secondary';
    if ($plan === \App\Models\Account::PLAN_STANDARD) {
        $badgeClass = 'bg-success-subtle text-success';
    } elseif ($plan === \App\Models\Account::PLAN_PREMIUM) {
        $badgeClass = 'bg-warning-subtle text-warning';
    }
@endphp

<div class="row">
    {{-- Colonne principale --}}
    <div class="col-lg-8">

        {{-- Card : état de l’abonnement --}}
        <div class="card mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center row-gap-2">
                <div>
                    <div class="small text-muted text-uppercase fw-semibold mb-1">
                        Mon abonnement
                    </div>

                    @if($onTrial)
                        {{-- ESSAI EN COURS --}}
                        <h5 class="mb-1">
                            Plan actuel :
                            <span class="badge bg-info-subtle text-info">
                                Période d’essai
                            </span>
                        </h5>
                        <div class="small text-muted">
                            Votre boutique est en essai gratuit
                            @if($endDate)
                                jusqu’au <strong>{{ $endDate->format('d/m/Y') }}</strong>.
                            @endif
                            Vous pouvez passer sur Standard ou Premium à tout moment.
                        </div>
                    @else
                        {{-- PLUS D’ESSAI --}}
                        <h5 class="mb-1">
                            Plan actuel :
                            @if($plan)
                                <span class="badge {{ $badgeClass }}">
                                    {{ $labels[$plan] ?? ucfirst($plan) }}
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">
                                    Aucun abonnement actif
                                </span>
                            @endif
                        </h5>

                        @if($plan && $endDate)
                            <div class="small text-muted">
                                Prochaine échéance le <strong>{{ $endDate->format('d/m/Y') }}</strong>.
                            </div>
                        @elseif(!$plan)
                            <div class="small text-muted">
                                Votre période d’essai est terminée. Choisissez un plan pour continuer à utiliser
                                MYLMARK dans les meilleures conditions.
                            </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>

        {{-- Card : choix / changement de plan --}}
        <div class="card mb-4">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0">Choisir ou modifier mon plan</h5>
                <small class="text-muted">
                    Ajustez votre abonnement selon le volume de produits et vos objectifs de vente.
                </small>
            </div>

            <div class="card-body">

                {{-- Toggle Mensuel / Annuel --}}
                <div class="d-flex justify-content-center mb-4">
                    <div id="billingToggle" class="btn-group btn-group-sm" role="group" aria-label="Choix de facturation">
                        <button type="button"
                                class="btn btn-dark active"
                                data-billing="monthly">
                            Mensuel
                        </button>
                        <button type="button"
                                class="btn btn-outline-dark"
                                data-billing="annual">
                            Annuel <span class="text-success ms-1">≈ 2 mois offerts</span>
                        </button>
                    </div>
                </div>

                <div class="row g-3">

                    {{-- Plan STANDARD --}}
                    <div class="col-md-6">
                        <div class="border rounded-3 h-100 d-flex flex-column p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="small text-uppercase text-success fw-semibold mb-1">
                                        Standard
                                    </div>
                                    <h6 class="mb-1">Pour bien démarrer</h6>
                                </div>
                                <div class="text-end">
                                    <div class="h5 mb-0">
                                        <span class="js-price-main"
                                            data-plan="standard"
                                            data-monthly="3 500"
                                            data-annual="35 000">3&nbsp;500</span>
                                        <span class="small text-muted js-price-suffix" data-plan="standard">
                                            FCFA
                                        </span>
                                    </div>
                                    <div class="small text-muted js-price-sub"
                                        data-plan="standard"
                                        data-sub-monthly=""
                                        data-sub-annual="">

                                    </div>
                                </div>
                            </div>

                            <ul class="list-unstyled small mb-3">
                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white"
                                        style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-building-store text-xs"></i>
                                    </span>
                                    <span>Boutique MYLMARK dédiée</span>
                                </li>

                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white"
                                        style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-box-multiple text-xs"></i>
                                    </span>
                                    <span>Jusqu’à <strong>25 produits actifs</strong></span>
                                </li>

                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white"
                                        style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-adjustments-horizontal text-xs"></i>
                                    </span>
                                    <span>Gestion des stocks, variations, promotions</span>
                                </li>

                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white"
                                        style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-list-details text-xs"></i>
                                    </span>
                                    <span>Suivi des commandes & tableau de bord</span>
                                </li>

                                {{-- <li class="d-flex align-items-start">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white"
                                        style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-percentage text-xs"></i>
                                    </span>
                                    <span>Commission : <strong>5% par vente</strong></span>
                                </li> --}}
                            </ul>


                            <div class="mt-auto">
                                <a href="{{ route('partners.shop.subscription.start', ['plan' => \App\Models\Account::PLAN_STANDARD]) }}"
                                class="btn btn-outline-success w-100 js-subscribe-btn
                                        @if(!$onTrial && $plan === \App\Models\Account::PLAN_STANDARD) disabled @endif"
                                @if(!$onTrial && $plan === \App\Models\Account::PLAN_STANDARD) aria-disabled="true" @endif
                                data-plan="standard">
                                    @if(!$onTrial && $plan === \App\Models\Account::PLAN_STANDARD)
                                        Plan Standard déjà actif
                                    @else
                                        Choisir le plan Standard
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Plan PREMIUM --}}
                    <div class="col-md-6">
                        <div class="border rounded-3 h-100 d-flex flex-column p-3 bg-light-subtle">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="small text-uppercase text-warning fw-semibold mb-1">
                                        Premium
                                    </div>
                                    <h6 class="mb-1">Pour accélérer sérieusement</h6>
                                </div>
                                <div class="text-end">
                                    <div class="h5 mb-0">
                                        <span class="js-price-main"
                                            data-plan="premium"
                                            data-monthly="9 900"
                                            data-annual="99 000">9&nbsp;900</span>
                                        <span class="small text-muted js-price-suffix" data-plan="premium">
                                            FCFA
                                        </span>
                                    </div>
                                    <div class="small text-muted js-price-sub"
                                        data-plan="premium"
                                        data-sub-monthly=" "
                                        data-sub-annual="">

                                    </div>
                                </div>
                            </div>

                            <ul class="list-unstyled small mb-3">
                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-check text-xs"></i>
                                    </span>
                                    <span><strong>Produits illimités</strong> dans votre catalogue</span>
                                </li>

                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-arrow-up-right text-xs"></i>
                                    </span>
                                    <span>Mise en avant prioritaire sur la marketplace</span>
                                </li>

                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-shield-check text-xs"></i>
                                    </span>
                                    <span>Badges de confiance & meilleure visibilité</span>
                                </li>

                                <li class="d-flex align-items-start mb-2">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-chart-bar text-xs"></i>
                                    </span>
                                    <span>Statistiques avancées</span>
                                </li>

                                {{-- <li class="d-flex align-items-start">
                                    <span class="me-2 mt-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width:1.25rem;height:1.25rem;">
                                        <i class="ti ti-percentage text-xs"></i>
                                    </span>
                                    <span>Commission réduite : <strong>2% par vente</strong></span>
                                </li> --}}
                            </ul>


                            <div class="mt-auto">
                                <a href="{{ route('partners.shop.subscription.start', ['plan' => \App\Models\Account::PLAN_PREMIUM]) }}"
                                class="btn btn-dark w-100 js-subscribe-btn
                                        @if(!$onTrial && $plan === \App\Models\Account::PLAN_PREMIUM) disabled @endif"
                                @if(!$onTrial && $plan === \App\Models\Account::PLAN_PREMIUM) aria-disabled="true" @endif
                                data-plan="premium">
                                    @if(!$onTrial && $plan === \App\Models\Account::PLAN_PREMIUM)
                                        Plan Premium déjà actif
                                    @else
                                        Passer au plan Premium
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>

                </div> {{-- row --}}
            </div>
        </div>

        {{-- Script : toggle mensuel / annuel + ajout param billing aux liens --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let currentMode = 'monthly';
                const toggle   = document.getElementById('billingToggle');

                const applyMode = (mode) => {
                    currentMode = mode;

                    // Boutons toggle
                    toggle.querySelectorAll('button[data-billing]').forEach(btn => {
                        const active = btn.dataset.billing === mode;
                        btn.classList.toggle('btn-dark', active);
                        btn.classList.toggle('btn-outline-dark', !active);
                        btn.classList.toggle('active', active);
                    });

                    // Prix
                    document.querySelectorAll('.js-price-main').forEach(el => {
                        const monthly = el.dataset.monthly;
                        const annual  = el.dataset.annual;
                        el.innerHTML  = (mode === 'monthly' ? monthly : annual).replace(' ', '&nbsp;');
                    });

                    // Suffix (/mois ou /an)
                    document.querySelectorAll('.js-price-suffix').forEach(el => {
                        el.textContent = (mode === 'monthly') ? 'FCFA' : 'FCFA';
                    });

                    // Sous-texte
                    document.querySelectorAll('.js-price-sub').forEach(el => {
                        const subMonthly = el.dataset.subMonthly;
                        const subAnnual  = el.dataset.subAnnual;
                        el.textContent = (mode === 'monthly' ? subMonthly : subAnnual);
                    });
                };

                if (toggle) {
                    toggle.addEventListener('click', function (e) {
                        const btn = e.target.closest('button[data-billing]');
                        if (!btn) return;
                        const mode = btn.dataset.billing;
                        if (mode && mode !== currentMode) {
                            applyMode(mode);
                        }
                    });
                }

                // Append billing=... aux liens d’abonnement
                document.querySelectorAll('.js-subscribe-btn').forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        if (btn.classList.contains('disabled') || btn.hasAttribute('aria-disabled')) {
                            e.preventDefault();
                            return;
                        }

                        e.preventDefault();
                        const href = btn.getAttribute('href') || '';
                        const sep  = href.includes('?') ? '&' : '?';
                        window.location.href = href + sep + 'billing=' + encodeURIComponent(currentMode);
                    });
                });

                applyMode('monthly');
            });
        </script>

    </div>

    {{-- Colonne latérale (infos / note) --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body d-flex gap-3">
                <div class="avatar avatar-md flex-shrink-0 bg-primary-subtle text-primary rounded-3 d-inline-flex align-items-center justify-content-center">
                    <i class="ti ti-shield-check"></i>
                </div>
                <div class="small text-muted">
                    <div class="fw-semibold mb-1">Paiement sécurisé</div>
                    MYLMARK n’enregistre pas vos coordonnées bancaires.
                </div>
            </div>
        </div>

        {{-- <div class="card mb-3">
            <div class="card-body small text-muted">
                <div class="fw-semibold mb-1">
                    À propos des commissions
                </div>
                <p class="mb-1">
                    Les commissions (<strong>5% Standard</strong>, <strong>2% Premium</strong>) s’appliquent
                    <strong>uniquement sur les ventes réellement payées</strong>.
                </p>
                <p class="mb-0">
                    Aucun frais fixe caché sur vos commandes.
                </p>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-body small text-muted">
                <div class="fw-semibold mb-1">
                    Besoin d’aide ?
                </div>
                <p class="mb-0">
                    Une question sur les abonnements ou la facturation ? Écrivez-nous à
                    <strong>contact@mylmark.com</strong> et nous vous répondons rapidement.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
