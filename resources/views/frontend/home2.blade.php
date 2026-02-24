<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Segnon Shop — Rideaux · Draps · Décoration</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;0,900;1,400;1,700;1,900&family=Bricolage+Grotesque:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        ivory:   '#F9F4EC',
        'ivory-dark': '#EFE8D8',
        amber:   '#B5651D',
        'amber-light': '#F0C99A',
        'amber-pale': '#FBF0E0',
        emerald: '#1B5E42',
        'emerald-light': '#D4EAE0',
        ink:     '#0F0D0B',
        'ink-soft': '#2C2620',
        'ink-muted': '#7A6E64',
        'ink-faint': '#BFB5A8',
        rouge:   '#C0392B',
        'rouge-pale': '#FAEAEA',
        gold:    '#D4A843',
        'gold-pale': '#FDF5E0',
      },
      fontFamily: {
        display: ['Playfair Display', 'Georgia', 'serif'],
        sans: ['Bricolage Grotesque', 'system-ui', 'sans-serif'],
      },
      animation: {
        'float-slow': 'floatSlow 7s ease-in-out infinite',
        'float-med':  'floatMed 5s ease-in-out infinite',
        'ticker':     'ticker 35s linear infinite',
        'spin-slow':  'spin 20s linear infinite',
        'fade-up':    'fadeUp .7s ease forwards',
        'grain':      'grain 8s steps(10) infinite',
      },
      keyframes: {
        floatSlow: { '0%,100%': {transform:'translateY(0) rotate(-1deg)'}, '50%': {transform:'translateY(-18px) rotate(1.5deg)'} },
        floatMed:  { '0%,100%': {transform:'translateY(0)'}, '50%': {transform:'translateY(-12px)'} },
        ticker:    { '0%': {transform:'translateX(0)'}, '100%': {transform:'translateX(-50%)'} },
        fadeUp:    { '0%': {opacity:'0',transform:'translateY(28px)'}, '100%': {opacity:'1',transform:'translateY(0)'} },
        grain:     { '0%,100%': {transform:'translate(0,0)'}, '10%': {transform:'translate(-5%,-10%)'}, '30%': {transform:'translate(3%,-15%)'}, '50%': {transform:'translate(12%,9%)'}, '70%': {transform:'translate(9%,4%)'}, '90%': {transform:'translate(-1%,7%)'} },
      },
    }
  }
}
</script>

