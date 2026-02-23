<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;
use App\HasFilters;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller {

    use HasFilters;

    /**
     * Construit une base de clé lisible depuis le type + détails (+ name en fallback).
     * Ex:
     *   mobile_money + operator=orange  => mobile_money_orange
     *   bank_transfer + bank_name=CORIS => bank_transfer_coris
     *   card + provider=Stripe          => card_stripe
     *   cash/cod                        => {type}_{slug(name)}
     */
    private function buildBaseKey(string $type, array $details, string $name): string {
        $suffix = match ($type) {
            'mobile_money'  => $details['operator'] ?? null,   // attendu en slug: orange/mtn/...
            'bank_transfer' => $details['bank_name'] ?? null,
            'card'          => $details['provider'] ?? null,
            default         => $name, // cash, cod : on se base sur le nom affiché
        };

        $base = $type;
        if ($suffix) {
            $base .= '_' . Str::slug($suffix, '_');
        }

        // sécurité alpha_dash + normalisation
        $base = strtolower($base);
        $base = preg_replace('/[^a-z0-9_]+/', '_', $base);
        $base = preg_replace('/_+/', '_', $base);
        return trim($base, '_');
    }

    /**
     * Garantit l'unicité en ajoutant un suffixe numérique si nécessaire.
     * mobile_money_orange -> mobile_money_orange_2, _3, ...
     */
    private function makeUniqueKey(string $base, int $maxLen = 64): string {
        $key = Str::limit($base, $maxLen, '');
        $i = 2;

        while (PaymentMethod::where('key', $key)->exists()) {
            $suffix  = '_' . $i;
            $trimLen = max(1, $maxLen - strlen($suffix));
            $key = Str::limit($base, $trimLen, '') . $suffix;
            $i++;
        }

        return $key;
    }

    public function index() {
        $methods   = PaymentMethod::with(['mobileMoney','bank','cash','card','cod'])
                     ->orderBy('position')->orderBy('id')->get();
        $allActive = $methods->count() > 0 && $methods->every(fn($m) => $m->active);
        return view('backend.admin.payment_methods', compact('methods','allActive'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'type'         => ['required','in:mobile_money,bank_transfer,cash,card,cod'],
            'name'         => ['required','string','max:255'],
            'instructions' => ['nullable','string'],
            'icon'         => ['nullable','string','max:255'],
            'position'     => ['nullable','integer','min:0'],
            'active'       => ['nullable'],
        ]);

        // règles spécifiques par type
        $byTypeRules = [
            'mobile_money' => [
                'details.operator'       => ['required','string','max:50'],
                'details.wallet_number'  => ['required','string','max:100'],
                'details.wallet_name'    => ['nullable','string','max:100'],
                'details.qr'             => ['nullable','string','max:255'],
                'details.reference_hint' => ['nullable','string','max:255'],
            ],
            'bank_transfer' => [
                'details.bank_name'      => ['required','string','max:120'],
                'details.holder'         => ['required','string','max:120'],
                'details.iban'           => ['required','string','max:120'],
                'details.bic'            => ['nullable','string','max:50'],
                'details.reference_hint' => ['nullable','string','max:255'],
            ],
            'cash' => [
                'details.address' => ['required','string','max:255'],
                'details.hours'   => ['nullable','string','max:120'],
                'details.phone'   => ['nullable','string','max:50'],
            ],
            'card' => [
                'details.provider'   => ['required','string','max:80'],
                'details.public_key' => ['nullable','string','max:255'],
                'details.secret_key' => ['nullable','string','max:255'],
            ],
            'cod'  => [
                'details.phone' => ['nullable','string','max:50'],
                'details.note'  => ['nullable','string','max:255'],
            ],
        ];
        $request->validate($byTypeRules[$data['type']]);



        $details = $request->input('details', []);
        $baseKey = $this->buildBaseKey($data['type'], $details, $data['name']);
        $key     = $this->makeUniqueKey($baseKey);

        DB::transaction(function () use ($request, $data, $key) {
            $method = PaymentMethod::create([
                'type'         => $data['type'],
                'key'          => $key,
                'name'         => $data['name'],
                'instructions' => $data['instructions'] ?? null,
                'icon'         => $data['icon'] ?? null,
                'position'     => $data['position'] ?? 0,
                'active'       => $request->boolean('active'),
            ]);

            $d = $request->input('details', []);

            match ($data['type']) {
                'mobile_money' => $method->mobileMoney()->create([
                    'operator'       => $d['operator'],
                    'wallet_number'  => $d['wallet_number'],
                    'wallet_name'    => $d['wallet_name'] ?? null,
                    'qr'             => $d['qr'] ?? null,
                    'reference_hint' => $d['reference_hint'] ?? null,
                ]),
                'bank_transfer' => $method->bank()->create([
                    'bank_name'      => $d['bank_name'],
                    'holder'         => $d['holder'],
                    'iban'           => $d['iban'],
                    'bic'            => $d['bic'] ?? null,
                    'reference_hint' => $d['reference_hint'] ?? null,
                ]),
                'cash' => $method->cash()->create([
                    'address' => $d['address'],
                    'hours'   => $d['hours'] ?? null,
                    'phone'   => $d['phone'] ?? null,
                ]),
                'card' => $method->card()->create([
                    'provider'   => $d['provider'],
                    'public_key' => $d['public_key'] ?? null,
                    'secret_key' => $d['secret_key'] ?? null,
                ]),
                'cod' => $method->cod()->create([
                    'phone' => $d['phone'] ?? null,
                    'note'  => $d['note'] ?? null,
                ]),
                default => null
            };
        });

        return redirect()->route('admin.payment_methods.index')->with('success','Moyen de paiement ajouté.');
    }

    public function update(Request $request, PaymentMethod $payment_method) {
        $data = $request->validate([
            'type'         => ['required','in:mobile_money,bank_transfer,cash,card,cod'],
            'name'         => ['required','string','max:255'],
            'instructions' => ['nullable','string'],
            'icon'         => ['nullable','string','max:255'],
            'position'     => ['nullable','integer','min:0'],
            'active'       => ['nullable'],
        ]);
        $byTypeRules = [
            'mobile_money' => [
                'details.operator'       => ['required','string','max:50'],
                'details.wallet_number'  => ['required','string','max:100'],
                'details.wallet_name'    => ['nullable','string','max:100'],
                'details.qr'             => ['nullable','string','max:255'],
                'details.reference_hint' => ['nullable','string','max:255'],
            ],
            'bank_transfer' => [
                'details.bank_name'      => ['required','string','max:120'],
                'details.holder'         => ['required','string','max:120'],
                'details.iban'           => ['required','string','max:120'],
                'details.bic'            => ['nullable','string','max:50'],
                'details.reference_hint' => ['nullable','string','max:255'],
            ],
            'cash' => [
                'details.address' => ['required','string','max:255'],
                'details.hours'   => ['nullable','string','max:120'],
                'details.phone'   => ['nullable','string','max:50'],
            ],
            'card' => [
                'details.provider'   => ['required','string','max:80'],
                'details.public_key' => ['nullable','string','max:255'],
                'details.secret_key' => ['nullable','string','max:255'],
            ],
            'cod'  => [
                'details.phone' => ['nullable','string','max:50'],
                'details.note'  => ['nullable','string','max:255'],
            ],
        ];
        $request->validate($byTypeRules[$data['type']]);

        DB::transaction(function () use ($request, $payment_method, $data) {
            $payment_method->update([
                'type'         => $data['type'],
                'name'         => $data['name'],
                'instructions' => $data['instructions'] ?? null,
                'icon'         => $data['icon'] ?? null,
                'position'     => $data['position'] ?? 0,
                'active'       => $request->boolean('active'),
            ]);

            $d = $request->input('details', []);

            // supprime/replace proprement la table de détail si le type a changé
            foreach (['mobileMoney','bank','cash','card','cod'] as $rel) {
                $payment_method->{$rel}()->delete();
            }

            match ($data['type']) {
                'mobile_money' => $payment_method->mobileMoney()->create([
                    'operator'       => $d['operator'],
                    'wallet_number'  => $d['wallet_number'],
                    'wallet_name'    => $d['wallet_name'] ?? null,
                    'qr'             => $d['qr'] ?? null,
                    'reference_hint' => $d['reference_hint'] ?? null,
                ]),
                'bank_transfer' => $payment_method->bank()->create([
                    'bank_name'      => $d['bank_name'],
                    'holder'         => $d['holder'],
                    'iban'           => $d['iban'],
                    'bic'            => $d['bic'] ?? null,
                    'reference_hint' => $d['reference_hint'] ?? null,
                ]),
                'cash' => $payment_method->cash()->create([
                    'address' => $d['address'],
                    'hours'   => $d['hours'] ?? null,
                    'phone'   => $d['phone'] ?? null,
                ]),
                'card' => $payment_method->card()->create([
                    'provider'   => $d['provider'],
                    'public_key' => $d['public_key'] ?? null,
                    'secret_key' => $d['secret_key'] ?? null,
                ]),
                'cod' => $payment_method->cod()->create([
                    'phone' => $d['phone'] ?? null,
                    'note'  => $d['note'] ?? null,
                ]),
                default => null
            };
        });

        return redirect()->route('admin.payment_methods.index')->with('success','Moyen de paiement mis à jour.');
    }

    public function destroy(PaymentMethod $payment_method) {
        if ($payment_method->payments()->exists()) {
            return back()->with('error', 'Impossible de supprimer. Ce moyens de paiement est utilisé. Vous pouvez simplement le désactiver.');
        }
        $payment_method->delete(); // cascade supprime le détail
        return redirect()->route('admin.payment_methods.index')->with('success','Moyen de paiement supprimé.');
    }



    public function toggleStatus(Request $request, PaymentMethod $payment_method) {
        $validated = $request->validate([
            'active' => ['required', 'in:0,1'],
        ]);

        $payment_method->update(['active' => (bool) $validated['active']]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour.',
            'data'    => [
                'id'     => $payment_method->id,
                'active' => (bool) $validated['active'],
            ],
        ]);
    }
}
