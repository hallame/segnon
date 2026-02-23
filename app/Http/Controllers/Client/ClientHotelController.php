<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;

class ClientHotelController extends Controller {

    public function index() {
        $hotels = Hotel::where('status', 1)->with('rooms')->paginate(24);
        return view('frontend.hotels.index', compact('hotels'));
    }


    public function show(Hotel $hotel) {
        $rooms = Room::where('hotel_id', $hotel->id)->paginate(24);
        $hotel->registerView();
        return view('frontend.hotels.show', compact('hotel', 'rooms'));
    }

}
