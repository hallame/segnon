<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <!-- SEO -->
    <title>Segnon Shop — L'Élégance Africaine</title>
    <meta name="description" content="Rideaux premium, draps de luxe, quincaillerie design et décoration d'exception. Des pièces uniques qui racontent une histoire.">
    <meta name="keywords" content="rideaux, draps, quincaillerie, décoration, maison, afrique, artisanat, luxe">
    <meta name="author" content="Segnon Shop">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://segnonshop.com/">
    <meta property="og:title" content="Segnon Shop — L'Élégance Africaine">
    <meta property="og:description" content="Rideaux premium, draps de luxe, quincaillerie design et décoration d'exception.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1618213749401-4492e2c1f7d3?w=1200">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Segnon Shop — L'Élégance Africaine">
    <meta name="twitter:description" content="Rideaux premium, draps de luxe, quincaillerie design et décoration d'exception.">
    <meta name="twitter:image" content="https://images.unsplash.com/photo-1618213749401-4492e2c1f7d3?w=1200">
    
    <!-- Favicon / icônes -->
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <!-- Couleur du thème pour navigateurs mobiles -->
    <meta name="theme-color" content="#f15b30">
    <meta name="msapplication-TileColor" content="#f15b30">
    
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
    <!-- ===== NAVBAR ===== -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-sand-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">  <!-- AJOUTER CECI -->
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="text-3xl font-['Clash_Display'] font-bold tracking-tight">
                    SEGNON<span class="text-terracotta-500">.</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="#accueil" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                        Accueil
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                        <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                    </a>
                    <a href="#collections" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                        Collections
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                        <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                    </a>
                    <a href="#produits" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                        Nouveautés
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                        <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                    </a>
                    <a href="#promos" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                        Promos
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                        <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                    </a>
                    <a href="#contact" class="px-4 py-2 text-night-700 hover:text-terracotta-500 font-medium transition relative group">
                        Contact
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:left-0 transition-all duration-300"></span>
                        <span class="absolute bottom-0 right-1/2 w-0 h-0.5 bg-terracotta-500 group-hover:w-1/2 group-hover:right-0 transition-all duration-300"></span>
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <button class="p-2 hover:bg-sand-100 rounded-full transition">
                        <i class="fas fa-search text-night-700"></i>
                    </button>
                    <button class="p-2 hover:bg-sand-100 rounded-full transition relative">
                        <i class="far fa-heart text-night-700"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-terracotta-500 rounded-full text-white text-[10px] flex items-center justify-center">3</span>
                    </button>
                    <button class="p-2 hover:bg-sand-100 rounded-full transition relative">
                        <i class="fas fa-shopping-bag text-night-700"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-terracotta-500 rounded-full text-white text-[10px] flex items-center justify-center">2</span>
                    </button>
                    <a href="https://wa.me/22900000000" class="hidden md:flex items-center gap-2 bg-terracotta-500 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-terracotta-600 transition shadow-lg hover:shadow-xl ml-2">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp
                    </a>
                    <button class="lg:hidden p-2 hover:bg-sand-100 rounded-full transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>


    @include('frontend.layouts.footer')



    <!-- Back to top -->
    <button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"
            class="fixed bottom-6 right-6 w-12 h-12 bg-terracotta-500 text-white rounded-xl flex items-center justify-center shadow-lg opacity-0 translate-y-4 transition-all duration-300 hover:bg-terracotta-600 z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script>
        // Back to top visibility
        window.addEventListener('scroll', function() {
            const btt = document.getElementById('backToTop');
            if (window.scrollY > 500) {
                btt.style.opacity = '1';
                btt.style.transform = 'translateY(0)';
            } else {
                btt.style.opacity = '0';
                btt.style.transform = 'translateY(20px)';
            }
        });

        // Countdown timer
        function updateTimer() {
            const days = document.getElementById('days');
            const hours = document.getElementById('hours');
            const minutes = document.getElementById('minutes');
            const seconds = document.getElementById('seconds');

            if (days && hours && minutes && seconds) {
                let d = parseInt(days.textContent);
                let h = parseInt(hours.textContent);
                let m = parseInt(minutes.textContent);
                let s = parseInt(seconds.textContent);

                s--;
                if (s < 0) {
                    s = 59;
                    m--;
                    if (m < 0) {
                        m = 59;
                        h--;
                        if (h < 0) {
                            h = 23;
                            d--;
                            if (d < 0) {
                                d = 7;
                            }
                        }
                    }
                }

                days.textContent = d.toString().padStart(2, '0');
                hours.textContent = h.toString().padStart(2, '0');
                minutes.textContent = m.toString().padStart(2, '0');
                seconds.textContent = s.toString().padStart(2, '0');
            }
        }

        setInterval(updateTimer, 1000);
        // Tabs functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('bg-terracotta-500', 'text-white');
                    b.classList.add('text-night-600');
                });
                this.classList.add('bg-terracotta-500', 'text-white');
                this.classList.remove('text-night-600');
            });
        });
    </script>
</body>
</html>