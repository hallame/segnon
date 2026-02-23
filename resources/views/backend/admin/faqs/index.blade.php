{{-- resources/views/backend/admin/faqs/index.blade.php --}}
@extends('backend.admin.layouts.master')

@section('title', 'FAQs')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0">FAQs</h1>

    {{-- Filtres --}}
    <form method="get" class="d-flex flex-wrap align-items-center gap-2">
        <div>
            <label for="filter_q" class="visually-hidden">Rechercher</label>
            <input id="filter_q" type="text" name="q" class="form-control"
                value="{{ request('q') }}" placeholder="Rechercher..." style="min-width: 220px;">
        </div>

        <div>
            <label for="filter_category_id" class="visually-hidden">Catégorie</label>
            <select id="filter_category_id" name="category_id" class="form-select">
            <option value="">Catégorie — Toutes</option>
            @foreach($categories as $id => $name)
                <option value="{{ $id }}" @selected((string)request('category_id') === (string)$id)>{{ $name }}</option>
            @endforeach
            </select>
        </div>

        {{-- Si besoin de réactiver le filtre compte, décommentez :
        <div>
            <label for="filter_account_id" class="visually-hidden">Compte</label>
            <select id="filter_account_id" name="account_id" class="form-select">
            <option value="">Compte — Tous</option>
            @foreach($accounts as $id => $name)
                <option value="{{ $id }}" @selected((string)request('account_id') === (string)$id)>{{ $name }}</option>
            @endforeach
            </select>
        </div>
        --}}

        <div>
            <label for="filter_active" class="visually-hidden">Statut</label>
            <select id="filter_active" name="active" class="form-select">
            <option value=""  @selected(request('active') === null || request('active') === '')>Actif — Tous</option>
            <option value="1" @selected(request('active') === '1')>Actifs</option>
            <option value="0" @selected(request('active') === '0')>Inactifs</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" type="submit">Filtrer</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-light border">Réinitialiser</a>
        </div>
    </form>

  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Ajouter</button>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<div class="table-responsive">
<table class="table align-middle">
  <thead class="table-light">
    <tr>
      <th style="width:110px;">Position</th>
      <th>Question</th>
      <th style="width:200px;">Catégorie</th>
      {{-- <th style="width:200px;">Compte</th> --}}
      <th style="width:120px;">Actif</th>
      <th class="text-end" style="width:160px;">Actions</th>
    </tr>
  </thead>
  <tbody id="faqRows">
    @forelse($faqs as $faq)
      <tr data-id="{{ $faq->id }}" draggable="true">
        <td class="text-muted">
          <span class="me-2" aria-label="Glisser pour réordonner" title="Glisser pour réordonner" style="cursor:grab;">⋮⋮</span>
          <span class="row-position">{{ $faq->position }}</span>
        </td>
        <td class="fw-semibold">{{ $faq->question }}</td>
        <td>{{ $faq->category->name ?? '—' }}</td>
        {{-- <td>{{ $faq->account->name  ?? '—' }}</td> --}}
        <td>
          <form action="{{ route('admin.faqs.toggle', $faq) }}" method="post">
            @csrf @method('PATCH')
            <button class="btn btn-sm {{ $faq->active ? 'btn-success' : 'btn-outline-secondary' }}">
              {{ $faq->active ? 'Actif' : 'Inactif' }}
            </button>
          </form>
        </td>
        <td class="text-end">
          <button
            class="btn btn-sm btn-edit"
            data-bs-toggle="modal"
            data-bs-target="#editModal"
            data-id="{{ $faq->id }}"
            data-question="{{ $faq->question }}"
            data-answer='@json($faq->answer)'
            data-category-id="{{ $faq->category_id ?? '' }}"
            data-account-id="{{ $faq->account_id ?? '' }}"
            data-position="{{ $faq->position }}"
            data-active="{{ $faq->active ? 1 : 0 }}"
          > <i class="ti ti-edit fs-20 text-secondary"></i></button>

          <form action="{{ route('admin.faqs.destroy', $faq) }}" method="post" class="d-inline"
                onsubmit="return confirm('Supprimer cette FAQ ?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm "><i class="ti ti-trash fs-20 text-danger"></i></button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center text-muted py-4">Aucune FAQ trouvée.</td>
      </tr>
    @endforelse
  </tbody>
</table>
</div>

<div class="mt-3">
    {{ $faqs->withQueryString()->links('pagination::bootstrap-5') }}
</div>

