@extends('backend.shop.layouts.master')
@section('title','Modifier produit')
@section('content')
<form method="POST" action="{{ route('partners.shop.products.update', $product) }}" enctype="multipart/form-data" class="p-3">
  @csrf
  @method('PUT')
  @include('backend.shop.products._form', ['product'=>$product])
  <div class="mt-3 text-end">
    <button class="btn btn-primary">Mettre à jour</button>
  </div>
</form>
@endsection
