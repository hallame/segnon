<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{User, Account, Module, Setting};
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\{Auth, DB, Hash, Route, Schema};
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Support\CurrentAccount;

class PartnerRegisterController extends Controller {

    public function create(Request $request) {
        $modules = Module::orderBy('name')->where('status', 1)->get(['id','slug','name']);
        $guideModuleId = Module::where('slug','guide')->value('id');

        $prefillId = null;
        $raw = $request->query('module');

        if ($raw !== null) {
            $slug = Str::of($raw)->lower()->trim()->toString();
            // 1) Refuser numériques/vides → rediriger SANS le paramètre
            if ($slug === '' || ctype_digit($slug)) {
                return redirect()->to($this->urlWithout($request, ['module']));
            }
            // 2) Slug inconnu → rediriger SANS le paramètre
            if (! $modules->contains('slug', $slug)) {
                return redirect()->to($this->urlWithout($request, ['module']));
            }
            // 3) Slug valide → pré-cocher côté serveur
            $prefillId = optional($modules->firstWhere('slug', $slug))->id;
        }


         // 🔹 Récupération du plan depuis l’URL (?plan=standard)
        $rawPlan = $request->query('plan');
        $plan = Account::PLAN_STANDARD; // valeur par défaut

        if ($rawPlan !== null) {
            $p = Str::of($rawPlan)->lower()->trim()->toString();
            if (in_array($p, [Account::PLAN_STANDARD, Account::PLAN_PREMIUM], true)) {
                $plan = $p;
            }
        }

        return view('auth.partners.register', compact('modules','prefillId','plan'));
    }

    /** Construit l’URL courante sans certaines clés de query. */
    private function urlWithout(Request $request, array $keys): string {
        $q = $request->query();
        foreach ($keys as $k) unset($q[$k]);
        return $request->url() . ($q ? ('?' . http_build_query($q)) : '');
    }

    public function store(Request $request) {

        // ===== HONEYPOT =====
        // Vérification honeypot
        if (!empty($request->website)) {
            \Log::info('Faux Compte: Spam détecté via honeypot', ['ip' => $request->ip()]);
            return back()->with('status', 'Votre message a été envoyé !'); // Même message pour ne pas alerter le bot
        }


        // ===== TEMPS MINIMUM =====
        $timeStart = $request->time_start;
        $timeElapsed = microtime(true) - $timeStart;

        // Temps minimum de 1.5 secondes, maximum de 30 minutes
        if ($timeElapsed < 1.5) {
            \Log::warning('Faux Compte: SPAM - Formulaire rempli trop vite', [
                'ip' => $request->ip(),
                'temps' => round($timeElapsed, 2) . 's'
            ]);
            return back()->withErrors(['error' => 'Veuillez prendre le temps de remplir le formulaire correctement.']);
        }

        if ($timeElapsed > 1800) { // 30 minutes
            return back()->withErrors(['error' => 'Session expirée. Veuillez recharger la page.']);
        }

        $validated = $request->validate([
            // User
            'firstname'       => ['required','string','max:255'],
            'lastname'        => ['required','string','max:255'],
            'email'           => ['required','email','max:255','unique:users,email'],
            'password'        => ['required','confirmed','min:6'],
            'phone'           => ['nullable','string','max:50'],
            'whatsapp'        => ['nullable','string','max:50'],

            // Account
            'account_name'    => ['required','string','max:255'],
            'account_phone'   => ['nullable','string','max:50'],
            'account_whatsapp'   => ['nullable','string','max:50'],
            'country'         => ['nullable','string','max:100'],
            'city'            => ['nullable','string','max:100'],
            'account_email'   => ['nullable','email','max:255'],
            'account_address' => ['nullable','string','max:255'],

            // Modules (≥1)
            'modules'         => ['required','array','min:1'],
            'modules.*'       => ['integer','distinct', Rule::exists('modules','id')],

            'subscription_plan' => ['nullable','string', Rule::in([
                Account::PLAN_STANDARD,
                Account::PLAN_PREMIUM,
            ])],
        ]);
        $validated['subscription_plan'] = $validated['subscription_plan'] ?: Account::PLAN_STANDARD;

        // Nombre de jours d’essai depuis settings, fallback 30
        $trialDays = (int) (Setting::where('key', 'shop_trial_days')->value('value') ?? 30);
        if ($trialDays <= 0) {
            $trialDays = 30;
        }

        [$user, $account, $pickedSlug] = DB::transaction(function () use ($validated, $trialDays) {
            // 0) Slug unique pour l'account
            $base = Str::slug($validated['account_name']) ?: 'compte';
            $slug = $base;
            $i = 2;
            while (Account::where('slug',$slug)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            // 1) User
            $user = User::create([
                'firstname' => $validated['firstname'],
                'lastname'  => $validated['lastname'],
                'email'     => $validated['email'],
                'phone'     => $validated['phone'] ?? null,
                'whatsapp'  => $validated['whatsapp'] ?? null,
                'password'  => Hash::make($validated['password']),
                'status'    => 1,
            ]);

            // 2) Account (avec slug obligatoire)
            $account = Account::create([
                'name'        => $validated['account_name'],
                'slug'        => $slug,
                'phone'       => $validated['account_phone'] ?? null,
                'whatsapp'    => $validated['account_whatsapp'] ?? null,
                'country'     => $validated['country'] ?? null,
                'city'        => $validated['city'] ?? null,
                'address'     => $validated['account_address'] ?? null,
                'email'       => $validated['account_email'] ?? null,
                'is_verified' => false,

                 // champs abonnement
                'subscription_plan'    => $validated['subscription_plan'],
                'on_trial'               => true,                   //  essai activé
                'subscription_ends_at'   => now()->addDays($trialDays),     //  fin d’essai
            ]);


            // 3) Membre owner + compte par défaut
            $user->accounts()->syncWithoutDetaching([$account->id => ['is_owner' => true]]);
            if (Schema::hasColumn('users','default_account_id')) {
                $user->default_account_id = $account->id;
                $user->save();
            }

            // 4) Activer modules sélectionnés
            $sync = collect($validated['modules'])->mapWithKeys(
                fn($id) => [$id => ['is_enabled' => true, 'activated_at' => now()]]
            )->all();
            $account->modules()->sync($sync);

            // 5) Rôles "owner" depuis module_roles (STRICT, pas de fallback en dur)
            $ownerRoleNames = Module::with(['roles' => fn($q) => $q->wherePivot('level','owner')])
                ->whereIn('id', $validated['modules'])
                ->get()
                ->flatMap(fn($m) => $m->roles->pluck('name'))
                ->unique()
                ->values()
                ->all();

            if (!empty($ownerRoleNames)) {
                app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
                app(PermissionRegistrar::class)->forgetCachedPermissions(); // reset cache before assign
                $user->assignRole($ownerRoleNames);
            }

            // 6) Slug module à privilégier pour la redirection
            $pickedSlug = Module::whereIn('id', $validated['modules'])
                ->orderBy('slug')
                ->value('slug'); // ex: 'guide'

            return [$user, $account, $pickedSlug];
        });

        // 7) Login + contexte
        Auth::login($user);
        $request->session()->regenerate(); // éviter fixation de session
        session([
            'current_account_id'  => $account->id,
            'mode'                => 'partner',         //  utile pour les middlewares
            'last_partner_module' => $pickedSlug,       //  pour la logique de choix
        ]);
        app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 8) Vérification email si nécessaire
        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice')->with('status','verification-link-sent');
        }

