@extends('backend.event.layouts.master')
@section('title','Calendrier des événements')
@section('content')

<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h3 class="page-title">Calendrier</h3>
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('partners.event.events.index') }}">Événements</a></li>
        <li class="breadcrumb-item active">Calendrier</li>
      </ul>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form class="row g-2 mb-3" method="get">
        <div class="col-md-4">
            <input id="start" name="start" type="date" class="form-control" value="{{ $start->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <input id="end" name="end" type="date" class="form-control" value="{{ $end->format('Y-m-d') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button class="btn btn-outline-secondary w-100">
                <i class="ti ti-calendar-stats"></i> Afficher
            </button>
            <button class="btn btn-outline-primary w-100"
                    type="submit"
                    formaction="{{ route('partners.event.events.export') }}"
                    formmethod="GET">
            <i class="ti ti-download"></i> Exporter
            </button>
        </div>
    </form>


    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Lieu</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
        @forelse($events as $e)
          <tr>
            <td><a href="{{ route('partners.event.events.edit', $e->id) }}">{{ $e->name }}</a></td>
            <td>{{ \Carbon\Carbon::parse($e->start_date)->format('d M Y H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($e->end_date)->format('d M Y H:i') }}</td>
            <td>{{ $e->location ?: '—' }}</td>
            <td><span class="badge {{ $e->status ? 'badge-success' : 'badge-secondary' }}">{{ $e->status ? 'Actif' : 'Inactif' }}</span></td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">Aucun événement sur cette période.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
