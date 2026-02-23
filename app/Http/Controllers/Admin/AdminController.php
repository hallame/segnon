<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Country;
use App\Models\Event;
use App\Models\Guide;
use Illuminate\Support\Facades\Auth;
use App\Models\Language;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\HasFilters;
use App\Models\Booking;
use App\Models\ContentSubmission;
use App\Models\Location;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;

class AdminController extends Controller{
    use HasFilters;

    // DASHBOARD
    public function dashboard(){

        // Statistiques Utilisateurs (ex-Clients)
        $users = tap(
            User::whereDoesntHave('accounts')->latest()->get(),
            function ($users) {
                $users->display = $users->take(5);
            }
        );

        $totalUsers = User::count();
        $activeClients = $users->where('status', 0)->count(); // si tu as un champ "status"

        $clientsData = [
            'clients' => $users,
            'totalUsers' => $totalUsers,
            'activeClients' => $activeClients,
        ];


        //  Statistiques Réservations (Bookings)
        $bookings = tap(Booking::latest()->get(), function ($bookings) {
            $bookings->display = $bookings->take(5);
        });

        $totalBookings = $bookings->count();

        if ($totalBookings > 0) {
            $pendingBookings   = $bookings->where('status', Booking::STATUS_PENDING)->count();
            $confirmedBookings = $bookings->where('status', Booking::STATUS_CONFIRMED)->count();
            $canceledBookings  = $bookings->where('status', Booking::STATUS_CANCELLED)->count();

            $pendingBookingsPercent   = round(($pendingBookings / $totalBookings) * 100);
            $confirmedBookingsPercent = round(($confirmedBookings / $totalBookings) * 100);
            $canceledBookingsPercent  = round(($canceledBookings / $totalBookings) * 100);
        } else {
            $pendingBookings = $confirmedBookings = $canceledBookings = 0;
            $pendingBookingsPercent = $confirmedBookingsPercent = $canceledBookingsPercent = 0;
        }

        $bookingsData = [
            'bookings' => $bookings,
            'totalBookings' => $totalBookings,
            'pendingBookings' => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'canceledBookings' => $canceledBookings,
            'pendingBookingsPercent' => $pendingBookingsPercent,
            'confirmedBookingsPercent' => $confirmedBookingsPercent,
            'canceledBookingsPercent' => $canceledBookingsPercent,
        ];


        //  Statistiques produits
        $products = tap(Product::latest()->get(), function ($products) {
            $products->display = $products->take(6);
        });

        $totalProducts = $products->count();
        $productsData = [
            'products' => $products,
            'totalProducts' => $totalProducts,
        ];

        // Statistiques Guides
        $guides = tap(Guide::latest()->get(), function ($guides) {
            $guides->display = $guides->take(5);
        });
        $totalGuides = $guides->count();
        $activeGuides = $guides->where('status', 0)->count();
        $guidesData = [
            'guides' => $guides,
            'totalGuides' => $totalGuides,
            'activeGuides' => $activeGuides,
        ];

        // Statistiques Partners
        $partners = tap(Partner::latest()->get(), function ($partners) {
            $partners->display = $partners->take(5);
        });
        $totalPartners = $partners->count();
        $activePartners = $partners->where('status', 0)->count();
        $partnersData = [
            'partners' => $partners,
            'totalPartners' => $totalPartners,
            'activePartners' => $activePartners,
        ];


        // Events
        $events = tap(Event::latest()->get(), function ($events) {
            $events->display = $events->take(5);
        });
        $totalEvents = $events->count();
        $eventsData = [
            'events' => $events,
            'totalEvents' => $totalEvents
        ];

        // Orders
        $orders = tap(Order::latest()->get(), function ($orders) {
            $orders->display = $orders->take(5);
        });
        $totalOrders = $orders->count();
        $ordersData = [
            'orders' => $orders,
            'totalOrders' => $totalOrders
        ];


        $totalSubs = ContentSubmission::count();

        // Data
        $languages = Language::get();
        $categories = Category::where('status', 1)->get();
        $countries = Country::where('status', 1)->get();

        $data = [
            'languages' => $languages,
            'categories' => $categories,
            'countries' => $countries,
            'totalSubs' => $totalSubs,
        ];


        /// Return ///////////////
        return view('backend.admin.dashboard', array_merge(
            $clientsData,
            $guidesData,
            $partnersData,
            $bookingsData,
            $eventsData,
            $data,
            $productsData,
            $ordersData,
        ));
    }

