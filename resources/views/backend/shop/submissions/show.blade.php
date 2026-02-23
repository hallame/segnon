@extends('backend.shop.layouts.master')
@section('title','Demande #'.$submission->id)
@section('content')
<a href="{{ route('partners.shop.submissions.index') }}" class="btn btn-sm btn-light border mb-3">
  <i class="ti ti-arrow-left"></i> Retour
</a>

<div class="card">
  <div class="card-body">
    <h5 class="mb-3">Demande #{{ $submission->id }}</h5>

    <dl class="row">
      <dt class="col-sm-3">Objet</dt>
      <dd class="col-sm-9">{{ class_basename($submission->model_type) }} — {{ $submission->model->name ?? $submission->model->title ?? $submission->model->slug ?? ('#'.$submission->model_id) }}</dd>

      <dt class="col-sm-3">Action</dt>
      <dd class="col-sm-9 text-capitalize">{{ $submission->operation }}</dd>

      <dt class="col-sm-3">Statut</dt>
      <dd class="col-sm-9">{{ $submission->status->status ?? '—' }}</dd>

      <dt class="col-sm-3">Commentaire modération</dt>
      <dd class="col-sm-9">{{ $submission->comment ?? '—' }}</dd>

      {{-- @if($submission->changes)
      <dt class="col-sm-3">Changements</dt>
      <dd class="col-sm-9"><pre class="mb-0 small" style="white-space:pre-wrap">{{ json_encode($submission->changes, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre></dd>
      @endif --}}
    </dl>
  </div>
</div>
@endsection
