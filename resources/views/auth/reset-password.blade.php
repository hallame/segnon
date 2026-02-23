<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Réinitialiser le mot de passe • MYLMARK</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="color-scheme" content="light" />

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

  {{-- SEO classique --}}
  <meta name="description" content="Choisissez un nouveau mot de passe sécurisé pour votre compte MYLMARK et retrouvez l’accès à vos commandes, favoris et informations personnelles.">
  <meta name="keywords" content="MYLMARK, réinitialiser mot de passe, nouveau mot de passe, compte client, sécurité, marketplace africaine, artisans, créateurs">

  {{-- Open Graph --}}
  <meta property="og:title" content="@yield('og_title', 'Réinitialiser le mot de passe • MYLMARK')">
  <meta property="og:description" content="@yield('og_desc', 'Réinitialisez en toute sécurité le mot de passe de votre compte MYLMARK pour continuer à profiter de vos achats et favoris.')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="@yield('og_image', asset('assets/images/2m.png'))">
  <meta property="og:image:width" content="@yield('og_image_width', '1200')">
  <meta property="og:image:height" content="@yield('og_image_height', '630')">
  <meta property="og:image:alt" content="@yield('og_image_alt', 'MYLMARK – Marketplace d’artisans & créateurs africains')">
  <meta property="og:locale" content="fr_FR">

  {{-- Favicon / icônes --}}
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon.png') }}">
  <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

  <style>
    body{font-family:Poppins,ui-sans-serif,system-ui}
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

    .card{border-radius:24px;background:rgba(255,255,255,.06);backdrop-filter:blur(10px);
      border:1px solid rgba(255,255,255,.18); box-shadow:0 24px 60px -28px rgba(34,197,94,.35)}
    .btn{display:inline-flex;align-items:center;gap:.5rem;padding:.7rem 1rem;border-radius:16px;
      font-weight:700;color:#0b1510;background:#34d399;box-shadow:0 10px 36px -14px rgba(52,211,153,.55);transition:.2s}
    .btn:hover{transform:translateY(-1px);background:#6ee7b7}
    .btn-ghost{display:inline-flex;align-items:center;gap:.55rem;padding:.55rem .85rem;border-radius:14px;border:1px solid rgba(255,255,255,.2);color:#fff;background:rgba(255,255,255,.06)}
    .inp{width:100%;border-radius:14px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);padding:.75rem .9rem;color:#fff;outline:none}
    .inp:focus{border-color:rgba(52,211,153,.6);box-shadow:0 0 0 3px rgba(52,211,153,.16)}
    .lbl{display:block;color:#fff;font-weight:600;margin-bottom:.35rem}
    .err{color:#fecaca;font-size:.85rem;margin-top:.25rem}
  </style>
</head>
<body class="min-h-screen bg-[#0f1512] text-white">
  <div class="mesh"></div><div class="ring a"></div><div class="ring b"></div><div class="grain"></div>

  <!-- HERO -->
  <header class="relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 text-center">
      <span class="inline-flex items-center gap-2 text-[11px] tracking-[0.18em] uppercase px-3 py-1 rounded-full bg-white/10 ring-1 ring-white/15 text-white/90">
        Sécurité
      </span>

      <h1 class="mt-2 text-3xl md:text-4xl font-extrabold leading-tight text-balance">
        Nouveau
        <span class="bg-gradient-to-r from-emerald-300 via-emerald-200 to-amber-200 bg-clip-text text-transparent"> mot de passe</span>
      </h1>


    </div>
  </header>

  <!-- FORM -->
  <main class="relative pb-14">
    <div class="max-w-lg mx-auto px-4 sm:px-6">
      @if (session('status'))
        <div class="mb-4 rounded-xl border border-emerald-300/40 bg-emerald-100/10 text-emerald-100 px-4 py-3">
          {{ session('status') }}
        </div>
      @endif
      @if ($errors->any())
        <div class="mb-4 rounded-xl border border-amber-300/40 bg-amber-100/10 text-amber-100 px-4 py-3">
          Merci de vérifier les champs indiqués ci-dessous.
        </div>
      @endif

      <form method="POST" action="{{ route('password.store') }}" novalidate class="card overflow-hidden">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div class="p-6 sm:p-8 space-y-4">
          <div>
            <label for="email" class="lbl">Email</label>
            <input  id="email"  name="email" type="email"
              class="inp"  value="{{ old('email', request('email')) }}"
              placeholder="exemple@email.com" autocomplete="email"  required >
            @error('email') <div class="err">{{ $message }}</div> @enderror
          </div>

          <div>
            <label for="password" class="lbl">Nouveau mot de passe</label>
            <div class="relative">
              <input id="password" name="password"  type="password"
                class="inp pr-10"  placeholder="••••••••"
                autocomplete="new-password"  minlength="6"  required >
              <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-white/80"
                      data-toggle="#password" aria-label="Afficher/Masquer">👁️</button>
            </div>
            @error('password') <div class="err">{{ $message }}</div> @enderror
          </div>

          <div>
            <label for="password_confirmation" class="lbl">Confirmer le mot de passe</label>
            <div class="relative">
              <input id="password_confirmation" name="password_confirmation"
                type="password"  class="inp pr-10"
                placeholder="Répétez le mot de passe"  autocomplete="new-password"  required >
              <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-white/80"
                      data-toggle="#password_confirmation" aria-label="Afficher/Masquer">👁️</button>
            </div>
          </div>
        </div>

        <div class="px-6 sm:px-8 pb-6 sm:pb-8">
          <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:justify-between">
            <a href="{{ route('login') }}" class="btn-ghost">← Retour à la connexion</a>
            <button class="btn" type="submit">Mettre à jour</button>
          </div>
          <p class="mt-3 text-xs text-white/60">
            Note : utilisez un mot de passe long (12+ caractères) et unique.
          </p>
        </div>
      </form>
    </div>
  </main>

  <script>
    // Toggle password visibility
    document.querySelectorAll('[data-toggle]').forEach(btn=>{
      btn.addEventListener('click',()=>{
        const sel = btn.getAttribute('data-toggle');
        const inp = document.querySelector(sel);
        if(!inp) return;
        inp.type = (inp.type === 'password') ? 'text' : 'password';
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
