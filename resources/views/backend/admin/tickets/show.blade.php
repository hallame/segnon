@extends('backend.admin.layouts.master')
@section('title', 'Détails du Ticket')

@section('content')
<div class="row">
    <div class="col-12 col-xl-9 mx-auto">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="fa fa-ticket-alt me-2"></i>
                        Ticket #{{ $ticket->id }}
                    </h5>
                    <small class="text-muted">
                        {{ $ticket->event->name ?? 'Événement non renseigné' }}
                    </small>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-light btn-sm">
                        <i class="fa fa-arrow-left me-1"></i> Retour
                    </a>

                    @if(Route::has('admin.tickets.edit'))
                        <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit me-1"></i> Modifier
                        </a>
                    @endif
                </div>
            </div>

            <div class="card-body">

                @php
                    $statusMap = [
                        'active'    => 'success',
                        'published' => 'success',
                        'draft'     => 'warning',
                        'pending'   => 'warning',
                        'cancelled' => 'danger',
                        'archived'  => 'secondary',
                    ];
                    $statusClass = $statusMap[$ticket->status] ?? 'secondary';

                    // 👉 Adapte cette partie selon ta façon de générer/servir le QR code
                    // Exemple 1 : si tu as un accessor $ticket->qrcode_url
                    // $qrUrl = $ticket->qrcode_url;
                    //
                    // Exemple 2 : si tu as une route pour générer le QR
                    // $qrUrl = route('admin.tickets.qrcode', $ticket);
                    //
                    // Pour l’exemple, je mets une variable générique :
                    $qrUrl = $ticket->qrcode_url ?? null;
                @endphp

                <div class="row g-4 align-items-stretch">
                    {{-- Colonne infos --}}
                    <div class="col-md-7 order-2 order-md-1">
                        <h6 class="text-uppercase text-muted small fw-semibold mb-3">
                            Informations du ticket
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-muted" style="width: 180px;">ID interne</th>
                                        <td>#{{ $ticket->id }}</td>
                                    </tr>

                                    <tr>
                                        <th class="text-muted">Événement</th>
                                        <td>{{ $ticket->event->name ?? '—' }}</td>
                                    </tr>

                                    <tr>
                                        <th class="text-muted">Type de ticket</th>
                                        <td>{{ $ticket->ticketType->name ?? '—' }}</td>
                                    </tr>

                                    <tr>
                                        <th class="text-muted">Statut</th>
                                        <td>
                                            <span class="badge bg-{{ $statusClass }} px-3 py-2">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-muted">Créé le</th>
                                        <td>
                                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                                            <small class="text-muted ms-2">
                                                ({{ $ticket->created_at->diffForHumans() }})
                                            </small>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-muted">Mis à jour le</th>
                                        <td>
                                            {{ $ticket->updated_at->format('d/m/Y H:i') }}
                                            <small class="text-muted ms-2">
                                                ({{ $ticket->updated_at->diffForHumans() }})
                                            </small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Colonne QR code / Carte ticket --}}
                    <div class="col-md-5 order-1 order-md-2">
                        <div class="h-100 d-flex flex-column justify-content-between">

                            <div class="border rounded-3 p-3 p-md-4 position-relative"
                                 style="background: #f9fafb;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-dark-subtle text-dark fw-semibold">
                                        Ticket numérique: {{ $ticket->qr_code }}
                                    </span>
                                    <i class="fa fa-qrcode text-muted"></i>
                                </div>



                                <div class="text-center">
                                    <div class="fw-semibold">
                                        {{ $ticket->event->name ?? '—' }}
                                    </div>
                                    <div class="text-muted small">
                                        Type : {{ $ticket->ticketType->name ?? '—' }}
                                    </div>

                                    <div class="mt-3">
                                        <small class="text-muted d-block">
                                            Réf. ticket : #{{ $ticket->id }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-center gap-2">
                                @if($qrUrl)
                                    <a href="{{ $qrUrl }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="fa fa-download me-1"></i> Télécharger le QR
                                    </a>
                                @endif

                                @if(Route::has('admin.tickets.print'))
                                    <a href="{{ route('admin.tickets.print', $ticket) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-print me-1"></i> Imprimer le ticket
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
