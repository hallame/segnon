@extends('backend.event.layouts.master')
@section('title','Réglages')

@section('content')
<div class="row">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Sécurité — Changer le mot de passe</h5>
      </div>

      <form method="POST" action="{{ route('partners.event.settings.update') }}" class="card-body row g-3">
        @csrf @method('PUT')

        <div class="col-12">
          <label for="current_password" class="form-label">Mot de passe actuel</label>
          <input id="current_password" name="current_password" type="password" class="form-control" required>
          @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
          <label for="password" class="form-label">Nouveau mot de passe</label>
          <input id="password" name="password" type="password" class="form-control" minlength="8" required>
          @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
          <label for="password_confirmation" class="form-label">Confirmer</label>
          <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" minlength="8" required>
        </div>

        <div class="col-12 d-flex justify-content-end gap-2">
          <a href="{{ route('partners.event.dashboard') }}" class="btn btn-light">Annuler</a>
          <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
      </form>
    </div>
  </div>

  {{-- (Option) Carte d’info / aide --}}
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header">
        <h6 class="mb-0">Aide</h6>
      </div>
      <div class="card-body">
        <p class="text-muted mb-2">• Minimum 8 caractères.</p>
        <p class="text-muted mb-2">• Évitez de réutiliser un mot de passe déjà utilisé.</p>
        @if (Route::has('contact'))
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('contact') }}">Contacter le support</a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
