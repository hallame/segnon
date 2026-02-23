@extends('backend.admin.layouts.master')
@section('title') Modifier Événement @endsection

@section('content')
  @include('backend.admin.events._form', [
    'event'      => $event,
    'languages'  => $languages,
    'categories' => $categories,
    // défaut = route('admin.events.update', $event->id)
  ])
@endsection