<style>
  /* ── FONTS & BASE ── */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { cursor: none; overflow-x: hidden; background: #F9F4EC; }

  /* ── CURSOR ── */
  #c-dot {
    position: fixed; pointer-events: none; z-index: 9999;
    width: 10px; height: 10px; border-radius: 50%;
    background: #B5651D; transform: translate(-50%,-50%);
    transition: width .25s, height .25s, background .25s, opacity .25s;
    mix-blend-mode: multiply;
  }
  #c-ring {
    position: fixed; pointer-events: none; z-index: 9998;
    width: 40px; height: 40px; border-radius: 50%;
    border: 1.5px solid rgba(181,101,29,.4);
    transform: translate(-50%,-50%);
    transition: transform .55s cubic-bezier(.22,1,.36,1), width .3s, height .3s, opacity .3s;
  }
  body:has(a:hover) #c-dot, body:has(button:hover) #c-dot { width: 22px; height: 22px; background: rgba(181,101,29,.2); border: 1.5px solid #B5651D; }

  /* ── NOISE OVERLAY ── */
  .noise::after {
    content: '';
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none; z-index: 10;
    animation: grain 8s steps(10) infinite;
  }

  /* ── HERO DIAGONAL ── */
  .hero-clip { clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%); }
  .hero-img-clip { clip-path: polygon(8% 0, 100% 0, 100% 100%, 0 100%); }

  /* ── TICKER ── */
  .ticker-wrap { display: flex; animation: ticker 35s linear infinite; white-space: nowrap; }

  /* ── CARD HOVER ── */
  .prod-card { transition: transform .4s cubic-bezier(.22,1,.36,1), box-shadow .4s; }
  .prod-card:hover { transform: translateY(-10px) rotate(.3deg); }
  .prod-card:hover .prod-overlay { opacity: 1; }
  .prod-overlay { opacity: 0; transition: opacity .35s; }

  /* ── CAT CARD ── */
  .cat-card { transition: transform .45s cubic-bezier(.22,1,.36,1), box-shadow .45s; }
  .cat-card:hover { transform: scale(1.03) rotate(-.4deg); }
  .cat-card:hover .cat-inner-emoji { transform: scale(1.12) translateY(-6px); }
  .cat-inner-emoji { transition: transform .45s; }

  /* ── SECTION REVEAL ── */
  .reveal { opacity: 0; transform: translateY(32px); transition: opacity .7s ease, transform .7s ease; }
  .reveal.on { opacity: 1; transform: translateY(0); }
  .delay-1 { transition-delay: .12s; }
  .delay-2 { transition-delay: .24s; }
  .delay-3 { transition-delay: .36s; }
  .delay-4 { transition-delay: .48s; }

  /* ── PROMO CARD ── */
  .promo-hover { transition: transform .35s cubic-bezier(.22,1,.36,1); }
  .promo-hover:hover { transform: scale(1.025); }

  /* ── WHY CARD ── */
  .why-card { transition: background .3s, border-color .3s, transform .3s; }
  .why-card:hover { transform: translateY(-5px); }

  /* ── TESTI CARD ── */
  .testi-card { transition: transform .35s, box-shadow .35s; }
  .testi-card:hover { transform: translateY(-6px); }

  /* ── FORM ── */
  .form-field { transition: border-color .25s, box-shadow .25s; }
  .form-field:focus { border-color: #B5651D !important; box-shadow: 0 0 0 4px rgba(181,101,29,.1) !important; }

  /* ── STRIPE DECO ── */
  .stripe-deco {
    background: repeating-linear-gradient(
      -45deg,
      transparent, transparent 4px,
      rgba(181,101,29,.08) 4px, rgba(181,101,29,.08) 8px
    );
  }

  /* ── SCROLLBAR ── */
  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-track { background: #F9F4EC; }
  ::-webkit-scrollbar-thumb { background: #B5651D; border-radius: 3px; }

  /* ── NAV SCROLL ── */
  .nav-glass { background: rgba(249,244,236,.92); backdrop-filter: blur(20px); }
</style>
</head>

<body class="font-sans text-ink bg-ivory">

<!-- CURSOR -->
<div id="c-dot"></div>
<div id="c-ring"></div>

<!-- ═══════════════════════════════════
     NAVIGATION
═══════════════════════════════════ -->
<nav id="nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
  <div class="max-w-screen-xl mx-auto flex items-center justify-between px-8 h-[68px]">

    <!-- Logo -->
    <a href="#" class="flex items-center gap-3 group">
      <div class="w-9 h-9 bg-amber rounded-xl flex items-center justify-center text-white font-display font-bold text-lg italic">S</div>
      <span class="font-display font-bold text-xl tracking-tight text-ink-soft">Segnon<span class="text-amber">Shop</span></span>
    </a>

    <!-- Links -->
    <div class="hidden md:flex items-center gap-1">
      <a href="#categories" class="px-4 py-2 text-sm text-ink-muted hover:text-ink hover:bg-ink/5 rounded-full transition-all duration-200">Catalogue</a>
      <a href="#produits"   class="px-4 py-2 text-sm text-ink-muted hover:text-ink hover:bg-ink/5 rounded-full transition-all duration-200">Produits</a>
      <a href="#promos"     class="px-4 py-2 text-sm text-ink-muted hover:text-ink hover:bg-ink/5 rounded-full transition-all duration-200">Promotions</a>
      <a href="#avis"       class="px-4 py-2 text-sm text-ink-muted hover:text-ink hover:bg-ink/5 rounded-full transition-all duration-200">Avis</a>
      <a href="#contact"    class="px-4 py-2 text-sm text-ink-muted hover:text-ink hover:bg-ink/5 rounded-full transition-all duration-200">Contact</a>
    </div>

    <!-- CTAs -->
    <div class="hidden md:flex items-center gap-3">
      <a href="tel:+22900000000" class="flex items-center gap-2 px-5 py-2.5 rounded-full border border-ink/15 text-sm text-ink-soft hover:border-ink/40 hover:text-ink transition-all duration-200">
        📞 Appeler
      </a>
      <a href="https://wa.me/22900000000" class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-emerald text-white text-sm font-medium hover:bg-emerald/90 transition-all duration-200 shadow-lg shadow-emerald/20">
        💬 WhatsApp
      </a>
    </div>
  </div>
</nav>

<!-- ═══════════════════════════════════
     HERO
═══════════════════════════════════ -->
<section class="relative min-h-screen grid grid-cols-1 lg:grid-cols-2 overflow-hidden">

  <!-- LEFT — Text -->
  <div class="relative z-10 flex flex-col justify-center px-8 md:px-16 py-20 lg:py-24 bg-ivory">


    <!-- Headline -->
    <h1 class="font-display font-black leading-[.92] tracking-tight mb-8" style="font-size: clamp(56px, 7vw, 104px); animation: fadeUp .7s .2s both">
      <span class="block text-ink">Votre</span>
      <span class="block text-amber italic">intérieur,</span>
      <span class="block text-ink">sublimé.</span>
    </h1>

    <!-- Desc -->
    <p class="text-ink-muted text-lg leading-relaxed max-w-[420px] mb-10 font-light" style="animation: fadeUp .7s .35s both">
      Rideaux premium, draps de luxe, quincaillerie design et décoration — tout pour transformer chaque pièce de votre maison.
    </p>

    <!-- Actions -->
    <div class="flex flex-wrap gap-4 mb-14" style="animation: fadeUp .7s .5s both">
      <a href="#categories" class="inline-flex items-center gap-3 px-8 py-4 bg-ink text-white text-sm font-semibold rounded-2xl hover:bg-amber transition-all duration-300 shadow-xl shadow-ink/20 hover:shadow-amber/30 hover:-translate-y-1">
        Explorer
        <span class="text-base">→</span>
      </a>
      <a href="https://wa.me/22900000000" class="inline-flex items-center gap-3 px-7 py-4 border-2 border-emerald text-emerald text-sm font-semibold rounded-2xl hover:bg-emerald hover:text-white transition-all duration-300 hover:-translate-y-1">
        💬 WhatsApp
      </a>
    </div>

    <!-- Stats -->
    {{-- <div class="flex gap-10 pt-8 border-t border-ink/10" style="animation: fadeUp .7s .65s both">
      <div>
        <div class="font-display text-4xl font-black text-ink tracking-tight">200<span class="text-amber text-2xl">+</span></div>
        <div class="text-xs text-ink-muted mt-1 font-medium uppercase tracking-wider">Produits</div>
      </div>
      <div class="w-px bg-ink/10"></div>
      <div>
        <div class="font-display text-4xl font-black text-ink tracking-tight">1.2k</div>
        <div class="text-xs text-ink-muted mt-1 font-medium uppercase tracking-wider">Clients</div>
      </div>
      <div class="w-px bg-ink/10"></div>
      <div>
        <div class="font-display text-4xl font-black text-ink tracking-tight">4.9<span class="text-gold text-2xl">★</span></div>
        <div class="text-xs text-ink-muted mt-1 font-medium uppercase tracking-wider">Note</div>
      </div>
    </div> --}}
  </div>

  <!-- RIGHT — Visual -->
  <div class="relative bg-amber-pale hero-img-clip overflow-hidden hidden lg:block noise">

    <!-- Ambient blobs -->
    <div class="absolute top-1/4 right-1/4 w-80 h-80 rounded-full bg-amber/20 blur-3xl"></div>
    <div class="absolute bottom-1/3 left-1/4 w-60 h-60 rounded-full bg-emerald/15 blur-3xl"></div>

    <!-- Center shape -->
    <div class="absolute inset-0 flex items-center justify-center">
      <div class="relative">
        <!-- Big pill -->
        <div class="w-[340px] h-[440px] rounded-[120px] bg-gradient-to-br from-amber-light/80 to-amber/40 flex items-center justify-center animate-float-slow shadow-2xl shadow-amber/30">
          <span class="text-[110px] drop-shadow-xl">🪟</span>
        </div>
        <!-- Stripe deco -->
        <div class="absolute -bottom-6 -right-6 w-48 h-48 rounded-3xl stripe-deco opacity-60 -z-10"></div>
      </div>
    </div>

    <!-- Floating chips -->
    <div class="absolute top-[18%] left-[5%] animate-float-med">
      <div class="bg-white/90 backdrop-blur rounded-2xl p-4 shadow-xl flex items-center gap-3 border border-white/60">
        <div class="w-10 h-10 rounded-xl bg-emerald-light flex items-center justify-center text-xl">🛏️</div>
        <div>
          <div class="text-[11px] text-ink-muted font-medium">Nouveauté</div>
          <div class="text-sm font-bold text-ink-soft">Draps Satin 2025</div>
        </div>
      </div>
    </div>

    <div class="absolute bottom-[25%] right-[6%] animate-float-med" style="animation-delay:1.2s">
      <div class="bg-white/90 backdrop-blur rounded-2xl p-4 shadow-xl flex items-center gap-3 border border-white/60">
        <div class="w-10 h-10 rounded-xl bg-amber-pale flex items-center justify-center text-xl">🏷️</div>
        <div>
          <div class="text-[11px] text-ink-muted font-medium">Promo</div>
          <div class="text-sm font-bold text-amber">–30% Rideaux</div>
        </div>
      </div>
    </div>

    <div class="absolute top-[55%] left-[8%] animate-float-med" style="animation-delay:.6s">
      <div class="bg-white/90 backdrop-blur rounded-2xl p-4 shadow-xl flex items-center gap-3 border border-white/60">
        <div class="w-10 h-10 rounded-xl bg-gold-pale flex items-center justify-center text-xl">⭐</div>
        <div>
          <div class="text-[11px] text-ink-muted font-medium">Avis clients</div>
          <div class="text-sm font-bold text-ink-soft">4.9 · 150+ avis</div>
        </div>
      </div>
    </div>

    <!-- Bottom accent strip -->
    <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-amber via-gold to-emerald"></div>
  </div>
</section>


<!-- ═══════════════════════════════════
     TICKER
═══════════════════════════════════ -->
<div class="bg-ink overflow-hidden py-4 border-y-2 border-amber/30">
  <div class="ticker-wrap" style="white-space:nowrap">
    <!-- 2× for seamless loop -->
    <template id="tpl">
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-white/60">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> Rideaux Premium
      </span>
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-amber">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> Draps de Luxe
      </span>
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-white/60">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> Livraison Rapide
      </span>
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-emerald-light">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> Qualité Garantie
      </span>
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-white/60">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> Décoration Intérieure
      </span>
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-gold">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> 200+ Produits
      </span>
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-white/60">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> Quincaillerie Design
      </span>
      <span class="inline-flex items-center gap-3 px-7 text-[13px] font-medium uppercase tracking-[.1em] text-amber">
        <span class="w-1.5 h-1.5 rounded-full bg-amber flex-shrink-0"></span> WhatsApp Direct ✦
      </span>
    </template>
  </div>
</div>


<!-- ═══════════════════════════════════
     CATEGORIES
═══════════════════════════════════ -->
<section class="py-28 px-6 md:px-14 bg-ivory" id="categories">
  <div class="max-w-screen-xl mx-auto">

    <!-- Header -->
    <div class="flex items-end justify-between mb-14 reveal">
      <div>
        <div class="flex items-center gap-2 mb-3">
          <span class="w-6 h-0.5 bg-amber rounded-full"></span>
          <span class="text-xs font-bold tracking-[.18em] uppercase text-amber">Nos Collections</span>
        </div>
        <h2 class="font-display font-black text-ink leading-none tracking-tight" style="font-size:clamp(38px,4.5vw,68px)">
          Explorez par <em class="text-amber italic font-black">catégorie</em>
        </h2>
      </div>
      <a href="#" class="hidden md:flex items-center gap-2 text-sm font-semibold text-ink-muted border-b-2 border-ink/15 pb-0.5 hover:text-amber hover:border-amber transition-all duration-200">
        Tout voir <span>→</span>
      </a>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">

      <!-- Card: Rideaux (big) -->
      <div class="cat-card lg:col-span-2 lg:row-span-2 relative rounded-3xl overflow-hidden cursor-pointer group reveal" style="min-height:480px; background: linear-gradient(145deg,#FDF0E0,#F0C99A)">
        <div class="absolute top-5 left-5 z-20">
          <span class="px-3 py-1 rounded-full bg-amber text-white text-[11px] font-bold uppercase tracking-wider">⭐ Le plus populaire</span>
        </div>
        <div class="cat-inner-emoji absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[60%] text-[110px] drop-shadow-2xl">🪟</div>
        <!-- Stripe deco -->
        <div class="absolute bottom-0 right-0 w-40 h-40 stripe-deco opacity-40 rounded-tl-3xl"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-amber/30 via-amber/10 to-transparent">
          <div class="text-[11px] text-amber-800/70 font-semibold uppercase tracking-widest mb-1">80+ références</div>
          <div class="font-display font-black text-3xl text-ink-soft tracking-tight">Rideaux</div>
          <div class="text-sm text-ink-muted mt-1">Voilages · Occultants · Sur-mesure</div>
        </div>
        <div class="absolute top-5 right-5 w-9 h-9 bg-white/80 backdrop-blur rounded-xl flex items-center justify-center text-amber font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 text-sm">↗</div>
      </div>

      <!-- Card: Draps -->
      <div class="cat-card relative rounded-3xl overflow-hidden cursor-pointer group reveal delay-1" style="min-height:230px; background:linear-gradient(145deg,#D4EAE0,#A8D4C0)">
        <div class="absolute top-5 left-5 z-20">
          <span class="px-3 py-1 rounded-full bg-emerald text-white text-[11px] font-bold uppercase tracking-wider">✦ Nouveau</span>
        </div>
        <div class="cat-inner-emoji absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[65%] text-7xl drop-shadow-xl">🛏️</div>
        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-emerald/30 to-transparent">
          <div class="font-display font-black text-2xl text-ink-soft tracking-tight">Draps</div>
          <div class="text-xs text-ink-muted mt-0.5">Coton · Satin · Microfibre</div>
        </div>
        <div class="absolute top-5 right-5 w-8 h-8 bg-white/80 backdrop-blur rounded-xl flex items-center justify-center text-emerald font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 text-sm">↗</div>
      </div>

      <!-- Card: Quincaillerie -->
      <div class="cat-card relative rounded-3xl overflow-hidden cursor-pointer group reveal delay-2" style="min-height:230px; background:linear-gradient(145deg,#FDF5E0,#EDD9A3)">
        <div class="cat-inner-emoji absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[65%] text-7xl drop-shadow-xl">🔧</div>
        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-gold/20 to-transparent">
          <div class="font-display font-black text-2xl text-ink-soft tracking-tight">Quincaillerie</div>
          <div class="text-xs text-ink-muted mt-0.5">Tringles · Crochets · Rails</div>
        </div>
        <div class="absolute top-5 right-5 w-8 h-8 bg-white/80 backdrop-blur rounded-xl flex items-center justify-center text-gold font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 text-sm">↗</div>
      </div>

      <!-- Card: Décoration -->
      <div class="cat-card relative rounded-3xl overflow-hidden cursor-pointer group reveal delay-1" style="min-height:230px; background:linear-gradient(145deg,#EAF0F8,#C0D4E8)">
        <div class="absolute top-5 left-5 z-20">
          <span class="px-3 py-1 rounded-full bg-rouge text-white text-[11px] font-bold uppercase tracking-wider">–20%</span>
        </div>
        <div class="cat-inner-emoji absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[65%] text-7xl drop-shadow-xl">🏺</div>
        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-blue-400/20 to-transparent">
          <div class="font-display font-black text-2xl text-ink-soft tracking-tight">Décoration</div>
          <div class="text-xs text-ink-muted mt-0.5">Coussins · Tapis · Art déco</div>
        </div>
        <div class="absolute top-5 right-5 w-8 h-8 bg-white/80 backdrop-blur rounded-xl flex items-center justify-center text-blue-600 font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 text-sm">↗</div>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════
     PRODUCTS
═══════════════════════════════════ -->
<section class="py-28 px-6 md:px-14 bg-ivory-dark" id="produits">
  <div class="max-w-screen-xl mx-auto">

    <div class="flex items-end justify-between mb-14 reveal">
      <div>
        <div class="flex items-center gap-2 mb-3">
          <span class="w-6 h-0.5 bg-emerald rounded-full"></span>
          <span class="text-xs font-bold tracking-[.18em] uppercase text-emerald">Sélection</span>
        </div>
        <h2 class="font-display font-black text-ink leading-none tracking-tight" style="font-size:clamp(38px,4.5vw,68px)">
          Produits <em class="italic text-emerald">vedettes</em>
        </h2>
      </div>
      <!-- Tabs -->
      <div class="hidden md:flex gap-2">
        <button onclick="tabActive(this)" class="tab-btn active px-4 py-2 rounded-full text-sm font-semibold bg-ink text-white transition-all">Tous</button>
        <button onclick="tabActive(this)" class="tab-btn px-4 py-2 rounded-full text-sm font-semibold border border-ink/20 text-ink-muted hover:border-ink/50 hover:text-ink transition-all">Rideaux</button>
        <button onclick="tabActive(this)" class="tab-btn px-4 py-2 rounded-full text-sm font-semibold border border-ink/20 text-ink-muted hover:border-ink/50 hover:text-ink transition-all">Draps</button>
        <button onclick="tabActive(this)" class="tab-btn px-4 py-2 rounded-full text-sm font-semibold border border-ink/20 text-ink-muted hover:border-ink/50 hover:text-ink transition-all">Déco</button>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

      <!-- Product card macro -->
      <!-- P1 -->
      <div class="prod-card bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-amber/15 reveal">
        <div class="relative h-56 flex items-center justify-center" style="background:linear-gradient(145deg,#FDF0E0,#F0C99A)">
          <span class="text-8xl drop-shadow-xl">🪟</span>
          <span class="absolute top-4 left-4 bg-rouge text-white text-[11px] font-bold px-3 py-1 rounded-full">–25%</span>
          <div class="prod-overlay absolute inset-0 bg-ink/60 backdrop-blur-sm flex flex-col items-center justify-center gap-3 p-4">
            <a href="https://wa.me/22900000000?text=Rideau Velours" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1aab52] transition-colors">💬 Commander WhatsApp</a>
            <a href="tel:+22900000000" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-white text-ink text-sm font-semibold hover:bg-ivory transition-colors">📞 Appeler maintenant</a>
          </div>
        </div>
        <div class="p-5">
          <div class="text-[11px] font-bold uppercase tracking-widest text-amber mb-2">Rideaux</div>
          <div class="font-display font-bold text-lg text-ink-soft mb-4 leading-tight">Rideau Velours Anthracite</div>
          <div class="flex items-end justify-between">
            <div>
              <div class="font-display font-black text-xl text-ink">15 000 F</div>
              <div class="text-xs text-ink-faint line-through mt-0.5">20 000 F</div>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-ink-muted">
              <span class="text-gold">★★★★★</span> (42)
            </div>
          </div>
        </div>
      </div>

      <!-- P2 -->
      <div class="prod-card bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-emerald/15 reveal delay-1">
        <div class="relative h-56 flex items-center justify-center" style="background:linear-gradient(145deg,#D4EAE0,#A8D4C0)">
          <span class="text-8xl drop-shadow-xl">🛏️</span>
          <span class="absolute top-4 left-4 bg-emerald text-white text-[11px] font-bold px-3 py-1 rounded-full">Nouveau</span>
          <div class="prod-overlay absolute inset-0 bg-ink/60 backdrop-blur-sm flex flex-col items-center justify-center gap-3 p-4">
            <a href="https://wa.me/22900000000?text=Drap Satin" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1aab52] transition-colors">💬 Commander WhatsApp</a>
            <a href="tel:+22900000000" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-white text-ink text-sm font-semibold hover:bg-ivory transition-colors">📞 Appeler maintenant</a>
          </div>
        </div>
        <div class="p-5">
          <div class="text-[11px] font-bold uppercase tracking-widest text-emerald mb-2">Draps</div>
          <div class="font-display font-bold text-lg text-ink-soft mb-4 leading-tight">Drap Satin Blanc Royal</div>
          <div class="flex items-end justify-between">
            <div>
              <div class="font-display font-black text-xl text-ink">12 500 F</div>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-ink-muted">
              <span class="text-gold">★★★★★</span> (28)
            </div>
          </div>
        </div>
      </div>

      <!-- P3 -->
      <div class="prod-card bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-gold/15 reveal delay-2">
        <div class="relative h-56 flex items-center justify-center" style="background:linear-gradient(145deg,#FDF5E0,#EDD9A3)">
          <span class="text-8xl drop-shadow-xl">🔧</span>
          <div class="prod-overlay absolute inset-0 bg-ink/60 backdrop-blur-sm flex flex-col items-center justify-center gap-3 p-4">
            <a href="https://wa.me/22900000000?text=Tringle" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1aab52] transition-colors">💬 Commander WhatsApp</a>
            <a href="tel:+22900000000" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-white text-ink text-sm font-semibold hover:bg-ivory transition-colors">📞 Appeler maintenant</a>
          </div>
        </div>
        <div class="p-5">
          <div class="text-[11px] font-bold uppercase tracking-widest text-gold mb-2">Quincaillerie</div>
          <div class="font-display font-bold text-lg text-ink-soft mb-4 leading-tight">Tringle Double Chromée 200cm</div>
          <div class="flex items-end justify-between">
            <div>
              <div class="font-display font-black text-xl text-ink">8 000 F</div>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-ink-muted">
              <span class="text-gold">★★★★☆</span> (19)
            </div>
          </div>
        </div>
      </div>

      <!-- P4 -->
      <div class="prod-card bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-blue-200/60 reveal delay-3">
        <div class="relative h-56 flex items-center justify-center" style="background:linear-gradient(145deg,#EAF0F8,#C0D4E8)">
          <span class="text-8xl drop-shadow-xl">🏺</span>
          <span class="absolute top-4 left-4 bg-rouge text-white text-[11px] font-bold px-3 py-1 rounded-full">–15%</span>
          <div class="prod-overlay absolute inset-0 bg-ink/60 backdrop-blur-sm flex flex-col items-center justify-center gap-3 p-4">
            <a href="https://wa.me/22900000000?text=Coussins" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1aab52] transition-colors">💬 Commander WhatsApp</a>
            <a href="tel:+22900000000" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-white text-ink text-sm font-semibold hover:bg-ivory transition-colors">📞 Appeler maintenant</a>
          </div>
        </div>
        <div class="p-5">
          <div class="text-[11px] font-bold uppercase tracking-widest text-blue-500 mb-2">Décoration</div>
          <div class="font-display font-bold text-lg text-ink-soft mb-4 leading-tight">Set 4 Coussins Déco Premium</div>
          <div class="flex items-end justify-between">
            <div>
              <div class="font-display font-black text-xl text-ink">18 700 F</div>
              <div class="text-xs text-ink-faint line-through mt-0.5">22 000 F</div>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-ink-muted">
              <span class="text-gold">★★★★★</span> (55)
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════
     CTA BAND — EMERALD
