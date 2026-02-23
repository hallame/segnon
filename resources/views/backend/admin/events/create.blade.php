@extends('backend.admin.layouts.master')
@section('title') Ajouter Événement @endsection

@section('content')
  @include('backend.admin.events._form', [
    'event'      => null,
    'languages'  => $languages,
    'categories' => $categories,
    'action'     => route('admin.events.store'),
  ])
@endsection
