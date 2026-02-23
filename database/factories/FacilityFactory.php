<?php

namespace Database\Factories;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FacilityFactory extends Factory {

    public function definition(): array {
        static $names = [
            'Wifi',
            'Parking',
            'Piscine',
            'Spa',
            'Climatisation',
            'Télévision',
            'Petit-déjeuner',
            'Réception 24h/24',
            'Salle de sport',
            'Service de chambre',
            'Blanchisserie',
            'Ascenseur',
            'Cuisine équipée',
            'Bureau',
            'Sèche-cheveux',
            'Coffre-fort',
            'Fer à repasser',
            'Vue sur mer',
            'Balcon',
            'Terrasse',
            'Chauffage',
            'Lit bébé',
            'Animaux acceptés',
            'Accès PMR',
            'Machine à café',
            'Micro-ondes',
            'Réfrigérateur',
            'Jeux pour enfants',
            'Navette aéroport',
            'Bar',
        ];

        static $index = 0;
        $name = $names[$index % count($names)];
        $index++;
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'icon' => 'fa-solid fa-check',
            'status' => 1,
        ];
    }
}
