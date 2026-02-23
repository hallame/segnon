<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder {
    public function run(): void {
        $now = now();

        // ——— FAQs “base Zaly” (≈20) ———
        $items = [
            ['q' => 'Qui peut devenir partenaire ?', 'a' => "Tout acteur du tourisme, de la culture ou de l’artisanat : hôtels, maisons d’hôtes, artisans, restaurants, organisateurs d’événements, musées, sites touristiques, guides, services, etc."],
            ['q' => 'Quels modules sont disponibles sur Zaly ?', 'a' => "Hôtels & chambres (réservation), Événements & billetterie (QR code), Boutique artisanale (e-commerce), Restaurants & menus, Circuits/visites, Musées & objets, Sites touristiques, Guides & Staff, Pages & blog."],
            ['q' => 'Y a-t-il des frais d’activation ?', 'a' => "Dans la plupart des cas non. Des options avancées (branding, domaine personnalisé, intégrations externes) peuvent être proposées sur devis."],
            ['q' => 'Comment sont calculées les commissions ?', 'a' => "Selon le module (réservation hôtel, billetterie, e-commerce). Les pourcentages exacts sont communiqués à la validation de votre compte et peuvent varier selon le pays et le mode de paiement."],
            ['q' => 'Puis-je activer plusieurs modules sur le même compte ?', 'a' => "Oui. Un même compte peut combiner hôtel + boutique + événements + restaurant + visites guidées, etc."],
            ['q' => 'Combien de temps pour être en ligne ?', 'a' => "L’onboarding standard prend 24 à 72h selon la complétude des informations (textes, tarifs, photos, disponibilités)."],
            ['q' => 'Proposez-vous un accompagnement ?', 'a' => "Oui : support, tutoriels, et conseils de mise en avant (photos, textes, SEO). Une formation express est possible pour vos équipes."],
            ['q' => 'Comment fonctionnent les paiements ?', 'a' => "Paiements en ligne (selon pays/intégrations) ou sur place. Les reversements peuvent être hebdomadaires ou mensuels, selon vos préférences et conditions."],
            ['q' => 'Billetterie événements : quelles fonctionnalités ?', 'a' => "Création d’événements, tarifs/quotas, billets avec QR code, contrôle à l’entrée (en ligne/hors-ligne), exports, rapports de ventes."],
            ['q' => 'Réservations hôtel : que peut-on configurer ?', 'a' => "Types de chambres, tarifs (nuit/saison/promos), calendrier de dispo, politiques d’annulation, no-show, taxes et options (petit-déj, transfert...)."],
            ['q' => 'Boutique artisanale : gérez-vous les stocks et variantes ?', 'a' => "Oui. Produits, variantes (taille, couleur...), inventaire, photos, catégories, coupons, commandes, livraison locale/point retrait."],
            ['q' => 'Peut-on gérer des visites guidées et assigner des guides ?', 'a' => "Oui. Les guides sont validés par l’admin et peuvent être assignés à des réservations (sites touristiques, musées, circuits) avec planning et suivi."],
            ['q' => 'Multi-comptes et rôles : comment ça marche ?', 'a' => "Un compte = votre structure. Vous pouvez inviter des utilisateurs (admin/manager/staff) avec des permissions fines par module."],
            ['q' => 'Peut-on utiliser un nom de domaine personnalisé ?', 'a' => "Oui, en option. Vous pouvez aussi démarrer avec un sous-domaine Zaly et basculer plus tard sur votre domaine."],
            ['q' => 'Multilingue et devises ?', 'a' => "Interface et contenus multilingues (FR/EN, etc.). Devises locales possibles, avec gestion des taxes et formats régionaux."],
            ['q' => 'Comment Zaly améliore ma visibilité en ligne ?', 'a' => "Page publique optimisée, référencement SEO de base, partage rapide sur réseaux sociaux, intégration carte/itinéraires, widgets embarquables."],
            ['q' => 'Modération des contenus : comment ça se passe ?', 'a' => "Les contenus peuvent passer par brouillon → relecture → publication. Les avis/notations peuvent être activés avec modération."],
            ['q' => 'Intégrations externes possibles ?', 'a' => "Liens WhatsApp, Facebook, Instagram, Google Maps, export iCal, passerelles de paiement compatibles selon région. D’autres intégrations sur demande."],
            ['q' => 'Puis-je exporter mes données ?', 'a' => "Oui. Export des réservations, commandes, contacts, produits, etc. (CSV/Excel/JSON selon le besoin)."],
            ['q' => 'Comment arrêter le service ou retirer mes contenus ?', 'a' => "Vous pouvez demander la désactivation de modules, la suppression de contenus, et l’export de vos données. Nous vous accompagnons durant la transition."],
            ['q' => 'Quel type de support proposez-vous ?', 'a' => "Support par email et messagerie, base de connaissances, délais de réponse généralement sous 24-48h ouvrées."],
        ];

        // ——— Construction des lignes avec slugs uniques + positions ———
        $rows = [];
        $used = [];
        $pos  = 0;

        foreach ($items as $item) {
            $base = Str::slug(Str::limit($item['q'], 60, '')) ?: Str::random(6);
            $slug = $base; $i = 2;
            while (in_array($slug, $used, true)) {
                $slug = $base.'-'.$i++;
            }
            $used[] = $slug;

            $rows[] = [
                'question'     => $item['q'],
                'answer'       => $item['a'],
                'slug'         => $slug,
                'account_id'   => null,     // Renseigner si besoin (multi-tenant)
                'category_id'  => null,     // Renseigner si vous seediez des catégories FAQ
                'position'     => $pos++,
                'active'       => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        // ——— Upsert sur le slug (idempotent) ———
        DB::table('faqs')->upsert(
            $rows,
            ['slug'], // clé d’unicité
            ['question','answer','position','active','category_id','account_id','updated_at']
        );
    }
}
