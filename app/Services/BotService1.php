<?php

namespace App\Services;

use App\Models\BotLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BotService {

    public function search(string $query): array {
        Log::info("Bot recherche: {$query}");
        $query = trim($query);
        $queryLower = mb_strtolower($query, 'UTF-8');

        // === DÉTECTION D'INTENTION AVANCÉE (NLU) Natural Language Understanding ===
        $intent = $this->detectIntent($queryLower);

        // Si intention claire détectée, traiter directement
        if ($intent) {
            return $this->handleDirectIntent($intent, $queryLower);
        }

        // === Mode MENU / SLOTS ======================================================
        $menus = config('bot.intents', []);

        // 2.1 Clic sur un menu -> renvoie question + options (encodées pour compat)
        if (str_starts_with($queryLower, 'menu:')) {
            $intent = substr($queryLower, 5);
            if (!isset($menus[$intent])) {
                return [[
                    'type' => 'Info',
                    'title' => 'Action non reconnue',
                    'excerpt' => "Choisissez une option parmi les menus proposés.",
                    'url' => route('bot'),
                ]];
            }
            $conf = $menus[$intent];

            $dynOptions = $this->dynamicOptionsForIntent($intent, $conf);

            // Extraire seulement les noms d'affichage pour le frontend
            $displayOptions = array_map(function($opt) {
                return is_array($opt) ? $opt['display'] : $opt;
            }, $dynOptions);

            $options = !empty($displayOptions) ? $displayOptions : ($conf['options'] ?? []);

            return [[
                'type'    => 'Question',
                'title'   => $conf['question'],
                'excerpt' => json_encode([
                    'intent'  => $intent,
                    'slot'    => $conf['slot'] ?? null,
                    'options' => $dynOptions, // ← ENVOIE LES OPTIONS COMPLÈTES (avec display ET value)
                ], JSON_UNESCAPED_UNICODE),
                'url'     => null,
            ]];
        }

        // 2.2 Clic sur une puce (option) -> slot:<slot>=<value>&intent=<intent>
        if (str_starts_with($queryLower, 'slot:')) {
            // ex: slot:region=haute-guinee&intent=visit_site
            parse_str(str_replace('slot:', '', $queryLower), $parts);
            $intent = $parts['intent'] ?? null;
            if (!$intent || !isset($menus[$intent])) {
                return [[
                'type' => 'Info',
                'title' => 'Détail manquant',
                'excerpt' => "Réessayez depuis un menu.",
                'url' => route('contact'),
                ]];
            }
            // Récup slot + value
            unset($parts['intent']);
            $slot  = array_key_first($parts);
            $value = $parts[$slot] ?? null;
            $value = $this->normalizeValue($value);

            $items = $this->runQueryByIntent($intent, $slot, $value);
            if ($items->isEmpty()) {
                return [[
                'type' => 'Aucun résultat',
                'title' => 'Aucun élément trouvé. Contactez le support',
                'excerpt' => "Essayez une autre option.",
                'url' => route('contact'),
                ]];
            }
            return $this->mapResults($items, $intent);
        }



        // --- Intentions ultra-rapides ---------------------------------------

        if (preg_match('/\b(bonjour|salut|hi|cc|hello|bonsoir|hi|coucou)\b/ui', $queryLower)) {
            return [[
                'type'    => 'MBot Assistant',
                'title'   => 'Bonjour 👋',


               'excerpt' => "<style>
                    .bot-link, .bot-link * {
                        font-size: 15px !important;
                        line-height: 1.5 !important;
                    }
                    .bot-link q {
                        font-size: 14px !important;
                        padding: 4px 10px !important;
                    }
                    </style>

                    🎯 <strong style='font-size: 17px;'>Je suis Votre Guide</strong><br><br>

                    <strong style='font-size: 16px;'>🛍️ BOUTIQUE</strong><br>
                    <a href='" . route('home') . "' class='bot-link' style='font-size: 15px;'><i class='ri-home-4-fill'></i> <q>Accueil</q></a> – Retour à l'accueil<br>
                    <a href='" . route('shop.products.index') . "' class='bot-link' style='font-size: 15px;'><i class='ri-store-3-fill'></i> <q>Boutique</q></a> – Explorer nos produits<br>
                    <a href='" . route('shop.cart.index') . "' class='bot-link' style='font-size: 15px;'><i class='ri-shopping-cart-2-fill'></i> <q>Panier</q></a> – Voir votre sélection<br><br>

                    <strong style='font-size: 16px;'>💬 SUPPORT</strong><br>
                    <a href='" . route('contact') . "' class='bot-link' style='font-size: 15px;'><i class='ri-customer-service-2-fill'></i> <q>Contact</q></a> – Assistance personnalisée<br><br>

                    <strong style='font-size: 16px;'>🤝 PARTENAIRE</strong><br>
                    <a href='" . route('partners.register') . "?module=shop' class='bot-link' style='font-size: 15px;'><i class='ri-user-add-fill'></i> <q>Devenir Vendeur</q></a> – Lancez votre boutique<br><br>

                    <em style='font-size: 15px;'>🌟 <strong>Prêt à Mylmarker ?</strong> – Je suis là pour vous guider, à vous de jouer !</em>"
                                    ,


                'url'     => route('bot'),
            ]];
        }

        if (preg_match('/\b(merci|au revoir|thanks)\b/ui', $queryLower)) {
            return [[
                'type'    => 'Réponse',
                'title'   => 'Avec plaisir 😊',
                'excerpt' => "N’hésitez pas à poser une autre question.",
                'url'     => route('bot'),
            ]];
        }

        if (preg_match('/\b(aide|help|besoin d\'aide|que peux[- ]?tu faire)\b/ui', $queryLower)) {
            return [[
                'type'    => 'Aide',
                'title'   => 'Comment puis-je vous aider ?',
                'excerpt' => "Je peux vous aider à trouver des produits spécifiques ou vous orienter vers notre service client.",
                'url'     => route('contact'),
            ]];
        }

        if (preg_match('/\b(promo|promotion|réduction|solde|discount|offre)\b/ui', $queryLower)) {
            // Chercher produits avec old_price > price (réduction)
            return $this->getDiscountedProducts($queryLower);
        }





        // --- Préparation recherche ------------------------------------------
        $tokens = $this->tokenize($queryLower);
        if (empty($tokens)) {
            return [];
        }

        $results = [];
        $sources = Config::get('bot.sources', []);
        $useFulltext = (bool) Config::get('bot.fulltext', false);

        foreach ($sources as $key => $source) {
            /** @var class-string<Model> $modelClass */
            $modelClass = $source['model'] ?? null;
            if (!$modelClass || !class_exists($modelClass)) {
                Log::warning("MBot: modèle introuvable pour la source [$key].");
                continue;
            }

            // Champs déclarés ET réellement existants (avec cache)
            $declaredFields = (array) ($source['fields'] ?? []);
            $validFields = $this->getValidFieldsForModel($modelClass, $declaredFields);
            if (empty($validFields)) {
                Log::debug("Bot: aucun champ valide pour [$key].");
                continue;
            }
            $queryBuilder = $modelClass::query();

            // --- Stratégie recherche ----------------------------------------
            // Prépare une seule fois la liste des colonnes FULLTEXT
            $cols = collect($validFields)->map(fn($f) => "`{$f}`")->implode(',');

            if ($useFulltext && $this->hasFulltextSupport($modelClass, $validFields)) {
                // Requête booléenne: +token* (obligatoire + wildcard)
                $boolean = collect($tokens)->map(fn($t) => '+'.$t.'*')->implode(' ');

                $queryBuilder
                    ->selectRaw("*, MATCH ($cols) AGAINST (? IN BOOLEAN MODE) AS score", [$boolean])
                    ->whereRaw("MATCH ($cols) AGAINST (? IN BOOLEAN MODE)", [$boolean])
                    ->orderByDesc('score');
            }


            else {
                $useOrMode = count($tokens) >= 4;

                if ($useOrMode) {
                    // OR global + score = nb de mots trouvés dans LE MÊME champ (max sur tous les champs)
                    $scoreParts = [];
                    $scoreBindings = [];

                    foreach ($validFields as $field) {
                        $cases = [];
                        foreach ($tokens as $t) {
                            $cases[] = "CASE WHEN `$field` LIKE ? THEN 1 ELSE 0 END";
                            $scoreBindings[] = "%{$t}%";
                        }
                        // score de ce champ = somme des mots trouvés dans CE champ
                        $scoreParts[] = '(' . implode(' + ', $cases) . ')';
                    }

                    // score final = meilleur score parmi les champs
                    $scoreSql = 'GREATEST(' . implode(', ', $scoreParts) . ')';
                    $queryBuilder->select('*')->selectRaw("$scoreSql AS relevance_score", $scoreBindings);

                    // condition OR globale pour ne pas bloquer les phrases naturelles
                    $queryBuilder->where(function ($q) use ($validFields, $tokens) {
                        foreach ($tokens as $t) {
                            foreach ($validFields as $f) {
                                $q->orWhere($f, 'LIKE', "%{$t}%");
                            }
                        }
                    });

                    $queryBuilder->orderByDesc('relevance_score');
                } else {
                    // AND strict (plus précis) pour 1–3 mots
                    $queryBuilder->where(function ($q) use ($validFields, $tokens) {
                        foreach ($tokens as $t) {
                            $q->where(function ($sub) use ($validFields, $t) {
                                foreach ($validFields as $f) {
                                    $sub->orWhere($f, 'LIKE', "%{$t}%");
                                }
                            });
                        }
                    });
                }
            }

            $limit = (int) ($source['limit'] ?? Config::get('bot.limit', 5));
            $items = $queryBuilder->limit($limit)->get();
            $results = array_merge($results, $this->unifyResults($key, $items));


        }

        // Log synthétique
        try {
            BotLog::create([
                'question'   => $query,
                'result'     => json_encode(collect($results)->take(3), JSON_UNESCAPED_UNICODE),
                'user_id'  => optional(Auth::user())->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Bot: échec BotLog::create - '.$e->getMessage());
        }

        // === MODE DIRECT AMÉLIORÉ ===
        return $this->handleDirectQuery($query, $queryLower);

        Log::info("Bot résultats: " . count($results) . " éléments trouvés");
        return $results;



    }








     /**
     * Détection d'intention avancée avec patterns
     */
    private function detectIntent(string $query): ?string {
        $patterns = [
            // Produits et achats
            'buy' => [
                '/\b(je\s+veux\s+acheter|je\s+cherche\s+à\s+acheter|acheter|commander|produit|article|item)\b/ui',
                '/\b(pc|laptop|ordinateur|téléphone|smartphone|tablette|vêtement|chaussure)\b/ui',
                '/\b(prix\s+de|coût\s+de|combien\s+coûte)\b/ui',
            ],

            // Livraison
            'delivery' => [
                '/\b(livraison|livrer|expédition|envoi|délai\s+de\s+livraison|frais\s+de\s+port)\b/ui',
                '/\b(comment\s+serai.*livré|mode\s+de\s+livraison|transports?)\b/ui',
            ],

            // Publication articles
            'publish' => [
                '/\b(publier|publication|article|blog|poster|créer\s+un\s+article)\b/ui',
                '/\b(comment\s+puis.*publier|ajouter\s+un\s+article)\b/ui',
            ],

            // Abonnements et tarifs
            'subscription' => [
                '/\b(abonnement|tarif|prix|coût|forfait|plan|mensuel|annuel)\b/ui',
                '/\b(combien.*abonnement|prix.*abonnement|tarification)\b/ui',
            ],

            // Support technique
            'support' => [
                '/\b(problème|bug|erreur|ne\s+marche\s+pas|aide\s+technique|sav)\b/ui',
                '/\b(comment\s+réparer|dépanner|assistance)\b/ui',
            ],

            // Contact
            'contact' => [
                '/\b(contacter|joindre|appeler|écrire|email|téléphone|contact)\b/ui',
                '/\b(service\s+client|support\s+client|aide)\b/ui',
            ],

            // Devenir vendeur
            'seller' => [
                '/\b(devenir\s+vendeur|vendre|vendeur|partenaire|boutique\s+en\s+ligne)\b/ui',
                '/\b(comment\s+vendre|ouvrir\s+boutique|mettre\s+en\s+vente)\b/ui',
            ],
        ];

        foreach ($patterns as $intentKey => $patternList) {
            foreach ($patternList as $pattern) {
                if (preg_match($pattern, $query)) {
                    return $intentKey;
                }
            }
        }
        return null;
    }

    /**
     * Traitement des intentions directes
     */
    private function handleDirectIntent(string $intent, string $query): array {
        switch ($intent) {
            case 'buy':
                // Recherche produits avec extraction de mots-clés
                $keywords = $this->extractProductKeywords($query);
                return $this->searchProducts($keywords);

            case 'delivery':
                return [[
                    'type' => 'Livraison',
                    'title' => '🚚 Informations Livraison',
                    'excerpt' => "Veuillez contacter le vendeur, ses coordonnées se trouvent dans les détails du produit concerné ou contactez le support.",
                    'url' => route('contact'),
                ]];

            case 'publish':
                return [[
                    'type' => 'Publication',
                    'title' => '📝 Publier un produit',
                    'excerpt' => "Connectez-vous et ajoutez votre produit. Notre équipe valide rapidement.",
                    'url' => route('login'),
                ]];

            case 'subscription':
                return [[
                    'type' => 'Abonnements',
                    'title' => '💰 Formules & Tarifs',
                    'excerpt' => "Plusieurs formules disponibles selon vos besoins. <a href='" . route('pricing') . "'>Comparer les formules</a>",
                    'url' => route('pricing'),
                ]];

            case 'support':
                return [[
                    'type' => 'Contact',
                    'title' => '📞 Nous contacter',
                    'excerpt' => "Pour toute question, notre équipe est à votre écoute.<br><br><a href='" . route('contact') . "'>Envoyer un message</a>",
                    'url' => route('contact'),
                ]];

            case 'seller':
                return [[
                    'type' => 'Devenir Vendeur',
                    'title' => '🚀 Programme Vendeur',
                    'excerpt' => "Découvrez nos offres spéciales pour les vendeurs. <a href='" . route('pricing') . "'>Consulter les détails</a>",
                    'url' => route('pricing'),
                ]];
            case 'contact':
                return [[
                    'type' => 'Contact',
                    'title' => '📞 Nous contacter',
                    'excerpt' => "Pour toute question, veuillez nous contacter via notre formulaire en ligne. Nous vous répondrons rapidement.<br>",
                    'url' => route('contact'),
                ]];
        }

        return [];
    }

    /**
     * Recherche directe améliorée avec scoring intelligent
     */

    private function handleDirectQuery(string $query, string $queryLower): array {
        // Mots-clés importants (pondération)
        $tokens = $this->tokenize($queryLower);

        if (empty($tokens)) {
            return [[
                'type' => 'Info',
                'title' => '🤔 Veuillez préciser',
                'excerpt' => "Exemples:<br>'Je cherche un téléphone'",
                'url' => route('bot'),
            ]];
        }
        // Recherche multi-sources avec scoring
        $results = [];
        $sources = config('bot.sources', []);

        foreach ($sources as $key => $source) {
            $modelClass = $source['model'] ?? null;
            if (!$modelClass || !class_exists($modelClass)) continue;

            $items = $this->smartSearch($modelClass, $tokens, $query);
            $results = array_merge($results, $this->unifyResults($key, $items));
        }

        // Si aucun résultat, proposer alternatives
        if (empty($results)) {
            return $this->suggestAlternatives($query, $tokens);
        }

        // Limiter et retourner
        return array_slice($results, 0, config('bot.limit', 5));
    }

    /**
     * Recherche intelligente avec scoring par pertinence
     */
    private function smartSearch(string $modelClass, array $tokens, string $originalQuery) {
        $model = new $modelClass;
        $table = $model->getTable();
        $fields = $this->getValidFieldsForModel($modelClass, ['name', 'title', 'description', 'content']);

        if (empty($fields)) {
            return collect();
        }
        // Construction de la requête avec scoring avancé
        $query = $modelClass::query();

        // Score basé sur:
        // 1. Match exact = 10 points
        // 2. Match partiel = 5 points
        // 3. Priorité titres > descriptions

        $selectParts = [];
        $bindings = [];

        foreach ($fields as $field) {
            $fieldScore = in_array($field, ['name', 'title']) ? 2 : 1;
            $scoreExact = $fieldScore * 10;
            $scorePartial = $fieldScore * 5;

            foreach ($tokens as $token) {
                // Match exact
                $selectParts[] = "CASE WHEN LOWER($field) = ? THEN {$scoreExact} ELSE 0 END";
                $bindings[] = $token;

                // Match partiel (LIKE)
                $selectParts[] = "CASE WHEN $field LIKE ? THEN {$scorePartial} ELSE 0 END";
                $bindings[] = "%{$token}%";
            }
        }

        if (!empty($selectParts)) {
            $scoreSql = implode(' + ', $selectParts) . ' AS relevance_score';
            $query->select('*')->selectRaw($scoreSql, $bindings);

            // Condition: au moins un token match
            $query->where(function ($q) use ($fields, $tokens) {
                foreach ($tokens as $token) {
                    foreach ($fields as $field) {
                        $q->orWhere($field, 'LIKE', "%{$token}%");
                    }
                }
            });

            $query->orderByDesc('relevance_score');
        }

        $this->addActiveScope($query, $modelClass);

        return $query->limit(config('bot.limit', 10))->get();
    }

    /**
     * Extraction de mots-clés produits
     */
    private function extractProductKeywords(string $query): array {
        // Filtrage des mots non pertinents
        $stopPhrases = ['je veux', 'je cherche', 'acheter', 'commander', 'trouver', 'pour'];

        $cleanQuery = $query;
        foreach ($stopPhrases as $phrase) {
            $cleanQuery = preg_replace("/\b{$phrase}\b/ui", '', $cleanQuery);
        }

        // Extraction de caractéristiques
        $features = [
            'budget' => '/(\d+)\s*(€|euro|euros)/ui',
            'color' => '/(noir|blanc|rouge|bleu|vert|jaune|gris|rose)/ui',
            'brand' => '/(apple|samsung|xiaomi|huawei|dell|hp|lenovo)/ui',
        ];

        $keywords = $this->tokenize($cleanQuery);

        // Ajout des caractéristiques détectées
        foreach ($features as $type => $pattern) {
            if (preg_match($pattern, $query, $matches)) {
                $keywords[] = $matches[1] ?? $matches[0];
            }
        }

        return array_unique(array_filter($keywords));
    }

    /**
     * Recherche produits avancée
     */
    private function searchProducts(array $keywords): array {
        if (empty($keywords)) {
            return [[
                'type' => 'Produits',
                'title' => '🔍 Que recherchez-vous ?',
                'excerpt' => "Exemples: 'Chaussures'",
                'url' => route('shop.products.index'),
            ]];
        }

        $model = \App\Models\Product::class;
        $query = $model::query();

        $this->addActiveScope($query, $model);

        // Recherche avec priorité
        $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $keyword) {
                $q->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhere('meta_title', 'LIKE', "%{$keyword}%");
            }
        });

        $items = $query->latest()->limit(8)->get();

        if ($items->isEmpty()) {
            return [[
                'type' => 'Produits',
                'title' => 'Aucun produit trouvé',
                'excerpt' => "Essayez avec d'autres termes ou <a href='" . route('contact') . "'>demandez-nous</a>",
                'url' => route('shop.products.index'),
            ]];
        }

        return $this->unifyResults('products', $items);
    }

    /**
     * Suggestions alternatives quand aucun résultat
     */
    private function suggestAlternatives(string $query, array $tokens): array {
        // Suggestions basées sur le premier token
        $firstToken = $tokens[0] ?? '';

        $suggestions = [
            'produit' => 'Essayez notre boutique: <a href="' . route('shop.products.index') . '">Parcourir les produits</a>',
            'article' => "Pour publier: <a href='" . route('partners.register') . "?module=shop'>Créer un compte vendeur</a>",
            'contact' => 'Contactez-nous: <a href="' . route('contact') . '">Formulaire</a>',
            'aide' => 'Centre d\'aide: <a href="' . route('contact') . '">Nous Contacter</a>',
        ];

        foreach ($suggestions as $keyword => $suggestion) {
            if (stripos($query, $keyword) !== false) {
                return [[
                    'type' => 'Suggestion',
                    'title' => '💡 Voici ce que je peux vous proposer',
                    'excerpt' => $suggestion,
                    'url' => null,
                ]];
            }
        }

        // Fallback général
        return [[
            'type' => 'Assistant',
            'title' => 'Je ne trouve pas exactement',
            'excerpt' => "Essayez:<br>• Des mots plus simples<br>• Une question plus précise<br>• Ou utilisez les boutons ci-dessus",
            'url' => route('bot'),
        ]];
    }




    private function getDiscountedProducts(string $query): array {
        $model = \App\Models\Product::class;
        $q = $model::query();
        $this->addActiveScope($q, $model);

        // Produits en réduction (old_price > price)
        if (Schema::hasColumn((new $model)->getTable(), 'old_price') &&
            Schema::hasColumn((new $model)->getTable(), 'price')) {
            $q->whereColumn('old_price', '>', 'price')
            ->whereNotNull('description')  // Description non vide
            ->where('description', '!=', '')  // Pas de chaîne vide
            ->orderByRaw('(old_price - price) DESC');
        }

        // Sinon, chercher par tags/mots-clés
        else {
            $q->where(function($query) {
                $query->where('name', 'like', '%promo%')
                    ->orWhere('name', 'like', '%réduction%')
                    ->orWhere('description', 'like', '%solde%');
            });
        }

        $items = $q->limit(config('bot.limit', 10))->get();
        return $this->unifyResults('products', $items, 'Promotions');
    }
    // ---------------------------------------------------------------------
    // Helpers PRIVÉS – pas de fonctions globales => pas de "redeclare"
    // ---------------------------------------------------------------------

    /** Normalise + tokenize avec stopwords et longueur min. */
    private function tokenize(string $text): array {
        $text = $this->normalizeText($text);
        $parts = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $minLen = (int) Config::get('bot.min_term_length', 3);
        $stop   = array_flip((array) Config::get('bot.stopwords', []));
        $tokens = [];
        foreach ($parts as $p) {
            if (mb_strlen($p, 'UTF-8') < $minLen) continue;
            if (isset($stop[$p])) continue;
            $tokens[] = $p;
        }
        return array_values(array_unique($tokens));
    }

    /** Normalisation accent/ponctuation/espaces. */
    private function normalizeText(string $text): string {
        $text = strip_tags($text);
        $text = mb_strtolower($text, 'UTF-8');

        // Remplacer & par "et" pour la recherche
        $text = str_replace('&', ' et ', $text);

        // Garder les accents, seulement enlever la ponctuation inutile
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));

        return $text;
    }

    /** Cache la liste des colonnes existantes pour un modèle puis croise avec les champs déclarés. */
    private function getValidFieldsForModel(string $modelClass, array $declared): array {
        /** @var Model $model */
        $model = new $modelClass;
        $table = $model->getTable();
        $cacheKey = "bot.columns.$table";

        $columns = Cache::remember($cacheKey, now()->addDay(), function () use ($table) {
            if (!Schema::hasTable($table)) return [];
            try {
                return Schema::getColumnListing($table);
            } catch (\Throwable $e) {
                Log::warning("Bot: getColumnListing échoué pour [$table] - ".$e->getMessage());
                return [];
            }
        });

        $declared = array_values(array_filter($declared));
        return array_values(array_intersect($declared, $columns));
    }

    /** Libellé i18n avec fallback propre. */
    private function typeLabel(string $key): string {
        $label = __("bot.$key");
        return ($label !== "bot.$key") ? $label : Str::headline($key);
    }

    /** Détection simple: possible de choisir d’activer FULLTEXT seulement si champs indexés existent. */
    private function hasFulltextSupport(string $modelClass, array $fields): bool {
        // Simplifié: on considère qu’au moins 1 champ text long suffit; idéalement, vérifiez vos index FULLTEXT.
        // possible de maintenir une whitelist par modèle dans la config.
        return !empty($fields);
    }

    //////////////////////////////// recherche guidee

    private function normalizeValue(?string $v): ?string {
        if ($v === null) return null;

        // GARDE les accents et le &, remplace seulement les espaces par des tirets
        $v = trim($v);

        // Convertir & en "et" pour la recherche
        $v = str_replace('&', 'et', $v);

        // Garder les accents, seulement remplacer espaces par tirets
        $v = preg_replace('/\s+/', '-', $v);

        // Enlever les caractères vraiment problématiques (pas les accents)
        $v = preg_replace('/[^\p{L}\p{N}\-]/u', '', $v);

        return mb_strtolower($v, 'UTF-8');
    }

    /** Champs utilisables pour un modèle: priorités + bot_fields, filtrés aux colonnes existantes. */
    private function fieldsFor(string $modelClass, array $preferred = []): array {
        $global = (array) \Illuminate\Support\Facades\Config::get('bot_fields', []);
        // priorité aux champs "preferred", puis fallback sur la liste globale
        $declared = array_values(array_unique(array_filter(array_merge($preferred, $global))));
        return $this->getValidFieldsForModel($modelClass, $declared);
    }



    private function variantsLike(string $raw): array {
        $v = trim($this->normalizeText($raw));
        if ($v === '') return [];

        // variantes de base
        $base = [$v];

        // singulier/pluriel simple
        if (!str_ends_with($v, 's')) $base[] = $v.'s';
        if (str_ends_with($v, 's')) $base[] = rtrim($v, 's');

        // tirets/espaces
        $base[] = str_replace('-', ' ', $v);
        $base[] = str_replace(' ', '-', $v);
        $base = array_values(array_unique($base));

        // en %like%
        return array_map(fn($w) => '%'.$w.'%', $base);
    }



    private function runQueryByIntent(string $intent, ?string $slot, ?string $value) {
        $limit = config('bot.limit', 10); // Augmenter la limite

        switch ($intent) {
            case 'buy': {
                $model = \App\Models\Product::class;
                $q = $model::query();

                $q->whereNotNull('description')
                ->where('description', '!=', '')
                ->whereNotNull('name')
                ->where('name', '!=', '');
                $this->addActiveScope($q, $model);

                if ($slot === 'category' && $value) {
                    // Log pour debug
                    \Illuminate\Support\Facades\Log::info("Recherche catégorie: {$value}", [
                        'slot' => $slot,
                        'value' => $value
                    ]);

                    // Trouver la catégorie AVEC filtre model='Product'
                    $category = \App\Models\Category::where('model', 'Product')
                        ->where(function($query) use ($value) {
                            $query->where('slug', $value)
                                ->orWhere('name', 'like', '%' . str_replace('-', ' ', $value) . '%');
                        })
                        ->first();

                    if ($category) {
                        $q->where('category_id', $category->id);
                        \Illuminate\Support\Facades\Log::info("Catégorie trouvée: {$category->name} (ID: {$category->id})");
                    } else {
                        // Fallback: chercher dans le nom/description des produits
                        $searchTerm = str_replace('-', ' ', $value);
                        $q->where(function($query) use ($searchTerm) {
                            $query->where('name', 'like', "%{$searchTerm}%")
                                ->orWhere('description', 'like', "%{$searchTerm}%");
                        });
                        \Illuminate\Support\Facades\Log::info("Catégorie non trouvée, recherche par terme: {$searchTerm}");
                    }
                }

                return $q->latest()->limit($limit)->get();
            }
            case 'contact_us': {
                $model = \App\Models\Contact::class;
                $q = $model::query();
                $this->addActiveScope($q, $model);

                if ($slot === 'name' && $value && $value !== 'autre') {
                    $cols = $this->fieldsFor($model, ['name']);
                    $this->applyFlexibleFilter($q, $model, $cols, $this->normalizeValue($value));
                }
                return $q->latest()->limit($limit)->get();
            }

            case 'popular': {
                $model = \App\Models\Product::class;
                $q = $model::query();
                $this->addActiveScope($q, $model);

                $q->whereNotNull('description')
                ->where('description', '!=', '')
                ->whereNotNull('name')
                ->where('name', '!=', '');

                if ($slot === 'popular_type' && $value) {
                    switch ($value) {
                        case 'most-viewed':
                            // Produits les plus vus via la relation views()
                            $q->withCount(['views as views_count'])
                            ->orderBy('views_count', 'DESC');
                            break;

                        case 'best-sellers':
                            // Produits les plus vendus (si vous avez un champ 'sales_count' ou relation 'orders')
                            if (Schema::hasColumn((new $model)->getTable(), 'sales_count')) {
                                $q->orderBy('sales_count', 'DESC');
                            } elseif (method_exists($model, 'orders')) {
                                // Si vous avez une relation orders
                                $q->withCount(['orders as orders_count'])
                                ->orderBy('orders_count', 'DESC');
                            }
                            break;

                        case 'top-rated':
                            // Produits mieux notés (si vous avez un système de ratings)
                            if (Schema::hasColumn((new $model)->getTable(), 'rating')) {
                                $q->orderBy('rating', 'DESC');
                            } elseif (method_exists($model, 'ratings')) {
                                // Si vous avez une relation ratings
                                $q->withAvg('ratings', 'score')
                                ->orderByDesc('ratings_avg_score');
                            }
                            break;

                        case 'all-trending':
                        default:
                            // Combinaison de vues et ventes
                            $q->withCount(['views as views_count'])
                            ->orderBy('views_count', 'ASC');
                            break;
                    }
                } else {
                    // Par défaut : produits les plus vus
                    $q->withCount(['views as views_count'])
                    ->orderBy('views_count', 'DESC');
                }

                return $q->limit($limit)->get();
            }

        }
        return collect();
    }



    private function applyFlexibleFilter($query, string $modelClass, array $preferredColumns, string $value): void {
        $m = new $modelClass;
        $table = $m->getTable();
        $cols = array_values(array_filter($preferredColumns, fn($c) => Schema::hasColumn($table, $c)));
        if (empty($cols)) return;

        // variantes classiques + fuzzy
        $likes = array_unique(array_merge(
            $this->variantsLike($value),         // ex: %nzerekore%, %n- zerekore%, …
            $this->variantsLikeFuzzy($value)     // ex: %n%z%e%r%e%k%o%r%e%
        ));
        if (empty($likes)) return;

        $query->where(function ($q) use ($cols, $likes) {
            foreach ($cols as $col) {
                foreach ($likes as $like) {
                    $q->orWhere($col, 'LIKE', $like);
                }
            }
        });
    }




    //////////////////////////////////////////////////////////

    private function addActiveScope($q, string $model): void{
        $table = (new $model)->getTable();
        if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'active')) {
            $q->where('active', 1);
        } elseif (\Illuminate\Support\Facades\Schema::hasColumn($table, 'status')) {
            // status: 1 = actif
            $q->where('status', 1);
        }
    }

    /** Génère l’URL d’un item selon la config (sources standard vs pages par type). */
    private function buildItemUrl(string $key, array $source, $item): ?string {
        try {
            // --- Cas spécial PAGES avec types (config: sources.pages.types.{type}.route/param)
            if ($key === 'pages') {
                $typesCfg = $source['types'] ?? [];
                $type     = $item->type ?? null;

                if ($type && isset($typesCfg[$type])) {
                    $pageRoute = $typesCfg[$type]['route'] ?? null;
                    $paramKey  = $typesCfg[$type]['param'] ?? null;

                    if ($pageRoute) {
                        if (!\Illuminate\Support\Facades\Route::has($pageRoute)) {
                            Log::debug("Bot: route [$pageRoute] absente (pages/$type).");
                            return null;
                        }

                        if ($paramKey) {
                            $value = $item->{$paramKey} ?? $item->slug ?? $item->getRouteKey();
                            return ($value !== null)
                                ? route($pageRoute, [$paramKey => $value])
                                : route($pageRoute);
                        }

                        return route($pageRoute);
                    }
                }

                // Fallback éventuel si tu as une route générique:
                if (\Illuminate\Support\Facades\Route::has('pages.show')) {
                    $value = $item->slug ?? $item->getRouteKey();
                    return route('pages.show', $value);
                }
                return null;
            }

            // --- Sources standard
            $routeName = $source['route'] ?? null;
            if (!$routeName || !\Illuminate\Support\Facades\Route::has($routeName)) return null;

            // Si 'param' est donné dans la config, on le respecte; sinon on tente le binding implicite
            $paramKey = $source['param'] ?? null;
            if ($paramKey) {
                $value = $item->{$paramKey} ?? $item->slug ?? $item->getRouteKey();
                return ($value !== null) ? route($routeName, [$paramKey => $value]) : null;
            }

            // Binding implicite (si ta route est {site}, {hotel}, … et que le model binding est en place)
            // ⚠️ IMPORTANT: ne PAS envelopper dans un array numéroté. Passer directement le modèle.
            return route($routeName, $item);

        } catch (\Throwable $e) {
            Log::error("Bot: URL introuvable [$key] - ".$e->getMessage());
            return null;
        }
    }

    /** Retourne [titleField, excerptField] d’après bot_fields ET colonnes existantes. */
    private function pickTitleAndExcerptFields(string $modelClass): array {
        $valid = $this->fieldsFor($modelClass); // utilise ton helper fieldsFor() proposé plus tôt
        if (empty($valid)) return [null, null];

        // Heuristique de titre/extrait (tu peux ajuster l’ordre)
        $titleOrder   = ['name','title','meta_title','subtitle', 'type', 'city',];
        $excerptOrder = ['description','content','history','info',  'value', 'address', 'location'];

        $titleField   = collect($titleOrder)->first(fn($f) => in_array($f, $valid, true));
        if (!$titleField) $titleField = $valid[0] ?? null;

        $excerptField = collect($excerptOrder)->first(fn($f) => in_array($f, $valid, true));
        if ($excerptField === $titleField) {
            // prend le prochain champ dispo différent du title
            $excerptField = collect($valid)->first(fn($f) => $f !== $titleField);
        }
        return [$titleField, $excerptField];
    }

    /** Unifie le mapping des items vers le format front {type,title,excerpt,url,type_key}. */
    private function unifyResults(string $sourceKey, iterable $items, ?string $labelOverride = null): array {
        $sourceCfg = \Illuminate\Support\Facades\Config::get("bot.sources.$sourceKey", []);
        $modelClass = $sourceCfg['model'] ?? null;

        // Par défaut, type = libellé dérivé de la sourceKey (ex: 'sites' -> 'Sites'),
        // sinon on autorise un libellé override (ex: pour un intent particulier)
        $typeLabel = $labelOverride ?: $this->typeLabel($sourceKey);

        [$titleField, $excerptField] = $modelClass ? $this->pickTitleAndExcerptFields($modelClass) : [null, null];

        $out = [];
        foreach ($items as $it) {
            $title   = $titleField && !empty($it->{$titleField}) ? (string) $it->{$titleField}
                    : ($it->name ?? $it->title ?? '(Sans titre)');

            $rawExcerpt = '';
            if ($excerptField && !blank($it->{$excerptField})) {
                $rawExcerpt = (string) $it->{$excerptField};
            } else {
                $rawExcerpt = (string) (
                    $it->description
                    ?? $it->content
                    ?? $it->history
                    ?? $it->info
                    ?? $it->value
                    ?? $it->address
                    ?? $it->location
                    ?? ''
                );
            }

            $excerpt = \Illuminate\Support\Str::limit(strip_tags($rawExcerpt), 180);
            $url     = $this->buildItemUrl($sourceKey, $sourceCfg, $it);

            $image = $it->featured_image ?? null;
            $extra = [];

            $out[] = [
                'type'     => $typeLabel,
                'title'    => $title,
                'excerpt'  => $excerpt,
                'url'      => $url,
                'type_key' => $sourceKey,
                'image'    => $image,
                'extra'    => $extra,
            ];
        }
        return $out;
        }


    private function mapResults($items, string $intent): array {
        // intent -> clé de source (aligne bien avec config('bot.sources'))
        $sourceKey = match ($intent) {
            'buy'          => 'products',
            'contact_us'   => 'contacts',
            'popular'      => 'products',
        };

        $table = $intent['table'] ?? null;
        $label = $table ? \Illuminate\Support\Str::plural(\Illuminate\Support\Str::lower($table)) : null;

        return $this->unifyResults($sourceKey, $items, $label);
    }


        /**
     * Génère des options dynamiques pour un intent (sinon fallback config).
     * Retourne un tableau de strings en kebab-case (compat chips front).
     */
    private function dynamicOptionsForIntent(string $intent, array $conf): array {
        return match ($intent) {
            'buy' => $this->getCategoriesForProducts(),
            'popular' => [
                ['display' => 'Les plus vus', 'value' => 'most-viewed'],
                // ['display' => 'Best-sellers', 'value' => 'best-sellers'],
                // ['display' => 'Mieux notés', 'value' => 'top-rated'],
                ['display' => 'Toutes les tendances', 'value' => 'all-trending'],
            ],
            'contact_us' => [['display' => 'Email', 'value' => 'email']],
            default => [],
        };
    }

    private function getCategoriesForProducts(): array {
        $categories = \App\Models\Category::query()
            ->where('model', 'Product')
            ->where('status', 1)
            ->whereHas('products', function ($q) {
                $q->where('status', 1);
            })
            ->orderBy('name')
            ->limit(12)
            ->get(['id', 'name', 'slug']);

        $options = [];
        foreach ($categories as $category) {
            $slug = $category->slug ?: Str::slug($category->name, '-', 'fr');
            $options[] = [
                'display' => $category->name,  // "Téléphones & Accessoires"
                'value' => $slug,              // "telephones-accessoires"
                'id' => $category->id
            ];
        }

        return $options;
    }


    private function variantsLikeFuzzy(string $raw): array {
        $v = trim($this->normalizeText($raw)); // "nzerekore"
        if ($v === '') return [];

        // classique
        $out = ['%'.$v.'%'];

        // fuzzy: %n%z%e%r%e%k%o%r%e%
        $chars = preg_split('//u', $v, -1, PREG_SPLIT_NO_EMPTY);
        if ($chars && count($chars) >= 3) {
            $out[] = '%'.implode('%', $chars).'%';
        }
        return array_values(array_unique($out));
    }

}
