<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;


class AdminTicketController extends Controller {

    public function index(Request $request)
    {
        // --- Filtres ---
        $query = Ticket::with(['event', 'ticketType']);

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('ticket_type_id')) {
            $query->where('ticket_type_id', $request->ticket_type_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('id', $q)
                    ->orWhere('qr_code', 'like', "%{$q}%");
            });
        }

        $tickets = $query->latest()->paginate(30)->withQueryString();

        // --- Stats globales ---
        $stats = [
            'total'     => Ticket::count(),
            'available' => Ticket::where('status', 'available')->count(),
            'reserved'  => Ticket::where('status', 'reserved')->count(),
            'sold'      => Ticket::where('status', 'sold')->count(),
            'used'      => Ticket::where('status', 'used')->count(),
        ];

        $events = Event::orderBy('name')->get();
        $types  = TicketType::orderBy('name')->get();

        $filters = [
            'event_id'      => $request->event_id,
            'ticket_type_id'=> $request->ticket_type_id,
            'status'        => $request->status,
            'q'             => $request->q,
        ];

        return view('backend.admin.tickets.index', compact(
            'tickets',
            'stats',
            'events',
            'types',
            'filters'
        ));
    }

    public function create() {
        $events = Event::orderBy('name')->get();
        $types = TicketType::orderBy('name')->get();
        return view('backend.admin.tickets.create', compact('events', 'types'));
    }

    public function getTicketTypes(Event $event) {
        $types = $event->ticketTypes()->select('id','name')->get();
        return response()->json($types);
    }


    public function store(Request $request) {
        $validated = $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|string',
        ]);

        $type = TicketType::findOrFail($validated['ticket_type_id']);
        // Vérifier combien de tickets existent déjà
        $existing = $type->tickets()->count();
        if ($type->quantity !== null && $existing >= $type->quantity) {
            return back()->with('error', "Tous les tickets pour ce type sont déjà générés.");
        }

        Ticket::create($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket ajouté avec succès.');
    }


    public function show($id) {
        $ticket = Ticket::with(['ticketType', 'event'])->findOrFail($id);
        return view('backend.admin.tickets.show', compact('ticket'));
    }

    public function destroy($id) {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->status !== 'available') {
            return back()->with('error', "Impossible de supprimer un ticket déjà {$ticket->status}.");
        }

        $ticket->delete();
        return back()->with('success', 'Ticket supprimé.');
    }

}