{{-- Modal Create --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="post" action="{{ route('admin.faqs.store') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Nouvelle FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-12">
          <label for="question_new" class="form-label">Question</label>
          <input id="question_new" name="question" type="text" class="form-control" required maxlength="255" value="{{ old('question') }}">
        </div>
        <div class="col-12">
          <label for="answer_new" class="form-label">Réponse</label>
          <textarea id="answer_new" name="answer" class="form-control" rows="6" required>{{ old('answer') }}</textarea>
        </div>

        <div class="col-md-6">
          <label for="category_id_new" class="form-label">Catégorie</label>
          <select id="category_id_new" name="category_id" class="form-select">
            <option value="">— Aucune —</option>
            @foreach($categories as $id => $name)
              <option value="{{ $id }}" @selected(old('category_id') == $id)>{{ $name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="account_id_new" class="form-label">Compte</label>
          <select id="account_id_new" name="account_id" class="form-select">
            <option value="">— Aucun —</option>
            @foreach($accounts as $id => $name)
              <option value="{{ $id }}" @selected(old('account_id') == $id)>{{ $name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <label for="position_new" class="form-label">Position</label>
          <input id="position_new" name="position" type="number" min="0" class="form-control" value="{{ old('position', 0) }}">
        </div>

        <div class="col-md-4 d-flex align-items-end">
          <div class="form-check">
            <input type="hidden" name="active" value="0">
            <input id="active_new" name="active" type="checkbox" value="1" class="form-check-input" @checked(old('active', true))>
            <label for="active_new" class="form-check-label">Actif</label>
          </div>
        </div>

        <div class="col-md-4">
          <label for="slug_new" class="form-label">Slug (optionnel)</label>
          <input id="slug_new" name="slug" type="text" class="form-control" maxlength="255" value="{{ old('slug') }}" placeholder="auto si vide">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button class="btn btn-primary">Créer</button>
      </div>
    </form>
  </div>
</div>
{{-- /Modal Create --}}

{{-- Modal Edit (unique, alimenté dynamiquement) --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editForm" class="modal-content" method="post" action="#">
      @csrf @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Modifier FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-12">
          <label for="question_edit" class="form-label">Question</label>
          <input id="question_edit" name="question" type="text" class="form-control" required maxlength="255">
        </div>
        <div class="col-12">
          <label for="answer_edit" class="form-label">Réponse</label>
          <textarea id="answer_edit" name="answer" class="form-control" rows="6" required></textarea>
        </div>

        <div class="col-md-6">
          <label for="category_id_edit" class="form-label">Catégorie</label>
          <select id="category_id_edit" name="category_id" class="form-select">
            <option value="">— Aucune —</option>
            @foreach($categories as $id => $name)
              <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="account_id_edit" class="form-label">Compte</label>
          <select id="account_id_edit" name="account_id" class="form-select">
            <option value="">— Aucun —</option>
            @foreach($accounts as $id => $name)
              <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <label for="position_edit" class="form-label">Position</label>
          <input id="position_edit" name="position" type="number" min="0" class="form-control">
        </div>

        <div class="col-md-4 d-flex align-items-end">
          <div class="form-check">
            <input type="hidden" name="active" value="0">
            <input id="active_edit" name="active" type="checkbox" value="1" class="form-check-input">
            <label for="active_edit" class="form-check-label">Actif</label>
          </div>
        </div>

        <div class="col-md-4">
          <label for="slug_edit" class="form-label">Slug (optionnel)</label>
          <input id="slug_edit" name="slug" type="text" class="form-control" maxlength="255" placeholder="auto si vide">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
  </div>
</div>
{{-- /Modal Edit --}}



<script>
  // URLs modèles (pour action du form d'édition + endpoint de réordonnancement)
  const updateUrlTemplate = "{{ route('admin.faqs.update', 0) }}"; // remplacé par l'ID à la fin
  const reorderUrl        = "{{ route('admin.faqs.reorder') }}";
  const csrfToken         = "{{ csrf_token() }}";

  // Remplit le modal d'édition à l'ouverture
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
      const id    = btn.dataset.id;
      const form  = document.getElementById('editForm');

      form.action = updateUrlTemplate.replace(/\/0$/, '/' + id);

      document.getElementById('question_edit').value   = btn.dataset.question || '';
      document.getElementById('answer_edit').value     = JSON.parse(btn.dataset.answer || '""');
      document.getElementById('category_id_edit').value= btn.dataset.categoryId || '';
      document.getElementById('account_id_edit').value = btn.dataset.accountId || '';
      document.getElementById('position_edit').value   = btn.dataset.position || 0;
      document.getElementById('active_edit').checked   = btn.dataset.active === '1';
      document.getElementById('slug_edit').value       = btn.dataset.slug || '';
    });
  });

  // ---- Drag & Drop natif pour réordonner ----
  const tbody = document.getElementById('faqRows');

  let dragRow = null;
  tbody.addEventListener('dragstart', (e) => {
    const tr = e.target.closest('tr');
    if (!tr) return;
    dragRow = tr;
    tr.classList.add('opacity-50');
    e.dataTransfer.effectAllowed = 'move';
  });

  tbody.addEventListener('dragover', (e) => {
    e.preventDefault();
    const targetRow = e.target.closest('tr');
    if (!dragRow || !targetRow || dragRow === targetRow) return;

    const rect = targetRow.getBoundingClientRect();
    const before = (e.clientY - rect.top) < rect.height / 2;
    if (before) {
      targetRow.parentNode.insertBefore(dragRow, targetRow);
    } else {
      targetRow.parentNode.insertBefore(dragRow, targetRow.nextSibling);
    }
  });

  tbody.addEventListener('dragend', async () => {
    if (!dragRow) return;
    dragRow.classList.remove('opacity-50');
    dragRow = null;

    // Recalcule les positions affichées
    updatePositionsUI();

    // Envoie l'ordre au backend
    const ids = Array.from(tbody.querySelectorAll('tr[data-id]')).map(tr => tr.dataset.id);
    try {
      await fetch(reorderUrl, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
        body: JSON.stringify({ items: ids })
      });
    } catch (e) {
      console.error(e);
      alert("Impossible d'enregistrer le nouvel ordre.");
    }
  });

  function updatePositionsUI() {
    let i = 0;
    tbody.querySelectorAll('tr .row-position').forEach(span => { span.textContent = i++; });
  }
</script>
@endsection

