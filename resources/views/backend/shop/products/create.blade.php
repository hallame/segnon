@extends('backend.shop.layouts.master')
@section('title','Créer un produit')
@section('content')
<form method="POST" action="{{ route('partners.shop.products.store') }}" enctype="multipart/form-data" class="p-3">
  @csrf
  @include('backend.shop.products._form')
  <div class="mt-3 text-end">
    <button class="btn btn-primary">Enregistrer</button>
  </div>
</form>
@endsection
