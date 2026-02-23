<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\PermissionRegistrar;

class SetTeamContext {
    public function handle($request, Closure $next) {


         // pose le team_id Spatie sur CHAQUE requête
        $teamId = (int) session('current_account_id', 0) ?: null;
        app(PermissionRegistrar::class)->setPermissionsTeamId($teamId);

        // (Optionnel) si tu veux empêcher d’ouvrir un écran admin quand l’UI est en mode "partner"
        if (str_starts_with($request->route()?->getName() ?? '', 'admin.')
            && session('mode') === 'partner') {
            abort(403);
        }


        return $next($request);
    }
}


