@extends('frontend.layouts.master')
@section('title', 'Acheter un ticket — '.$event->name)

@php
    use Illuminate\Support\Str;
    $now = now();
@endphp

@section('content')
<section class="bg-slate-50/60">
    <div class="max-w-5xl mx-auto px-4 py-8 md:py-10">

        {{-- Header / résumé événement --}}
        <div class="mb-8">
            <a href="{{ route('events.show', $event) }}"
               class="inline-flex items-center gap-1 text-sm text-emerald-700 hover:text-emerald-900 mb-3">
                <i class="ri-arrow-left-line"></i> Retour à l’événement
            </a>

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-wide text-emerald-700 font-semibold">
                        Billetterie officielle
                    </p>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-zinc-900">
                        Acheter un billet — {{ $event->name }}
                    </h1>
                    <p class="text-sm text-zinc-600 mt-1">
                        Choisissez vos tickets, ajustez les quantités, puis continuez pour confirmer vos informations.
                    </p>
                </div>

                @if(!$eventEnded)
                    <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 text-emerald-700 text-xs px-3 py-1 border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Ventes ouvertes
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 rounded-full bg-rose-50 text-rose-700 text-xs px-3 py-1 border border-rose-100">
                        <i class="ri-calendar-close-line text-sm"></i>
                        Événement terminé
                    </div>
                @endif
            </div>

            @if($eventEnded)
                <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 flex items-center gap-2">
                    <i class="ri-error-warning-line text-lg"></i>
                    <span>Cet événement est terminé. L’achat de billets n’est plus possible.</span>
                </div>
            @endif
        </div>

        @if($types->isEmpty())
            <div class="rounded-2xl border border-zinc-200 bg-white px-4 py-6 text-center text-zinc-600 shadow-sm">
                Aucun ticket disponible pour le moment.
            </div>
        @else
            <form action="{{ route('events.reserve', $event) }}" method="POST" class="space-y-5">
                @csrf

                {{-- Liste des types de billets --}}
                <div class="space-y-4">
                    @foreach($types as $t)
                        @php
                            // Features
                            $features = $t->features;
                            if (is_string($features)) {
                                $decoded = json_decode($features, true);
                                $features = is_array($decoded)
                                    ? $decoded
                                    : (trim($features) !== '' ? [$features] : []);
                            }
                            if (!is_array($features)) $features = [];

                            // Fenêtre de vente
                            $canBuyWindow = true;
                            if ($t->sales_start && $now->lt($t->sales_start)) $canBuyWindow = false;
                            if ($t->sales_end   && $now->gt($t->sales_end))   $canBuyWindow = false;

                            // Tickets restants

                            $rawRemaining = $t->remaining_tickets_count; // vient de l’accessor
                            $remaining    = max(0, (int) $rawRemaining);
                            $maxPerOrder   = $t->max_per_order ?: 6;
                            $maxSelectable = min($remaining, $maxPerOrder);
                            $disabled      = $eventEnded || !$canBuyWindow || $remaining <= 0;
                        @endphp

                        <div class="rounded-2xl border border-zinc-200 bg-white/80 backdrop-blur-sm p-4 md:p-5 shadow-sm hover:shadow-md transition">
                            <div class="flex flex-col md:flex-row md:items-start gap-4">

                                {{-- Infos billet --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-lg font-bold text-zinc-900">
                                            {{ $t->name }}
                                        </h3>

                                        @if($t->is_refundable)
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold border border-emerald-100">
                                                Remboursable
                                            </span>
                                        @endif

                                        {{-- @if($t->max_per_order)
                                            <span class="px-2 py-0.5 rounded-full bg-zinc-100 text-zinc-700 text-[11px] border border-zinc-200">
                                                max {{ $t->max_per_order }} / commande
                                            </span>
                                        @endif --}}
                                    </div>

                                    @if($t->description)
                                        <p class="text-sm text-zinc-600 mt-1">
                                            {{ $t->description }}
                                        </p>
                                    @endif

                                    @if(!empty($features))
                                        <ul class="mt-2 grid gap-1.5 text-sm text-zinc-700">
                                            @foreach($features as $f)
                                                <li class="flex items-start gap-2">
                                                    <i class="ri-check-line text-emerald-600 mt-[2px]"></i>
                                                    <span>{{ $f }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">
                                        <span class="px-2 py-0.5 rounded-full border border-zinc-200 text-zinc-700 bg-white/60">
                                            Prix : <span class="font-semibold">{{ number_format($t->price, 0, ',', ' ') }} GNF</span>
                                        </span>

                                        <span class="px-2 py-0.5 rounded-full bg-zinc-50 border border-zinc-200 text-zinc-700">
                                            @if($remaining > 0 && $remaining < 9999)
                                                {{ $remaining }} ticket{{ $remaining > 1 ? 's' : '' }} restant{{ $remaining > 1 ? 's' : '' }}
                                            @elseif($remaining >= 9999)
                                                Disponibilité élevée
                                            @else
                                                Terminé
                                            @endif
                                        </span>

                                        @if($t->sales_start || $t->sales_end)
                                            <span class="px-2 py-0.5 rounded-full border border-amber-200 bg-amber-50 text-amber-700">
                                                Vente :
                                                {{ $t->sales_start ? $t->sales_start->format('d/m/Y H:i') : '—' }}
                                                →
                                                {{ $t->sales_end ? $t->sales_end->format('d/m/Y H:i') : '∞' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Bloc quantité / prix --}}
                                <div class="w-full md:w-60 md:border-l border-t md:border-t-0 border-zinc-100 md:pl-4 md:ml-2 pt-3 md:pt-0">
                                    <div class="text-right">
                                        <div class="text-xs uppercase tracking-wide text-zinc-500 mb-1">
                                            Prix unitaire
                                        </div>
                                        <div class="text-xl font-extrabold text-zinc-900">
                                            {{ number_format($t->price, 0, ',', ' ') }} GNF
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="flex items-center justify-between text-xs text-zinc-600 mb-1">
                                            <span>Quantité</span>
                                            @if($maxSelectable > 0 && !$eventEnded && $canBuyWindow)
                                                <span>max {{ $maxSelectable }}</span>
                                            @endif
                                        </div>

                                        <div class="inline-flex items-center rounded-full border border-zinc-200 overflow-hidden bg-zinc-50">
                                            <button type="button"
                                                    class="px-3 py-1 text-lg leading-none text-zinc-600 hover:bg-zinc-100 disabled:opacity-40"
                                                    onclick="changeQty('{{ $t->id }}', -1)"
                                                    @if($disabled) disabled @endif>
                                                –
                                            </button>
                                            <input
                                                type="number"
                                                inputmode="numeric"
                                                min="0"
                                                max="{{ $maxSelectable }}"
                                                value="0"
                                                class="w-14 text-center border-0 bg-transparent text-sm font-semibold text-zinc-900 focus:ring-0 focus:outline-none"
                                                name="lines[{{ $t->id }}][qty]"
                                                id="qty_{{ $t->id }}"
                                                @if($disabled) readonly @endif
                                            >
                                            <button type="button"
                                                    class="px-3 py-1 text-lg leading-none text-zinc-600 hover:bg-zinc-100 disabled:opacity-40"
                                                    onclick="changeQty('{{ $t->id }}', 1)"
                                                    @if($disabled) disabled @endif>
                                                +
                                            </button>
                                        </div>

                                        <input type="hidden" name="lines[{{ $t->id }}][ticket_type_id]" value="{{ $t->id }}">

                                        @if($disabled)
                                            <div class="mt-2 text-[11px] text-amber-700 bg-amber-50 border border-amber-200 rounded-xl px-2 py-1">
                                                @if($eventEnded)
                                                    Événement terminé.
                                                @elseif($remaining <= 0)
                                                    Ce type de billet est fini.
                                                @elseif(!$canBuyWindow)
                                                    Vente fermée pour ce type.
                                                @endif
                                            </div>
                                        @else
                                            {{-- <div class="mt-2 text-[11px] text-zinc-500">
                                                Laissez 0 si vous ne souhaitez pas ce type de billet.
                                            </div> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Erreurs générales --}}
                @if($errors->any())
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- CTA global --}}
                <div class="pt-5 border-t border-zinc-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 text-sm shadow-sm
                                   @if($eventEnded) opacity-60 cursor-not-allowed @endif"
                            @if($eventEnded) disabled @endif>
                        <i class="ri-arrow-right-circle-line text-lg"></i>
                        <span>Continuer</span>
                    </button>
                </div>
            </form>
        @endif
    </div>
</section>

<script>
    function changeQty(id, delta) {
        const input = document.getElementById('qty_' + id);
        if (!input || input.readOnly) return;
        const max = parseInt(input.max || '999', 10);
        const min = parseInt(input.min || '0', 10);
        let val = parseInt(input.value || '0', 10);
        if (isNaN(val)) val = 0;
        val = val + delta;
        if (val < min) val = min;
        if (val > max) val = max;
        input.value = val;
    }
</script>
@endsection
