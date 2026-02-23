<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\Language;
use Illuminate\Support\Str;
use App\HasFilters;
use App\Models\Category;
use App\Models\Country;
use App\Models\Slider;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller {
    use HasFilters;

    // sliders
    public function sliders(Request $request) {
        // Récupérer les filtres
        $statusMapping = [
            'active' => 1,
            'inactive' => 0,
        ];
        // Appliquer les filtres génériques via le trait
        $query = Slider::withCount(['reviews', 'views'])->with('reviews');
        $query = $this->applyFilters($request, $query, $statusMapping);

        // Exécution de la requête
        $sliders = $query->get();

        $total = $sliders->count();
        $active = $sliders->where('status', 1)->count();
        $inactive = $sliders->where('status', 0)->count();

        $categories = Category::orderBy('name')->get();
        $languages = Language::all();

        return view('backend.admin.sliders.index', compact(
            'sliders',
            'total',
            'active',
            'inactive',
            'categories',
            'languages',
        ));
    }
    public function store(Request $request) {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'language_id' => 'nullable|exists:languages,id',
            'page_id' => 'nullable|exists:pages,id',
            'page' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position' => 'nullable|integer',
            'link' => 'nullable|url|max:255',
        ]);
        // Récupération des données sauf image
        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders/images', 'public');
        }
        $data['status'] = $request->has('status') ? $request->status : 1;
        Slider::create($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider ajoutée avec succès.');
    }


    public function edit($id){
        $slider = Slider::findOrFail($id);
        $languages = Language::all();
        return view('backend.admin.sliders.edit', compact('slider', 'languages'));
    }


    public function updateStatus($id, Request $request){
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['success' => false, 'message' => 'Introuvable.'], 404);
        }
        $slider->status = $request->input('status');
        $slider->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }

    public function update(Request $request, $id) {
        $slider = Slider::findOrFail($id);
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'language_id' => 'nullable|exists:languages,id',
            'page_id' => 'nullable|exists:pages,id',
            'page' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position' => 'nullable|integer',
            'link' => 'nullable|url|max:255',
        ]);

        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders/images', 'public');
        }
        $data['status'] = $request->has('status') ? $request->status : 1;
        $slider->update($data);

        return redirect()->route('admin.sliders')->with('success', 'Slider mis à jour avec succès.');
    }

    public function delete($id) {
        $slider = Slider::findOrFail($id);
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return redirect()->route('admin.sliders')->with('success', 'Slider supprimé avec succès.');
    }

}
