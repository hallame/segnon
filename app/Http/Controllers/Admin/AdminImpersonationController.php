<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;

class AdminImpersonationController extends Controller {

    public function start(Request $request, User $user) {


        $admin = $request->user();

        $perm = app(PermissionRegistrar::class);
        $perm->setPermissionsTeamId(1); // plateforme
        $perm->forgetCachedPermissions();

        // Sécurité : s'assurer que $admin est bien un admin
        if (! $admin->hasAnyRole(['super_admin','moderator','finance_admin','support','developer'])) {
            abort(403);
        }

        // Ne pas s’impersonate soi-même
        if ($admin->id === $user->id) {
            return back()->with('warning', 'Vous êtes déjà connecté avec ce compte.');
        }

        $request->session()->regenerate();
        $request->session()->put('impersonator_id', $admin->id);
        Auth::guard('web')->login($user);

        // IMPORTANT : réutiliser la logique de post-login
        // → idéalement on extrait la fin de ta méthode login()
        //    dans une méthode protégée réutilisable.
        return app(AuthenticatedSessionController::class)->redirectAfterLogin($request, $user);
    }


    public function stop(Request $request) {

        if (! $request->session()->has('impersonator_id')) {
            return redirect()
                ->route('login')
                ->with('warning', 'Aucune session d\'impersonation active.');
        }

        $impersonatorId = $request->session()->get('impersonator_id');
        $request->session()->forget('impersonator_id');

        $admin = User::find($impersonatorId);

        if (! $admin) {
            Auth::guard('web')->logout();
            return redirect()
                ->route('login')
                ->with('error', 'Impossible de retrouver le compte administrateur d\'origine.');
        }



        $perm = app(PermissionRegistrar::class);
        $perm->setPermissionsTeamId(1);
        $perm->forgetCachedPermissions();

        if (! $admin->hasAnyRole(['super_admin','developer','support','moderator','finance_admin'])) {
            Auth::guard('web')->logout();

            return redirect()
                ->route('login')
                ->with('error', 'Le compte d\'origine n\'a plus les droits administrateur.');
        }


        Auth::guard('web')->login($admin);


        $perm->setPermissionsTeamId(1);
        $perm->forgetCachedPermissions();
        session(['mode' => 'admin']);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Vous êtes revenu sur votre compte administrateur.');
    }


}

