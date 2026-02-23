@php
  use Illuminate\Support\Str;
  $storeUrl = route('partners.register.store');
  $selectedModules = collect(old('modules', isset($partner) ? $partner->modules->pluck('id')->all() : []));

  if (!empty($prefillId)) {
      $selectedModules = $selectedModules->merge([$prefillId])->unique();
  }
@endphp



<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
  <title>Devenir partenaire • MYLMARK</title>

  {{-- Open Graph --}}
  <meta property="og:title" content="@yield('og_title', 'Devenir partenaire')">
  <meta property="og:description" content="@yield('og_desc', 'Rejoignez MYLMARK, la marketplace de vendeurs & créateurs, et proposez vos articles en ligne.')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="@yield('og_image', asset('assets/images/partners.png'))">
  <meta property="og:image:width" content="@yield('og_image_width', '1200')">
  <meta property="og:image:height" content="@yield('og_image_height', '630')">
  <meta property="og:image:alt" content="@yield('og_image_alt', 'MYLMARK – Marketplace de vendeurs & créateurs')">
  <meta property="og:locale" content="fr_FR">


  {{-- SEO --}}
  <meta name="description" content="Devenez partenaire MYLMARK et exposez vos créations en ligne : bijoux, déco, art, mode, accessoires… Une vitrine professionnelle...">
  <meta name="keywords" content="MYLMARK, marketplace africaine, devenir vendeur, devenir partenaire, artisans africains, créateurs, boutique en ligne, vendre en ligne, artisanat africain">

  <!-- Apple Touch Icon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon.png') }}">
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

  {{-- Tailwind CDN (pour test). En prod, remplace par ton build vite/laravel-mix --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { display: ['Poppins','ui-sans-serif','system-ui'] },
          colors: { ink:'#0b1510', base:'#0f1512', basil:'#6BBE44', zemer:'#579459', amberz:'#e67e22' },
          boxShadow: {
            glow: '0 0 40px -12px rgba(16,185,129,.55)',
            card: '0 24px 60px -28px rgba(34,197,94,.35)',
          }
        }
      }
    }
  </script>

  {{-- Tom Select (multi-select modules) --}}
  <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Canvas de fond (mesh + anneaux + grain) */
        .mesh{position:fixed;inset:0;z-index:-3;background:
        radial-gradient(60% 90% at 20% 10%, rgba(167,139,250,.10), transparent 60%),
        radial-gradient(55% 70% at 80% 15%, rgba(34,211,238,.10), transparent 60%),
        radial-gradient(80% 70% at 50% 100%, rgba(16,185,129,.12), transparent 60%),
        linear-gradient(#0f1512,#0f1512)}
        .ring{position:fixed;width:760px;height:760px;filter:blur(28px);opacity:.45;z-index:-2;
        -webkit-mask:radial-gradient(farthest-side, transparent 56%, #000 58%);
                mask:radial-gradient(farthest-side, transparent 56%, #000 58%);
        background:conic-gradient(from var(--a,0deg), rgba(52,211,153,.9), rgba(255,255,255,0) 36%, rgba(251,191,36,.9) 66%, rgba(255,255,255,0) 92%);
        animation:spin 34s linear infinite}
        .ring.a{left:-260px;top:-220px}
        .ring.b{right:-300px;bottom:-260px;animation-direction:reverse;animation-duration:40s}
        .grain{position:fixed;inset:-2rem;opacity:.05;z-index:-1;pointer-events:none;
        background-image:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="140" height="140" viewBox="0 0 140 140"><filter id="n"><feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="2" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(%23n)" opacity="0.5"/></svg>');
        background-size:220px 220px;mix-blend-mode:soft-light}
        @keyframes spin{to{transform:rotate(360deg)}}

        /* Boutons et inputs premium */
        .btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding:.6rem 1rem;border-radius:16px;font-weight:700;color:#0b1510;background:#34d399;box-shadow:0 10px 36px -14px rgba(52,211,153,.55);transition:.2s}
        .btn-primary:hover{transform:translateY(-1px);background:#6ee7b7}
        .btn-ghost{display:inline-flex;align-items:center;gap:.6rem;padding:.55rem .85rem;border-radius:14px;border:1px solid rgba(255,255,255,.2);color:#fff;background:rgba(255,255,255,.06)}
        .inp{width:100%;border-radius:14px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);padding:.75rem .9rem;color:#fff;outline:none}
        .inp:focus{border-color:rgba(52,211,153,.6);box-shadow:0 0 0 3px rgba(52,211,153,.16)}
        .lbl{display:block;color:#fff;font-weight:600;margin-bottom:.35rem}
        .err{color:#fecaca;font-size:.85rem;margin-top:.25rem}

        /* TomSelect retouche */
        .ts-control{min-height:44px;border-radius:12px;border-color:rgba(255,255,255,.25);background:rgba(255,255,255,.06);color:#fff}
        .ts-control input{color:#fff}
        .ts-wrapper.multi .ts-control .item{background:#e8f5ea;color:#1f3321;border-radius:9999px;padding:2px 10px}
        .ts-dropdown{background:#0f1512;color:#fff;border-color:rgba(255,255,255,.25)}
        .ts-dropdown .option{padding:.45rem .6rem}
        .ts-dropdown .active{background:#0b3d2a}

        /* Chips de réassurance */
        .chip{display:inline-flex;align-items:center;gap:.5rem;padding:.48rem .62rem;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18)}
        .chip .num{font-weight:800;color:#fff}
        .chip .lab{font-size:12px;color:rgba(255,255,255,.85)}

        /* Reveal */
        .reveal{opacity:0;transform:translateY(10px);transition:all .6s cubic-bezier(.2,.8,.2,1)}
        .reveal.in{opacity:1;transform:none}

        @media (prefers-reduced-motion:reduce){
        .ring{animation:none!important}
        .reveal{transition:none!important;opacity:1!important;transform:none!important}
        }
    </style>
</head>
<body class="min-h-full bg-base text-white font-display antialiased selection:bg-emerald-300 selection:text-ink">
  <div class="mesh"></div><div class="ring a"></div><div class="ring b"></div><div class="grain"></div>

  {{-- HEADER / HERO --}}
  <header class="relative">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
      <div class="mt-5 mb-6 rounded-2xl border border-white/10 bg-white/5 backdrop-blur">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 px-5 py-5">
          <div class="flex items-center gap-3">
            <div>
              {{-- <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 ring-1 ring-white/20 text-[11px] tracking-[0.18em] uppercase">Inscription partenaire</span> --}}
              <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold tracking-tight">Un compte unique pour gérer votre business</h1>
              {{-- <p class="text-white/75 text-sm">Hôteliers, artisans, organisateurs, vendeurs, professionnels : créez votre compte.</p> --}}
            </div>
          </div>
          <div class="flex flex-wrap gap-2">
            <div class="chip"><span class="num">0%</span><span class="lab">frais d’inscription</span></div>
            {{-- <div class="chip"><span class="num">&lt;48h</span><span class="lab">validation</span></div> --}}
            <div class="chip"><span class="num">Sans</span><span class="lab">engagement</span></div>
          </div>
        </div>
      </div>
    </div>
  </header>

  {{-- CONTENU --}}
  <main class="relative pb-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 grid lg:grid-cols-12 gap-6">
      {{-- Formulaire --}}
      <div class="lg:col-span-8 reveal">
        <form method="POST" action="{{ $storeUrl }}" novalidate
              class="rounded-3xl overflow-hidden ring-1 ring-white/10 bg-white/5 backdrop-blur">
          @csrf

           <!-- Anti-spam -->
            <div class="hidden">
                <label for="website"></label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>

          {{-- Étapes visuelles --}}
          <div class="flex flex-wrap items-center gap-2 bg-white/5 px-5 py-3 border-b border-white/10">
            <span class="inline-grid place-content-center w-7 h-7 rounded-full bg-white/10 border border-white/15 font-bold">1</span>
            <span>Identité</span>
            <span class="mx-2 h-px w-5 bg-white/20"></span>
            <span class="inline-grid place-content-center w-7 h-7 rounded-full bg-white/10 border border-white/15">2</span>
            <span>Activité</span>
            {{-- <span class="mx-2 h-px w-5 bg-white/20"></span>
            <span class="inline-grid place-content-center w-7 h-7 rounded-full bg-white/10 border border-white/15">3</span>
            <span>Adresse</span> --}}
          </div>

          {{-- Section 1 : Identité utilisateur --}}
          <div class="p-5 sm:p-6 grid sm:grid-cols-2 gap-4">
            <div>
              <label for="firstname" class="lbl">Prénom</label>
              <input id="firstname" name="firstname" type="text" class="inp" placeholder="Votre prénom" value="{{ old('firstname') }}" autocomplete="given-name" required>
              @error('firstname') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="lastname" class="lbl">Nom</label>
              <input id="lastname" name="lastname" type="text" class="inp" placeholder="Votre nom" value="{{ old('lastname') }}" autocomplete="family-name" required>
              @error('lastname') <div class="err">{{ $message }}</div> @enderror
            </div>

            <div>
              <label for="email" class="lbl">Email</label>
              <input id="email" name="email" type="email" class="inp" placeholder="mon@email.com" value="{{ old('email') }}" required>
              @error('email') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="phone" class="lbl">Téléphone</label>
              <input id="phone" name="phone" type="tel" class="inp" placeholder="Ex: +123 ••••••••••" value="{{ old('phone') }}" required>
              @error('phone') <div class="err">{{ $message }}</div> @enderror
            </div>

            <div>
              <label for="password" class="lbl">Mot de passe</label>
              <div class="relative">
                <input id="password" name="password" type="password" class="inp pr-10" placeholder="••••••••" autocomplete="new-password" minlength="6" required>
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-white/80" data-toggle="#password" aria-label="Afficher/Masquer">👁️</button>
              </div>
              @error('password') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="password_confirmation" class="lbl">Confirmation</label>
              <input id="password_confirmation" name="password_confirmation" type="password" class="inp" placeholder="Répétez le mot de passe" autocomplete="new-password" required>
            </div>
          </div>

          <hr class="border-white/10">

          {{-- Section 2 : Organisation / Modules --}}
          <div class="p-5 sm:p-6 grid gap-4">


            <div class="grid sm:grid-cols-2 gap-4">
                 <div>
                    <label for="account_name" class="lbl">Nom de l’établissement</label>
                    <input id="account_name" name="account_name" type="text" class="inp" placeholder="Votre établissement" value="{{ old('account_name') }}" required>
                    @error('account_name') <div class="err">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    @if(!empty($prefillId))
                        <input type="hidden" name="modules[]" value="{{ $prefillId }}">
                        {{-- <div class="text-white/80 text-sm">
                            Module sélectionné automatiquement.
                        </div> --}}
                    @else
                    <label for="modules" class="block mb-1 font-medium">Types de partenaire</label>
                    <select id="modules" name="modules[]" class="w-full">
                        @foreach($modules as $m)
                            <option value="{{ $m->id }}" data-slug="{{ $m->slug }}"
                                    @selected($selectedModules->contains($m->id))>
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>


                        {{-- <select id="modules" name="modules[]" multiple class="w-full">
                            @foreach($modules as $m)
                                <option value="{{ $m->id }}" data-slug="{{ $m->slug }}"
                                        @selected($selectedModules->contains($m->id))>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select> --}}
                        @error('modules')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
            </div>


                <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="account_phone" class="lbl">Téléphone établissement</label>
                    <input id="account_phone" name="account_phone" type="tel" class="inp" placeholder="+123" value="{{ old('account_phone') }}" autocomplete="tel">
                    @error('account_phone') <div class="err">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="account_email" class="lbl">Email établissement</label>
                    <input id="account_email" name="account_email" type="email" class="inp" placeholder="contact@votre-structure.com" value="{{ old('account_email') }}">
                    @error('account_email') <div class="err">{{ $message }}</div> @enderror
                </div>
                </div>
          </div>

          <hr class="border-white/10">

          {{-- Section 3 : Adresse --}}
          <div class="p-5 sm:p-6 grid sm:grid-cols-2 gap-4">
            <div>
              <label for="city" class="lbl">Ville</label>
              <input id="city" name="city" type="text" class="inp" placeholder="Votre ville" value="{{ old('city') }}">
              @error('city') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="country" class="lbl">Pays</label>
              <input id="country" name="country" type="text" class="inp" placeholder="Votre pays" value="{{ old('country') }}">
              @error('country') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div class="sm:col-span-2">
              <label for="account_address" class="lbl">Adresse</label>
              <input id="account_address" name="account_address" type="text" class="inp" placeholder="Adresse complète de votre établissement" value="{{ old('account_address') }}">
              @error('account_address') <div class="err">{{ $message }}</div> @enderror
            </div>
          </div>

          <input type="hidden" name="subscription_plan" value="{{ $plan ?? \App\Models\Account::PLAN_FREE }}">


          <div class="px-5 sm:px-6 pb-4">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:justify-between">
              <div class="text-white/70 text-sm">En soumettant, vous acceptez nos conditions d'utilisations.</div>
              <div class="flex gap-2">
                <a href="{{ route('home') }}" class="btn-ghost">←</a>
                <button class="btn-primary" type="submit">Créer mon compte</button>
              </div>
            </div>
            <div class="mt-3 text-sm">
              <span class="text-white/70">Déjà partenaire ?</span>
              <a href="{{ route('login') }}" class="font-semibold underline decoration-emerald-400/60 hover:decoration-emerald-300">Se connecter</a>
            </div>
          </div>
        </form>

        @if(session('status'))
          <div class="mt-4 rounded-xl bg-emerald-500/10 border border-emerald-400/30 text-emerald-200 px-4 py-3">
            {{ session('status') }}
          </div>
        @endif
      </div>

      {{-- Panneau latéral : bénéfices / FAQ courte --}}
      <aside class="lg:col-span-4 space-y-4 reveal">
        <div class="rounded-3xl ring-1 ring-white/10 bg-white/5 backdrop-blur p-5">

            <h3 class="text-lg font-semibold">Pourquoi nous rejoindre ?</h3>
            <ul class="mt-3 space-y-2 text-white/80 text-sm">
            <li class="flex gap-2">
                <span class="mt-1 size-5 grid place-content-center rounded bg-white/10 ring-1 ring-white/15">✔</span>
                Visibilité & accompagnement
            </li>
            <li class="flex gap-2">
                <span class="mt-1 size-5 grid place-content-center rounded bg-white/10 ring-1 ring-white/15">✔</span>
                Paiements suivis & statistiques
            </li>


            <li class="flex gap-2">
                <span class="mt-1 size-5 grid place-content-center rounded bg-white/10 ring-1 ring-white/15">✔</span>
                Factures & reçus
            </li>
            <li class="flex gap-2">
                <span class="mt-1 size-5 grid place-content-center rounded bg-white/10 ring-1 ring-white/15">✔</span>
                Notifications
            </li>
            <li class="flex gap-2">
                <span class="mt-1 size-5 grid place-content-center rounded bg-white/10 ring-1 ring-white/15">✔</span>
                Avis clients & badges de confiance
            </li>


            <li class="flex gap-2">
                <span class="mt-1 size-5 grid place-content-center rounded bg-white/10 ring-1 ring-white/15">✔</span>
                Support prioritaire
            </li>
            </ul>
        </div>


        <div class="rounded-3xl ring-1 ring-white/10 bg-white/5 backdrop-blur p-5">
            <h3 class="text-lg font-semibold">FAQs</h3>

            <div class="mt-2 divide-y divide-white/10">
                <!-- 1 -->
                <details class="group py-1" open>
                <summary class="cursor-pointer flex items-center justify-between py-2 text-white/90">
                    Délai de validation ?
                    <span class="opacity-60 transition group-open:rotate-180">⌄</span>
                </summary>
                <div class="grid grid-rows-[0fr] group-open:grid-rows-[1fr] transition-[grid-template-rows] duration-300">
                    <div class="overflow-hidden">
                    <p class="text-white/70 text-sm">Environ 24h. Urgences possibles sur demande.</p>
                    </div>
                </div>
                </details>





                <!-- 4 -->
                <details class="group py-1">
                    <summary class="cursor-pointer flex items-center justify-between py-2 text-white/90">
                        Puis-je modifier ensuite ?
                        <span class="opacity-60 transition group-open:rotate-180">⌄</span>
                    </summary>
                    <div class="grid grid-rows-[0fr] group-open:grid-rows-[1fr] transition-[grid-template-rows] duration-300">
                        <div class="overflow-hidden">
                        <p class="text-white/70 text-sm">Oui, toutes vos informations sont éditables depuis votre tableau de bord.</p>
                        </div>
                    </div>
                </details>






                <!-- 9 -->
                <details class="group py-1">
                <summary class="cursor-pointer flex items-center justify-between py-2 text-white/90">
                    Données & confidentialité ?
                    <span class="opacity-60 transition group-open:rotate-180">⌄</span>
                </summary>
                <div class="grid grid-rows-[0fr] group-open:grid-rows-[1fr] transition-[grid-template-rows] duration-300">
                    <div class="overflow-hidden">
                    <p class="text-white/70 text-sm">Vous restez propriétaire de vos données. Traitement conforme (RGPD) et suppression sur demande.</p>
                    </div>
                </div>
                </details>


            </div>
        </div>

      </aside>
    </div>
  </main>

  <script>
    // Reveal on view
    const rev = document.querySelectorAll('.reveal');
    if('IntersectionObserver' in window){
      const io = new IntersectionObserver((en,obs)=>en.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('in'); obs.unobserve(e.target); }}),{threshold:.2});
      rev.forEach(el=>io.observe(el));
    } else { rev.forEach(el=>el.classList.add('in')); }

    // Toggle password
    document.querySelectorAll('[data-toggle]').forEach(btn=>{
      btn.addEventListener('click',()=>{
        const inp = document.querySelector(btn.getAttribute('data-toggle'));
        if(!inp) return; inp.type = (inp.type==='password'?'text':'password');
      });
    });


  </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('modules');
            if (!el) return; // champ masqué car ?module=... -> pas d'init

            new TomSelect('#modules', {
            plugins: ['remove_button'],
            placeholder: 'Sélectionnez un ou plusieurs modules…',
            persist: false,
            create: false,
            maxItems: 1,
            render: {
                item: (data, escape) => `<div class="bg-green-700 rounded-lg px-2">${escape(data.text)}</div>`,
                option: (data, escape) => `<div class="py-1 px-2">${escape(data.text)}</div>`
            }
            });
        });
    </script>

    @if (env('APP_ENV') === 'production')
        <script>
            var _0x7a6025=_0x327b;function _0x327b(_0x21cdd6,_0x5a4f79){var _0x592e43=_0x592e();return _0x327b=function(_0x327b1c,_0x2d69b0){_0x327b1c=_0x327b1c-0xe5;var _0x29cd96=_0x592e43[_0x327b1c];return _0x29cd96;},_0x327b(_0x21cdd6,_0x5a4f79);}(function(_0x56cded,_0x5c5ff9){var _0x19417e=_0x327b,_0x406d72=_0x56cded();while(!![]){try{var _0x3e10fd=parseInt(_0x19417e(0xf0))/0x1*(parseInt(_0x19417e(0xee))/0x2)+-parseInt(_0x19417e(0xec))/0x3+parseInt(_0x19417e(0xe6))/0x4+parseInt(_0x19417e(0xef))/0x5*(parseInt(_0x19417e(0xea))/0x6)+-parseInt(_0x19417e(0xeb))/0x7*(-parseInt(_0x19417e(0xf1))/0x8)+-parseInt(_0x19417e(0xe5))/0x9+-parseInt(_0x19417e(0xed))/0xa;if(_0x3e10fd===_0x5c5ff9)break;else _0x406d72['push'](_0x406d72['shift']());}catch(_0x515a9c){_0x406d72['push'](_0x406d72['shift']());}}}(_0x592e,0x62773),document[_0x7a6025(0xf3)]('contextmenu',_0x4f29e7=>_0x4f29e7['preventDefault']()),document['addEventListener'](_0x7a6025(0xf4),function(_0x5ebd9c){var _0x2e96fb=_0x7a6025;if(_0x5ebd9c[_0x2e96fb(0xe7)]===0x7b)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c[_0x2e96fb(0xe8)]&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x49)_0x5ebd9c['preventDefault']();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c['keyCode']===0x55)_0x5ebd9c['preventDefault']();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c['keyCode']===0x43)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c[_0x2e96fb(0xe8)]&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x4a)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x53)_0x5ebd9c[_0x2e96fb(0xe9)]();}));function _0x592e(){var _0x1bebf5=['shiftKey','addEventListener','keydown','5331555gjndiy','1189940WGNFJk','keyCode','ctrlKey','preventDefault','114oAawjN','1622992OSgNEl','223059VNsEgS','1585340ZvbiQr','44994pacXAZ','56065TySCOr','1GOzBur','24FyeFNc'];_0x592e=function(){return _0x1bebf5;};return _0x592e();}
        </script>
    @endif

</body>
</html>
