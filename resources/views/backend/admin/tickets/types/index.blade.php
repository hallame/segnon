@extends('backend.admin.layouts.master')

@section('title', 'Types de tickets')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Stats cards --}}
    @if(!empty($stats))
        <div class="row mb-4">
            {{-- Total types --}}
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
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Total types</p>
                                    <h4 class="mb-0">{{ $stats['total_types'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Types actifs --}}
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center">
                                        <i class="ti ti-check fs-18 text-success"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Types actifs</p>
                                    <h4 class="mb-0">{{ $stats['active_types'] }}</h4>
                                </div>
                            </div>
                            @if($stats['total_types'] > 0)
                                <span class="badge bg-success-subtle text-success fs-11">
                                    {{ round($stats['active_types'] / max($stats['total_types'],1) * 100) }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Types inactifs --}}
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <span class="p-2 br-10 bg-secondary-transparent border border-secondary d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle fs-18 text-secondary"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Types inactifs</p>
                                    <h4 class="mb-0">{{ $stats['inactive_types'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Capacité totale --}}
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <span class="p-2 br-10 bg-warning-transparent border border-warning d-flex align-items-center justify-content-center">
                                        <i class="ti ti-users fs-18 text-warning"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="fs-12 fw-medium mb-1 text-gray-5">Capacité définie</p>
                                    <h4 class="mb-0">
                                        {{ number_format($stats['total_capacity'] ?? 0, 0, '.', ' ') }} &infin;
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Filtres --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ticket_types.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label mb-1">Événement</label>
                        <select name="event_id" class="form-select">
                            <option value="">Tous les événements</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}"
                                    @selected(($filters['event_id'] ?? null) == $event->id)>
                                    {{ $event->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Statut</label>
                        <select name="active" class="form-select">
                            <option value="">Actif + inactif</option>
                            <option value="1" @selected(($filters['active'] ?? '') === '1')>Actifs uniquement</option>
                            <option value="0" @selected(($filters['active'] ?? '') === '0')>Inactifs uniquement</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Recherche</label>
                        <input type="text"
                               name="q"
                               class="form-control"
                               placeholder="Nom ou ......"
                               value="{{ $filters['q'] ?? '' }}">
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i> Filtrer
                        </button>
                        <a href="{{ route('admin.ticket_types.index') }}" class="btn btn-dark">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Types de tickets</h1>
            <a href="{{ route('admin.ticket_types.create') }}" class="btn btn-success">
                <i class="ti ti-circle-plus"></i> Nouveau type
            </a>
        </div>

        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Événement</th>
                    <th>Prix (GNF)</th>
                    <th>Reste/Qté</th>
                    <th>Ventes</th>
                    <th>Actif</th>
                    {{-- <th>Créé</th> --}}
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($types as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->event->name ? Str::limit($type->event->name, 20) : '-' }}</td>
                        <td>{{ number_format($type->price, 0, '.', ' ') }}</td>
                        <td>{{ $type->quantity === null ? '∞' : $type->remaining_tickets_count  }}/{{ $type->quantity === null ? '∞' : $type->quantity }}</td>
                        <td>
                            @if($type->sales_start || $type->sales_end)
                                <small class="text-muted">
                                    {{ $type->sales_start ? $type->sales_start->format('Y-m-d H:i') : '—' }}
                                    →
                                    {{ $type->sales_end ? $type->sales_end->format('Y-m-d H:i') : '∞' }}
                                </small>
                            @else
                                <small class="text-muted">Toujours</small>
                            @endif
                        </td>
                        <td>
                            @if($type->is_active)
                                <span class="badge bg-success">Oui</span>
                            @else
                                <span class="badge bg-secondary">Non</span>
                            @endif
                        </td>
                        {{-- <td>{{ $type->created_at->format('Y-m-d') }}</td> --}}
                        <td class="text-end">
                            <a href="{{ route('admin.ticket_types.generate', $type->id) }}"
                               class="btn btn-sm btn-purple"
                               onclick="return confirm('Générer les tickets manquants pour ce type ?')">
                                Générer tickets
                            </a>

                            <a href="{{ route('admin.ticket_types.edit', $type->id) }}" class="btn btn-sm btn-secondary">
                                <i class="ti ti-edit"></i>
                            </a>

                            {{-- Delete: form with modal confirmation --}}
                            <form action="{{ route('admin.ticket_types.destroy', $type->id) }}" method="POST" class="d-inline-block ms-1 delete-type-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-open-delete-modal"
                                        data-id="{{ $type->id }}"
                                        data-name="{{ e($type->name) }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">Aucun type de ticket trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $types->links() }}
    </div>
</div>

{{-- Modal de confirmation de suppression (Bootstrap) --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmer la suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Êtes-vous sûr de vouloir supprimer ce type de ticket : <strong id="deleteTypeName"></strong> ? Cette action est irréversible.</p>
      </div>
      <div class="modal-footer m-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Supprimer</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deleteForm = null;

        document.querySelectorAll('.btn-open-delete-modal').forEach(btn => {
            btn.addEventListener('click', function () {
                const name = this.dataset.name || '—';
                document.getElementById('deleteTypeName').textContent = name;
                deleteForm = this.closest('form');
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show();
            });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (!deleteForm) return;
            deleteForm.submit();
        });
    });
</script>
@endsection
