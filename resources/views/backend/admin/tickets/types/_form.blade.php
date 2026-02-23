@php
/** @var \App\Models\TicketType|null $type */
/** @var \Illuminate\Database\Eloquent\Collection $events */

$isEdit = isset($type) && $type->exists;

$action = $action ?? ($isEdit
    ? route('admin.ticket_types.update', $type->id)
    : route('admin.ticket_types.store'));

$btnLabel = $isEdit ? 'Mettre à jour' : 'Enregistrer';

// --- safe access to features (do NOT try to read $type->features when $type is null)
$rawFeatures = old('features', null);
if ($rawFeatures === null) {
    $rawFeatures = $type ? $type->features : [];
}
$features = is_array($rawFeatures) ? $rawFeatures : (
    // try decode if string
    (is_string($rawFeatures) ? (@json_decode($rawFeatures, true) ?: [$rawFeatures]) : [])
);

// --- metadata as pretty JSON string (safe)
if (old('metadata') !== null) {
    $metadata = old('metadata');
} else {
    $metadata = $type && $type->metadata ? json_encode($type->metadata, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) : '';
}
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="ticketTypeForm">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="card">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label for="event_id" class="form-label">Événement <span class="text-danger">*</span></label>
                    <select id="event_id" name="event_id" class="form-control" required>
                        <option value="">-- Sélectionner un événement --</option>
                        @foreach($events as $ev)
                            <option value="{{ $ev->id }}" @selected((int)old('event_id', $type->event_id ?? '') === (int)$ev->id)>{{ $ev->name }}</option>
                        @endforeach
                    </select>
                    @error('event_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nom du type <span class="text-danger">*</span></label>
                    <input id="name" name="name" type="text" class="form-control" required
                           value="{{ old('name', $type->name ?? '') }}">
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- <div class="col-md-4">
                    <label for="sku" class="form-label">SKU</label>
                    <input id="sku" name="sku" type="text" class="form-control"
                           value="{{ old('sku', $type->sku ?? '') }}">
                    @error('sku')<small class="text-danger">{{ $message }}</small>@enderror
                </div> --}}

                <div class="col-md-3">
                    <label for="price" class="form-label">Prix (GNF) <span class="text-danger">*</span></label>
                    <input id="price" name="price" type="number" step="0.01" min="0" class="form-control" required
                           value="{{ old('price', $type->price ?? 0) }}">
                    @error('price')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-3">
                    <label for="quantity" class="form-label">Quantité (null = illimité)</label>
                    <input id="quantity" name="quantity" type="number" step="1" min="0" class="form-control"
                           value="{{ old('quantity', $type->quantity ?? '') }}">
                    @error('quantity')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-3">
                    <label for="sales_start" class="form-label">Ventes - début</label>
                    {{-- SAFE: do not call ->sales_start on null --}}
                    <input id="sales_start" name="sales_start" type="datetime-local" class="form-control"
                        value="{{ old('sales_start', ($type && $type->sales_start) ? $type->sales_start->format('Y-m-d\TH:i') : '') }}">
                    @error('sales_start')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-3">
                    <label for="sales_end" class="form-label">Ventes - fin</label>
                    <input id="sales_end" name="sales_end" type="datetime-local" class="form-control"
                        value="{{ old('sales_end', ($type && $type->sales_end) ? $type->sales_end->format('Y-m-d\TH:i') : '') }}">
                    @error('sales_end')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $type->description ?? '') }}</textarea>
                    @error('description')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Features dynamic list --}}
                <div class="col-12">
                    <label class="form-label">Features (ex: Accès backstage) — ajouter/retirer</label>
                    <div id="featuresList">
                        @if(count($features))
                            @foreach($features as $i => $f)
                                <div class="input-group mb-2 feature-item">
                                    <input type="text" name="features[]" class="form-control" value="{{ old("features.$i", $f) }}" placeholder="Feature">
                                    <button type="button" class="btn btn-outline-danger btn-remove-feature" title="Retirer">×</button>
                                </div>
                            @endforeach
                        @else
                            <div class="input-group mb-2 feature-item">
                                <input type="text" name="features[]" class="form-control" value="" placeholder="Feature">
                                <button type="button" class="btn btn-outline-danger btn-remove-feature" title="Retirer">×</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="addFeatureBtn" class="btn btn-sm btn-secondary">+ Ajouter une feature</button>
                    @error('features')<small class="text-danger d-block">{{ $message }}</small>@enderror
                    @error('features.*')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>



                <div class="col-md-4">
                    <label for="max_per_order" class="form-label">Max par commande</label>
                    <input id="max_per_order" name="max_per_order" type="number" step="1" min="1" class="form-control"
                           value="{{ old('max_per_order', $type->max_per_order ?? '') }}">
                    @error('max_per_order')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-4">
                    <label for="is_refundable" class="form-label d-block">Remboursable</label>
                    {{-- checkbox: always submit something via hidden input --}}
                    <input type="hidden" name="is_refundable" value="0">
                    <div class="form-check form-switch">
                        <input id="is_refundable" name="is_refundable" class="form-check-input" type="checkbox" value="1"
                            @checked(old('is_refundable', $type->is_refundable ?? false))>
                        <label class="form-check-label" for="is_refundable">Autoriser remboursement</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="is_active" class="form-label d-block">Actif</label>
                    <input type="hidden" name="is_active" value="0">
                    <div class="form-check form-switch">
                        <input id="is_active" name="is_active" class="form-check-input" type="checkbox" value="1"
                            @checked(old('is_active', $type->is_active ?? true))>
                        <label class="form-check-label" for="is_active">Vendre ce type</label>
                    </div>
                </div>

                {{-- <div class="col-12">
                    <label for="metadata" class="form-label">Metadata (JSON libre, optionnel)</label>
                    <textarea id="metadata" name="metadata" rows="5" class="form-control" placeholder='{"zone":"A","seat_map":...}'>{{ $metadata }}</textarea>
                    <small class="text-muted">Facultatif — utilisé pour étendre (seats, zone, custom).</small>
                    @error('metadata')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div> --}}

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary mt-3">{{ $btnLabel }}</button>
                </div>

            </div>
        </div>
    </div>
</form>

{{-- JS pour features dynamique --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const featuresList = document.getElementById('featuresList');
        const addBtn = document.getElementById('addFeatureBtn');

        function createFeatureItem(value = '') {
            const wrapper = document.createElement('div');
            wrapper.className = 'input-group mb-2 feature-item';
            // safe stringification
            const safeValue = String(value).replace(/"/g,'&quot;').replace(/\n/g,' ');
            wrapper.innerHTML = `
                <input type="text" name="features[]" class="form-control" value="${safeValue}" placeholder="Feature">
                <button type="button" class="btn btn-outline-danger btn-remove-feature" title="Retirer">×</button>
            `;
            return wrapper;
        }

        addBtn.addEventListener('click', function () {
            featuresList.appendChild(createFeatureItem(''));
        });

        featuresList.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('btn-remove-feature')) {
                const item = e.target.closest('.feature-item');
                if (item) item.remove();
            }
        });
    });
</script>