═══════════════════════════════════ -->
<section class="relative overflow-hidden bg-emerald py-24 px-6 md:px-14 noise reveal">
  <!-- Watermark -->
  <div class="absolute inset-y-0 right-0 flex items-center pointer-events-none overflow-hidden">
    <span class="font-display font-black italic text-white/[.05] select-none leading-none" style="font-size:220px;white-space:nowrap">SEGNON</span>
  </div>
  <!-- Circle deco -->
  <div class="absolute -top-20 -left-20 w-64 h-64 rounded-full border border-white/10"></div>
  <div class="absolute -bottom-12 right-24 w-40 h-40 rounded-full border border-white/10"></div>

  <div class="max-w-screen-xl mx-auto relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
    <div class="text-center lg:text-left">
      <div class="inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full border border-white/20 text-white/70 text-xs font-semibold uppercase tracking-widest">
        ✦ Contact Direct
      </div>
      <h2 class="font-display font-black text-white leading-none tracking-tight mb-5" style="font-size:clamp(40px,5vw,76px)">
        Besoin d'un<br><em class="italic font-black" style="color:#F0C99A">conseil ?</em>
      </h2>
      <p class="text-white/65 text-lg max-w-md font-light leading-relaxed">
        Nos conseillers répondent en moins de 5 minutes. Choisissez votre couleur, taille ou style — on vous guide.
      </p>
    </div>
    <div class="flex flex-col gap-4 min-w-[280px]">
      <a href="https://wa.me/22900000000?text=Bonjour Segnon Shop" class="flex items-center justify-center gap-3 py-5 px-10 bg-white text-emerald font-bold rounded-2xl text-base hover:translate-x-2 transition-transform duration-300 shadow-2xl">
        <span class="text-xl">💬</span> Écrire sur WhatsApp
      </a>
      <a href="tel:+22900000000" class="flex items-center justify-center gap-3 py-4 px-10 bg-white/15 text-white font-semibold rounded-2xl text-base border-2 border-white/25 hover:bg-white/25 transition-colors duration-200">
        <span class="text-xl">📞</span> Appeler maintenant
      </a>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════
     COMMENT ÇA MARCHE
