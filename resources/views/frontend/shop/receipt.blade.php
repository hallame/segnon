@php
  $S = function ($v) {
    if ($v instanceof \Stringable) return (string)$v;
    return is_array($v) ? implode(', ', array_filter($v)) : (string)($v ?? '');
  };
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Reçu — {{ $order->reference }}</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <style>
    /* DOMPDF-friendly styles (pas de flex, pas de position:fixed) */
    :root { --border:#E5E7EB; --text:#111827; --muted:#6B7280; --emerald:#059669; --amber:#B45309; }
    * { box-sizing: border-box; }
    body {
      font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
      font-size: 12px; color: var(--text); margin: 0; padding: 24px;
      -webkit-print-color-adjust: exact; color-adjust: exact;
    }
    .wrap { max-width: 800px; margin: 0 auto; }
    .card { border: 1px solid var(--border); border-radius: 16px; padding: 20px; }

    .row { width: 100%; }
    .row:after { content:""; display:block; clear:both; }
    .col-6 { float:left; width: 50%; }
    .col-4 { float:left; width: 33.3333%; }
    .col-8 { float:left; width: 66.6667%; }

    h1,h2,h3 { margin: 0; }
    h1 { font-size: 20px; }
    .muted { color: var(--muted); }
    .mb-1{ margin-bottom: 4px;} .mb-2{ margin-bottom: 8px;} .mb-3{ margin-bottom: 12px;} .mb-4{ margin-bottom: 16px;}
    .mt-1{ margin-top: 4px;} .mt-2{ margin-top: 8px;} .mt-3{ margin-top: 12px;} .mt-4{ margin-top: 16px;}

    .badge {
      display: inline-block; padding: 4px 8px; border-radius: 999px; font-weight: 700; font-size: 11px;
    }
    .badge-paid { background:#D1FAE5; color:#064E3B; }
    .badge-pending { background:#FEF3C7; color:#7C2D12; }

    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; vertical-align: top; }
    thead th { text-align: left; font-size: 12px; border-bottom: 1px solid var(--border); }
    tbody td { border-bottom: 1px solid var(--border); }
    tfoot td { padding: 6px 10px; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .small { font-size: 11px; }
    .strong { font-weight: 700; }

    .box {
      border:1px solid var(--border); border-radius:10px; padding:10px;
      background: #fff;
    }
  </style>
</head>
<body>
@php
  $fmt = fn($n) => number_format((float)$n, 0, ',', ' ') . ' ' . $currency;
  $subtotal = $order->items->sum('total_price');
  $shipping = (float)($order->shipping_total ?? 0);
  $tax      = (float)($order->tax_total ?? 0);
  $total    = (float)($order->total ?? ($subtotal + $shipping + $tax));
  $paid = isset($isPaid) ? (bool)$isPaid : $order->payments->where('status',1)->isNotEmpty();
  $latestPayment = $order->payments->sortByDesc('id')->first();
@endphp

<div class="wrap">
  {{-- En-tête --}}
  <div class="card mb-4">
    <div class="row">
      <div class="col-8">
        <h1>{{ config('app.name') }}</h1>

        <div class="mt-3">
          <div class="mb-1"><span class="muted">Commande :</span> <span class="strong">{{ $order->reference }}</span></div>
          <div class="mb-1"><span class="muted">Date :</span> {{ optional($order->created_at)->format('d/m/Y H:i') }}</div>
          <div class="mb-1">
            @if($paid)
              <span class="badge badge-paid">PAYÉE</span>
            @else
              <span class="badge badge-pending">EN ATTENTE DE VÉRIFICATION</span>
            @endif
          </div>
        </div>
      </div>

      <div class="col-4">
        <div class="box text-center">
          <div class="small muted mb-2">Scannez pour revenir à la boutique</div>

          @if(!empty($qrPng))
            <img src="data:image/png;base64,{{ $qrPng }}" alt="QR" width="100" height="100">
            @endif
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-6">
        <div class="box">
          <div class="strong mb-1">Coordonnées</div>
          <div class="small">
            @if(!empty($order->customer_name)) <div>{{ $S($order->customer_firstname) }}</div> @endif
            @if(!empty($order->customer_name)) <div>{{ $S($order->customer_lastname) }}</div> @endif
            @if(!empty($order->customer_email)) <div>{{ $S($order->customer_email) }}</div> @endif
            @if(!empty($order->customer_phone)) <div>{{ $S($order->customer_phone) }}</div> @endif
            @if(!empty($order->shipping_address))
                <div class="mt-1">{{ $S($order->shipping_address) }}</div>
            @endif
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="box">
          <div class="strong mb-1">Paiement</div>
          <div class="small">
            <div>Méthode :
              <span class="strong">
                {{ $latestPayment?->method?->name ?? '—' }}
              </span>
            </div>
            <div>Réf. paiement :
              <span class="strong">{{ $latestPayment?->reference ?? '—' }}</span>
            </div>
            @if(!empty($latestPayment?->transaction_number))
              <div>N° transaction : {{ $latestPayment->transaction_number }}</div>
            @endif
            <div>Montant :
              <span class="strong">{{ $fmt($total) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Détail des articles --}}
  <div class="card mb-4">
    <table>
      <thead>
        <tr>
          <th>Article</th>
          <th class="text-center">Qté</th>
          <th class="text-right">Prix unitaire</th>
          <th class="text-right">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $it)
          @php
            $qty = max(1, (int)$it->qty);
            $unit = (float)$it->total_price / $qty;
            $attrs = '';
            if (!empty($it->sku?->attributes) && is_iterable($it->sku->attributes)) {
              $parts = [];
              foreach ($it->sku->attributes as $k => $v) { $parts[] = ucfirst($k).': '.$v; }
              $attrs = implode(' • ', $parts);
            }
          @endphp
          <tr>
            <td>
                <div class="strong">{{ $S($it->product?->name ?? 'Produit') }}</div>
                    @if($attrs)<div class="small muted">{{ $attrs }}</div>@endif
            </td>
            <td class="text-center">{{ $qty }}</td>
            <td class="text-right">{{ $fmt($unit) }}</td>
            <td class="text-right">{{ $fmt($it->total_price) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td class="text-right muted">Sous-total</td>
          <td class="text-right strong">{{ $fmt($subtotal) }}</td>
        </tr>
        {{-- <tr>
          <td colspan="2"></td>
          <td class="text-right muted">Livraison</td>
          <td class="text-right">{{ $fmt($shipping) }}</td>
        </tr> --}}
        <tr>
          <td colspan="2"></td>
          <td class="text-right muted">Taxes</td>
          <td class="text-right">{{ $fmt($tax) }}</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td class="text-right strong">Total</td>
          <td class="text-right strong">{{ $fmt($total) }}</td>
        </tr>
      </tfoot>
    </table>
  </div>

  {{-- Mentions --}}
  <div class="small muted">
    <div>Merci pour votre confiance !</div>
    <div class="mt-1">Besoin d’aide ? Contactez-nous : {{ $supportEmail }}</div>
  </div>
</div>
</body>
</html>
