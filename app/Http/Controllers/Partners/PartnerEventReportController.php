<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Support\CurrentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class PartnerEventReportController extends Controller {

    private function accountId(): int {
        return (int) app(CurrentAccount::class)->id();
    }

    public function index(Request $request) {
        $accountId = $this->accountId();

        // Période (défaut : 30 derniers jours)
        $start = $request->filled('start')
            ? Carbon::parse($request->input('start'))->startOfDay()
            : now()->subDays(30)->startOfDay();

        $end = $request->filled('end')
            ? Carbon::parse($request->input('end'))->endOfDay()
            : now()->endOfDay();

        // Existence des tables billetterie (pour éviter tout crash si pas encore migré)
        $hasOrders    = Schema::hasTable('orders')    && Schema::hasColumn('orders','event_id');
        $hasAttendees = Schema::hasTable('attendees') && Schema::hasColumn('attendees','event_id');
        $hasCheckins  = Schema::hasTable('checkins')  && Schema::hasColumn('checkins','attendee_id');

        // KPIs "contenu" toujours disponibles
        $eventsBase = DB::table('events')->where('account_id', $accountId);
        $now        = now();

        $contentMetrics = [
            'events_total'    => (clone $eventsBase)->count(),
            'events_upcoming' => (clone $eventsBase)->where('start_date','>', $now)->count(),
            'events_live'     => (clone $eventsBase)->where('start_date','<=',$now)->where('end_date','>=',$now)->count(),
            'events_past'     => (clone $eventsBase)->where('end_date','<',  $now)->count(),
        ];

        // KPIs billetterie (si tables présentes)
        $sales = [
            'revenue'   => null,
            'orders'    => null,
            'attendees' => null,
            'checkins'  => null,
        ];
        $topEvents = collect();
        $byDay     = collect();

        if ($hasOrders) {
            $ordersQ = DB::table('orders')
                ->where('account_id', $accountId)
                ->whereNotNull('event_id')
                ->whereBetween('created_at', [$start, $end])
                ->where('payment_status', 'paid');

            $sales['revenue'] = (float) (clone $ordersQ)->sum('total');
            $sales['orders']  = (int)   (clone $ordersQ)->count();

            // Top événements par CA
            $topEvents = (clone $ordersQ)
                ->select('event_id', DB::raw('SUM(total) as revenue'), DB::raw('COUNT(*) as orders'))
                ->groupBy('event_id')
                ->orderByDesc('revenue')
                ->limit(7)
                ->get();

            // Série par jour (revenue, orders)
            $byDay = (clone $ordersQ)
                ->selectRaw('DATE(created_at) as d, SUM(total) as revenue, COUNT(*) as orders')
                ->groupBy('d')
                ->orderBy('d')
                ->get();
        }

        if ($hasAttendees) {
            $attQ = DB::table('attendees')
                ->whereBetween('created_at', [$start, $end]);
            $sales['attendees'] = (int) $attQ->count();
        }

        if ($hasCheckins && $hasAttendees) {
            // join simple pour compter les check-ins associés à des attendees d'événements
            $sales['checkins'] = (int) DB::table('checkins as c')
                ->join('attendees as a','a.id','=','c.attendee_id')
                ->whereBetween('c.scanned_at', [$start, $end])
                ->count();
        }

        // Pour nommer les events dans "topEvents"
        $eventNames = DB::table('events')
            ->where('account_id', $accountId)
            ->pluck('name','id');

        return view('backend.event.reports.index', [
            'start'        => $start,
            'end'          => $end,
            'content'      => $contentMetrics,
            'sales'        => $sales,
            'topEvents'    => $topEvents,
            'eventNames'   => $eventNames,
            'byDay'        => $byDay,
            'flags'        => compact('hasOrders','hasAttendees','hasCheckins'),
        ]);
    }

    public function export(Request $request) {
        $accountId = $this->accountId();

        $start = $request->filled('start')
            ? Carbon::parse($request->input('start'))->startOfDay()
            : now()->subDays(30)->startOfDay();

        $end = $request->filled('end')
            ? Carbon::parse($request->input('end'))->endOfDay()
            : now()->endOfDay();

        $hasOrders = Schema::hasTable('orders') && Schema::hasColumn('orders','event_id');

        $file = 'event-reports-'.now()->format('Ymd_His').'.csv';
        return response()->streamDownload(function () use ($hasOrders, $accountId, $start, $end) {
            $out = fopen('php://output', 'w');
            echo chr(0xEF).chr(0xBB).chr(0xBF); // BOM UTF-8

            if ($hasOrders) {
                // Export par événement (CA + nb commandes sur la période)
                fputcsv($out, ['Event ID','Nom','Revenu','Commandes']);
                $rows = DB::table('orders')
                    ->join('events','events.id','=','orders.event_id')
                    ->where('orders.account_id', $accountId)
                    ->whereNotNull('orders.event_id')
                    ->where('orders.payment_status','paid')
                    ->whereBetween('orders.created_at', [$start, $end])
                    ->groupBy('orders.event_id','events.name')
                    ->select('orders.event_id','events.name',
                        DB::raw('SUM(orders.total) as revenue'),
                        DB::raw('COUNT(*) as orders'))
                    ->orderByDesc('revenue')
                    ->get();

                foreach ($rows as $r) {
                    fputcsv($out, [$r->event_id, $r->name, number_format((float)$r->revenue,2,'.',''), $r->orders]);
                }
            } else {
                // Export fallback : liste des événements de la période
                fputcsv($out, ['Event ID','Nom','Début','Fin','Lieu','Statut']);
                DB::table('events')
                    ->where('account_id', $accountId)
                    ->whereBetween('start_date', [$start, $end])
                    ->orderBy('start_date')
                    ->chunk(500, function ($chunk) use ($out) {
                        foreach ($chunk as $e) {
                            fputcsv($out, [
                                $e->id, $e->name, $e->start_date, $e->end_date, $e->location, $e->status ? 'Actif':'Inactif'
                            ]);
                        }
                    });
            }
            fclose($out);
        }, $file, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
