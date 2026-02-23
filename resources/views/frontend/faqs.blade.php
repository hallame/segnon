@extends('frontend.layouts.master')
@section('title') Foire aux questions — FAQ @endsection

@section('content')
@php
  $currentCat = (string)request('category_id', '');
  $q          = (string)request('q', '');
@endphp

{{-- HERO --}}
<section class="relative overflow-hidden text-white">
  {{-- Mesh gradient + halos + dot grid --}}
  <div class="relative isolate bg-[radial-gradient(1200px_600px_at_20%_-10%,#7bd88f_0%,#2e7d32_35%,#0b3d2e_70%,#07251c_100%)]">
    {{-- halos animés --}}
    <div aria-hidden="true" class="pointer-events-none absolute -top-24 -left-16 w-[42rem] h-[42rem] rounded-full bg-emerald-400/20 blur-3xl animate-pulse"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-28 -right-20 w-[34rem] h-[34rem] rounded-full bg-lime-300/20 blur-3xl animate-pulse [animation-duration:4s]"></div>

    {{-- grille de points --}}
    <div aria-hidden="true" class="absolute inset-0 opacity-[0.18] mix-blend-soft-light"
         style="background-image: radial-gradient(currentColor 1px, transparent 1px);
                background-size: 22px 22px;">
    </div>

    <div class="max-w-7xl mx-auto px-6 pt-5 pb-10 relative">
      {{-- breadcrumb --}}
      <nav class="text-white/80 text-sm mb-4">
        <a href="{{ url('/') }}" class="hover:underline">Accueil</a>
        <span class="mx-2">/</span>
        <span>FAQs</span>
      </nav>

      {{-- titre + badge --}}
      <div class="max-w-3xl">
        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 ring-1 ring-white/20 px-3 py-1 text-[11px] tracking-wider uppercase">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Centre d’aide
        </span>

        <h1 class="mt-3 text-3xl md:text-5xl font-extrabold tracking-tight leading-tight">
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-white via-emerald-100 to-emerald-300">
            Foire aux questions
          </span>
        </h1>
        <p class="mt-3 text-white/85 max-w-2xl">
          Les réponses essentielles pour bien démarrer avec Zaly.
        </p>
      </div>

      {{-- carte recherche (glass) --}}
      <form method="get" action="{{ route('faqs.index') }}"
            class="mt-8 rounded-2xl bg-white/10 backdrop-blur-md ring-1 ring-white/20 shadow-2xl">
        <div class="p-4 md:p-5 flex flex-col md:flex-row gap-3 md:items-center">
          {{-- search --}}
          <div class="flex-1">
            <label for="q" class="sr-only">Rechercher</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-white/75" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="m21 21-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              <input id="q" name="q" type="search" value="{{ $q ?? '' }}"
                     class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white/40 focus:ring-0 placeholder-white/70 text-white ps-11 pe-4 py-3"
                     placeholder="Rechercher une question…">
            </div>
          </div>

          {{-- catégorie --}}
          <div class="md:w-64">
            <label for="category_id" class="sr-only">Catégorie</label>
            <select id="category_id" name="category_id"
                    class="w-full rounded-xl bg-white text-[#1f3321] border border-white/20 px-4 py-3">
              <option value="">Toutes les catégories</option>
              @if(!empty($categories))
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" @selected(($currentCat ?? '') === (string)$cat->id)>{{ $cat->name }}</option>
                @endforeach
              @endif
            </select>
          </div>

          {{-- actions --}}
          <div class="flex gap-2">
            <button class="rounded-xl bg-white text-[#1f3321] font-semibold px-5 py-3 hover:opacity-90 transition">
              Filtrer
            </button>
            @if(($q ?? null) || ($currentCat ?? null))
              <a href="{{ route('faqs.index') }}"
                 class="rounded-xl border border-white/30 px-4 py-3 text-white/90 hover:bg-white/10 transition">
                Réinitialiser
              </a>
            @endif
          </div>
        </div>

        {{-- chips catégories (scrollable) --}}
        @if(!empty($categories) && $categories->count())
        <div class="px-4 md:px-5 pb-4">
          <div class="flex gap-2 overflow-x-auto scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
            <a href="{{ route('faqs.index', array_filter(['q' => ($q ?? '') ?: null])) }}"
               class="px-3 py-1.5 rounded-full text-xs border
                      {{ empty($currentCat) ? 'bg-white text-[#1f3321] border-white' : 'border-white/30 text-white/85 hover:bg-white/10' }}">
              Toutes
            </a>
            @foreach($categories as $cat)
              <a href="{{ route('faqs.index', array_filter(['q' => ($q ?? '') ?: null, 'category_id' => $cat->id])) }}"
                 class="px-3 py-1.5 rounded-full text-xs border
                        {{ ($currentCat ?? '') === (string)$cat->id ? 'bg-white text-[#1f3321] border-white' : 'border-white/30 text-white/85 hover:bg-white/10' }}">
                {{ $cat->name }}
              </a>
            @endforeach
          </div>
        </div>
        @endif
      </form>
    </div>

    {{-- vague de séparation (plus fine) --}}
    <div class="absolute inset-x-0 -bottom-px">
      <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full h-[40px] md:h-[47px] text-white">
        <path fill="currentColor" d="M0,64L80,69.3C160,75,320,85,480,85.3C640,85,800,75,960,69.3C1120,64,1280,64,1360,69.3L1440,75L1440,0L0,0Z"/>
      </svg>
    </div>
  </div>
