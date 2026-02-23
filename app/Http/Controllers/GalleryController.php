<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Circuit;
use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;

class GalleryController extends Controller {
    // public function __construct(){
    //     $this->middleware('auth.admin');
    // }

     // GALLERIES

    public function galleries(Request $request){
        // Initialiser les filtres
        $status = $request->get('status');
        $period = $request->get('period');

        // Construire la requête principale
        $query = Gallery::with('galleryable')->latest();

        // Filtrer par statut si un statut est sélectionné
        if ($status) {
            // Filtre par type du modèle associé (par exemple 'App\Models\Site', 'App\Models\Circuit', etc.)
            $query->where('galleryable_type', 'App\Models\\' . $status);
        }

        // Filtrer par période si une période est sélectionnée
        if ($period) {
            // Application des filtres sur la période
            $dateQuery = match ($period) {
                'recently_added' => now()->subDays(7), // Derniers 7 jours
                'last_month' => now()->subMonth(), // Dernier mois
                'last_7_days' => now()->subDays(7), // Derniers 7 jours
                default => null,
            };

            if ($dateQuery) {
                $query->where('created_at', '>=', $dateQuery);
            }
        }

        // Exécuter la requête et récupérer les résultats
        $galleries = $query->get();

        // Compter les galeries et autres données pour l'affichage
        $total = $galleries->count();
        $categories = Category::orderBy('name')->get();

        return view('backend.admin.galleries', compact('galleries', 'total', 'categories'));
    }

    public function getElements(Request $request){
        $type = $request->input('type');

        if (!in_array($type, [
            'App\Models\Circuit',
            'App\Models\Hotel',
            'App\Models\Event',
        ])) {
            return response()->json([], 400);
        }

        $elements = $type::select('id', 'name')->orderBy('name')->get();

        return response()->json($elements);
    }

    public function add(Request $request) {
        $request->validate([
            'galleryable_type' => 'required|string',
            'galleryable_id' => 'required|integer',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'galleryable_type.required' => 'Le type d\'élément est requis.',
            'galleryable_id.required' => 'L\'élément spécifique est requis.',
            'images.required' => 'Veuillez télécharger au moins une image.',
            'images.array' => 'Les images doivent être sous forme de tableau.',
            'images.*.image' => 'Chaque fichier doit être une image.',
            'images.*.mimes' => 'Les images doivent être de type : jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Chaque image ne doit pas dépasser 2 Mo.',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $type = strtolower(class_basename($request->galleryable_type));
                $folder = "galleries/{$type}";
                $imagePath = $image->store($folder, 'public');

                Gallery::create([
                    'image' => $imagePath,
                    'galleryable_type' => $request->galleryable_type,
                    'galleryable_id' => $request->galleryable_id,
                    'status' => 1,
                ]);
            }
        }

        return back()->with('success', 'Galerie enregistrée avec succès.');
    }

    public function delete($id){
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return back()->with('error', 'Image introuvable.');
        }

        // Supprimer l'image physique
        if ($gallery->image && file_exists(storage_path('app/public/' . $gallery->image))) {
            unlink(storage_path('app/public/' . $gallery->image));
        }

        // Supprimer l'enregistrement en base
        $gallery->delete();

        return back()->with('success', 'Image supprimée avec succès.');
    }

    public function updateStatus($id, Request $request){
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return response()->json(['success' => false, 'message' => 'Galerie introuvable.'], 404); // 404 pour "site introuvable"
        }
        // Met à jour le statut
        $gallery->status = $request->input('status');
        $gallery->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }
}
