@csrf

@php
  // Valeurs par défaut utiles côté JS
  $defaultUnit = old('unit', $product->unit ?? '');
  $isEdit = isset($product) && $product && $product->exists;
@endphp


<div class="row g-3">
  {{-- Nom & Catégorie --}}
  <div class="col-md-6">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $product->name ?? '') }}"
           placeholder="Ex : T-shirt Premium 100% coton" required>
  </div>

  <div class="col-md-3">
    <label class="form-label">Catégorie</label>
    <select name="category_id" class="form-select">
      <option value="">Sélectionner</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id ?? '') == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  {{-- <div class="col-md-2">
    <label class="form-label">SKU (auto si vide)</label>
    <input type="text" name="sku" class="form-control"
           value="{{ old('sku', $product->sku ?? '') }}"
           placeholder="Ex : TS-PR-001">
  </div> --}}

  <div class="col-md-3">
    <label class="form-label">Type</label>
    <select name="type" id="type" class="form-select" required>
      <option value="simple"   @selected(old('type', $product->type ?? 'simple')=='simple')>Simple</option>
      {{-- <option value="variable" @selected(old('type', $product->type ?? '')=='variable')>Variable</option> --}}
    </select>
  </div>

  {{-- Description --}}
  <div class="col-md-12">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3"
              placeholder="Points forts, matière, guide d’entretien, etc.">{{ old('description', $product->description ?? '') }}</textarea>
  </div>

  {{-- Prix / Stock --}}
  <div class="col-md-4 simple-only">
    <label class="form-label">Prix actuel</label>
    <input type="number" step="0.01" name="price" class="form-control"
           value="{{ old('price', $product->price ?? 0) }}" placeholder="Ex : 149000">
  </div>

  <div class="col-md-4 simple-only">
    <label class="form-label">Ancien prix</label>
    <input type="number" step="1" name="old_price" class="form-control"
           value="{{ old('old_price', $product->old_price ?? '') }}" placeholder="Ex : 169000">
  </div>

  <div class="col-md-4 simple-only">
    <label class="form-label">Stock</label>
    <input type="number" name="stock" class="form-control"
           value="{{ old('stock', $product->stock ?? 0) }}" placeholder="Ex : 25">
  </div>

  {{-- Poids / Unité / Statut --}}
  <div class="col-md-4 simple-only">
    <label class="form-label">Poids</label>
    <input type="number" step="0.01" name="weight" class="form-control"
           value="{{ old('weight', $product->weight ?? '') }}" placeholder="Ex : 0.45">
  </div>

  <div class="col-md-4 simple-only">
    <label class="form-label">Unité</label>
    <input type="text" name="unit" class="form-control"
           value="{{ old('unit', $product->unit ?? '') }}" placeholder="Ex : kg">
  </div>

  <div class="col-md-4 d-flex align-items-end simple-only">
    <div class="form-check form-switch">
        <input type="hidden" name="status" value="0">
        <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                @checked(old('status', $product->status ?? true))>
        <label class="form-check-label ms-2" for="status">Actif</label>
    </div>
  </div>

    <div class="col-md-4">
      <label for="image" class="form-label">Image principale</label>
      <input type="file" name="image" id="image" class="form-control" accept="image/*">
      @if($isEdit && $product->image)
        <small class="d-block mt-1">Image actuelle :
          <br><img src="{{ asset('storage/'.$product->image) }}" alt="Image actuelle" style="max-width:110px;">
        </small>
      @endif
      @error('image')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="col-md-4">
        <label for="video" class="form-label">Vidéo (optionnelle)</label>
        <input type="file" name="video" id="video" class="form-control" accept="video/*" placeholder="MP4 – max 20 Mo">
        @if($isEdit && $product->video)
            <small class="d-block mt-1">
                Vidéo actuelle : {{ basename($product->video) }}
                @if(Str::startsWith($product->video, 'http'))
                    <br><a href="{{ $product->video }}" target="_blank">Lien externe</a>
                @else
                    <br><video src="{{ asset('storage/'.$product->video) }}" controls style="max-width:100%;max-height:150px;"></video>
                @endif
            </small>
        @endif
        <small class="text-muted d-block mt-1">
            Formats acceptés : MP4 • Max 20 Mo
        </small>
        @error('video')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- <div class="col-md-4">
        <label for="video_url" class="form-label">URL vidéo (YouTube, Vimeo...)</label>
        <input type="url" name="video_url" class="form-control"
            value="{{ old('video_url', $product->video_url ?? '') }}"
            placeholder="https://...">
    </div> --}}


  {{-- Galerie --}}
  <div class="col-md-4">
    <label class="form-label">Galerie (images multiples)</label>
    <input type="file" name="gallery[]" class="form-control" multiple
           accept=".jpg,.jpeg,.png,.webp" placeholder="JPG/PNG/WebP, 5 Mo max">
    @if(!empty($product))
      <div class="d-flex gap-2 mt-2 flex-wrap">
        @foreach($product->getMedia('gallery') as $m)
          <div class="position-relative">
            @php
            $src = $m->hasGeneratedConversion('thumb')
                ? asset('storage/'.$m->getPathRelativeToRoot('thumb'))
                : asset('storage/'.$m->getPathRelativeToRoot());
            @endphp
            <img src="{{ $src }}" alt="media" style="width:90px;height:90px;object-fit:cover" class="rounded border">


            {{-- <img src="{{ $m->getUrl('thumb') ?: $m->getUrl() }}"
                 style="width:90px;height:90px;object-fit:cover" class="rounded border" alt="media"> --}}
            <button class="btn btn-sm btn-danger position-absolute top-0 end-0"
                    onclick="event.preventDefault(); deleteMedia({{ $product->id }}, {{ $m->id }}, this)">×</button>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

