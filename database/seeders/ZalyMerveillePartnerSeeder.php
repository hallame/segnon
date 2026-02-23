<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\Account;
use App\Models\Module;

class ZalyMerveillePartnerSeeder extends Seeder {

    public function run(): void {
        $email      = env('PLATFORM_OWNER_EMAIL', 'admin@zalymerveille.org');            // OPTIONNEL : cible précise
        $accName    = env('PLATFORM_ACCOUNT_NAME', 'ZALY MERVEILLE');
        $accEmail   = env('PLATFORM_ACCOUNT_EMAIL', 'info@zalymerveille.org');
        $accPhone   = env('PLATFORM_ACCOUNT_PHONE', 'info@zalymerveille.org');
        $accCountry = env('PLATFORM_ACCOUNT_COUNTRY', 'Guinée');
        $accCity    = env('PLATFORM_ACCOUNT_CITY', 'Nzérékoré');
        $accAddress = env('PLATFORM_ACCOUNT_ADDRESS', 'Nzérékoré, Guinée');

        DB::transaction(function () use ($email, $accName, $accEmail, $accPhone, $accCountry, $accCity, $accAddress) {
            // 1) Trouver le super admin existant
            $user = $email
                ? User::where('email', $email)->first()
                : User::whereHas('roles', fn($q) => $q->where('name', 'super_admin'))->orderBy('id')->first();

            if (! $user) {
                throw new \RuntimeException(
                    'Aucun super admin trouvé. Définissez PLATFORM_OWNER_EMAIL dans .env ou assignez le rôle super_admin à un user.'
                );
            }

            // 2) Créer / trouver le compte "plateforme"
            $account = Account::where('name', $accName)->first();
            if (! $account) {
                $slug = Str::slug($accName) ?: Str::ulid();
                $base = $slug; $i = 2;
                while (Account::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $account = Account::create([
                    'name'        => $accName,
                    'slug'        => $slug,
                    'email'       => $accEmail,
                    'phone'       => $accPhone,
                    'country'     => $accCountry,
                    'city'        => $accCity,
                    'address'     => $accAddress,
                    'is_verified' => true,
                    'status'      => 1,
                ]);
            }

            // 3) Lier user ↔ account (owner) + compte par défaut si vide
            $user->accounts()->syncWithoutDetaching([$account->id => ['is_owner' => true]]);
            if (empty($user->default_account_id)) {
                $user->default_account_id = $account->id;
                $user->save();
            }

            // 4) Activer TOUS les modules existants sur ce compte
            $modules = Module::all();
            if ($modules->isNotEmpty()) {
                $sync = $modules->mapWithKeys(
                    fn($m) => [$m->id => ['is_enabled' => true, 'activated_at' => now()]]
                )->all();
                $account->modules()->syncWithoutDetaching($sync);
            }

            // 5) Assigner les rôles "owner" par module (team-aware)
            app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);

            $ownerRoleNames = Module::with(['roles' => fn($q) => $q->wherePivot('level', 'owner')])
                ->whereKey($modules->pluck('id'))
                ->get()
                ->flatMap(fn($m) => $m->roles->pluck('name'))
                ->unique()
                ->values()
                ->all();

            // Fallback si aucun mapping owner n’est défini
            if (empty($ownerRoleNames)) {
                foreach ($modules as $m) {
                    if ($m->slug === 'hotel')   $ownerRoleNames[] = 'hotel_owner';
                    if ($m->slug === 'artisan') $ownerRoleNames[] = 'artisan_owner';
                    if ($m->slug === 'shop')    $ownerRoleNames[] = 'shop_owner';
                }
                $ownerRoleNames = array_values(array_unique($ownerRoleNames));
            }

            if (!empty($ownerRoleNames)) {
                $user->assignRole($ownerRoleNames);
            }
        });
    }
}
