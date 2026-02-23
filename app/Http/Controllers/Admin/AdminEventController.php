<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Country;
use App\Models\Event;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Storage;


class AdminEventController extends Controller {

    public function index(){
        $now = now();
        $languages = Language::get();
        $categories = Category::where('status', 1)->where(fn($q) => $q->where('model',['event', 'Event'])->orWhereNull('model'))->get();;
        $countries = Country::where('status', 1)->get();

        // Statistiques
        $totalEvents = Event::count();
        $activeEvents = Event::where('status', 1)->count();
        $inactiveEvents = Event::where('status', 0)->count();
        $upcomingEvents = Event::where('start_date', '>', $now)->count();
        $pastEvents = Event::where('end_date', '<', $now)->count();
        $currentEvents = Event::where('start_date', '<=', $now)->where('end_date', '>=', $now)->count();

        // Statistiques par langue (exemple avec FR et EN si tu veux les afficher)
        $eventByLanguage = Event::select('language_id', DB::raw('count(*) as total'))
            ->groupBy('language_id')
            ->get();

        // Statistiques par catégorie
        $eventByCategory = Event::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->get();

        // Liste complète des événements
        $events = Event::with(['category', 'language'])->orderBy('created_at', 'desc')->paginate(20);

        return view('backend.admin.events.index', compact(
            'events',
            'totalEvents',
            'upcomingEvents',
            'pastEvents',
            'currentEvents',
            'eventByLanguage',
            'eventByCategory',
            'totalEvents', 'activeEvents', 'inactiveEvents',
            'languages', 'categories', 'countries',
        ));
    }


    public function create(){
        $languages = Language::all();
        $categories = Category::query()->where('status', 1)
                    ->where(fn($q) => $q->whereIn('model', ['event','Event'])->orWhereNull('model'))
                    ->orderBy('name')->get();
        return view('backend.admin.events.create', compact('languages', 'categories'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'start_date'  => 'required|date',
            'price' => 'nullable|numeric',

            'end_date'    => 'required|date|after_or_equal:start_date',
            'description' => 'required|string',
            'video'       => 'nullable|file|mimes:mp4,avi,mkv,flv|max:50000',
            'video_url'   => 'nullable|url|max:255',
        ]);

        $event = new Event();
        $event->fill(Arr::except($validated, ['image','video']));

        // slug garanti par le modèle, mais on peut le fixer ici aussi au cas où
        if (empty($event->slug)) {
            $event->slug = Event::generateUniqueSlug($event->name);
        }

        // Image
        $event->image = $request->file('image')->store('events', 'public');

        // Vidéo (optionnelle)
        if ($request->hasFile('video')) {
            $event->video = $request->file('video')->store('videos/events', 'public');
        }

        // Statut par défaut
        $event->status = 1;

        $event->save();

        return redirect()->route('media.index', [
            'type' => 'event',
            'key'  => $event->slug ?: $event->getKey(),
        ])->with('success', 'Événement ajouté avec succès. Veuillez maintenant ajouter des images.');
    }

    public function updateStatus($id, Request $request){
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Introuvable.'], 404);
        }

        // Met à jour le statut
        $event->status = $request->input('status');
        $event->save();
        return response()->json(['success' => true, 'message' => 'Statut mis à jour avec succès.']);
    }


    public function edit($id){
        $event = Event::findOrFail($id);
        $languages = Language::all();
        $categories = Category::query()->where('status', 1)
                    ->where(fn($q) => $q->whereIn('model', ['event','Event'])->orWhereNull('model'))
                    ->orderBy('name')->get();
        return view('backend.admin.events.edit', compact('event', 'languages', 'categories'));
    }

    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);

        $data = $request->validate([
            'name'         => 'sometimes|required|string|max:255',
            'location'     => 'sometimes|required|string|max:255',
            'language_id'  => 'sometimes|required|exists:languages,id',
            'category_id'  => 'sometimes|nullable|exists:categories,id',
            'start_date'   => 'sometimes|required|date',
            'end_date'     => 'sometimes|required|date|after_or_equal:start_date',
            'description'  => 'sometimes|required|string',
            'price' => 'nullable|numeric',
            'image'        => 'sometimes|nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video'        => 'sometimes|nullable|file|mimes:mp4,avi,mkv,flv|max:50000',
            'video_url'    => 'sometimes|nullable|url|max:255',
        ]);

        // Champs simples
        $event->fill(Arr::except($data, ['image','video']));
        if (empty($event->slug)) {
            $event->slug = Event::generateUniqueSlug($event->name);
        }

        // Image
        if ($request->hasFile('image')) {
            if ($event->image && \Storage::disk('public')->exists($event->image)) {
                \Storage::disk('public')->delete($event->image);
            }
            $event->image = $request->file('image')->store('events', 'public');
        }

        // Vidéo
        if ($request->hasFile('video')) {
            if ($event->video && \Storage::disk('public')->exists($event->video)) {
                \Storage::disk('public')->delete($event->video);
            }
            $event->video = $request->file('video')->store('videos/events', 'public');
        }

        // URL vidéo
        if ($request->has('video_url')) {
            $event->video_url = $request->input('video_url');
        }
        $event->save();

        return redirect()->route('admin.events.index')->with('success', 'Événement mis à jour.');
    }


    public function delete($id){
        $event = Event::find($id);
        if (!$event) {
            return back()->with('error', 'Événement introuvable.');
        }
        if ($event->image && file_exists(public_path('uploads/events/' . $event->image))) {
            unlink(public_path('uploads/events/' . $event->image));
        }
        $event->bookings()->delete();
        $event->reviews()->delete();
        $event->views()->delete();
        $event->delete();

        return back()->with('success', 'Événement supprimé avec succès.');
    }
}
