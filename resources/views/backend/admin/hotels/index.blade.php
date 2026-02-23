@extends('backend.admin.layouts.master')
@section('title') Hôtels @endsection
@section('content')

<div class="row">
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-pink-transparent border border-pink d-flex align-items-center justify-content-center">
                                <i class="ti ti-world text-pink fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1">Total Hôtels</p>
                            <h4>{{ $total }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-checkbox  fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1">Hôtels Actifs</p>
                            <h4>{{ $active }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-danger border border-pink d-flex align-items-center justify-content-center">
                                <i class="ti ti-x fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1">Hôtels Inactifs</p>
                            <h4>{{ $inactive }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-info-transparent border border-info d-flex align-items-center justify-content-center">
                                <i class="ti ti-star fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1">Note Moyenne</p>
                            <span class="fw-bold text-black ">
                                {{ $averageRating }}
                            </span>
                            <span>({{ $totalReviews }} Avis)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="card">
  <div class="card-body p-3">
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
      <div class="d-flex align-items-center flex-wrap row-gap-3">

        {{-- Filtre par statut (inchangé) --}}
        <div class="dropdown me-3">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
            Sélectionner le statut
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-3" id="status-dropdown">
            <li><a href="{{ route('admin.hotels', ['status' => 'all'] + collect(request()->query())->except('status')->all()) }}" class="dropdown-item rounded-1">Tous les Hôtels</a></li>
            <li><a href="{{ route('admin.hotels', ['status' => 'active'] + collect(request()->query())->except('status')->all()) }}" class="dropdown-item rounded-1">Hôtels Actifs</a></li>
            <li><a href="{{ route('admin.hotels', ['status' => 'inactive'] + collect(request()->query())->except('status')->all()) }}" class="dropdown-item rounded-1">Hôtels Inactifs</a></li>
          </ul>
        </div>

        {{-- Filtre par période (sans "Récemment ajoutés") --}}
        @php
          $periodLabel = match(request('period')) {
            'last_month' => 'Dernier mois',
            'last_7_days' => 'Derniers 7 jours',
            default => 'Tous'
          };
        @endphp
        <div class="dropdown">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
            Trier par : {{ $periodLabel }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-3" id="period-dropdown">
            <li>
              <a href="{{ route('admin.hotels', collect(request()->query())->except('period')->all()) }}"
                 class="dropdown-item rounded-1">Tous</a>
            </li>
            <li>
              <a href="{{ route('admin.hotels', array_merge(collect(request()->query())->except('period')->all(), ['period' => 'last_month'])) }}"
                 class="dropdown-item rounded-1">Dernier mois</a>
            </li>
            <li>
              <a href="{{ route('admin.hotels', array_merge(collect(request()->query())->except('period')->all(), ['period' => 'last_7_days'])) }}"
                 class="dropdown-item rounded-1">Derniers 7 jours</a>
            </li>
          </ul>
        </div>

         {{-- Filtre Partenaire (Account -> Owner) --}}
        {{-- <div class="dropdown me-3">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
            Partenaire
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-3">
            <li>
              <a href="{{ route('admin.hotels', collect(request()->query())->except('account_id')->all()) }}"
                 class="dropdown-item rounded-1">Tous</a>
            </li>
            @foreach($accounts as $acc)
              @php $owner = $acc->users->first(); @endphp
              <li>
                <a href="{{ route('admin.hotels', array_merge(request()->query(), ['account_id' => $acc->id])) }}"
                   class="dropdown-item rounded-1">
                  {{ $acc->name }} → {{ $owner ? ($owner->lastname.' '.$owner->firstname) : '—' }}
                </a>
              </li>
            @endforeach
          </ul>
        </div> --}}

      </div>
      <div>
        <a href="{{ route('admin.hotel.add') }}" class="btn btn-primary d-flex align-items-center text-center">
          <i class="ti ti-circle-plus me-2"></i>Ajouter un Hôtel
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                @if($hotels->isEmpty())
                    @include('partials.empty')
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Hôtel</th>
                                    <th># Chambres</th>
                                    <th>Catégorie</th>
                                    <th>Emplacement</th>
                                    <th>À partir de</th>
                                    {{-- <th>Réservé</th> --}}
                                    <th>Avis</th>
                                    <th>Vues</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotels as $hotel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $hotel->name ?? 'N/A' }}</td>
                                        <td>{{ $hotel->rooms_count ?? 0 }} Chambres</td>
                                        <td>{{ $hotel->category ? $hotel->category->name : 'N/A' }}</td>
                                        <td>
                                            {{ $hotel->city ?? 'N/A' }} - {{ $hotel->country->name ?? 'N/A' }}
                                        </td>

                                        <td>
                                            @if($hotel->rooms_count)
                                                {{ number_format($hotel->rooms->min('price'), 0, ',', ' ') }} GNF/nuit
                                            @else
                                                0 Chambre
                                            @endif
                                        </td>
                                        {{-- <td>{{ $hotel->bookings_count ?? 0 }} fois</td> --}}
                                        <td>
                                            <span class="text-warning">
                                                @if ($hotel->reviews_count > 0)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            </span>
                                            {{ number_format($hotel->average_rating ?? 0, 1) }} ({{ $hotel->reviews_count ?? 0 }})
                                        </td>
                                        <td>{{ $hotel->views_count ?? 0 }} Vues</td>
                                        {{-- <td>
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="status[{{ $hotel->id }}]" value="0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="status[{{ $hotel->id }}]" value="1"
                                                    id="status-switch-{{ $hotel->id }}"
                                                    {{ $hotel->status ? 'checked' : '' }}>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input js-status-switch"
                                                    type="checkbox"
                                                    data-url="{{ route('admin.hotels.status', $hotel) }}"
                                                    {{ $hotel->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>

                                            <a href="{{ route('admin.hotel.edit', $hotel) }}" class="btn btn-sm btn-secondary" title="Modifier">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                               data-bs-toggle="modal" data-bs-target="#delete_modal"
                                               onclick="setDeleteLink({{ $hotel->id }})">
                                                <i class="ti ti-trash"></i>
                                            </a>


                                            <a href="{{ route('media.index',['type'=>'hotel','key'  => $hotel->slug ?: $hotel->getKey()]) }}"
                                                class="btn btn-sm btn-info btn-icon"
                                                {{ $hotel->has_pending_submission ? 'disabled' : '' }}
                                                data-bs-toggle="tooltip" data-bs-title="Médias" aria-label="Médias">
                                                <i class="ti ti-photo-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-3">
                        {{ $hotels->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- Add hotel -->
<div class="modal fade" id="add_hotel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un nouvel Hôtel</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('admin.hotel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pb-0">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Ex : Hôtel Zaly Palace" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label">Ville <span class="text-danger">*</span></label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="Ex : N'zérékoré" required>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="address" class="form-label">Adresse (quartier / district)</label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Ex : Quartier Zébéla, District Sud">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Ex : +2290167617769">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Ex : support@omizix.com">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="country_id" class="form-label">Pays</label>
                            <select name="country_id" id="country_id" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $country->id == 1 ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">-- Sélectionner une catégorie --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="free_rooms" class="form-label">Chambres disponibles</label>
                            <input type="number" name="free_rooms" id="free_rooms" class="form-control" placeholder="Ex : 12">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="total_rooms" class="form-label">Nombre total de chambres</label>
                            <input type="number" name="total_rooms" id="total_rooms" class="form-control" placeholder="Ex : 20">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Type d'hôtel</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Eco">Économique</option>
                                    <option value="Standard">Standard</option>
                                    <option value="Deluxe">De luxe</option>
                                    {{-- <option value="Boutique">Boutique</option> --}}
                                    <option value="Suite">Résidence hôtelière</option>
                                    <option value="Resort">Resort</option>
                                    <option value="Business">D’affaires</option>
                                    <option value="Auberge">Auberge</option>
                                    <option value="Autre">Autre</option>

                                </select>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="video" class="form-label">Vidéo (fichier)</label>
                            <input type="file" name="video" id="video" class="form-control" accept="video/*">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="video_url" class="form-label">Vidéo URL</label>
                            <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://youtube.com/...">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="info" class="form-label">Informations supplémentaires</label>
                            <input type="text" name="info" id="info" class="form-control" placeholder="Ex : Réception 24h/24, petit déjeuner inclus">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Ex : 7.75687123">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Ex : -8.82645123">
                        </div>

                        {{-- <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" selected>Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div> --}}

                        <div class="col-md-4 mb-3">
                            <label for="image" class="form-label">Image principale</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="facilities" class="form-label">Installations</label>
                            <select name="facilities[]" id="facilities" class="form-select select2" multiple>
                                <option disabled selected>-- Sélectionnez les installations --</option>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brève présentation de l'hôtel, des services, etc."></textarea>
                        </div>

                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary mt-3 m-2">Enregistrer</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add hotel -->


<!-- Modal pour confirmation de suppression -->
<div class="modal fade" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                    <i class="ti ti-trash-x fs-36"></i>
                </span>
                <h4 class="mb-1">Confirmer la suppression</h4>
                <p class="mb-3 text-danger">
                    Attention : En confirmant la suppression, toutes les informations associées seront définitivement perdues.
                </p>
                <div class="d-flex justify-content-center">
                    <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</a>

                    <!-- Formulaire de suppression dynamique -->
                    <form id="deleteForm" action="{{ route('admin.hotel.delete', ':id') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var hotelId = this.name.match(/\[(\d+)\]/)[1];
            var status = this.checked ? 1 : 0;

            // Send the update request via AJAX
            fetch(`/zpanel/hotel/status-update/${hotelId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Statut mis à jour avec succès !');
                } else {
                    toastr.error('Échec de la mise à jour du statut.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                toastr.error('Erreur lors de la mise à jour du statut.');
            });

        });
    });
</script>

<script>
    function setDeleteLink(hotelId) {
        var formAction = document.getElementById('deleteForm');
        formAction.action = formAction.action.replace(':id', hotelId);
    }
</script>


<script>
    document.querySelectorAll('.js-status-switch').forEach(function (el) {
        el.addEventListener('change', function () {
            const url = this.dataset.url;
            const status = this.checked ? 1 : 0;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Statut mis à jour avec succès !');
                } else {
                    toastr.error('Échec de la mise à jour du statut.');
                }
            })
            .catch(() => toastr.error('Erreur lors de la mise à jour du statut.'));
        });
    });
</script>
@endsection
