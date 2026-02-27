<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Authentification')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <meta name="color-scheme" content="dark light" />

    <meta property="og:title" content="@yield('og_title', 'Authentification sécurisée')">
    <meta property="og:description" content="@yield('og_desc', 'Connectez-vous à votre compte')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/check.png'))">

    <link rel="icon" href="{{ asset('assets/images/check.png') }}">

    <style>
        body{
            font-family:Poppins,ui-sans-serif,system-ui;
        }

        /* ==========================
           🎨 THEME VARIABLES
        ========================== */
        :root{
            --bg-dark: #0f1512;
            --primary: #34d399;
            --primary-light: #6ee7b7;
            --accent: #fbbf24;
            --card-bg: rgba(255,255,255,.06);
            --card-border: rgba(255,255,255,.18);
            --input-bg: rgba(255,255,255,.08);
            --input-border: rgba(255,255,255,.18);
        }

        /* ==========================
           🌌 BACKGROUND
        ========================== */
        .mesh{
            position:fixed;inset:0;z-index:-3;
            background:
            radial-gradient(60% 90% at 20% 10%, rgba(167,139,250,.12), transparent 60%),
            radial-gradient(55% 70% at 80% 15%, rgba(34,211,238,.12), transparent 60%),
            radial-gradient(80% 70% at 50% 100%, rgba(16,185,129,.15), transparent 60%),
            linear-gradient(var(--bg-dark),var(--bg-dark));
        }

        .ring{
            position:fixed;
            width:760px;height:760px;
            filter:blur(28px);
            opacity:.45;
            z-index:-2;
            -webkit-mask:radial-gradient(farthest-side, transparent 56%, #000 58%);
            mask:radial-gradient(farthest-side, transparent 56%, #000 58%);
            background:conic-gradient(
                from var(--a,0deg),
                var(--primary),
                rgba(255,255,255,0) 36%,
                var(--accent) 66%,
                rgba(255,255,255,0) 92%
            );
            animation:spin 34s linear infinite;
        }

        .ring.a{left:-260px;top:-220px}
        .ring.b{right:-300px;bottom:-260px;animation-direction:reverse;animation-duration:40s}

        .grain{
            position:fixed;inset:-2rem;opacity:.05;z-index:-1;pointer-events:none;
            background-image:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="140" height="140"><filter id="n"><feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="2" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(%23n)" opacity="0.5"/></svg>');
            background-size:220px 220px;
            mix-blend-mode:soft-light
        }

        @keyframes spin{to{transform:rotate(360deg)}}

        /* ==========================
           💎 CARD
        ========================== */
        .card{
            border-radius:24px;
            background:var(--card-bg);
            backdrop-filter:blur(12px);
            border:1px solid var(--card-border);
            box-shadow:0 24px 60px -28px rgba(0,0,0,.45);
        }

        /* ==========================
           🔘 BUTTONS
        ========================== */
        .btn{
            display:inline-flex;
            align-items:center;
            gap:.5rem;
            padding:.7rem 1rem;
            border-radius:16px;
            font-weight:700;
            color:#0b1510;
            background:var(--primary);
            box-shadow:0 10px 36px -14px rgba(52,211,153,.55);
            transition:.25s;
        }

        .btn:hover{
            transform:translateY(-2px);
            background:var(--primary-light);
        }

        .btn-ghost{
            display:inline-flex;
            align-items:center;
            gap:.55rem;
            padding:.55rem .85rem;
            border-radius:14px;
            border:1px solid var(--card-border);
            color:#fff;
            background:rgba(255,255,255,.06);
        }

        /* ==========================
           🧾 INPUTS
        ========================== */
        .inp{
            width:100%;
            border-radius:14px;
            background:var(--input-bg);
            border:1px solid var(--input-border);
            padding:.75rem .9rem;
            color:#fff;
            outline:none;
            transition:.2s;
        }

        .inp:focus{
            border-color:var(--primary);
            box-shadow:0 0 0 3px rgba(52,211,153,.16);
        }

        .lbl{display:block;color:#fff;font-weight:600;margin-bottom:.35rem}
        .err{color:#fecaca;font-size:.85rem;margin-top:.25rem}
    </style>
</head>

<body class="min-h-screen bg-[var(--bg-dark)] text-white flex flex-col">

<div class="mesh"></div>
<div class="ring a"></div>
<div class="ring b"></div>
<div class="grain"></div>

@yield('content')

<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('[data-toggle]').forEach(btn=>{
            btn.addEventListener('click',()=>{
                const sel = btn.getAttribute('data-toggle');
                const inp = document.querySelector(sel);
                if(!inp) return;
                inp.type = (inp.type === 'password') ? 'text' : 'password';
            });
        });
    });
</script>


</body>
</html>