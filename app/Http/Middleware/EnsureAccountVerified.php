<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Account;
use Illuminate\Support\Facades\Route;

class EnsureAccountVerified {
    /**
     * Routes autorisées même si le compte n'est pas vérifié.
     * (noms de routes)
     */
    protected array $allowlist = [
        'partners.account.pending',
        'partners.resume',
        'logout',
    ];

    public function handle(Request $request, Closure $next): Response {
        // supposons que 'current.account' a mis l'ID en session
        $accountId = (int) $request->session()->get('current_account_id');
        $account   = $accountId ? Account::find($accountId) : null;

        // Si pas d'account identifié ici, on laisse passer : un autre middleware gérera
        if (! $account) {
            return $next($request);
        }

        // Si vérifié → OK
        if ($account->is_verified) {
            return $next($request);
        }

        // Si non vérifié → autoriser seulement certaines routes (allowlist)
        $routeName = optional($request->route())->getName();
        if ($routeName && in_array($routeName, $this->allowlist, true)) {
            return $next($request);
        }

        // Réponse adaptée pour AJAX/JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Compte partenaire en attente de validation.',
                'redirect' => route(Route::has('partners.account.pending')
                    ? 'partners.account.pending'
                    : 'home')
            ], 403);
        }


        $pendingRoute = Route::has('partners.account.pending')
            ? 'partners.account.pending'
            : 'home';

        return redirect()
            ->route($pendingRoute)
            ->with('status', 'Votre compte partenaire est en cours de validation.');
    }
}
