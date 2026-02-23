@extends('backend.admin.layouts.master')
@section('title') Chambres @endsection
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
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1">Total Chambres</p>
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
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1">Chambres Activées</p>
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
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1">Chambres Désactivées</p>
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
                <!-- Filtre par statut -->
                <div class="dropdown me-3">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                        Sélectionner le statut
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-3" id="status-dropdown">
                        <li>
                            <a href="{{ route('admin.rooms', ['status' => 'all']) }}" class="dropdown-item rounded-1">Toutes les Chambres</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.rooms', ['status' => 'active']) }}" class="dropdown-item rounded-1">Activées</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.rooms', ['status' => 'inactive']) }}" class="dropdown-item rounded-1">Désactivées</a>
                        </li>
                    </ul>
                </div>
                <!-- Filtre par période -->
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                        Trier par : Derniers 7 jours
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-3" id="period-dropdown">
                        <li>
                            <a href="{{ route('admin.rooms', ['period' => 'recently_added']) }}" class="dropdown-item rounded-1">Récemment ajoutées</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.rooms', ['period' => 'last_month']) }}" class="dropdown-item rounded-1">Dernier mois</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.rooms', ['period' => 'last_7_days']) }}" class="dropdown-item rounded-1">Derniers 7 jours</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <a href="#add_room" data-bs-toggle="modal" data-bs-effect="effect-newspaper"
                    class="modal-effect btn btn-primary d-flex align-items-center text-center">
                    <i class="ti ti-circle-plus me-2"></i>Ajouter une chambre</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                @if($rooms->isEmpty())
                    @include('partials.empty')
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Chambre/Hôtel</th>
                                    {{-- <th>Hôtel</th> --}}
                                    <th>Type</th>
                                    <th>Capacité</th>
                                    <th>Prix/nuit (GNF)</th>
                                    <th>Réservé</th>
                                    {{-- <th>Avis</th> --}}
                                    <th>Vues</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $room)
                                    <tr>
                                        {{-- <td>{{ $loop->iteration }}</td> --}}
                                        <td>
                                            <div class="d-flex align-items-center file-name-icon">
                                                <div class="ms-2">
                                                    <h6 class="fw-medium">
                                                        <a href="{{ route('rooms.show', $room) }}">
                                                            {{ $room->name ?? 'N/A' }}
                                                        </a>
                                                    </h6>
                                                    <span class="fs-12 fw-normal">{{ $room->hotel->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td>{{ $room->hotel->name ?? 'N/A' }}</td> --}}
                                        <td>{{ $room->type ?? 'N/A' }}</td>
                                        <td>{{ $room->capacity ?? 'N/A' }} pers.</td>
                                        <td>
                                            {{ number_format($room->price ?? 0, 0, ',', ' ') }}
                                        </td>
                                        <td>{{ $room->bookings_count ?? 0 }} fois</td>
                                        {{-- <td>
                                            <span class="text-warning">
                                                @if ($room->reviews_count > 0)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            </span>
                                            {{ number_format($room->average_rating ?? 0, 1) }} ({{ $room->reviews_count ?? 0 }})
                                        </td> --}}
                                        <td>{{ $room->views_count ?? 0 }} fois</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="status[{{ $room->id }}]" value="0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="status[{{ $room->id }}]" value="1"
                                                    id="status-switch-{{ $room->id }}"
                                                    {{ $room->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-secondary" title="Modifier">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal" data-bs-target="#delete_modal" title="Supprimer"
                                                onclick="setDeleteLink({{ $room->id }})">
                                                <i class="ti ti-trash"></i>
                                            </a>

                                            <form action="{{ route('admin.rooms.duplicate', $room) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-dark" title="Dupliquer"
                                                        onclick="return confirm('Dupliquer cette chambre ?')">
                                                    <i class="ti ti-copy"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('media.index',['type'=>'room','key'  => $room->slug ?: $room->getKey()]) }}"
                                                class="btn btn-sm btn-info btn-icon"
                                                {{ $room->has_pending_submission ? 'disabled' : '' }}
                                                data-bs-toggle="tooltip" data-bs-title="Médias" aria-label="Médias">
                                                <i class="ti ti-photo-plus"></i>
                                            </a>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">Aucune chambre enregistrée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-3">
                        {{ $rooms->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- Add Room -->
<div class="modal fade" id="add_room">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter une nouvelle chambre</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pb-0">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Ex : Chambre Deluxe" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="hotel_id" class="form-label">Hôtel <span class="text-danger">*</span></label>
                            <select name="hotel_id" id="hotel_id" class="form-control" required>
                                <option value="">-- Sélectionner un hôtel --</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Type de chambre</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Simple">Simple</option>
                                    <option value="Double">Double</option>
                                    <option value="Twin">Twin</option>
                                    <option value="Triple">Triple</option>
                                    <option value="Suite">Suite</option>
                                    <option value="Familial">Familial</option>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Autre">Autre</option>
                                </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="address" class="form-label">Adresse (facultatif)</label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Si différente de celle de  l'hôtel">
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="capacity" class="form-label">Capacité (Nombre de personnes)</label>
                            <input type="number" name="capacity" id="capacity" class="form-control" placeholder="Ex : 2">
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Prix par nuit</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="Ex : 250000">
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

                        <div class="col-md-4 mb-3">
                            <label for="info" class="form-label">Informations supplémentaires</label>
                            <input type="text" name="info" id="info" class="form-control" placeholder="Ex : Mini-bar, balcon, TV écran plat">
                        </div>


                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brève description de la chambre, équipements, confort..."></textarea>
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
<!-- /Add Room -->


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
                    <form id="deleteForm" action="{{ route('admin.rooms.delete', ':id') }}" method="POST" style="display: inline;">
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
            var roomId = this.name.match(/\[(\d+)\]/)[1];
            var status = this.checked ? 1 : 0;

            // Send the update request via AJAX
            fetch(`/zpanel/rooms/status/${roomId}`, {
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
    function setDeleteLink(roomId) {
        var formAction = document.getElementById('deleteForm');
        formAction.action = formAction.action.replace(':id', roomId);
    }
</script>

@endsection
