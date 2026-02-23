<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;


class ClientRegisterController extends Controller {

    public function store(Request $request) {
        $data = $request->validate([
            'firstname' => ['required','string','max:255'],
            'lastname'  => ['required','string','max:255'],
            'email'     => ['required','email','max:255','unique:users,email'],
            'password'  => ['required','confirmed','min:6'],
            'phone'     => 'nullable|regex:/^(\+?\d{1,3})?\d{8,15}$/',
        ]);

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'password'  => Hash::make($data['password']),
        ]);


        Auth::login($user);
        //  event(new Registered($user));

        // Si le modèle User implémente MustVerifyEmail, on envoie la notif
        if ($user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice')->with('info', 'verification-link-sent');
        }

        // Sinon, on redirige selon droits
        return redirect()->intended('/');
    }
}
