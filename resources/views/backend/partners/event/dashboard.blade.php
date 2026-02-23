@extends('backend.partners.layouts.master')
@section('title', 'Tableau de bord')
@section('content')

@php
    use App\Support\CurrentAccount;
    $u   = auth()->user();
    $acc = app(CurrentAccount::class)->account;
    // Détection par permissions (simple & robuste)
    $hasHotel   = auth()->user()?->can('hotels.view-any')
            || auth()->user()?->can('rooms.view-any')
            || auth()->user()?->can('bookings.view');

    $hasArtisan = auth()->user()?->can('products.view-any')
           || auth()->user()?->can('orders.view');

    // Valeurs par défaut si le contrôleur n’en envoie pas
    $totalHotels   = $totalHotels   ?? 0;
    $totalRooms    = $totalRooms    ?? 0;
    $totalBookings = $totalBookings ?? 0;

    $totalProducts = $totalProducts ?? 0;
    $totalOrders   = $totalOrders   ?? 0;
    $totalRevenue  = $totalRevenue  ?? 0;

    $confirmedBookings       = $confirmedBookings       ?? 0;
    $pendingBookings         = $pendingBookings         ?? 0;
    $canceledBookings        = $canceledBookings        ?? 0;
    $confirmedBookingsPct    = $confirmedBookingsPct    ?? 0;
    $pendingBookingsPct      = $pendingBookingsPct      ?? 0;
    $canceledBookingsPct     = $canceledBookingsPct     ?? 0;
    $latestBookings = $latestBookings ?? collect();
    $latestOrders   = $latestOrders   ?? collect();
@endphp

{{-- Banner bienvenue --}}
<div class="welcome-wrap mb-2">
    <div class="d-flex align-items-center justify-content-between flex-wrap">
        <div class="mb-1">
            <h2 class="mb-1 text-white">
                Bienvenue, {{ $u?->firstname }} {{ $u?->lastname }} !
            </h2>
            {{-- @if($acc)
                <p class="text-white-50 mb-0">{{ $acc->name }}</p>
            @endif --}}
        </div>
        <div class="d-flex align-items-center flex-wrap mb-1">
            @can('hotels.create')
                <a href="{{ route('partners.hotels.create') }}" class="btn btn-dark btn-md me-2">
                    <i class="ti ti-circle-plus me-2"></i>Nouvel hôtel
                </a>
            @endcan
            @can('products.create')
                <a href="{{ route('partners.products.create') }}" class="btn btn-light btn-md me-2">
                    <i class="ti ti-package me-2"></i>Nouvel article
                </a>
            @endcan
        </div>
    </div>
    <div class="welcome-bg">
        <img src="{{ asset('assets/back/img/bg/welcome-bg-02.svg') }}" alt="img" class="welcome-bg-01">
        <img src="{{ asset('assets/back/img/bg/welcome-bg-03.svg') }}" alt="img" class="welcome-bg-02">
        <img src="{{ asset('assets/back/img/bg/welcome-bg-01.svg') }}" alt="img" class="welcome-bg-03">
    </div>
</div>


