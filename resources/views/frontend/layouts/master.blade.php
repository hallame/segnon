<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    
    <!-- TITLE -->
    <title>@yield('title', 'Segnon Shop — L\'Élégance Africaine')</title>
    
    <!-- META DESCRIPTION -->
    <meta name="description" content="@yield('meta_description', 'Rideaux premium, draps de luxe, quincaillerie design et décoration d\'exception. Des pièces uniques qui racontent une histoire.')">
    
    <!-- META KEYWORDS -->
    <meta name="keywords" content="@yield('meta_keywords', 'rideaux, draps, quincaillerie, décoration, maison, afrique, artisanat, luxe')">
    
    <!-- META AUTHOR -->
    <meta name="author" content="Segnon Shop">
    
    <!-- META ROBOTS -->
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    
    <!-- CANONICAL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- OPEN GRAPH / FACEBOOK -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Segnon Shop">
    <meta property="og:title" content="@yield('og_title', 'Segnon Shop — L\'Élégance Africaine')">
    <meta property="og:description" content="@yield('og_description', 'Rideaux premium, draps de luxe, quincaillerie design et décoration d\'exception.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'Segnon Shop - Décoration et intérieur africain')">
    <meta property="og:locale" content="fr_FR">
    
    <!-- TWITTER CARD -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Segnon Shop — L\'Élégance Africaine')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Rideaux premium, draps de luxe, quincaillerie design et décoration d\'exception.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/twitter-image.jpg'))">
    <meta name="twitter:image:alt" content="@yield('twitter_image_alt', 'Segnon Shop - Décoration et intérieur africain')">
    
    <!-- PWA & THEME -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#f15b30">
    <meta name="msapplication-TileColor" content="#f15b30">
    
    <!-- FAVICONS -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    {{-- <link rel="manifest" href="{{ asset('site.webmanifest') }}"> --}}
    
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300..800&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&display=swap" rel="stylesheet">
    
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- ICONS (Lucide) optionnel -->
    <script src="https://unpkg.com/lucide@latest"></script>
    

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuration Tailwind personnalisée -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'terracotta': {
                            50: '#fff4ed',
                            100: '#ffe6d5',
                            200: '#fdccb0',
                            300: '#fbaa82',
                            400: '#f77f54',
                            500: '#f15b30',
                            600: '#de411d',
                            700: '#b83216',
                            800: '#932b18',
                            900: '#782616',
                        },
                        'saffron': {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        'safari': {
                            50: '#f2f7f2',
                            100: '#e0ebe0',
                            200: '#c3d9c3',
                            300: '#9cbf9c',
                            400: '#74a074',
                            500: '#558255',
                            600: '#3e643e',
                            700: '#324f32',
                            800: '#294029',
                            900: '#223622',
                        },
                        'night': {
                            50: '#f5f5f6',
                            100: '#e6e6e8',
                            200: '#cfd0d4',
                            300: '#adaeb6',
                            400: '#858792',
                            500: '#676a77',
                            600: '#4f515d',
                            700: '#3f414b',
                            800: '#2f3139',
                            900: '#1e1f24',
                        },
                        'sand': {
                            50: '#faf8f4',
                            100: '#f2ede3',
                            200: '#e5dbcc',
                            300: '#d3c4ae',
                            400: '#bfa88a',
                            500: '#af8f6b',
                            600: '#9d7855',
                            700: '#826145',
                            800: '#6a4f3c',
                            900: '#564133',
                        }
                    },
                    fontFamily: {
                        'display': ['Clash Display', 'system-ui', 'sans-serif'],
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 8s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 2s infinite',
                        'spin-slow': 'spin 8s linear infinite',
                        'marquee': 'marquee 25s linear infinite',
                        'marquee2': 'marquee2 25s linear infinite',
                        'gradient': 'gradient 8s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-100%)' },
                        },
                        marquee2: {
                            '0%': { transform: 'translateX(100%)' },
                            '100%': { transform: 'translateX(0%)' },
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        }
                    },
                    backgroundSize: {
                        '300%': '300%',
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300..800&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Styles personnalisés -->
    <style>
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #f15b30 0%, #f59e0b 50%, #558255 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }
    </style>
</head>
<body class="font-sans antialiased bg-sand-50 text-night-900">
    @include('frontend.layouts.header')
    @yield('content')
    @include('frontend.layouts.footer')

    <!-- Back to top -->
    <button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"
            class="fixed bottom-6 right-6 w-12 h-12 bg-terracotta-500 text-white rounded-xl flex items-center justify-center shadow-lg opacity-0 translate-y-4 transition-all duration-300 hover:bg-terracotta-600 z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    @include('frontend.layouts.scripts')
</body>
</html>