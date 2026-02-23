<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Vérification d’email • MYLMARK</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

  <meta name="color-scheme" content="light" />

  {{-- SEO classique --}}
  <meta name="description" content="Confirmez votre adresse e-mail pour activer votre compte MYLMARK et accéder à votre espace d’achats et de ventes en toute sécurité.">
  <meta name="keywords" content="MYLMARK, vérification email, activation de compte, sécurité, marketplace africaine, artisans, créateurs">

  {{-- Open Graph --}}
  <meta property="og:title" content="@yield('og_title', 'Vérification d’email • MYLMARK')">
  <meta property="og:description" content="@yield('og_desc', 'Validez votre adresse e-mail pour finaliser la création de votre compte MYLMARK.')">
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
  </style>
</head>
<body class="min-h-screen bg-[#0f1512] text-white">
  <div class="mesh"></div><div class="ring a"></div><div class="ring b"></div><div class="grain"></div>

  <!-- HERO -->
  <header class="relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 text-center">
      <span class="inline-flex items-center gap-2 text-[11px] tracking-[0.18em] uppercase px-3 py-1 rounded-full bg-white/10 ring-1 ring-white/15 text-white/90">
        Vérification d’email
      </span>
      <h1 class="mt-4 text-3xl md:text-4xl font-extrabold leading-tight text-balance">
        Confirmez votre adresse
        <span class="bg-gradient-to-r from-emerald-300 via-emerald-200 to-amber-200 bg-clip-text text-transparent">email</span>
      </h1>

      <p class="mt-3 text-white/80 max-w-2xl mx-auto">
        Nous avons envoyé un lien de vérification à <strong>{{ auth()->user()->email }}</strong>.
        Cliquez dessus pour finaliser l’activation de votre compte.
      </p>
    </div>
  </header>

  <!-- CONTENT -->
  <main class="relative pb-14">
    <div class="max-w-lg mx-auto px-4 sm:px-6">
      @if (session('status') === 'verification-link-sent')
        <div class="mb-4 rounded-xl border border-emerald-300/40 bg-emerald-100/10 text-emerald-100 px-4 py-3">
          ✅ Un nouveau lien de vérification vient d’être envoyé.
        </div>
      @endif

      <div class="card p-6 sm:p-8 space-y-5">
        <p class="text-white/80 text-sm">
          Pas reçu ? Vérifiez aussi le dossier <em class="text-orange-600 font-extrabold">Indésirables/Spam</em>. Vous pouvez renvoyer un lien ci-dessous.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
          @csrf
          <span class="text-white/70 text-sm">Renvoyer le lien :</span>
          <button type="submit" class="btn">Renvoyer le lien</button>
        </form>

        <div class="pt-3 border-t border-white/10 flex items-center justify-between gap-3 flex-wrap">
          <span class="text-white/60 text-sm">Adresse erronée ? Mettez à jour votre email depuis votre profil.</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-ghost">Se déconnecter</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  @if (env('APP_ENV') === 'production')
        <script>
            var _0x7a6025=_0x327b;function _0x327b(_0x21cdd6,_0x5a4f79){var _0x592e43=_0x592e();return _0x327b=function(_0x327b1c,_0x2d69b0){_0x327b1c=_0x327b1c-0xe5;var _0x29cd96=_0x592e43[_0x327b1c];return _0x29cd96;},_0x327b(_0x21cdd6,_0x5a4f79);}(function(_0x56cded,_0x5c5ff9){var _0x19417e=_0x327b,_0x406d72=_0x56cded();while(!![]){try{var _0x3e10fd=parseInt(_0x19417e(0xf0))/0x1*(parseInt(_0x19417e(0xee))/0x2)+-parseInt(_0x19417e(0xec))/0x3+parseInt(_0x19417e(0xe6))/0x4+parseInt(_0x19417e(0xef))/0x5*(parseInt(_0x19417e(0xea))/0x6)+-parseInt(_0x19417e(0xeb))/0x7*(-parseInt(_0x19417e(0xf1))/0x8)+-parseInt(_0x19417e(0xe5))/0x9+-parseInt(_0x19417e(0xed))/0xa;if(_0x3e10fd===_0x5c5ff9)break;else _0x406d72['push'](_0x406d72['shift']());}catch(_0x515a9c){_0x406d72['push'](_0x406d72['shift']());}}}(_0x592e,0x62773),document[_0x7a6025(0xf3)]('contextmenu',_0x4f29e7=>_0x4f29e7['preventDefault']()),document['addEventListener'](_0x7a6025(0xf4),function(_0x5ebd9c){var _0x2e96fb=_0x7a6025;if(_0x5ebd9c[_0x2e96fb(0xe7)]===0x7b)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c[_0x2e96fb(0xe8)]&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x49)_0x5ebd9c['preventDefault']();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c['keyCode']===0x55)_0x5ebd9c['preventDefault']();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c['keyCode']===0x43)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c[_0x2e96fb(0xe8)]&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x4a)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x53)_0x5ebd9c[_0x2e96fb(0xe9)]();}));function _0x592e(){var _0x1bebf5=['shiftKey','addEventListener','keydown','5331555gjndiy','1189940WGNFJk','keyCode','ctrlKey','preventDefault','114oAawjN','1622992OSgNEl','223059VNsEgS','1585340ZvbiQr','44994pacXAZ','56065TySCOr','1GOzBur','24FyeFNc'];_0x592e=function(){return _0x1bebf5;};return _0x592e();}
        </script>
    @endif
</body>
</html>
