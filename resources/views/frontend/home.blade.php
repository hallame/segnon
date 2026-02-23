<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segnon Shop - Rideaux, Draps, Quincaillerie & Décoration</title>
    
    <!-- Font Awesome 6 (Gratuit) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Poppins + Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Animate.css (Animations) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* ===== VARIABLES ===== */
        :root {
            --primary: #c8a97e;
            --primary-dark: #b38b5b;
            --secondary: #2c3e50;
            --dark: #1e2b37;
            --light: #f9f7f4;
            --white: #ffffff;
            --gray: #7f8c8d;
            --light-gray: #ecf0f1;
            --shadow: 0 10px 40px rgba(0,0,0,0.08);
            --shadow-hover: 0 20px 60px rgba(0,0,0,0.15);
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background: var(--white);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* ===== UTILITAIRES ===== */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .section {
            padding: 100px 0;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 3rem;
            color: var(--dark);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2 span {
            color: var(--primary);
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border-radius: 3px;
        }

        .section-title p {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 20px auto 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            gap: 10px;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 10px 30px rgba(200, 169, 126, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(200, 169, 126, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--dark);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
        }

        .btn-whatsapp {
            background: #25D366;
            color: var(--white);
        }

        .btn-whatsapp:hover {
            background: #128C7E;
            transform: translateY(-3px);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        /* ===== NAVBAR MODERNE ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar.scrolled {
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.98);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            color: var(--dark);
        }

        .logo span {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .nav-links a {
            font-weight: 500;
            position: relative;
            padding: 5px 0;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-icons a {
            font-size: 1.3rem;
            transition: var(--transition);
        }

        .nav-icons a:hover {
            color: var(--primary);
            transform: scale(1.1);
        }

        /* ===== HERO SECTION ULTRA MODERNE ===== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            background: linear-gradient(135deg, #fff5eb 0%, #ffffff 100%);
            overflow: hidden;
            padding-top: 80px;
        }

        .hero .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .hero-content {
            animation: fadeInUp 1s ease;
        }

        .hero-subtitle {
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: inline-block;
            padding: 8px 20px;
            background: rgba(200, 169, 126, 0.1);
            border-radius: 50px;
        }

        .hero-title {
            font-size: 4.5rem;
            line-height: 1.1;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .hero-title span {
            color: var(--primary);
            font-style: italic;
        }

        .hero-description {
            font-size: 1.1rem;
            color: var(--gray);
            margin-bottom: 40px;
            max-width: 500px;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
            animation: float 6s ease-in-out infinite;
        }

        .hero-image img {
            border-radius: 30px;
            box-shadow: var(--shadow);
            transform: perspective(1000px) rotateY(-5deg);
            transition: var(--transition);
        }

        .hero-image:hover img {
            transform: perspective(1000px) rotateY(0deg);
        }

        .hero-badge {
            position: absolute;
            bottom: 30px;
            left: -30px;
            background: var(--white);
            padding: 20px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 15px;
            animation: fadeInUp 1s ease 0.5s both;
        }

        .hero-badge i {
            font-size: 2.5rem;
            color: var(--primary);
        }

        .hero-badge-text h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .hero-badge-text p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .hero-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to top, rgba(255,255,255,0.8), transparent);
            z-index: 1;
        }

        /* ===== CATÉGORIES SECTION ===== */
        .categories {
            background: var(--light);
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .category-card {
            background: var(--white);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .category-image {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .category-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .category-card:hover .category-image img {
            transform: scale(1.1);
        }

        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .category-card:hover .category-overlay {
            opacity: 1;
        }

        .category-content {
            padding: 25px 20px;
            text-align: center;
        }

        .category-content h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .category-content p {
            color: var(--primary);
            font-weight: 600;
        }

        .category-icon {
            position: absolute;
            bottom: 80px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.2rem;
            opacity: 0;
            transform: scale(0);
            transition: var(--transition);
            z-index: 2;
        }

        .category-card:hover .category-icon {
            opacity: 1;
            transform: scale(1);
        }

        /* ===== PRODUITS EN SOLDE ===== */
        .promo-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 30px;
            padding: 60px;
            margin-bottom: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .promo-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .promo-banner-content h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .promo-banner-content p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .promo-banner-timer {
            display: flex;
            gap: 20px;
        }

        .timer-block {
            text-align: center;
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 15px;
            min-width: 80px;
        }

        .timer-block .number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }

        .timer-block .label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .product-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .product-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--primary);
            color: var(--white);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-badge.soldes {
            background: #e74c3c;
        }

        .product-badge.new {
            background: #2ecc71;
        }

        .product-image {
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-actions {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
            z-index: 2;
        }

        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .product-actions a {
            width: 45px;
            height: 45px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: var(--transition);
        }

        .product-actions a:hover {
            background: var(--primary);
            color: var(--white);
        }

        .product-info {
            padding: 20px;
        }

        .product-category {
            color: var(--gray);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .product-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .current-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
        }

        .old-price {
            color: var(--gray);
            text-decoration: line-through;
            font-size: 0.9rem;
        }

        /* ===== SECTION À PROPOS ===== */
        .about {
            background: var(--white);
        }

        .about .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .about-image {
            border-radius: 30px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .about-image:hover img {
            transform: scale(1.1);
        }

        .about-image:first-child {
            margin-top: 50px;
        }

        .about-content h2 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .about-content p {
            color: var(--gray);
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .feature i {
            width: 50px;
            height: 50px;
            background: rgba(200, 169, 126, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* ===== SECTION AVIS CLIENTS ===== */
        .testimonials {
            background: var(--light);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .testimonial-card {
            background: var(--white);
            padding: 40px 30px;
            border-radius: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .testimonial-card::before {
            content: '\f10d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 4rem;
            color: rgba(200, 169, 126, 0.1);
        }

        .testimonial-rating {
            color: #f1c40f;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .testimonial-text {
            font-size: 1rem;
            line-height: 1.8;
            color: var(--gray);
            margin-bottom: 20px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
        }

        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .author-info p {
            color: var(--gray);
            font-size: 0.8rem;
        }

        /* ===== SECTION CONTACT/CTA ===== */
        .contact-cta {
            background: linear-gradient(135deg, var(--dark) 0%, #2c3e50 100%);
            color: var(--white);
            text-align: center;
            padding: 80px 0;
        }

        .contact-cta h2 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .contact-cta p {
            font-size: 1.1rem;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-buttons .btn {
            padding: 16px 40px;
            font-size: 1.1rem;
        }

        /* ===== FOOTER ULTRA MODERNE ===== */
        .footer {
            background: var(--dark);
            color: var(--white);
            padding-top: 80px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-col:first-child p {
            margin: 20px 0;
            opacity: 0.8;
            line-height: 1.8;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
        }

        .footer-logo span {
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-5px);
        }

        .footer-col h3 {
            font-size: 1.3rem;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--primary);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 15px;
        }

        .footer-col ul li a {
            opacity: 0.8;
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            opacity: 1;
            color: var(--primary);
            padding-left: 5px;
        }

        .contact-info li {
            display: flex;
            align-items: center;
            gap: 15px;
            opacity: 0.8;
        }

        .contact-info li i {
            color: var(--primary);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 20px 0;
            text-align: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .hero-title { font-size: 3.5rem; }
            .products-grid,
            .categories-grid,
            .testimonials-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 992px) {
            .hero .container,
            .about .container { grid-template-columns: 1fr; }
            
            .hero-content { text-align: center; }
            .hero-description { margin-left: auto; margin-right: auto; }
            .hero-buttons { justify-content: center; }
            
            .products-grid,
            .categories-grid,
            .testimonials-grid,
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .section { padding: 60px 0; }
            .hero-title { font-size: 2.8rem; }
            
            .products-grid,
            .categories-grid,
            .testimonials-grid,
            .footer-grid { grid-template-columns: 1fr; }
            
            .promo-banner { flex-direction: column; text-align: center; gap: 30px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="logo">Segnon<span>Shop</span></a>
            
            <div class="nav-links">
                <a href="#home" class="active">Accueil</a>
                <a href="#categories">Catégories</a>
                <a href="#produits">Produits</a>
                <a href="#about">À propos</a>
                <a href="#contact">Contact</a>
            </div>
            
            <div class="nav-icons">
                <a href="#"><i class="fas fa-search"></i></a>
                <a href="#"><i class="far fa-heart"></i></a>
                <a href="#"><i class="fas fa-shopping-bag"></i></a>
                <a href="#" class="btn btn-primary" style="padding: 10px 20px;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <span class="hero-subtitle animate__animated animate__fadeInUp">✨ Art de vivre africain</span>
                <h1 class="hero-title animate__animated animate__fadeInUp animate__delay-1s">
                    Rendez votre <span>intérieur</span><br>unique et élégant
                </h1>
                <p class="hero-description animate__animated animate__fadeInUp animate__delay-2s">
                    Découvrez notre collection exclusive de rideaux, draps, quincaillerie et décoration. 
                    Des produits de qualité pour sublimer votre espace de vie.
                </p>
                <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-3s">
                    <a href="#produits" class="btn btn-primary">
                        <i class="fas fa-store"></i>
                        Découvrir nos produits
                    </a>
                    <a href="#contact" class="btn btn-outline">
                        <i class="fas fa-phone-alt"></i>
                        Nous contacter
                    </a>
                </div>
            </div>
            
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1618213749401-4492e2c1f7d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Décoration intérieure africaine">
                
                <div class="hero-badge">
                    <i class="fas fa-truck"></i>
                    <div class="hero-badge-text">
                        <h4>Livraison rapide</h4>
                        <p>Partout en Afrique</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-shape"></div>
    </section>

    <!-- ===== CATÉGORIES SECTION ===== -->
    <section class="categories section" id="categories">
        <div class="container">
            <div class="section-title">
                <h2>Nos <span>Catégories</span></h2>
                <p>Explorez notre large gamme de produits soigneusement sélectionnés pour vous</p>
            </div>
            
            <div class="categories-grid">
                <!-- Rideaux -->
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Rideaux">
                        <div class="category-overlay"></div>
                    </div>
                    <div class="category-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="category-content">
                        <h3>Rideaux</h3>
                        <p>+50 modèles</p>
                    </div>
                </div>
                
                <!-- Draps -->
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Draps">
                        <div class="category-overlay"></div>
                    </div>
                    <div class="category-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="category-content">
                        <h3>Draps</h3>
                        <p>100% coton</p>
                    </div>
                </div>
                
                <!-- Quincaillerie -->
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1581539250439-c96689b516dd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Quincaillerie">
                        <div class="category-overlay"></div>
                    </div>
                    <div class="category-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="category-content">
                        <h3>Quincaillerie</h3>
                        <p>Qualité pro</p>
                    </div>
                </div>
                
                <!-- Décoration -->
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1532372320978-9b4b6d95f4b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Décoration">
                        <div class="category-overlay"></div>
                    </div>
                    <div class="category-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="category-content">
                        <h3>Décoration</h3>
                        <p>Unique & tendance</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRODUITS EN SOLDE ===== -->
    <section class="section" id="promo">
        <div class="container">
            <div class="promo-banner">
                <div class="promo-banner-content">
                    <h3>🔥 Soldes exceptionnelles</h3>
                    <p>Jusqu'à -50% sur une sélection de produits</p>
                </div>
                <div class="promo-banner-timer">
                    <div class="timer-block">
                        <div class="number">24</div>
                        <div class="label">Heures</div>
                    </div>
                    <div class="timer-block">
                        <div class="number">45</div>
                        <div class="label">Minutes</div>
                    </div>
                    <div class="timer-block">
                        <div class="number">12</div>
                        <div class="label">Secondes</div>
                    </div>
                </div>
            </div>
            
            <div class="products-grid">
                <!-- Produit 1 -->
                <div class="product-card">
                    <span class="product-badge soldes">-30%</span>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1617104551722-3b2d513664dd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Rideau luxe">
                        <div class="product-actions">
                            <a href="#"><i class="far fa-heart"></i></a>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <a href="#"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Rideaux</div>
                        <h3 class="product-title">Rideau velours premium</h3>
                        <div class="product-price">
                            <span class="current-price">24 500 FCFA</span>
                            <span class="old-price">35 000 FCFA</span>
                        </div>
                    </div>
                </div>
                
                <!-- Produit 2 -->
                <div class="product-card">
                    <span class="product-badge soldes">-25%</span>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1616628188859-7f11e9a7a7e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Draps haut de gamme">
                        <div class="product-actions">
                            <a href="#"><i class="far fa-heart"></i></a>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <a href="#"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Draps</div>
                        <h3 class="product-title">Parure de lit 5 pièces</h3>
                        <div class="product-price">
                            <span class="current-price">32 000 FCFA</span>
                            <span class="old-price">42 500 FCFA</span>
                        </div>
                    </div>
                </div>
                
                <!-- Produit 3 -->
                <div class="product-card">
                    <span class="product-badge new">Nouveau</span>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Quincaillerie design">
                        <div class="product-actions">
                            <a href="#"><i class="far fa-heart"></i></a>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <a href="#"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Quincaillerie</div>
                        <h3 class="product-title">Poignée de porte design</h3>
                        <div class="product-price">
                            <span class="current-price">8 500 FCFA</span>
                        </div>
                    </div>
                </div>
                
                <!-- Produit 4 -->
                <div class="product-card">
                    <span class="product-badge soldes">-40%</span>
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1567225591450-0605936a7f2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Décoration murale">
                        <div class="product-actions">
                            <a href="#"><i class="far fa-heart"></i></a>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <a href="#"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Décoration</div>
                        <h3 class="product-title">Miroir doré sculpté</h3>
                        <div class="product-price">
                            <span class="current-price">18 000 FCFA</span>
                            <span class="old-price">30 000 FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SECTION À PROPOS ===== -->
    <section class="about section" id="about">
        <div class="container">
            <div class="about-images">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1618213749401-4492e2c1f7d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Showroom Segnon Shop">
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1533090161767-e6ffedb9b3a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Produits qualité">
                </div>
            </div>
            
            <div class="about-content">
                <h2>Plus qu'une boutique, <span>une signature</span></h2>
                <p>
                    Depuis 10 ans, Segnon Shop sublime les intérieurs avec des produits d'exception. 
                    Nous sélectionnons avec soin chaque article pour vous offrir le meilleur du design 
                    africain et international.
                </p>
                
                <div class="about-features">
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Produits certifiés</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-truck"></i>
                        <span>Livraison 24-48h</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-undo-alt"></i>
                        <span>Retour facile</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-lock"></i>
                        <span>Paiement sécurisé</span>
                    </div>
                </div>
                
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-store"></i>
                    Visiter notre showroom
                </a>
            </div>
        </div>
    </section>

    <!-- ===== AVIS CLIENTS ===== -->
    <section class="testimonials section" id="avis">
        <div class="container">
            <div class="section-title">
                <h2>Ce que nos <span>clients disent</span></h2>
                <p>La satisfaction de nos clients est notre plus belle récompense</p>
            </div>
            
            <div class="testimonials-grid">
                <!-- Avis 1 -->
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "Les rideaux sont absolument magnifiques ! La qualité est exceptionnelle 
                        et la livraison a été très rapide. Je recommande vivement Segnon Shop."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Aissatou Diallo">
                        </div>
                        <div class="author-info">
                            <h4>Aïssatou Diallo</h4>
                            <p>Dakar, Sénégal</p>
                        </div>
                    </div>
                </div>
                
                <!-- Avis 2 -->
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "J'ai acheté une parure de lit et je suis bluffée par la douceur du coton. 
                        Le rapport qualité-prix est imbattable !"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Mamadou Diop">
                        </div>
                        <div class="author-info">
                            <h4>Mamadou Diop</h4>
                            <p>Abidjan, Côte d'Ivoire</p>
                        </div>
                    </div>
                </div>
                
                <!-- Avis 3 -->
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="testimonial-text">
                        "Service client exceptionnel ! Ils m'ont conseillé parfaitement pour choisir 
                        mes rideaux. Le résultat est exactement ce que je voulais."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Fatou Ndiaye">
                        </div>
                        <div class="author-info">
                            <h4>Fatou Ndiaye</h4>
                            <p>Dakar, Sénégal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SECTION CONTACT/CTA ===== -->
    <section class="contact-cta" id="contact">
        <div class="container">
            <h2>Prêt à transformer votre intérieur ?</h2>
            <p>Contactez-nous directement sur WhatsApp pour une réponse rapide ou laissez-nous un message</p>
            
            <div class="cta-buttons">
                <a href="https://wa.me/221XXXXXXXXX" class="btn btn-whatsapp" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp direct
                </a>
                <a href="tel:+221XXXXXXXXX" class="btn btn-outline" style="border-color: var(--white); color: var(--white);">
                    <i class="fas fa-phone-alt"></i>
                    Appel rapide
                </a>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-envelope"></i>
                    Formulaire de contact
                </a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">Segnon<span>Shop</span></div>
                    <p>
                        Votre destination premium pour l'ameublement et la décoration. 
                        Qualité, élégance et service client exceptionnel.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="#home">Accueil</a></li>
                        <li><a href="#categories">Catégories</a></li>
                        <li><a href="#produits">Produits</a></li>
                        <li><a href="#about">À propos</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Catégories</h3>
                    <ul>
                        <li><a href="#">Rideaux</a></li>
                        <li><a href="#">Draps</a></li>
                        <li><a href="#">Quincaillerie</a></li>
                        <li><a href="#">Décoration</a></li>
                        <li><a href="#">Promotions</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Contact</h3>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            Dakar, Sénégal
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            +221 77 123 45 67
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            contact@segnonshop.com
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            Lun-Sam: 9h - 19h
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Segnon Shop. Tous droits réservés. Design avec ❤️ pour l'Afrique</p>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Active link highlight
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-links a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>