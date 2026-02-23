@extends('backend.admin.layouts.master')
@section('title', 'Liste des Tickets')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Stats cards --}}
    @if(!empty($stats))
        <div class="row mb-4">
            {{-- Total tickets --}}
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <span class="p-2 br-10 bg-info-transparent border border-info d-flex align-items-center justify-content-center">
                                        <i class="ti ti-ticket fs-18 text-info"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Total tickets</p>
                                    <h4 class="mb-0">{{ $stats['total'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Disponibles --}}
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle-check fs-18 text-success"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Disponibles</p>
                                    <h4 class="mb-0">{{ $stats['available'] }}</h4>
                                </div>
                            </div>
                            @if($stats['total'] > 0)
                                <span class="badge bg-success-subtle text-success fs-11">
                                    {{ round($stats['available'] / max($stats['total'],1) * 100) }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Réservés --}}
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <span class="p-2 br-10 bg-warning-transparent border border-warning d-flex align-items-center justify-content-center">
                                        <i class="ti ti-clock fs-18 text-warning"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Réservés</p>
                                    <h4 class="mb-0">{{ $stats['reserved'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vendus + utilisés --}}
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <span class="p-2 br-10 bg-pink-transparent border border-pink d-flex align-items-center justify-content-center">
                                        <i class="ti ti-checklist fs-18 text-pink"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Vendus</p>
                                    <h4 class="mb-0">
                                        {{ $stats['sold'] + $stats['used'] }}
                                    </h4>
                                </div>
                            </div>
                            {{-- <span class="fs-11 text-muted">
                                Vendus : {{ $stats['sold'] }} &nbsp;•&nbsp; Utilisés : {{ $stats['used'] }}
                            </span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Filtres --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.tickets.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label mb-1">Événement</label>
                        <select name="event_id" class="form-select">
                            <option value="">Tous</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}"
                                    @selected(($filters['event_id'] ?? null) == $event->id)>
                                    {{ $event->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Type de ticket</label>
                        <select name="ticket_type_id" class="form-select">
                            <option value="">Tous</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}"
                                    @selected(($filters['ticket_type_id'] ?? null) == $type->id)>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Statut</label>
                        <select name="status" class="form-select">
                            <option value="">Tous</option>
                            <option value="available" @selected(($filters['status'] ?? '') === 'available')>Disponible</option>
                            <option value="reserved" @selected(($filters['status'] ?? '') === 'reserved')>Réservé</option>
                            <option value="sold"     @selected(($filters['status'] ?? '') === 'sold')>Vendu</option>
                            <option value="used"     @selected(($filters['status'] ?? '') === 'used')>Utilisé</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1">Recherche</label>
                        <input type="text"
                               name="q"
                               class="form-control"
                               placeholder="ID ou QR code..."
                               value="{{ $filters['q'] ?? '' }}">
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i>
                        </button>
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-dark">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table des tickets --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des tickets</h5>
            <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus"></i> Ajouter un ticket
            </a>
        </div>

        <div class="card-body">
            @if($tickets->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Événement</th>
                                <th>Type de ticket</th>
                                <th>QR / Référence</th>
                                <th>Status</th>
                                {{-- <th>Créé le</th> --}}
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>#{{ $ticket->id }}</td>
                                    <td>
                                        {{ $ticket->event? Str::limit($ticket->event->name, 25) : '-' }}
                                    </td>
                                    <td>{{ $ticket->ticketType->name ?? '-' }} ({{ $ticket->ticketType->price ?? '-' }} GNF)</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $ticket->qr_code ? Str::limit($ticket->qr_code, 20) : '—' }}
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $status = $ticket->status;
                                        @endphp
                                        @if($status === 'available')
                                            <span class="badge bg-success">Disponible</span>
                                        @elseif($status === 'reserved')
                                            <span class="badge bg-warning text-dark">Réservé</span>
                                        @elseif($status === 'sold')
                                            <span class="badge bg-primary">Vendu</span>
                                        @elseif($status === 'used')
                                            <span class="badge bg-secondary">Utilisé</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                    {{-- <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td> --}}
                                    <td class="text-end">
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                           class="btn btn-sm btn-info">
                                           <i class="ti ti-eye"></i>
                                        </a>

                                        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}"
                                              method="POST"
                                              class="d-inline-block"
                                              onsubmit="return confirm('Supprimer ce ticket ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $tickets->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            @else
                <p class="text-muted mb-0">Aucun ticket trouvé.</p>
            @endif
        </div>
    </div>
</div>
@endsection
