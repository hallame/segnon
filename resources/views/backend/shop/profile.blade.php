@extends('backend.shop.layouts.master')
@section('title','Mon Compte')

@section('content')
@php
    $u = $user ?? auth()->user();
    $currentAccount = $account;
@endphp

{{-- BLOC ABONNEMENT --}}
<div class="card mb-4">
  <div class="card-body d-flex flex-wrap justify-content-between align-items-center row-gap-2">
    <div>
      <div class="small text-muted text-uppercase fw-semibold mb-1">
        Mon abonnement
      </div>

      @php
          /** @var \App\Models\Account|null $currentAccount */
          $plan = $currentAccount?->subscription_plan; // 'standard', 'premium' ou null

          $labels = [
              'standard' => 'Standard',
              'premium'  => 'Premium',
          ];

          $badgeClass = 'bg-secondary-subtle text-secondary';
          if ($plan === 'standard') {
              $badgeClass = 'bg-success-subtle text-success';
          } elseif ($plan === 'premium') {
              $badgeClass = 'bg-warning-subtle text-warning';
          }
      @endphp

      @if($currentAccount?->on_trial)
          {{-- ESSAI EN COURS --}}
          <h6 class="mb-1">
              Période d’essai :
              <span class="badge bg-info-subtle text-info">
                  {{ $plan ? 'Essai '.$labels[$plan] : 'Découverte MYLMARK' }}
              </span>
          </h6>
          <div class="small text-muted">
              Essai gratuit en cours
              @if($currentAccount?->subscription_ends_at)
                  — jusqu’au {{ $currentAccount->subscription_ends_at->format('d/m/Y') }}
              @endif
          </div>
      @else
          {{-- PLUS D’ESSAI : SOIT UN PLAN ACTIF, SOIT RIEN --}}
          <h6 class="mb-1">
              Plan actuel :
              @if($plan)
                  <span class="badge {{ $badgeClass }}">
                      {{ $labels[$plan] ?? ucfirst($plan) }}
                  </span>
              @else
                  <span class="badge bg-secondary-subtle text-secondary">
                      Aucun abonnement actif
                  </span>
              @endif
          </h6>

          @if($plan && $currentAccount?->subscription_ends_at)
              <div class="small text-muted">
                  Prochaine échéance : {{ $currentAccount->subscription_ends_at->format('d/m/Y') }}
              </div>
          @elseif(!$plan)
              <div class="small text-muted">
                  Votre période d’essai est terminée. Vous pouvez choisir
                  un plan Standard ou Premium.
              </div>
          @endif
      @endif
    </div>

    {{-- CTA futur quand tu auras le paiement en place --}}
    <div class="text-end">
        <a href="{{ route('partners.shop.subscription.index') }}" class="btn btn-outline-secondary btn-sm">Gérer mon abonnement</a>
    </div>
  </div>
</div>





{{-- FORMULAIRE PROFIL --}}
<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-2">
    <h5 class="mb-0">Mon profil</h5>
  </div>

  <form method="POST" action="{{ route('partners.shop.profile.update') }}" class="card-body row g-3">
    @csrf @method('PUT')

    {{-- Infos utilisateur --}}
    <div class="col-md-4">
      <label for="firstname" class="form-label">Prénom</label>
      <input id="firstname" name="firstname" type="text" class="form-control"
             value="{{ old('firstname', $u?->firstname) }}" required>
      @error('firstname') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="lastname" class="form-label">Nom</label>
      <input id="lastname" name="lastname" type="text" class="form-control"
             value="{{ old('lastname', $u?->lastname) }}">
      @error('lastname') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="email" class="form-label">Email</label>
      <input id="email" name="email" type="email" readonly class="form-control"
             value="{{ old('email', $u?->email) }}" placeholder="contact@exemple.com">
      @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="phone" class="form-label">Téléphone</label>
      <input id="phone" name="phone" type="text" class="form-control"
             value="{{ old('phone', $u?->phone) }}" placeholder="Ex: +1234567890">
      @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="whatsapp" class="form-label">WhatsApp</label>
      <input id="whatsapp" name="whatsapp" type="text" class="form-control"
             value="{{ old('whatsapp', $u?->whatsapp) }}" placeholder="Ex: +1234567890">
      @error('whatsapp') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <hr class="mt-4 mb-3">

    {{-- Infos compte / boutique --}}
    <div class="col-12">
      <h6 class="fw-semibold mb-2">Ma boutique</h6>
    </div>

    <div class="col-md-8">
      <label for="account_name" class="form-label">Nom</label>
      <input id="account_name" name="account_name" type="text" class="form-control"
             value="{{ old('account_name', $currentAccount?->name) }}" required>
      @error('account_name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="account_email" class="form-label">Email</label>
      <input id="account_email" name="account_email" type="email" class="form-control"
             value="{{ old('account_email', $currentAccount?->email) }}" placeholder="ex: boutique@mylmark.com">
      @error('account_email') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="account_phone" class="form-label">Téléphone</label>
      <input id="account_phone" name="account_phone" type="text" class="form-control"
             value="{{ old('account_phone', $currentAccount?->phone) }}">
      @error('account_phone') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="account_whatsapp" class="form-label">WhatsApp </label>
      <input id="account_whatsapp" name="account_whatsapp" type="text" class="form-control"
             value="{{ old('account_whatsapp', $currentAccount?->whatsapp) }}">
      @error('account_whatsapp') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="account_country" class="form-label">Pays</label>
      <input id="account_country" name="account_country" type="text" class="form-control"
             value="{{ old('account_country', $currentAccount?->country) }}">
      @error('account_country') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-8">
      <label for="account_address" class="form-label">Adresse</label>
      <input id="account_address" name="account_address" type="text" class="form-control"
             value="{{ old('account_address', $currentAccount?->address) }}">
      @error('account_address') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label for="account_city" class="form-label">Ville</label>
      <input id="account_city" name="account_city" type="text" class="form-control"
             value="{{ old('account_city', $currentAccount?->city) }}">
      @error('account_city') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
      <label for="account_about" class="form-label">À propos</label>
      <textarea id="account_about" name="account_about" rows="4" class="form-control"
                placeholder="Décrivez votre boutique, votre univers, vos valeurs...">{{ old('account_about', $currentAccount?->about) }}</textarea>
      @error('account_about') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-12 d-flex justify-content-end gap-2">
      <a href="{{ route('partners.shop.dashboard') }}" class="btn btn-light">Annuler</a>
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
  </form>
</div>
@endsection
