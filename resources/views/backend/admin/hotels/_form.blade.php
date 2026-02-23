<div class="modal-body pb-0">
    <div class="row">


        {{-- Champ obligatoire, filtré sur comptes ayant le module "hotel" --}}
        {{-- <div class="col-md-6 mb-3">
            <label class="form-label">Compte propriétaire <span class="text-danger">*</span></label>
            <select name="account_id" class="form-select" required>
                <option value="">— Sélectionner un compte —</option>
                @foreach($accounts as $acc)
                <option value="{{ $acc->id }}" {{ old('account_id', $hotel->account_id ?? null) == $acc->id ? 'selected' : '' }}>{{ $acc->name }} @if($acc->is_verified)✓@endif</option>
                @endforeach
            </select>
        </div> --}}


        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $hotel->name ?? '') }}"
                class="form-control" placeholder="Ex : Hôtel Zaly Palace" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="city" class="form-label">Ville <span class="text-danger">*</span></label>
            <input type="text" name="city" value="{{ old('city', $hotel->city ?? '') }}"
                id="city" class="form-control" placeholder="Ex : N'zérékoré" required>
        </div>


        <div class="col-md-6 mb-3">
            <label for="address" class="form-label">Adresse (quartier / district)</label>
            <input type="text" name="address" id="address" value="{{ old('address', $hotel->address ?? '') }}"
                class="form-control" placeholder="Ex : Quartier Zébéla, District Sud">
        </div>

        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Ex : +2290167617769"
                value="{{ old('phone', $hotel->phone ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', $hotel->email ?? '') }}" placeholder="Ex : support@omizix.com">
        </div>

        <div class="col-md-6 mb-3">
            <label for="country_id" class="form-label">Pays</label>
            <select name="country_id" id="country_id" class="form-control">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id', $hotel->country_id ?? 1) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $hotel->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="free_rooms" class="form-label">Chambres disponibles</label>
            <input type="number" value="{{ old('free_rooms', $hotel->free_rooms ?? '') }}"
                name="free_rooms" id="free_rooms"  class="form-control" placeholder="Ex : 12">
        </div>

        <div class="col-md-6 mb-3">
            <label for="total_rooms" class="form-label">Nombre total de chambres</label>
            <input type="number" value="{{ old('total_rooms', $hotel->total_rooms ?? '') }}"
                name="total_rooms" id="total_rooms" class="form-control" placeholder="Ex : 20">
        </div>

        <div class="col-md-6 mb-3">
            <label for="type" class="form-label">Type d'hôtel</label>
            <select name="type" id="type" class="form-control" required>
                @foreach(['Eco','Standard','Deluxe','Suite','Resort','Business','Auberge','Autre'] as $t)
                    <option value="{{ $t }}" {{ old('type', $hotel->type ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-6 mb-3">
            <label for="video" class="form-label">Vidéo (fichier)</label>
            <input type="file" name="video" id="video" class="form-control" accept="video/*">
        </div>

        <div class="col-md-6 mb-3">
            <label for="video_url" class="form-label">Vidéo URL</label>
            <input type="url" name="video_url" value="{{ old('video_url', $hotel->video_url ?? '') }}"
                id="video_url" class="form-control" placeholder="https://youtube.com/...">
        </div>

        <div class="col-md-6 mb-3">
            <label for="info" class="form-label">Informations supplémentaires</label>
            <input type="text" value="{{ old('info', $hotel->info ?? '') }}" name="info" id="info"
                 class="form-control" placeholder="Ex : Réception 24h/24, petit déjeuner inclus">
        </div>

        <div class="col-md-6 mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control"
                value="{{ old('latitude', $hotel->latitude ?? '') }}" placeholder="Ex : 7.75687123">
        </div>

        <div class="col-md-6 mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" value="{{ old('longitude', $hotel->longitude ?? '') }}"
                name="longitude" id="longitude" class="form-control" placeholder="Ex : -8.82645123">
        </div>

        <div class="col-md-6 mb-3">
            <label for="image" class="form-label">Image principale</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @if(!empty($hotel?->image))
            <small class="d-block mt-1">
                <img src="{{ asset('storage/'.$hotel->image) }}" style="max-width:100px">
            </small>
            @endif
        </div>
        <div class="col-md-6 mb-3">
            <label for="facilities" class="form-label">Installations</label>
            {{-- <select name="facilities[]" id="facilities" class="form-select select2" multiple>
                <option disabled selected>-- Sélectionnez les installations --</option>
                @foreach ($facilities as $facility)
                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                @endforeach
            </select> --}}

            <select name="facilities[]" class="form-select select2" multiple>
                @foreach($facilities as $facility)
                    @php
                    $selected = collect(old('facilities', $hotel->facilities_array ?? []))->contains($facility->id);
                    @endphp
                    <option value="{{ $facility->id }}" {{ $selected ? 'selected' : '' }}>
                    {{ $facility->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="omizixEditor" class="form-control" rows="10" placeholder="Brève présentation de l'hôtel, des services, etc.">
                {{ old('description', $hotel->description ?? '') }}
            </textarea>
        </div>

        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary mt-3 m-2">{{ $submitText ?? 'Enregistrer' }}</button>
        </div>

    </div>
</div>
