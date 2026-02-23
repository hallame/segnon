<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HasFilters;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Contact;
use Illuminate\Routing\Controller;

class ContactController extends Controller {
    use HasFilters;

    public function contacts(Request $request){
        $contacts = Contact::all();

        $total = $contacts->count();
        $active = $contacts->where('status', 1)->count();
        $inactive = $contacts->where('status', 0)->count();

        return view('backend.admin.contacts', compact('contacts', 'total', 'active', 'inactive'));
    }

    public function add(Request $request) {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => $request->name === 'image'
                ? 'required|file|mimes:jpeg,png,jpg,webp|max:2048' // si image : fichier image obligatoire
                : 'required|string|max:255', // sinon : texte simple
        ]);

        $contact = new Contact();
        $contact->name = $request->name;

        if ($request->name === 'image') {
            // Si c'est une image, on gère l'upload
            if ($request->hasFile('value')) {
                $image = $request->file('value');
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('contacts', $filename, 'public');
                $contact->value = $path; // Stocker le chemin de l'image dans value
            }
            $contact->url = null; // Pas de lien URL pour une image
        } else {
            // Sinon, c'est du texte
            $contact->value = $request->value;

            // Générer l'URL selon le type
            if ($request->name == 'phone') {
                $contact->url = 'tel:' . $request->value;
            } elseif ($request->name == 'email') {
                $contact->url = 'mailto:' . $request->value;
            } elseif ($request->name == 'address') {
                $contact->url = null;
            } elseif ($request->name == 'whatsapp') {
                $contact->url = 'https://wa.me/' . $request->value;
            } else {
                $contact->url = null;
            }
        }

        $contact->save();

        return redirect()->route('admin.contacts')->with('success', 'Contact ajouté avec succès.');
    }


    public function updateStatus($id, Request $request){
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Hôtel introuvable.'], 404);
        }
        $contact->status = $request->input('status');
        $contact->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }

    public function delete($id){
        $contact = Contact::find($id);

        if (!$contact) {
            return back()->with('error', 'Contact introuvable.');
        }
        $imagePath = public_path('uploads/contacts/' . $contact->image);
        if ($contact->image && file_exists($imagePath)) {
            unlink($imagePath);
        }
        $contact->delete();
        return back()->with('success', 'Contact supprimé avec succès.');
    }
}
