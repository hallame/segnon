@extends('backend.event.layouts.master')
@section('title','Tableau de bord')

@section('content')
@php
  $u     = auth()->user();
  $range = (int) request('range', 30);

  // Sécurisation des datas attendues
  $metrics = $metrics ?? [
    'events_total'=>0,'events_upcoming'=>0,'events_live'=>0,'events_past'=>0,
    'published'=>null,'pending'=>null,'drafts'=>null
  ];
  $sales = $sales ?? [
    'revenue30'=>null,'orders30'=>null,'attendees30'=>null,'checkinsToday'=>null
  ];
  $flags = $flags ?? ['hasOrders'=>false,'hasAttendees'=>false,'hasCheckins'=>false];
  $nextEvents   = $nextEvents   ?? collect();
  $recentOrders = $recentOrders ?? collect();
@endphp

{{-- Bandeau de bienvenue --}}
<div class="welcome-wrap mb-3">
  <div class="d-flex align-items-center justify-content-between flex-wrap text-white rounded-3">
    <div class="mb-1">
      <h2 class="mb-1 text-white">Bienvenue, {{ trim(($u?->firstname)) ?: $u?->email }} !</h2>
    </div>
    <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
      <a href="{{ route('partners.event.events.create') }}" class="btn btn-dark">
        <i class="ti ti-calendar-plus me-2"></i>Nouveau événement
      </a>
      <a href="#" class="btn btn-light text-dark">
        <i class="ti ti-qrcode me-2"></i>Ouvrir le check-in
      </a>
    </div>
  </div>
  <div class="welcome-bg">
    <img src="{{ asset('assets/back/img/bg/welcome-bg-02.svg') }}" class="welcome-bg-01" alt="">
    <img src="{{ asset('assets/back/img/bg/welcome-bg-03.svg') }}" class="welcome-bg-02" alt="">
    <img src="{{ asset('assets/back/img/bg/welcome-bg-01.svg') }}" class="welcome-bg-03" alt="">
  </div>
</div>

{{-- Filtres rapides / fenêtre temporelle --}}
{{-- <form method="get" class="mb-3">
  <div class="d-flex flex-wrap align-items-center gap-2">
    <span class="text-muted">Période :</span>
    @foreach([7=>'7j',30=>'30j',90=>'90j'] as $d=>$lbl)
      <button name="range" value="{{ $d }}" class="btn btn-sm {{ $range===$d ? 'btn-primary' : 'btn-outline-light border' }}">
        {{ $lbl }}
      </button>
    @endforeach
  </div>
</form> --}}