═══════════════════════════════════ -->
<section class="py-28 px-6 md:px-14 bg-white" id="process">
  <div class="max-w-screen-xl mx-auto">
    <div class="text-center mb-16 reveal">
      <div class="inline-flex items-center gap-2 mb-4">
        <span class="w-6 h-0.5 bg-gold rounded-full"></span>
        <span class="text-xs font-bold tracking-[.18em] uppercase text-gold">Comment ça marche</span>
        <span class="w-6 h-0.5 bg-gold rounded-full"></span>
      </div>
      <h2 class="font-display font-black text-ink leading-none tracking-tight" style="font-size:clamp(36px,4vw,64px)">
        Commander en <em class="italic text-gold">4 étapes</em>
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
      <!-- Step cards -->
      <div class="why-card group relative rounded-3xl border-2 border-ivory-dark bg-ivory p-8 hover:border-amber hover:bg-amber-pale reveal">
        <div class="font-display font-black text-6xl text-ink/10 group-hover:text-amber/20 transition-colors leading-none mb-5 tracking-tight">01</div>
        <div class="text-4xl mb-4">🔍</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Explorez</div>
        <div class="text-sm text-ink-muted leading-relaxed">Parcourez notre catalogue en ligne et repérez les produits qui correspondent à votre style.</div>
        <div class="absolute top-1/2 -right-[13px] w-6 h-6 rounded-full bg-white border-2 border-amber/30 hidden lg:flex items-center justify-center text-xs text-ink-muted z-10">→</div>
      </div>
      <div class="why-card group relative rounded-3xl border-2 border-ivory-dark bg-ivory p-8 hover:border-emerald hover:bg-emerald-light delay-1 reveal">
        <div class="font-display font-black text-6xl text-ink/10 group-hover:text-emerald/20 transition-colors leading-none mb-5 tracking-tight">02</div>
        <div class="text-4xl mb-4">💬</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Contactez</div>
        <div class="text-sm text-ink-muted leading-relaxed">WhatsApp ou téléphone — réponse garantie en moins de 5 minutes par notre équipe.</div>
        <div class="absolute top-1/2 -right-[13px] w-6 h-6 rounded-full bg-white border-2 border-emerald/30 hidden lg:flex items-center justify-center text-xs text-ink-muted z-10">→</div>
      </div>
      <div class="why-card group relative rounded-3xl border-2 border-ivory-dark bg-ivory p-8 hover:border-gold hover:bg-gold-pale delay-2 reveal">
        <div class="font-display font-black text-6xl text-ink/10 group-hover:text-gold/20 transition-colors leading-none mb-5 tracking-tight">03</div>
        <div class="text-4xl mb-4">✅</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Confirmez</div>
        <div class="text-sm text-ink-muted leading-relaxed">Validez votre commande, choisissez entre livraison express ou retrait en boutique.</div>
        <div class="absolute top-1/2 -right-[13px] w-6 h-6 rounded-full bg-white border-2 border-gold/30 hidden lg:flex items-center justify-center text-xs text-ink-muted z-10">→</div>
      </div>
      <div class="why-card group rounded-3xl border-2 border-ivory-dark bg-ivory p-8 hover:border-rouge hover:bg-rouge-pale delay-3 reveal">
        <div class="font-display font-black text-6xl text-ink/10 group-hover:text-rouge/20 transition-colors leading-none mb-5 tracking-tight">04</div>
        <div class="text-4xl mb-4">🎉</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Profitez</div>
        <div class="text-sm text-ink-muted leading-relaxed">Votre intérieur est transformé. Qualité premium, satisfaction 100% garantie.</div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════
     PROMOS
