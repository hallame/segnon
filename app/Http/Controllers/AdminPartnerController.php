<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;


class AdminPartnerController extends Controller {

    public function partners(){
        $totalPartners = Partner::count();
        $activePartners = Partner::where('status', 1)->count();
        $inactivePartners = Partner::where('status', 0)->count();
        $partners = Partner::latest()->get();
        return view('backend.admin.partners.index', compact('partners', 'totalPartners', 'activePartners', 'inactivePartners'));
    }

    public function createPartner(Request $request){
        $request->validate([
            'company'     => 'required|string|max:255',
            'address'     => 'required|string|max:500',
            'email'       => 'required|email|max:255|unique:partners,email',
            'phone'       => ['required', 'regex:/^(\+?\d{1,3})?\d{8,15}$/'],
            'logo'        => 'required|image|max:2048',
            'contact'     => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ], [
            'company.required'     => 'Le nom de l\'entreprise est obligatoire.',
            'company.string'       => 'Le nom de l\'entreprise doit être une chaîne de caractères.',
            'company.max'          => 'Le nom de l\'entreprise ne peut pas dépasser :max caractères.',

            'address.required'     => 'L\'adresse complète est obligatoire.',
            'address.string'       => 'L\'adresse doit être une chaîne de caractères.',
            'address.max'          => 'L\'adresse ne peut pas dépasser :max caractères.',

            'email.required'       => 'L\'adresse e-mail est obligatoire.',
            'email.email'          => 'Veuillez entrer une adresse e-mail valide.',
            'email.unique'         => 'Cette adresse e-mail est déjà utilisée.',
            'email.max'            => 'L\'adresse e-mail ne peut pas dépasser :max caractères.',

            'phone.required'       => 'Le numéro de téléphone est obligatoire.',
            'phone.regex'          => 'Le numéro de téléphone est invalide.',

            'logo.required'        => 'Le logo de l\'entreprise est obligatoire.',
            'logo.image'           => 'Le fichier du logo doit être une image valide.',
            'logo.max'             => 'Le logo ne peut pas dépasser 2 Mo.',

            'contact.string'       => 'Le contact doit être une chaîne de caractères.',
            'contact.max'          => 'Le contact ne peut pas dépasser :max caractères.',

            'description.string'   => 'La description doit être une chaîne de caractères.',
            'description.max'      => 'La description ne peut pas dépasser :max caractères.',
        ]);

        // Création du partenaire
        $partner = new Partner();
        $partner->company     = $request->company;
        $partner->address     = $request->address;
        $partner->email       = $request->email;
        $partner->phone       = $request->phone;
        $partner->contact     = $request->contact;
        $partner->description = $request->description;

        // Gestion du fichier logo
        if ($request->hasFile('logo')) {
            $logoFile  = $request->file('logo');
            $filename  = time() . '_' . Str::random(10) . '.' . $logoFile->getClientOriginalExtension();
            $filePath  = $logoFile->storeAs('partners', $filename, 'public');
            $partner->logo = $filePath;
        }
        $partner->save();
        return redirect()->back()->with('success', 'Le partenaire a été créé avec succès.');
    }

    public function updatePartner(Request $request, $id) {
        $partner = Partner::findOrFail($id);

        // Validation des champs correspondant au formulaire
        $request->validate([
            'company'     => 'required|string|max:255',
            'address'     => 'required|string|max:500',
            'email'       => 'required|email|max:255|unique:partners,email,' . $id,
            'phone'       => ['required', 'regex:/^(\+?\d{1,3})?\d{8,15}$/'],
            'logo'        => 'nullable|image|max:2048',
            'contact'     => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:255',
        ], [
            'company.required'     => 'Le nom de l\'entreprise est obligatoire.',
            'company.string'       => 'Le nom de l\'entreprise doit être une chaîne de caractères.',
            'company.max'          => 'Le nom de l\'entreprise ne peut pas dépasser :max caractères.',

            'address.required'     => 'L\'adresse complète est obligatoire.',
            'address.string'       => 'L\'adresse doit être une chaîne de caractères.',
            'address.max'          => 'L\'adresse ne peut pas dépasser :max caractères.',

            'email.required'       => 'L\'adresse e-mail est obligatoire.',
            'email.email'          => 'Veuillez entrer une adresse e-mail valide.',
            'email.unique'         => 'Cette adresse e-mail est déjà utilisée par un autre partenaire.',
            'email.max'            => 'L\'adresse e-mail ne peut pas dépasser :max caractères.',

            'phone.required'       => 'Le numéro de téléphone est obligatoire.',
            'phone.regex'          => 'Le numéro de téléphone est invalide.',

            'logo.image'           => 'Le fichier du logo doit être une image valide.',
            'logo.max'             => 'Le logo ne peut pas dépasser 2 Mo.',

            'contact.string'       => 'Le contact doit être une chaîne de caractères.',
            'contact.max'          => 'Le contact ne peut pas dépasser :max caractères.',

            'description.string'   => 'La description doit être une chaîne de caractères.',
            'description.max'      => 'La description ne peut pas dépasser :max caractères.',

            'website.url' => 'Le format de l’adresse du site web est invalide. Veuillez renseigner une URL commençant par http:// ou https://.',
            'website.max' => 'L’URL du site ne peut pas dépasser 255 caractères.',
        ]);

        // Si un nouveau logo est uploadé, supprimer l'ancien et stocker le nouveau
        if ($request->hasFile('logo')) {
            if ($partner->logo && file_exists(storage_path('app/public/' . $partner->logo))) {
                unlink(storage_path('app/public/' . $partner->logo));
            }
            $logoPath = $request->file('logo')->store('partners', 'public');
            $partner->logo = $logoPath;
        }

        // Mise à jour des autres champs
        $partner->company     = $request->company;
        $partner->address     = $request->address;
        $partner->email       = $request->email;
        $partner->phone       = $request->phone;
        $partner->contact     = $request->contact;
        $partner->description = $request->description;
        $partner->save();

        return redirect()->back()->with('success', 'Partenaire mis à jour avec succès.');
    }

    public function deletePartner($id) {
        $partner = Partner::find($id);
        if (! $partner) {
            return redirect()->back()->with('error', 'Le partenaire choisi n\'existe pas.');
        }
        if ($partner->logo && file_exists(storage_path('app/public/' . $partner->logo))) {
            unlink(storage_path('app/public/' . $partner->logo));
        }
        $partner->delete();
        return redirect()->back()->with('success', 'Le partenaire a été supprimé avec succès.');
    }

}