<hr class="my-4">

{{-- Variantes (si type=variable) --}}
<div id="variants" class="{{ old('type', $product->type ?? 'simple')==='variable' ? '' : 'd-none' }}">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h5 class="mb-0">Variantes</h5>
    <button type="button" class="btn btn-sm btn-primary" onclick="addSkuRow()">Ajouter une variante</button>
  </div>

  <div class="border rounded">
    <table class="table table-sm align-middle mb-0" id="skuTable" style="min-width: 980px">

      <thead>
        <tr>
          <th>Attributs (Ex:Couleur=Noir; Taille=M)</th>
          {{-- <th>SKU</th> --}}
          <th>Prix</th>
          <th>Ancien Prix</th>
          <th>Stock</th>
          <th>Poids</th>
          <th>Unité</th>
          <th>Actif</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @php $rows = old('skus', isset($product) ? $product->skus->toArray() : []); @endphp
        @foreach($rows as $i => $row)
          <tr>
            <td>
              <input type="text" name="skus[{{ $i }}][attributes_input]" class="form-control"
                     placeholder="Ex : Couleur=Noir; Taille=M"
                     value="{{ $row['attributes_input'] ?? (isset($row['attributes']) ? collect($row['attributes'])->map(fn($v,$k)=>"$k=$v")->implode('; ') : '') }}">
            </td>
            {{-- <td>
              <input type="hidden" name="skus[{{ $i }}][id]" value="{{ $row['id'] ?? '' }}">
              <input type="text"   name="skus[{{ $i }}][sku]" class="form-control"
                     value="{{ $row['sku'] ?? '' }}" placeholder="Auto si vide">
            </td> --}}
            <td><input type="number" step="1" name="skus[{{ $i }}][price]" class="form-control"
                       value="{{ $row['price'] ?? '' }}" placeholder="Ex : 149000"></td>
            <td><input type="number" step="1" name="skus[{{ $i }}][old_price]" class="form-control"
                       value="{{ $row['old_price'] ?? '' }}" placeholder="Ex : 169000"></td>
            <td><input type="number" name="skus[{{ $i }}][stock]" class="form-control"
                       value="{{ $row['stock'] ?? 0 }}" placeholder="Ex : 10"></td>
            <td><input type="number" step="0.01" name="skus[{{ $i }}][weight]" class="form-control"
                       value="{{ $row['weight'] ?? '' }}" placeholder="Ex : 0.45"></td>
            <td><input type="text" name="skus[{{ $i }}][unit]" class="form-control"
                       value="{{ $row['unit'] ?? ($product->unit ?? '') }}" placeholder="Ex : kg"></td>
            <td class="text-center">
              <input type="checkbox" name="skus[{{ $i }}][status]" value="1"
                     {{ (isset($row['status']) ? (int)$row['status'] : 1) ? 'checked' : '' }}>
            </td>
            <td><button type="button" class="btn btn-sm btn-light" onclick="removeSkuRow(this)">Supprimer</button></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<script>
    (function(){
        const typeSel  = document.getElementById('type');
        const variants = document.getElementById('variants');
        const DEFAULT_UNIT = @json($defaultUnit);

        function toggleTypeFields() {
            const isVariable = typeSel.value === 'variable';

            // montrer/cacher bloc variantes
            if (variants) {
                variants.classList.toggle('d-none', !isVariable);
            }

            // cacher les champs réservés au produit simple
            document.querySelectorAll('.simple-only').forEach(el => {
                el.classList.toggle('d-none', isVariable);
            });
        }

        if (typeSel) {
            typeSel.addEventListener('change', toggleTypeFields);
            // état initial
            toggleTypeFields();
        }
    })();
