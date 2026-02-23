<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Account;


class EnsureModuleEnabled {
    public function handle($request, Closure $next, ...$slugs) {
        $accountId = (int) session('current_account_id');
        if (!$accountId) abort(403);

        $has = Account::query()
            ->whereKey($accountId)
            ->whereHas('modules', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs)
                  ->where('account_modules.is_enabled', true);
            })
            ->exists();

        if (!$has) abort(403); // ou redirect()->route('partners.account.modules.index')->with('warning','Module requis.');

        return $next($request);
    }
}
