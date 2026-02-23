@extends('backend.admin.layouts.master')
@section('title','Commandes')
@section('content')


{{-- Bandeau Stats --}}
<div class="row mb-3">
  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-primary-transparent border border-primary me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-package fs-18 text-primary"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Total</p>
            <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-info-transparent border border-info me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-box fs-18 text-info"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Non Payées</p>
            <h4 class="mb-0">{{ $stats['pending'] ?? 0 }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">

          <span class="p-2 br-10 bg-success-transparent border border-success me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-circle-check fs-18 text-success"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Payées</p>
            <h4 class="mb-0">{{ $stats['paid'] ?? 0 }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">

           <span class="p-2 br-10 bg-warning-transparent border border-warning me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-clock fs-18 text-warning"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Vérification</p>
            <h4 class="mb-0">{{ $stats['under_review'] }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Filtres --}}
<div class="card mb-3">
  <form class="card-body row g-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Réf / nom / email / téléphone"></div>
    <div class="col-md-2">
      <select name="status" class="form-select">
        <option value="">— Statut —</option>
        @foreach(\App\Models\Order::$statusLabels as $code=>$label)
          <option value="{{ $code }}" @selected((string)$status === (string)$code)>{{ ucfirst(str_replace('_',' ', $label)) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2"><input type="date" name="from" value="{{ $from }}" class="form-control"></div>
    <div class="col-md-2"><input type="date" name="to"   value="{{ $to   }}" class="form-control"></div>
    <div class="col-md-2 text-end"><button class="btn btn-primary w-100">Filtrer</button></div>
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
          <th>Total ({{ $currency }})</th>
          <th>Statut</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $o)
          @php
            $statusMap = [
              \App\Models\Order::STATUS_PENDING      => 'bg-warning text-dark',
              \App\Models\Order::STATUS_UNDER_REVIEW => 'bg-info',
              \App\Models\Order::STATUS_PAID         => 'bg-success',
              \App\Models\Order::STATUS_REJECTED     => 'bg-secondary',
              \App\Models\Order::STATUS_CANCELLED    => 'bg-danger',
              \App\Models\Order::STATUS_FULFILLED    => 'bg-primary',
            ];
            $cls = $statusMap[$o->status] ?? 'bg-light text-dark';
          @endphp
          <tr>
            <td><a href="{{ route('admin.orders.show',$o) }}" class="fw-semibold">{{ $o->reference }}</a></td>
            <td>
              <div class="fw-semibold">{{ $o->customer_firstname }} {{ $o->customer_lastname }}</div>
              <div class="text-muted small">{{ $o->customer_email }}</div>
            </td>
            <td class="fw-semibold">{{ number_format($o->total, 0, ' ', ' ') }}</td>
            <td><span class="badge {{ $cls }}">{{ ucfirst(str_replace('_',' ',$o->status_label)) }}</span></td>
            <td class="text-muted">{{ $o->created_at?->format('d/m/Y H:i') }}</td>
            <td class="text-nowrap">
              <a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-outline-primary">Voir</a>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Aucune commande.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
</div>
@endsection
