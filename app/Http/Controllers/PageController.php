<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Language;
use Illuminate\Support\Str;
use App\HasFilters;
use App\Models\Category;
use App\Models\Country;
use App\Models\Page;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller {
    use HasFilters;


    // Pages
    public function index(Request $request) {
        // Récupérer les filtres
        $statusMapping = [
            'active' => 1,
            'inactive' => 0,
        ];

        // Appliquer les filtres génériques via le trait
        $query = Page::withCount(['reviews', 'views'])->with('reviews');
        $query = $this->applyFilters($request, $query, $statusMapping);

        // Exécution de la requête
        $pages = $query->get();

        $total = $pages->count();
        $active = $pages->where('status', 1)->count();
        $inactive = $pages->where('status', 0)->count();

        $categories = Category::orderBy('name')->get();
        $languages = Language::all();
        $countries = Country::orderBy('name')->get();

        return view('backend.admin.pages.index', compact(
            'pages',
            'total',
            'active',
            'inactive',
            'categories',
            'languages',
            'countries',
        ));
    }

    public function create(Request $request) {
        $categories = Category::orderBy('name')->get();
        $languages = Language::all();
        $countries = Country::orderBy('name')->get();

        return view('backend.admin.pages.create', compact(
            'categories',
            'languages',
            'countries',
        ));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'type' => 'required|in:people,merveille,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'content' => 'required|string',
            'info' => 'nullable|string',

        ]);
        $slug = Str::slug($request->title, '-');
        $existingPage = Page::where('slug', $slug)->first();
        if ($existingPage) {
            $slug = $slug . '-' . time();
        }
        // Traitement des données pour l'ajout
        $data = $request->except(['image', 'banner', 'video']);
        $data['slug'] = $slug; // Ajouter le slug dans les données
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages/images', 'public');
        }
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('pages/banners', 'public');
        }
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('pages/videos', 'public');
        }
        Page::create($data);
        return redirect()->route('admin.pages')->with('success', 'Page ajoutée avec succès.');
    }

    public function edit($id){
        $page = Page::findOrFail($id);
        $languages = Language::all();
        $countries = Country::orderBy('name')->get();
        $categories = Category::all();
        return view('backend.admin.pages.edit', compact('page', 'languages', 'countries', 'categories'));
    }

    public function update(Request $request, $id) {
        $page = Page::findOrFail($id);
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'content' => 'required|string',
            'info' => 'nullable|string',
        ];
        if (!in_array($page->type, ['about', 'community', 'home'])) {
            $rules['type'] = 'required|in:home,about,community,merveille,people,women,other';
        }
        // Validation
        $validated = $request->validate($rules);

        // On retire les fichiers (gérés à part)
        $data = Arr::except($validated, ['image', 'banner', 'video']);

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $data['image'] = $request->file('image')->store('pages/images', 'public');
        }
        if ($request->hasFile('banner')) {
            if ($page->banner) {
                Storage::disk('public')->delete($page->banner);
            }
            $data['banner'] = $request->file('banner')->store('pages/banners', 'public');
        }
        if ($request->hasFile('video')) {
            if ($page->video) {
                Storage::disk('public')->delete($page->video);
            }
            $data['video'] = $request->file('video')->store('pages/videos', 'public');
        }
        $page->update($data);
        return redirect()->route('admin.pages')->with('success', 'Page mise à jour avec succès.');
    }

    public function updateStatus($id, Request $request){
        $page = Page::find($id);
        if (!$page) {
            return response()->json(['success' => false, 'message' => 'Introuvable.'], 404);
        }
        $page->status = $request->input('status');
        $page->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }

    public function delete($id){
        $page = Page::find($id);
        if (!$page) {
            return back()->with('error', 'Page introuvable.');
        }
        if (!in_array($page->type, ['other', 'merveille', 'people'])) {
            return back()->with('error', 'Cette page ne peut pas être supprimée.');
        }

        $uploadsPath = public_path('uploads/pages/');
        $fichiers = ['image', 'banner', 'video'];
        foreach ($fichiers as $fichier) {
            if ($page->$fichier && file_exists($uploadsPath . $page->$fichier)) {
                @unlink($uploadsPath . $page->$fichier);
            }
        }
        $page->delete();
        return back()->with('success', 'Page supprimée avec succès.');
    }

}
