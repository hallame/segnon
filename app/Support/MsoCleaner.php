<?php

namespace App\Support;

use Mews\Purifier\Facades\Purifier;

class MsoCleaner {
    protected static function detectAndConvertUtf8(string $html): string {
        $enc = mb_detect_encoding($html, ['UTF-8','ISO-8859-1','Windows-1252','ASCII'], true) ?: 'UTF-8';
        return mb_convert_encoding($html, 'UTF-8', $enc);
    }

    protected static function preNormalize(string $html): string {
        $html = preg_replace('/<!--.*?-->/s', ' ', $html);
        $html = preg_replace('/<!\[if.*?endif\]>/is', ' ', $html);
        $html = preg_replace('/<style[^>]*>.*?<\/style>/is', ' ', $html);
        $html = preg_replace('/<script[^>]*>.*?<\/script>/is', ' ', $html);

        // classes/attributs MSO
        $html = preg_replace('/\sclass="[^"]*Mso[^"]*"/i', ' ', $html);
        $html = preg_replace('/\sstyle="[^"]*mso-[^"]*"/i', ' ', $html);

        return $html;
    }

    /** HTML MSO -> TEXTE propre (garde des séparateurs logiques) */
    public static function toText(string $html): string {
        $html = self::preNormalize(self::detectAndConvertUtf8($html));
        $wrapped = '<?xml encoding="UTF-8">' . $html;

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $ok  = @$dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        if (!$ok) {
            // Fallback brutal si DOM échoue
            $txt = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            return trim(preg_replace('/\s+/u', ' ', $txt));
        }

        $buf  = [];
        $walk = function (\DOMNode $node) use (&$walk, &$buf) {
            if ($node->nodeType === XML_TEXT_NODE) {
                $buf[] = $node->nodeValue;
                return;
            }
            if ($node->nodeType === XML_ELEMENT_NODE) {
                $tag = strtolower($node->nodeName);
                if (in_array($tag, ['p','div','tr','table','h1','h2','h3','h4','h5','h6','ul','ol'])) $buf[] = "\n";
                if ($tag === 'br') $buf[] = "\n";

                foreach (iterator_to_array($node->childNodes) as $child) {
                    $walk($child);
                }

                if ($tag === 'li')  $buf[] = "\n";
                if ($tag === 'td' || $tag === 'th') $buf[] = ' ';
                if (in_array($tag, ['p','div','tr','table'])) $buf[] = "\n";
            }
        };

        $root = $dom->getElementsByTagName('body')->item(0) ?: $dom;
        $walk($root);

        $text = implode('', $buf);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[\h\x{00A0}]+/u', ' ', $text);
        $text = preg_replace("/(?:\r\n|\r|\n){2,}/", "\n", $text);

        return trim($text);
    }

    /** Retire les deux 1ères lignes si elles contiennent nom/ville/pays */
    public static function toTextForHotel(string $html, ?string $name=null, ?string $city=null, ?string $country=null): string
    {
        $text  = self::toText($html);
        $lines = array_values(array_filter(array_map('trim', preg_split("/\R/u", $text))));

        for ($i = 0; $i < 2; $i++) {
            if (!isset($lines[0])) break;
            $l = $lines[0];
            $hit = false;

            if ($name && mb_stripos($l, $name) !== false)      $hit = true;
            if ($city && mb_stripos($l, $city) !== false)       $hit = true;
            if ($country && mb_stripos($l, $country) !== false) $hit = true;

            if ($hit || $l === '') { array_shift($lines); $i--; continue; }
            break;
        }

        return trim(implode("\n", $lines));
    }

    /** HTML propre pour page détail (paragraphes) avec Fallback si Purifier vide */
    public static function toSafeHtml(string $html): string
    {
        $text = self::toText($html);
        if ($text === '') return '';

        $parts = preg_split("/\n{2,}/", $text);
        $parts = array_map(fn($p) => trim($p), $parts);
        $parts = array_values(array_filter($parts, fn($p) => $p !== ''));

        $rebuilt = implode("\n", array_map(fn($p) => '<p>'.e($p).'</p>', $parts));

        // Purifier (⚠️ sans HTML5) — ou retire cette ligne si tu préfères
        $clean = Purifier::clean($rebuilt, [
            // 'HTML.Doctype' => 'XHTML 1.0 Transitional',
            'HTML.Allowed' => 'p,br,strong,b,em,i,a[href|title|target],ul,ol,li',
            'Attr.AllowedFrameTargets' => ['_blank'],
            'Attr.AllowedRel' => ['nofollow','noopener','noreferrer'],
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => true,
            'URI.AllowedSchemes' => ['http'=>true,'https'=>true,'mailto'=>true],
        ]);

        // Fallback : si Purifier renvoie vide, on renvoie la version rebuild non purifiée
        if (trim(strip_tags($clean)) === '') {
            return $rebuilt;
        }
        return $clean;
    }
}