═══════════════════════════════════ -->
<section class="py-28 px-6 md:px-14 bg-ivory" id="promos">
  <div class="max-w-screen-xl mx-auto">
    <div class="mb-14 reveal">
      <div class="flex items-center gap-2 mb-3">
        <span class="w-6 h-0.5 bg-rouge rounded-full"></span>
        <span class="text-xs font-bold tracking-[.18em] uppercase text-rouge">Offres Spéciales</span>
      </div>
      <h2 class="font-display font-black text-ink leading-none tracking-tight" style="font-size:clamp(36px,4vw,64px)">
        Promotions <em class="italic text-rouge">du moment</em>
      </h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

      <!-- Big promo -->
      <div class="promo-hover lg:col-span-3 relative rounded-3xl overflow-hidden cursor-pointer reveal" style="min-height:420px;background:linear-gradient(140deg,#B5651D 0%,#8B3A0D 100%)">
        <div class="absolute inset-0 noise"></div>
        <!-- Pattern -->
        <div class="absolute inset-0 stripe-deco opacity-20"></div>
        <!-- Watermark -->
        <div class="absolute -right-6 top-4 font-display font-black italic text-white/10 leading-none select-none" style="font-size:120px">–30%</div>
        <!-- Badge -->
        <div class="absolute top-6 left-6">
          <span class="px-4 py-1.5 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold uppercase tracking-wider">⏳ Offre limitée</span>
        </div>
        <div class="absolute bottom-0 left-0 right-0 p-10 z-10">
          <div class="font-display font-black text-white leading-none tracking-tight mb-3" style="font-size:88px">–30%</div>
          <div class="text-white/70 text-lg mb-8 font-light">Sur toute la gamme Rideaux · Jusqu'à fin du mois</div>
          <a href="https://wa.me/22900000000?text=Promo rideaux -30%" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-amber font-bold rounded-xl hover:bg-ivory transition-colors text-sm shadow-xl">
            Profiter de l'offre →
          </a>
        </div>
        <div class="absolute top-1/2 right-10 -translate-y-1/2 text-[120px] opacity-30">🪟</div>
      </div>

      <!-- Small promos -->
      <div class="lg:col-span-2 flex flex-col gap-5">
        <div class="promo-hover relative rounded-3xl overflow-hidden cursor-pointer flex-1 reveal delay-1" style="min-height:190px;background:linear-gradient(145deg,#D4EAE0,#A8D4C0)">
          <div class="absolute top-1/2 right-6 -translate-y-1/2 text-8xl opacity-25">🛏️</div>
          <div class="p-8 relative z-10 h-full flex flex-col justify-end">
            <div class="text-3xl mb-2">🛏️</div>
            <div class="font-display font-black text-2xl text-ink-soft mb-1">Collection Draps</div>
            <div class="text-sm text-emerald font-semibold">–20% sur les draps Satin · Ce weekend</div>
          </div>
        </div>
        <div class="promo-hover relative rounded-3xl overflow-hidden cursor-pointer flex-1 reveal delay-2" style="min-height:190px;background:linear-gradient(145deg,#FDF5E0,#EDD9A3)">
          <div class="absolute top-1/2 right-6 -translate-y-1/2 text-8xl opacity-25">🏺</div>
          <div class="p-8 relative z-10 h-full flex flex-col justify-end">
            <div class="text-3xl mb-2">🏺</div>
            <div class="font-display font-black text-2xl text-ink-soft mb-1">Pack Décoration</div>
            <div class="text-sm text-gold font-semibold">3 articles pour 25 000 F · Économisez 8 000 F</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════
     WHY US
