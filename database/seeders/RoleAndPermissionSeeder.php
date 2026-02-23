<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\{User, Account, Module, Product, ProductSku};
use App\Support\Platform;
use Illuminate\Support\Facades\Schema;
use App\Models\{Hotel, Room};
use Illuminate\Support\Facades\Cache;

class RoleAndPermissionSeeder extends Seeder {

    public function run(): void {
        // IMPORTANT: Spatie teams activé et team_foreign_key = 'account_id' dans config/permission.php
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // ====== Permissions PARTENAIRES (scopées par account/teams) ======
        $crud = fn(string $r) => ["$r.view-any","$r.view","$r.create","$r.update","$r.delete"];
        /**
         * Définition des ressources métiers + actions additionnelles.
         * Ajoute ici toute nouvelle ressource/table (ex: 'tours', 'menus', etc.).
         */
        $resourceExtras = [
            // Hôtellerie
            'hotels'   => ['restore','force-delete','archive','unarchive','publish','unpublish','export'],
            'rooms'    => ['restore','force-delete','export'],

            // Boutique d'art
            'products' => ['restore','force-delete','archive','unarchive','publish','unpublish','import','export','media.upload','media.delete'],
            'customers'=> ['export'], // facultatif

            // Flux transactionnels
            'orders'   => ['manage','refund','export'],      // manage = confirmer, annuler, marquer payé...
            'bookings' => ['manage','cancel','export'],      // choisis "bookings" OU "reservations" et tiens-toi à un seul
        ];

        // Génération CRUD + extras
        $partnerPerms = collect($resourceExtras)->flatMap(function (array $extras, string $r) use ($crud) {
                return array_merge($crud($r), array_map(fn($e) => "$r.$e", $extras));
            })
            // Transverses (hors ressource)
            ->merge([
                'rates.view','rates.update',
                'availability.view','availability.update',

                // Finance (self = limité à son compte)
                'finance.self.view','finance.self.export',
                'payments.capture','payments.refund',

                // Espace partenaire
                'account.members.invite','account.members.remove',
                'account.profile.update','account.settings.update','account.modules.manage',

                // Modération (soumissions à valider)
                'submissions.create',

                // Rapports & intégrations
                'reports.view','reports.export',
                'api_keys.manage','webhooks.manage',

                // Média global (si besoin hors produit)
                'media.upload','media.delete',
            ])
            ->unique()
            ->values()
            ->all();

        // Upsert
        foreach ($partnerPerms as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }


        // ====== Rôles partenaires ======
        $hotelOwner   = Role::firstOrCreate(['name' => 'hotel_owner',   'guard_name' => 'web']);
        $hotelManager = Role::firstOrCreate(['name' => 'hotel_manager', 'guard_name' => 'web']);
        $hotelEditor  = Role::firstOrCreate(['name' => 'hotel_editor',  'guard_name' => 'web']);
        $hotelFinance = Role::firstOrCreate(['name' => 'hotel_finance', 'guard_name' => 'web']);

        $hotelOwner->givePermissionTo([
            'hotels.view-any','hotels.view','hotels.create','hotels.update','hotels.delete',
            'rooms.view-any','rooms.view','rooms.create','rooms.update','rooms.delete',
            'products.view-any','products.view','products.create','products.update','products.delete',
            'rates.update','availability.update',
            'bookings.view','bookings.manage',
            'orders.view','orders.manage',
            'finance.self.view','finance.self.export',
            'account.members.invite','account.members.remove','account.profile.update',
        ]);

        $hotelManager->givePermissionTo([
            'hotels.view-any','hotels.view','hotels.update',
            'rooms.view-any','rooms.view','rooms.create','rooms.update',
            'products.view-any','products.view','products.create','products.update',
            'rates.update','availability.update',
            'bookings.view','bookings.manage',
            'orders.view','orders.manage',
            'finance.self.view',
        ]);

        $hotelEditor->givePermissionTo([
            'hotels.view-any','hotels.view',
            'rooms.view-any','rooms.view','rooms.create','rooms.update',
            'products.view-any','products.view',
        ]);

        $hotelFinance->givePermissionTo(['finance.self.view','finance.self.export']);

        // Shop
        $shopOwner   = Role::firstOrCreate(['name' => 'shop_owner',   'guard_name' => 'web']);
        $shopManager = Role::firstOrCreate(['name' => 'shop_manager', 'guard_name' => 'web']);
        $shopEditor  = Role::firstOrCreate(['name' => 'shop_editor',  'guard_name' => 'web']);
        $shopFinance = Role::firstOrCreate(['name' => 'shop_finance', 'guard_name' => 'web']);

        $shopOwner->givePermissionTo([
            'products.view-any','products.view','products.create','products.update','products.delete',
            'orders.view','orders.manage',
            'finance.self.view','finance.self.export',
            'account.members.invite','account.members.remove','account.profile.update',
        ]);
        $shopManager->givePermissionTo([
            'products.view-any','products.view','products.create','products.update',
            'orders.view','orders.manage',
            'finance.self.view',
        ]);
        $shopEditor->givePermissionTo([
            'products.view-any','products.view','products.create','products.update',
        ]);
        $shopFinance->givePermissionTo(['finance.self.view','finance.self.export']);

        // ====== Bloc ADMIN plateforme (global, hors scope de compte) ======
        $adminPerms = [
            'platform.view','platform.manage',
            'content.review','content.publish',
            'accounts.verify','accounts.manage',
            'finance.view','finance.payouts.manage',
            'support.tickets.manage',
        ];
        foreach ($adminPerms as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        $super     = Role::firstOrCreate(['name' => 'super_admin',   'guard_name' => 'web']);
        $moderator = Role::firstOrCreate(['name' => 'moderator',     'guard_name' => 'web']);
        $finance   = Role::firstOrCreate(['name' => 'finance_admin', 'guard_name' => 'web']);
        $support   = Role::firstOrCreate(['name' => 'support',       'guard_name' => 'web']);
        $dev       = Role::firstOrCreate(['name' => 'developer',     'guard_name' => 'web']);

        // Le super admin a tout (admin + partenaire)
        $super->givePermissionTo(array_merge($adminPerms, $partnerPerms));
        $moderator->givePermissionTo(['platform.view','content.review','content.publish']);
        $finance->givePermissionTo(['platform.view','finance.view','finance.payouts.manage']);
        $support->givePermissionTo(['platform.view','support.tickets.manage']);
        // 'developer' n'obtient rien ici : le bypass se fait via Gate::before + config/mega.php

        // ====== Démo / Comptes & utilisateurs seedés via ENV ======

        // 0) Compte "Platform" pour scoper les rôles admin globaux
        $platform = Account::firstOrCreate(['name' => config('platform.account_name', 'Platform')]);
        // $platform = Account::firstOrCreate(['name' => config('platform.account_name')]);
        // reset le cache d’ID si besoin
        Cache::forget('platform_account_id');

        // 1) Super Admin (scopé sur Platform)
        $superUser = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@zalymerveille.com')],
            ['firstname' => 'Super', 'lastname' => 'Admin', 'status' => 1, 'password' => bcrypt(env('ADMIN_PASSWORD','u4esgfw4588@#scwcwDE'))],
        );
        $superUser->email_verified_at = now(); $superUser->save();
        // rattacher au compte Platform + default
        $superUser->accounts()->syncWithoutDetaching([$platform->id => ['is_owner' => true]]);
        if (empty($superUser->default_account_id)) {
            $superUser->default_account_id = $platform->id;
            $superUser->save();
        }

        // assigner le rôle super_admin dans la team Platform (PAS de NULL)
        app(PermissionRegistrar::class)->setPermissionsTeamId($platform->id);
        $superUser->assignRole('super_admin');


        // 2) Developer (Mega Access) – aussi scopé sur Platform
        if ($devEmail = env('DEV_EMAIL', 'ever21321@gmail.com')) {
            $devUser = User::firstOrCreate(
                ['email' => $devEmail],
                ['firstname' => 'Ever', 'lastname' => 'Never', 'status' => 1, 'password' => bcrypt(env('DEV_PASSWORD','u4esgfw4588@#scDE'))]
            );
            $devUser->email_verified_at = now();  // ✅
            $devUser->save();

            $devUser->accounts()->syncWithoutDetaching([$platform->id => ['is_owner' => false]]);
            app(PermissionRegistrar::class)->setPermissionsTeamId($platform->id);
            $devUser->assignRole('developer'); // les “super pouvoirs” dev passent par Gate::before + config/mega.php
        }


        // 3) Compte partenaire de démo (scopé par account)
        $acc = Account::firstOrCreate(['name' => env('DEMO_ACCOUNT_NAME','Demo Partner')]);

        // Activer TOUS les modules existants pour ce compte
        $allModuleIds = \App\Models\Module::pluck('id')->all();
        $acc->modules()->syncWithoutDetaching(
            collect($allModuleIds)->mapWithKeys(
                fn($id) => [$id => ['is_enabled' => true, 'activated_at' => now()]]
            )->all()
        );

        // User propriétaire de démo
        $owner = User::firstOrCreate(
            ['email' => env('DEMO_OWNER_EMAIL','dev@dev.com')],
            ['firstname' => 'Owner', 'lastname' => 'Dev', 'password' => bcrypt('password')]
        );
        $owner->email_verified_at = now();
        $owner->save();

        // Lier comme OWNER du compte
        $owner->accounts()->syncWithoutDetaching([$acc->id => ['is_owner' => true]]);

        // Récupérer tous les rôles "owner" mappés aux modules (module_roles.level='owner')
        $ownerRoleNames = \App\Models\Module::with(['roles' => fn($q) => $q->wherePivot('level','owner')])
            ->whereIn('id', $allModuleIds)
            ->get()
            ->flatMap(fn($m) => $m->roles->pluck('name'))
            ->unique()
            ->values()
            ->all();

        // Assigner ces rôles dans la TEAM (= account) du partenaire
        app(PermissionRegistrar::class)->setPermissionsTeamId($acc->id);
        if (!empty($ownerRoleNames)) {
            $owner->assignRole($ownerRoleNames);
        }


        if (Schema::hasTable('hotels') && Schema::hasColumn('hotels','account_id')) {
            $available = Hotel::whereNull('account_id')->count();

            if ($available > 0) {
                $take = min($available, random_int(3, 10));
                $hotelIds = Hotel::whereNull('account_id')
                    ->inRandomOrder()
                    ->take($take)
                    ->pluck('id');

                // Assigner ces hôtels au compte de démo
                Hotel::whereIn('id', $hotelIds)->update(['account_id' => $acc->id]);

                // Assigner leurs rooms si la colonne existe (et si non déjà scopées)
                if (Schema::hasTable('rooms') && Schema::hasColumn('rooms','account_id')) {
                    Room::whereIn('hotel_id', $hotelIds)
                        ->whereNull('account_id')
                        ->update(['account_id' => $acc->id]);
                }
            }
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products','account_id')) {
            $available = Product::whereNull('account_id')->count();
            if ($available > 0) {
                $take = min($available, random_int(5, 10));
                $productIds = Product::whereNull('account_id')
                    ->inRandomOrder()
                    ->take($take)
                    ->pluck('id');
                // Assigner ces produits au compte de démo
                Product::whereIn('id', $productIds)->update(['account_id' => $acc->id]);
                // Assigner leurs ProductSku si la colonne existe (et si non déjà scopées)
                if (Schema::hasTable('rooms') && Schema::hasColumn('product_skus','account_id')) {
                    ProductSku::whereIn('product_id', $productIds)
                        ->whereNull('account_id')
                        ->update(['account_id' => $acc->id]);
                }
            }
        }

    }
}

