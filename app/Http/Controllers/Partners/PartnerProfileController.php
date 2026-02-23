<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\User;
use App\Support\CurrentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class PartnerProfileController extends Controller {


    public function edit() {
        $user = Auth::user();
        return view('backend.partners.profile', compact('user'));
    }

    public function update(Request $r) {
        $user = Auth::user();

        $data = $r->validate([
            'firstname' => ['required','string','max:120'],
            'lastname'  => ['required','string','max:120'],
            'phone'     => ['nullable','string','max:60'],
            'whatsapp'  => ['nullable','string','max:60'],
            'email'     => ['nullable','email','max:190', Rule::unique('users','email')->ignore($user->id)],
        ]);

        // 1) Mise à jour User
        $user->fill($data)->save();

        // 2) (Optionnel) Sync côté Guide du compte courant
        $guide = Guide::query()
            ->where('account_id', app(CurrentAccount::class)->id())
            ->where('user_id', $user->id)
            ->first();

        if ($guide) {
            $guide->fill([
                'firstname' => $data['firstname'],
                'lastname'  => $data['lastname'] ?? $guide->lastname,
                'phone'     => $data['phone'] ?? $guide->phone,
                'whatsapp'  => $data['whatsapp'] ?? $guide->whatsapp,
                'email'     => $data['email'] ?? $guide->email,
            ])->save();
        }

        return back()->with('success', 'Profil mis à jour.');
    }



}
