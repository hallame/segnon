<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder {
    public function run(): void {
        $tags = [
            // Tags produits généraux
            ['name' => 'Nouveauté', 'slug' => 'nouveaute'],
            ['name' => 'Promotion', 'slug' => 'promotion'],
            ['name' => 'Meilleure vente', 'slug' => 'meilleure-vente'],
            ['name' => 'Coup de cœur', 'slug' => 'coup-de-coeur'],
            ['name' => 'Éco-responsable', 'slug' => 'eco-responsable'],
            
            // Tags qualité/état
            ['name' => 'Premium', 'slug' => 'premium'],
            ['name' => 'Entrée de gamme', 'slug' => 'entree-de-gamme'],
            ['name' => 'Reconditionné', 'slug' => 'reconditionne'],
            ['name' => 'Neuf', 'slug' => 'neuf'],
            
            // Tags saisonniers
            ['name' => 'Noël', 'slug' => 'noel'],
            ['name' => 'Soldes d\'été', 'slug' => 'soldes-ete'],
            ['name' => 'Soldes d\'hiver', 'slug' => 'soldes-hiver'],
            ['name' => 'Back to school', 'slug' => 'rentree-scolaire'],
            
            // Tags tendances
            ['name' => 'Tendance', 'slug' => 'tendance'],
            ['name' => 'Instagrammable', 'slug' => 'instagrammable'],
            ['name' => 'Influenceur', 'slug' => 'influenceur'],
            
            // Tags livraison/garantie
            ['name' => 'Livraison gratuite', 'slug' => 'livraison-gratuite'],
            ['name' => 'Garantie 2 ans', 'slug' => 'garantie-2-ans'],
            ['name' => 'En stock', 'slug' => 'en-stock'],
            ['name' => 'Pré-commande', 'slug' => 'pre-commande'],
        ];
        

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}