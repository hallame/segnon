@extends('frontend.layouts.master')
@section('title','Commande confirmée')

@php
  $fmt = fn($n) => number_format((float)$n, 0, ',', ' ') . ' ' . $currency;
@endphp

@section('content')
<div class="mx-auto max-w-2xl md:max-w-3xl px-4 sm:px-6 lg:px-8 py-5 ">

  {{-- Carte succès --}}
  <div class="relative overflow-hidden rounded-[28px] border bg-white shadow-sm">
    <div class="absolute inset-0 bg-gradient-to-tr from-emerald-50 via-white to-emerald-50 opacity-60"></div>
    <div class="relative p-6 sm:p-10">

      <div class="mx-auto flex w-14 h-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
        <svg viewBox="0 0 24 24" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>

      <h1 class="mt-4 text-center sm:text-left text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
        Merci, votre commande est confirmée !
      </h1>
      <p class="mt-2 text-center sm:text-left text-gray-600">
        Nous avons bien reçu votre commande. En cours de vérification...
      </p>

      {{-- Référence + copier --}}
      <div class="mt-4 w-full sm:w-auto inline-flex flex-wrap items-center justify-center sm:justify-start gap-2 rounded-full border bg-white px-3 py-1.5 text-sm">
        <span class="text-gray-600">Référence :</span>
        <strong id="orderRef" class="tracking-wide">{{ $order->reference }}</strong>
        <button type="button" onclick="copyRef()"
                class="rounded-full border px-2 py-0.5 text-xs hover:bg-gray-50"
                aria-label="Copier la référence">Copier</button>
      </div>

      {{-- Timeline compact --}}
      <ol class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm" aria-label="Progression de la commande">
        @php $steps = [['Panier',1],['Paiement',1],['Confirmation',1]]; @endphp
        @foreach($steps as [$label,$done])
          <li class="flex items-center gap-2">
            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full {{ $done ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-600' }}">✓</span>
            <span class="{{ $done ? 'text-gray-900 font-medium' : 'text-gray-600' }}">{{ $label }}</span>
          </li>
        @endforeach
      </ol>

      {{-- CTAs --}}
      <div class="mt-6 flex flex-col sm:flex-row sm:flex-wrap justify-between items-stretch sm:items-center gap-3">
        <a href="{{ route('shop.products.index') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-white font-semibold hover:bg-emerald-700">
          Continuer vos achats
        </a>

        <a href="{{ route('shop.orders.receipt', $order->reference) }}"
           class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl border px-4 py-3 font-semibold hover:bg-gray-50">
          Télécharger le reçu (PDF)
        </a>
      </div>

    </div>
  </div>

</div>

<script>
  function copyRef() {
    const el = document.getElementById('orderRef');
    if (!el) return;
    const t = (el.textContent || '').trim();
    if (!t) return;
    navigator.clipboard?.writeText(t).then(()=> {
      const btn = el.nextElementSibling;
      if (btn) { const old = btn.textContent; btn.textContent = 'Copié !'; setTimeout(()=> btn.textContent = old, 1500); }
    });
  }
</script>

@endsection
