@extends('backend.partners.layouts.master')
@section('title','Commande '.$order->reference)
@section('content')

<div class="mb-2">
  <a href="{{ route('partners.orders.index') }}" class="btn btn-sm btn-light">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="row g-3">
  <div class="col-lg-8">
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
            <h5 class="mb-1">Commande #{{ $order->reference }}</h5>
            <div class="text-muted small">{{ $order->created_at?->format('d/m/Y H:i') }}</div>
          </div>
          @php
            $cls = [
              \App\Models\Order::STATUS_PENDING      => 'bg-warning text-dark',
              \App\Models\Order::STATUS_UNDER_REVIEW => 'bg-info',
              \App\Models\Order::STATUS_PAID         => 'bg-success',
              \App\Models\Order::STATUS_REJECTED     => 'bg-secondary',
              \App\Models\Order::STATUS_CANCELLED    => 'bg-danger',
              \App\Models\Order::STATUS_FULFILLED    => 'bg-primary',
            ][$order->status] ?? 'bg-light text-dark';
          @endphp
          <span class="badge {{ $cls }}">{{ ucfirst(str_replace('_',' ',$order->status_label)) }}</span>
        </div>

        <hr>

        <div class="row g-3">
          <div class="col-md-6">
            <h6 class="fw-bold">Client</h6>
            <div class="text-muted">{{ $order->customer_firstname }} {{ $order->customer_lastname }}</div>
            <div class="text-muted">{{ $order->customer_email }}</div>
            @if($order->customer_phone)<div class="text-muted">{{ $order->customer_phone }}</div>@endif
          </div>
          <div class="col-md-6">
            <h6 class="fw-bold">Récapitulatif</h6>
            <div class="d-flex justify-content-between"><span>Sous-total</span><span>{{ number_format($order->subtotal,0,' ',' ') }} {{ $order->currency }}</span></div>
            <div class="d-flex justify-content-between"><span>Remise</span><span>-{{ number_format($order->discount,0,' ',' ') }} {{ $order->currency }}</span></div>
            <div class="d-flex justify-content-between"><span>Livraison</span><span>{{ number_format($order->shipping,0,' ',' ') }} {{ $order->currency }}</span></div>
            <div class="d-flex justify-content-between"><span>Taxes</span><span>{{ number_format($order->tax,0,' ',' ') }} {{ $order->currency }}</span></div>
            <div class="d-flex justify-content-between fw-bold"><span>Total</span><span>{{ number_format($order->total,0,' ',' ') }} {{ $order->currency }}</span></div>
          </div>
        </div>

        @if(!empty($order->shipping_address))
          <hr>
          <h6 class="fw-bold">Adresse de livraison</h6>
          @php $addr = $order->shipping_address; @endphp
          <div class="text-muted">
            {{ $addr['line1'] ?? '' }} {{ $addr['line2'] ?? '' }}<br>
            {{ $addr['city'] ?? '' }} {{ $addr['postal_code'] ?? '' }}<br>
            {{ $addr['country'] ?? '' }}
          </div>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h6 class="mb-0">Articles</h6></div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead><tr><th>Article</th><th>Attributs</th><th class="text-end">Prix</th><th class="text-center">Qté</th><th class="text-end">Total</th></tr></thead>
          <tbody>
            @foreach($order->items as $it)
              <tr>
                <td>{{ $it->product_name }}</td>
                <td class="text-muted small">
                  @if(!empty($it->sku_attributes))
                    @foreach($it->sku_attributes as $k=>$v)
                      <span class="me-2">{{ $k }}: <strong>{{ $v }}</strong></span>
                    @endforeach
                  @else
                    —
                  @endif
                </td>
                <td class="text-end">{{ number_format($it->unit_price,0,' ',' ') }} {{ $order->currency }}</td>
                <td class="text-center">{{ (int)$it->qty }}</td>
                <td class="text-end fw-semibold">{{ number_format($it->vendorTotal,0,' ',' ') }} {{ $order->currency }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <div class="col-lg-4">
    <div class="card mb-3">
      <div class="card-header"><h6 class="mb-0">Actions</h6></div>
      <div class="card-body">
        <form method="POST" action="{{ route('partners.orders.status',$order) }}">
          @csrf
          <label class="form-label">Changer le statut</label>
          <div class="d-flex gap-2">
            <select name="status" class="form-select">
              @foreach($allowedNext as $code)
                <option value="{{ $code }}">{{ ucfirst(str_replace('_',' ',$statusLabels[$code])) }}</option>
              @endforeach
            </select>
            <button class="btn btn-primary" {{ empty($allowedNext) ? 'disabled' : '' }}>Mettre à jour</button>
          </div>
          <input type="text" name="note" class="form-control mt-2" placeholder="Note interne (optionnel)">
        </form>

        @if($order->note)
          <hr>
          <pre class="small mb-0" style="white-space:pre-wrap">{{ $order->note }}</pre>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h6 class="mb-0">Infos</h6></div>
      <div class="card-body small text-muted">
        <div>Référence : {{ $order->reference }}</div>
        <div>Devise : {{ $order->currency }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
