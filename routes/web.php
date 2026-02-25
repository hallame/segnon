<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminPartnerController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ContextController;
use App\Http\Controllers\ShopCheckoutController;
use App\Http\Controllers\ShopPaymentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MonerooWebhookController;

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminImpersonationController;
use App\Http\Controllers\Admin\AdminSocialController;
use App\Http\Controllers\Admin\AdminOrderController;


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ClientRegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\PartnerRegisterController;

use App\Http\Controllers\Partners\PartnerController;
use App\Http\Controllers\Partners\PartnerSettingController;
use App\Http\Controllers\Partners\PartnerSubmissionController;
use App\Http\Controllers\Partners\PartnerProfileController;
use App\Http\Controllers\Partners\PartnerOrderController;
use App\Http\Controllers\Partners\PartnerProductController;
use App\Http\Controllers\Partners\PartnerSubscriptionController;

Route::post('/payments/moneroo/webhook', [MonerooWebhookController::class, 'handle'])->name('payments.moneroo.webhook');

// ==========================
// AUTH (VISITEURS / guest)
// ==========================

// Bot
Route::middleware(['web', 'throttle:20,1'])->group(function () {
    Route::view('/bot', 'frontend.bot')->name('bot');
});


Route::view('/mbot', 'frontend.bot')->name('mbot');
////// FRONTEND CONTROLLER
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/segnon', [FrontendController::class, 'segnon'])->name('segnon');

Route::get('/pricing', [FrontendController::class, 'pricing'])->name('shop.pricing');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/send', [FrontendController::class, 'sendContact'])->name('contact.send');
Route::post('/newsletter/subscribe', [FrontendController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs.index');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/sales/guide', [FrontendController::class, 'sellerGuide'])->name('sales.guide');

Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('/policy', [FrontendController::class, 'policy'])->name('policy');



////// USERS SHOPPING CONTROLLERs
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class,'index'])->name('products.index');
    Route::get('/products', [ShopController::class,'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ShopController::class,'show'])->name('products.show');
    Route::get('/products/category/{slug}', [ShopController::class,'category'])->name('products.category');
    Route::get('/collections', [ShopController::class,'collections'])->name('collections');


    Route::get('/cart', [ShopController::class,'cartIndex'])->name('cart.index');
    Route::post('/cart/add', [ShopController::class,'cartAdd'])->name('cart.add');
    Route::patch('/cart/items/{item}', [ShopController::class,'cartUpdate'])->name('cart.items.update');
    Route::delete('/cart/items/{item}', [ShopController::class,'cartRemove'])->name('cart.items.remove');

    Route::get('/checkout', [ShopCheckoutController::class,'index'])->name('checkout.index');
    Route::post('/checkout', [ShopCheckoutController::class,'store'])->name('checkout.store');
    Route::get('/vendors/{account:slug}', [ShopController::class, 'showVendor'])->name('vendors.show');

    Route::get('/payment/{order:reference}', [ShopPaymentController::class,'show'])->name('payment.show');
    Route::post('/payment/{order:reference}', [ShopPaymentController::class,'pay'])->name('payment.store');
    Route::get('/orders/success/{reference}', [ShopPaymentController::class,'success'])->name('orders.success');
    Route::get('/orders/{reference}/receipt', [ShopPaymentController::class, 'receipt'])->name('orders.receipt');

    Route::post('/orders/{order:reference}/pay/moneroo', [ShopPaymentController::class, 'payOnline'])->name('orders.pay.moneroo');
    Route::get('/orders/{order:reference}/moneroo/return', [ShopPaymentController::class, 'handleMonerooReturn'])->name('orders.moneroo.return');

});


Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'login'])->middleware('throttle:10,1')->name('login.store');
    Route::get('/spanel/login', fn () => view('backend.admin.auth.login'))->name('admin.login');
});

Route::middleware(['throttle:3,10'])->group(function () {
    Route::get('/partners/register',  [PartnerRegisterController::class, 'create'])->name('partners.register');
    Route::post('/partners/register', [PartnerRegisterController::class, 'store'])->name('partners.register.store');

    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::post('/register', [ClientRegisterController::class, 'store'])->name('register.store');
});

Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');

Route::post('/forgot-password', [AuthenticatedSessionController::class, 'passwordResetLink'])->middleware('throttle:6,1')->name('password.email');

