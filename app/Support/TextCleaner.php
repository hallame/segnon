<?php

// app/Support/TextCleaner.php
namespace App\Support;

use Mews\Purifier\Facades\Purifier;

class TextCleaner {
    public static function htmlToPlain(string $html): string {
        if (!mb_detect_encoding($html, 'UTF-8', true)) {
            $html = mb_convert_encoding($html, 'UTF-8');
        }

        // Balises → séparateurs
        $html = preg_replace('#<(br|BR)\s*/?>#', "\n", $html);
        $html = preg_replace('#</?(p|div|tr|table|thead|tbody|tfoot|ul|ol|li|h[1-6])[^>]*>#i', "\n", $html);
        $html = preg_replace('#</?(td|th)[^>]*>#i', ' ', $html);

        // Purge totale (profil "plain" dans config/purifier.php)
        $clean = Purifier::clean($html, 'plain');

        // Entités + espaces
        $text  = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text  = preg_replace('/[\h\x{00A0}]+/u', ' ', $text);
        // Collapser lignes vides multiples
        $text  = preg_replace("/\R{2,}/u", "\n", $text);
        return trim($text);
    }

    /**
     * Version pour description d'hôtel : enlève en tête le nom et la (ville/pays) si présents.
     */
    public static function cleanHotelDescription(string $html, ?string $name=null, ?string $city=null, ?string $country=null): string {
        $text  = self::htmlToPlain($html);
        $lines = array_values(array_filter(array_map('trim', preg_split("/\R/u", $text))));

        // Retire la 1ère ligne si elle contient le nom (souvent collé en majuscules)
        if ($name && isset($lines[0]) && mb_stripos($lines[0], $name) !== false) {
            array_shift($lines);
        }
        // Retire la 1ère ligne suivante si c’est la ville/le pays
        if (($city || $country) && isset($lines[0])) {
            $pattern = [];
            if ($city)    $pattern[] = preg_quote($city, '/');
            if ($country) $pattern[] = preg_quote($country, '/');
            if ($pattern && preg_match('/('.implode('|',$pattern).')/iu', $lines[0])) {
                array_shift($lines);
            }
        }

        return trim(implode("\n", $lines));
    }
}
