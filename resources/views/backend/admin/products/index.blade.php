@extends('backend.admin.layouts.master')
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
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-2"></i>Ajouter un produit
            </a>

            <!-- Formulaire filtres -->
            <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                <input type="text" class="form-control" name="q"
                       value="{{ $q ?? '' }}"
                       placeholder="Rechercher par nom ..."
                       style="width:200px">

                {{-- <select name="category_id" class="form-select" style="width:auto">
                    <option value="">Catégorie…</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(($category ?? '')==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select> --}}

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
        {{-- <th>SKU</th> --}}
        <th>Prix ({{ $currency }})</th>
        <th>Stock/Vues</th>
        <th>Ajout</th>
        <th>Statut</th>
        <th class="text-nowrap">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $p)

        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.products.edit',$p) }}" class="avatar flex-shrink-0">
                        <img src="{{ asset('storage/'.$p->image) }}" class="rounded-circle border border-2" alt="{{ $p->name }}">
                    </a>
                    <div class="ms-1">
                        <div class="fw-semibold">{{ Str::limit($p->name, 30) }}</div>
                        <div class="text-muted small">
                          {{ $p->category->name ?? '—' }} 
                          {{-- <span class="badge bg-light text-dark">{{ $p->type === 'variable' ? '#Variable' : '#Simple' }}</span> --}}
                        </div>
                    </div>
                </div>
            </td>
            {{-- <td><code>{{ $p->sku ? Str::limit($p->sku, 10) : '—' }}</code></td> --}}
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
            <td>{{ $p->totalStock() }} u et {{ $p->views_count }} Vues</td>

            <td>{{ $p->created_at->translatedFormat('d/m/y à H:i') }}</td>
            <td>
                <div class="form-check form-switch">
                <input type="checkbox"
                        class="form-check-input me-2 product-switch"
                        role="switch"
                        data-id="{{ $p->id }}"
                        id="status-switch-{{ $p->id }}"
                        {{ $p->status ? 'checked' : '' }}>
                </div>
            </td>
            <td class="text-nowrap">
                <a href="{{ route('shop.products.show',$p) }}" target="_blank" class="me-2"><i class="ti ti-eye fs-20 text-info"></i></a>
                <a href="{{ route('admin.products.edit',$p) }}" class="me-2"><i class="ti ti-edit fs-20 text-secondary"></i></a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal" onclick="setDeleteLink({{ $p->id }})">
                <i class="ti ti-trash fs-20 text-danger"></i>
                </a>
            </td>
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
          <form id="deleteForm" action="{{ route('admin.products.destroy', ':id') }}" method="POST">
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
    document.querySelectorAll('.product-switch').forEach(cb => {
        cb.dataset.prev = cb.checked ? '1' : '0';
        cb.addEventListener('change', async () => {
        const id = cb.dataset.id;
        const url = '{{ route('admin.products.toggle', ':id') }}'.replace(':id', id);
        try {
            cb.disabled = true;
            const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify({ status: cb.checked ? 1 : 0 })
            });
            const data = await res.json().catch(()=>({success:false}));
            if (!res.ok || !data.success) throw new Error(data.message || 'Erreur serveur');
            cb.dataset.prev = cb.checked ? '1' : '0';
            toastr?.success?.('Statut mis à jour !');
        } catch(e) {
            cb.checked = cb.dataset.prev === '1';
            toastr?.error?.(e.message || 'Échec de la mise à jour.');
        } finally {
            cb.disabled = false;
        }
        });
    });

    window.setDeleteLink = function(id) {
        const form = document.getElementById('deleteForm');
        form.action = form.action.replace(':id', id);
    };
    });
</script>
@endsection
