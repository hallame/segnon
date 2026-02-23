<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Account, Module, Order, Product, Setting};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{DB, Hash, Schema};
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AdminUserController extends Controller {

    public function index(Request $r) {
        $scope = $r->input('scope','customers'); // "customers" | "partners" | "all"
        // Liste
        $users = User::query()
            ->when($scope === 'partners', fn($q) => $q->whereHas('accounts'))
            ->when($scope === 'customers',  fn($q) => $q->whereDoesntHave('accounts'))
            ->when($q = trim((string)$r->input('q','')), function($qq) use ($q){
                $qq->where(function($w) use ($q){
                    $w->where('email','like',"%$q%")
                      ->orWhere('firstname','like',"%$q%")
                      ->orWhere('lastname','like',"%$q%");
                });
            })
            ->orderByDesc('id')
            ->paginate(20)->withQueryString();

        $stats = [
            'total_users'    => User::count(),
            'customers'        => User::whereDoesntHave('accounts')->count(),
            'partners'       => User::whereHas('accounts')->count(),
            'active_users'   => User::where('status',1)->count(),
            'inactive_users' => User::where('status','!=',1)->count(),
        ];

        // Stats spécifiques partenaires (optionnel)
        if ($scope === 'partners') {
            $stats['accounts_total']    = Account::count();
            $stats['accounts_verified'] = Account::where('is_verified', true)->count();
            $stats['accounts_pending']  = Account::where('is_verified', false)->count();
        }

        return view('backend.admin.users.index', compact('users','stats','scope'));
    }

    public function customers(Request $r) {
        $customers = User::query()
            ->whereDoesntHave('accounts')
            ->when($q = trim((string)$r->input('q','')), function($qq) use ($q){
                $qq->where(function($w) use ($q){
                    $w->where('email','like',"%$q%")
                      ->orWhere('firstname','like',"%$q%")
                      ->orWhere('lastname','like',"%$q%");
                });
            })
            ->withCount('orders as orders_count')
            ->orderByDesc('id')
            ->paginate(20)->withQueryString();

        // Stats rapides
        $stats = [
            'total_users'    => User::count(),
            'customers'      => User::whereDoesntHave('accounts')->count(),
            'active_users'   => User::where('status',1)->count(),
            'partners'       => User::whereHas('accounts')->count(),
            'inactive_users' => User::where('status','!=',1)->count(),
        ];
        $modules = Module::orderBy('name')->where('status', 1)->get(['id','slug','name']);
        return view('backend.admin.users.customers', compact('customers','stats', 'modules'));
    }

    public function storeUser(Request $r) {
        $data = $r->validate([
            'firstname' => ['required','string','max:255'],
            'lastname'  => ['required','string','max:255'],
            'email'     => ['required','email','max:255','unique:users,email'],
            'password'  => ['required','confirmed','min:6'],
            'phone'     => ['nullable','string','max:50'],
            'address'   => ['nullable','string','max:255'],
            'status'    => ['nullable','in:0,1,2'],
        ]);

        User::create([
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'phone'     => $data['phone'] ?? null,
            'address'   => $data['address'] ?? null,
            'status'    => (int)($data['status'] ?? 1),
            'email_verified_at' => now(),
        ]);

        return back()->with('success','Utilisateur créé.');
    }

    public function partners(Request $r) {
        $q        = trim((string) $r->input('q',''));
        $status   = $r->input('status');          // '', 0,1,2
        $verified = $r->input('verified');        // '', 0,1
        $moduleId = (int) $r->input('module_id') ?: null;
        $country  = trim((string) $r->input('country',''));
        $sort     = $r->input('sort','recent');   // recent|name|accounts

        $partners = User::query()
            ->partner()
            ->notStaff()
            ->whereHas('accounts', function ($qa) use ($verified, $moduleId, $country) {
                if ($verified !== null && $verified !== '') $qa->where('is_verified', (bool)$verified);
                if ($country) $qa->where('country','like',"%{$country}%");
                if ($moduleId) $qa->whereHas('modules', fn($qm) => $qm->whereKey($moduleId));
            })
            ->when($q, function ($u) use ($q) {
                $u->where(function ($w) use ($q) {
                    $w->where('email','like',"%{$q}%")
                    ->orWhere('firstname','like',"%{$q}%")
                    ->orWhere('lastname','like',"%{$q}%")
                    ->orWhere('phone','like',"%{$q}%")
                    ->orWhereHas('accounts', fn($a) => $a->where(function($aa) use ($q){
                        $aa->where('name','like',"%{$q}%")
                            ->orWhere('email','like',"%{$q}%");
                    }));
                });
            })
            ->when($status !== null && $status !== '', fn($u) => $u->where('status', (int)$status))
            ->withCount('accounts as accounts_count')
            ->with([
                'accounts' => fn($acc) => $acc
                    ->select('accounts.id','accounts.name','accounts.slug','accounts.is_verified','accounts.country','accounts.city','accounts.phone','accounts.email','accounts.created_at')
                    ->withCount([
                        'modules as modules_count',
                        'products as products_count',
                        // nécessite une relation orders() sur Account filtrée par items
                        'orders as orders_count',
                        'items as items_count',
                    ])
                    ->withSum([
                        'items as revenue_sum' => fn($q) =>
                            $q->whereHas('order', fn($o) =>
                                $o->whereIn('status', [Order::STATUS_PAID, Order::STATUS_FULFILLED])
                            )
                    ], 'total_price')
                    ->orderBy('name')
            ]);

        // tri
        $partners = match ($sort) {
            'name'     => $partners->orderBy('lastname')->orderBy('firstname'),
            'accounts' => $partners->orderByDesc('accounts_count')->orderByDesc('id'),
            default    => $partners->orderByDesc('id'),
        };

        $partners = $partners->paginate(20)->withQueryString();

        // Agrégats par partenaire (totaux sur tous ses accounts) prêts pour la vue
        $partners->getCollection()->transform(function ($u) {
            $u->agg = [
                'orders'  => (int) $u->accounts->sum('orders_count'),
                'items'   => (int) $u->accounts->sum('items_count'),
                'revenue' => (float) $u->accounts->sum('revenue_sum'),
            ];
            return $u;
        });

        // Liste des users “assignables” (pour le <select> “lier un utilisateur existant”)
        // - exclus staff
        // - par défaut : seulement ceux SANS account (des clients simples)
        $assignableUsers = User::query()
            ->select('id','firstname','lastname','email')
            // ->notStaff()
            ->whereDoesntHave('accounts')
            ->orderBy('email')
            ->limit(200)
            ->get();

        $stats = [
            'total_users'         => User::count(),
            'customers'           => User::whereDoesntHave('accounts')->count(),
            'partners'            => User::partner()->count(),
            'active_users'        => User::where('status',1)->count(),
            'inactive_users'      => User::where('status','!=',1)->count(),
            'accounts_total'      => Account::count(),
            'accounts_verified'   => Account::where('is_verified', true)->count(),
            'accounts_unverified' => Account::where('is_verified', false)->count(),
        ];

        $modules   = Module::orderBy('name')->get(['id','name','slug']);
        $countries = Account::query()->whereNotNull('country')->distinct()->orderBy('country')->pluck('country');

        return view('backend.admin.users.partners', [
            'partners'       => $partners,
            'assignableUsers'=> $assignableUsers,
            'stats'          => $stats,
            'modules'        => $modules,
            'countries'      => $countries,
            'filters'        => compact('q','status','verified','moduleId','country','sort'),
        ]);
    }


    /** Créer (ou lier) un partenaire : user + account + modules + rôles */

    public function storePartner(Request $r) {
        $isLink = $r->filled('user_id'); // true = lier un user existant

        // Règles communes (compte + modules)
        $rules = [
            'account_name'   => ['required','string','max:255'],
            'account_email'  => ['nullable','email','max:255'],
            'account_phone'  => ['nullable','string','max:50'],
            'country'        => ['nullable','string','max:100'],
            'city'           => ['nullable','string','max:100'],
            'address'        => ['nullable','string','max:255'],
            'is_verified'    => ['sometimes','boolean'],
            'modules'        => ['required','array','min:1'],
            'modules.*'      => ['integer', Rule::exists('modules','id')],
        ];

        if ($isLink) {
            // Cas : lier un utilisateur existant
            $rules['user_id'] = ['required','integer', Rule::exists('users','id')];
        } else {
            // Cas : créer un nouvel utilisateur
            $rules += [
                'firstname'      => ['required','string','max:255'],
                'lastname'       => ['nullable','string','max:255'],
                'email'          => ['required','email','max:255','unique:users,email'],
                'password'       => ['required','confirmed','min:6'],
                'user_phone'     => ['nullable','string','max:50'],
                'status'         => ['nullable','in:0,1,2'],
            ];
        }

        $data = $r->validate($rules);

        [$user, $account] = DB::transaction(function () use ($data, $isLink) {
            // 1) User
            if ($isLink) {
                $user = User::findOrFail($data['user_id']);
            } else {
                $user = User::create([
                    'firstname' => $data['firstname'],
                    'lastname'  => $data['lastname'] ?? null,
                    'email'     => $data['email'],
                    'password'  => Hash::make($data['password']),
                    'phone'     => $data['user_phone'] ?? null,
                    'status'    => (int)($data['status'] ?? 1),
                ]);
            }

            // 2) Account (slug unique)
            $slug = Str::slug($data['account_name']);
            $base = $slug; $i = 2;
            while (Account::where('slug',$slug)->exists()) { $slug = "{$base}-{$i}"; $i++; }

            $account = Account::create([
                'name'        => $data['account_name'],
                'slug'        => $slug,
                'email'       => $data['account_email'] ?? null,
                'phone'       => $data['account_phone'] ?? null,
                'country'     => $data['country'] ?? null,
                'city'        => $data['city'] ?? null,
                'address'     => $data['address'] ?? null,
                'is_verified' => (bool)($data['is_verified'] ?? false),
                'status'      => 1,
            ]);

            // 3) Liaison + compte par défaut si vide
            $user->accounts()->syncWithoutDetaching([$account->id => ['is_owner' => true]]);
            if (empty($user->default_account_id)) {
                $user->default_account_id = $account->id;
                $user->save();
            }

            // 4) Modules
            $sync = collect($data['modules'])->mapWithKeys(
                fn($id) => [$id => ['is_enabled' => true, 'activated_at' => now()]]
            )->all();
            $account->modules()->sync($sync);

            // 5) Rôles owner par module (team-aware)
            app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($account->id);
            $roleNames = $this->ownerRolesFromModules($data['modules']);
            if (!empty($roleNames)) $user->assignRole($roleNames);

            return [$user, $account];
        });

        return back()->with('success', 'Compte partenaire créé.');
    }



    public function toggleStatus(Request $request, User $user) {
        $request->validate(['status' => ['required','in:0,1']]);
        $user->update(['status' => (bool)$request->status]);
        return response()->json(['success'=>true]);
    }


    private function ownerRolesFromModules(array $moduleIds): array {
        $names = Module::with(['roles' => fn($q) => $q->wherePivot('level','owner')])
            ->whereIn('id',$moduleIds)
            ->get()
            ->flatMap(fn($m) => $m->roles->pluck('name'))
            ->unique()->values()->all();

        if (empty($names)) {
            $slugs = Module::whereIn('id',$moduleIds)->pluck('slug')->all();
            if (in_array('hotel',$slugs,true))   $names[]='hotel_owner';
            if (in_array('artisan',$slugs,true)) $names[]='artisan_owner';
        }
        return $names;
    }






    public function upgradeToPartner(Request $request, User $user) {
        // 1) S’il a déjà un compte partenaire, on bloque
        if ($user->accounts()->exists()) {
            return back()->with('error', "Cet utilisateur est déjà associé à au moins un compte partenaire.");
        }

        // 2) Validation des infos account + plan + modules
        $validated = $request->validate([
            // Account
            'account_name'      => ['required','string','max:255'],
            'account_phone'     => ['nullable','string','max:50'],
            'account_whatsapp'  => ['nullable','string','max:50'],
            'country'           => ['nullable','string','max:100'],
            'city'              => ['nullable','string','max:100'],
            'account_email'     => ['nullable','email','max:255'],
            'account_address'   => ['nullable','string','max:255'],

            // Modules (on peut en choisir plusieurs, mais au minimum shop)
            'modules'           => ['required','array','min:1'],
            'modules.*'         => ['integer','distinct', Rule::exists('modules','id')],

            'subscription_plan' => ['nullable','string', Rule::in([
                Account::PLAN_STANDARD,
                Account::PLAN_PREMIUM,
            ])],
        ]);

        $validated['subscription_plan'] = $validated['subscription_plan'] ?: Account::PLAN_STANDARD;

        // 3) Nombre de jours d’essai depuis settings (fallback 30)
        $trialDays = (int) (Setting::where('key', 'shop_trial_days')->value('value') ?? 30);
        if ($trialDays <= 0) {
            $trialDays = 30;
        }

        [$account, $pickedSlug] = DB::transaction(function () use ($validated, $user, $trialDays) {

            // a) Slug unique pour l'account
            $base = Str::slug($validated['account_name']) ?: 'compte';
            $slug = $base;
            $i = 2;
            while (Account::where('slug', $slug)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }

            // b) Création du compte
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

                // Abonnement
                'subscription_plan'   => $validated['subscription_plan'],
                'on_trial'            => true,
                'subscription_ends_at'=> now()->addDays($trialDays),
            ]);

            // c) Lier le user à ce compte comme owner
            $user->accounts()->syncWithoutDetaching([
                $account->id => ['is_owner' => true],
            ]);

            // d) Default account du user si colonne présente
            if (Schema::hasColumn('users', 'default_account_id')) {
                $user->default_account_id = $account->id;
                $user->save();
            }

            // e) Activer les modules choisis
            $sync = collect($validated['modules'])->mapWithKeys(
                fn ($id) => [$id => ['is_enabled' => true, 'activated_at' => now()]]
            )->all();
            $account->modules()->sync($sync);

            // f) Rôles "owner" depuis module_roles
            $ownerRoleNames = Module::with(['roles' => fn($q) => $q->wherePivot('level','owner')])
                ->whereIn('id', $validated['modules'])
                ->get()
                ->flatMap(fn($m) => $m->roles->pluck('name'))
                ->unique()
                ->values()
                ->all();

            if (!empty($ownerRoleNames)) {
                app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);
                app(PermissionRegistrar::class)->forgetCachedPermissions();
                $user->assignRole($ownerRoleNames);
            }

            // g) Slug module prioritaire pour éventuelle redirection
            $pickedSlug = Module::whereIn('id', $validated['modules'])
                ->orderBy('slug')
                ->value('slug'); // ex: 'shop'

            return [$account, $pickedSlug];
        });

        return redirect()->back()->with('success', "L'utilisateur {$user->firstname} {$user->lastname} est désormais partenaire (compte {$account->name}).");
    }
}
