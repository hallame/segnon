@extends('backend.admin.layouts.master')
@section('title') Ajouter un Hôtel @endsection
@section('content')
    <div class="row align-items-center mb-4">
        <div class="d-md-flex d-sm-block justify-content-between align-items-center flex-wrap">
            <h6 class="fw-medium d-inline-flex align-items-center mb-3 mb-sm-0"><a href="{{ route('admin.hotels') }}">
                <i class="ti ti-arrow-left me-2"></i>Retour</a>
            </h6>
            <div class="d-flex">
                <div class="text-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary"><i class="ti ti-circle-arrow-up me-1"></i>Tableau de board</a>
                </div>
                <div class="head-icons ms-2 text-end">
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('admin.hotel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('backend.admin.hotels._form', [
            'hotel'      => null,
            'countries'  => $countries,
            'categories' => $categories,
            'facilities' => $facilities,
            'accounts'   => $accounts,   // fourni par le controller admin
            'isAdmin'    => true,
            'submitText' => 'Créer'
            ])
    </form>
@endsection
