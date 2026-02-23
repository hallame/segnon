<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\BotService;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;

class BotController extends Controller {

    protected BotService $bot;

    public function __construct(BotService $bot) {
        $this->bot = $bot;
    }

    public function search(Request $request) {
        $validated = $request->validate([
            'query' => ['required','string','min:2','max:500'],
        ]);
        try {
            $results = $this->bot->search($validated['query']);
            return response()->json([
                'results' => $results,
                'count'   => count($results),
            ]);
        } catch (\Throwable $e) {
            Log::error('MBot Search Error', [
                'msg'   => $e->getMessage(),
                'ip'    => $request->ip(),
                'ua'    => $request->userAgent(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Ne divulgue pas l’exception en prod :
            return response()->json([
                'error' => '❌ Erreur lors de la recherche.',
            ], 500);
        }
    }

}
