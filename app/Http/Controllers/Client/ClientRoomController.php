<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Category;



class ClientRoomController extends Controller {

    public function index(Request $request) {
        $request->validate([
            'q'          => ['nullable','string','max:100'],
            'hotel'      => ['nullable','string'], // id ou slug
            'category'   => ['nullable','string'], // id ou slug
            'price_min'  => ['nullable','numeric','min:0'],
            'price_max'  => ['nullable','numeric','min:0'],
            'capacity'   => ['nullable','integer','min:1'],
            'city'       => ['nullable','string','max:100'],
            'sort'       => ['nullable','in:price_asc,price_desc,capacity_desc,newest'],
        ]);

        $query = Room::query()
            ->with([
                'hotel:id,name,slug,city',
                'category:id,name,slug'
            ])
            ->where('status', 1);

        // Recherche plein texte simple
        if ($s = trim((string) $request->q)) {
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                ->orWhere('description', 'like', "%{$s}%")
                ->orWhere('address', 'like', "%{$s}%");
            });
        }

        // Filtre hôtel (id ou slug)
        if ($hotel = $request->hotel) {
            if (is_numeric($hotel)) {
                $query->where('hotel_id', $hotel);
            } else {
                $query->whereHas('hotel', fn($q) => $q->where('slug', $hotel));
            }
        }

        // Filtre catégorie (id ou slug)
        if ($cat = $request->category) {
            if (is_numeric($cat)) {
                $query->where('category_id', $cat);
            } else {
                $query->whereHas('category', fn($q) => $q->where('slug', $cat));
            }
        }

        // Prix
        if ($min = $request->price_min) {
            $query->where('price', '>=', $min);
        }
        if ($max = $request->price_max) {
            $query->where('price', '<=', $max);
        }

        // Capacité minimale
        if ($cap = $request->capacity) {
            $query->where('capacity', '>=', $cap);
        }

        // Ville (via l’hôtel)
        if ($city = trim((string) $request->city)) {
            $query->whereHas('hotel', fn($q) => $q->where('city', 'like', "%{$city}%"));
        }

        // Tri
        switch ($request->sort) {
            case 'price_asc':     $query->orderBy('price', 'asc'); break;
            case 'price_desc':    $query->orderBy('price', 'desc'); break;
            case 'capacity_desc': $query->orderBy('capacity', 'desc'); break;
            case 'newest':        $query->latest(); break;
            default:              $query->latest('rooms.id'); break;
        }

        $rooms = $query->paginate(24)->appends($request->query());

        // Pour les selects / chips
        $hotels = Hotel::where('status', 1)->select('id','name','slug')->orderBy('name')->get();
        $categories = Category::where('model', 'Room')->select('id','name','slug')->orderBy('name')->get();
        return view('frontend.hotels.rooms.index', compact('rooms','hotels','categories'));
    }

    public function show(Room $room) {
        $room->load([ 'hotel', 'category', 'images', 'reviews']);
        $room->registerView();
        return view('frontend.hotels.rooms.show', compact('room'));
    }



}
