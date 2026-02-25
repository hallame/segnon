@extends('frontend.layouts.master')

@section('title', 'Notre Histoire - Segnon Shop | L\'Élégance pour votre Intérieur')
@section('meta_description', 'Découvrez l\'histoire de Segnon Shop, notre atelier et notre engagement pour une décoration d\'exception.')
@section('og_image', asset('assets/images/about-segnon.jpg'))

@section('content')

<!-- ===== HERO ABOUT ===== -->
<section class="relative bg-gradient-to-br from-sand-100 via-white to-saffron-50 overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-terracotta-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-safari-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float-slow"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 lg:py-24">
        <div class="text-center max-w-4xl mx-auto">
            <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-[0.3em]">Notre histoire</span>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold mt-6 mb-8 leading-[1.1]">
                L'élégance <span class="gradient-text">réinventée</span><br>
                avec passion
            </h1>
            <p class="text-xl text-night-600 max-w-3xl mx-auto">
                Depuis 2024, Segnon Shop crée des pièces uniques qui subliment vos intérieurs 
                avec une touche d'exception.
            </p>
        </div>
    </div>
</section>

<!-- ===== NOTRE HISTOIRE ===== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&auto=format&fit=crop" 
                         alt="Atelier Segnon Shop" 
                         class="w-full h-full object-cover">
                </div>
                <!-- Badge expérience -->
                <div class="absolute -bottom-6 -right-6 bg-terracotta-500 text-white p-6 rounded-2xl shadow-2xl">
                    <div class="text-4xl font-display font-bold">2024</div>
                    <div class="text-sm opacity-90">Année de création</div>
                </div>
            </div>
            
            <div class="space-y-8">
                <div class="inline-flex items-center gap-3">
                    <span class="w-12 h-0.5 bg-terracotta-500"></span>
                    <span class="text-terracotta-600 font-semibold">Notre histoire</span>
                </div>
                
                <h2 class="text-4xl md:text-5xl font-display font-bold">
                    Une passion <span class="gradient-text">transmise</span>
                </h2>
                
                <p class="text-lg text-night-600 leading-relaxed">
                    Segnon Shop naît d'une conviction : la décoration intérieure mérite une attention 
                    particulière. Chaque pièce que nous créons raconte une histoire, celle d'un savoir-faire 
                    minutieux au service de votre bien-être.
                </p>
                
                <p class="text-lg text-night-600 leading-relaxed">
                    Notre aventure commence à Cotonou avec la rencontre de talents passionnés. Ensemble, 
                    nous avons imaginé une marque qui réinvente les codes de la décoration en mêlant 
                    traditions textiles et designs épurés.
                </p>
                
                <div class="flex items-center gap-8 pt-4">
                    <div>
                        <div class="text-3xl font-display font-bold text-terracotta-500">15+</div>
                        <div class="text-sm text-night-500">Collaborateurs</div>
                    </div>
                    <div>
                        <div class="text-3xl font-display font-bold text-saffron-600">200+</div>
                        <div class="text-sm text-night-500">Créations</div>
                    </div>
                    <div>
                        <div class="text-3xl font-display font-bold text-safari-600">5000+</div>
                        <div class="text-sm text-night-500">Clients</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== NOS VALEURS ===== -->
<section class="py-20 bg-sand-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-saffron-600 font-semibold text-sm uppercase tracking-wider">Nos valeurs</span>
            <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                Ce qui nous <span class="gradient-text">anime</span>
            </h2>
            <p class="text-lg text-night-600">
                Trois piliers guident chacune de nos créations et notre relation avec nos clients.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Valeur 1 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition hover-lift">
                <div class="w-16 h-16 bg-terracotta-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-medal text-2xl text-terracotta-600"></i>
                </div>
                <h3 class="text-2xl font-display font-bold mb-4">Qualité d'exception</h3>
                <p class="text-night-600 leading-relaxed">
                    Chaque pièce est réalisée avec un soin minutieux pour garantir une qualité irréprochable.
                </p>
            </div>
            
            <!-- Valeur 2 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition hover-lift">
                <div class="w-16 h-16 bg-saffron-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-leaf text-2xl text-saffron-600"></i>
                </div>
                <h3 class="text-2xl font-display font-bold mb-4">Matériaux nobles</h3>
                <p class="text-night-600 leading-relaxed">
                    Nous sélectionnons les meilleurs tissus et matériaux pour des créations durables.
                </p>
            </div>
            
            <!-- Valeur 3 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition hover-lift">
                <div class="w-16 h-16 bg-safari-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-heart text-2xl text-safari-600"></i>
                </div>
                <h3 class="text-2xl font-display font-bold mb-4">Service personnalisé</h3>
                <p class="text-night-600 leading-relaxed">
                    Accompagnement sur-mesure de la conception à l'installation dans votre intérieur.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ===== L'ATELIER ===== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1 space-y-8">
                <div class="inline-flex items-center gap-3">
                    <span class="w-12 h-0.5 bg-terracotta-500"></span>
                    <span class="text-terracotta-600 font-semibold">L'atelier</span>
                </div>
                
                <h2 class="text-4xl md:text-5xl font-display font-bold">
                    Des mains qui <span class="gradient-text">créent</span>
                </h2>
                
                <p class="text-lg text-night-600 leading-relaxed">
                    Dans notre atelier de Cotonou, une quinzaine de collaborateurs travaillent chaque jour à la création 
                    de pièces uniques. Tous partagent la même exigence de qualité et la même fierté du travail bien fait.
                </p>
                
                <p class="text-lg text-night-600 leading-relaxed">
                    Nous croyons en une décoration responsable, où chaque création prend le temps d'exister. 
                    C'est pourquoi nous privilégions les petites séries et les pièces sur-mesure.
                </p>
                
                <div class="pt-4">
                    <a href="#contact" class="inline-flex items-center gap-3 text-terracotta-500 font-semibold group">
                        <span>Rencontrer l'équipe</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-2 transition"></i>
                    </a>
                </div>
            </div>
            
            <div class="order-1 lg:order-2 relative">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="overflow-hidden rounded-2xl shadow-lg">
                            <img src="https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400&auto=format&fit=crop" 
                                 alt="Création en cours" 
                                 class="w-full h-48 object-cover hover:scale-110 transition duration-700">
                        </div>
                        <div class="overflow-hidden rounded-2xl shadow-lg">
                            <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=400&auto=format&fit=crop" 
                                 alt="Travail textile" 
                                 class="w-full h-64 object-cover hover:scale-110 transition duration-700">
                        </div>
                    </div>
                    <div class="space-y-4 mt-8">
                        <div class="overflow-hidden rounded-2xl shadow-lg">
                            <img src="https://images.unsplash.com/photo-1562259929-b4e1e3a40ee6?w=400&auto=format&fit=crop" 
                                 alt="Couture" 
                                 class="w-full h-64 object-cover hover:scale-110 transition duration-700">
                        </div>
                        <div class="overflow-hidden rounded-2xl shadow-lg">
                            <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=400&auto=format&fit=crop" 
                                 alt="Finitions" 
                                 class="w-full h-48 object-cover hover:scale-110 transition duration-700">
                        </div>
                    </div>
                </div>
                
                <!-- Badge flottant -->
                <div class="absolute -bottom-6 -left-6 bg-white/90 backdrop-blur p-4 rounded-xl shadow-xl">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-quote-right text-3xl text-terracotta-500"></i>
                        <div>
                            <div class="font-semibold text-night-900">15 collaborateurs</div>
                            <div class="text-sm text-night-500">Passion & savoir-faire</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== ENGAGEMENTS ===== -->