{{-- KPIs (ligne 1 : événements) --}}
<div class="row g-3">
  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-primary flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-calendar-event text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">Événements</p>
            <h5 class="mb-0">{{ number_format($metrics['events_total']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-success flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-calendar-up text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">À venir</p>
            <h5 class="mb-0">{{ number_format($metrics['events_upcoming']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-warning flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-broadcast text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">En cours</p>
            <h5 class="mb-0">{{ number_format($metrics['events_live']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-secondary flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-history text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">Passés</p>
            <h5 class="mb-0">{{ number_format($metrics['events_past']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>
</div>

{{-- KPIs (ligne 2 : modération si dispo) --}}
@if(!is_null($metrics['published']))
<div class="row g-3 mt-1">
  <div class="col-xl-4 col-md-4">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-success flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-check text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">Publiés</p>
            <h5 class="mb-0">{{ number_format($metrics['published']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-4">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-warning flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-hourglass text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">En revue</p>
            <h5 class="mb-0">{{ number_format($metrics['pending']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-4">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-secondary flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-edit text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">Brouillons</p>
            <h5 class="mb-0">{{ number_format($metrics['drafts']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>
</div>
@endif

{{-- KPIs (ligne 3 : billetterie si dispo) --}}
<div class="row g-3 mt-1">
  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-purple flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-currency-dollar text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">CA ({{ $range }}j)</p>
            <h5 class="mb-0">
              @if(!is_null($sales['revenue30']))
                {{ number_format($sales['revenue30'], 0, ' ', ' ') }}
              @else
                —
              @endif
            </h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-info flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-receipt-2 text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">Commandes ({{ $range }}j)</p>
            <h5 class="mb-0">{{ is_null($sales['orders30']) ? '—' : number_format($sales['orders30']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-success flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-users text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">Participants ({{ $range }}j)</p>
            <h5 class="mb-0">{{ is_null($sales['attendees30']) ? '—' : number_format($sales['attendees30']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card position-relative">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md br-10 bg-dark flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-scan text-white fs-16"></i></span>
          </div>
          <div class="ms-3">
            <p class="fw-medium text-truncate mb-1">Check-ins (aujourd’hui)</p>
            <h5 class="mb-0">{{ is_null($sales['checkinsToday']) ? '—' : number_format($sales['checkinsToday']) }}</h5>
          </div>
        </div>
        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" class="position-absolute top-0 end-0" alt="">
      </div>
    </div>
  </div>
</div>



{{-- Prochains événements --}}
<div class="card mt-3">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0"><i class="ti ti-calendar-stats me-1"></i> Prochains événements</h5>
    <a href="{{ route('partners.event.events.index') }}" class="btn btn-sm btn-outline-secondary">Voir tout</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Événement</th>
            <th>Période</th>
            <th>Lieu</th>
            <th>Statut</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($nextEvents as $ev)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="fw-medium">{{ $ev->name }}</td>
              <td>
                {{ \Carbon\Carbon::parse($ev->start_date)->format('d/m/Y H:i') }}
                — {{ \Carbon\Carbon::parse($ev->end_date)->format('d/m/Y H:i') }}
              </td>
              <td>{{ $ev->location ?: '—' }}</td>
              <td>
                @php
                  // statut d’activation (1/0) + éventuellement modération si dispo
                  $badge = $ev->status ? 'badge-success' : 'badge-secondary';
                  $text  = $ev->status ? 'Actif' : 'Inactif';
                @endphp
                <span class="badge {{ $badge }}">{{ $text }}</span>
              </td>
              <td class="text-end">
                <a class="btn btn-sm btn-light" href="{{ route('partners.event.events.edit', $ev->id) }}">
                  <i class="ti ti-edit"></i> Éditer
                </a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('partners.event.tickets.types.index', $ev->id) }}">
                  <i class="ti ti-ticket"></i> Billetterie
                </a>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Aucun événement à venir. Créez votre premier événement.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Dernières commandes (si billetterie dispo) --}}
@if($flags['hasOrders'])
<div class="card mt-3">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0"><i class="ti ti-receipt-2 me-1"></i> Dernières commandes</h5>

    <a href="#" class="btn btn-sm btn-outline-secondary">Tout voir</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Client</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
        @forelse($recentOrders as $o)
          <tr>
            <td>{{ $o->id }}</td>
            <td>{{ $o->buyer_email }}</td>
            <td>{{ number_format($o->total, 2, ',', ' ') }} {{ $o->currency }}</td>
            <td>
              @php
                $map = [
                  'paid'     => ['txt'=>'Payée','cls'=>'badge-success'],
                  'failed'   => ['txt'=>'Échec','cls'=>'badge-danger'],
                  'pending'  => ['txt'=>'En attente','cls'=>'badge-warning'],
                  'refunded' => ['txt'=>'Remboursée','cls'=>'badge-info'],
                ];
                $m = $map[$o->payment_status] ?? ['txt'=>ucfirst($o->payment_status),'cls'=>'badge-secondary'];
              @endphp
              <span class="badge {{ $m['cls'] }}">{{ $m['txt'] }}</span>
            </td>
            <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d/m/Y H:i') }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">Aucune commande pour le moment.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif


{{-- Ligne suivante : Répartition & Raccourcis --}}
<div class="row g-3 mt-1">
  <div class="col-xl-6 d-flex">
    <div class="card flex-fill">
      <div class="card-header">
        <h5 class="mb-0">Répartition des événements</h5>
      </div>
      <div class="card-body">
        @if(is_null($metrics['published']))
          <div class="text-muted">La répartition (Brouillons/En revue/Publiés) s’affichera dès que la colonne <code>moderation_status</code> sera disponible.</div>
        @else
          <div class="row g-3">
            <div class="col-6"><span class="badge bg-secondary me-2">Brouillons</span> {{ number_format($metrics['drafts']) }}</div>
            <div class="col-6"><span class="badge bg-warning me-2">En revue</span> {{ number_format($metrics['pending']) }}</div>
            <div class="col-6"><span class="badge bg-success me-2">Publiés</span> {{ number_format($metrics['published']) }}</div>
            <div class="col-6"><span class="badge bg-info me-2">À venir</span> {{ number_format($metrics['events_upcoming']) }}</div>
            <div class="col-12"><hr class="my-2"><strong>Total :</strong> {{ number_format($metrics['events_total']) }}</div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-xl-6 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Raccourcis</h5>
        <a href="{{ route('partners.event.events.index') }}" class="btn btn-sm btn-outline-primary">Tous mes événements</a>
      </div>
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar avatar-md br-10 bg-primary flex-shrink-0">
            <span class="d-flex align-items-center"><i class="ti ti-rocket text-white fs-16"></i></span>
          </div>
          <div>
            <div class="fw-medium">Démarrer vite</div>
            <div class="text-muted">Créez un événement, ajoutez un type de ticket, activez le check-in.</div>
          </div>
        </div>
        <div class="mt-3 d-flex flex-wrap gap-2">
          {{-- <a href="{{ route('partners.event.events.create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-calendar-plus me-1"></i> Nouvel événement
          </a> --}}
          <a href="{{ route('partners.event.events.calendar') }}" class="btn btn-sm btn-primary border">
            <i class="ti ti-map-pin me-1"></i> Calendrier
          </a>
          <a href="#" class="btn btn-sm btn-outline-light border">
            <i class="ti ti-ticket me-1"></i> Coupons
          </a>
          <a href="#" class="btn btn-sm btn-outline-light border">
            <i class="ti ti-chart-bar me-1"></i> Rapports
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Tips --}}
<div class="alert alert-info mt-3">
  <div class="d-flex">
    <i class="ti ti-info-circle me-2 fs-18"></i>
    <div>
      <strong>Astuce :</strong> créez un événement, ajoutez au moins un type de ticket, puis testez le
      <a href="#">check-in</a> avec un QR code de test.
    </div>
  </div>
</div>

@endsection
