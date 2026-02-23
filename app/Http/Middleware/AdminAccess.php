<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Account;
use Spatie\Permission\PermissionRegistrar;
use App\Support\Platform;


class AdminAccess {

    public function handle($request, Closure $next) {
        $platformId = Platform::id();
        app(PermissionRegistrar::class)->setPermissionsTeamId($platformId);
        return $next($request);
    }
}
