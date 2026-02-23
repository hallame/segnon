<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {
    /**
     * Path to the "home" route for your application.
     * Typically used for redirect after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Bootstrap any route model bindings, pattern filters, and the rate limiter.
     */
    public function boot(): void {
        $this->configureRateLimiting();

        // Chargement des routes
        Route::middleware('api')
             ->prefix('api')
             ->group(base_path('routes/api.php'));

        Route::middleware('web')
             ->group(base_path('routes/web.php'));
    }
    /**
     * Configure rate limiters for the application.
     */
    protected function configureRateLimiting(): void{
        RateLimiter::for('bot', function (Request $request) {
            return Limit::perMinute(100)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    $retryAfter = $headers['Retry-After'] ?? null;
                    return response()->json([
                        'ok'          => false,
                        'error'       => 'too_many_requests',
                        'message'     => '⏳ Trop de requêtes. Veuillez réessayer bientôt.',
                        'retry_after' => $retryAfter ? (int) $retryAfter : null,
                    ], 429, $headers);
            });
        });

    }

}
