<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;
use App\Support\CurrentAccount;
use App\Support\Platform;

class PartnerAccess {
    public function handle(Request $request, Closure $next) {
        $user = $request->user();
        if (!$user) return redirect()->route('login');

        $account = app(CurrentAccount::class)->get() ?? $user->accounts()->first();
        if (!$account) return redirect()->route('partners.pending')->with('error', 'Aucun espace partenaire associé.');

        if (!$user->accounts()->whereKey($account->id)->exists()) {
            abort(403, 'Accès refusé: non membre de ce compte.');
        }

        if (method_exists($account,'isActive') && !$account->isActive()) {
            return redirect()->route('partners.pending')->with('error','Espace partenaire en attente ou bloqué.');
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
        return $next($request);
    }
}
