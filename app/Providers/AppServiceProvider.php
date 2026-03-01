<?php

namespace App\Providers;

use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\Permission\PermissionRegistrar;
use App\Support\CurrentAccount;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->singleton(CurrentAccount::class, fn() => new CurrentAccount());
    }

    
    public function boot(): void {

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $appName = config('app.name', 'Omizix');

            $name = $notifiable->firstname
                ?? $notifiable->name
                ?? '';

            return (new MailMessage)
                ->subject('Confirmez votre email — ' . $appName)
                ->greeting('Bienvenue ' . ($name ? $name : 'sur ' . $appName))
                ->line('Cliquez ci-dessous pour confirmer votre adresse email.')
                ->action('Vérifier mon email', $url)
                ->line("Si vous n'êtes pas à l'origine de cette demande, ignorez simplement ce message.")
                ->salutation('— Équipe ' . $appName);
        });

        View::composer('backend.admin.*', function ($view) {
            $view->with('admin', Auth::user());
        });


        View::composer('backend.admin.*', function ($view) {
            $view->with('admin', Auth::user());
        });


        View::composer('frontend.sections.faqs', function ($view) {
            $categoryId = $view->getData()['faqCategoryId'] ?? null;
            $limit      = $view->getData()['limit'] ?? null;
            $q = Faq::query()->active()->ordered()->select('question','answer');
            if ($categoryId) $q->where('category_id', $categoryId);
            if ($limit)      $q->take((int)$limit);

            $view->with('faqs', $q->get());
        });

        $this->shareCurrency();

        $this->app->resolving(PermissionRegistrar::class, function ($pr) {
            $ctx = app(CurrentAccount::class);
            $pr->setPermissionsTeamId($ctx->id());
        });
    }

    private function shareCurrency(): void {
        // Récupérer la devise une seule fois au démarrage
        $currency = $this->getCurrency();
        
        // La partager avec TOUTES les vues
        View::share('currency', $currency);
    }

    private function getCurrency(): string {
        $defaultCurrency = config('app.currency', 'XOF');
        
        try {
            if (Schema::hasTable('settings')) {
                return cache()->remember('app.currency', 3600, function () use ($defaultCurrency) {
                    return Setting::where('key', 'currency')->value('value') ?? $defaultCurrency;
                });
            }
        } catch (\Exception $e) {
            report($e);
        }
        return $defaultCurrency;
    }

}
