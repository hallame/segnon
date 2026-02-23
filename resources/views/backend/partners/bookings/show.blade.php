@extends('backend.partners.layouts.master')
@section('title','Réservation '.$b->reference)

@section('content')
<div class="row g-3">

  <div class="col-lg-8">
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
           <h5 class="mb-1 d-flex align-items-center gap-2">
                <a href="{{ route('partners.bookings.index') }}" class="btn btn-sm btn-light border me-2" title="Retour à la liste">
                    <i class="ti ti-arrow-left"></i>
                </a>
                <span>Réservation #{{ $b->reference ?? $b->id }}</span>
            </h5>

            <div class="text-muted small">{{ $b->created_at?->format('d/m/Y H:i') }} — Source: {{ $b->source ?? '—' }}</div>
          </div>
          @php
            $statusMap = [
              \App\Models\Booking::STATUS_PENDING   => 'bg-warning text-dark',
              \App\Models\Booking::STATUS_CONFIRMED => 'bg-info',
              \App\Models\Booking::STATUS_CANCELLED => 'bg-danger',
              \App\Models\Booking::STATUS_COMPLETED => 'bg-success',
            ];
            $payMap = [
              \App\Models\Booking::PAY_UNPAID         => 'bg-secondary',
              \App\Models\Booking::PAY_AWAITING_VERIF => 'bg-warning text-dark',
              \App\Models\Booking::PAY_VERIFIED       => 'bg-success',
              \App\Models\Booking::PAY_REJECTED       => 'bg-danger',
            ];
          @endphp
          <div class="d-flex gap-2">
            <span class="badge {{ $statusMap[$b->status] ?? 'bg-light' }}">{{ $statusLabels[$b->status] ?? '' }}</span>
            <span class="badge {{ $payMap[$b->payment_status] ?? 'bg-light' }}">{{ $paymentLabels[$b->payment_status] ?? '' }}</span>
          </div>
        </div>

        <hr>

        <div class="row g-3">
          <div class="col-md-6">
            <h6 class="fw-bold">Client</h6>
            @if($b->client)
              <div class="text-muted">{{ $b->client_name }} </div>
              <div class="text-muted">{{ $b->client_email }}</div>
              @if($b->client_phone)<div class="text-muted">{{ $b->client_phone }}</div>@endif
            @else
              <div class="text-muted">—</div>
            @endif
          </div>
          <div class="col-md-6">
            <h6 class="fw-bold">Séjour</h6>
            <div class="d-flex justify-content-between"><span>Arrivée</span><span>{{ $b->check_in?->format('d/m/Y H:i') }}</span></div>
            <div class="d-flex justify-content-between"><span>Départ</span><span>{{ $b->check_out?->format('d/m/Y H:i') }}</span></div>
            <div class="d-flex justify-content-between"><span>Participants</span><span>{{ (int)$b->guests }} {{ $b->is_group ? '(groupe)' : '' }}</span></div>
            <div class="d-flex justify-content-between"><span>Jours</span><span>{{ $b->days->count() }}</span></div>
          </div>
        </div>

        <hr>

        <h6 class="fw-bold">Tarification</h6>
        <div class="d-flex justify-content-between">
          <span>Prix unitaire</span><span>{{ number_format($b->unit_price ?? 0, 0, ' ', ' ') }}</span>
        </div>
        @if(!empty($b->pricing_details))
          <details class="mt-2">
            <summary class="small text-muted">Détails</summary>
            <pre class="small mb-0" style="white-space:pre-wrap">{{ json_encode($b->pricing_details, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
          </details>
        @endif
        <div class="d-flex justify-content-between fw-bold mt-2">
          <span>Montant</span><span>{{ number_format($b->amount ?? 0, 0, ' ', ' ') }}</span>
        </div>
      </div>
    </div>

    {{-- Paiement (restreint) --}}
    {{-- <div class="card mb-3">
      <div class="card-header"><h6 class="mb-0">Paiement</h6></div>
      <div class="card-body">
        <form method="POST" action="{{ route('partners.bookings.payment',$b) }}" class="row g-3">
          @csrf
          <div class="col-md-4">
            <label class="form-label">Statut</label>
            <select name="payment_status" class="form-select">
              <!-- Partenaire: seulement UNPAID <-> AWAITING_VERIF -->
              <option value="{{ \App\Models\Booking::PAY_UNPAID }}" @selected($b->payment_status===\App\Models\Booking::PAY_UNPAID)>Impayé</option>
              <option value="{{ \App\Models\Booking::PAY_AWAITING_VERIF }}" @selected($b->payment_status===\App\Models\Booking::PAY_AWAITING_VERIF)>À vérifier</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Référence paiement</label>
            <input type="text" name="payment_reference" class="form-control" value="{{ $b->payment_reference }}">
          </div>
          <div class="col-md-12">
            <input type="text" name="note" class="form-control" placeholder="Note (optionnel)">
          </div>
          <div class="col-md-12">
            <button class="btn btn-primary">Mettre à jour</button>
          </div>
        </form>

        <hr>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div>
            @if($b->payment_receipt_path)
              <div class="small text-muted">Reçu actuel : <a href="{{ asset('storage/'.$b->payment_receipt_path) }}" target="_blank">voir</a></div>
            @else
              <div class="small text-muted">Aucun reçu envoyé.</div>
            @endif
          </div>
          <div class="d-flex gap-2">
            <form method="POST" action="{{ route('partners.bookings.receipt.upload',$b) }}" enctype="multipart/form-data">
              @csrf
              <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.webp,.pdf" class="form-control form-control-sm d-inline-block" required>
              <button class="btn btn-sm btn-success">Téléverser</button>
            </form>
            @if($b->payment_receipt_path)
              <form method="POST" action="{{ route('partners.bookings.receipt.delete',$b) }}">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
              </form>
            @endif
          </div>
        </div>

      </div>
    </div> --}}

  </div>

  <div class="col-lg-4">
    <div class="card mb-3">
      <div class="card-header"><h6 class="mb-0">Actions</h6></div>
      <div class="card-body">
        <form method="POST" action="{{ route('partners.bookings.status',$b) }}">
          @csrf
          <label class="form-label">Statut réservation</label>
          <div class="d-flex gap-2">
            <select name="status" class="form-select">
              <!-- Partenaire: pending->(confirm/cancel) ; confirmed->(cancel/complete) -->
              @foreach([\App\Models\Booking::STATUS_PENDING,\App\Models\Booking::STATUS_CONFIRMED,\App\Models\Booking::STATUS_CANCELLED,\App\Models\Booking::STATUS_COMPLETED] as $code)
                <option value="{{ $code }}" @selected($b->status===$code) >{{ $statusLabels[$code] }}</option>
              @endforeach
            </select>
            <button class="btn btn-primary">Mettre à jour</button>
          </div>
          <input type="text" name="note" class="form-control mt-2" placeholder="Motif/Note (si annulation)">
        </form>

        @if($b->note)
          <hr><pre class="small mb-0" style="white-space:pre-wrap">{{ $b->note }}</pre>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h6 class="mb-0">Ressource</h6></div>
      <div class="card-body small text-muted">
        <div>Type : {{ class_basename($b->bookable_type) }}</div>
        <div>ID   : {{ $b->bookable_id }}</div>
        @if($b->bookable && (property_exists($b->bookable,'name') || isset($b->bookable->name)))
          <div>Nom  : {{ $b->bookable->name }}</div>
        @elseif($b->bookable && (property_exists($b->bookable,'title') || isset($b->bookable->title)))
          <div>Titre: {{ $b->bookable->title }}</div>
        @endif
      </div>
    </div>
  </div>

</div>
@endsection