<section class="py-16 bg-night-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-4xl md:text-5xl font-display font-bold mb-6">
                Nos <span class="text-terracotta-500">engagements</span>
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Engagement 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-terracotta-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-2xl text-terracotta-500"></i>
                </div>
                <h3 class="font-display font-bold text-lg mb-2">Éco-responsable</h3>
                <p class="text-white/70 text-sm">Matériaux durables et upcycling</p>
            </div>
            
            <!-- Engagement 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-saffron-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-heart text-2xl text-saffron-500"></i>
                </div>
                <h3 class="font-display font-bold text-lg mb-2">Production locale</h3>
                <p class="text-white/70 text-sm">Fabrication à Cotonou</p>
            </div>
            
            <!-- Engagement 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-safari-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-safari-500"></i>
                </div>
                <h3 class="font-display font-bold text-lg mb-2">Créations durables</h3>
                <p class="text-white/70 text-sm">Des pièces conçues pour durer</p>
            </div>
            
            <!-- Engagement 4 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-terracotta-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-people-group text-2xl text-terracotta-500"></i>
                </div>
                <h3 class="font-display font-bold text-lg mb-2">Transmission</h3>
                <p class="text-white/70 text-sm">Formation des nouvelles générations</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== NOTRE ÉQUIPE ===== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-terracotta-500 font-semibold text-sm uppercase tracking-wider">L'équipe</span>
            <h2 class="text-4xl md:text-5xl font-display font-bold mt-4 mb-6">
                Les visages de <span class="gradient-text">Segnon</span>
            </h2>
            <p class="text-lg text-night-600">
                Rencontrez les talents qui donnent vie à vos intérieurs.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Membre 1 -->
            <div class="group text-center">
                <div class="relative mb-6 overflow-hidden rounded-3xl">
                    <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?w=400&auto=format&fit=crop" 
                         alt="Mawulé" 
                         class="w-full aspect-square object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                </div>
                <h3 class="text-xl font-display font-bold">Mawulé Akakpo</h3>
                <p class="text-terracotta-500 text-sm mb-2">Fondateur & Directeur</p>
                <p class="text-sm text-night-500">Visionnaire et passionné</p>
            </div>
            
            <!-- Membre 2 -->
            <div class="group text-center">
                <div class="relative mb-6 overflow-hidden rounded-3xl">
                    <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=400&auto=format&fit=crop" 
                         alt="Aminata" 
                         class="w-full aspect-square object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                </div>
                <h3 class="text-xl font-display font-bold">Aminata Diallo</h3>
                <p class="text-terracotta-500 text-sm mb-2">Directrice Créative</p>
                <p class="text-sm text-night-500">Designer textile, 12 ans d'expérience</p>
            </div>
            
            <!-- Membre 3 -->
            <div class="group text-center">
                <div class="relative mb-6 overflow-hidden rounded-3xl">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop" 
                         alt="Kofi" 
                         class="w-full aspect-square object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                </div>
                <h3 class="text-xl font-display font-bold">Kofi Mensah</h3>
                <p class="text-terracotta-500 text-sm mb-2">Responsable production</p>
                <p class="text-sm text-night-500">Expert en textiles</p>
            </div>
            
            <!-- Membre 4 -->
            <div class="group text-center">
                <div class="relative mb-6 overflow-hidden rounded-3xl">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&auto=format&fit=crop" 
                         alt="Fatou" 
                         class="w-full aspect-square object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-night-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                </div>
                <h3 class="text-xl font-display font-bold">Fatou Ndiaye</h3>
                <p class="text-terracotta-500 text-sm mb-2">Relation clients</p>
                <p class="text-sm text-night-500">Votre contact privilégié</p>
            </div>
        </div>
    </div>
</section>

@endsection