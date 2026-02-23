@extends('backend.partners.layouts.master')
@section('title','Modifier produit')
@section('content')
<form method="POST" action="{{ route('partners.products.update', $product) }}" enctype="multipart/form-data" class="p-3">
  @csrf
  @method('PUT')
  @include('backend.partners.products._form', ['product'=>$product])
  <div class="mt-3 text-end">
    <button class="btn btn-primary">Mettre à jour</button>
  </div>
</form>
@endsection
