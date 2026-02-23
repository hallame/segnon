@extends('backend.admin.layouts.master')
@section('title', 'Ajouter un type de ticket')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-3">Ajouter un type de ticket</h1>

        @include('backend.admin.tickets.types._form', [
            'type' => null,
            'events' => $events, // passe la collection d'événements depuis le controller
            'action' => route('admin.ticket_types.store'),
        ])
    </div>
@endsection
