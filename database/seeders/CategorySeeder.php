<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
    public function run(): void {
        
        $categories = [
            // Électronique et High-Tech
            ['name' => 'Smartphones', 'slug' => 'smartphones', 'description' => 'Téléphones mobiles et accessoires', 'position' => 1],
            ['name' => 'Ordinateurs', 'slug' => 'ordinateurs', 'description' => 'PC portables, fixes et tablettes', 'position' => 2],
            ['name' => 'Audio', 'slug' => 'audio', 'description' => 'Casques, écouteurs et enceintes', 'position' => 3],
            ['name' => 'Photographie', 'slug' => 'photographie', 'description' => 'Appareils photo, objectifs et drones', 'position' => 4],
            
            // Mode et Accessoires
            ['name' => 'Vêtements Femme', 'slug' => 'vetements-femme', 'description' => 'Robes, tops, jeans et lingerie', 'position' => 5],
            ['name' => 'Vêtements Homme', 'slug' => 'vetements-homme', 'description' => 'Chemises, pantalons, costumes', 'position' => 6],
            ['name' => 'Chaussures', 'slug' => 'chaussures', 'description' => 'Baskets, bottes, sandales', 'position' => 7],
            ['name' => 'Montres', 'slug' => 'montres', 'description' => 'Montres connectées et traditionnelles', 'position' => 8],
            
            // Maison et Déco
            ['name' => 'Ameublement', 'slug' => 'ameublement', 'description' => 'Meubles, rangement et décoration', 'position' => 9],
            ['name' => 'Cuisine', 'slug' => 'cuisine', 'description' => 'Ustensiles, électroménager, arts de la table', 'position' => 10],
            ['name' => 'Literie', 'slug' => 'literie', 'description' => 'Matelas, oreillers, linge de lit', 'position' => 11],
            
            // Beauté et Bien-être
            ['name' => 'Cosmétiques', 'slug' => 'cosmetiques', 'description' => 'Maquillage, soins visage et corps', 'position' => 12],
            ['name' => 'Parfums', 'slug' => 'parfums', 'description' => 'Parfums femme, homme et coffrets', 'position' => 13],
            
            // Sports et Loisirs
            ['name' => 'Fitness', 'slug' => 'fitness', 'description' => 'Musculation, yoga, cardio', 'position' => 14],
            ['name' => 'Sports d\'extérieur', 'slug' => 'sports-exterieur', 'description' => 'Camping, randonnée, cyclisme', 'position' => 15],
            
            // Enfants et Bébé
            ['name' => 'Puériculture', 'slug' => 'puericulture', 'description' => 'Poussettes, sièges auto, jeux', 'position' => 16],
            ['name' => 'Jeux et Jouets', 'slug' => 'jeux-jouets', 'description' => 'Jeux d\'éveil, puzzles, figurines', 'position' => 17],
            
            // Alimentation
            ['name' => 'Épicerie fine', 'slug' => 'epicerie-fine', 'description' => 'Produits du terroir, vins, chocolats', 'position' => 18],
            ['name' => 'Boissons', 'slug' => 'boissons', 'description' => 'Cafés, thés, jus, sodas', 'position' => 19],
            
            // Auto-Moto
            ['name' => 'Auto-Moto', 'slug' => 'auto-moto', 'description' => 'Accessoires, entretien, navigation', 'position' => 20],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}