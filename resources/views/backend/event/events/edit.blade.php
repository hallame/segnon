@extends('backend.event.layouts.master')
@section('title','Éditer : '.$event->name)
@section('content')

<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h3 class="page-title">Éditer : {{ $event->name }}</h3>
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('partners.event.events.index') }}">Événements</a></li>
        <li class="breadcrumb-item active">Éditer</li>
      </ul>
    </div>
    {{-- <div class="col-auto d-flex gap-2 flex-wrap">
      @if(!$event->status)
        <form method="post" action="{{ route('partners.event.events.publish',$event->id) }}">@csrf
          <button class="btn btn-success"><i class="ti ti-eye"></i> Demander publication</button>
        </form>
      @else
        <form method="post" action="{{ route('partners.event.events.unpublish',$event->id) }}">@csrf
          <button class="btn btn-warning"><i class="ti ti-eye-off"></i> Demander dépublication</button>
        </form>
      @endif
      <form method="post" action="{{ route('partners.event.events.duplicate',$event->id) }}">@csrf
        <button class="btn btn-outline-secondary"><i class="ti ti-copy"></i> Dupliquer</button>
      </form>
      <form method="post" action="{{ route('partners.event.events.destroy',$event->id) }}"
            onsubmit="return confirm('Confirmer la demande de suppression ?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger"><i class="ti ti-trash"></i> Demander suppression</button>
      </form>
    </div> --}}
  </div>
</div>

<div class="alert alert-info">
  <i class="ti ti-shield-lock"></i>
  Les modifications ci-dessous seront <strong>soumises</strong> à la validation.
</div>

@include('backend.event.events._form', [
  'action'       => route('partners.event.events.update', $event->id),
  'method'       => 'PUT',
  'submitLabel'  => 'Soumettre les modifications',
  'event'        => $event,
  'withComment'  => false,
  'categories'   => $categories,
])

{{-- Annulation --}}
{{-- <div class="card mt-3">
  <div class="card-header"><strong>Annuler l’événement</strong></div>
  <div class="card-body">
    <form method="post" action="{{ route('partners.event.events.cancel', $event->id) }}">@csrf
      <div class="row g-2">
        <div class="col-md-8">
          <label for="reason" class="form-label">Raison (optionnel)</label>
          <input id="reason" name="reason" class="form-control" placeholder="Ex: météo, sécurité, logistique…">
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button class="btn btn-outline-danger w-100"><i class="ti ti-ban"></i> Demander l’annulation</button>
        </div>
      </div>
    </form>
  </div>
</div> --}}
@endsection
