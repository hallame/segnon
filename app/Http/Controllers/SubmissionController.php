<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentSubmission;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\ModerationStatus;
use App\Models\Product;
use App\Models\Room;
use App\Models\Site;
use App\Services\SubmissionService;
use Illuminate\Http\Request;

class SubmissionController extends Controller {


    public function index(Request $request) {
        $q = ContentSubmission::with(['model','status'])->latest();

        if ($request->filled('status')) {
            $statusId = ModerationStatus::idFor($request->string('status')->toString());
            if ($statusId) $q->where('status_id', $statusId);
        }

        if ($request->filled('account_id')) {
            $q->where('account_id', (int) $request->input('account_id'));
        }

        if ($request->filled('model_type')) {
            $type = $request->string('model_type')->toString();
            $map  = [
                'hotel' => Hotel::class,
                'room' => Room::class,
                'product' => Product::class,
                'event' => Event::class,
            ];
            $q->where('model_type', $map[$type] ?? $type);
        }

        $subs = $q->paginate(20);
        return view('backend.admin.submissions.index', compact('subs'));
    }

    public function show(ContentSubmission $submission) {
        $submission->load('model','status');
        return view('backend.admin.submissions.show', compact('submission'));
    }


    public function approve(ContentSubmission $submission, SubmissionService $service) {
        $service->approve($submission);
        return back()->with('success','Soumission approuvée et appliquée.');
    }

    public function reject(ContentSubmission $submission, Request $request, SubmissionService $service) {
        $service->reject($submission, $request->string('comment')->toString() ?: null);
        return back()->with('success','Soumission rejetée.');
    }
}
