@extends('backend.admin.layouts.master')
@section('title','Réservation '.$b->reference)
@section('content')
<div class="row g-3">

<div class="col-lg-8">
    <div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div>
            <h5 class="mb-1 d-flex align-items-center gap-2">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-light border me-2" title="Retour à la liste">
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
            <span class="badge {{ $statusMap[$b->status] ?? 'bg-light' }}">{{ ucfirst(str_replace('_',' ',$statusLabels[$b->status] ?? '')) }}</span>
            <span class="badge {{ $payMap[$b->payment_status] ?? 'bg-light' }}">{{ ucfirst(str_replace('_',' ',$paymentLabels[$b->payment_status] ?? '')) }}</span>
        </div>
        </div>

        <hr>

        <div class="row g-3">
        <div class="col-md-6">
            <h6 class="fw-bold">Client</h6>
            @if($b->client)
            <div class="text-muted">{{ $b->client_name }}</div>
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
            <summary class="small text-muted">Détail du calcul</summary>
            <pre class="small mb-0" style="white-space:pre-wrap">{{ json_encode($b->pricing_details, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
        </details>
        @endif
        <div class="d-flex justify-content-between fw-bold mt-2">
        <span>Montant</span><span>{{ number_format($b->amount ?? 0, 0, ' ', ' ') }}</span>
        </div>

    </div>
    </div>

    {{-- Reçu / Paiement --}}
    <div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Paiement</h6></div>
    <div class="card-body">
        <div class="row g-3">
        <div class="col-md-12">
            <form method="POST" action="{{ route('admin.bookings.payment',$b) }}">
            @csrf
            <label class="form-label">Statut paiement</label>
            <div class="d-flex gap-2">
                <select name="payment_status" class="form-select">
                @foreach($paymentLabels as $code=>$lab)
                    <option value="{{ $code }}" @selected($b->payment_status===$code)>{{ ucfirst(str_replace('_',' ',$lab)) }}</option>
                @endforeach
                </select>
                <button class="btn btn-primary">Mettre à jour</button>
            </div>
            <div class="mt-2">
                <label class="form-label">Échéance paiement</label>
                <input type="datetime-local" name="payment_due_at" class="form-control"
                    value="{{ $b->payment_due_at ? $b->payment_due_at->format('Y-m-d\TH:i') : '' }}">
            </div>
            <div class="mt-2">
                <label class="form-label">Référence paiement</label>
                <input type="text" name="payment_reference" class="form-control" value="{{ $b->payment_reference }}">
            </div>
            <input type="text" name="note" class="form-control mt-2" placeholder="Note interne (optionnel)">
            </form>
        </div>

        </div>
    </div>
    </div>

    {{-- ASSIGNATION GUIDE --}}
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Guide</h6>
            @if($b->guide)
            <form method="POST" action="{{ route('admin.bookings.unassign-guide', $b) }}" onsubmit="return confirm('Retirer le guide ?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Retirer</button>
            </form>
            @endif
        </div>

        <div class="card-body">
            @php
            $placeLabel = match($placeSig['type'] ?? null) {
                \App\Models\Site::class    => 'Site',
                \App\Models\Museum::class  => 'Musée',
                \App\Models\Monument::class=> 'Monument',
                default => 'Ressource',
            };
            $placeName = $b->bookable_name ?? '—';
            @endphp

            <div class="mb-2 small text-muted">
            Lieu : <strong>{{ $placeLabel }}</strong> — {{ $placeName }}
            </div>

            @if($b->guide)
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <div>
                <div><strong>{{ $b->guide->firstname }} {{ $b->guide->lastname }}</strong></div>
                @if($assignedPivot)
                    <div class="small text-muted">
                    Tarif: {{ number_format($assignedPivot->price ?? 0, 0, ',', ' ') }} {{ $assignedPivot->currency ?? '' }}
                    @if($assignedPivot->pricing_type) ({{ str_replace('_',' ', $assignedPivot->pricing_type) }}) @endif
                    </div>
                @endif
                </div>
                <span class="badge bg-info">Guide assigné</span>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.bookings.assign-guide', $b) }}" class="row g-2">
            @csrf
            <div class="col-md-8">
                <label class="form-label">Guide éligible</label>
                <select name="guide_id" class="form-select" {{ $eligibleGuides->isEmpty() ? 'disabled' : '' }}>
                @if($eligibleGuides->isEmpty())
                    <option value="">— Aucun guide éligible pour ce lieu —</option>
                @else
                    <option value="">— Choisir —</option>
                    @foreach($eligibleGuides as $g)
                    <option value="{{ $g->id }}">
                        {{ $g->lastname }} {{ $g->firstname }}
                        — {{ number_format($g->pivot_price ?? 0, 0, ',', ' ') }}
                        @if($g->pricing_type) ({{ str_replace('_',' ', $g->pricing_type) }}) @endif
                    </option>
                    @endforeach
                @endif
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Note (optionnel)</label>
                <input type="text" name="note" class="form-control" placeholder="Ex: préfère matin">
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-primary" {{ $eligibleGuides->isEmpty() ? 'disabled' : '' }}>
                Assigner le guide
                </button>
            </div>
            </form>

            @if($eligibleGuides->isEmpty())
            <div class="small text-muted mt-2">
                Aucun guide actif/approuvé pour ce lieu. Attache d’abord des guides au lieu via <em>Guides → Lieux d’intervention</em>.
            </div>
            @endif
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="card mb-3">
        <div class="card-header"><h6 class="mb-0">Actions</h6></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.bookings.status',$b) }}">
            @csrf
            <label class="form-label">Statut réservation</label>
            <div class="d-flex gap-2">
                <select name="status" class="form-select">
                @foreach($statusLabels as $code=>$lab)
                    <option value="{{ $code }}" @selected($b->status===$code)>{{ ucfirst(str_replace('_',' ',$lab)) }}</option>
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
            <div>Type : {{ $b->bookable_type_label }}</div>
            <div>ID   : {{ $b->bookable_id }}</div>

            @if($b->bookable_type === \App\Models\Room::class && $b->bookable)
                <hr class="my-2">
                <div>
                    Hôtel :
                    @if(Route::has('admin.hotels.show') && $b->hotel)
                    <a href="{{ route('admin.hotels.show', $b->hotel) }}">{{ $b->hotel->name }}</a>
                    @else
                    {{ $b->hotel?->name ?? '—' }}
                    @endif
                </div>
                <div>
                    Chambre :
                    @if(Route::has('admin.rooms.show'))
                    <a href="{{ route('admin.rooms.show', $b->bookable) }}">{{ $b->bookable->name }}</a>
                    @else
                    {{ $b->bookable->name }}
                    @endif
                </div>
            @else
                {{-- Fallback générique si ce n'est pas une Room --}}
                @if($b->bookable)
                    <div>Nom : {{ $b->bookable_name }}</div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
