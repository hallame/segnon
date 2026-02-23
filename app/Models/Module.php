<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;

class Module extends Model {

    protected $guarded = [];

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'module_roles')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function accounts(): BelongsToMany {
        return $this->belongsToMany(Account::class, 'account_modules')
            ->withPivot(['is_enabled', 'activated_at', 'deactivated_at', 'settings', 'trial_ends_at', 'billing_plan'])
            ->withTimestamps();
    }

    /**
     * Noms des rôles "owner" pour les modules donnés (pour assignation au propriétaire du compte).
     */
    public static function getOwnerRoleNamesForModuleIds(array $moduleIds): array {
        if (empty($moduleIds)) {
            return [];
        }

        return static::with(['roles' => fn ($q) => $q->wherePivot('level', 'owner')])
            ->whereIn('id', $moduleIds)
            ->get()
            ->flatMap(fn ($m) => $m->roles->pluck('name'))
            ->unique()
            ->values()
            ->all();
    }


}
