<?php

return [
    'modules' => [
        // ==== HÔTEL ====
        'hotel' => [
            'name' => 'Hôtellerie',
            'is_core' => true,
            'roles' => [
                'owner'   => 'hotel_owner',
                'manager' => 'hotel_manager',
                'editor'  => 'hotel_editor',
                'finance' => 'hotel_finance',
            ],
            'resources' => [
                'hotels'   => ['extras' => ['restore','force-delete','archive','unarchive','publish','unpublish','export']],
                'rooms'    => ['extras' => ['restore','force-delete','export']],
                'products' => ['extras' => ['restore','force-delete','archive','unarchive','publish','unpublish','import','export','media.upload','media.delete']],
                'bookings' => ['extras' => ['manage','cancel','export']],
                'orders'   => ['extras' => ['manage','refund','export']],
            ],
            'transversal' => [
                'rates.view','rates.update',
                'availability.view','availability.update',
                'finance.self.view','finance.self.export',
                'payments.capture','payments.refund',
                'account.members.invite','account.members.remove',
                'account.profile.update','account.settings.update','account.modules.manage',
                'submissions.create',
                'reports.view','reports.export',
                'api_keys.manage','webhooks.manage',
                'media.upload','media.delete',
            ],
        ],


        // ==== SHOP ====
        'shop' => [
            'name' => "Boutique d’art",
            'is_core' => true,
            'roles' => [
                'owner'   => 'shop_owner',
                'manager' => 'shop_manager',
                'editor'  => 'shop_editor',
                'finance' => 'shop_finance',
            ],
            'resources' => [
                'products' => ['extras' => ['restore','force-delete','archive','unarchive','publish','unpublish','import','export','media.upload','media.delete']],
                'orders'   => ['extras' => ['manage','refund','export']],
                'customers'=> ['extras' => ['export']],
            ],
            'transversal' => [
                'finance.self.view','finance.self.export',
                'account.members.invite','account.members.remove',
                'account.profile.update',
                'reports.view','reports.export',
                'media.upload','media.delete',
            ],
        ],

        // ==== GUIDES ====
        'guide' => [
            'name' => 'Guide touristique',
            'is_core' => true,
            'roles' => [
                'owner'   => 'guide_owner',
                'manager' => 'guide_manager',
                'editor'  => 'guide_editor',
                'finance' => 'guide_finance',
                // rôle “terrain”
                'worker'  => 'guide_staff',
            ],
            'resources' => [
                'guides'      => ['extras' => ['approve','suspend','export']],           // gestion profils guides
                'tours'       => ['extras' => ['publish','unpublish','export']],         // circuits/visites
                'assignments' => ['extras' => ['manage','reassign','cancel','export']],  // affectations
                'schedules'   => ['extras' => ['update','export']],                      // plannings
                'bookings'    => ['extras' => ['manage','cancel','export']],             // réservations guidées
            ],
            'transversal' => [
                'availability.view','availability.update',
                'reports.view','reports.export',
                // droits “self” pour le guide terrain :
                'assignments.self.view','assignments.self.update',
                'schedules.self.update','reports.create',
            ],
        ],

        // ==== RESTAURANT ====
        'restaurant' => [
            'name'    => 'Restauration',
            'is_core' => true,
            'roles' => [
                'owner'   => 'restaurant_owner',
                'manager' => 'restaurant_manager',
                'editor'  => 'restaurant_editor',
                'finance' => 'restaurant_finance',
                'worker'  => 'restaurant_staff', // service / cuisine / runner
            ],
            'resources' => [
                'restaurants' => ['extras' => ['publish','unpublish','archive','unarchive','export']],
                'menus'       => ['extras' => ['publish','unpublish','export']],
                'menu_items'  => ['extras' => ['import','export','media.upload','media.delete']],
                'categories'  => ['extras' => ['export']],
                'tables'      => ['extras' => ['export']],
                'bookings'    => ['extras' => ['manage','cancel','export']],   // réservations de tables (garde "bookings" pour rester homogène)
                'orders'      => ['extras' => ['manage','refund','export']],    // commandes sur place / click&collect
                'deliveries'  => ['extras' => ['assign','cancel','export']],    // livraisons/prise en charge
                'schedules'   => ['extras' => ['update','export']],             // horaires & shifts
                'inventory'   => ['extras' => ['import','export']],             // stock/ingrédients
                'modifiers'   => ['extras' => ['export']],                      // options, suppléments
            ],
            'transversal' => [
                'availability.view','availability.update',
                'finance.self.view','finance.self.export',
                'payments.capture','payments.refund',
                'account.members.invite','account.members.remove',
                'account.profile.update',
                'reports.view','reports.export',
                'media.upload','media.delete',

                // droits "terrain" pour le staff (compatibles avec le template worker du seeder)
                'assignments.self.view','assignments.self.update',
                'schedules.self.update','reports.create',
            ],
        ],

        // ==== ÉVÉNEMENTIEL (Organisateurs) ====
        'event' => [
            'name'    => 'Événementiel',
            'is_core' => true,
            'roles' => [
                'owner'   => 'event_owner',
                'manager' => 'event_manager',
                'editor'  => 'event_editor',
                'finance' => 'event_finance',
                'worker'  => 'event_staff', // billetterie / contrôle / staff terrain
            ],
            'resources' => [
                'events'       => ['extras' => ['publish','unpublish','archive','unarchive','export']],
                'venues'       => ['extras' => ['export']],
                'ticket_types' => ['extras' => ['export']],                     // tarifs & catégories
                'tickets'      => ['extras' => ['export']],                     // tickets émis
                'orders'       => ['extras' => ['manage','refund','export']],   // ventes billets
                'attendees'    => ['extras' => ['export']],
                'checkins'     => ['extras' => ['scan','export']],              // contrôle d’accès
                'schedules'    => ['extras' => ['update','export']],            // programme / sessions
                'speakers'     => ['extras' => ['export']],
                'sponsors'     => ['extras' => ['export']],
                'coupons'      => ['extras' => ['manage','export']],            // promos / codes
            ],
            'transversal' => [
                'availability.view','availability.update',
                'finance.self.view','finance.self.export',
                'payments.capture','payments.refund',
                'account.members.invite','account.members.remove',
                'account.profile.update',
                'reports.view','reports.export',
                'media.upload','media.delete',

                // staff terrain (compatibles avec le template worker du seeder)
                'assignments.self.view','assignments.self.update',
                'schedules.self.update','reports.create',
            ],
        ],

    ],
];
