<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class AdminTicketTypeController extends Controller {
    public function index() {
        $types = TicketType::with('event')->latest()->paginate(20);
        return view('backend.tickets.types.index', compact('types'));
    }

    public function create() {
        $events = Event::orderBy('name')->get();
        return view('backend.tickets.types.create', compact('events'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['account_id'] = auth()->user()->account_id ?? null;

        TicketType::create($validated);

        return redirect()->route('admin.ticket_types')->with('success', 'Type de ticket créé avec succès.');
    }

    public function edit($id)
    {
        $type = TicketType::findOrFail($id);
        $events = Event::orderBy('name')->get();
        return view('backend.tickets.types.edit', compact('type', 'events'));
    }

    public function update(Request $request, $id)
    {
        $type = TicketType::findOrFail($id);

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $type->update($validated);

        return redirect()->route('admin.ticket_types')->with('success', 'Type de ticket mis à jour.');
    }

    public function destroy($id)
    {
        TicketType::findOrFail($id)->delete();
        return back()->with('success', 'Type de ticket supprimé.');
    }
}
