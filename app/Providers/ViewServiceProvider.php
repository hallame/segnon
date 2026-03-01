<?php

namespace App\Providers;

use App\Models\Social;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\CartService;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

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

            if (Schema::hasTable('socials')) {
                $footerSocials = Social::where('status', 1)
                    ->select('name', 'url', 'icon', 'image')
                    ->get();
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

            if (Schema::hasTable('settings')) {
                $supportEmail = Setting::where('key', 'email')->value('value') ?? 'omizix@gmail.com';
                $view->with('supportEmail', $supportEmail);
            } else {
                $view->with('supportEmail', 'omizix@gmail.com');
            }

            $user = Auth::user();
            $view->with('user', $user);

            $clientId = $user->id ?? null;
            $sessionId = session()->getId();
            $cart = app(CartService::class)->current($clientId, $sessionId);
            $count = $cart?->exists ? CartItem::where('cart_id', $cart->id)->sum('qty') : 0;
            $view->with('cartCount', (int)$count);
        });

    }

}
