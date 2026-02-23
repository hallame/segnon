<?php

namespace App\Providers;

use App\Models\Museum;
use App\Models\Social;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\CartService;
use App\Models\CartItem;
use App\Support\CurrentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

use App\Models\User as AppUser;

class ViewServiceProvider extends ServiceProvider{
    /**
     * Register services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {

        View::composer('*', function ($view) {

             // Réseaux sociaux
            if (Schema::hasTable('socials')) {
                $footerSocials = Social::where('status', 1)
                    ->select('name', 'url', 'icon', 'image')
                    ->get();

                // Partager les données
                $view->with([
                    'footerSocials' => $footerSocials,
                    'facebook' => $footerSocials->firstWhere('name', 'facebook'),
                    'twitter' => $footerSocials->firstWhere('name', 'twitter'),
                    'tiktok' => $footerSocials->firstWhere('name', 'tiktok'),
                    'instagram' => $footerSocials->firstWhere('name', 'instagram'),
                    'youtube' => $footerSocials->firstWhere('name', 'youtube'),
                    'linkedin' => $footerSocials->firstWhere('name', 'linkedin'),
                    'text' => $footerSocials->firstWhere('name', 'text'),
                ]);
            } else {
                // Si la table n’existe pas, on partage une collection vide
                $view->with([
                    'footerSocials' => collect(),
                    'facebook' => null,
                    'twitter' => null,
                    'tiktok' => null,
                    'instagram' => null,
                    'youtube' => null,
                    'linkedin' => null,
                    'text' => null,
                ]);
            }

             // Contacts
             if (Schema::hasTable('contacts')) {
                $footerContacts = collect([
                    Contact::where('status', 1)->where('name', 'email')->latest()->select('name', 'url', 'value')->first(),
                    Contact::where('status', 1)->where('name', 'phone')->latest()->select('name', 'url', 'value')->first(),
                    Contact::where('status', 1)->where('name', 'address')->latest()->select('name', 'url', 'value')->first(),
                ])->filter(); // enlever les null au cas où certains n'existent pas

                $view->with('footerContacts', $footerContacts);
            } else {
                $view->with('footerContacts', collect());
            }



            // currency
            $defaultCurrency = config('app.currency', 'XOF');

            if (Schema::hasTable('settings')) {
                $currency = cache()->remember('app.currency', 3600, function () use ($defaultCurrency) {
                    return Setting::where('key', 'currency')->value('value') ?? $defaultCurrency;
                });
            } else {
                $currency = $defaultCurrency;
            }
            $view->with('currency', $currency);


            // email support
            if (Schema::hasTable('settings')) {
                $supportEmail = Setting::where('key', 'email')->value('value') ?? 'omizix@gmail.com';
                $view->with('supportEmail', $supportEmail);
            } else {
                $view->with('supportEmail', 'omizix@gmail.com');
            }

            // user
            $user = Auth::user();
            $view->with('user', $user);

            //cart
            $clientId = $user->id ?? null;
            $sessionId = session()->getId();
            $cart = app(CartService::class)->current($clientId, $sessionId);
            $count = $cart?->exists ? CartItem::where('cart_id', $cart->id)->sum('qty') : 0;
            $view->with('cartCount', (int)$count);
        });

    }

}
