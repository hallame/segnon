@extends('backend.admin.layouts.master')
@section('title','Modifier Page')
@section('content')
  @include('backend.admin.pages._form', [
    'page'      => $page,
    'languages' => $languages,
  ])
@endsection
