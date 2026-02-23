@extends('backend.partners.layouts.master')
@section('title','Mes Hôtels')

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
        {{-- Filtre par statut --}}
        <div class="dropdown me-3">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-white" data-bs-toggle="dropdown">Sélectionner le statut</a>
          <ul class="dropdown-menu dropdown-menu-end p-3">
            <li><a href="{{ route('partners.hotels.index', collect(request()->query())->except('status')->all()) }}" class="dropdown-item">Tous</a></li>
            <li><a href="{{ route('partners.hotels.index', array_merge(request()->query(), ['status'=>'active'])) }}" class="dropdown-item">Actifs</a></li>
            <li><a href="{{ route('partners.hotels.index', array_merge(request()->query(), ['status'=>'inactive'])) }}" class="dropdown-item">Inactifs</a></li>
          </ul>
        </div>
        {{-- Filtre période (sans "Récemment ajoutés") --}}
        @php $periodLabel = match(request('period')) { 'last_month'=>'Dernier mois','last_7_days'=>'Derniers 7 jours', default=>'Tous' }; @endphp
        <div class="dropdown">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-white" data-bs-toggle="dropdown">Trier par : {{ $periodLabel }}</a>
          <ul class="dropdown-menu dropdown-menu-end p-3">
            <li><a href="{{ route('partners.hotels.index', collect(request()->query())->except('period')->all()) }}" class="dropdown-item">Tous</a></li>
            <li><a href="{{ route('partners.hotels.index', array_merge(collect(request()->query())->except('period')->all(), ['period'=>'last_month'])) }}" class="dropdown-item">Dernier mois</a></li>
            <li><a href="{{ route('partners.hotels.index', array_merge(collect(request()->query())->except('period')->all(), ['period'=>'last_7_days'])) }}" class="dropdown-item">Derniers 7 jours</a></li>
          </ul>
        </div>
      </div>

      @can('hotels.create')
      <div>
        <a href="{{ route('partners.hotels.create') }}" class="btn btn-primary">
          <i class="ti ti-circle-plus me-2"></i>Ajouter un Hôtel
        </a>
      </div>
      @endcan
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
                    <th>Réservé</th>
                    <th>Avis</th>
                    <th>Vues</th>
                    <th>Modération</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($hotels as $hotel)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $hotel->name ?? 'N/A' }}</td>
                  <td>{{ $hotel->rooms_count ?? 0 }}</td>
                  <td>{{ $hotel->category->name ?? 'N/A' }}</td>
                  <td>{{ $hotel->city ?? 'N/A' }} - {{ $hotel->country->name ?? 'N/A' }}</td>
                  <td>
                    @if($hotel->rooms_count)
                      {{ number_format($hotel->rooms->min('price') ?? 0, 0, ',', ' ') }} GNF / nuit
                    @else
                      —
                    @endif
                  </td>

                    <td>{{ $hotel->bookings_count ?? 0 }} fois</td>
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
                    <td>{{ $hotel->views_count ?? 0 }} fois</td>


                  <td>
                    @if($hotel->has_pending_submission)
                      <span class="badge bg-warning">En attente</span>
                    @else
                      <span class="badge bg-secondary">Aucune</span>
                    @endif
                  </td>
                  <td>
                        <div class="form-check form-switch">
                            @if($hotel->status)
                        <span class="badge bg-success">Publié</span>
                        @else
                        <span class="badge bg-danger">Non publié</span>
                        @endif
                            {{-- <input class="form-check-input js-status-switch"
                                type="checkbox"
                                data-url="{{ route('partners.hotels.toggle', $hotel) }}"
                                {{ $hotel->status ? 'checked' : '' }}> --}}
                        </div>
                  </td>
                    <td>
                        <a href="{{ route('hotels.show',$hotel) }}" target="_blank" class="me-2"><i class="ti ti-eye fs-20 text-info"></i></a>
                        @can('hotels.update')
                            <a href="{{ route('partners.hotels.edit', $hotel) }}"
                            class="btn btn-sm btn-secondary btn-icon"
                            data-bs-toggle="tooltip" data-bs-title="Modifier" aria-label="Modifier">
                            <i class="ti ti-edit"></i>
                            </a>
                        @endcan

                        @can('hotels.update')
                            <form action="{{ route('partners.submissions.hotels.request', $hotel) }}" method="POST"
                                onsubmit="return confirm('{{ $hotel->status ? 'Demander la désactivation ?' : 'Demander l’activation ?' }}');"
                                class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="{{ $hotel->status ? 'deactivate' : 'activate' }}">
                                <button type="submit"
                                        class="btn btn-sm {{ $hotel->status ? 'btn-warning' : 'btn-primary' }} btn-icon"
                                        {{ $hotel->has_pending_submission ? 'disabled' : '' }}
                                        data-bs-toggle="tooltip"
                                        data-bs-title="{{ $hotel->status ? 'Désactiver' : 'Activer' }}"
                                        aria-label="{{ $hotel->status ? 'Désactiver' : 'Activer' }}">
                                    <i class="ti {{ $hotel->status ? 'ti-toggle-left' : 'ti-toggle-right' }}"></i>
                                </button>
                            </form>
                        @endcan

                        @can('hotels.delete')
                            <form action="{{ route('partners.submissions.hotels.request', $hotel) }}" method="POST"
                                onsubmit="return confirm('Demander la suppression ?');" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="delete">
                                <button type="submit"
                                        class="btn btn-sm btn-danger btn-icon"
                                        {{ $hotel->has_pending_submission ? 'disabled' : '' }}
                                        data-bs-toggle="tooltip" data-bs-title="Supprimer" aria-label="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        @endcan

                        @can('hotels.update')
                            <a href="{{ route('media.index',['type'=>'room','key'  => $hotel->slug ?: $hotel->getKey()]) }}"
                                class="btn btn-sm btn-info btn-icon"
                                {{ $hotel->has_pending_submission ? 'disabled' : '' }}
                                data-bs-toggle="tooltip" data-bs-title="Médias" aria-label="Médias">
                                <i class="ti ti-photo-plus"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-end mt-3">
            {{ $hotels->withQueryString()->links('pagination::bootstrap-5') }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
  .btn-icon{width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center}
</style>
<script>
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
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
