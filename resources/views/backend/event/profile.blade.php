@extends('backend.event.layouts.master')
@section('title','Mon profil')

@section('content')
@php($g = $g ?? null)
@php($u = $u ?? auth()->user())

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-2">
    <h5 class="mb-0">Mon profil</h5>
  </div>

  <form method="POST" action="{{ route('partners.event.profile.update') }}" class="card-body row g-3">
    @csrf @method('PUT')

    <div class="col-md-6">
      <label for="firstname" class="form-label">Prénom</label>
      <input id="firstname" name="firstname" type="text" class="form-control"
             value="{{ old('firstname', $g?->firstname ?? $u?->firstname) }}" required>
      @error('firstname') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
      <label for="lastname" class="form-label">Nom</label>
      <input id="lastname" name="lastname" type="text" class="form-control"
             value="{{ old('lastname', $g?->lastname ?? $u?->lastname) }}">
      @error('lastname') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
      <label for="email" class="form-label">Email (contact)</label>
      <input id="email" name="email" type="email" class="form-control"
             value="{{ old('email', $g?->email) }}" placeholder="contact@exemple.com">
      @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
      <label for="phone" class="form-label">Téléphone</label>
      <input id="phone" name="phone" type="text" class="form-control"
             value="{{ old('phone', $g?->phone) }}" placeholder="Ex: +1234567890">
      @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
      <label for="whatsapp" class="form-label">WhatsApp</label>
      <input id="whatsapp" name="whatsapp" type="text" class="form-control"
             value="{{ old('whatsapp', $g?->whatsapp) }}" placeholder="Ex: +1234567890">
      @error('whatsapp') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-12 d-flex justify-content-end gap-2">
      <a href="{{ route('partners.event.dashboard') }}" class="btn btn-light">Annuler</a>
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
  </form>
</div>
@endsection
