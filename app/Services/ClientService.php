<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ClientService {
    /**
     * Trouve par email ou crée un client à partir des données fournies.
     * Retourne [Client $client, ?string $plainPasswordSiCree]
     */
    public function ensure(array $data): array {
        // normalisation minimale
        $email = strtolower(trim($data['email'] ?? ''));
        if (!$email) {
            throw new \InvalidArgumentException('Email requis pour ensure client.');
        }

        $client = User::where('email', $email)->first();
        $plain = null;
        if (!$client) {
            $plain = Str::random(8);
            $client = User::create([
                'firstname' => $data['firstname'] ?? '',
                'lastname'  => $data['lastname'] ?? '',
                'email'     => $email,
                'phone'     => $data['phone'] ?? null,
                'password'  => bcrypt($plain),
                'status'    => 1,
            ]);


            // stock session (format array safe pour Blade)
            Auth::login($client);

            // email de bienvenue (non bloquant)
            try {
                if (class_exists(\App\Mail\ClientWelcomeMail::class)) {
                    Mail::to($client->email)
                        ->send(new \App\Mail\ClientWelcomeMail($client, $plain));
                }
            } catch (\Throwable $e) {
                Log::error('Mail bienvenue client: '.$e->getMessage());
            }
        } else {
            // met à jour infos basiques si fournies
            $client->fill([
                'firstname' => $data['firstname'] ?? $client->firstname,
                'lastname'  => $data['lastname']  ?? $client->lastname,
                'phone'     => $data['phone']     ?? $client->phone,
            ])->save();

            Auth::login($client);
        }
        return [$client, $plain];
    }


    /** Helper pratique depuis un Request */
    public function ensureFromRequest(Request $request): array {
        return $this->ensure($request->only([
            'firstname','lastname','email','phone','shipping_address'
        ]));
    }
}