═══════════════════════════════════ -->
<section class="py-28 px-6 md:px-14 bg-ivory-dark">
  <div class="max-w-screen-xl mx-auto">
    <div class="text-center mb-16 reveal">
      <div class="inline-flex items-center gap-2 mb-4">
        <span class="w-6 h-0.5 bg-emerald rounded-full"></span>
        <span class="text-xs font-bold tracking-[.18em] uppercase text-emerald">Pourquoi nous</span>
        <span class="w-6 h-0.5 bg-emerald rounded-full"></span>
      </div>
      <h2 class="font-display font-black text-ink leading-none tracking-tight" style="font-size:clamp(36px,4vw,64px)">
        Ce qui nous <em class="italic text-emerald">distingue</em>
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <div class="why-card group bg-white rounded-3xl p-8 border border-ivory-dark hover:border-amber hover:shadow-xl hover:shadow-amber/10 reveal">
        <div class="w-14 h-14 rounded-2xl bg-amber-pale flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">🏆</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Qualité Garantie</div>
        <div class="text-sm text-ink-muted leading-relaxed">Chaque produit passe un contrôle qualité strict. Nous ne référençons que ce qui mérite votre confiance.</div>
      </div>
      <div class="why-card group bg-white rounded-3xl p-8 border border-ivory-dark hover:border-emerald hover:shadow-xl hover:shadow-emerald/10 reveal delay-1">
        <div class="w-14 h-14 rounded-2xl bg-emerald-light flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">💰</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Prix Imbattables</div>
        <div class="text-sm text-ink-muted leading-relaxed">Les meilleurs prix du marché avec des promotions régulières. On s'aligne ou on rembourse la différence.</div>
      </div>
      <div class="why-card group bg-white rounded-3xl p-8 border border-ivory-dark hover:border-gold hover:shadow-xl hover:shadow-gold/10 reveal delay-2">
        <div class="w-14 h-14 rounded-2xl bg-gold-pale flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">⚡</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Livraison Express</div>
        <div class="text-sm text-ink-muted leading-relaxed">Commandes traitées le jour même. Livraison à domicile rapide et fiable dans toute la zone.</div>
      </div>
      <div class="why-card group bg-white rounded-3xl p-8 border border-ivory-dark hover:border-[#25D366] hover:shadow-xl hover:shadow-green-200 reveal">
        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">💬</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Support WhatsApp</div>
        <div class="text-sm text-ink-muted leading-relaxed">7j/7 sur WhatsApp. Conseils personnalisés, suivi de commande et SAV ultra-réactif.</div>
      </div>
      <div class="why-card group bg-white rounded-3xl p-8 border border-ivory-dark hover:border-blue-400 hover:shadow-xl hover:shadow-blue-100 reveal delay-1">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">🎨</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Large Catalogue</div>
        <div class="text-sm text-ink-muted leading-relaxed">200+ produits dans 4 univers distincts. Nouvelles collections régulièrement ajoutées.</div>
      </div>
      <div class="why-card group bg-white rounded-3xl p-8 border border-ivory-dark hover:border-rouge hover:shadow-xl hover:shadow-red-100 reveal delay-2">
        <div class="w-14 h-14 rounded-2xl bg-rouge-pale flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">🛡️</div>
        <div class="font-display font-bold text-xl text-ink mb-3">Satisfait ou Repris</div>
        <div class="text-sm text-ink-muted leading-relaxed">Pas satisfait ? On reprend le produit. Votre confiance est notre priorité absolue.</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════
     NEWSLETTER — AMBER
