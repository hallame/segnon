@extends('backend.admin.layouts.master')
@section('title','Ajouter une page')
@section('content')
  @include('backend.admin.pages._form', [
    'page'      => null,
    'languages' => $languages,
  ])
@endsection