</section>


{{-- Chips catégories (optionnelles) --}}
@if($categories->count())
  <div class="max-w-7xl mx-auto px-6 -mt-6 mb-6">
    <div class="flex flex-wrap gap-2">
      <a href="{{ route('faqs.index', array_filter(['q' => $q ?: null])) }}"
         class="px-3 py-1.5 rounded-full text-sm border {{ $currentCat==='' ? 'bg-[#579459] text-white border-[#579459]' : 'border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
        Toutes
      </a>
      @foreach($categories as $cat)
        <a href="{{ route('faqs.index', array_filter(['q' => $q ?: null, 'category_id' => $cat->id])) }}"
           class="px-3 py-1.5 rounded-full text-sm border
                  {{ $currentCat === (string)$cat->id ? 'bg-[#579459] text-white border-[#579459]' : 'border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
          {{ $cat->name }}
        </a>
      @endforeach
    </div>
  </div>
@endif

{{-- Résultats --}}
<section class="py-10">
  <div class="max-w-7xl mx-auto px-6">
    @if($faqs->count())
      <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-zinc-600">
          {{ $faqs->total() }} résultat{{ $faqs->total() > 1 ? 's' : '' }}
          @if($q) pour « <span class="font-medium">{{ $q }}</span> » @endif
          @if($currentCat && ($cat = $categories->firstWhere('id', (int)$currentCat)))
            dans « <span class="font-medium">{{ $cat->name }}</span> »
          @endif
        </p>
        <a href="{{ route('contact') }}" class="hidden md:inline-flex items-center gap-2 rounded-xl border border-[#579459]/30 px-4 py-2 font-medium text-[#579459] hover:text-white hover:bg-[#579459] transition">
          Poser une question
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($faqs as $i => $f)
          <details class="group rounded-2xl p-5 bg-white ring-1 ring-zinc-200/80 hover:ring-[#579459]/30 hover:shadow-xl transition" {{ $i === 0 ? 'open' : '' }}>
            <summary class="flex items-start justify-between gap-4 cursor-pointer list-none">
              <span class="font-semibold leading-snug">{{ $f->question }}</span>
              <svg class="w-5 h-5 mt-1 shrink-0 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.085l3.71-3.855a.75.75 0 011.08 1.04l-4.24 4.4a.75.75 0 01-1.08 0l-4.24-4.4a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
              </svg>
            </summary>
            <div class="mt-3 text-[15px] leading-relaxed text-zinc-600">
              {!! nl2br(e($f->answer)) !!}
            </div>
          </details>
        @endforeach
      </div>

      {{-- Pagination --}}
      <div class="mt-8">
        {{ $faqs->onEachSide(1)->links() }}
      </div>

      {{-- CTA mobile --}}
      <div class="mt-6 md:hidden">
        <a href="{{ route('contact') }}" class="block w-full text-center rounded-xl border border-[#579459]/30 px-4 py-3 font-medium text-[#579459] hover:text-white hover:bg-[#579459] transition">
          Poser une question
        </a>
      </div>
    @else
      <div class="rounded-2xl border border-dashed border-zinc-300 p-10 text-center">
        <p class="text-zinc-700 font-medium">Aucun résultat.</p>
        <p class="text-zinc-500 mt-1">Essayez un autre mot-clé ou réinitialisez les filtres.</p>
        <div class="mt-4 flex items-center justify-center gap-3">
          <a href="{{ route('faqs.index') }}" class="rounded-xl border px-4 py-2 text-zinc-700 hover:bg-zinc-50">Réinitialiser</a>
          <a href="{{ route('contact') }}" class="rounded-xl bg-[#579459] text-white px-4 py-2 hover:opacity-90">Poser une question</a>
        </div>
      </div>
    @endif
  </div>
</section>


{{-- JSON-LD SEO (FAQPage) basé sur la page courante --}}
  @php
    $faqLd = [
      '@context'   => 'https://schema.org',
      '@type'      => 'FAQPage',
      'mainEntity' => $faqs->getCollection()->map(function($f){
        return [
          '@type'          => 'Question',
          'name'           => $f->question,
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => trim(preg_replace('/\s+/', ' ', strip_tags($f->answer))),
          ],
        ];
      })->values()->all(),
    ];
  @endphp
  <script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

@endsection

