@if(isset($faqs) && $faqs->count())
<section class="bg-[#f8faf9] text-[#1f3321] py-14" itemscope itemtype="https://schema.org/FAQPage">
  <div class="max-w-7xl mx-auto px-6">
    <div class="max-w-3xl mb-8">
      <p class="text-sm uppercase tracking-widest text-zinc-500">Questions fréquentes</p>
      <h2 class="text-2xl md:text-3xl font-extrabold">Tout ce qu’il faut savoir</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach($faqs as $idx => $f)
        <details class="rounded-2xl p-4 bg-white ring-1 ring-zinc-200 open:shadow"
                 {{ $idx === 0 ? 'open' : '' }}
                 itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
          <summary class="cursor-pointer list-none font-semibold flex items-center justify-between">
            <span itemprop="name">{{ $f->question }}</span>
            <svg class="w-5 h-5 shrink-0 transition-transform details-marker" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.085l3.71-3.855a.75.75 0 011.08 1.04l-4.24 4.4a.75.75 0 01-1.08 0l-4.24-4.4a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
            </svg>
          </summary>
          <div class="mt-2 text-sm text-zinc-600" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
            <div itemprop="text">{!! nl2br(e($f->answer)) !!}</div>
          </div>
        </details>
      @endforeach
    </div>
  </div>
</section>


@php
  $faqLd = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => $faqs->map(function($f){
      return [
        '@type'          => 'Question',
        'name'           => $f->question,
        'acceptedAnswer' => [
          '@type' => 'Answer',
          // du texte brut (sans balises) pour le JSON-LD
          'text'  => trim(preg_replace('/\s+/', ' ', strip_tags($f->answer))),
        ],
      ];
    })->values()->all(),
  ];
@endphp

<script type="application/ld+json">
    {!! json_encode($faqLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
</script>

@endif
