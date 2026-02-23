@extends('backend.admin.layouts.master')
@section('title', 'Modifier le type de ticket')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-3">Modifier : {{ $type->name }}</h1>

        @include('backend.admin.tickets.types._form', [
            'type' => $type,
            'events' => $events,
            // action par défaut calculée dans le partial, mais on précise pour être explicite
            'action' => route('admin.ticket_types.update', $type->id),
        ])
    </div>
@endsection