═══════════════════════════════════ -->
<section class="py-20 px-6 md:px-14 bg-ink noise relative overflow-hidden reveal">
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-amber/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -right-20 w-80 h-80 rounded-full bg-emerald/10 blur-3xl pointer-events-none"></div>
    <div class="max-w-screen-xl mx-auto relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
      <div>
        <h3 class="font-display font-black text-white leading-none tracking-tight mb-3" style="font-size:clamp(32px,3.5vw,56px)">
          Offres exclusives <em class="italic text-amber-light font-black">en avant-première.</em>
        </h3>
        <p class="text-white/50 text-base font-light max-w-md leading-relaxed">Inscrivez-vous et recevez nos promotions et nouvelles collections avant tout le monde.</p>
      </div>
      <form onsubmit="submitNL(event)" class="flex flex-col gap-3 min-w-[340px]">
        <div class="flex">
          <input type="email" id="nlEmail" placeholder="votre@email.com" required class="flex-1 px-5 py-4 bg-white/8 border border-white/15 rounded-l-xl text-white placeholder-white/30 outline-none focus:border-amber text-sm transition-colors" style="background:rgba(255,255,255,.07)">
          <button type="submit" id="nlBtn" class="px-7 py-4 bg-amber text-white font-semibold rounded-r-xl hover:bg-amber/90 transition-colors text-sm whitespace-nowrap">S'inscrire →</button>
        </div>
        <p class="text-white/25 text-xs text-center">🔒 Aucun spam. Désinscription en un clic.</p>
      </form>
    </div>
  </section>

  
<!-- ═══════════════════════════════════
     TÉMOIGNAGES
═══════════════════════════════════ -->
<section class="py-28 px-6 md:px-14 bg-white" id="avis">
  <div class="max-w-screen-xl mx-auto">
    <div class="flex items-end justify-between mb-14 reveal">
      <div>
        <div class="flex items-center gap-2 mb-3">
          <span class="w-6 h-0.5 bg-gold rounded-full"></span>
          <span class="text-xs font-bold tracking-[.18em] uppercase text-gold">Témoignages</span>
        </div>
        <h2 class="font-display font-black text-ink leading-none tracking-tight" style="font-size:clamp(36px,4vw,64px)">
          Ils parlent de <em class="italic text-gold">nous</em>
        </h2>
      </div>
      <div class="hidden md:flex flex-col items-end gap-1">
        <div class="flex gap-0.5 text-gold text-2xl">★★★★★</div>
        <div class="font-display font-black text-3xl text-ink">4.9/5</div>
        <div class="text-xs text-ink-muted">150+ avis vérifiés</div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <!-- T1 -->
      <div class="testi-card bg-ivory rounded-3xl p-8 border border-ivory-dark hover:shadow-2xl hover:shadow-amber/10 relative reveal">
        <div class="absolute top-6 right-6 text-[11px] font-semibold text-emerald bg-emerald-light px-3 py-1 rounded-full">✓ Vérifié</div>
        <div class="font-display italic font-black text-6xl text-amber/20 leading-none mb-3">"</div>
        <div class="flex gap-0.5 text-gold text-sm mb-4">★★★★★</div>
        <p class="text-ink-soft leading-relaxed mb-7 text-[15px] font-light">Commande reçue en 24h, qualité vraiment exceptionnelle. Les rideaux sont exactement comme sur les photos. Service client au top !</p>
        <div class="flex items-center gap-3 pt-5 border-t border-ivory-dark">
          <div class="w-11 h-11 rounded-2xl bg-amber flex items-center justify-center font-display font-bold italic text-white text-lg">A</div>
          <div>
            <div class="font-semibold text-ink-soft text-sm">Aminata Coulibaly</div>
            <div class="text-xs text-ink-muted mt-0.5">📍 Cotonou · Cliente fidèle</div>
          </div>
        </div>
      </div>
      <!-- T2 -->
      <div class="testi-card bg-ivory rounded-3xl p-8 border border-ivory-dark hover:shadow-2xl hover:shadow-emerald/10 relative reveal delay-1">
        <div class="absolute top-6 right-6 text-[11px] font-semibold text-emerald bg-emerald-light px-3 py-1 rounded-full">✓ Vérifié</div>
        <div class="font-display italic font-black text-6xl text-emerald/20 leading-none mb-3">"</div>
        <div class="flex gap-0.5 text-gold text-sm mb-4">★★★★★</div>
        <p class="text-ink-soft leading-relaxed mb-7 text-[15px] font-light">WhatsApp ultra-réactif, réponse en moins de 2 minutes ! Les draps satin sont d'une douceur incroyable. Je recommande à 100%.</p>
        <div class="flex items-center gap-3 pt-5 border-t border-ivory-dark">
          <div class="w-11 h-11 rounded-2xl bg-emerald flex items-center justify-center font-display font-bold italic text-white text-lg">K</div>
          <div>
            <div class="font-semibold text-ink-soft text-sm">Kofi Mensah</div>
            <div class="text-xs text-ink-muted mt-0.5">📍 Porto-Novo</div>
          </div>
        </div>
      </div>
      <!-- T3 -->
      <div class="testi-card bg-ivory rounded-3xl p-8 border border-ivory-dark hover:shadow-2xl hover:shadow-gold/10 relative reveal delay-2">
        <div class="absolute top-6 right-6 text-[11px] font-semibold text-emerald bg-emerald-light px-3 py-1 rounded-full">✓ Vérifié</div>
        <div class="font-display italic font-black text-6xl text-gold/20 leading-none mb-3">"</div>
        <div class="flex gap-0.5 text-gold text-sm mb-4">★★★★★</div>
        <p class="text-ink-soft leading-relaxed mb-7 text-[15px] font-light">Mon salon a été totalement transformé. Prix imbattables, qualité au top. Je reviens régulièrement pour mes nouvelles décorations !</p>
        <div class="flex items-center gap-3 pt-5 border-t border-ivory-dark">
          <div class="w-11 h-11 rounded-2xl bg-gold flex items-center justify-center font-display font-bold italic text-white text-lg">F</div>
          <div>
            <div class="font-semibold text-ink-soft text-sm">Fatou Diallo</div>
            <div class="text-xs text-ink-muted mt-0.5">📍 Abomey-Calavi</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>







<!-- ═══════════════════════════════════
     FOOTER
