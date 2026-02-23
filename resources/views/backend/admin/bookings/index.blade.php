@extends('backend.admin.layouts.master')
@section('title','Réservations')
@section('content')


<div class="row">
    <!-- Total des Réservations -->
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-primary-transparent border border-primary d-flex align-items-center justify-content-center">
                                <i class="ti ti-calendar-stats text-primary fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Total</p>
                            <h4>{{ $kpis['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Réservations Confirmées -->
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-check text-success fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Confirmées</p>
                            <h4>{{ $kpis['confirmed'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Réservations en Attente -->
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-warning-transparent border border-warning d-flex align-items-center justify-content-center">
                                <i class="ti ti-clock text-warning fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">En attente</p>
                            <h4>{{ $kpis['pending'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Réservations Annulées -->
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-danger-transparent border border-danger d-flex align-items-center justify-content-center">
                                <i class="ti ti-ban text-danger fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1 text-gray-5">Annulées</p>
                            <h4>{{ $kpis['cancelled'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Filtres --}}
<div class="card mb-3">
  <form class="card-body row g-3">
    <div class="col-md-3"><input name="q" value="{{ $filters['q'] }}" class="form-control" placeholder="Réf / client / paiement"></div>
    <div class="col-md-2">
      <select name="status" class="form-select">
        <option value="">— Statut —</option>
        @foreach($statusLabels as $code=>$lab)
          <option value="{{ $code }}" @selected((string)$filters['status']===(string)$code)>{{ ucfirst(str_replace('_',' ',$lab)) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <select name="payment_status" class="form-select">
        <option value="">— Paiement —</option>
        @foreach($paymentLabels as $code=>$lab)
          <option value="{{ $code }}" @selected((string)$filters['pay']===(string)$code)>{{ ucfirst(str_replace('_',' ',$lab)) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2"><input type="date" name="from" value="{{ $filters['from'] }}" class="form-control" placeholder="du"></div>
    <div class="col-md-2"><input type="date" name="to"   value="{{ $filters['to'] }}" class="form-control" placeholder="au"></div>
    <div class="col-md-1 d-grid"><button class="btn btn-primary">Filtrer</button></div>
  </form>
</div>

{{-- Liste --}}
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
                $nights = $b->check_in && $b->check_out ? $b->check_in->diffInDays($b->check_out) : null;
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
            <td><a class="fw-semibold" href="{{ route('admin.bookings.show',$b) }}">{{ $b->reference ?? '—' }}</a></td>
            <td>
              @if($b->client)
                <div class="fw-semibold">{{ $b->client_name }}</div>
                <div class="text-muted small">{{ $b->client_email }}</div>
              @else
                —
              @endif
            </td>
            <td>
                <div class="fw-semibold">{{ $b->bookable_type_label }}</div>
                <div class="text-muted">{{ Str::limit($b->bookable_name, 15) }}</div>
                {{-- <div class="small text-gray-500">#{{ $b->bookable_id }}</div> --}}
            </td>

            
            <td>
              <div class="small">{{ $b->check_in?->format('d/m/Y H:i') }} → {{ $b->check_out?->format('d/m/Y H:i') }}</div>
              {{-- <div class="text-muted small">{{ $nights !== null ? $nights.' nuit(s)' : '—' }}</div> --}}
            </td>
            <td>{{ (int)$b->guests }} {{ $b->is_group ? ' (gr.)' : '' }}</td>
            <td class="fw-semibold">{{ number_format($b->amount ?? 0, 0, ' ', ' ') }}</td>
            <td><span class="badge {{ $payClass }}">{{ ucfirst(str_replace('_',' ', $paymentLabels[$b->payment_status] ?? '')) }}</span></td>
            <td><span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_',' ', $statusLabels[$b->status] ?? '')) }}</span></td>
            <td class="text-muted small">{{ $b->created_at?->format('d/m/Y H:i') }}</td>
            <td class="text-nowrap">
              <a href="{{ route('admin.bookings.show',$b) }}" class="btn btn-sm btn-outline-primary">Voir</a>
            </td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center text-muted py-4">Aucune réservation.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
    <div class="card-footer">
        {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
