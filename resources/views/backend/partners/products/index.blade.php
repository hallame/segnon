@extends('backend.partners.layouts.master')
@section('title','Produits')
@section('content')

{{-- Bandeau Stats --}}
<div class="row mb-3">
  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-primary-transparent border border-primary me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-package fs-18 text-primary"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Total produits</p>
            <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-success-transparent border border-success me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-circle-check fs-18 text-success"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Actifs</p>
            <h4 class="mb-0">{{ $stats['active'] ?? 0 }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-danger-transparent border border-danger me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-circle-x fs-18 text-danger"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Inactifs</p>
            <h4 class="mb-0">{{ $stats['inactive'] ?? 0 }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="p-2 br-10 bg-info-transparent border border-info me-2 d-flex align-items-center justify-content-center">
            <i class="ti ti-box fs-18 text-info"></i>
          </span>
          <div>
            <p class="fs-12 fw-medium mb-1 text-gray-5">Variantes (SKUs)</p>
            <h4 class="mb-0">{{ $stats['variants'] ?? 0 }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
    <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

            <!-- Bouton Ajouter -->
            <a href="{{ route('partners.products.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-2"></i>Ajouter un produit
            </a>
            <!-- Formulaire filtres -->
            <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                <input type="text" class="form-control" name="q"
                       value="{{ $q ?? '' }}"
                       placeholder="Rechercher par nom ..."
                       style="width:200px">

                <select name="category_id" class="form-select" style="width:auto">
                    <option value="">Catégorie…</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(($category ?? '')==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>

                <select name="type" class="form-select" style="width:auto">
                    <option value="">Type…</option>
                    <option value="simple" @selected(($type ?? '')==='simple')>Simple</option>
                    <option value="variable" @selected(($type ?? '')==='variable')>Variable</option>
                </select>

                <select name="status" class="form-select" style="width:auto">
                    <option value="" @selected(($status ?? '')==='')>Tous</option>
                    <option value="1" @selected(($status ?? '')==='1')>Actifs</option>
                    <option value="0" @selected(($status ?? '')==='0')>Inactifs</option>
                </select>

                <button class="btn btn-black">Filtrer</button>
            </form>
        </div>
    </div>
</div>

<div class="table-responsive border rounded">
  @if($products->count())
  <table class="table align-middle">
    <thead>
      <tr>
        <th>Nom</th>
        <th>SKU</th>
        <th>Prix ({{ $currency }})</th>
        <th>Stock</th>
        <th>Type</th>
        <th>Catégorie</th>
        <th>Statut</th>
        <th class="text-nowrap">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $p)
        <tr>
            <td>
                <div class="fw-semibold">{{ $p->name }}</div>
                <div class="text-muted small">{{ $p->slug }}</div>
            </td>
            <td><code>{{ $p->sku ? Str::limit($p->sku, 10) : '—' }}</code></td>
            <td>
                @php
                    [$min,$max] = $p->priceRange();
                @endphp

                <div class="fw-semibold">
                    @if($p->type === 'variable')
                        @if(is_null($min)) —
                        @elseif($min == $max)
                            {{ number_format($min, 0, '.', ' ') }}
                        @else
                            {{ number_format($min, 0, '.', ' ') }}–{{ number_format($max, 0, '.', ' ') }}
                        @endif
                    @else
                        {{ number_format($min, 0, '.', ' ') }}
                    @endif
                </div>

                @if($p->type !== 'variable' && $p->old_price)
                    <div class="text-muted small">
                    <s>{{ number_format($p->old_price, 0, '.', ' ') }}</s>
                    </div>
                @endif
            </td>
            <td>{{ $p->totalStock() }}</td>

            <td><span class="badge bg-light text-dark">{{ $p->type === 'variable' ? 'Variable' : 'Simple' }}</span></td>
            <td>{{ $p->category->name ?? '—' }}</td>
            <td>

                <div class="form-check form-switch">
                    <input class="form-check-input js-status-switch" type="checkbox"
                    data-url="{{ route('partners.products.toggle', $p) }}"
                    {{ $p->status ? 'checked' : '' }}>
                </div>

            </td>

            <td class="d-flex align-items-center gap-1 flex-nowrap text-nowrap">
                {{-- Voir fiche public --}}
                <a href="{{ route('shop.products.show',$p) }}" target="_blank"
                    class="btn btn-sm btn-info btn-icon" data-bs-toggle="tooltip" data-bs-title="Voir">
                    <i class="ti ti-eye"></i>
                </a>

                @can('products.update')
                    {{-- Éditer --}}
                    <a href="{{ route('partners.products.edit',$p) }}"
                    class="btn btn-sm btn-secondary btn-icon" data-bs-toggle="tooltip" data-bs-title="Modifier">
                    <i class="ti ti-edit"></i>
                    </a>

                    {{-- Activer / Désactiver (via submission) --}}
                    <form action="{{ route('partners.submissions.products.request',$p) }}" method="POST"
                        class="d-inline"
                        onsubmit="return confirm('{{ $p->status ? 'Demander la désactivation ?' : 'Demander l’activation ?' }}');">
                    @csrf
                    <input type="hidden" name="action" value="{{ $p->status ? 'deactivate' : 'activate' }}">
                    <button type="submit"
                            class="btn btn-sm {{ $p->status ? 'btn-warning' : 'btn-primary' }} btn-icon"
                            {{ $p->has_pending_submission ? 'disabled' : '' }}
                            data-bs-toggle="tooltip"
                            data-bs-title="{{ $p->status ? 'Désactiver' : 'Activer' }}">
                        <i class="ti {{ $p->status ? 'ti-toggle-left' : 'ti-toggle-right' }}"></i>
                    </button>
                    </form>
                @endcan

                @can('products.delete')
                    {{-- Supprimer (via submission) --}}
                    <form action="{{ route('partners.submissions.products.request',$p) }}" method="POST"
                        class="d-inline" onsubmit="return confirm('Demander la suppression ?');">
                    @csrf
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="btn btn-sm btn-danger btn-icon"
                            {{ $p->has_pending_submission ? 'disabled' : '' }}
                            data-bs-toggle="tooltip" data-bs-title="Supprimer">
                        <i class="ti ti-trash"></i>
                    </button>
                    </form>
                @endcan

                {{-- @can('products.update')
                    <a href="{{ route('media.index',['type'=>'product','key'=>$p->slug ?: $p->getKey()]) }}"
                    class="btn btn-sm btn-info btn-icon"
                    {{ $p->has_pending_submission ? 'disabled' : '' }}
                    data-bs-toggle="tooltip" data-bs-title="Médias">
                    <i class="ti ti-photo-plus"></i>
                    </a>
                @endcan --}}

                {{-- Badge "en attente" --}}
                @if($p->has_pending_submission)
                    <span class="badge bg-warning text-dark" data-bs-toggle="tooltip" data-bs-title="Demande en attente">En attente</span>
                @endif
                </td>

            {{-- <td class="text-nowrap">
                <a href="{{ route('shop.products.show',$p) }}" class="me-2"><i class="ti ti-eye fs-20 text-info"></i></a>
                <a href="{{ route('partners.products.edit',$p) }}" class="me-2"><i class="ti ti-edit fs-20 text-secondary"></i></a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal" onclick="setDeleteLink({{ $p->id }})">
                <i class="ti ti-trash fs-20 text-danger"></i>
                </a>
            </td> --}}
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-3 px-2">
    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
  @else
    @include('partials.empty')
  @endif
</div>

{{-- Delete modal --}}
<div class="modal fade" id="delete_modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
          <i class="ti ti-trash-x fs-36"></i>
        </span>
        <h4 class="mb-1">Supprimer le produit ?</h4>
        <p class="mb-3">Action irréversible.</p>
        <div class="d-flex justify-content-center">
          <a href="#" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</a>
          <form id="deleteForm" action="{{ route('partners.products.destroy', ':id') }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Oui, supprimer</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    window.setDeleteLink = function(id) {
        const form = document.getElementById('deleteForm');
        form.action = form.action.replace(':id', id);
    };
    });
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
