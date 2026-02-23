<?php

return [

    //Options = Les valeurs possibles pour slot
    'shortcuts' => [
        ['key' => 'buy', 'label' => '🛍️ Acheter'],
        ['key' => 'contact_us', 'label' => '💬 Nous contacter'],
    ],

    'intents' => [
        'buy' => [
            'question' => "Choisissez une catégorie :",
            'slot'     => 'category',
            'options'  => [], // Vide = dynamique
            'table'    => 'Product',
        ],

        'contact_us' => [
            'question' => "Comment souhaitez-vous nous contacter ?",
            'slot'     => 'contact_type',
            'options'  => ['Téléphone', 'WhatsApp', 'Email'],
            'table'    => 'Contact',
        ],

        'popular' => [
            'question' => "Produits populaires :",
            'slot'     => 'popular_type',
            'options'  => [],  // ← Vide, devrait être dynamique
            'table'    => 'Product',
        ],
    ],

    // Limite globale par source (override possible via 'limit' dans une source)
    'limit' => 12,

    // Taille min d’un terme + stopwords fr/en courants
    'min_term_length' => 3,
    'stopwords' => require __DIR__.'/bot_stopwords.php',


    // Activer expérimentalement FULLTEXT si dispo (voir commentaire dans service)
    'fulltext' => false,

    'sources' => [
        'products' => [
            'model'  => App\Models\Product::class,
            'fields' => require __DIR__.'/bot_fields.php',
            'route'  => 'shop.products.show',
            'param'  => 'product',
        ],

        'contacts' => [
            'model'  => App\Models\Contact::class,
            'fields' => require __DIR__.'/bot_fields.php',
            'route'  => 'contact',
            'param'  => 'contact',
        ],

    ],
];
