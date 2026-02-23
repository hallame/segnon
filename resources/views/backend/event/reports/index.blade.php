@extends('backend.event..layouts.master')
@section('title','Rapports — Événementiel')
@section('content')

<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h3 class="page-title">Rapports</h3>
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('partners.event.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active">Rapports</li>
      </ul>
    </div>
    <div class="col-auto d-flex gap-2">
      <form method="get" class="d-flex gap-2">
        <input type="date" name="start" value="{{ $start->toDateString() }}" class="form-control">
        <input type="date" name="end"   value="{{ $end->toDateString() }}"   class="form-control">
        <button class="btn btn-light"><i class="ti ti-filter"></i> Filtrer</button>
      </form>
      <a class="btn btn-outline-secondary"
         href="{{ route('partners.event.reports.export', ['start'=>$start->toDateString(),'end'=>$end->toDateString()]) }}">
        <i class="ti ti-download"></i> Export CSV
      </a>
    </div>
  </div>
</div>

{{-- Cartes contenu (toujours dispo) --}}
<div class="row g-3 mb-3">
  <div class="col-md-3"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">Total événements</p><h4>{{ $content['events_total'] }}</h4></div>
    <span class="p-2 br-10 bg-info-transparent border border-info d-flex align-items-center"><i class="ti ti-calendar"></i></span>
  </div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">À venir</p><h4>{{ $content['events_upcoming'] }}</h4></div>
    <span class="p-2 br-10 bg-primary-transparent border border-primary d-flex align-items-center"><i class="ti ti-calendar-plus"></i></span>
  </div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">En cours</p><h4>{{ $content['events_live'] }}</h4></div>
    <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center"><i class="ti ti-bolt"></i></span>
  </div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">Passés</p><h4>{{ $content['events_past'] }}</h4></div>
    <span class="p-2 br-10 bg-warning-transparent border border-warning d-flex align-items-center"><i class="ti ti-calendar-check"></i></span>
  </div></div></div>
</div>

{{-- KPIs billetterie (si dispo) --}}
@if($flags['hasOrders'] || $flags['hasAttendees'] || $flags['hasCheckins'])
<div class="row g-3 mb-3">
  @if($flags['hasOrders'])
  <div class="col-md-4"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">Revenu (période)</p><h4>{{ number_format($sales['revenue'] ?? 0,2,',',' ') }}</h4></div>
    <span class="p-2 br-10 bg-emerald-50 border border-emerald-500 d-flex align-items-center"><i class="ti ti-currency-dollar"></i></span>
  </div></div></div>
  <div class="col-md-4"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">Commandes</p><h4>{{ $sales['orders'] ?? 0 }}</h4></div>
    <span class="p-2 br-10 bg-indigo-50 border border-indigo-500 d-flex align-items-center"><i class="ti ti-shopping-cart"></i></span>
  </div></div></div>
  @endif

  @if($flags['hasAttendees'])
  <div class="col-md-4"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">Participants</p><h4>{{ $sales['attendees'] ?? 0 }}</h4></div>
    <span class="p-2 br-10 bg-pink-transparent border border-pink d-flex align-items-center"><i class="ti ti-users"></i></span>
  </div></div></div>
  @endif
  @if($flags['hasCheckins'])
  <div class="col-md-4"><div class="card"><div class="card-body d-flex justify-content-between">
    <div><p class="text-muted mb-1">Check-ins</p><h4>{{ $sales['checkins'] ?? 0 }}</h4></div>
    <span class="p-2 br-10 bg-teal-transparent border border-teal d-flex align-items-center"><i class="ti ti-qrcode"></i></span>
  </div></div></div>
  @endif
</div>

{{-- Top événements --}}
@if(($topEvents ?? collect())->isNotEmpty())
<div class="card mb-3">
  <div class="card-header"><strong>Top événements (par CA)</strong></div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Événement</th><th>Revenu</th><th>Commandes</th></tr></thead>
        <tbody>
        @foreach($topEvents as $row)
          <tr>
            <td>{{ $eventNames[$row->event_id] ?? ('#'.$row->event_id) }}</td>
            <td>{{ number_format($row->revenue,2,',',' ') }}</td>
            <td>{{ $row->orders }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif
@endif

{{-- Message si pas de billetterie --}}
@if(!$flags['hasOrders'] && !$flags['hasAttendees'] && !$flags['hasCheckins'])
<div class="alert alert-warning">
  Les rapports de <strong>billetterie</strong> seront disponibles dès que les modules <em>Commandes/Participants/Check-ins</em> seront en place.
  En attendant, vous pouvez filtrer par période et exporter la liste des événements.
</div>
@endif
@endsection