<div class="row">
    {{-- Cards Hôtellerie --}}
    @if($hasHotel)
        {{-- <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-primary flex-shrink-0">
                            <span class="d-flex align-items-center">
                                <i class="fa fa-hotel text-white fs-16"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <p class="fw-medium text-truncate mb-1">Hôtels</p>
                            <h5>{{ $totalHotels }}</h5>
                        </div>
                    </div>
                    <span class="position-absolute top-0 end-0">
                        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                    </span>
                </div>
            </div>
        </div> --}}

        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-secondary flex-shrink-0">
                            <span class="d-flex align-items-center">
                                <i class="fa fa-bed text-white fs-16"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <p class="fw-medium text-truncate mb-1">Chambres</p>
                            <h5>{{ $totalRooms }}</h5>
                        </div>
                    </div>
                    <span class="position-absolute top-0 end-0">
                        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-info flex-shrink-0">
                            <span class="d-flex align-items-center">
                                <i class="ti ti-calendar-check text-white fs-16"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <p class="fw-medium text-truncate mb-1">Réservations</p>
                            <h5>{{ $totalBookings }}</h5>
                        </div>
                    </div>
                    <span class="position-absolute top-0 end-0">
                        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                    </span>
                </div>
            </div>
        </div>
    @endif

    {{-- Cards Boutique d’art --}}
    @if($hasArtisan)
        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-danger flex-shrink-0">
                            <span class="d-flex align-items-center">
                                <i class="ti ti-shopping-bag text-white fs-16"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <p class="fw-medium text-truncate mb-1">Produits</p>
                            <h5>{{ $totalProducts }}</h5>
                        </div>
                    </div>
                    <span class="position-absolute top-0 end-0">
                        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-purple flex-shrink-0">
                            <span class="d-flex align-items-center">
                                <i class="ti ti-receipt text-white fs-16"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <p class="fw-medium text-truncate mb-1">Commandes</p>
                            <h5>{{ $totalOrders }}</h5>
                        </div>
                    </div>
                    <span class="position-absolute top-0 end-0">
                        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                    </span>
                </div>
            </div>
        </div>

        {{-- @can('finance.self.view')
        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-success flex-shrink-0">
                            <span class="d-flex align-items-center">
                                <i class="ti ti-currency-dollar text-white fs-16"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <p class="fw-medium text-truncate mb-1">Revenu (net)</p>
                            <h5>{{ number_format($totalRevenue, 0, ',', ' ') }} {{ $currency ?? 'GNF' }}</h5>
                        </div>
                    </div>
                    <span class="position-absolute top-0 end-0">
                        <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                    </span>
                </div>
            </div>
        </div>
        @endcan --}}
    @endif
</div>

{{-- Dernières réservations / commandes --}}
<div class="row">
    @if($hasHotel)
        <div class="col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                    <h5>Dernières réservations</h5>
                    <div>
                        <a href="{{ route('partners.bookings.index') }}" class="btn btn-sm btn-primary px-3">Voir tout</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($latestBookings->isEmpty())
                        @include('partials.empty')
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client</th>
                                        <th>Hôtel / Chambre</th>
                                        <th>Période</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestBookings as $bk)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $bk->customer_name ?? '--' }}</td>
                                            <td>{{ $bk->hotel?->name ?? '--' }} {{ $bk->room?->name ? ' / '.$bk->room->name : '' }}</td>
                                            <td>
                                                {{ optional($bk->start_date)->format('d/m/Y') }}
                                                — {{ optional($bk->end_date)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                @switch($bk->status)
                                                    @case('confirmed') <span class="badge bg-success">Confirmée</span> @break
                                                    @case('completed') <span class="badge bg-secondary">Terminée</span> @break
                                                    @case('cancelled') <span class="badge bg-danger">Annulée</span> @break
                                                    @default <span class="badge bg-warning">En attente</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('partners.bookings.show', $bk) }}" class="btn btn-sm btn-info">Détails</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<div class="row">
    @if($hasArtisan)
        <div class="col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                    <h5>Dernières commandes</h5>
                    <div>
                        <a href="{{ route('partners.orders.index') }}" class="btn btn-sm btn-primary px-3">Voir tout</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($latestOrders->isEmpty())
                        @include('partials.empty')
                    @else
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client</th>
                                        <th>Total</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrders as $order)
                                        <tr>
                                            <td>{{ $order->reference ?? $order->id }}</td>
                                            <td>{{ $order->customer_name ?? $order->customer?->fullname ?? '--' }}</td>
                                            <td>{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} {{ $currency ?? 'GNF' }}</td>
                                            <td>
                                                @switch($order->status)
                                                    @case('paid')      <span class="badge bg-success">Payée</span> @break
                                                    @case('cancelled') <span class="badge bg-danger">Annulée</span> @break
                                                    @case('refunded')  <span class="badge bg-secondary">Remboursée</span> @break
                                                    @default           <span class="badge bg-warning">En attente</span>
                                                @endswitch
                                            </td>
                                            <td>{{ optional($order->created_at)->format('d/m/Y') }}</td>
                                            <td><a href="{{ route('partners.orders.show', $order) }}" class="btn btn-sm btn-info">Détails</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
