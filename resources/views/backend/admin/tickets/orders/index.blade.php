@extends('backend.admin.layouts.master')
@section('title', 'Commandes billets')

@section('content')
<div class="container-fluid">

    {{-- Header + CTA --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Commandes de billets</h4>
            <p class="text-muted mb-0">Suivi des ventes de tickets et validation des paiements.</p>
        </div>
    </div>

    {{-- Stats cards --}}
    <div class="row g-3 mb-4">
        {{-- Total commandes --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-info-transparent border border-info d-flex align-items-center justify-content-center">
                                <i class="ti ti-receipt-2 fs-18 text-info"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Total commandes</p>
                            <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Brouillons --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-secondary-transparent border border-secondary d-flex align-items-center justify-content-center">
                                <i class="ti ti-pencil fs-18 text-secondary"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Brouillons</p>
                            <h4 class="mb-0">{{ $stats['draft'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- En attente paiement --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-warning-transparent border border-warning d-flex align-items-center justify-content-center">
                                <i class="ti ti-clock-hour-4 fs-18 text-warning"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Validation en cours</p>
                            <h4 class="mb-0">{{ $stats['awaiting_payment'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payées --}}
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-check fs-18 text-success"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Commandes payées</p>
                            <h4 class="mb-0">{{ $stats['paid'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.tickets.orders.index') }}">
                <div class="row g-3 align-items-end">

                    {{-- Filtre événement --}}
                    <div class="col-md-3">
                        <label for="filter_event" class="form-label fs-12 fw-medium text-gray-5">Événement</label>
                        <select name="event_id" id="filter_event" class="form-select">
                            <option value="">Tous les événements</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}" @selected(($filters['event_id'] ?? null) == $ev->id)>
                                    {{ $ev->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtre statut --}}
                    <div class="col-md-3">
                        <label for="filter_status" class="form-label fs-12 fw-medium text-gray-5">Statut</label>
                        <select name="status" id="filter_status" class="form-select">
                            <option value="">Tous les statuts</option>
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected(($filters['status'] ?? null) === $value)>
                                    {{ $label }}
                                    
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Recherche texte --}}
                    <div class="col-md-3">
                        <label for="filter_q" class="form-label fs-12 fw-medium text-gray-5">Recherche</label>
                        <input type="text"
                               name="q"
                               id="filter_q"
                               value="{{ $filters['q'] ?? '' }}"
                               class="form-control"
                               placeholder="Réf., email, nom client…">
                    </div>

                    {{-- Boutons --}}
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="ti ti-filter me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('admin.tickets.orders.index') }}" class="btn btn-dark flex-fill">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tableau des commandes --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Liste des commandes</h5>
        </div>
        <div class="card-body p-0">
            @if($orders->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ticket</th>
                                <th>Client</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            @php
                                $status = $order->status;
                                $badgeClass = match ($status) {
                                    'paid'             => 'bg-success',
                                    'awaiting_payment' => 'bg-warning',
                                    'draft'            => 'bg-secondary',
                                    'cancelled'        => 'bg-danger',
                                    default            => 'bg-secondary',
                                };
                                $statusLabel = $statusOptions[$status] ?? ucfirst($status);
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-medium">
                                        <a href="{{ route('admin.tickets.orders.show', $order) }}" class="fw-semibold text-primary">
                                            {{ $order->reference }}
                                        </a>
                                    </div>
                                    <div class=" text-muted small">
                                        {{ $order->event->name ? Str::limit($order->event->name, 30) : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">
                                        {{ $order->customer_firstname }} {{ $order->customer_lastname }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $order->customer_email }}
                                    </div>
                                </td>
                                <td>
                                    {{ number_format($order->total, 0, ',', ' ') }} {{ $order->currency }}
                                </td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <span class="small text-muted">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.tickets.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="p-4">
                    <p class="mb-0 text-muted text-center">Aucune commande pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
