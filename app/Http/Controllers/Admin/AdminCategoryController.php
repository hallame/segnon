<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\HasFilters;


class AdminCategoryController extends Controller {


    use HasFilters;

    public function index(){
        $categories = Category::orderBy('name')->get();
        $allActive = $categories->every(fn($category) => $category->status);
        return view('backend.admin.categories', compact('categories', 'allActive'));
    }

    public function updateStatus(Request $request, $id) {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Catégorie introuvable.'], 404);
        }

        $category->status = (bool) $request->input('status');
        $category->save();

        return response()->json(['success' => true]);
    }

    public function store(Request $request){

        $request = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'description.required' => 'La description est obligatoire.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',

        ]);

        Category::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'slug' => Str::slug($request['name']),
            'status' => 1,
        ]);

        // Retourner vers la liste des pays avec un message de succès
        return redirect()->route('admin.categories')->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'description.required' => 'La description est obligatoire.',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => Str::slug($validated['name']),
        ]);

        return back()->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy($id) {

        $category = Category::find($id);

        if (!$category) {
            return back()->with('error', 'Cette catégorie n\'existe pas.');
        }

        $relations = [
            'hotels' => 'des hôtels',
            'objects' => 'des objets',
            'sites' => 'des sites',
            'events' => 'des événements',
        ];

        foreach ($relations as $relation => $label) {
            if ($category->$relation()->exists()) {
                return back()->with('error', "Impossible de supprimer cette catégorie : elle est liée à $label.");
            }
        }

        $category->delete();

        return back()->with('success', 'La catégorie a été supprimée avec succès.');
    }
}
