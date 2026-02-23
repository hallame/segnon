@extends('backend.admin.layouts.master')
@section('title') Modifier une Chambre @endsection
@section('content')
    <div class="row align-items-center mb-4">
        <div class="d-md-flex d-sm-block justify-content-between align-items-center flex-wrap">
            <h6 class="fw-medium d-inline-flex align-items-center mb-3 mb-sm-0"><a href="{{ route('admin.rooms') }}">
                <i class="ti ti-arrow-left me-2"></i>Retour</a>
            </h6>
            <div class="d-flex">
                <div class="text-end">
                    <a href="{{ route('media.index', ['type'=>'room','key'  => $room->slug ?: $room->getKey()]) }}"
                        class="btn btn-success">
                        <i class="ti ti-photo-plus me-1"></i> Ajouter des médias
                    </a>
                </div>
                <div class="head-icons ms-2 text-end">
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('backend.admin.rooms._form', ['room' => $room, 'hotels' => $hotels, 'facilities' => $facilities, 'submitLabel' => 'Mettre à jour'])
    </form>
@endsection
