@php
  /** @var \App\Models\Event|null $event */
  use Illuminate\Support\Carbon;
  $isEdit   = isset($event) && $event->exists;

  $action   = $action ?? ($isEdit ? route('admin.events.update', $event->id) : route('admin.event.add')); // garde ton route store actuel
  $btnLabel = $isEdit ? 'Mettre à jour' : 'Enregistrer';
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="eventForm">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="modal-body pb-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="name" class="form-label">Titre de l’événement <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $event->name ?? '') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="location" class="form-label">Lieu <span class="text-danger">*</span></label>
                    <input type="text" id="location" name="location" class="form-control"
                            value="{{ old('location', $event->location ?? '') }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                    <label for="language_id" class="form-label">Langue <span class="text-danger">*</span></label>
                    <select name="language_id" id="language_id" class="form-control" required>
                        @foreach($languages as $lang)
                        <option value="{{ $lang->id }}"
                            @selected((int)old('language_id', $event->language_id ?? 1) === (int)$lang->id)>{{ $lang->name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected((int)old('category_id', $event->category_id ?? 0) === (int)$category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="mb-2">
                    <label for="start_date" class="form-label">Date de début <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control" required
                            value="{{ old('start_date', isset($event->start_date) ? Carbon::parse($event->start_date)->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                    <label for="end_date" class="form-label">Date de fin <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control" required
                            value="{{ old('end_date', isset($event->end_date) ? Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                    <label for="image" class="form-label">Affiche ou image {{ $isEdit ? '' : ' *' }}</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" {{ $isEdit ? '' : 'required' }}>
                    </div>
                </div>

                {{-- <div class="col-md-3 mb-3">
                    <label for="price" class="form-label">Prix du ticket (GNF)</label>
                    <input type="number" step="1" name="price" id="price" class="form-control"
                            value="{{ old('price', $isEdit ? $event->price : '') }}">
                    @error('price')<small class="text-danger">{{ $message }}</small>@enderror
                </div> --}}

                <div class="col-md-3">
                    <div class="mb-3">
                    <label for="video" class="form-label">Vidéo (optionnel)</label>
                    <input type="file" name="video" id="video" class="form-control" accept="video/*">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                    <label for="video_url" class="form-label">Lien vers la vidéo (optionnel)</label>
                    <input type="url" name="video_url" id="video_url" class="form-control"
                            value="{{ old('video_url', $event->video_url ?? '') }}"
                            placeholder="Lien YouTube/Vimeo…">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control" rows="8" required
                                placeholder="Détails sur l’événement, programme, intervenants, etc.">{{ old('description', $event->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary mb-3">{{ $btnLabel }}</button>
                </div>

            </div>
    </div>
</form>
