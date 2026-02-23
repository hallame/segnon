<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Seeder unique : structure (modules, rôles, permissions) + compte plateforme + optionnel démo.
 * Source de vérité : config/modules.php
 */
class RoleAndPermissionSeeder extends Seeder {
    private const GUARD = 'web';

    public function run(): void {
        DB::transaction(function () {
            $this->resetCache();
            $this->seedStructure();
            $this->seedPlatformAccount();
            if ($this->demoEnabled()) {
                $this->seedDemoAccount();
            }
        });
    }

    private function resetCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function teamKey(): string
    {
        return config('permission.column_names.team_foreign_key', 'account_id');
    }

    private function seedStructure(): void {
        $teamKey = $this->teamKey();
        $transversalGlobal = config('modules.transversal_global', []);
        $this->createPermissions($transversalGlobal);

        $allPartnerPerms = $transversalGlobal;

        foreach (config('modules.modules', []) as $slug => $def) {
            $module = Module::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $def['name'],
                    'description' => $def['description'] ?? null,
                    'status'      => true,
                    'is_core'     => $def['is_core'] ?? false,
                ]
            );

            $perms = $this->buildModulePermissions($def);
            $this->createPermissions($perms);
            $allPartnerPerms = array_merge($allPartnerPerms, $perms);

            $modulePerms = array_values(array_unique(array_merge($perms, $def['transversal'] ?? [])));
            $ownerPerms = array_values(array_unique(array_merge($modulePerms, $transversalGlobal)));

            $roleModels = [];
            foreach ($def['roles'] ?? [] as $level => $roleName) {
                $role = Role::firstOrCreate(
                    [
                        'name'       => $roleName,
                        'guard_name' => self::GUARD,
                        $teamKey     => null,
                    ],
                    ['name' => $roleName, 'guard_name' => self::GUARD, $teamKey => null]
                );
                $roleModels[$level] = $role;

                DB::table('module_roles')->updateOrInsert(
                    ['module_id' => $module->id, 'role_id' => $role->id],
                    ['level' => $level, 'updated_at' => now(), 'created_at' => DB::raw('COALESCE(created_at, NOW())')]
                );
            }

