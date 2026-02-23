<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Event::create([
            'name' => 'Festival culturel de Zaly',
            'description' => 'Un événement culturel majeur célébrant les traditions locales de la Guinée.',
            'start_date' => Carbon::create('2025', '05', '01', '10', '00', '00'), // Date et heure de début
            'end_date' => Carbon::create('2025', '05', '02', '20', '00', '00'), // Date et heure de fin
            'location' => 'Nzérékoré, Guinée',
            'image' => 'festival_zaly.jpg', // Nom de l'image (assurez-vous que l'image est dans le répertoire public/images)
            'language_id' => 1, // ID de la langue
            'category_id' => 1, // ID de la catégorie (si nécessaire)
            'latitude' => 7.7464,
            'longitude' => -8.6503,
            'map_url' => 'https://maps.google.com/?q=7.7464,-8.6503',
            'map_description' => 'Lieu du festival',
        ]);

        Event::create([
            'name' => 'Concert de musique traditionnelle',
            'description' => 'Concert en plein air mettant en avant les artistes locaux.',
            'start_date' => Carbon::create('2025', '06', '10', '18', '00', '00'),
            'end_date' => Carbon::create('2025', '06', '10', '22', '00', '00'),
            'location' => 'Conakry, Guinée',
            'image' => 'concert_musique_traditionnelle.jpg',
            'language_id' => 1,
            'category_id' => 2,
            'latitude' => 9.4395,
            'longitude' => -13.5784,
            'map_url' => 'https://maps.google.com/?q=9.4395,-13.5784',
            'map_description' => 'Lieu du concert',
        ]);
    }
}
