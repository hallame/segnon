<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Hotel;
use App\Models\Language;
use Illuminate\Support\Str;
use App\HasFilters;
use App\Models\Account;
use App\Models\Category;
use App\Models\Country;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;


class AdminRoomController extends Controller {

    use HasFilters;

    public function index(Request $request) {
        // Récupérer les filtres
        $statusMapping = [
            'active' => 1,
            'inactive' => 0,
        ];

        // Appliquer les filtres génériques via le trait
        $query = Room::withCount(['bookings', 'reviews', 'views']);
        $query = $this->applyFilters($request, $query, $statusMapping);

        // Exécution de la requête
        $rooms = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calcul des autres données
        $total = Room::count();
        $active = Room::where('status', 1)->count();
        $inactive = Room::where('status', 0)->count();
        $averageRating = Room::with('reviews')->get()->avg(function($room) {
            return $room->reviews->avg('rating') ?? 0;
        });
        $averageRating = number_format($averageRating, 2);


        $totalReviews = Room::has('reviews')->count();
        $hotels = Hotel::all();
        $languages = Language::all();
        $countries = Country::orderBy('name')->get();
        $facilities = Facility::where('status', 1)->orderBy('name')->get();

        // Retourner la vue avec les données
        return view('backend.admin.rooms.index', compact(
            'rooms',
            'total',
            'averageRating',
            'totalReviews',
            'active',
            'inactive',
            'hotels',
            'languages',
            'countries',
            'facilities',
        ));
    }

    public function create(Request $request) {
        $categories = Category::where(function($q) {
            $q->whereIn('model', ['hotel', 'room'])
            ->orWhereNull('model');
        })->get();

        $languages = Language::all();
        $countries = Country::orderBy('name')->get();
        $facilities = Facility::where('status', 1)->orderBy('name')->get();
        $hotels = Hotel::all();

        $accounts = Account::query()
            ->where('status',1)
            ->whereHas('modules', fn($m)=>$m->where('slug','hotel'))
            ->orderBy('name')
            ->get(['id','name','is_verified']);

        return view('backend.admin.rooms.create', compact(
            'categories',
            'languages',
            'countries',
            'facilities',
            'hotels',
            'accounts'
        ));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'nullable','integer',
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric',
            'info' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
            'video_url' => 'nullable|url',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ]);
        // $validated['account_id'] = $this->resolveAccountId(null, false);

        $room = new Room();
        $room->fill(collect($validated)->except('facilities')->toArray());
        $room->slug = Str::slug($request->name) . '-' . uniqid();
        if ($request->hasFile('image')) {
            $room->image = $request->file('image')->store('rooms/images', 'public');
        }
        if ($request->hasFile('video')) {
            $room->video = $request->file('video')->store('rooms/videos', 'public');
        }
        $room->save();
        if ($request->has('facilities')) {
            $room->facilities()->sync($request->facilities);
        }

        return redirect()->route('media.index', [
            'type' => 'room',
            'key'  => $room->slug ?: $room->getKey(),
        ])->with('success', 'Chambre créée avec succès. Veuillez maintenant ajouter des images.');
    }

    public function edit(Room $room){
        $languages = Language::all();
        $countries = Country::orderBy('name')->get();
        $categories = Category::where(function($q) {
            $q->where('model', ['hotel', 'room'])->orWhereNull('model');
        })->get();
        $hotels = Hotel::all();

        $facilities = Facility::where('status', 1)->orderBy('name')->get();
        return view('backend.admin.rooms.edit', compact('room', 'languages', 'countries', 'categories', 'facilities', 'hotels'));
    }

     public function updateStatus($id, Request $request){
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Hôtel introuvable.'], 404);
        }
        $room->status = $request->input('status');
        $room->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }

    public function update(Request $request, Room $room) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'nullable','integer',
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric',
            'info' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
            'video_url' => 'nullable|url',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ]);
        // $validated['account_id'] = $this->resolveAccountId(null, false);

        $room->fill(collect($validated)->except('facilities')->toArray());


        // Image principale
        if ($request->hasFile('image')) {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $room->image = $request->file('image')->store('rooms/images', 'public');
        }

        // Vidéo
        if ($request->hasFile('video')) {
            if ($room->video && Storage::disk('public')->exists($room->video)) {
                Storage::disk('public')->delete($room->video);
            }
            $room->video = $request->file('video')->store('rooms/videos', 'public');
        }

        $room->save();

        if ($request->has('facilities')) {
            $room->facilities()->sync($request->facilities);
        } else {
            $room->facilities()->detach();
        }


        // Controller update()
        if ($request->has('save_and_media')) {
            return redirect()->route('media.index', ['type' => 'room', 'key'  => $room->slug ?: $room->getKey()])
                ->with('success', 'Modifications enregistrées. Gérer les médias.');
        }

        return back()->with('success', 'Modifications enregistrées.');

    }

    public function destroy($id) {
        $room = Room::find($id);

        if (!$room) {
            return back()->with('error', 'La chambre n’existe pas.');
        }

        // Vérifier s’il existe des réservations
        if ($room->bookings()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette chambre car elle a des réservations.');
        }

        // Supprimer les relations
        $room->facilities()->detach();
        $room->reviews()->delete();
        $room->views()->delete();

        // Supprimer les fichiers si souhaité (image et vidéo)
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        if ($room->video && Storage::disk('public')->exists($room->video)) {
            Storage::disk('public')->delete($room->video);
        }

        $room->delete();

        return back()->with('success', 'Chambre supprimée avec succès.');
    }


    public function duplicate(Room $room, Request $request) {
        $copy = DB::transaction(function () use ($room) {
            // On duplique toutes les colonnes sauf celles à régénérer
            $new = $room->replicate(['slug','image','video','created_at','updated_at']);

            // Nom + slug uniques
            $new->name = Str::limit($room->name.' (copie)', 255, '');
            $new->slug = Str::slug($new->name).'-'.uniqid();

            // brouillon pour relecture
            $new->status = 0;

            // Copier l’image principale si présente
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                $ext = pathinfo($room->image, PATHINFO_EXTENSION) ?: 'jpg';
                $newImage = 'rooms/images/'.uniqid('copy_').'.'.$ext;
                Storage::disk('public')->copy($room->image, $newImage);
                $new->image = $newImage;
            }

            // Copier la vidéo si présente
            if ($room->video && Storage::disk('public')->exists($room->video)) {
                $ext = pathinfo($room->video, PATHINFO_EXTENSION) ?: 'mp4';
                $newVideo = 'rooms/videos/'.uniqid('copy_').'.'.$ext;
                Storage::disk('public')->copy($room->video, $newVideo);
                $new->video = $newVideo;
            }

            // Sauvegarde de la nouvelle chambre
            $new->save();

            // Dupliquer les équipements (pivot)
            $facilityIds = $room->facilities()->pluck('facilities.id')->all();
            if (!empty($facilityIds)) {
                $new->facilities()->sync($facilityIds);
            }

            // (Optionnel) Dupliquer les médias Spatie (galerie) si utilises
            // foreach ($room->getMedia() as $m) {
            //     $new->addMedia($m->getPath())->preservingOriginal()->toMediaCollection($m->collection_name);
            // }

            return $new;
        });

        return redirect()->route('admin.rooms.edit', $copy)
            ->with('success', 'Chambre dupliquée. Vous pouvez maintenant la modifier.');
    }

}
