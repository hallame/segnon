@extends('backend.partners.layouts.master')
@section('title','Mes réservations')

@section('content')

<div class="row">
  <div class="col-xl-3 col-md-6 d-flex"><div class="card flex-fill"><div class="card-body">
    <div class="d-flex align-items-center"><span class="p-2 br-10 bg-primary-transparent border border-primary me-2"><i class="ti ti-calendar-stats text-primary fs-18"></i></span>
      <div><p class="fs-12 text-gray-5 mb-1">Total</p><h4>{{ $kpis['total'] }}</h4></div>
    </div>
  </div></div></div>

  <div class="col-xl-3 col-md-6 d-flex"><div class="card flex-fill"><div class="card-body">
    <div class="d-flex align-items-center"><span class="p-2 br-10 bg-info-transparent border border-info me-2"><i class="ti ti-checkup-list text-info fs-18"></i></span>
      <div><p class="fs-12 text-gray-5 mb-1">Confirmées</p><h4>{{ $kpis['confirmed'] }}</h4></div>
    </div>
  </div></div></div>

  <div class="col-xl-3 col-md-6 d-flex"><div class="card flex-fill"><div class="card-body">
    <div class="d-flex align-items-center"><span class="p-2 br-10 bg-warning-transparent border border-warning me-2"><i class="ti ti-clock text-warning fs-18"></i></span>
      <div><p class="fs-12 text-gray-5 mb-1">En attente</p><h4>{{ $kpis['pending'] }}</h4></div>
    </div>
  </div></div></div>

  <div class="col-xl-3 col-md-6 d-flex"><div class="card flex-fill"><div class="card-body">
    <div class="d-flex align-items-center"><span class="p-2 br-10 bg-success-transparent border border-success me-2"><i class="ti ti-currency-dollar text-success fs-18"></i></span>
      <div><p class="fs-12 text-gray-5 mb-1">Revenus ({{ $currency }})</p><h4>{{ number_format($kpis['revenue'] ?? 0, 0, ' ', ' ') }}</h4></div>
    </div>
  </div></div></div>
</div>

<div class="card mb-3">
  <form class="card-body row g-3">
    <div class="col-md-3"><input name="q" value="{{ $filters['q'] }}" class="form-control" placeholder="Réf / client / paiement"></div>
    <div class="col-md-2">
      <select name="status" class="form-select">
        <option value="">— Statut —</option>
        @foreach($statusLabels as $code=>$lab)
          <option value="{{ $code }}" @selected((string)$filters['status']===(string)$code)>{{ $lab }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <select name="payment_status" class="form-select">
        <option value="">— Paiement —</option>
        @foreach($paymentLabels as $code=>$lab)
          <option value="{{ $code }}" @selected((string)$filters['pay']===(string)$code)>{{ $lab }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2"><input type="date" name="from" value="{{ $filters['from'] }}" class="form-control"></div>
    <div class="col-md-2"><input type="date" name="to"   value="{{ $filters['to'] }}" class="form-control"></div>
    <div class="col-md-1 d-grid"><button class="btn btn-primary">Filtrer</button></div>
  </form>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>Réf</th>
          <th>Client</th>
          <th>Type</th>
          <th>Dates</th>
          <th>Pers.</th>
          <th>Montant ({{ $currency }})</th>
          <th>Paiement</th>
          <th>Statut</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($bookings as $b)
        @php
          $statusClass = [
            \App\Models\Booking::STATUS_PENDING   => 'bg-warning text-dark',
            \App\Models\Booking::STATUS_CONFIRMED => 'bg-info',
            \App\Models\Booking::STATUS_CANCELLED => 'bg-danger',
            \App\Models\Booking::STATUS_COMPLETED => 'bg-success',
          ][$b->status] ?? 'bg-light text-dark';

          $payClass = [
            \App\Models\Booking::PAY_UNPAID         => 'bg-secondary',
            \App\Models\Booking::PAY_AWAITING_VERIF => 'bg-warning text-dark',
            \App\Models\Booking::PAY_VERIFIED       => 'bg-success',
            \App\Models\Booking::PAY_REJECTED       => 'bg-danger',
          ][$b->payment_status] ?? 'bg-light text-dark';
        @endphp
        <tr>
          <td><a href="{{ route('partners.bookings.show',$b) }}" class="fw-semibold">{{ $b->reference ?? '—' }}</a></td>
          <td>
            @if($b->client)
              <div class="fw-semibold">{{ $b->client_name }}</div>
              <div class="text-muted small">{{ $b->client_email }}</div>
            @else — @endif
          </td>
          <td>
            <div class="fw-semibold">{{ $b->bookable_type_label }}</div>
            <div class="text-muted small">{{ Str::limit($b->bookable_name, 18) }}</div>
          </td>
          <td class="small">{{ $b->check_in?->format('d/m/Y H:i') }} → {{ $b->check_out?->format('d/m/Y H:i') }}</td>
          <td>{{ (int)$b->guests }}{{ $b->is_group ? ' (gr.)' : '' }}</td>
          <td class="fw-semibold">{{ number_format($b->amount ?? 0, 0, ' ', ' ') }}</td>
          <td><span class="badge {{ $payClass }}">{{ $paymentLabels[$b->payment_status] ?? '' }}</span></td>
          <td><span class="badge {{ $statusClass }}">{{ $statusLabels[$b->status] ?? '' }}</span></td>
          <td class="text-muted small">{{ $b->created_at?->format('d/m/Y H:i') }}</td>
          <td class="text-nowrap"><a href="{{ route('partners.bookings.show',$b) }}" class="btn btn-sm btn-outline-primary">Voir</a></td>
        </tr>
      @empty
        <tr><td colspan="10" class="text-center text-muted py-4">Aucune réservation.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
</div>

@endsection
