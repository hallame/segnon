<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;


class AuthenticatedSessionController extends Controller {

    public function login(Request $request){
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'Identifiants invalides.']);
        }

        $request->session()->regenerate();
        $user = $request->user();
        $user->update(['last_login_at' => now()]);
        $user->save();

        return $this->redirectAfterLogin($request, $user);
    }

    public  function redirectAfterLogin(Request $request, User $user) {
        // Admins → admin.dashboard
        $isAdmin = DB::table('model_has_roles')
            ->join('roles','roles.id','=','model_has_roles.role_id')
            ->where('model_has_roles.model_type', User::class)
            ->where('model_has_roles.model_id', $user->id)
            ->whereIn('roles.name', ['super_admin','moderator','finance_admin','support','developer'])
            ->exists();

        if ($isAdmin) {
            $perm = app(PermissionRegistrar::class);
            $perm->setPermissionsTeamId(1);
            $perm->forgetCachedPermissions();
            session(['mode' => 'admin']);


            return redirect()->intended(route('admin.dashboard'));
        }

        // Partenaire : récupérer un compte
        $count   = $user->accounts()->count();
        $account = $user->default_account_id ? Account::find($user->default_account_id) : null;
        if (!$account && $count === 1) $account = $user->accounts()->first();
        if (!$account && $count > 1) {
            return redirect()->route('partners.accounts.choose');
        }

        if ($account) {
            session([
                'current_account_id' => $account->id,
                'mode'               => 'partner',
            ]);
            app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            $enabled = $account->modules()
                ->wherePivot('is_enabled', true)
                ->pluck('modules.slug') // 👈 important
                ->all();

            $requested = (string) $request->string('module')->lower();
            if ($requested && ! in_array($requested, $enabled, true)) {
                $requested = null; // slug inconnu → ignore
            }
            $last = session('last_partner_module');

            $pick = null;
            if ($requested && in_array($requested, $enabled, true)) {
                $pick = $requested;
            } elseif ($last && in_array($last, $enabled, true)) {
                $pick = $last;
            } elseif (count($enabled) === 1) {
                $pick = $enabled[0];
            } else {
                foreach (['hotel','shop','guide','restaurant','event'] as $slug) {
                    if (in_array($slug, $enabled, true)) { $pick = $slug; break; }
                }
            }

            $dashRoutes = [
                'hotel'      => 'partners.hotel.dashboard',
                'shop'       => 'partners.shop.dashboard',
                'guide'      => 'partners.guide.dashboard',
                'restaurant' => 'partners.restaurant.dashboard',
                'event'      => 'partners.event.dashboard',
            ];

            if ($pick && isset($dashRoutes[$pick]) && \Illuminate\Support\Facades\Route::has($dashRoutes[$pick])) {
                session(['last_partner_module' => $pick]);
                return redirect()->intended(route($dashRoutes[$pick], ['account' => $account->slug]));
            }

            return redirect()->intended(route('partners.dashboard', ['account' => $account->slug]));
        }

        // Pas de compte partenaire → espace client
        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        session(['mode' => 'client']);

        return redirect()->intended(route('client.dashboard'));
    }


    public function logout(Request $request) {
        $user = $request->user();

        $isAdmin = false;
        if ($user) {
            $isAdmin = DB::table('model_has_roles')
                ->join('roles','roles.id','=','model_has_roles.role_id')
                ->where('model_has_roles.model_type', \App\Models\User::class)
                ->where('model_has_roles.model_id', $user->id)
                ->whereIn('roles.name', ['super_admin','moderator','finance_admin','support','developer'])
                ->exists();
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Reset team scope proprement
        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route($isAdmin ? 'admin.login' : 'login')
            ->with('success', 'Déconnecté.');
    }

    public function verify(Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    }


    public function passwordResetLink(Request $request) {
        $request->validate(['email' => ['required','email']]);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


    public function storeNewPassword(Request $request) {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required','email'],
            'password' => ['required','confirmed','min:6'],
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


    public function resume(Request $request) {
        $user = $request->user()?->fresh();
        if (! $user) {
            return redirect()->route('login');
        }

        // Si le statut a changé → on repart sur le flux normal
        if (! $user->isActive()) {
            $msg = match ($user->status) {
                User::STATUS_BLOCKED => 'Votre compte est toujours bloqué.',
                User::STATUS_PENDING => 'Votre compte est toujours en attente de validation.',
                default => 'Votre compte n’est pas actif.',
            };
            return back()->with('status', $msg);
        }

        // === Même logique que dans login() une fois actif ===

        // Admin ?
        $isAdmin = DB::table('model_has_roles')
            ->join('roles','roles.id','=','model_has_roles.role_id')
            ->where('model_has_roles.model_type', User::class)
            ->where('model_has_roles.model_id', $user->id)
            ->whereIn('roles.name', ['super_admin','moderator','finance_admin','support','developer'])
            ->exists();

        if ($isAdmin) {

            $perm = app(PermissionRegistrar::class);
            $perm->setPermissionsTeamId(1); //  plateform
            $perm->forgetCachedPermissions();
            session(['mode' => 'admin']);
            return redirect()->intended(route('admin.dashboard'));
        }

        // Partenaire ?
        $count   = $user->accounts()->count();
        $account = $user->default_account_id ? Account::find($user->default_account_id) : null;
        if (! $account && $count === 1) $account = $user->accounts()->first();
        if (! $account && $count > 1) {
            return redirect()->route('partners.accounts.choose');
        }

        if ($account) {
            // Contexte team Spatie
            session([
                'current_account_id' => $account->id,
                'mode'               => 'partner',
            ]);
            app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            // Si le compte partenaire n'est pas encore vérifié → page "pending" partenaire
            if (! $account->is_verified) {
                return redirect()->route('partners.account.pending', ['account' => $account->slug])
                    ->with('status', 'Votre compte partenaire est en cours de validation.');
            }

            // Choix du module
            $enabled = $account->modules()
                ->wherePivot('is_enabled', true)
                ->pluck('modules.slug')
                ->all();

            $last = session('last_partner_module');
            $priority = ['hotel','shop','guide','restaurant','event'];
            $pick = $last && in_array($last,$enabled,true) ? $last
                : (count($enabled)===1 ? $enabled[0]
                : collect($priority)->first(fn($s)=>in_array($s,$enabled,true)));

            $dash = [
                'hotel'      => 'partners.hotel.dashboard',
                'shop'       => 'partners.shop.dashboard',
                'guide'      => 'partners.guide.dashboard',
                'restaurant' => 'partners.restaurant.dashboard',
                'event'      => 'partners.event.dashboard',
            ];

            if ($pick && isset($dash[$pick]) && \Route::has($dash[$pick])) {
                session(['last_partner_module'=>$pick]);
                return redirect()->route($dash[$pick], ['account'=>$account->slug]);
            }
            return redirect()->route('partners.dashboard', ['account'=>$account->slug]);
        }

        // Sinon, espace client
        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        session(['mode' => 'client']);
        return redirect()->intended(route('client.dashboard'));
    }
}
