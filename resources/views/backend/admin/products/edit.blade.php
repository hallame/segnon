@extends('backend.admin.layouts.master')
@section('title','Modifier produit')
@section('content')
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="p-3">
  @csrf
  @method('PUT')
  @include('backend.admin.products._form', ['product'=>$product])
  <div class="mt-3 text-end">
    <button class="btn btn-primary">Mettre à jour</button>
  </div>
</form>
@endsection
