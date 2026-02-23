<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lignes de langage pour la validation
    |--------------------------------------------------------------------------
    */

    'accepted' => 'Le champ :attribute doit être accepté.',
    'active_url' => 'Le champ :attribute n’est pas une URL valide.',
    'current_password' => 'Le mot de passe actuel est incorrect.',

    'after' => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal' => ' :attribute doit être une date postérieure ou égale au :date.',
    'alpha' => 'Le champ :attribute ne peut contenir que des lettres.',
    'alpha_dash' => 'Le champ :attribute ne peut contenir que des lettres, chiffres, tirets et tirets bas.',
    'alpha_num' => 'Le champ :attribute ne peut contenir que des lettres et chiffres.',
    'array' => 'Le champ :attribute doit être un tableau.',
    'before' => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date antérieure ou égale au :date.',
    'between' => [
        'numeric' => 'Le champ :attribute doit être compris entre :min et :max.',
        'file' => 'Le fichier :attribute doit être compris entre :min et :max kilo-octets.',
        'string' => 'Le champ :attribute doit contenir entre :min et :max caractères.',
        'array' => 'Le champ :attribute doit contenir entre :min et :max éléments.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation de :attribute ne correspond pas.',
    'date' => 'Le champ :attribute n’est pas une date valide.',
    'date_equals' => 'Le champ :attribute doit être une date égale à :date.',
    'date_format' => 'Le champ :attribute ne correspond pas au format :format.',
    'different' => 'Les champs :attribute et :other doivent être différents.',
    'digits' => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between' => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'dimensions' => 'Le champ :attribute a des dimensions d’image invalides.',
    'distinct' => 'Le champ :attribute a une valeur en double.',
    'email' => 'Le champ :attribute doit être une adresse email valide.',
    'ends_with' => 'Le champ :attribute doit se terminer par l’une des valeurs suivantes : :values',
    'exists' => 'Le champ :attribute sélectionné est invalide.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute est obligatoire.',
    'gt' => [
        'numeric' => 'Le champ :attribute doit être supérieur à :value.',
        'file' => 'Le fichier :attribute doit être plus grand que :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir plus de :value caractères.',
        'array' => 'Le champ :attribute doit contenir plus de :value éléments.',
    ],
    'gte' => [
        'numeric' => 'Le champ :attribute doit être supérieur ou égal à :value.',
        'file' => 'Le fichier :attribute doit être supérieur ou égal à :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au moins :value caractères.',
        'array' => 'Le champ :attribute doit contenir :value éléments ou plus.',
    ],
    'image' => 'Le champ :attribute doit être une image.',
    'in' => 'Le champ :attribute sélectionné est invalide.',
    'in_array' => 'Le champ :attribute n’existe pas dans :other.',
    'integer' => 'Le champ :attribute doit être un entier.',
    'ip' => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le champ :attribute doit être une chaîne JSON valide.',
    'lt' => [
        'numeric' => 'Le champ :attribute doit être inférieur à :value.',
        'file' => 'Le fichier :attribute doit être plus petit que :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir moins de :value caractères.',
        'array' => 'Le champ :attribute doit contenir moins de :value éléments.',
    ],
    'lte' => [
        'numeric' => 'Le champ :attribute doit être inférieur ou égal à :value.',
        'file' => 'Le fichier :attribute doit être inférieur ou égal à :value kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au maximum :value caractères.',
        'array' => 'Le champ :attribute ne doit pas contenir plus de :value éléments.',
    ],
    'max' => [
        'numeric' => 'Le champ :attribute ne peut pas être supérieur à :max.',
        'file' => 'Le fichier :attribute ne peut pas dépasser :max kilo-octets.',
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        'array' => 'Le champ :attribute ne peut pas contenir plus de :max éléments.',
    ],
    'mimes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'mimetypes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'min' => [
        'numeric' => 'Le champ :attribute doit être au moins de :min.',
        'file' => 'Le fichier :attribute doit faire au moins :min kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
        'array' => 'Le champ :attribute doit contenir au moins :min éléments.',
    ],
    'not_in' => 'Le champ :attribute sélectionné est invalide.',
    'not_regex' => 'Le format du champ :attribute est invalide.',
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => 'Le champ :attribute doit être présent.',
    'regex' => 'Le format du champ :attribute est invalide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'Le champ :attribute est obligatoire quand :other est :value.',
    'required_unless' => 'Le champ :attribute est obligatoire sauf si :other est dans :values.',
    'required_with' => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire quand :values sont présents.',
    'required_without' => 'Le champ :attribute est obligatoire quand :values n’est pas présent.',
    'required_without_all' => 'Le champ :attribute est obligatoire quand aucun de :values ne sont présents.',
    'same' => 'Les champs :attribute et :other doivent correspondre.',
    'size' => [
        'numeric' => 'Le champ :attribute doit être :size.',
        'file' => 'Le fichier :attribute doit faire :size kilo-octets.',
        'string' => 'Le champ :attribute doit contenir :size caractères.',
        'array' => 'Le champ :attribute doit contenir :size éléments.',
    ],
    'starts_with' => 'Le champ :attribute doit commencer par : :values.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone' => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique' => 'Le champ :attribute a déjà été pris.',
    'uploaded' => 'Le champ :attribute n’a pas pu être téléversé.',
    'url' => 'Le format du champ :attribute est invalide.',
    'uuid' => 'Le champ :attribute doit être un UUID valide.',
    'throttle' => 'Trop de tentatives. Veuillez réessayer dans :seconds secondes.',


    /*
    |--------------------------------------------------------------------------
    | Valeurs des attributs  ou input
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        //  Authentification / Utilisateurs
        'email' => 'adresse e-mail',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
        'current_password' => 'mot de passe actuel',
        'new_password' => 'nouveau mot de passe',
        'username' => 'nom d’utilisateur',
        'remember' => 'se souvenir de moi',
        'token' => 'jeton',
        'role' => 'rôle',
        'permissions' => 'autorisations',

        //  Profil utilisateur
        'firstname' => 'prénom',
        'lastname' => 'nom de famille',
        'name' => 'nom',
        'gender' => 'genre',
        'birthdate' => 'date de naissance',
        'avatar' => 'photo de profil',
        'bio' => 'biographie',
        'username' => 'nom d’utilisateur',

        //  Contact / formulaire
        'query' => 'champ de recherche',
        'subject' => 'sujet',
        'message' => 'votre message',
        'phone' => 'téléphone',
        'address' => 'adresse',
        'city' => 'ville',
        'postal_code' => 'code postal',
        'country' => 'pays',

        //  Produits / Commandes
        'product' => 'produit',
        'product_id' => 'identifiant du produit',
        'category' => 'catégorie',
        'quantity' => 'quantité',
        'price' => 'prix',
        'total' => 'total',
        'order' => 'commande',
        'order_id' => 'identifiant de commande',
        'status' => 'statut',
        'payment_method' => 'mode de paiement',
        'shipping_address' => 'adresse de livraison',

        //  Contenus / CMS
        'title' => 'titre',
        'slug' => 'identifiant URL',
        'description' => 'description',
        'content' => 'contenu',
        'excerpt' => 'extrait',
        'image' => 'image',
        'file' => 'fichier',
        'video' => 'vidéo',
        'published_at' => 'date de publication',

        //  Dates / horaires
        'date' => 'date',
        'start_date' => 'date de début',
        'end_date' => 'date de fin',
        'check_in' => 'date d’arrivée',
        'today'     => "Aujourd'hui",
        'check_out' => 'date de départ',
        'created_at' => 'créé le',
        'updated_at' => 'mis à jour le',
        'time' => 'heure',

        //  Données diverses
        'value' => 'valeur',
        'type' => 'type',
        'level' => 'niveau',
        'code' => 'code',
        'reference' => 'référence',
        'notes' => 'notes',
        'comment' => 'commentaire',
        'file_upload' => 'fichier à téléverser',
        'url' => 'URL',
        //
        'company' => 'nom de l’entreprise',


        'payment_method_id' => 'mode de paiement',
        'customer_phone'    => 'numéro de téléphone',
        'customer_email'    => 'adresse e-mail',
        'customer_firstname'=> 'prénom',
        'customer_lastname' => 'nom',



    ],


    /*
    |--------------------------------------------------------------------------
    | Messages personnalisés pour les partenaires
    |--------------------------------------------------------------------------
    */
    'custom' => [


        'payment_method_id' => [
            'required' => 'Veuillez choisir un mode de paiement.',
        ],
        'customer_phone' => [
            'required' => 'Veuillez renseigner votre numéro de téléphone.',
        ],


        'check_in' => [
            'required' => 'La date d’arrivée est requise.',
            'date' => 'La date d’arrivée doit être une date valide.',
        ],
        'check_out' => [
            'required' => 'La date de départ est requise.',
            'date' => 'La date de départ doit être une date valide.',
            'after' => 'La date de départ doit être postérieure à la date d’arrivée.',
        ],
        'guests' => [
            'required' => 'Le nombre de personnes est requis.',
            'integer' => 'Le nombre de personnes doit être un nombre entier.',
            'min' => 'Au moins une personne doit être présente.',
            'max' => 'Le nombre de personnes ne peut pas dépasser :max.',
        ],
        'firstname' => [
            'required' => 'Le prénom est requis.',
            'string' => 'Le prénom doit être une chaîne de caractères.',
            'max' => 'Le prénom ne peut pas dépasser :max caractères.',
        ],
        'lastname' => [
            'required' => 'Le nom est requis.',
            'string' => 'Le nom doit être une chaîne de caractères.',
            'max' => 'Le nom ne peut pas dépasser :max caractères.',
        ],
        'email' => [
            'required' => 'L’adresse email est requise.',
            'email' => 'L’adresse email doit être valide.',
        ],
        'phone' => [
            'required' => 'Le numéro de téléphone est requis.',
            'string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'max' => 'Le numéro de téléphone ne peut pas dépasser :max caractères.',
        ],
        'payment_method' => [
            'required' => 'Le mode de paiement est requis.',
            'string' => 'Le mode de paiement doit être une chaîne de caractères.',
            'in' => 'Le mode de paiement sélectionné est invalide.',
        ],
        'special_requests' => [
            'string' => 'Les demandes spéciales doivent être une chaîne de caractères.',
            'max' => 'Les demandes spéciales ne peuvent pas dépasser :max caractères.',
        ],
        'note' => [
            'string' => 'La note doit être une chaîne de caractères.',
            'max' => 'La note ne peut pas dépasser :max caractères.',
        ],
        'receipt' => [
            'file' => 'Le reçu doit être un fichier.',
            'mimes' => 'Le reçu doit être un fichier de type : jpg, jpeg, png ou pdf.',
            'max' => 'La taille du fichier ne doit pas dépasser 2 Mo.',
        ],
    ],


];
