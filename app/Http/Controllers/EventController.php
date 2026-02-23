<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Event;
use App\Models\Language;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EventController extends Controller {

    public function index() {
        $events = Event::where('status', 1)
            ->with(['category'])->withCount('views')
            ->orderByDesc('created_at')->orderByDesc('id')->get();
        return view('frontend.events.index', compact('events'));
    }


   public function show(Event $event) {
        // Compter la vue
        if (method_exists($event, 'registerView')) {
            $event->registerView();
        }

        // Relations nécessaires à la page
        $event->load([
            'category',
            'country',
            'language',
            'media',                // Spatie Media Library
            'ticketTypes' => function ($q) {
                $q->where('is_active', true)->orderBy('price');
            },
        ])->loadCount('views');

        // Types actifs
        // $types = $event->ticketTypes ?? collect();

        $types = $event->ticketTypes()
        ->withCount(['tickets as available_tickets_count' => fn($q) => $q->where('status','available')])
        ->get();


        // Prix minimal (si pas de types, fallback sur event->price)
        $minPrice = null;
        if ($types->isNotEmpty()) {
            $minPrice = $types->min('price');
        } else {
            if (!is_null($event->price ?? null)) {
                $minPrice = (float) $event->price;
            }
        }

        // Événements liés (même catégorie)
        $related = Event::query()
            ->where('status', 1)
            ->where('id', '!=', $event->id)
            ->when($event->category_id, function ($q) use ($event) {
                $q->where('category_id', $event->category_id);
            })
            ->orderByDesc('start_date')
            ->take(6)
            ->get();

        // “safe” variables de base pour le Blade
        $title = $event->title ?? $event->name;
        $categoryName = optional($event->category)->name;
        $countryName  = optional($event->country)->name;
        $languageName = optional($event->language)->name;

        // Dates texte
        $dateText = '';
        if (!empty($event->start_date) && !empty($event->end_date)) {
            $sameMonth = $event->start_date->format('mY') === $event->end_date->format('mY');
            if ($sameMonth) {
                $dateText = $event->start_date->translatedFormat('d') . '–' . $event->end_date->translatedFormat('d M Y');
            } else {
                $dateText = $event->start_date->translatedFormat('d M Y') . ' — ' . $event->end_date->translatedFormat('d M Y');
            }
        } elseif (!empty($event->start_date)) {
            $dateText = $event->start_date->translatedFormat('d M Y');
        }

        // État événement (terminé ?)
        $eventEnded = false;
        if (!empty($event->end_date)) {
            $eventEnded = now()->greaterThan($event->end_date->copy()->endOfDay());
        }

        return view('frontend.events.show', compact(
            'event',
            'types',
            'related',
            'title',
            'categoryName',
            'countryName',
            'languageName',
            'dateText',
            'minPrice',
            'eventEnded'
        ));
    }


    // public function show(Event $event) {
    //     $event->registerView();
    //     $event->load([
    //         'category', 'country', 'language',
    //         'media',
    //     ])->loadCount('views');

    //     $related = Event::where('status', 1)
    //         ->where('id', '!=', $event->id)
    //         ->when($event->category_id, fn($q) => $q->where('category_id', $event->category_id))
    //         ->latest('start_date')->take(6)->get();

    //     return view('frontend.events.show', compact('event', 'related'));
    // }

}
