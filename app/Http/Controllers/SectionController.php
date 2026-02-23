<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\Language;
use Illuminate\Support\Str;
use App\HasFilters;
use App\Models\Category;
use App\Models\Country;
use App\Models\Section;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller {
    use HasFilters;

    // sections
    public function sections(Request $request) {
        // Récupérer les filtres
        $statusMapping = [
            'active' => 1,
            'inactive' => 0,
        ];

        // Appliquer les filtres génériques via le trait
        $query = Section::withCount(['views']);
        $query = $this->applyFilters($request, $query, $statusMapping);

        // Exécution de la requête
        $sections = $query->get();

        $total = $sections->count();
        $active = $sections->where('status', 1)->count();
        $inactive = $sections->where('status', 0)->count();

        $categories = Category::orderBy('name')->get();
        $languages = Language::all();

        return view('backend.admin.sections.index', compact(
            'sections',
            'total',
            'active',
            'inactive',
            'categories',
            'languages',
        ));
    }

    public function addForm(Request $request) {
        $languages = Language::all();
        return view('backend.admin.sections.add', compact('languages'));
    }

    public function add(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100', // pas obligatoire mais limité
            'language_id' => 'nullable|exists:languages,id',
            'content' => 'required|string',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240', // 10 Mo max
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2 Mo max
            'status' => 'nullable|boolean',
            'position' => 'nullable|integer',
            'info' => 'nullable|string',
            'page_id' => 'nullable|exists:pages,id',
            'page' => 'nullable|string|max:255',
        ]);

        // Préparer les données sauf les fichiers
        $data = $request->except(['image', 'video']);
        // Gestion des fichiers uploadés
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sections/images', 'public');
        }
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('sections/videos', 'public');
        }
        // Création de la section
        Section::create($data);

        return redirect()->route('admin.sections')->with('success', 'Section ajoutée avec succès.');
    }

    public function edit($id){
        $section = Section::findOrFail($id);
        $languages = Language::all();
        $countries = Country::orderBy('name')->get();
        $categories = Category::all();
        return view('backend.admin.sections.edit', compact('section', 'languages', 'countries', 'categories'));
    }


    public function updateStatus($id, Request $request){
        $section = Section::find($id);
        if (!$section) {
            return response()->json(['success' => false, 'message' => 'Introuvable.'], 404);
        }
        $section->status = $request->input('status');
        $section->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }


    public function update(Request $request, $id) {
        $section = Section::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'language_id' => 'nullable|exists:languages,id',
            'content' => 'required|string',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|boolean',
            'position' => 'nullable|integer',
            'info' => 'nullable|string',
            'page_id' => 'nullable|exists:pages,id',
            'page' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['image', 'video']);
        if ($request->hasFile('image')) {
            if ($section->image && Storage::disk('public')->exists($section->image)) {
                Storage::disk('public')->delete($section->image);
            }
            $data['image'] = $request->file('image')->store('sections/images', 'public');
        }
        if ($request->hasFile('video')) {
            if ($section->video && Storage::disk('public')->exists($section->video)) {
                Storage::disk('public')->delete($section->video);
            }
            $data['video'] = $request->file('video')->store('sections/videos', 'public');
        }
        $section->update($data);

        return redirect()->route('admin.sections')->with('success', 'Section mise à jour avec succès.');
    }


    public function delete($id) {
        $section = Section::find($id);
        if (!$section) {
            return back()->with('error', 'Introuvable.');
        }
       if (in_array($section->type, ['merveille', 'guinea'])) {
            return back()->with('error', 'Cette section ne peut pas être supprimée.');
        }

        if ($section->image && Storage::disk('public')->exists($section->image)) {
            Storage::disk('public')->delete($section->image);
        }
        if ($section->video && Storage::disk('public')->exists($section->video)) {
            Storage::disk('public')->delete($section->video);
        }
        $section->delete();
        return back()->with('success', 'Section supprimée avec succès.');
    }

}
