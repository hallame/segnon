@extends('backend.shop.layouts.master')
@section('title','Mes demandes')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Mes demandes </h5>
  <form class="d-flex gap-2">
    {{-- <select name="type" class="form-select form-select-sm" style="width:auto">
      <option value="">— Type —</option>
      <option value="hotel" @selected(request('type')==='hotel')>Hôtel</option>
      <option value="room"  @selected(request('type')==='room')>Chambre</option>
      <option value="room"  @selected(request('type')==='product')>Article</option>
    </select> --}}
    <select name="status" class="form-select form-select-sm" style="width:auto">
      <option value="">— Statut —</option>
      <option value="pending"  @selected(request('status')==='pending')>En attente</option>
      <option value="approved" @selected(request('status')==='approved')>Approuvée</option>
      <option value="rejected" @selected(request('status')==='rejected')>Rejetée</option>
    </select>
    <button class="btn btn-sm btn-primary">Filtrer</button>
  </form>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>Date</th>
          <th>Produit</th>
          <th>Action</th>
          <th>Statut</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($subs as $s)
          @php
            $badge = [
              'pending'  => 'badge bg-warning text-dark',
              'approved' => 'badge bg-success',
              'rejected' => 'badge bg-danger',
            ][$s->status->slug ?? ''] ?? 'badge bg-secondary';

            $model = $s->model;
            $name  = $model->name ?? $model->title ?? $model->slug ?? ('#'.$s->model_id);
            $type  = class_basename($s->model_type);
          @endphp
          <tr>
            <td class="text-muted small">{{ $s->submitted_at?->format('d/m/Y H:i') ?? $s->created_at->format('d/m/Y H:i') }}</td>
            <td>
                {{-- <div class="fw-semibold">{{ $type }}</div> --}}
                <div class="fw-semibold">{{ Str::limit($name, 50) }}</div>
            </td>
            <td class="text-capitalize">{{ $s->operation }}</td>
            <td><span class="{{ $badge }}">{{ $s->status->status ?? '—' }}</span></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('partners.shop.submissions.show', $s) }}">
                Voir
              </a>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Aucune demande.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $subs->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
</div>
@endsection
