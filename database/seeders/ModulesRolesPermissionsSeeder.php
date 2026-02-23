<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\{Role, Permission};
use Spatie\Permission\PermissionRegistrar;
use App\Models\Module;

class ModulesRolesPermissionsSeeder extends Seeder {
    public function run(): void {
        // Spatie Permission cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $modules = config('modules.modules', []);
        $crud = fn(string $r) => ["$r.view-any","$r.view","$r.create","$r.update","$r.delete"];

        foreach ($modules as $slug => $def) {

            // 1) Module
            $module = Module::updateOrCreate(
                ['slug' => $slug],
                ['name' => $def['name'], 'is_core' => $def['is_core'] ?? false]
            );

            // 2) Rôles + mapping module_roles(level)
            $roleModels = [];
            foreach ($def['roles'] as $level => $roleName) {
                $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
                $roleModels[$level] = $role;

                DB::table('module_roles')->updateOrInsert(
                    ['module_id' => $module->id, 'role_id' => $role->id],
                    ['level' => $level, 'created_at' => now(), 'updated_at' => now()]
                );
            }

            // 3) Permissions (CRUD + extras + transversales)
            $perms = [];
            foreach ($def['resources'] ?? [] as $resource => $opts) {
                $perms = array_merge($perms, $crud($resource));
                foreach (($opts['extras'] ?? []) as $extra) {
                    $perms[] = "$resource.$extra";
                }
            }
            $perms = array_values(array_unique(array_merge($perms, $def['transversal'] ?? [])));

            foreach ($perms as $p) {
                Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
            }

            // 4) Attribution des permissions par “template” de rôle
            $all       = collect($perms);
            $manager   = $all->reject(fn($p) => str_contains($p, 'force-delete')); // manager = tout sauf force-delete
            $editor    = $all->filter(fn($p) => preg_match('#\.(view-any|view|create|update)$#', $p));
            $finance   = collect(['finance.self.view','finance.self.export']);
            $worker    = collect($perms)->filter(fn($p) =>
                str_starts_with($p, 'assignments.self.')
                || str_starts_with($p, 'schedules.self.')
                || $p === 'reports.create'
            );

            if (isset($roleModels['owner']))   $roleModels['owner']->givePermissionTo($all->all());
            if (isset($roleModels['manager'])) $roleModels['manager']->givePermissionTo($manager->all());
            if (isset($roleModels['editor']))  $roleModels['editor']->givePermissionTo($editor->all());
            if (isset($roleModels['finance'])) $roleModels['finance']->givePermissionTo($finance->all());
            if (isset($roleModels['worker']))  $roleModels['worker']->givePermissionTo($worker->all());
        }

        // Flush cache à la fin
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