// Réinitialisation (form avec token + enregistrement)
Route::get('/reset-password/{token}', fn ($token) => view('auth.reset-password', ['token' => $token]))->name('password.reset');
Route::post('/reset-password', [AuthenticatedSessionController::class, 'storeNewPassword'])->name('password.store');


// ==========================
// AUTHENTIFIE (auth)
// ==========================
Route::middleware('auth')->group(function () {
    Route::post('/impersonate/stop', [AdminImpersonationController::class, 'stop'])->name('impersonate.stop');

    // Accessible connecté uniquement
    Route::get('/user/pending', fn () => view('auth.status'))->name('user.pending');
    Route::get('/user/resume', [AuthenticatedSessionController::class, 'resume'])->name('auth.resume');

    // Vérification email (notice + renvoi du lien)
    Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');
    Route::post('/email/verification-notification', [AuthenticatedSessionController::class, 'verify'])->middleware('throttle:6,1')->name('verification.send');
    // Lien de vérif reçu par email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->intended('/'); // destination après vérif
    })->middleware(['signed','throttle:6,1'])->name('verification.verify');

    // Déconnexion
    Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
});


// ==========================
// spanel (admin) – sécurisé
// ==========================
Route::middleware(['auth', 'user.active', 'verified','admin.access','permission:platform.view'])
        ->prefix('spanel')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


    Route::get('/users',        [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/customers',  [AdminUserController::class, 'customers'])->name('users.customers');
    Route::get('/users/partners',   [AdminUserController::class, 'partners'])->name('users.partners');
    Route::post('/users/customer',  [AdminUserController::class, 'storeUser'])->name('users.store.user');
    Route::post('/users/partner',[AdminUserController::class, 'storePartner'])->name('users.store.partner');
    Route::post('/users/{user}/upgrade',[AdminUserController::class, 'upgradeToPartner'])->name('users.upgrade');
    Route::post  ('/users/{user}/toggle', [AdminUserController::class,'toggleStatus'])->name('users.toggle');
    Route::post('/impersonate/{user}', [AdminImpersonationController::class, 'start'])->name('impersonate.start');

    Route::get('/countries', [AdminController::class, 'countries'])->name('countries');
    Route::post('/country/add', [AdminController::class, 'addCountry'])->name('country.add');
    Route::put('/country/update/{id}', [AdminController::class, 'updateCountry'])->name('country.update');
    Route::delete('/delete/country/{id}', [AdminController::class, 'deleteCountry'])->name('country.delete');

    Route::get('/locations', [AdminController::class, 'locations'])->name('locations');
    Route::post('/location/add', [AdminController::class, 'addLocation'])->name('location.add');
    Route::post('/location/status/{id}', [AdminController::class, 'updateStatusLocation'])->name('location.status');
    Route::delete('/delete/location/{id}', [AdminController::class, 'deleteLocation'])->name('location.delete');


    ////////// ORDER ADMIN Controller ////////////
    Route::get ('/orders',                [AdminOrderController::class,'index'])->name('orders.index');
    Route::get ('/orders/{order}',        [AdminOrderController::class,'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class,'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}',      [AdminOrderController::class,'destroy'])->name('orders.destroy');

    ////////// Payment Methods Controller ////////////
    Route::get   ('/payment-methods',                [PaymentMethodController::class, 'index'])->name('payment_methods.index');
    Route::post  ('/payment-methods',                [PaymentMethodController::class, 'store'])->name('payment_methods.store');
    Route::put   ('/payment-methods/{payment_method}', [PaymentMethodController::class, 'update'])->name('payment_methods.update');
    Route::delete('/payment-methods/{payment_method}', [PaymentMethodController::class, 'destroy'])->name('payment_methods.destroy');
    Route::post  ('/payment-methods/status/{payment_method}', [PaymentMethodController::class, 'toggleStatus'])->name('payment_methods.toggle');

    //////////Category Controller////////////
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories');
    Route::post('/categories/store', [AdminCategoryController::class, 'store'])->name('category.store');
    Route::post('/categories-status/{id}', [AdminCategoryController::class, 'updateStatus'])->name('categories.config');
    Route::post('/categories/status/{id}', [AdminCategoryController::class, 'updateStatus'])->name('categories.config');
    Route::put('/category/update/{id}', [AdminCategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('category.delete');
    Route::delete('/categories/force-delete/{id}', [AdminCategoryController::class, 'forceDestroy'])->name('category.force-destroy');

    // ////// Partners CONTROLLER /////////
    Route::get('/partners', [AdminPartnerController::class, 'partners'])->name('partners');
    Route::post('/partner/create', [AdminPartnerController::class, 'createPartner'])->name('partner.create');
    Route::put('/update/partner/{id}', [AdminPartnerController::class, 'updatePartner'])->name('partner.update');
    Route::delete('/delete/partner/{id}', [AdminPartnerController::class, 'deletePartner'])->name('partner.delete');

    /////////// Gallery Controller////////////////
    Route::get('/galleries', [GalleryController::class, 'galleries'])->name('galleries');
    Route::get('/gallery/add-form', [GalleryController::class, 'addForm'])->name('gallery.add.form');
    Route::post('/gallery/add', [GalleryController::class, 'add'])->name('gallery.add');
    Route::delete('/delete/gallery/{id}', [GalleryController::class, 'delete'])->name('gallery.delete');
    Route::post('/gallery/status-update/{id}', [GalleryController::class, 'updateStatus']);
    Route::get('/gallery/elements', [GalleryController::class, 'getElements'])->name('gallery.elements');

    Route::get('/myprofile', [AdminController::class, 'myprofile'])->name('myprofile');
    Route::post('/myprofile/update', [AdminController::class, 'updateMyProfile'])->name('myprofile.update');


    ////////// Social Controller////////////
    Route::get('/socials', [AdminSocialController::class, 'socials'])->name('socials');
    Route::post('/social-add', [AdminSocialController::class, 'add'])->name('social.add');
    Route::post('/social/status-update/{id}', [AdminSocialController::class, 'updateStatus']);
    Route::delete('/social-delete/{id}', [AdminSocialController::class, 'delete'])->name('social.delete');

    //////////Contact Controller////////////
    Route::get('/contacts', [ContactController::class, 'contacts'])->name('contacts');
    Route::post('/contact-add', [ContactController::class, 'add'])->name('contact.add');
    Route::post('/contact/status-update/{id}', [ContactController::class, 'updateStatus']);
    Route::delete('/contact-delete/{id}', [ContactController::class, 'delete'])->name('contact.delete');

    // FAQs
    Route::get('faqs',            [AdminFaqController::class, 'index'])->name('faqs.index');
    Route::get('faqs/create',     [AdminFaqController::class, 'create'])->name('faqs.create');
    Route::post('faqs',           [AdminFaqController::class, 'store'])->name('faqs.store');
    Route::get('faqs/{faq}/edit', [AdminFaqController::class, 'edit'])->name('faqs.edit');
    Route::put('faqs/{faq}',      [AdminFaqController::class, 'update'])->name('faqs.update');
    Route::delete('faqs/{faq}',   [AdminFaqController::class, 'destroy'])->name('faqs.destroy');
    Route::patch('faqs/{faq}/toggle', [AdminFaqController::class, 'toggle'])->name('faqs.toggle');
    Route::post('faqs/reorder', [AdminFaqController::class, 'reorder'])->name('faqs.reorder');

    ////////// PRODUCT Methods Controller ////////////
    Route::get   ('/products/all',                  [AdminProductController::class,'index'])->name('products.index');
    Route::get   ('/products/create',           [AdminProductController::class,'create'])->name('products.create');
    Route::post  ('/products/store',                  [AdminProductController::class,'store'])->name('products.store');
    Route::get   ('/products/{product}/edit',   [AdminProductController::class,'edit'])->name('products.edit');
    Route::put   ('/products/{product}',        [AdminProductController::class,'update'])->name('products.update');
    Route::delete('/products/{product}',        [AdminProductController::class,'destroy'])->name('products.destroy');

    Route::post('/products/{product}/status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');
    // Route::post('/products/{product}/media',  [AdminProductController::class, 'storeMedia'])->name('products.media.store');
    Route::delete('/products/{product}/media/{media}', [AdminProductController::class, 'destroyMedia'])->name('products.media.destroy');

    ////////// Submissions admin Controller ////////////
    Route::get('/submissions',                [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}',   [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/approve', [SubmissionController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{submission}/reject',  [SubmissionController::class, 'reject'])->name('submissions.reject');

});


//////// MEDIA CONTROLLER
Route::middleware(['auth','verified',
    // 'current.account',
    ])->prefix('media')->name('media.')->group(function () {
    Route::get('/{type}/{key}', [MediaController::class, 'index'])->name('index');
    Route::post('/{type}/{key}', [MediaController::class, 'store'])->name('store');
    Route::delete('/{media:uuid}', [MediaController::class, 'destroy'])->name('destroy');
});



// ================================
// Partners – sécurisé (zone + rôles)
// ================================

// Switch
Route::middleware(['auth','verified','current.account'])->prefix('partners')->name('partners.')->group(function () {
    Route::post('/switch', [ContextController::class, 'switch'])->name('switch');
    Route::get('account/pending', [PartnerRegisterController::class, 'pending'])->name('account.pending');
    Route::get('/resume', [PartnerRegisterController::class,'resume'])->name('resume');
});

Route::middleware(['auth', 'user.active', 'current.account', 'partner.access',
        // 'account.verified', 'verified',
        ])->prefix('partners')->name('partners.')->group(function () {

    // ===== Tableau de bord & état "en attente" =====
    Route::get('/dashboard/{account:slug?}', [PartnerController::class, 'dashboard'])->name('dashboard');

    // ===================== ESPACE PARTENAIRE =====================
    // settings and profile
    Route::get('/profile',  [PartnerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',  [PartnerProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings', [PartnerSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [PartnerSettingController::class, 'update'])->name('settings.update');

    // Requests
    Route::get('/submissions', [PartnerSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}', [PartnerSubmissionController::class, 'show'])->name('submissions.show');

    Route::post('/hotels/{hotel:slug}/submissions', [PartnerSubmissionController::class, 'hotelRequest'])
        ->name('submissions.hotels.request');

    Route::post('/rooms/{room:slug}/submissions', [PartnerSubmissionController::class, 'roomRequest'])
        ->name('submissions.rooms.request');

    Route::post('/products/{product}/submissions', [PartnerSubmissionController::class, 'productRequest'])
        ->name('submissions.products.request');



    // ===================== BOUTIQUE D'ART =====================
    Route::middleware('module:shop')->prefix('shop')->as('shop.')->group(function () {
         // Dashboard
        Route::get('/dashboard', [PartnerProductController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [PartnerProductController::class, 'dashboard'])->name('dashboard');

        // Products (Partners)
        Route::get   ('/products',                  [PartnerProductController::class,'index'])->name('products.index');
        Route::get   ('/products/create',           [PartnerProductController::class,'create'])->name('products.create');
        Route::post  ('/products',                  [PartnerProductController::class,'store'])->name('products.store');
        Route::get   ('/products/{product}/edit',   [PartnerProductController::class,'edit'])->name('products.edit');
        Route::put   ('/products/{product}',        [PartnerProductController::class,'update'])->name('products.update');
        Route::delete('/products/{product}',        [PartnerProductController::class,'destroy'])->name('products.destroy');
        Route::post  ('/products/{product}/toggle', [PartnerProductController::class,'toggleStatus'])->name('products.toggle');
        Route::delete('/products/{product}/media/{media}', [PartnerProductController::class,'destroyMedia'])->name('products.media.destroy');
        // Orders Partners Controller
        Route::get('/orders', [PartnerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [PartnerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [PartnerOrderController::class, 'updateStatus'])->name('orders.status');

        // Requests
        Route::get('/submissions', [PartnerProductController::class, 'submissions'])->name('submissions.index');
        Route::get('/submissions/{submission}', [PartnerProductController::class, 'submissionShow'])->name('submissions.show');
        Route::post('/products/{product}/submissions', [PartnerSubmissionController::class, 'productRequest'])->name('submissions.products.request');

        // Settings and profile
        Route::get('/profile',  [PartnerProductController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile',  [PartnerProductController::class, 'updateProfile'])->name('profile.update');
        Route::get('/settings', [PartnerProductController::class, 'editSettings'])->name('settings.edit');
        Route::put('/settings', [PartnerProductController::class, 'updateSettings'])->name('settings.update');


        // subscription
        Route::get('/subscription',  [PartnerSubscriptionController::class, 'index'])->name('subscription.index');
        Route::get('/subscription/start',  [PartnerSubscriptionController::class, 'startSubscription'])
            ->name('subscription.start');
        Route::get('/subscription/moneroo/return', [PartnerSubscriptionController::class, 'handleMonerooReturn'])
            ->name('subscription.moneroo.return');
    });

});
