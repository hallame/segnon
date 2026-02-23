<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Social;
use App\HasFilters;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Support\Str;
use App\Models\Category;


class AdminSocialController extends Controller {
        use HasFilters;

    public function socials(Request $request){
        $socials = Social::all();
        $total = $socials->count();
        $active = $socials->where('status', 1)->count();
        $inactive = $socials->where('status', 0)->count();

        return view('backend.admin.socials', compact('socials', 'total', 'active', 'inactive'));
    }
    public function add(Request $request) {
        // Validation dynamique selon la sélection
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => [
                'required',
                'string', // toujours une chaîne
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->name !== 'text' && !filter_var($value, FILTER_VALIDATE_URL)) {
                        $fail('Le lien doit être une URL valide.');
                    }
                },
                'max:255',
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'icon' => 'nullable|string|max:255', // Correction ici aussi : icon est du texte (ex: une classe CSS)
        ]);

        // Vérifie si un réseau social avec ce nom existe déjà
        if (Social::where('name', $request->name)->exists()) {
            return back()->with('error', 'Ce réseau social existe déjà.');
        }

        $social = new Social();
        $social->name = $request->name;
        $social->url = $request->url;
        $social->icon = $request->icon;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('socials', $filename, 'public');
            $social->image = $path;
        }

        $social->save();

        return redirect()->route('admin.socials')->with('success', 'Réseau social ajouté avec succès.');
    }

    public function updateStatus($id, Request $request){
        $social = Social::find($id);
        if (!$social) {
            return response()->json(['success' => false, 'message' => 'Introuvable.'], 404);
        }
        $social->status = $request->input('status');
        $social->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }

    public function delete($id){
        $social = Social::find($id);

        if (!$social) {
            return back()->with('error', 'Réseau social introuvable.');
        }
        $imagePath = public_path('uploads/socials/' . $social->image);
        if ($social->image && file_exists($imagePath)) {
            unlink($imagePath);
        }
        $social->delete();
        return back()->with('success', 'Réseau social supprimé avec succès.');
    }

}
