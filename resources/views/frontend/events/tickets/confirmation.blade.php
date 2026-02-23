{{-- resources/views/frontend/events/confirmation.blade.php --}}
@extends('frontend.layouts.master')
@section('title', 'Confirmation — '.$event->name)

@section('content')
<section class="bg-slate-50/70 py-10 md:py-16">
    <div class="max-w-5xl mx-auto px-4">
        {{-- Header / Hero --}}
        <div class="flex items-start gap-4 mb-8 md:mb-10">
            <div class="h-12 w-12 md:h-14 md:w-14 rounded-2xl bg-emerald-100 flex items-center justify-center shadow-sm">
                <svg class="h-7 w-7 text-emerald-600" viewBox="0 0 24 24" fill="none">
                    <path d="M9.5 16.25L5.75 12.5L7.16 11.09L9.5 13.43L16.84 6.09L18.25 7.5L9.5 16.25Z"
                          fill="currentColor" />
                </svg>
            </div>

            <div>
                <p class="text-[10px] md:text-xs font-semibold tracking-[0.25em] uppercase text-emerald-600/90 mb-1">
                    Commande enregistrée
                </p>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-snug">
                    Merci pour votre réservation
                </h1>
                <p class="mt-2 text-sm md:text-base text-slate-600">
                    {{ $event->name }}
                </p>
            </div>
        </div>

        @php
            $statusLabels = [
                'pending'          => 'En attente',
                'awaiting_payment' => 'En attente de validation',
                'paid'             => 'Payée',
                'completed'        => 'Terminée',
                'cancelled'        => 'Annulée',
                'refunded'         => 'Remboursée',
                'payment_failed'   => 'Paiement échoué',
            ];

            $statusLabel = $statusLabels[$ot->status] ?? ucfirst(str_replace('_',' ',$ot->status));

            $statusClasses = [
                'pending'          => 'bg-amber-50 text-amber-800 ring-amber-200',
                'awaiting_payment' => 'bg-amber-50 text-amber-800 ring-amber-200',
                'paid'             => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
                'completed'        => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
                'cancelled'        => 'bg-rose-50 text-rose-800 ring-rose-200',
                'refunded'         => 'bg-sky-50 text-sky-800 ring-sky-200',
                'payment_failed'   => 'bg-rose-50 text-rose-800 ring-rose-200', // 🔴 ajoute ça
            ];

            $statusClass = $statusClasses[$ot->status] ?? 'bg-slate-50 text-slate-800 ring-slate-200';
        @endphp

        <div class="grid gap-6 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)]">
            {{-- Colonne principale --}}
            <div class="space-y-5">
                {{-- Résumé commande --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 md:p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500 mb-1">
                                Référence de commande
                            </p>
                            <p class="font-mono text-lg md:text-xl font-semibold text-slate-900">
                                {{ $ot->reference }}
                            </p>
                        </div>

                        @if($ot->status === 'paid')
                            <p class="text-emerald-700 font-semibold">Paiement confirmé ✅</p>
                        @elseif($ot->status === 'payment_failed')
                            <p class="text-rose-700 font-semibold">Paiement échoué ❌</p>
                        @endif


                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-semibold ring-1 {{ $statusClass }}">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-current"></span>
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm md:text-[15px]">
                        <div>
                            <dt class="text-slate-500 mb-1">Montant total</dt>
                            <dd class="text-base md:text-lg font-semibold text-slate-900">
                                {{ number_format($ot->total, 0, ',', ' ') }}
                                <span class="text-xs font-medium text-slate-500 align-middle">GNF</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-slate-500 mb-1">Événement</dt>
                            <dd class="font-medium text-slate-900">
                                {{ $event->name }}
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-4 border-t border-dashed border-slate-200 pt-4 text-xs md:text-[13px] text-slate-500 flex flex-wrap items-center gap-3">
                        @if($ot->created_at)
                            <span>Commande passée le
                                <span class="font-medium text-slate-700">
                                    {{ $ot->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </span>
                        @endif

                        @if(!empty($ot->customer_email))
                            <span class="hidden sm:inline">•</span>
                            <span>
                                Confirmation envoyée à
                                <span class="font-medium text-slate-700">{{ $ot->customer_email }}</span>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Bloc "Étape suivante" --}}
                <div class="relative overflow-hidden rounded-2xl bg-green-900 text-slate-50 p-5 md:p-6">
                    <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-emerald-500/15 blur-3xl"></div>
                    <div class="pointer-events-none absolute -left-12 -bottom-16 h-40 w-40 rounded-full bg-sky-500/10 blur-3xl"></div>

                    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                        <div class="max-w-xl">
                            <p class="text-[10px] md:text-[11px] font-semibold tracking-[0.25em] uppercase text-emerald-300/80 mb-2">
                                Étape suivante
                            </p>

                            @if($ot->payments->isNotEmpty())
                                <p class="text-sm md:text-base font-medium">
                                    Votre paiement a bien été transmis. Notre équipe va le vérifier sous peu.
                                </p>
                                <p class="mt-2 text-xs md:text-sm text-slate-300 leading-relaxed">
                                    Vous recevrez un e-mail dès que le paiement sera validé.
                                    Vos tickets (QR code) seront alors envoyés à votre adresse e-mail.
                                </p>
                            @else
                                <p class="text-sm md:text-base font-medium">
                                    Votre réservation est enregistrée. Il ne reste plus qu’à finaliser le paiement.
                                </p>
                                <p class="mt-2 text-xs md:text-sm text-slate-300 leading-relaxed">
                                    Suivez les instructions reçues par e-mail pour effectuer le règlement.
                                    Pensez à mentionner la référence
                                    <span class="font-mono font-semibold">{{ $ot->reference }}</span>
                                    dans le motif du paiement.
                                </p>
                            @endif
                        </div>

                        {{-- <div class="flex flex-col gap-2 text-xs md:text-sm w-full md:w-auto">
                            <a href="{{ route('events.show', $event) }}"
                               class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 border border-white/15 font-medium">
                                Voir l’événement
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- Colonne droite --}}
            <aside class="space-y-4">
                @if($ot->payments->isNotEmpty())
                    @php $p = $ot->payments->first(); @endphp
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-3 md:p-3">
                        <div class="flex items-center justify-between gap-1 mb-3">
                            <h2 class="text-sm font-semibold text-slate-900">
                                Paiement
                            </h2>
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[11px] font-medium bg-slate-50 text-slate-600 ring-1 ring-slate-200">
                                {{ $p->reference }}
                            </span>
                        </div>

                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between gap-3">
                                <dt class="text-slate-500">Méthode</dt>
                                <dd class="font-medium text-slate-900"> {{ $p->method->name }}</dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt class="text-slate-500">Montant soumis</dt>
                                <dd class="font-medium text-slate-900">
                                    {{ number_format($p->amount ?? $ot->total, 0, ',', ' ') }} GNF
                                </dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt class="text-slate-500">Statut</dt>
                                <dd class="font-medium text-slate-900">
                                    {{ ['Soumis','Vérifié','Rejeté'][$p->status] ?? 'Inconnu' }}
                                </dd>
                            </div>
                            @if($p->created_at)
                                <div class="flex justify-between gap-3">
                                    <dt class="text-slate-500">Date</dt>
                                    <dd class="text-slate-900">
                                        {{ $p->created_at->format('d/m/Y H:i') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>

                        <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                            Si ces informations ne correspondent pas à votre paiement,
                            merci de contacter le support en mentionnant votre référence de commande.
                        </p>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-4 md:p-5">
                        <h2 class="text-sm font-semibold text-slate-900 mb-2">
                            Paiement en attente
                        </h2>
                        {{-- <p class="text-xs md:text-sm text-slate-600 mb-3">
                            Aucun paiement n’est encore lié à cette commande.
                        </p> --}}
                        <ul class="text-xs md:text-sm text-slate-600 space-y-1.5 list-disc list-inside">
                            <li>Consultez vos SMS / e-mails pour les instructions de paiement.</li>
                            <li>Indiquez la référence
                                <span class="font-mono font-semibold">{{ $ot->reference }}</span>
                                dans le motif du paiement.
                            </li>
                            <li>Conservez bien votre reçu, il pourra être demandé pour la validation.</li>
                        </ul>
                    </div>
                @endif

                {{-- Bloc assistance --}}
                <div class="bg-green-900 text-green-50 rounded-2xl p-4 md:p-5 text-xs md:text-sm">
                    <h3 class="font-semibold mb-2">Besoin d’aide ?</h3>
                    <p class="text-green-200 mb-2 leading-relaxed">
                        En cas de question sur votre commande ou votre paiement,
                        contactez notre équipe de support en mentionnant votre référence.
                    </p>
                    <p class="text-white">
                        Référence :
                        <span class="font-mono font-extrabold">{{ $ot->reference }}</span>
                    </p>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
