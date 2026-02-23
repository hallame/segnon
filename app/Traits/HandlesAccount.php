<?php

namespace App\Traits;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;

trait HandlesAccount {
    /**
     * Retourne l'account_id valide à utiliser pour un admin.
     *
     * @param int|null $accountId
     * @return int
     */
    public function resolveAccountId(?int $accountId = null, bool $allowPlatform = true): ?int {
        if ($accountId && Account::where('id', $accountId)->where('status', 1)->exists()) {
            return $accountId;
        }

        $admin = Auth::user();

        $userAccounts = $admin->accounts()
            ->where('slug', '!=', 'platform')
            ->where('status', 1)
            ->pluck('accounts.id')
            ->toArray();

        if (!empty($userAccounts)) {
            return $userAccounts[0];
        }

        if ($allowPlatform) {
            $platformAccount = Account::where('slug', 'platform')->first();
            if ($platformAccount) return $platformAccount->id;
        }

        return Account::where('status', 1)->value('id') ?? null;
    }

}
