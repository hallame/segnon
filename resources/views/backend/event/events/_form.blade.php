@php
  // Attendus : $action, $method, $submitLabel, $event (nullable), $withComment (bool), $categories (Collection)
  $fmt = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('Y-m-d\TH:i') : '';
@endphp

<form method="post" action="{{ $action }}" class="card" enctype="multipart/form-data">
  @csrf
  @if (strtoupper($method) !== 'POST') @method($method) @endif

  <div class="card-body">
    <div class="mb-3">
      <label for="name" class="form-label">Nom de l’événement</label>
      <input id="name" name="name" class="form-control" required value="{{ old('name', optional($event)->name) }}">
      @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    {{-- Slug (affichage en lecture seule si déjà défini) --}}
    {{-- @if(!empty($event?->slug))
      <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input id="slug" class="form-control" value="{{ $event->slug }}" readonly>
        <small class="text-muted">Le slug n’est pas modifiable après création.</small>
      </div>
    @endif --}}

    
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea id="description" name="description" class="form-control" rows="6" required>{{ old('description', optional($event)->description) }}</textarea>
      @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="row g-3">
      <div class="col-md-3">
        <label for="start_date" class="form-label">Date début</label>
        <input id="start_date" name="start_date" type="datetime-local" class="form-control" required
               value="{{ old('start_date', $fmt(optional($event)->start_date)) }}">
        @error('start_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-3">
        <label for="end_date" class="form-label">Date fin</label>
        <input id="end_date" name="end_date" type="datetime-local" class="form-control" required
               value="{{ old('end_date', $fmt(optional($event)->end_date)) }}">
        @error('end_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label for="location" class="form-label">Lieu</label>
        <input id="location" name="location" class="form-control" value="{{ old('location', optional($event)->location) }}">
        @error('location') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="row g-3 mt-0">


      <div class="col-md-3">
        <label for="latitude" class="form-label">Latitude</label>
        <input id="latitude" name="latitude" type="number" step="0.0000001" class="form-control"
               value="{{ old('latitude', optional($event)->latitude) }}">
        @error('latitude') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-3">
        <label for="longitude" class="form-label">Longitude</label>
        <input id="longitude" name="longitude" type="number" step="0.0000001" class="form-control"
               value="{{ old('longitude', optional($event)->longitude) }}">
        @error('longitude') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label for="category_id" class="form-label">Catégorie</label>
        <select id="category_id" name="category_id" class="form-select">
          <option value="">— Aucune —</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected((int)old('category_id', optional($event)->category_id) === (int)$cat->id)>{{ $cat->name }}</option>
          @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="row g-3 mt-0">
      <div class="col-md-8">
        <label for="map_url" class="form-label">Lien carte</label>
        <input id="map_url" name="map_url" type="url" class="form-control"
               value="{{ old('map_url', optional($event)->map_url) }}">
        @error('map_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-4">
        <label for="image" class="form-label">Image (couverture)</label>
        <input id="image" name="image" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>

    @if(!empty($event?->image))
      <div class="mt-3">
        <label class="form-label">Aperçu actuel</label>
        <div class="border rounded p-2" style="max-width: 360px;">
          <img src="{{ asset('storage/'.$event->image) }}" alt="Cover" class="img-fluid rounded">
        </div>
      </div>
    @endif

    @if(!empty($withComment))
      <div class="mt-3">
        <label for="comment" class="form-label">Commentaire à l’admin (optionnel)</label>
        <input id="comment" name="comment" class="form-control" placeholder="Infos utiles pour la validation"
               value="{{ old('comment') }}">
      </div>
    @endif
  </div>

  <div class="card-footer d-flex justify-content-between gap-2 flex-wrap">
    <a href="{{ route('partners.event.events.index') }}" class="btn btn-light">Annuler</a>
    <button class="btn btn-primary"><i class="ti ti-send"></i> {{ $submitLabel }}</button>
  </div>
</form>
