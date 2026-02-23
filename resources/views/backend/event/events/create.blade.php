@extends('backend.event.layouts.master')
@section('title','Créer un événement')
@section('content')

<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h3 class="page-title">Créer un événement</h3>
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('partners.event.events.index') }}">Événements</a></li>
        <li class="breadcrumb-item active">Créer</li>
      </ul>
    </div>
  </div>
</div>

<div class="alert alert-info">
  <i class="ti ti-shield-lock"></i>
  Les créations sont <strong>soumises</strong> à validation. L’événement sera créé en brouillon, puis une demande de <strong>publication</strong> sera envoyée à l’administrateur.
</div>

@include('backend.event.events._form', [
  'action'       => route('partners.event.events.store'),
  'method'       => 'POST',
  'submitLabel'  => 'Soumettre à validation',
  'event'        => null,
  'withComment'  => true,
  'categories'   => $categories,
])
@endsection