      // LOCATIONS
    public function locations(){
        $locations = Location::orderBy('name')->get();
        $totalLocations = $locations->count();
        $openedLocations = $locations->where('status', true)->count();
        $closedLocations = $locations->where('status', false)->count();
        return view('backend.admin.locations', compact('locations', 'totalLocations', 'openedLocations', 'closedLocations'));
    }

    public function deleteLocation($id){
        $location = Location::find($id);
        if (!$location) {
            return back()->with('error', 'Emplacement introuvable.');
        }
        $location->delete();
        return back()->with('success', 'Emplacement supprimé avec succès.');
    }

    public function updateStatusLocation($id, Request $request){
        $location = Location::find($id);
        if (!$location) {
            return redirect()->route('admin.domains')->with('error', 'Emplacement introuvable.');
        }
        // Met à jour le statut
        $location->status = $request->input('status');
        $location->save();
        return redirect()->route('admin.domains')->with('success', 'Emplacement mis à jour avec succès.');
    }

    public function addLocation(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',         // Nom de l'emplacement (obligatoire)
            'address' => 'required|string|max:255',      // Adresse (obligatoire)
            'phone' => 'nullable|string|max:20',         // Numéro de téléphone (optionnel)
            'email' => 'nullable|email|max:255',         // Email (optionnel)
            'details' => 'nullable|string',              // Détails supplémentaires (optionnel)
            'map_link' => 'nullable|string',              // Détails supplémentaires (optionnel)
        ], [
            'name.required' => 'Le nom de l\'emplacement est obligatoire.',
            'name.string' => 'Le nom de l\'emplacement doit être une chaîne de caractères.',
            'name.max' => 'Le nom de l\'emplacement ne peut pas dépasser 255 caractères.',

            'address.required' => 'L\'adresse est obligatoire.',
            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',

            'phone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',

            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'details.string' => 'Les détails doivent être une chaîne de caractères.',
            'map_link.string' => 'Le lien map doit être une chaîne de caractères.',

        ]);


        // Création d'un nouvel emplacement avec les données validées
        $location = new Location();
        $location->name = $request->input('name');
        $location->address = $request->input('address');
        $location->phone = $request->input('phone');
        $location->email = $request->input('email');
        $location->details = $request->input('details');
        $location->status = true; // Par défaut, l'emplacement est actif
        $location->save();
        // Retourner une réponse avec un message de succès
        return redirect()->route('admin.locations')->with('success', 'Emplacement ajouté avec succès!');
    }



     // COUNTRIES
    public function countries(){
        $countries = Country::orderBy('name')->get();
        $allActive = $countries->every(fn($country) => $country->status);

        return view('backend.admin.countries', compact('countries', 'allActive'));
    }

    public function configCountries(Request $request){

        if ($request->has('status')) {
            foreach ($request->input('status') as $countryId => $status) {
                $country = Country::find($countryId);
                if ($country) {
                    $country->status = (bool) $status; // Convertir en booléen
                    $country->save();
                }
            }

            return redirect()->route('admin.countries')->with('success', 'Les statuts des pays ont été mis à jour avec succès.');
        }

        return redirect()->route('admin.countries')->with('error', 'Aucune modification n\'a été apportée.');
    }

    public function addCountry(Request $request){
        // Validation des données
        $request = $request->validate([
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string|min:2|unique:countries,iso_code|max:3|alpha', // Validation ISO code (lettres uniquement, 2 ou 3 caractères)
            'country_code' => 'required|string|regex:/^\+?\d{1,5}$/', // Validation de l'indicatif pays (peut commencer par + suivi de 1 à 5 chiffres)
        ], [
            'name.required' => 'Le nom du pays est obligatoire.',
            'name.string' => 'Le nom du pays doit être une chaîne de caractères.',
            'name.max' => 'Le nom du pays ne doit pas dépasser 255 caractères.',

            'iso_code.required' => 'Le code ISO est obligatoire.',
            'iso_code.string' => 'Le code ISO doit être une chaîne de caractères.',
            'iso_code.min' => 'Le code ISO doit avoir 2 ou 3 caractères.',
            'iso_code.unique' => 'Ce code ISO est déjà utilisé.',
            'iso_code.max' => 'Le code ISO doit avoir 2 ou 3 caractères.',
            'iso_code.alpha' => 'Le code ISO doit uniquement contenir des lettres.',

            'country_code.required' => 'L\'indicatif pays est obligatoire.',
            'country_code.string' => 'L\'indicatif pays doit être une chaîne de caractères.',
            'country_code.regex' => 'L\'indicatif pays doit être un nombre valide, pouvant commencer par + (ex : +229).',
        ]);
        // Création d'un nouveau pays dans la base de données
        Country::create([
            'name' => $request['name'],
            'iso_code' => $request['iso_code'], // Utilisation du code ISO
            'country_code' => $request['country_code'],
            'status' => 1, // Pays ajouté comme actif par défaut
        ]);

        // Retourner vers la liste des pays avec un message de succès
        return redirect()->route('admin.countries')->with('success', 'Le pays a été ajouté avec succès.');
    }

    public function updateCountry(Request $request, $id){
        $request->validate([
            'name' => 'required|string',
            'iso_code' => 'required|string',
            'country_code' => 'required|string',
        ]);

        $country = Country::findOrFail($id);
        $country->update([
            'name' => $request->name,
            'iso_code' => $request->iso_code,
            'country_code' => $request->country_code,
        ]);

        return back()->with('success', 'Pays modifié avec succès.');
    }

    public function deleteCountry($id){
        $country = Country::find($id);
        if ($country) {
            $country->delete();

            return back()->with('success', 'Le pays a été supprimé avec succès.');
        }
        return back()->with('error', 'Le pays n\'existe pas.');
    }



        // ACCOUNT
    public function myprofile(){
            $admin = Auth::user();
            return view('backend.admin.myprofile', compact('admin'));
    }
    public function updateMyProfile(Request $request){
        $admin = $request->user();
        // Validation des données du formulaire
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:6|confirmed',
        ], [
            'firstname.required' => 'Le prénom est requis.',
            'firstname.string' => 'Le prénom doit être une chaîne de caractères.',
            'firstname.max' => 'Le prénom ne peut pas dépasser 255 caractères.',

            'lastname.required' => 'Le nom est requis.',
            'lastname.string' => 'Le nom doit être une chaîne de caractères.',
            'lastname.max' => 'Le nom ne peut pas dépasser 255 caractères.',

            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'email.max' => 'L\'adresse e-mail ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',

            'phone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',

            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',

            'country.string' => 'Le pays doit être une chaîne de caractères.',
            'country.max' => 'Le pays ne peut pas dépasser 255 caractères.',

            'city.string' => 'La ville doit être une chaîne de caractères.',
            'city.max' => 'La ville ne peut pas dépasser 255 caractères.',

            'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
            'postal_code.max' => 'Le code postal ne peut pas dépasser 20 caractères.',

            'profile_picture.image' => 'Le fichier téléchargé doit être une image.',
            'profile_picture.mimes' => 'L\'image doit être de type jpeg, png, jpg ou gif.',
            'profile_picture.max' => 'L\'image ne peut pas dépasser 2 Mo.',

            'current_password.string' => 'Le mot de passe actuel doit être une chaîne de caractères.',
            'current_password.min' => 'Le mot de passe actuel doit comporter au moins 6 caractères.',

            'new_password.string' => 'Le nouveau mot de passe doit être une chaîne de caractères.',
            'new_password.min' => 'Le nouveau mot de passe doit comporter au moins 6 caractères.',
            'new_password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);
        // Mise à jour des informations de l'administrateur
        $admin->firstname = $validated['firstname'];
        $admin->lastname = $validated['lastname'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'] ?? $admin->phone;
        $admin->address = $validated['address'] ?? $admin->address;
        $admin->country = $validated['country'] ?? $admin->country;
        $admin->city = $validated['city'] ?? $admin->city;
        $admin->postal_code = $validated['postal_code'] ?? $admin->postal_code;
        // Si une nouvelle photo de profil est téléchargée
        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profiles/admins', 'public');
            // Supprimer l'ancienne photo de profil si elle existe
            if ($admin->avatar && Storage::exists('public/' . $admin->avatar)) {
                Storage::delete('public/' . $admin->avatar);
            }
            $admin->avatar = $imagePath;
        }

        // Changement de mot de passe
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->current_password, $admin->password)) {
                $admin->password = Hash::make($validated['new_password']);
            } else {
                return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
            }
        }
        // Sauvegarder les modifications
        $admin->save();
        // Retourner à la vue avec un message de succès
        return redirect()->route('admin.myprofile')->with('success', 'Profil mis à jour avec succès.');
    }

}
