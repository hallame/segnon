@extends('backend.admin.layouts.master')

@section('title', 'Commande '.$order->reference)

@php
    use Illuminate\Support\Str;

    $status       = $order->status;
    $statusLabel  = [
        'draft'            => 'Brouillon',
        'awaiting_payment' => 'En attente paiement',
        'paid'             => 'Payée',
        'cancelled'        => 'Annulée',
    ][$status] ?? ucfirst($status);

    $badgeClass = match ($status) {
        'paid'             => 'bg-success',
        'awaiting_payment' => 'bg-warning',
        'draft'            => 'bg-secondary',
        'cancelled'        => 'bg-danger',
        default            => 'bg-secondary',
    };

    $lastPayment = $order->payments->first(); // car on a ->latest() dans le load()
@endphp

@section('content')
<div class="container-fluid">

    {{-- Header + back --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Commande {{ $order->reference }}</h4>
            <p class="text-muted mb-0">
                Détails de la commande de billets et gestion du paiement.
            </p>
        </div>
        <a href="{{ route('admin.tickets.orders.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i> Retour aux commandes
        </a>
    </div>

    {{-- Stats cards --}}
    <div class="row g-3 mb-4">
        {{-- Total commande --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-info-transparent border border-info d-flex align-items-center justify-content-center">
                                <i class="ti ti-currency-dollar fs-18 text-info"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Montant total</p>
                            <h4 class="mb-0">
                                {{ number_format($order->total, 0, ',', ' ') }} {{ $order->currency }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statut --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-warning-transparent border border-warning d-flex align-items-center justify-content-center">
                                <i class="ti ti-status-change fs-18 text-warning"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Statut</p>
                            <span class="badge {{ $badgeClass }} fs-12">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nb tickets / lignes --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-ticket fs-18 text-success"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Tickets</p>
                            <h4 class="mb-0">
                                {{ $order->items->sum('qty') }}
                            </h4>
                            {{-- <small class="text-muted">{{ $order->items->count() }} type(s)</small> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dernier paiement --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-primary-transparent border border-primary d-flex align-items-center justify-content-center">
                                <i class="ti ti-credit-card fs-18 text-primary"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Dernier paiement</p>
                            @if($lastPayment)
                                <h6 class="mb-0">
                                    {{ number_format($lastPayment->amount, 0, ',', ' ') }} {{ $lastPayment->currency }}
                                </h6>
                                <small class="text-muted">
                                    {{ $lastPayment->status }} · {{ $lastPayment->created_at->format('d/m/Y H:i') }}
                                </small>
                            @else
                                <span class="text-muted small">Aucun paiement</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Layout 2 colonnes --}}
    <div class="row">
        {{-- Colonne gauche : commande, client, lignes --}}
        <div class="col-xl-8">

            {{-- Infos commande & event --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations commande</h5>
                    <span class="badge bg-light text-muted">
                        Créée le {{ $order->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-2">Événement</h6>
                            <p class="mb-1">
                                {{ $order->event->name ?? '-' }}
                            </p>
                            @if($order->event)
                                <small class="text-muted d-block">
                                    {{ optional($order->event->start_at ?? $order->event->start_date)->format('d/m/Y H:i') ?? '' }}
                                    @if(($order->event->country->name ?? false) || ($order->event->city ?? false))
                                        · {{ $order->event->city ?? '' }} {{ $order->event->country->name ?? '' }}
                                    @endif
                                </small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-2">Client</h6>
                            <p class="mb-1">
                                {{ $order->customer_firstname }} {{ $order->customer_lastname }}
                            </p>
                            <small class="d-block text-muted">
                                {{ $order->customer_email }}
                            </small>
                            @if($order->customer_phone)
                                <small class="d-block text-muted">
                                    {{ $order->customer_phone }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lignes de billets --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Lignes de billets</h5>
                </div>
                <div class="card-body p-0">
                    @if($order->items->count())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type de billet</th>
                                        <th class="text-center">Qté</th>
                                        <th class="text-end">Prix unitaire</th>
                                        <th class="text-end">Total ligne</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->ticket_type_name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="text-end">
                                            {{ number_format($item->unit_price, 0, ',', ' ') }} {{ $order->currency }}
                                        </td>
                                        <td class="text-end">
                                            {{ number_format($item->total_price, 0, ',', ' ') }} {{ $order->currency }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="3" class="text-end">Sous-total</th>
                                        <th class="text-end">
                                            {{ number_format($order->subtotal, 0, ',', ' ') }} {{ $order->currency }}
                                        </th>
                                    </tr>
                                    @if($order->discount > 0)
                                    <tr>
                                        <th colspan="3" class="text-end">Remise</th>
                                        <th class="text-end text-success">
                                            -{{ number_format($order->discount, 0, ',', ' ') }} {{ $order->currency }}
                                        </th>
                                    </tr>
                                    @endif
                                    @if($order->tax > 0)
                                    <tr>
                                        <th colspan="3" class="text-end">Taxes</th>
                                        <th class="text-end">
                                            {{ number_format($order->tax, 0, ',', ' ') }} {{ $order->currency }}
                                        </th>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th colspan="3" class="text-end">Total</th>
                                        <th class="text-end">
                                            {{ number_format($order->total, 0, ',', ' ') }} {{ $order->currency }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="p-3">
                            <p class="mb-0 text-muted">Aucune ligne de billet pour cette commande.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tickets générés (après validation paiement) --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tickets générés</h5>
                    <span class="badge bg-light text-muted">
                        {{ $order->tickets->count() }} ticket(s)
                    </span>
                </div>
                <div class="card-body p-0">
                    @if($order->tickets->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Code / QR</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Créé le</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($order->tickets as $ticket)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $ticket->qr_code }}</span>
                                        </td>
                                        <td>
                                            {{ $ticket->ticketType->name ?? '-' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-outline-primary">
                                                {{ $ticket->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="small text-muted">
                                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-3">
                            <p class="mb-0 text-muted">
                                Aucun ticket n’a encore été associé à cette commande.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Colonne droite : paiements + actions --}}
        <div class="col-xl-4">

            {{-- Timeline paiements --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Paiements</h5>
                </div>
                <div class="card-body">
                    @if($order->payments->count())
                        <div class="timeline">
                            @foreach($order->payments as $payment)
                                @php
                                    $pBadge = match ($payment->status) {
                                        \App\Models\Payment::STATUS_SUBMITTED => 'bg-warning',
                                        \App\Models\Payment::STATUS_VERIFIED  => 'bg-success',
                                        \App\Models\Payment::STATUS_REJECTED  => 'bg-danger',
                                        default                              => 'bg-secondary',
                                    };
                                @endphp
                                <div class="mb-3 pb-3 border-bottom last:border-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <span class="badge {{ $pBadge }} me-2">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                            <strong>{{ $payment->method->name ?? 'Méthode inconnue' }}</strong>
                                        </div>
                                        <small class="text-muted">
                                            {{ $payment->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div class="small text-muted mb-1">
                                        Montant : {{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}
                                    </div>
                                    @if($payment->transaction_number)
                                        <div class="small">
                                            Réf. transaction : <strong>{{ $payment->transaction_number }}</strong>
                                        </div>
                                    @endif
                                    @if($payment->note)
                                        <div class="small mt-1">
                                            <span class="text-muted">Note :</span><br>
                                            {!! nl2br(e($payment->note)) !!}
                                        </div>
                                    @endif
                                    @if($payment->hasMedia('receipt'))
                                        <div class="small mt-1">
                                            <a href="{{ $payment->getFirstMediaUrl('receipt') }}" target="_blank">
                                                Voir reçu
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mb-0 text-muted">Aucun paiement soumis pour le moment.</p>
                    @endif
                </div>
            </div>

            {{-- Actions validation / rejet pour le dernier paiement soumis --}}
            @if($lastPayment && $lastPayment->status === \App\Models\Payment::STATUS_SUBMITTED)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Valider / rejeter le paiement</h5>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted">
                            Vérifiez les informations du paiement ci-dessus (montant, méthode, reçu, référence),
                            puis confirmez ou rejetez.
                        </p>

                        {{-- Note admin --}}
                        <form method="POST" action="" id="paymentActionForm">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_note" class="form-label fs-12 fw-medium text-gray-5">
                                    Note interne / message
                                </label>
                                <textarea name="note" id="admin_note" rows="3" class="form-control"
                                          placeholder="Ajouter un commentaire (optionnel)"></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                {{-- Vérifier --}}
                                <button type="submit"
                                        class="btn btn-success flex-fill"
                                        formaction="{{ route('admin.tickets.orders.payments.verify', $lastPayment) }}">
                                    <i class="ti ti-badge-check me-1"></i> Valider le paiement
                                </button>

                                {{-- Rejeter --}}
                                <button type="submit"
                                        class="btn btn-outline-danger flex-fill"
                                        formaction="{{ route('admin.tickets.orders.payments.reject', $lastPayment) }}">
                                    <i class="ti ti-x me-1"></i> Rejeter
                                </button>
                            </div>
                        </form>
                        <small class="text-muted d-block mt-2">
                            La validation associera les tickets à la commande et passera le statut en <strong>Payée</strong>.
                            Le rejet informera le client par e-mail.
                        </small>
                    </div>
                </div>
            @else
                {{-- Pas de paiement soumis ou déjà traité --}}
            @endif

        </div>
    </div>
</div>
@endsection
