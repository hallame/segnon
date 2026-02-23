@extends('backend.partners.layouts.master')
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
                <a href="{{ route('partners.rooms.create') }}" data-bs-effect="effect-newspaper"
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
                                    <th>#</th>
                                    <th>Chambre</th>
                                    <th>Hôtel</th>
                                    <th>Type</th>
                                    <th>Capacité</th>
                                    <th>À partir de</th>
                                    <th>Réservé</th>
                                    <th>Avis</th>
                                    <th>Vues</th>
                                     <th>Modération</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $room)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $room->name ?? 'N/A' }}</td>
                                        <td>{{ $room->hotel->name ?? 'N/A' }}</td>
                                        <td>{{ $room->type ?? 'N/A' }}</td>
                                        <td>{{ $room->capacity ?? 'N/A' }} pers.</td>
                                        <td>
                                            {{ number_format($room->price ?? 0, 0, ',', ' ') }} GNF / nuit
                                        </td>
                                        <td>{{ $room->reservations_count ?? 0 }} fois</td>
                                        <td>
                                            <span class="text-warning">
                                                @if ($room->reviews_count > 0)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            </span>
                                            {{ number_format($room->average_rating ?? 0, 1) }} ({{ $room->reviews_count ?? 0 }})
                                        </td>
                                        <td>{{ $room->views_count ?? 0 }} fois</td>
                                        <td>
                                            @if($room->has_pending_submission)
                                            <span class="badge bg-warning">En attente</span>
                                            @else
                                            <span class="badge bg-secondary">Aucune</span>
                                            @endif
                                        </td>


                                        <td>
                                            <div class="form-check form-switch">
                                                @if($room->status)
                                            <span class="badge bg-success">Publié</span>
                                            @else
                                            <span class="badge bg-danger">Non publié</span>
                                            @endif
                                                {{-- <input class="form-check-input js-status-switch"
                                                    type="checkbox"
                                                    data-url="{{ route('partners.rooms.toggle', $hotel) }}"
                                                    {{ $hotel->status ? 'checked' : '' }}> --}}
                                            </div>
                                    </td>
                                    <td class=" d-flex align-items-center gap-1 flex-nowrap text-nowrap">

                                        <a href="{{ route('rooms.show',$room) }}" target="_blank" class="me-2"><i class="ti ti-eye fs-20 text-info"></i></a>

                                        @can('rooms.update')
                                            <a href="{{ route('partners.rooms.edit',$room) }}" class="btn btn-sm btn-secondary btn-icon"
                                            data-bs-toggle="tooltip" data-bs-title="Modifier" aria-label="Modifier">
                                            <i class="ti ti-edit"></i>
                                            </a>
                                        @endcan

                                        @can('rooms.update')
                                            <form action="{{ route('partners.submissions.rooms.request',$room) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('{{ $room->status ? 'Demander la désactivation ?' : 'Demander l’activation ?' }}');">
                                            @csrf
                                            <input type="hidden" name="action" value="{{ $room->status ? 'deactivate' : 'activate' }}">
                                            <button type="submit"
                                                    class="btn btn-sm {{ $room->status ? 'btn-warning' : 'btn-primary' }} btn-icon"
                                                    {{ $room->has_pending_submission ? 'disabled' : '' }}
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="{{ $room->status ? 'Désactiver' : 'Activer' }}"
                                                    aria-label="{{ $room->status ? 'Désactiver' : 'Activer' }}">
                                                <i class="ti {{ $room->status ? 'ti-toggle-left' : 'ti-toggle-right' }}"></i>
                                            </button>
                                            </form>
                                        @endcan

                                        @can('rooms.delete')
                                            <form action="{{ route('partners.submissions.rooms.request',$room) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Demander la suppression ?');">
                                            @csrf
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon"
                                                    {{ $room->has_pending_submission ? 'disabled' : '' }}
                                                    data-bs-toggle="tooltip" data-bs-title="Supprimer" aria-label="Supprimer">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                            </form>
                                        @endcan

                                        @can('rooms.update')
                                            <a href="{{ route('media.index',['type'=>'room','key'  => $room->slug ?: $room->getKey()]) }}"
                                                class="btn btn-sm btn-info btn-icon"
                                                {{ $room->has_pending_submission ? 'disabled' : '' }}
                                                data-bs-toggle="tooltip" data-bs-title="Médias" aria-label="Médias">
                                                <i class="ti ti-photo-plus"></i>
                                            </a>
                                        @endcan
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
                    // Check if an error message is provided by the controller
                    if (data.error) {
                        toastr.error(data.error);
                    } else {
                        toastr.error('Échec de la mise à jour du statut.');
                    }
                }
            })
            .catch(() => toastr.error('Erreur lors de la mise à jour du statut.'));
        });
    });
</script>


@endsection
