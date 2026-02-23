<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Route, Storage};
use Illuminate\Support\Str;



class AdminTicketTypeController extends Controller {
    public function index(Request $request) {
        // --- Filtres ---
        $query = TicketType::with('event');

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('active')) {
            if ($request->active === '1') {
                $query->where('is_active', true);
            } elseif ($request->active === '0') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            });
        }

        $types = $query->latest()->paginate(20)->withQueryString();

        // --- Stats globales (tous les types) ---
        $stats = [
            'total_types'      => TicketType::count(),
            'active_types'     => TicketType::where('is_active', true)->count(),
            'inactive_types'   => TicketType::where('is_active', false)->count(),
            'total_capacity'   => TicketType::whereNotNull('quantity')->sum('quantity'), // seulement les quotas définis
        ];

        // Pour le filtre par événement
        $events = Event::orderBy('name')->get();

        return view('backend.admin.tickets.types.index', [
            'types'  => $types,
            'stats'  => $stats,
            'events' => $events,
            'filters' => [
                'event_id' => $request->event_id,
                'active'   => $request->active,
                'q'        => $request->q,
            ],
        ]);
    }


    public function create() {
        $events = Event::orderBy('name')->get();
        return view('backend.admin.tickets.types.create', compact('events'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'event_id'       => 'required|exists:events,id',
            'name'           => 'required|string|max:255',
            'sku'            => 'nullable|string|max:255',
            'price'          => 'required|numeric|min:0',
            'quantity'       => 'nullable|integer|min:0',
            'description'    => 'nullable|string',
            'features'       => 'nullable|array',
            'features.*'     => 'string|max:255',
            'is_refundable'  => 'sometimes|boolean',
            'is_active'      => 'sometimes|boolean',
            'sales_start'    => 'nullable|date',
            'sales_end'      => 'nullable|date|after_or_equal:sales_start',
            'max_per_order'  => 'nullable|integer|min:1',
            'metadata'       => 'nullable|array',
        ]);

        $validated['account_id'] = Auth::user()->account_id ?? null;

        TicketType::create($validated);

        return redirect()->route('admin.ticket_types.index')->with('success', 'Type de ticket créé avec succès.');
    }

    public function edit($id) {
        $type = TicketType::findOrFail($id);
        $events = Event::orderBy('name')->get();
        return view('backend.admin.tickets.types.edit', compact('type', 'events'));
    }



    public function update(Request $request, $id) {
        $type = TicketType::findOrFail($id);

        $validated = $request->validate([
            'event_id'       => 'required|exists:events,id',
            'name'           => 'required|string|max:255',
            'sku'            => 'nullable|string|max:255',
            'price'          => 'required|numeric|min:0',
            'quantity'       => 'nullable|integer|min:0',
            'description'    => 'nullable|string',
            'features'       => 'nullable|array',
            'features.*'     => 'string|max:255',
            'is_refundable'  => 'sometimes|boolean',
            'is_active'      => 'sometimes|boolean',
            'sales_start'    => 'nullable|date',
            'sales_end'      => 'nullable|date|after_or_equal:sales_start',
            'max_per_order'  => 'nullable|integer|min:1',
            'metadata'       => 'nullable|array',
        ]);

        $type->update($validated);

        return redirect()->route('admin.ticket_types.index')->with('success', 'Type de ticket mis à jour.');
    }




    public function generateTickets($id) {
        $type = TicketType::findOrFail($id);

        $existing = $type->tickets()->count();
        $toGenerate = $type->quantity ? $type->quantity - $existing : 0;

        if ($toGenerate <= 0) {
            return back()->with('info', 'Tous les tickets sont déjà générés.');
        }

        for ($i = 0; $i < $toGenerate; $i++) {
            $type->tickets()->create([
                'event_id' => $type->event_id,
                'status' => 'available',
                'qr_code' => Str::uuid(),
            ]);
        }

        return back()->with('success', "$toGenerate tickets générés pour ce type.");
    }


    public function destroy($id) {
        $type = TicketType::findOrFail($id);

        if ($type->tickets()->whereIn('status', ['sold', 'reserved', 'used'])->exists()) {
            return back()->with('error', "Impossible de supprimer ce type : certains tickets ont déjà été vendus ou utilisés.");
        }

        // Optionnel : supprimer uniquement les tickets disponibles
        $type->tickets()->where('status', 'available')->delete();

        $type->delete();

        return back()->with('success', 'Type de ticket supprimé.');
    }

}
