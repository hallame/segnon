<?php

/**
 * Source de vérité unique : modules, rôles et permissions.
 * Convention permissions : {ressource}.{action} (view-any, view, create, update, delete + extras).
 * Niveaux de rôle : owner (tout), manager (tout sauf force-delete), editor (CRUD seul), finance (finance.self.*).
 */

return [

    /*
    | Permissions transversales (communes à tous les modules partenaire)
    */
    'transversal_global' => [
        'rates.view', 'rates.update',
        'availability.view', 'availability.update',
        'finance.self.view', 'finance.self.export',
        'payments.capture', 'payments.refund',
        'account.members.invite', 'account.members.remove',
        'account.profile.update', 'account.settings.update', 'account.modules.manage',
        'submissions.create', 'reports.view', 'reports.export',
        'api_keys.manage', 'webhooks.manage', 'media.upload', 'media.delete',
    ],

    /*
    | Définition des modules : slug => [ name, roles, resources, transversal ]
    */
    'modules' => [

        'hotel' => [
            'name'        => 'Hôtel',
            'description' => 'Gestion hôtelière : chambres, réservations',
            'is_core'     => false,
            'roles'       => [
                'owner'   => 'hotel_owner',
                'manager' => 'hotel_manager',
                'editor'  => 'hotel_editor',
                'finance' => 'hotel_finance',
            ],
            'resources' => [
                'hotels'   => ['extras' => ['restore', 'force-delete', 'archive', 'unarchive', 'publish', 'unpublish', 'export']],
                'rooms'    => ['extras' => ['restore', 'force-delete', 'export']],
                'bookings' => ['extras' => ['manage', 'cancel', 'export']],
                'orders'   => ['extras' => ['manage', 'refund', 'export']],
            ],
            'transversal' => [],
        ],

        'shop' => [
            'name'        => 'Boutique',
            'description' => 'E-commerce : produits, commandes',
            'is_core'     => false,
            'roles'       => [
                'owner'   => 'shop_owner',
                'manager' => 'shop_manager',
                'editor'  => 'shop_editor',
                'finance' => 'shop_finance',
            ],
            'resources' => [
                'products'  => ['extras' => ['restore', 'force-delete', 'archive', 'unarchive', 'publish', 'unpublish', 'import', 'export', 'media.upload', 'media.delete']],
                'customers' => ['extras' => ['export']],
                'orders'    => ['extras' => ['manage', 'refund', 'export']],
            ],
            'transversal' => [],
        ],

        'expert' => [
            'name'        => 'Expert',
            'description' => 'Espace expert : articles, projets',
            'is_core'     => false,
            'roles'       => [
                'owner'   => 'expert_owner',
                'manager' => 'expert_manager',
                'editor'  => 'expert_editor',
            ],
            'resources' => [
                'articles' => ['extras' => ['publish', 'unpublish', 'export']],
                'projects' => ['extras' => ['assign', 'complete', 'export']],
            ],
            'transversal' => ['reports.view', 'reports.export'],
        ],

        'restaurant' => [
            'name'        => 'Restaurant',
            'description' => 'Menus, réservations, commandes',
            'is_core'     => false,
            'roles'       => [
                'owner'   => 'restaurant_owner',
                'manager' => 'restaurant_manager',
                'editor'  => 'restaurant_editor',
                'finance' => 'restaurant_finance',
            ],
            'resources' => [
                'menus'         => ['extras' => ['publish', 'unpublish', 'export']],
                'reservations'  => ['extras' => ['manage', 'cancel', 'export']],
                'orders'        => ['extras' => ['manage', 'refund', 'export']],
            ],
            'transversal' => [],
        ],

        'artisan' => [
            'name'        => 'Artisan',
            'description' => 'Espace artisan',
            'is_core'     => false,
            'roles'       => [
                'owner'   => 'artisan_owner',
                'manager' => 'artisan_manager',
                'editor'  => 'artisan_editor',
            ],
            'resources' => [
                'products' => ['extras' => ['publish', 'export']],
                'orders'   => ['extras' => ['manage', 'export']],
            ],
            'transversal' => [],
        ],

        'developer' => [
            'name'        => 'Développeur',
            'description' => 'Espace développeur / formateur',
            'is_core'     => false,
            'roles'       => [
                'owner'   => 'developer_owner',
                'manager' => 'developer_manager',
                'editor'  => 'developer_editor',
            ],
            'resources' => [
                'courses' => ['extras' => ['publish', 'export']],
                'assignments' => ['extras' => ['grade', 'export']],
            ],
            'transversal' => [],
        ],
        'student' => [
            'name'        => 'Étudiant',
            'description' => 'Espace étudiant',
            'is_core'     => false,
            'roles'       => [
                'owner'   => 'student_owner',
                'editor'  => 'student_editor',
            ],
            'resources' => [
                'enrollments' => ['extras' => ['export']],
                'submissions' => ['extras' => ['export']],
                'courses' => ['extras' => ['publish', 'export']],
                'assignments' => ['extras' => ['grade', 'export']],
            ],
            'transversal' => ['reports.view'],
        ],

    ],
    /*
    | Admin plateforme (rôles hors scope compte partenaire)
    */
    'platform' => [
        'permissions' => [
            'platform.view', 'platform.manage',
            'content.review', 'content.publish',
            'accounts.verify', 'accounts.manage',
            'finance.view', 'finance.payouts.manage',
            'support.tickets.manage',
        ],
        'roles' => [
            'super_admin'   => null, // null = toutes les perms (admin + partenaire)
            'developer'     => [],
            'moderator'     => ['platform.view', 'content.review', 'content.publish'],
            'finance_admin' => ['platform.view', 'finance.view', 'finance.payouts.manage'],
            'support'       => ['platform.view', 'support.tickets.manage'],
        ],
    ],

    
    /*
    | Tables à lier au compte démo (colonnes account_id) quand SEED_DEMO_ACCOUNT=true
    */
    'demo_assign_tables' => ['hotels', 'products'],

];
