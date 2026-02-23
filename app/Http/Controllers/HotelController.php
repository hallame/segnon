<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Hotel;
use App\Models\Language;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Category;
use App\Models\Country;
use App\Models\Facility;
use App\Models\Review;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class HotelController extends Controller {

    public function index(Request $request) {
        // === Filtres ===
        $status = $request->string('status')->toString(); // all|active|inactive
        $period = $request->string('period')->toString(); // recently_added|last_month|last_7_days
        $accountId = $request->integer('account_id', 0);

        $q = Hotel::query()
            ->with(['category','country'])
            ->withCount(['bookings','reviews','views','rooms']);

        if ($status === 'active')   $q->where('status', 1);
        if ($status === 'inactive') $q->where('status', 0);
        if ($accountId)             $q->where('account_id', $accountId);

        if ($period === 'last_month')   $q->where('created_at', '>=', now()->subMonth());
        if ($period === 'last_7_days')  $q->where('created_at', '>=', now()->subDays(7));
        // 'recently_added' => juste l'ordre desc (par défaut plus bas)

        $hotels = $q->orderByDesc('created_at')->paginate(20)->withQueryString();

        // === KPIs (DB direct, pas en PHP) ===
        $total    = Hotel::count();
        $active   = Hotel::where('status', 1)->count();
        $inactive = $total - $active;

        $stats = Review::whereHasMorph('reviewable', [Hotel::class], function ($q) use ($accountId) {
                $q->where('account_id', $accountId);
            })
            ->selectRaw('COALESCE(AVG(rating),0) AS avg_rating, COUNT(*) AS total_reviews')
            ->first();

        $averageRating = round((float) $stats->avg_rating, 2);
        $totalReviews  = (int) $stats->total_reviews;

        $categories = Category::where(fn($q) => $q->where('model',['hotel', 'Hotel'])->orWhereNull('model'))->get();
        $languages  = Language::all();
        $countries  = Country::orderBy('name')->get();
        $facilities = Facility::where('status',1)->orderBy('name')->get();

        $accounts = Account::query()
        ->whereIn('id', Hotel::whereNotNull('account_id')->distinct()->pluck('account_id'))
        ->with(['users' => fn($q) => $q->wherePivot('is_owner', true)->select('users.id','firstname','lastname')])
        ->orderBy('name')
        ->get();

        return view('backend.admin.hotels.index', compact(
            'hotels','total','averageRating','totalReviews','active','inactive',
            'categories','languages','countries','facilities', 'accounts',
        ));
    }

    // Toggle status (AJAX)
    public function status(Request $request, Hotel $hotel) {
        $hotel->update(['status' => $request->boolean('status') ? 1 : 0]);
        return response()->json(['success' => true]);
    }

    public function add(Request $request) {
        $accounts = Account::query()
        ->where('status',1)
        ->whereHas('modules', fn($m)=>$m->where('slug','hotel'))
        ->orderBy('name')
        ->get(['id','name','is_verified']);
        $categories = Category::where(function($q) {
            $q->where('model',['hotel', 'Hotel'])->orWhereNull('model');
        })->get();        $languages = Language::all();
        $countries = Country::orderBy('name')->get();
        $facilities = Facility::where('status', 1)->orderBy('name')->get();
        return view('backend.admin.hotels.create', compact(
            'categories',
            'languages',
            'countries',
            'facilities',
            'accounts'
        ));

    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'nullable','integer',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'category_id' => 'nullable|exists:categories,id',
            'free_rooms' => 'nullable|integer|min:0',
            'total_rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:Standard,Luxe,Eco',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
            'video_url' => 'nullable|url|max:255',
            'info' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|max:10240',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'description' => 'nullable|string|max:3000',
            // 'account_id' => [
            //     'required','integer',
            //     Rule::exists('accounts','id')->where(function($q){
            //     $q->where('status',1)
            //         ->whereHas('modules', fn($m)=>$m->where('slug','hotel'));
            //     }),
            // ],
        ]);
        // $validated['account_id'] = $this->resolveAccountId(null, false);


        // Création d'une nouvelle instance
        $hotel = new Hotel();
        $hotel->fill(collect($validated)->except('facilities')->toArray());
        if ($request->hasFile('image')) {
            $hotel->image = $request->file('image')->store('hotels/images', 'public');
        }

        if ($request->hasFile('video')) {
            $hotel->video = $request->file('video')->store('hotels/videos', 'public');
        }

        $hotel->save();
        if ($request->has('facilities')) {
            $hotel->facilities()->sync($request->input('facilities', []));
        }

        return redirect()->route('media.index', [
            'type' => 'hotel',
            'key'  => $hotel->slug ?: $hotel->getKey(),
        ])->with('success', 'Hôtel ajouté avec succès. Veuillez maintenant ajouter des images.');
    }

    public function edit(Hotel $hotel) {
        $categories = Category::where(fn($q)=>$q->where('model',['hotel', 'Hotel'])->orWhereNull('model'))->get();
        $countries  = Country::orderBy('name')->get();
        $facilities = Facility::where('status',1)->orderBy('name')->get();
        $accounts   = Account::orderBy('name')->get(); // optionnel pour changer de compte
        return view('backend.admin.hotels.edit', compact('hotel','countries','categories','facilities','accounts'));
    }

    public function update(Request $request, Hotel $hotel){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'nullable','integer',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'category_id' => 'nullable|exists:categories,id',
            'free_rooms' => 'nullable|integer|min:0',
            'total_rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:Standard,Luxe,Eco',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
            'video_url' => 'nullable|url|max:255',
            'info' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|max:10240',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'description' => 'nullable|string|max:3000',
        ]);
        // $validated['account_id'] = $this->resolveAccountId(null, false);
        // Mise à jour des champs simples
        // $hotel->fill($validated);
        $hotel->fill(collect($validated)->except('facilities')->toArray());

        // Image principale
        if ($request->hasFile('image')) {
            if ($hotel->image && Storage::disk('public')->exists($hotel->image)) {
                Storage::disk('public')->delete($hotel->image);
            }
            $hotel->image = $request->file('image')->store('hotels/images', 'public');
        }

        // Vidéo
        if ($request->hasFile('video')) {
            if ($hotel->video && Storage::disk('public')->exists($hotel->video)) {
                Storage::disk('public')->delete($hotel->video);
            }
            $hotel->video = $request->file('video')->store('hotels/videos', 'public');
        }

        $hotel->save();

        // Synchronisation des installations
        if ($request->has('facilities')) {
            $hotel->facilities()->sync($request->facilities);
        } else {
            $hotel->facilities()->detach();
        }


        // Controller update()
        if ($request->has('save_and_media')) {
            return redirect()->route('media.index', ['type' => 'hotel', 'key'  => $hotel->slug ?: $hotel->getKey()])
                ->with('success', 'Modifications enregistrées. Gérer les médias.');
        }

        return back()->with('success', 'Modifications enregistrées. Gérer les médias !');
    }


    public function updateStatus($id, Request $request){
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json(['success' => false, 'message' => 'Hôtel introuvable.'], 404);
        }
        $hotel->status = $request->input('status');
        $hotel->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }

    public function destroy($id) {
        $hotel = Hotel::withCount('rooms')->find($id);

        if (!$hotel) {
            return back()->with('error', 'Hôtel introuvable.');
        }

        // ❌ Bloquer si l'hôtel a des chambres
        if ($hotel->rooms_count > 0) {
            return back()->with('error', 'Impossible de supprimer cet hôtel car il contient des chambres.');
        }

        // Supprimer l'image si stockée avec Storage (disk 'public')
        if ($hotel->image && Storage::disk('public')->exists($hotel->image)) {
            Storage::disk('public')->delete($hotel->image);
        }

        // Supprimer la vidéo si elle existe
        if ($hotel->video && Storage::disk('public')->exists($hotel->video)) {
            Storage::disk('public')->delete($hotel->video);
        }
        $hotel->reviews()->delete();
        $hotel->views()->delete();
        $hotel->facilities()->detach();

        $hotel->delete();

        return back()->with('success', 'Hôtel supprimé avec succès.');
    }


}