            $this->assignPermissionsByLevel($roleModels, $ownerPerms, $modulePerms);
        }

        $this->seedPlatformRoles(array_values(array_unique($allPartnerPerms)));
        $this->resetCache();
    }

    private function buildModulePermissions(array $def): array {
        $perms = [];
        foreach ($def['resources'] ?? [] as $resource => $opts) {
            $perms[] = "{$resource}.view-any";
            $perms[] = "{$resource}.view";
            $perms[] = "{$resource}.create";
            $perms[] = "{$resource}.update";
            $perms[] = "{$resource}.delete";
            foreach (($opts['extras'] ?? []) as $extra) {
                $perms[] = "{$resource}.{$extra}";
            }
        }
        return array_merge($perms, $def['transversal'] ?? []);
    }

    private function createPermissions(array $names): void {
        foreach (array_unique($names) as $name) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => self::GUARD],
                ['name' => $name, 'guard_name' => self::GUARD]
            );
        }
    }

    /** @param array<string, Role> $roleModels */
    private function assignPermissionsByLevel(array $roleModels, array $ownerPerms, array $modulePerms): void {
        $all = collect($ownerPerms);
        $manager = $all->reject(fn (string $p) => str_ends_with($p, '.force-delete'))->values()->all();
        $editor = collect($modulePerms)->filter(fn (string $p) => (bool) preg_match('#\.(view-any|view|create|update)$#', $p))->values()->all();
        $finance = ['finance.self.view', 'finance.self.export'];

        if (isset($roleModels['owner'])) {
            $roleModels['owner']->syncPermissions($ownerPerms);
        }
        if (isset($roleModels['manager'])) {
            $roleModels['manager']->syncPermissions($manager);
        }
        if (isset($roleModels['editor'])) {
            $roleModels['editor']->syncPermissions($editor);
        }
        if (isset($roleModels['finance'])) {
            $roleModels['finance']->syncPermissions($finance);
        }
    }

    private function seedPlatformRoles(array $allPartnerPerms): void {
        $platform = config('modules.platform', []);
        $adminPerms = $platform['permissions'] ?? [];
        $this->createPermissions($adminPerms);

        $teamKey = $this->teamKey();
        $super = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => self::GUARD, $teamKey => null],
            ['name' => 'super_admin', 'guard_name' => self::GUARD, $teamKey => null]
        );
        $super->syncPermissions(array_values(array_unique(array_merge($adminPerms, $allPartnerPerms))));

        foreach ($platform['roles'] ?? [] as $roleName => $permissionList) {
            if ($roleName === 'super_admin') {
                continue;
            }
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => self::GUARD, $teamKey => null],
                ['name' => $roleName, 'guard_name' => self::GUARD, $teamKey => null]
            );
            if ($permissionList !== null && is_array($permissionList)) {
                $role->syncPermissions($permissionList);
            }
        }
    }

    private function seedPlatformAccount(): void {
        $platform = Account::firstOrCreate(
            ['name' => config('platform.account_name', 'Platform')],
            ['slug' => 'platform', 'is_verified' => true, 'status' => Account::STATUS_ACTIVE]
        );


        $this->createPlatformUser(
            env('ADMIN_EMAIL', 'admin@example.com'),
            env('ADMIN_FIRSTNAME', 'Super'),
            env('ADMIN_LASTNAME', 'Admin'),
            env('ADMIN_PASSWORD', 'password'),
            $platform,
            ['super_admin'],
            true
        );

        if ($devEmail = env('DEV_EMAIL')) {
            $this->createPlatformUser(
                $devEmail,
                env('DEV_FIRSTNAME', 'Dev'),
                env('DEV_LASTNAME', 'User'),
                env('DEV_PASSWORD', 'password'),
                $platform,
                ['developer'],
                false
            );
        }

        $moduleIds = Module::pluck('id')->all();
        $ownerRoleNames = Module::getOwnerRoleNamesForModuleIds($moduleIds);
        if (!empty($ownerRoleNames)) {
            app(PermissionRegistrar::class)->setPermissionsTeamId($platform->id);
            $platformUser = User::where('email', env('ADMIN_EMAIL', 'admin@example.com'))->first();
            if ($platformUser) {
                $platformUser->assignRole($ownerRoleNames);
            }
        }

        Cache::forget('platform_account_id');
    }

    private function createPlatformUser(
        string $email,
        string $firstname,
        string $lastname,
        string $password,
        Account $platform,
        array $roles,
        bool $isOwner
    ): void {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'firstname'         => $firstname,
                'lastname'          => $lastname,
                'password'          => bcrypt($password),
                'email_verified_at' => now(),
                'status'           => User::STATUS_ACTIVE,
            ]
        );

        $user->accounts()->syncWithoutDetaching([$platform->id => ['is_owner' => $isOwner]]);
        if (empty($user->default_account_id)) {
            $user->default_account_id = $platform->id;
            $user->save();
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId($platform->id);
        foreach ($roles as $role) {
            $user->assignRole($role);
        }
    }

    private function demoEnabled(): bool
    {
        return filter_var(env('SEED_DEMO_ACCOUNT', false), FILTER_VALIDATE_BOOLEAN);
    }

    private function seedDemoAccount(): void
    {
        $account = Account::firstOrCreate(
            ['name' => env('DEMO_ACCOUNT_NAME', 'Demo Partner')],
            ['is_verified' => true, 'status' => Account::STATUS_ACTIVE]
        );

        $moduleIds = Module::pluck('id')->all();
        if (!empty($moduleIds)) {
            $account->modules()->syncWithoutDetaching(
                collect($moduleIds)->mapWithKeys(
                    fn ($id) => [$id => ['is_enabled' => true, 'activated_at' => now()]]
                )->all()
            );
        }

        $owner = User::firstOrCreate(
            ['email' => env('DEMO_OWNER_EMAIL', 'owner@demo.com')],
            [
                'firstname'         => env('DEMO_OWNER_FIRSTNAME', 'Demo'),
                'lastname'          => env('DEMO_OWNER_LASTNAME', 'Owner'),
                'password'          => bcrypt(env('DEMO_OWNER_PASSWORD', 'password')),
                'email_verified_at' => now(),
                'status'           => User::STATUS_ACTIVE,
            ]
        );

        $owner->accounts()->syncWithoutDetaching([$account->id => ['is_owner' => true]]);
        if (empty($owner->default_account_id)) {
            $owner->default_account_id = $account->id;
            $owner->save();
        }

        $ownerRoleNames = Module::getOwnerRoleNamesForModuleIds($moduleIds);
        if (!empty($ownerRoleNames)) {
            app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
            app(PermissionRegistrar::class)->forgetCachedPermissions();
            $owner->assignRole($ownerRoleNames);
        }

        $this->assignExistingDataToAccount($account);
    }

    private function assignExistingDataToAccount(Account $account): void {
        $tables = config('modules.demo_assign_tables', ['hotels', 'products']);
        foreach ($tables as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'account_id')) {
                continue;
            }
            $ids = DB::table($table)->whereNull('account_id')->inRandomOrder()->limit(10)->pluck('id');
            if ($ids->isNotEmpty()) {
                DB::table($table)->whereIn('id', $ids)->update(['account_id' => $account->id]);
            }
        }
    }
}
