<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\CurrentAccount;
use App\Models\Account;

class SetCurrentAccount {
    public function __construct(private CurrentAccount $ctx) {}

    public function handle(Request $request, Closure $next) {
        $user = $request->user();
        // {account} peut être un modèle (grâce à {account:slug?}) ou un slug/id
        $raw = $request->route('account');
        $account = $raw instanceof Account
            ? $raw
            : (is_null($raw) ? null : Account::where('slug',$raw)->orWhere('id',$raw)->first());


        if (!$account && $user && session('current_account_id')) {
            $account = $user->accounts()->whereKey(session('current_account_id'))->first();
        }

        // Fallback : premier compte du user
        if (!$account && $user) {
            $account = $user->accounts()->first();
        }

        // Si l’account trouvé n’appartient pas au user → ignore
        if ($account && $user && ! $user->accounts()->whereKey($account->id)->exists()) {
            $account = $user->accounts()->first();
        }

        $this->ctx->set($account); // NE PAS fixer le team_id ici
        return $next($request);
    }
}
