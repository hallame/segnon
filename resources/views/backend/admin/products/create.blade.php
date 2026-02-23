@extends('backend.admin.layouts.master')
@section('title','Créer un produit')
@section('content')
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="p-3">
  @csrf
  @include('backend.admin.products._form')
  <div class="mt-3 text-end">
    <button class="btn btn-primary">Enregistrer</button>
  </div>
</form>
@endsection
