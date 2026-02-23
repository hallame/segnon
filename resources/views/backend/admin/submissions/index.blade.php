@extends('backend.admin.layouts.master')
@section('title') Soumissions @endsection

@section('content')

<div class="row align-items-center mb-4">
  <div class="d-md-flex d-sm-block justify-content-between align-items-center flex-wrap">
    <h6 class="fw-medium d-inline-flex align-items-center mb-3 mb-sm-0">
      <i class="ti ti-inbox me-2"></i>Soumissions à modérer
    </h6>
    <div class="d-flex">
      <div class="text-end">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
          <i class="ti ti-circle-arrow-up me-1"></i>Tableau de bord
        </a>
      </div>
    </div>
  </div>
</div>



{{-- Filtres --}}
<div class="card mb-3">
  <div class="card-body p-3">
    <form method="GET" action="{{ route('admin.submissions.index') }}" class="row g-2 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Statut</label>
        @php $currentStatus = request('status'); @endphp
        <select name="status" class="form-select">
          <option value="">Tous</option>
          <option value="pending"  {{ $currentStatus==='pending'  ? 'selected' : '' }}>En attente</option>
          <option value="approved" {{ $currentStatus==='approved' ? 'selected' : '' }}>Approuvées</option>
          <option value="rejected" {{ $currentStatus==='rejected' ? 'selected' : '' }}>Rejetées</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Type de modèle</label>
        <select name="model_type" class="form-select">
          <option value="">Tous</option>
          <option value="hotel" {{ request('model_type')==='hotel' ? 'selected' : '' }}>Hôtel</option>
          {{-- ajoute d’autres types ici si nécessaire : room, product, … --}}
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Account ID</label>
        <input type="number" name="account_id" value="{{ request('account_id') }}" class="form-control" placeholder="ID du compte">
      </div>

      <div class="col-md-3">
        <button class="btn btn-outline-secondary me-2" type="submit">
          <i class="ti ti-filter"></i> Filtrer
        </button>
        <a href="{{ route('admin.submissions.index') }}" class="btn btn-light">
          Réinitialiser
        </a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    @if ($subs->isEmpty())
      @include('partials.empty')
    @else
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Modèle</th>
              <th>Operation</th>
              <th>Compte</th>
              <th>Par</th>
              <th>Statut</th>
              <th>Soumise</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach($subs as $s)

            <tr>
              <td>#{{ $s->id }}</td>
              <td>
                    @if (class_basename($s->model_type) == 'Product')
                        @if($s->model)
                            <div class="d-flex align-items-center">
                                <a href="{{ route('admin.products.edit', $s->model) }}" class="avatar flex-shrink-0">
                                    <img src="{{ $s->model->featured_image }}" class="rounded-circle border border-2" alt="{{ $s->model->name }}">
                                </a>
                                <div class="ms-1">
                                    <div class="fw-semibold">{{ Str::limit($s->model->name, 30) }}</div>
                                    <div class="text-muted small">{{ $s->model->category->name ?? '—' }}</div>
                                </div>
                            </div>
                        @endif
                    @else
                        {{ class_basename($s->model_type) }} @if($s->model_id) #{{ $s->model_id }} @endif
                        <div class="text-muted small">
                            @if($s->model)
                                @php
                                    $label = $s->model->name ?? $s->model->title ?? null;
                                @endphp
                                {{ $label ? Str::limit($label, 60) : '' }}
                            @endif
                        </div>
                    @endif
                </td>
              {{-- <td>
                @if (class_basename($s->model_type) == 'Product')
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.products.edit',$s) }}" class="avatar flex-shrink-0">
                            <img src="{{ $s->featured_image }}" class="rounded-circle border border-2" alt="{{ $s->name }}">
                        </a>
                        <div class="ms-1">
                            <div class="fw-semibold">{{ Str::limit($s->name, 30) }}</div>
                            <div class="text-muted small">{{ $p->category->name ?? '—' }}</div>
                        </div>
                    </div>
                @endif




                {{ class_basename($s->model_type) }} @if($s->model_id) #{{ $s->model_id }} @endif
                <div class="text-muted small">
                  @if($s->model)
                    @php
                      $label = $s->model->name ?? $s->model->title ?? null;
                    @endphp
                    {{ $label ? Str::limit($label, 60) : '' }}
                  @endif
                </div>
              </td> --}}
              <td><span class="badge bg-gray-100 text-dark">{{ $s->operation }}</span></td>
              <td>
                @if(method_exists($s,'account') && $s->relationLoaded('account') && $s->account)
                  {{ $s->account->name }} ({{ $s->account_id }})
                @else
                  #{{ $s->account_id }}
                @endif
              </td>
              <td>
                @if($s->user) {{ $s->user->lastname ?? '' }} {{ $s->user->firstname ?? '' }} @else — @endif
              </td>
              <td>
                @php $slug = $s->status->slug ?? 'pending'; @endphp
                <span class="badge
                  @if($slug==='pending') bg-warning
                  @elseif($slug==='approved') bg-success
                  @elseif($slug==='rejected') bg-danger
                  @else bg-secondary @endif">
                  {{ $s->status->status ?? ucfirst($slug) }}
                </span>
              </td>
              <td>{{ optional($s->submitted_at)->format('d/m/Y H:i') ?? $s->created_at->format('d/m/Y H:i') }}</td>
              <td class="d-flex align-items-center gap-1 flex-nowrap text-nowrap">

                <a class="btn btn-sm btn-info border" href="{{ route('admin.submissions.show', $s) }}" title="Détails">
                  <i class="ti ti-eye"></i>
                </a>

                @if(($s->status->slug ?? 'pending') === 'pending')
                  <form method="POST" action="{{ route('admin.submissions.approve', $s) }}" onsubmit="return confirm('Approuver cette soumission ?');">
                    @csrf
                    <button class="btn btn-sm btn-success" type="submit" title="Approuver">
                      <i class="ti ti-check"></i>
                    </button>
                  </form>

                  <button class="btn btn-sm btn-danger" title="Rejeter"
                          data-bs-toggle="modal" data-bs-target="#rejectModal"
                          data-action="{{ route('admin.submissions.reject', $s) }}">
                    <i class="ti ti-x"></i>
                  </button>
                @endif

              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-end mt-3">
        {{ $subs->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
</div>

{{-- Modal Rejet --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" id="rejectForm">
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const rejectModal = document.getElementById('rejectModal');
    rejectModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        document.getElementById('rejectForm').setAttribute('action', action);
    });
    });
</script>

@endsection
