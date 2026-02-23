<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'auth'                  => \App\Http\Middleware\Authenticate::class,
            'guest'                 => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'current.account'       => \App\Http\Middleware\SetCurrentAccount::class,
            'admin.access'          => \App\Http\Middleware\AdminAccess::class,
            'partner.access'        => \App\Http\Middleware\PartnerAccess::class,
            'set.context'           => \App\Http\Middleware\SetTeamContext::class,
            'module'                => \App\Http\Middleware\EnsureModuleEnabled::class,
            'account.verified'      => \App\Http\Middleware\EnsureAccountVerified::class,
            'user.active'           => \App\Http\Middleware\EnsureUserActive::class,
            'role'                  => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'            => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission'    => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

        ]);
        $middleware->appendToGroup('web', \App\Http\Middleware\SetTeamContext::class);
      
    })

    ->withSingletons([
        \App\Support\CurrentAccount::class => fn () => new \App\Support\CurrentAccount(),
    ])
    
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
