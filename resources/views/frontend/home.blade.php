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

    <!-- ===== HERO SECTION ===== -->
    <section id="accueil" class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden">
        <!-- Formes décoratives -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-terracotta-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-safari-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float-slow"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 lg:py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8 text-center lg:text-left">
                    
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-['Clash_Display'] font-bold leading-[1.1] tracking-tight">
                        <span class="block text-night-900">L'élégance</span>
                        <span class="gradient-text">africaine</span>
                        <span class="block text-night-900">réinventée</span>
                    </h1>
                    
                    <p class="text-lg text-night-600 max-w-xl mx-auto lg:mx-0">
                        Rideaux premium, draps de luxe, quincaillerie design et décoration d'exception. 
                        Des pièces uniques qui racontent une histoire.
                    </p>
                    
                    <!-- CTA Group -->
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="#collections" class="group bg-terracotta-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-terracotta-600 transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                            Explorer
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition"></i>
                        </a>
                        <a href="https://wa.me/22900000000" class="group bg-white text-night-900 px-8 py-4 rounded-full font-semibold border-2 border-sand-300 hover:border-terracotta-500 transition flex items-center gap-2">
                            <i class="fab fa-whatsapp text-terracotta-500"></i>
                            WhatsApp direct
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-8 border-t border-sand-200 max-w-md mx-auto lg:mx-0">
                        <div>
                            <div class="text-2xl font-['Clash_Display'] font-bold text-terracotta-500">5000+</div>
                            <div class="text-xs text-night-500">Clients</div>
                        </div>
                        <div>
                            <div class="text-2xl font-['Clash_Display'] font-bold text-safari-600">200+</div>
                            <div class="text-xs text-night-500">Produits</div>
                        </div>
                        <div>
                            <div class="text-2xl font-['Clash_Display'] font-bold text-saffron-600">4.9/5</div>
                            <div class="text-xs text-night-500">Avis</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Images Grid -->
                <div class="grid grid-cols-2 gap-4 relative">
                    <!-- Image 1 -->
                    <div class="space-y-4">
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="https://images.unsplash.com/photo-1618213749401-4492e2c1f7d3?w=800&auto=format&fit=crop" 
                                 alt="Décoration" class="w-full h-64 object-cover hover:scale-110 transition duration-700">
                        </div>
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800&auto=format&fit=crop" 
                                 alt="Draps" class="w-full h-48 object-cover hover:scale-110 transition duration-700">
                        </div>
                    </div>
                    <!-- Image 2 -->
                    <div class="space-y-4 mt-8">
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=800&auto=format&fit=crop" 
                                 alt="Rideaux" class="w-full h-48 object-cover hover:scale-110 transition duration-700">
                        </div>
                        <div class="overflow-hidden rounded-3xl shadow-xl hover-scale">
                            <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?w=800&auto=format&fit=crop" 
                                 alt="Décoration" class="w-full h-64 object-cover hover:scale-110 transition duration-700">
                        </div>
                    </div>
                    
                    <!-- Badge flottant -->
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-2xl p-4 animate-float hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-terracotta-500 rounded-xl flex items-center justify-center text-white text-xl">
                                <i class="fas fa-star"></i>
                            </div>
                            <div>
                                <div class="font-bold text-night-900">4.9/5</div>
                                <div class="text-sm text-night-500">1500+ avis</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MARQUEE BANNER ===== -->
    <div class="bg-night-900 text-white py-5 overflow-hidden border-y-4 border-terracotta-500">
        <div class="animate-marquee whitespace-nowrap flex">
            <div class="inline-flex items-center gap-8 mx-4">
                <span class="text-xl font-semibold">✨ RIDEAUX PREMIUM</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">🛏️ DRAPS DE LUXE</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
                <span class="text-xl font-semibold">🔧 QUINCAILLERIE DESIGN</span>
                <span class="w-2 h-2 bg-safari-500 rounded-full"></span>
                <span class="text-xl font-semibold">🏺 DÉCORATION UNIQUE</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">⭐ SATISFACTION CLIENT</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
            </div>
            <!-- Duplicate pour effet infini -->
            <div class="inline-flex items-center gap-8 mx-4">
                <span class="text-xl font-semibold">✨ RIDEAUX PREMIUM</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">🛏️ DRAPS DE LUXE</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
                <span class="text-xl font-semibold">🔧 QUINCAILLERIE DESIGN</span>
                <span class="w-2 h-2 bg-safari-500 rounded-full"></span>
                <span class="text-xl font-semibold">🏺 DÉCORATION UNIQUE</span>
                <span class="w-2 h-2 bg-terracotta-500 rounded-full"></span>
                <span class="text-xl font-semibold">⭐ SATISFACTION CLIENT</span>
                <span class="w-2 h-2 bg-saffron-500 rounded-full"></span>
            </div>
        </div>
    </div>

    <!-- ===== CATEGORIES SECTION ===== -->
    <section id="collections" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-white py-8">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mt-4 mb-6">
                Explorez nos <span class="gradient-text">univers</span>
            </h2>
            <p class="text-night-600">
                Quatre univers distincts pour sublimer chaque pièce de votre intérieur.
            </p>
        </div>
        
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Catégorie 1 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=800&auto=format&fit=crop" 
                        alt="Rideaux" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">120+ modèles</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Rideaux</h3>
                    <p class="text-white/70 text-sm mb-4">Voilages, occultants, sur-mesure</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 2 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800&auto=format&fit=crop" 
                        alt="Draps" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-safari-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Nouveauté</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Draps</h3>
                    <p class="text-white/70 text-sm mb-4">Coton, satin, microfibre</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 3 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=800&auto=format&fit=crop" 
                        alt="Quincaillerie" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-saffron-600 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Jusqu'à -20%</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Quincaillerie</h3>
                    <p class="text-white/70 text-sm mb-4">Tringles, crochets, rails</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 4 -->
            <div class="group relative h-96 rounded-3xl overflow-hidden cursor-pointer hover-lift">
                <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?w=800&auto=format&fit=crop" 
                        alt="Décoration" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-night-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <span class="bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full mb-3 inline-block">Pièces uniques</span>
                    <h3 class="text-2xl font-['Clash_Display'] font-bold mb-2">Décoration</h3>
                    <p class="text-white/70 text-sm mb-4">Coussins, tapis, art déco</p>
                    <div class="flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                        <span>Découvrir</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURED PRODUCTS ===== -->
    <section id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-sand-50 py-8">
        <!-- Section Header avec tabs -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mt-4">
                    Nos <span class="gradient-text">incontournables</span>
                </h2>
            </div>
            
            <!-- Tabs -->
            <div class="flex flex-wrap gap-2 mt-6 lg:mt-0 p-1 bg-white rounded-2xl shadow-sm">
                <button class="tab-btn active px-6 py-3 rounded-xl bg-terracotta-500 text-white font-medium transition">Tous</button>
                <button class="tab-btn px-6 py-3 rounded-xl text-night-600 hover:bg-sand-200 font-medium transition">Rideaux</button>
                <button class="tab-btn px-6 py-3 rounded-xl text-night-600 hover:bg-sand-200 font-medium transition">Draps</button>
                <button class="tab-btn px-6 py-3 rounded-xl text-night-600 hover:bg-sand-200 font-medium transition">Déco</button>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Produit 1 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full">-30%</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?w=800&auto=format&fit=crop" 
                            alt="Rideau velours" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <!-- Overlay Actions -->
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-terracotta-500 font-semibold">Rideaux</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 ml-1">(45)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Rideau Velours Premium</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">24 500 F</span>
                        <span class="text-sm text-night-400 line-through">35 000 F</span>
                    </div>
                </div>
            </div>
            
            <!-- Produit 2 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-safari-600 text-white text-xs px-3 py-1 rounded-full">Nouveau</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=800&auto=format&fit=crop" 
                            alt="Drap satin" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-safari-600 font-semibold">Draps</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(32)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Parure de lit 5 pièces</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">32 000 F</span>
                    </div>
                </div>
            </div>
            
            <!-- Produit 3 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-saffron-600 text-white text-xs px-3 py-1 rounded-full">Top vente</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800&auto=format&fit=crop" 
                            alt="Poignée" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-saffron-600 font-semibold">Quincaillerie</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 ml-1">(18)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Poignée de porte design</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">8 500 F</span>
                    </div>
                </div>
            </div>
            
            <!-- Produit 4 -->
            <div class="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all hover-lift">
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    <span class="absolute top-3 left-3 z-10 bg-terracotta-500 text-white text-xs px-3 py-1 rounded-full">-25%</span>
                    <button class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    <img src="https://images.unsplash.com/photo-1567225591450-0605936a7f2c?w=800&auto=format&fit=crop" 
                            alt="Miroir" class="w-full h-64 object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2 p-4 bg-gradient-to-t from-night-900/90 to-transparent">
                        <a href="#" class="flex-1 bg-terracotta-500 text-white text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-terracotta-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="flex-1 bg-white text-night-900 text-sm py-2 rounded-lg flex items-center justify-center gap-1 hover:bg-sand-100">
                            <i class="fas fa-phone-alt"></i> Appel
                        </a>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-terracotta-500 font-semibold">Décoration</span>
                        <div class="flex items-center gap-1 text-saffron-500 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-night-400 ml-1">(27)</span>
                        </div>
                    </div>
                    
                    <h3 class="font-['Clash_Display'] font-bold text-lg">Miroir doré sculpté</h3>
                    
                    <div class="flex items-end gap-2">
                        <span class="text-xl font-bold text-night-900">18 000 F</span>
                        <span class="text-sm text-night-400 line-through">24 000 F</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center gap-2 bg-night-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-terracotta-500 transition shadow-md hover:shadow-lg">
                Voir tous les produits
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- ===== PROMO BANNER ===== -->

    <section class="py-16 bg-gradient-to-r from-terracotta-600 via-saffron-600 to-safari-600 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">  <!-- AJOUTER CECI -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8 z-10">
                <div class="text-center lg:text-left">
                    <span class="inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-semibold mb-4">⚡ OFFRE EXCEPTIONNELLE</span>
                    <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mb-4">
                        Jusqu'à -50% sur une sélection
                    </h2>
                    <p class="text-white/90 text-lg max-w-2xl">
                        Rideaux, draps et décoration. Livraison offerte.
                    </p>
                </div>
                
                <!-- Timer -->
                <div class="flex gap-3">
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="days">24</div>
                        <div class="text-xs text-white/80">Jours</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="hours">12</div>
                        <div class="text-xs text-white/80">Heures</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="minutes">45</div>
                        <div class="text-xs text-white/80">Minutes</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center min-w-[80px]">
                        <div class="text-3xl font-['Clash_Display'] font-bold" id="seconds">30</div>
                        <div class="text-xs text-white/80">Secondes</div>
                    </div>
                </div>
                
                <a href="#" class="bg-white text-night-900 px-8 py-4 rounded-full font-semibold hover:shadow-2xl hover:scale-105 transition flex items-center gap-2 whitespace-nowrap">
                    J'en profite
                    <i class="fas fa-bolt"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->

    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">  <!-- AJOUTER CECI -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-saffron-600 font-semibold text-sm uppercase tracking-wider">Témoignages</span>
                <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mt-4 mb-6">
                    Ils nous font <span class="gradient-text">confiance</span>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-sand-50 p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="flex items-center gap-1 text-saffron-500 text-lg mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-night-600 mb-6 leading-relaxed">
                        "Rideaux magnifiques, qualité exceptionnelle. Le service WhatsApp est ultra rapide, livraison en 24h. Je recommande !"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-terracotta-500 rounded-full flex items-center justify-center text-white font-bold text-xl">A</div>
                        <div>
                            <h4 class="font-bold text-night-900">Aminata Diallo</h4>
                            <p class="text-sm text-night-500">Dakar, Sénégal</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-sand-50 p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="flex items-center gap-1 text-saffron-500 text-lg mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-night-600 mb-6 leading-relaxed">
                        "Draps d'une douceur incroyable. Prix imbattables. Je suis devenue cliente fidèle, toute ma maison est équipée Segnon Shop !"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-safari-600 rounded-full flex items-center justify-center text-white font-bold text-xl">K</div>
                        <div>
                            <h4 class="font-bold text-night-900">Kofi Mensah</h4>
                            <p class="text-sm text-night-500">Abidjan, Côte d'Ivoire</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-sand-50 p-8 rounded-2xl hover:shadow-xl transition hover-lift">
                    <div class="flex items-center gap-1 text-saffron-500 text-lg mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-night-600 mb-6 leading-relaxed">
                        "Service client exceptionnel. Ils m'ont conseillée pour choisir mes rideaux. Le rendu est magnifique, exactement ce que je voulais."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-saffron-600 rounded-full flex items-center justify-center text-white font-bold text-xl">F</div>
                        <div>
                            <h4 class="font-bold text-night-900">Fatou Ndiaye</h4>
                            <p class="text-sm text-night-500">Dakar, Sénégal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===== CTA SECTION ===== -->
    <section class="py-16 bg-night-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">  <!-- AJOUTER CECI -->
            <h2 class="text-4xl md:text-5xl font-['Clash_Display'] font-bold mb-6">
                Prêt à transformer votre <span class="text-terracotta-500">intérieur ?</span>
            </h2>
            <p class="text-white/70 text-lg max-w-2xl mx-auto mb-10">
                Nos conseillers sont disponibles 7j/7 pour vous guider dans vos choix.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="https://wa.me/22900000000" class="bg-terracotta-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-terracotta-600 transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fab fa-whatsapp text-xl"></i>
                    WhatsApp direct
                </a>
                <a href="tel:+22900000000" class="bg-white/10 backdrop-blur text-white px-8 py-4 rounded-full font-semibold border-2 border-white/20 hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-phone-alt"></i>
                    Appel rapide
                </a>
                <a href="#" class="bg-white text-night-900 px-8 py-4 rounded-full font-semibold hover:bg-sand-100 transition flex items-center gap-2">
                    <i class="fas fa-envelope"></i>
                    Formulaire
                </a>
            </div>
        </div>
    </section>

      <!-- ===== AVANTAGES ===== -->
      <section class="py-16 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Avantage 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-terracotta-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-2xl text-terracotta-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Livraison gratuite</h3>
                    <p class="text-sm text-night-500">Dès 50 000 F d'achat</p>
                </div>
                
                <!-- Avantage 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-saffron-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-undo-alt text-2xl text-saffron-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Retours faciles</h3>
                    <p class="text-sm text-night-500">Satisfait ou remboursé</p>
                </div>
                
                <!-- Avantage 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-safari-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-safari-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Paiement sécurisé</h3>
                    <p class="text-sm text-night-500">Cartes, mobile money</p>
                </div>
                
                <!-- Avantage 4 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-terracotta-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-terracotta-600"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg">Support 7j/7</h3>
                    <p class="text-sm text-night-500">Réponse sous 24h</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ATELIER — SAVOIR-FAIRE ===== -->
    <section class="relative py-12 md:py-16 bg-gradient-to-b from-night-900 to-night-800 text-white overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-terracotta-500 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-sage-500 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-white/5 rounded-full"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                <!-- Contenu texte -->
                <div class="space-y-8 reveal fade-left">
                    <div class="inline-flex items-center gap-3">
                        <span class="w-12 h-0.5 bg-terracotta-500"></span>
                        <span class="text-terracotta-400 text-sm uppercase tracking-[0.3em] font-semibold">L'atelier</span>
                    </div>
                    
                    <h2 class="font-display text-5xl md:text-6xl lg:text-7xl leading-[1.1] font-bold">
                        Ce qui ne <span class="text-terracotta-500 relative inline-block">s'achète
                            <span class="absolute -bottom-2 left-0 w-full h-1 bg-terracotta-500/30 rounded-full"></span>
                        </span> pas
                    </h2>
                    
                    <p class="text-white/70 text-lg md:text-xl leading-relaxed max-w-xl">
                        Le temps, le geste, la rencontre avec la matière. Derrière chaque pièce, 
                        il y a des mains qui savent regarder, des yeux qui savent toucher.
                    </p>
                    
                    <div class="flex flex-wrap gap-8 pt-6">
                        <div class="flex items-center gap-4 group">
                            <div class="w-14 h-14 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-terracotta-500/20 transition-colors duration-300">
                                <i class="ph ph-hands-clapping text-2xl text-terracotta-400"></i>
                            </div>
                            <div>
                                <div class="text-sm text-white/50">Artisans</div>
                                <div class="font-display text-2xl text-white">15 collaborateurs</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 group">
                            <div class="w-14 h-14 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-terracotta-500/20 transition-colors duration-300">
                                <i class="ph ph-clock text-2xl text-terracotta-400"></i>
                            </div>
                            <div>
                                <div class="text-sm text-white/50">Depuis</div>
                                <div class="font-display text-2xl text-white">2024</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-6">
                        <a href="#contact" class="inline-flex items-center gap-3 text-white group">
                            <span class="text-lg">Découvrir l'atelier</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                            <span class="w-12 h-0.5 bg-terracotta-500 group-hover:w-20 transition-all duration-300"></span>
                        </a>
                    </div>
                </div>
                
                <!-- Image avec effets -->
                <div class="relative reveal fade-right">
                    <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&auto=format&fit=crop" 
                            alt="Atelier" 
                            class="w-full h-full object-cover hover:scale-110 transition duration-700">
                    </div>
                    
                    <!-- Badge flottant -->
                    <div class="absolute -bottom-8 -left-8 bg-white/10 backdrop-blur-md text-white p-6 rounded-2xl shadow-2xl border border-white/10 animate-float">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-terracotta-500 rounded-xl flex items-center justify-center text-white">
                                <i class="fab fa-whatsapp text-2xl"></i>
                            </div>
                            <div>
                                <div class="text-sm opacity-70">Conseil privé</div>
                                <div class="text-xl font-display font-semibold">+229 00 00 00 00</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Badge qualité -->
                    <div class="absolute top-8 right-8 bg-white/10 backdrop-blur-md px-6 py-3 rounded-full border border-white/10">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-saffron-500"></i>
                            <span class="font-semibold">Savoir-faire unique</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

  
    <!-- ===== COLLECTION EXCLUSIVE ===== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header avec style différent -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                Collection <span class="gradient-text">Essentielle</span>
            </h2>
            <p class="text-night-600">Des pièces intemporelles, sélectionnées pour leur qualité exceptionnelle.</p>
        </div>
        
        <!-- Grille différente : 3 colonnes avec mise en avant -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Carte premium 1 -->
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?w=800&auto=format&fit=crop" 
                        alt="Produit" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/60 via-transparent to-transparent"></div>
                    
                    <!-- Badges repositionnés -->
                    <span class="absolute top-4 left-4 bg-terracotta-500 text-white px-4 py-1.5 rounded-full text-xs font-semibold z-10">Exclusivité</span>
                    
                    <!-- Actions flottantes -->
                    <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs text-terracotta-500 font-semibold uppercase tracking-wider">Rideaux</span>
                            <h3 class="font-display font-bold text-xl mt-1">Velours Céleste</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-night-900">24 500 F</span>
                            <span class="text-sm text-night-400 line-through block">35 000 F</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-1 text-saffron-500">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 text-sm ml-1">(45)</span>
                        </div>
                        
                        <a href="#" class="text-terracotta-500 font-semibold text-sm flex items-center gap-1 hover:gap-3 transition-all">
                            Détails <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <!-- WhatsApp direct dans la carte -->
                    <a href="#" class="mt-4 w-full bg-sand-100 text-night-900 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-terracotta-500 hover:text-white transition group">
                        <i class="fab fa-whatsapp text-terracotta-500 group-hover:text-white"></i>
                        <span class="font-medium">Commander sur WhatsApp</span>
                    </a>
                </div>
            </div>
            
            <!-- Carte premium 2 -->
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?w=800&auto=format&fit=crop" 
                        alt="Produit" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/60 via-transparent to-transparent"></div>
                    
                    <span class="absolute top-4 left-4 bg-safari-600 text-white px-4 py-1.5 rounded-full text-xs font-semibold z-10">Nouveauté</span>
                    
                    <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs text-safari-600 font-semibold uppercase tracking-wider">Draps</span>
                            <h3 class="font-display font-bold text-xl mt-1">Parure 5 pièces</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-night-900">32 000 F</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-1 text-saffron-500">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-night-400 text-sm ml-1">(32)</span>
                        </div>
                        
                        <a href="#" class="text-terracotta-500 font-semibold text-sm flex items-center gap-1 hover:gap-3 transition-all">
                            Détails <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <a href="#" class="mt-4 w-full bg-sand-100 text-night-900 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-terracotta-500 hover:text-white transition group">
                        <i class="fab fa-whatsapp text-terracotta-500 group-hover:text-white"></i>
                        <span class="font-medium">Commander sur WhatsApp</span>
                    </a>
                </div>
            </div>
            
            <!-- Carte premium 3 -->
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800&auto=format&fit=crop" 
                        alt="Produit" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/60 via-transparent to-transparent"></div>
                    
                    <span class="absolute top-4 left-4 bg-saffron-600 text-white px-4 py-1.5 rounded-full text-xs font-semibold z-10">-20%</span>
                    
                    <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs text-saffron-600 font-semibold uppercase tracking-wider">Quincaillerie</span>
                            <h3 class="font-display font-bold text-xl mt-1">Poignée design</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-night-900">8 500 F</span>
                            <span class="text-sm text-night-400 line-through block">10 500 F</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-1 text-saffron-500">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-night-400 text-sm ml-1">(18)</span>
                        </div>
                        
                        <a href="#" class="text-terracotta-500 font-semibold text-sm flex items-center gap-1 hover:gap-3 transition-all">
                            Détails <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <a href="#" class="mt-4 w-full bg-sand-100 text-night-900 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-terracotta-500 hover:text-white transition group">
                        <i class="fab fa-whatsapp text-terracotta-500 group-hover:text-white"></i>
                        <span class="font-medium">Commander sur WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Lien vers toute la collection -->
        <div class="text-center mt-8">
            <a href="#" class="inline-flex items-center gap-3 text-night-900 font-semibold group">
                <span>Découvrir toute la collection</span>
                <i class="fas fa-arrow-right group-hover:translate-x-2 transition"></i>
                <span class="w-12 h-0.5 bg-terracotta-500 group-hover:w-20 transition-all"></span>
            </a>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-night-800 text-white/70 mt-8 md:mt-10 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-white/10">
            <!-- About -->
            <div>
                <div class="text-2xl font-['Clash_Display'] font-bold text-white mb-6">
                    SEGNON<span class="text-terracotta-500">SHOP</span>
                </div>
                <p class="text-white/60 text-sm leading-relaxed mb-6">
                    Votre boutique premium de rideaux, draps, quincaillerie et décoration. L'élégance africaine réinventée.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-terracotta-500 hover:text-white transition">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
            
            <!-- Links -->
            <div>
                <h4 class="text-white font-bold mb-6">Liens rapides</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Accueil</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Collections</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Nouveautés</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Promotions</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Contact</a></li>
                </ul>
            </div>
            
            <!-- Categories -->
            <div>
                <h4 class="text-white font-bold mb-6">Catégories</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Rideaux</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Draps</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Quincaillerie</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Décoration</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition">Sur mesure</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="text-white font-bold mb-6">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1"></i>
                        <span>Cotonou, Bénin</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-phone-alt mt-1"></i>
                        <span>+229 00 00 00 00</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-envelope mt-1"></i>
                        <span>contact@segnonshop.com</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-clock mt-1"></i>
                        <span>Lun - Sam : 8h - 19h</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 text-sm">
            <div>© 2025 Segnon Shop. Tous droits réservés.</div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition">Mentions légales</a>
                <a href="#" class="hover:text-white transition">Confidentialité</a>
                <a href="#" class="hover:text-white transition">CGV</a>
            </div>
        </div>
    </footer>



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