</script>

<script>
    (function(){
    const typeSel  = document.getElementById('type');
    const variants = document.getElementById('variants');
    const DEFAULT_UNIT = @json($defaultUnit);

    if (typeSel && variants) {
        typeSel.addEventListener('change', () => {
        variants.classList.toggle('d-none', typeSel.value !== 'variable');
        });
    }

    window.addSkuRow = function(){
        const tbody = document.querySelector('#skuTable tbody');
        const idx   = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td><input type="text" name="skus[${idx}][attributes_input]" class="form-control"
                    placeholder="Ex : Couleur=Noir; Taille=M"></td>
        <td>
            <input type="hidden" name="skus[${idx}][id]" value="">
            <input type="text"   name="skus[${idx}][sku]" class="form-control" placeholder="Auto si vide">
        </td>
        <td><input type="number" step="0.01" name="skus[${idx}][price]" class="form-control" placeholder="Ex : 149000"></td>
        <td><input type="number" step="0.01" name="skus[${idx}][old_price]" class="form-control" placeholder="Ex : 169000"></td>
        <td><input type="number" name="skus[${idx}][stock]" class="form-control" value="0" placeholder="Ex : 10"></td>
        <td><input type="number" step="0.01" name="skus[${idx}][weight]" class="form-control" placeholder="Ex : 0.45"></td>
        <td><input type="text" name="skus[${idx}][unit]" class="form-control" value="${DEFAULT_UNIT || ''}" placeholder="Ex : kg"></td>
        <td class="text-center"><input type="checkbox" name="skus[${idx}][status]" value="1" checked></td>
        <td><button type="button" class="btn btn-sm btn-light" onclick="removeSkuRow(this)">Supprimer</button></td>
        `;
        tbody.appendChild(tr);
    };

    window.removeSkuRow = function(btn){
        btn.closest('tr')?.remove();
    };

    window.deleteMedia = async function(productId, mediaId, btn){
        if (!confirm('Supprimer cette image ?')) return;





        const res = await fetch(`{{ url('/partners/shop/products') }}/${productId}/media/${mediaId}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}','Accept':'application/json'}
        });
        const data = await res.json().catch(()=>({}));
        if (data.success) {
        btn.closest('.position-relative')?.remove();
        } else {
        alert('Échec suppression.');
        }
    };
    })();
</script>


