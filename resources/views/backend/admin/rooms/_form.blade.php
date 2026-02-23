@php
  $isEdit = isset($room) && $room && $room->exists;
  $submitLabel = $submitLabel ?? ($isEdit ? 'Mettre à jour' : 'Enregistrer');
  $selectedFacilities = old('facilities', $isEdit ? $room->facilities->pluck('id')->all() : []);
  $types = ['Simple','Double','Twin','Triple','Suite','Familial','Deluxe','Autre'];
@endphp

<div class="modal-body pb-0">
  <div class="row">
    {{-- <div class="col-md-4 mb-3">
        <label class="form-label">Compte propriétaire <span class="text-danger">*</span></label>
        <select name="account_id" class="form-select" required>
            <option value="">— Sélectionner un compte —</option>
            @foreach($accounts as $acc)
            <option value="{{ $acc->id }}" {{ old('account_id', $hotel->account_id ?? null) == $acc->id ? 'selected' : '' }}>{{ $acc->name }} @if($acc->is_verified)✓@endif</option>
            @endforeach
        </select>
    </div> --}}

    {{-- Nom --}}
    <div class="col-md-4 mb-3">
      <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
      <input type="text" name="name" id="name" class="form-control"
             value="{{ old('name', $isEdit ? $room->name : '') }}" required>
      @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Hôtel associé --}}
    <div class="col-md-4 mb-3">
      <label for="hotel_id" class="form-label">Hôtel <span class="text-danger">*</span></label>
      <select name="hotel_id" id="hotel_id" class="form-control" required>
        <option value="">-- Sélectionner un hôtel --</option>
        @foreach($hotels as $hotel)
          <option value="{{ $hotel->id }}"
            {{ (string)old('hotel_id', $isEdit ? $room->hotel_id : '') === (string)$hotel->id ? 'selected' : '' }}>
            {{ $hotel->name }}
          </option>
        @endforeach
      </select>
      @error('hotel_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Type --}}
    <div class="col-md-4 mb-3">
      <label for="type" class="form-label">Type de chambre</label>
      <select name="type" id="type" class="form-control">
        <option value="">-- Sélectionner --</option>
        @foreach($types as $type)
          <option value="{{ $type }}"
            {{ old('type', $isEdit ? $room->type : '') === $type ? 'selected' : '' }}>
            {{ $type }}
          </option>
        @endforeach
      </select>
      @error('type')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Adresse --}}
    <div class="col-md-4 mb-3">
      <label for="address" class="form-label">Adresse (facultatif)</label>
      <input type="text" name="address" id="address" class="form-control"
             value="{{ old('address', $isEdit ? $room->address : '') }}">
      @error('address')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Capacité --}}
    <div class="col-md-4 mb-3">
      <label for="capacity" class="form-label">Capacité (Nombre de personnes)</label>
      <input type="number" name="capacity" id="capacity" class="form-control"
             value="{{ old('capacity', $isEdit ? $room->capacity : '') }}">
      @error('capacity')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Prix --}}
    <div class="col-md-4 mb-3">
      <label for="price" class="form-label">Prix par nuit</label>
      <input type="number" step="0.01" name="price" id="price" class="form-control"
             value="{{ old('price', $isEdit ? $room->price : '') }}">
      @error('price')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Vidéo (fichier) --}}
    <div class="col-md-4 mb-3">
      <label for="video" class="form-label">Vidéo (fichier)</label>
      <input type="file" name="video" id="video" class="form-control" accept="video/*">
      @error('video')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Vidéo URL --}}
    <div class="col-md-4 mb-3">
      <label for="video_url" class="form-label">Vidéo URL</label>
      <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://youtube.com/..."
             value="{{ old('video_url', $isEdit ? $room->video_url : '') }}">
      @error('video_url')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Image --}}
    <div class="col-md-4 mb-3">
      <label for="image" class="form-label">Image principale</label>
      <input type="file" name="image" id="image" class="form-control" accept="image/*">
      @if($isEdit && $room->image)
        <small class="d-block mt-1">Image actuelle :
          <br><img src="{{ asset('storage/'.$room->image) }}" alt="Image actuelle" style="max-width:110px;">
        </small>
      @endif
      @error('image')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Installations --}}
    <div class="col-md-8 mb-3">
      <label for="facilities" class="form-label">Installations</label>
      <select name="facilities[]" id="facilities" class="form-select select2" multiple>
        @foreach ($facilities as $facility)
          <option value="{{ $facility->id }}"
            {{ in_array($facility->id, $selectedFacilities, true) ? 'selected' : '' }}>
            {{ $facility->name }}
          </option>
        @endforeach
      </select>
      @error('facilities')<small class="text-danger d-block">{{ $message }}</small>@enderror
      @error('facilities.*')<small class="text-danger d-block">{{ $message }}</small>@enderror
    </div>

    {{-- Infos supplémentaires --}}
    <div class="col-md-12 mb-3">
      <label for="info" class="form-label">Informations supplémentaires</label>
      <input type="text" name="info" id="info" class="form-control"
             value="{{ old('info', $isEdit ? $room->info : '') }}">
      @error('info')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Description --}}
    <div class="col-md-12">
      <label for="description" class="form-label">Description</label>
      <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $isEdit ? $room->description : '') }}</textarea>
      @error('description')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Submit --}}
    <div class="col-md-12 text-end">
      <button type="submit" class="btn btn-{{ $isEdit ? 'success' : 'primary' }} mt-3 m-2">
        {{ $submitLabel }}
      </button>
    </div>

  </div>
</div>
