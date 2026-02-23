<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserActive {
    /**
     * Routes accessibles même si l'user n'est pas "active".
     */
    protected array $allowlist = [
        'auth.resume',
        'logout',
        'verification.notice',
        'verification.send',
        'password.request',
        'password.email',
        'password.reset',
        'password.store',
    ];

    public function handle(Request $request, Closure $next): Response {
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        // status: 0=pending, 1=active, 2=blocked (d'après ton schéma)
        $status = (int) $user->status;

        if ($status === 1) {
            return $next($request); // OK
        }

        $routeName = optional($request->route())->getName();

        // Laisser passer certaines routes (evite boucles)
        if ($routeName && in_array($routeName, $this->allowlist, true)) {
            return $next($request);
        }

        // Bloqué -> on coupe la session
        if ($status === 2) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Compte bloqué.'], 403);
            }

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Votre compte a été bloqué. Contactez le support.']);
        }

        // Pending -> on laisse la session mais on restreint l’accès
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Compte en attente de validation.'], 403);
        }

        // Redirige vers une page "user pending" si tu en as une (sinon notice e-mail)
        $pendingRoute = \Illuminate\Support\Facades\Route::has('user.pending')
            ? 'user.pending'
            : 'verification.notice';

        return redirect()->route($pendingRoute)
            ->with('status', 'Votre compte est en attente de validation.');
    }
}
