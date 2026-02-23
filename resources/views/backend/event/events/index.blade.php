@extends('backend.event.layouts.master')
@section('title','Mes événements')
@section('content')

{{-- <div class="page-header">
  <div class="row align-items-center gy-2">
    <div class="col">
      <h3 class="page-title">Mes événements</h3>
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('partners.event.dashboard') }}">Organisateur</a></li>
        <li class="breadcrumb-item active">Événements</li>
      </ul>
    </div>
    <div class="col-auto">
      <a href="{{ route('partners.event.events.create') }}" class="btn btn-primary d-flex align-items-center">
        <i class="ti ti-circle-plus me-1"></i> Nouvel Événement
      </a>
    </div>
  </div>
</div> --}}

{{-- STAT CARDS --}}
<div class="row g-3">
  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-pink-transparent border border-pink d-flex align-items-center justify-content-center me-2">
            <i class="ti ti-users-group text-pink fs-18"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Total Événements</p>
            <h4 class="mb-0">{{ $totalEvents }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-info-transparent border border-info d-flex align-items-center justify-content-center me-2">
            <i class="ti ti-calendar-plus fs-18"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Événements à venir</p>
            <h4 class="mb-0">{{ $upcomingEvents }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-warning-transparent border border-warning d-flex align-items-center justify-content-center me-2">
            <i class="ti ti-history fs-18"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Événements passés</p>
            <h4 class="mb-0">{{ $pastEvents }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center me-2">
              <i class="ti ti-broadcast fs-18"></i>
            </span>
            <div>
              <p class="fs-12 fw-medium mb-1 text-gray-5">En cours</p>
              <h4 class="mb-0">{{ $liveNow }}</h4>
            </div>
          </div>
          <a href="{{ route('partners.event.events.create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- FILTRES --}}
<form method="get" class="row g-2 mb-3">
  <div class="col-md-4">
    <label for="q" class="form-label">Recherche</label>
    <input id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nom ou lieu…">
  </div>
  <div class="col-md-4">
    <label for="status" class="form-label">Statut</label>
    <select id="status" name="status" class="form-select">
      <option value="">— Tous —</option>
      <option value="published" @selected(request('status')==='published')>Publiés</option>
      <option value="draft" @selected(request('status')==='draft')>Brouillons</option>
      <option value="pending" @selected(request('status')==='pending')>En revue</option>
    </select>
  </div>
  <div class="col-md-4 d-flex align-items-end gap-2">
    <button class="btn btn-outline-secondary w-100"><i class="ti ti-search"></i> Filtrer</button>
    <a href="{{ route('partners.event.events.export') }}" class="btn btn-outline-primary w-100">
        <i class="ti ti-download"></i> Exporter CSV
    </a>
  </div>


</form>

{{-- LISTE --}}
<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="thead-light">
          <tr>
            <th>Nom</th>
            <th>Période</th>
            {{-- <th>Lieu</th> --}}
            <th>Statut</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
        @forelse($events as $ev)
          <tr>
            <td>
                <div class="d-flex align-items-center file-name-icon">
                    <div class="ms-2">
                        <h6 class="fw-medium">{{ $ev->name }}</h6>
                        <span class="fs-12 fw-normal">{{ $ev->location ? Str::limit($ev->location, 40) : '—' }}</span>
                    </div>
                </div>
            </td>
            <td>{{ \Carbon\Carbon::parse($ev->start_date)->format('d M Y H:i') }} — {{ \Carbon\Carbon::parse($ev->end_date)->format('d M Y H:i') }}</td>
            {{-- <td>{{ $ev->location ? Str::limit($ev->location, 20) : '—' }}</td> --}}
            <td><span class="badge {{ $ev->status ? 'badge-success' : 'badge-secondary' }}">{{ $ev->status ? 'Actif' : 'Inactif' }}</span></td>


            <td class="text-end text-nowrap">
                <div class="btn-group">
                    {{-- Edit principal --}}
                    <a class="btn btn-sm btn-primary" href="{{ route('partners.event.events.edit', $ev->id) }}">
                        <i class="ti ti-edit"></i>
                        <span class="d-none d-md-inline">Éditer</span>
                    </a>

                    {{-- Split dropdown --}}
                    <button class="btn btn-sm btn-dark dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Ouvrir actions</span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end p-1 action-menu">

                    {{-- Publier / Dépublier (désactivés si pending) --}}
                    @php
                        $pending = ($ev->pending_count ?? 0) > 0;
                    @endphp

                    @if(!$ev->status)
                        <form method="post" action="{{ route('partners.event.events.publish',$ev->id) }}" class="m-0">
                        @csrf
                        <button class="dropdown-item d-flex align-items-center gap-2 {{ $pending ? 'disabled pe-none opacity-50' : '' }}">
                            <i class="ti ti-eye"></i> Demander publication
                        </button>
                        </form>
                    @else
                        <form method="post" action="{{ route('partners.event.events.unpublish',$ev->id) }}" class="m-0">
                        @csrf
                        <button class="dropdown-item d-flex align-items-center gap-2 {{ $pending ? 'disabled pe-none opacity-50' : '' }}">
                            <i class="ti ti-eye-off"></i> Demander dépublication
                        </button>
                        </form>
                    @endif

                    {{-- Annuler l’événement (si publié et pas terminé) --}}
                    @php
                        $now = \Carbon\Carbon::now();
                        $canCancel = (bool)$ev->status && \Carbon\Carbon::parse($ev->end_date)->isFuture();
                    @endphp
                    <button
                        class="dropdown-item d-flex align-items-center gap-2 js-cancel {{ $canCancel ? '' : 'disabled pe-none opacity-50' }}"
                        data-action="{{ route('partners.event.events.cancel', $ev->id) }}"
                        title="Informer l’admin que l’événement est annulé (raison requise)">
                        <i class="ti ti-ban"></i> Demander annulation
                    </button>

                    <div class="dropdown-divider my-1"></div>

                    {{-- Dupliquer --}}
                    <form method="post" action="{{ route('partners.event.events.duplicate',$ev->id) }}" class="m-0">
                        @csrf
                        <button class="dropdown-item d-flex align-items-center gap-2">
                        <i class="ti ti-copy"></i> Dupliquer (brouillon)
                        </button>
                    </form>

                    {{-- Supprimer (soumission de suppression) --}}
                    <form method="post" action="{{ route('partners.event.events.destroy',$ev->id) }}" class="m-0"
                            onsubmit="return confirm('Confirmer la demande de suppression ?')">
                        @csrf @method('DELETE')
                        <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                        <i class="ti ti-trash"></i> Demander suppression
                        </button>
                    </form>
                    </div>
                </div>
            </td>

          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">Aucun événement pour le moment.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

    <div class="mt-3">
        {{ $events->links() }}
    </div>



    <form id="cancelForm" method="post" class="d-none">
        @csrf
        <input type="hidden" name="reason" id="cancelReason">
    </form>

    <style>
        .action-menu .dropdown-item .ti{width:18px;text-align:center;opacity:.8}
        @media (max-width: 576px){
            .text-nowrap{white-space:normal}
        }
    </style>


    <script>
    document.addEventListener('click', function(e){
        const btn = e.target.closest('.js-cancel');
        if(!btn) return;

        const reason = prompt("Raison de l’annulation (obligatoire) :");
        if(!reason) return;

        const form = document.getElementById('cancelForm');
        form.action = btn.dataset.action;
        document.getElementById('cancelReason').value = reason;
        form.submit();
    });
    </script>

@endsection
