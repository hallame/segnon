@php
  /** @var \App\Models\Page|null $page */
  $isEdit   = isset($page) && $page->exists;
  $action   = $isEdit ? route('admin.page.update', $page->id) : route('admin.page.store');
  $btnLabel = $isEdit ? 'Mettre à jour' : 'Enregistrer';

  // Types autorisés dans le select (tu peux en ajouter)
  $typeOptions = [
    'people'    => 'Communautés: Peuples',
    'merveille' => 'Merveilles de Guinée',
    'other'     => 'Autre',
  ];

  // Verrouiller le type pour certaines pages système
  $lockedTypes = ['about','community','home'];
  $lockType    = $isEdit && in_array($page->type, $lockedTypes, true);
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="pageForm">
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div class="modal-body pb-0">
    <div class="row">

      {{-- Titre --}}
      <div class="col-md-6 mb-3">
        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control"
               value="{{ old('title', $page->title ?? '') }}" required>
      </div>

      {{-- Sous-titre --}}
      <div class="col-md-6 mb-3">
        <label for="subtitle" class="form-label">Sous-titre</label>
        <input type="text" name="subtitle" id="subtitle" class="form-control"
               value="{{ old('subtitle', $page->subtitle ?? '') }}">
      </div>

      {{-- Langue --}}
      <div class="col-md-3 mb-3">
        <label for="language_id" class="form-label">Langue <span class="text-danger">*</span></label>
        <select name="language_id" id="language_id" class="form-control" required>
          @foreach($languages as $lang)
            <option value="{{ $lang->id }}"
              @selected((int)old('language_id', $page->language_id ?? 1) === (int)$lang->id)>{{ $lang->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- Type --}}
      <div class="col-md-3 mb-3">
        <label class="form-label">Type de page {{ $lockType ? '(verrouillé)' : '' }}</label>
        @if($lockType)
          <input type="hidden" name="type" value="{{ $page->type }}">
          <input type="text" class="form-control" value="{{ ucfirst($page->type) }}" readonly>
        @else
          <select name="type" id="type" class="form-control" required>
            <option value="" disabled {{ old('type', $page->type ?? '')==='' ? 'selected' : '' }}>Sélectionner</option>
            @foreach($typeOptions as $val => $label)
              <option value="{{ $val }}" @selected(old('type', $page->type ?? '') === $val)>{{ $label }}</option>
            @endforeach
          </select>
        @endif
      </div>

      {{-- Image --}}
      <div class="col-md-6 mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        @if($isEdit && $page->image)
          <div class="mt-2">
            <img src="{{ asset('storage/'.$page->image) }}" alt="Image actuelle" width="110" class="rounded border">
          </div>
        @endif
      </div>

      {{-- Bannière --}}
      <div class="col-md-6 mb-3">
        <label for="banner" class="form-label">Bannière</label>
        <input type="file" name="banner" id="banner" class="form-control" accept="image/*">
        @if($isEdit && $page->banner)
          <div class="mt-2">
            <img src="{{ asset('storage/'.$page->banner) }}" alt="Bannière actuelle" width="110" class="rounded border">
          </div>
        @endif
      </div>

      {{-- Vidéo URL --}}
      <div class="col-md-6 mb-3">
        <label for="video_url" class="form-label">URL de la vidéo</label>
        <input type="url" name="video_url" id="video_url" class="form-control"
               value="{{ old('video_url', $page->video_url ?? '') }}" placeholder="https://...">
      </div>

      {{-- Vidéo upload --}}
      <div class="col-md-6 mb-3">
        <label for="video" class="form-label">Vidéo (optionnelle)</label>
        <input type="file" name="video" id="video" class="form-control" accept="video/*">
        @if($isEdit && $page->video)
          <div class="mt-2">
            <video width="180" controls>
              <source src="{{ asset('storage/'.$page->video) }}">
            </video>
          </div>
        @endif
      </div>

      {{-- Meta --}}
      <div class="col-md-6 mb-3">
        <label for="meta_title" class="form-label">Meta Title</label>
        <input type="text" name="meta_title" id="meta_title" class="form-control"
               value="{{ old('meta_title', $page->meta_title ?? '') }}">
      </div>
      <div class="col-md-6 mb-3">
        <label for="meta_description" class="form-label">Meta Description</label>
        <input type="text" name="meta_description" id="meta_description" class="form-control"
               value="{{ old('meta_description', $page->meta_description ?? '') }}">
      </div>
      <div class="col-md-6 mb-3">
        <label for="meta_keywords" class="form-label">Meta Keywords</label>
        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
               value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}" placeholder="tourisme, culture, Guinée">
      </div>

      {{-- Citation --}}
      <div class="col-md-12 mb-3">
        <label for="info" class="form-label">Citation</label>
        <textarea name="info" id="info" class="form-control" rows="2">{{ old('info', $page->info ?? '') }}</textarea>
      </div>

      {{-- Contenu --}}
      <div class="col-md-12 mb-3">
        <label for="content" class="form-label">Contenu <span class="text-danger">*</span></label>
        <textarea name="content" id="omizixEditor" class="form-control" rows="10" required>{{ old('content', $page->content ?? '') }}</textarea>
      </div>

      {{-- Submit --}}
      <div class="col-md-12 text-end">
        <button type="submit" class="btn btn-primary mt-2 mb-3">{{ $btnLabel }}</button>
      </div>

    </div>
  </div>
</form>



<script>
    (function () {
    const form = document.getElementById('pageForm');
    if (!form) return;

    // Plan B : forcer la soumission – mais AVANT, on synchronise TinyMCE
    const btn = form.querySelector('button[type="submit"],input[type="submit"]');
    if (btn) {
        btn.addEventListener('click', function () {
        setTimeout(function () {
            // 1) s'assurer que le contenu TinyMCE est bien poussé dans le <textarea name="content">
            if (window.tinymce && typeof tinymce.triggerSave === 'function') {
            tinymce.triggerSave();
            }
            // 2) valider les contraintes HTML5 pour éviter d'envoyer si invalide
            if (typeof form.reportValidity === 'function' && !form.reportValidity()) return;

            // 3) soumission native (pas d'événements)
            HTMLFormElement.prototype.submit.call(form);
        }, 120);
        }, true); // capture
    }
    })();
</script>



<script>
  // Quand un éditeur est ajouté (par le script global), accroche la sync auto
  if (window.tinymce) {
    tinymce.on('AddEditor', (e) => {
      if (e.editor.id === 'omizixEditor') {
        e.editor.on('init change keyup undo redo', () => e.editor.save());
      }
    });
  }

  // Ceinture + bretelles : synchroniser aussi au vrai submit (si jamais il passe)
  document.getElementById('pageForm')?.addEventListener('submit', function () {
    if (window.tinymce && typeof tinymce.triggerSave === 'function') {
      tinymce.triggerSave();
    }
  }, true); // capture
</script>


