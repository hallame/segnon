<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Faq;
use App\Models\SupportContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Models\Circuit;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Account;
use App\Models\Language;
use App\Models\Module;
use App\Models\Product;
use App\Models\Story;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;


class FrontendController extends Controller {


    public function home() {
        $bestSellers = Product::query()
            ->where('status', 1)
            ->selectRaw('products.*,
                CASE
                    WHEN old_price IS NOT NULL AND old_price > price AND description IS NOT NULL AND description != "" THEN 3
                    WHEN old_price IS NOT NULL AND old_price > price THEN 2
                    WHEN description IS NOT NULL AND description != "" THEN 1
                    ELSE 0
                END as priority')
            ->orderBy('created_at', 'desc')
            ->orderBy('priority', 'desc')


            ->with(['media', 'skus', 'category'])
            ->withMin('skus', 'price')
            ->paginate(32);

        // $bestSellers = Product::query()->where('status', 1)->with(['media','skus','category'])->withMin('skus', 'price')->latest()->paginate(24);

        $trends = Product::query()->where('status', 1)->with(['media','skus','category'])->withMin('skus', 'price')->latest()->paginate(12);

        $shopModule = Module::where('slug', 'shop')->first();

        $topVendors = collect();

        if ($shopModule) {
            $topVendors = Account::query()
                ->whereHas('modules', function ($q) use ($shopModule) {
                    $q->where('modules.id', $shopModule->id)
                    ->where('account_modules.is_enabled', true);
                })
                ->where('slug', '!=', 'platform')

                // compte uniquement les produits actifs
                ->withCount([
                    'products as active_products_count' => function ($q) {
                        $q->where('status', 1);
                    }
                ])

                // optionnel : s'assurer qu'il y en a au moins 1
                ->having('active_products_count', '>', 0)


                ->orderByDesc('active_products_count')

                ->orderByDesc(
                    DB::table('account_users')
                        ->join('users', 'users.id', '=', 'account_users.user_id')
                        ->whereColumn('account_users.account_id', 'accounts.id')
                        ->select('users.last_login_at')
                        ->orderByDesc('users.last_login_at')
                        ->limit(1)
                )
                ->limit(7)
                ->get();
        }

        return view('frontend.home', compact(
            'trends', 'bestSellers', 'topVendors'
        ));
    }

    public function pricing(){
        return view('frontend.pricing');
    }

    public function sellerGuide(){
        return view('frontend.sales-guide');
    }

    public function terms(){
        return view('frontend.terms');
    }

    public function policy(){
        return view('frontend.policy');
    }




    // CONTACT
    public function contact(){
        $contacts = Contact::where('status', 1)->get();
        return view('frontend.contact', compact('contacts'));
    }

    public function sendContact(Request $request) {

        // ===== 1. HONEYPOT =====
        // Vérification honeypot
        if (!empty($request->website)) {
            \Log::info('Spam détecté via honeypot', ['ip' => $request->ip()]);
            return back()->with('status', 'Votre message a été envoyé !'); // Même message pour ne pas alerter le bot
        }

        // ===== TEMPS MINIMUM =====
        $timeStart = $request->time_start;
        $timeElapsed = microtime(true) - $timeStart;

        // Temps minimum de 1.5 secondes, maximum de 30 minutes
        if ($timeElapsed < 1.5) {
            \Log::warning('Spam - Formulaire rempli trop vite', [
                'ip' => $request->ip(),
                'temps' => round($timeElapsed, 2) . 's'
            ]);
            return back()->withErrors(['error' => 'Veuillez prendre le temps de remplir le formulaire correctement.']);
        }

        if ($timeElapsed > 1800) { // 30 minutes
            return back()->withErrors(['error' => 'Session expirée. Veuillez recharger la page.']);
        }

        // ===== 4. RATE LIMITING PAR IP =====
        $ipKey = 'contact:ip:' . $request->ip();
        $ipLimit = Cache::get($ipKey, 0);

        if ($ipLimit >= 5) { // 5 tentatives max
            if ($ipLimit == 5) {
                \Log::warning('Rate limit atteint pour IP', ['ip' => $request->ip()]);
                Cache::put($ipKey, $ipLimit + 1, now()->addHours(2)); // Bloquer plus longtemps
            }
            return back()->with('status', 'Merci pour votre message ! Nous vous répondrons rapidement.');
        }

        // ===== 6. VALIDATION DES DONNÉES =====
        $validated = $request->validate([
            'firstname' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/u',
                function ($attribute, $value, $fail) {
                    // Vérifier les patterns de spam communs
                    if (strlen($value) > 50 || preg_match('/[0-9]/', $value) || substr_count($value, ' ') > 5) {
                        $fail('Le nom semble invalide.');
                    }
                }
            ],
            'lastname'  => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/u'
            ],
            'email'     => [
                'required',
                'email:rfc,dns',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Bloquer les emails temporaires ou suspects
                    $tempDomains = ['tempmail', '10minutemail', 'guerrillamail', 'mailinator'];
                    foreach ($tempDomains as $domain) {
                        if (strpos($value, $domain) !== false) {
                            $fail('Les emails temporaires ne sont pas acceptés.');
                        }
                    }

                    // Vérifier le format
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('L\'email n\'est pas valide.');
                    }
                }
            ],
            'phone'     => 'nullable|string|max:50|regex:/^[\d\s\-\+\(\)]{10,20}$/',
            'subject'   => 'required|string|max:255',
            'message'   => [
                'required',
                'string',
                'min:20',
                'max:2000',
                function ($attribute, $value, $fail) {
                    // Détection de spam dans le message
                    $spamScore = 0;

                    // Trop de liens
                    $linkCount = preg_match_all('/https?:\/\//i', $value);
                    if ($linkCount > 2) $spamScore += 2;

                    // Mots clés de spam
                    $spamKeywords = [
                        'viagra', 'cialis', 'casino', 'loan', 'lottery', 'credit',
                        'insurance', 'investment', 'bitcoin', 'crypto', 'forex',
                        'click here', 'buy now', 'limited offer', 'dear friend'
                    ];

                    foreach ($spamKeywords as $keyword) {
                        if (stripos($value, $keyword) !== false) {
                            $spamScore += 1;
                        }
                    }

                    // Trop de majuscules (CRIÉ)
                    if (preg_match_all('/[A-Z]/', $value) > strlen($value) * 0.3) {
                        $spamScore += 1;
                    }

                    // Caractères répétitifs
                    if (preg_match('/(.)\1{5,}/', $value)) {
                        $spamScore += 2;
                    }

                    if ($spamScore >= 3) {
                        $fail('Votre message semble contenir du contenu indésirable.');
                    }
                }
            ],
            'consent'   => 'required|accepted',
        ]);

        // ===== 7. INCREMENTER LES COMPTEURS =====
        Cache::put($ipKey, $ipLimit + 1, now()->addHour());
        // Cache::put($emailKey, $emailLimit + 1, now()->addHours(6));

        // ===== 8. TRAITEMENT NORMAL =====
        $supportContact = new SupportContact();
        $supportContact->firstname = $validated['firstname'];
        $supportContact->lastname  = $validated['lastname'];
        $supportContact->email     = $validated['email'];
        $supportContact->phone     = $validated['phone'] ?? null;
        $supportContact->subject   = $validated['subject'];
        $supportContact->message   = $validated['message'];
        $supportContact->consent   = 1;
        $supportContact->save();

        $recipientEmail = config('mail.submission_notification.email');

        // ===== 9. ENVOI EMAIL =====
        try {
            Mail::to($recipientEmail)->send(new ContactFormMail(
                $validated['firstname'],
                $validated['lastname'],
                $validated['email'],
                $validated['phone'] ?? null,
                $validated['subject'],
                $validated['message']
            ));

        } catch (\Exception $e) {
            // On log l'erreur mais on ne bloque pas l'utilisateur
            \Log::error("Échec de l'envoi de l'email contact : " . $e->getMessage(), [
                'contact_id' => $supportContact->id,
                'email' => $validated['email']
            ]);

            // Vous pourriez aussi envoyer une notification à l'admin
            // via un autre canal (Slack, SMS, etc.) pour signaler le problème
        }

        // ===== 10. TOUJOURS SUCCÈS POUR L'UTILISATEUR =====
        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }



    // about
    public function about(){
        return view('frontend.about');
    }



    public function subscribe(Request $request){
        // Validation de l'email
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email'
        ]);

        // Enregistrement de l'email dans la base de données
        $subscriber = NewsletterSubscriber::create([
            'email' => $request->email,
        ]);

        // Envoi d'un email de confirmation
        // Mail::to($request->email)->send(new NewsletterConfirmation($subscriber));

        // Retourner un message de confirmation
        return back()->with('success', 'Vous êtes maintenant abonné à notre newsletter !');
    }



    // FAQs
    public function faqs(Request $request) {
        $q          = (string) $request->get('q', '');
        $categoryId = $request->get('category_id');

        $faqs = Faq::query()
            ->with('category')
            ->active()
            ->when($categoryId, fn($qq) => $qq->where('category_id', $categoryId))
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('question', 'like', "%{$q}%")
                      ->orWhere('answer', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%");
                });
            })
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->where('model','Faq')
            ->orderBy('name')
            ->get(['id','name']);

        return view('frontend.faqs', compact('faqs','categories'));
    }

}
