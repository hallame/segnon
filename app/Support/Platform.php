<?php

namespace App\Support;

use App\Models\Account;
use Illuminate\Support\Facades\Cache;

class Platform {
    public static function name(): string {
        return config('platform.account_name', 'Platform');
    }

    public static function id(): ?int {
        return Cache::remember('platform_account_id', 600, function () {
            return Account::where('name', self::name())->value('id');
        });
    }
}