═══════════════════════════════════ -->
<footer class="bg-ink-soft pt-20 pb-10 px-6 md:px-14">
  <div class="max-w-screen-xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-16 border-b border-white/10">

      <!-- Brand -->
      <div class="lg:col-span-1">
        <a href="#" class="flex items-center gap-3 mb-5">
          <div class="w-9 h-9 bg-amber rounded-xl flex items-center justify-center text-white font-display font-bold text-lg italic">S</div>
          <span class="font-display font-bold text-xl tracking-tight text-white">Segnon<span class="text-amber">Shop</span></span>
        </a>
        <p class="text-white/40 text-sm leading-relaxed mb-7 max-w-[240px] font-light">Votre boutique premium de rideaux, draps, quincaillerie et décoration intérieure au Bénin.</p>
        <div class="flex gap-3">
          <a href="#" class="w-9 h-9 rounded-xl bg-white/8 border border-white/10 flex items-center justify-center text-white/50 hover:bg-amber hover:border-amber hover:text-white transition-all text-sm">f</a>
          <a href="#" class="w-9 h-9 rounded-xl bg-white/8 border border-white/10 flex items-center justify-center text-white/50 hover:bg-amber hover:border-amber hover:text-white transition-all text-sm">in</a>
          <a href="https://wa.me/22900000000" class="w-9 h-9 rounded-xl bg-white/8 border border-white/10 flex items-center justify-center text-white/50 hover:bg-[#25D366] hover:border-[#25D366] hover:text-white transition-all text-sm">💬</a>
        </div>
      </div>

      <!-- Nav -->
      <div>
        <div class="text-[11px] font-bold uppercase tracking-[.18em] text-white/30 mb-5">Navigation</div>
        <ul class="flex flex-col gap-3">
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Accueil</a></li>
          <li><a href="#categories" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Catégories</a></li>
          <li><a href="#produits" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Produits</a></li>
          <li><a href="#promos" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Promotions</a></li>
          <li><a href="#avis" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Avis clients</a></li>
          <li><a href="#contact" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Contact</a></li>
        </ul>
      </div>

      <!-- Produits -->
      <div>
        <div class="text-[11px] font-bold uppercase tracking-[.18em] text-white/30 mb-5">Produits</div>
        <ul class="flex flex-col gap-3">
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Rideaux Voilage</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Rideaux Occultants</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Draps Satin</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Draps Coton</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Tringles & Rails</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Coussins & Tapis</a></li>
        </ul>
      </div>

      <!-- Infos -->
      <div>
        <div class="text-[11px] font-bold uppercase tracking-[.18em] text-white/30 mb-5">Informations</div>
        <ul class="flex flex-col gap-3">
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>À propos</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Livraison & Retours</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Guide des tailles</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>FAQ</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Mentions légales</a></li>
          <li><a href="#" class="text-sm text-white/50 hover:text-amber transition-colors flex items-center gap-2 group"><span class="w-0 h-px bg-amber transition-all group-hover:w-3"></span>Confidentialité</a></li>
        </ul>
      </div>

    </div>
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-10">
      <div class="text-white/25 text-sm">© 2026 Segnon Shop. Tous droits réservés.</div>
      <div class="flex gap-6">
        <a href="#" class="text-white/25 text-sm hover:text-white/50 transition-colors">CGV</a>
        <a href="#" class="text-white/25 text-sm hover:text-white/50 transition-colors">Confidentialité</a>
        <a href="#" class="text-white/25 text-sm hover:text-white/50 transition-colors">Mentions légales</a>
      </div>
    </div>
  </div>
</footer>

<!-- Back to top -->
<button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"
  class="fixed bottom-7 right-7 w-12 h-12 bg-amber text-white rounded-xl flex items-center justify-center text-lg font-bold shadow-xl shadow-amber/30 opacity-0 translate-y-4 transition-all duration-300 hover:bg-amber/90 hover:-translate-y-1 z-50">
  ↑
</button>

<script>
// ── CURSOR ──
const dot = document.getElementById('c-dot'), ring = document.getElementById('c-ring');
let cx = 0, cy = 0;
document.addEventListener('mousemove', e => {
  cx = e.clientX; cy = e.clientY;
  dot.style.left = cx + 'px'; dot.style.top = cy + 'px';
  setTimeout(() => { ring.style.left = cx + 'px'; ring.style.top = cy + 'px'; }, 70);
});
document.querySelectorAll('a, button, .cat-card, .prod-card, .why-card, .testi-card, .promo-hover').forEach(el => {
  el.addEventListener('mouseenter', () => { dot.classList.add('big'); ring.style.transform = 'translate(-50%,-50%) scale(1.6)'; ring.style.borderColor = 'rgba(181,101,29,.6)'; });
  el.addEventListener('mouseleave', () => { dot.classList.remove('big'); ring.style.transform = 'translate(-50%,-50%) scale(1)'; ring.style.borderColor = 'rgba(181,101,29,.4)'; });
});

// ── NAVBAR ──
const nav = document.getElementById('nav');
window.addEventListener('scroll', () => {
  if (window.scrollY > 60) { nav.classList.add('nav-glass', 'shadow-sm'); }
  else { nav.classList.remove('nav-glass', 'shadow-sm'); }
  const btt = document.getElementById('btt');
  if (window.scrollY > 500) { btt.style.opacity = '1'; btt.style.transform = 'translateY(0)'; }
  else { btt.style.opacity = '0'; btt.style.transform = 'translateY(1rem)'; }
});

// ── TICKER — clone content ──
const tpl = document.getElementById('tpl');
const ticker = document.querySelector('.ticker-wrap');
if (tpl && ticker) {
  const content = tpl.innerHTML;
  ticker.innerHTML = content + content;
}

// ── REVEAL ──
const revObs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); revObs.unobserve(e.target); } });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => revObs.observe(el));

// ── TABS ──
function tabActive(el) {
  document.querySelectorAll('.tab-btn').forEach(b => {
    b.classList.remove('bg-ink', 'text-white', 'border-transparent');
    b.classList.add('border', 'border-ink/20', 'text-ink-muted');
  });
  el.classList.add('bg-ink', 'text-white');
  el.classList.remove('border', 'border-ink/20', 'text-ink-muted');
}

// ── FORMS ──
function submitForm(e) {
  e.preventDefault();
  const btn = document.getElementById('formBtn');
  btn.innerHTML = '✅ Message envoyé !';
  btn.style.background = '#1B5E42';
  setTimeout(() => { btn.innerHTML = '<span>✉️</span> Envoyer le message'; btn.style.background = ''; e.target.reset(); }, 3500);
}
function submitNL(e) {
  e.preventDefault();
  const btn = document.getElementById('nlBtn');
  btn.textContent = '✅ Inscrit !';
  btn.style.background = '#1B5E42';
  setTimeout(() => { btn.textContent = "S'inscrire →"; btn.style.background = ''; e.target.reset(); }, 3000);
}
</script>
</body>
</html>
