@extends('backend.admin.layouts.master')
@section('title') Détails soumission #{{ $submission->id }} @endsection

@section('content')

<div class="row align-items-center mb-4">
  <div class="d-md-flex d-sm-block justify-content-between align-items-center flex-wrap">
    <h6 class="fw-medium d-inline-flex align-items-center mb-3 mb-sm-0">
      <a href="{{ route('admin.submissions.index') }}"><i class="ti ti-arrow-left me-2"></i>Retour</a>
    </h6>
    <div class="d-flex">
      @if(($submission->status->slug ?? 'pending') === 'pending')
        <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}"
              onsubmit="return confirm('Approuver cette soumission ?');" class="me-2">
          @csrf
          <button class="btn btn-success"><i class="ti ti-check me-1"></i>Approuver</button>
        </form>

        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
          <i class="ti ti-x me-1"></i>Rejeter
        </button>
      @endif
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-4">
    <div class="card mb-3">
      <div class="card-header"><h6 class="mb-0">Métadonnées</h6></div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-5">ID</dt><dd class="col-7">#{{ $submission->id }}</dd>
          <dt class="col-5">Modèle</dt><dd class="col-7">{{ class_basename($submission->model_type) }} @if($submission->model_id)#{{ $submission->model_id }}@endif</dd>
          <dt class="col-5">Operation</dt><dd class="col-7"><span class="badge bg-gray-100 text-dark">{{ $submission->operation }}</span></dd>
          <dt class="col-5">Compte</dt><dd class="col-7">#{{ $submission->account_id }}</dd>
          <dt class="col-5">Soumis par</dt><dd class="col-7">
            @if($submission->user) {{ $submission->user->lastname ?? '' }} {{ $submission->user->firstname ?? '' }} @else — @endif
          </dd>
          <dt class="col-5">Statut</dt>
          <dd class="col-7">
            @php $slug = $submission->status->slug ?? 'pending'; @endphp
            <span class="badge
              @if($slug==='pending') bg-warning
              @elseif($slug==='approved') bg-success
              @elseif($slug==='rejected') bg-danger
              @else bg-secondary @endif">
              {{ $submission->status->status ?? ucfirst($slug) }}
            </span>
          </dd>
          <dt class="col-5">Soumise</dt><dd class="col-7">{{ optional($submission->submitted_at)->format('d/m/Y H:i') ?? $submission->created_at->format('d/m/Y H:i') }}</dd>
          @if($submission->reviewed_at)
            <dt class="col-5">Revue le</dt><dd class="col-7">{{ $submission->reviewed_at->format('d/m/Y H:i') }}</dd>
          @endif
          @if($submission->comment)
            <dt class="col-5">Commentaire</dt><dd class="col-7">{{ $submission->comment }}</dd>
          @endif
        </dl>
      </div>
    </div>
  </div>

  <div class="col-xl-8">
    <div class="card mb-3">
      <div class="card-header"><h6 class="mb-0">Changements proposés</h6></div>
      <div class="card-body">
        @if($submission->changes)
          <pre class="bg-light p-3 rounded border" style="white-space: pre-wrap;">{{ json_encode($submission->changes, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
        @else
          <em>Aucun payload (opération {{ $submission->operation }})</em>
        @endif
      </div>
    </div>

    @if($submission->before)
      <div class="card">
        <div class="card-header"><h6 class="mb-0">Avant (snapshot)</h6></div>
        <div class="card-body">
          <pre class="bg-light p-3 rounded border" style="white-space: pre-wrap;">{{ json_encode($submission->before, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
      </div>
    @endif
  </div>
</div>

{{-- Modal Rejet --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.submissions.reject', $submission) }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Rejeter la soumission</h5>
        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="ti ti-x"></i>
        </button>
      </div>
      <div class="modal-body">
        <label class="form-label">Motif (optionnel)</label>
        <textarea name="comment" class="form-control" rows="4" placeholder="Expliquez brièvement la raison du rejet..."></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Annuler</button>
        <button class="btn btn-danger" type="submit">Rejeter</button>
      </div>
    </form>
  </div>
</div>

@endsection
