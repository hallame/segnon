<!DOCTYPE html>
<html lang="fr">
<head>
    @php
        $defaultTitle = "Marketplace de vendeurs et créateurs";
        $pageTitle = trim($__env->yieldContent('title', $defaultTitle));
        $metaTitle = trim($__env->yieldContent('meta_title', $pageTitle));
        $metaDescription = trim(
            $__env->yieldContent(
                'meta_description',
                "Marché digital dédié aux artisans, créateurs et vendeurs : objets d'art, déco, mode, cadeaux et pièces uniques."
            )
        );

        $metaImage = $__env->yieldContent('meta_image', asset('assets/images/mk.png'));
        $metaUrl   = url()->current();
        $metaType  = trim($__env->yieldContent('meta_type', 'website'));
        $metaRobots = trim($__env->yieldContent('meta_robots', 'index,follow'));
    @endphp


    <meta charset="UTF-8">
    <title>{{ $metaTitle }} | MYLMARK</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO de base --}}
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="{{ $metaRobots }}">
    <link rel="canonical" href="{{ $metaUrl }}">

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:locale" content="fr_FR">
    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:site_name" content="MYLMARK">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/front/images/pwa/favicon.png') }}">

     <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Fonts / UI --}}
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css">

    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              brand: {
                green: '#166534',
                greenSoft: '#DCFCE7',
                orange: '#F97316',
                orangeSoft: '#FFEDD5',
                dark: '#111827'
              }
            },
            fontFamily: {
              sans: ['Lexend', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif']
            },
            boxShadow: {
              soft: '0 18px 45px rgba(15, 23, 42, 0.12)',
              card: '0 16px 32px rgba(15, 23, 42, 0.14)'
            }
          }
        }
      }
    </script>

    <style>
      html {
        scroll-behavior: smooth;
        font-size: 18px;
      }
    </style>

</head>
<body class="font-sans bg-slate-50 text-slate-900 antialiased">
    <div class="min-h-screen flex flex-col">
        @include('frontend.layouts.header')
        <main id="top" class="flex-1">
            @yield('content')
        </main>
        @include('frontend.layouts.footer')
        @include('frontend.layouts.scripts')
    </div>
</body>
</html>