        // 9) Redirection (au choix)
        // Option A : pending générique
        // return redirect()->route('partners.pending')
        //     ->with('status','Votre compte partenaire est en cours de validation.');

        // Option B : si un dashboard module existe, on y va, sinon pending
        $dash = 'partners.'.$pickedSlug.'.dashboard';
        if (Route::has($dash)) {
            return redirect()->route($dash, ['account' => $account->slug])
                ->with('status','Bienvenue ! Votre espace a été créé. Validation en cours.');
        }

        return redirect()->route('partners.pending')
            ->with('status','Votre compte partenaire est en cours de validation.');
    }


    public function pending(CurrentAccount $ctx) {
        $account = $ctx->account; // ou $ctx->get()
        if (! $account) {
            return redirect()
                ->route('partners.accounts.choose')
                ->with('status', 'Sélectionnez un compte à utiliser.');
        }

        $isVerified = (bool) $account->is_verified;
        $hasModules = $account->modules()
            ->wherePivot('is_enabled', true)
            ->exists();

        return view('auth.partners.pending', compact('account','isVerified','hasModules'));
    }


    public function resume(Request $request) {
        $account = Account::with('modules')->find((int) session('current_account_id'));
        if (! $account) return redirect()->route('login');

        if (! $account->is_verified) {
            return redirect()->route('partners.account.pending')
                ->with('status','Toujours en validation…');
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

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
            'hotel'=>'partners.hotel.dashboard',
            'shop'=>'partners.shop.dashboard',
            'guide'=>'partners.guide.dashboard',
            'restaurant'=>'partners.restaurant.dashboard',
            'event'=>'partners.event.dashboard',
        ];

        if ($pick && isset($dash[$pick]) && \Route::has($dash[$pick])) {
            session(['last_partner_module'=>$pick]);
            return redirect()->route($dash[$pick], ['account'=>$account->slug]);
        }
        return redirect()->route('partners.dashboard', ['account'=>$account->slug]);
    }



}
