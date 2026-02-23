<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PartnerSettingController extends Controller {

    

    public function edit() {
        $user = Auth::user();
        return view('backend.partners.settings', compact('user'));
    }

    public function update(Request $r) {
        $r->validate([
            'current_password' => ['required','current_password'],
            'password'         => ['required','string','min:8','confirmed','different:current_password'],
        ]);
        $r->user()->update(['password' => Hash::make($r->input('password'))]);
        return back()->with('success', 'Mot de passe mis à jour.');
    }

}
