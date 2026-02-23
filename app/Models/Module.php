<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Module extends Model {

    protected $guarded = [];

    public function roles() {
        return $this->belongsToMany(Role::class, 'module_roles')
            ->withPivot('level') // owner, manager, editor, finance...
            ->withTimestamps();
    }

    public function accounts() {
        return $this->belongsToMany(Account::class, 'account_modules')
            ->withPivot(['is_enabled','activated_at','deactivated_at','settings','trial_ends_at','billing_plan'])
            ->withTimestamps();
    }


}
