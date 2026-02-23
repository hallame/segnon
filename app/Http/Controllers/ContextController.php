<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Route, Storage};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use App\Support\CurrentAccount;


class ContextController extends Controller {
    
    public function switch(Request $request) {
        $data = $request->validate([
            'account_id' => ['required','integer','exists:accounts,id'],
        ]);

        $user    = Auth::user()->fresh();
        $account = $user->accounts()->whereKey($data['account_id'])
                    ->withPivot('is_owner')->firstOrFail();

        $perm = app(PermissionRegistrar::class);
        $perm->setPermissionsTeamId($account->id);
        $perm->forgetCachedPermissions();

        // IMPORTANT : regénérer la session
        $request->session()->regenerate();

        $isPlatform = ($account->slug === config('app.platform_account_slug','platform'))
                    || (bool)($account->is_platform ?? false);

        session([
            'current_account_id' => $account->id,
            'mode'               => $isPlatform ? 'admin' : 'partner',
        ]);

        // Recharger l’utilisateur (pour teams)
        Auth::setUser($user->fresh());

        // FORCER la destination adaptée
        return redirect()->to(
            $isPlatform
                ? route('admin.dashboard')
                : route('partners.dashboard', ['account' => $account])
        );
    }

}
