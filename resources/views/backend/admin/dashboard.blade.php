@extends('backend.admin.layouts.master')
@section('title') Tableau de bord @endsection
@section('content')

    <!-- Welcome Wrap -->

    <div class="welcome-wrap mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="mb-3">
                <h2 class="mb-1 text-white">Bienvenue à bord, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }} !</h2>
            </div>
            <div class="d-flex align-items-center flex-wrap mb-1">
                <!-- Bouton Ajouter un Site -->
                {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#add_site" class="btn btn-dark btn-md me-2 mb-2">
                    <i class="ti ti-circle-plus me-2"></i>Ajouter un Site
                </a> --}}
                <!-- Bouton Ajouter une Réservation -->
                <a href="{{ route('admin.products.create') }}" class="btn btn-light btn-md mb-2">
                    <i class="ti ti-box me-2"></i>Ajouter un produit
                </a>
                {{-- <a href="#" class="btn btn-light btn-md mb-2">
                    <i class="ti ti-calendar me-2"></i>Ajouter une Réservation
                </a> --}}
            </div>
        </div>
        <div class="welcome-bg">
            <img src="{{ asset('assets/back/img/bg/welcome-bg-02.svg') }}" alt="img" class="welcome-bg-01">
            <img src="{{ asset('assets/back/img/bg/welcome-bg-03.svg') }}" alt="img" class="welcome-bg-02">
            <img src="{{ asset('assets/back/img/bg/welcome-bg-01.svg') }}" alt="img" class="welcome-bg-03">
        </div>
    </div>
    <!-- /Welcome Wrap -->
    <div class="row">
        <!-- Total des Sites -->
        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-primary flex-shrink-0">
                            <span class="d-flex align-items-center"><i class="ti ti-box text-white fs-16"></i></span>
                        </div>
                        <div class="ms-3">
                            <a href="{{ route('admin.products.index') }}">
                                <p class="fw-medium text-truncate mb-1">Produits</p>
                            </a>
                            <h5>{{ $totalProducts }}</h5>
                        </div>
                    </div>
                    {{-- <div class="progress progress-xs mb-2">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $totalSitesPercent }}%"></div>
                    </div> --}}
                    <span class="position-absolute top-0 end-0"><img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="Img"></span>
                </div>
            </div>
        </div>

        <!-- Total des Réservations -->
        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-secondary flex-shrink-0">
                            <span class="d-flex align-items-center"><i class="ti ti-list-check text-white fs-16"></i></span>
                        </div>
                        <div class="ms-3">
                            <a href="{{ route('admin.submissions.index') }}">
                                <p class="fw-medium text-truncate mb-1">Demandes</p>
                            </a>
                            <h5>{{ $totalSubs }}</h5>
                        </div>
                    </div>
                    {{-- <div class="progress progress-xs mb-2">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $totalBookingsPercent }}%"></div>
                    </div> --}}
                    <span class="position-absolute top-0 end-0"><img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="Img"></span>
                </div>
            </div>
        </div>

        <!-- Total des Clients -->
        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md br-10 icon-rotate bg-danger flex-shrink-0">
                            <span class="d-flex align-items-center"><i class="ti ti-users-group text-white fs-16"></i></span>
                        </div>
                        <div class="ms-3">
                            <p class="fw-medium text-truncate mb-1">Utilisateurs</p>
                            <h5>{{ $totalUsers }}</h5>
                        </div>
                    </div>
                    {{-- <div class="progress progress-xs mb-2">
                        <div class="progress-bar bg-pink" role="progressbar" style="width: {{ $totalClientsPercent }}%"></div>
                    </div> --}}
                    <span class="position-absolute top-0 end-0"><img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="Img"></span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">

                        <div class="avatar avatar-md br-10 icon-rotate bg-info flex-shrink-0">
                            <span class="d-flex align-items-center">
                                <i class="ti ti-receipt text-white fs-16"></i>
                            </span>
                        </div>

                        <div class="ms-3">
                            <a href="{{ route('admin.orders.index') }}">
                                <p class="fw-medium text-truncate mb-1">Commandes</p>
                            </a>
                            <h5>{{ $totalOrders }}</h5>
                        </div>
                    </div>
                    {{-- <div class="progress progress-xs mb-2">
                        <div class="progress-bar bg-purple" role="progressbar" style="width: {{ $totalGuidesPercent }}%"></div>
                    </div> --}}
                    <span class="position-absolute top-0 end-0"><img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="Img"></span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

    @php
        use Carbon\Carbon;
    @endphp

    {{-- Derniers produits --}}
    <div class="col-xl-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-0">Derniers produits</h5>
                    @if ($products->count())
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if ($products->count())
                    @foreach ($products->display as $p)
                        @php
                            $stock = $p->totalStock();

                            if (!$p->status) {
                                $statusText = 'Désactivé';
                                $bgColor    = 'bg-secondary text-white';
                                $textColor = 'text-white';
                            } elseif ($stock <= 0) {
                                $statusText = 'Rupture';
                                $bgColor    = 'bg-purple text-white';
                                $textColor = 'text-white';
                            } else {
                                $statusText = 'Actif';
                                $textColor = 'text-black';
                                $bgColor    = 'bg-light text-black';
                            }

                            [$min, $max] = $p->priceRange();
                            $media = $p->getFirstMedia('gallery');
                            $image  = $p->image;
                            $img = $image ? asset('storage/' . $image) : ($media ? asset('storage/' . $media->getPathRelativeToRoot()) : asset('assets/images/products.png'));

                        @endphp

                        <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded shadow-sm {{ $bgColor }}">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('admin.products.edit',$p) }}" class="avatar flex-shrink-0">
                                    <img src="{{ $img }}" class="rounded-circle border border-2" alt="{{ $p->name }}">
                                </a>
                                <div class="ms-1">
                                    <h6 class="fs-14 fw-bold text-truncate mb-1">
                                        <a href="{{ route('shop.products.show',$p) }}" class=" {{ $textColor }} text-decoration-none">
                                            {{ $p->name }}
                                        </a>
                                        
                                        <span class="badge bg-light text-dark ms-1">
                                            {{ $p->type === 'variable' ? 'Variable' : 'Simple' }}
                                        </span>
                                    </h6>

                                    <p class="fs-13 mb-0">
                                        💰
                                        @if($p->type === 'variable')
                                            @if(is_null($min))
                                                —
                                            @elseif($min == $max)
                                                <strong>{{ number_format($min, 0, '.', ' ') }} {{ $currency }}</strong>
                                            @else
                                                <strong>{{ number_format($min, 0, '.', ' ') }}–{{ number_format($max, 0, '.', ' ') }} {{ $currency }}</strong>
                                            @endif
                                        @else
                                            <strong>{{ number_format($min, 0, '.', ' ') }} {{ $currency }}</strong>
                                        @endif

                                        <span class="ms-2">• Stock : <strong>{{ $stock }}</strong></span>
                                        <span class="badge bg-primary ms-2">{{ $statusText }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-end">
                                {{-- @if($p->type !== 'variable' && $p->old_price)
                                    <span class="small text-decoration-line-through opacity-75">
                                        {{ number_format($p->old_price, 0, '.', ' ') }} {{ $currency }}
                                    </span>
                                @endif --}}
                                <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-sm btn-dark mt-1">
                                    <i class="ti ti-edit"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    @include('partials.empty')
                @endif
            </div>
        </div>
    </div>
    {{-- Dernières commandes --}}
    <div class="col-xl-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                    <h5>Dernières commandes</h5>
                    <div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary px-3">Voir tout</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    @if($orders->isEmpty())
                        @include('partials.empty')
                    @else
                        @php
                            $borderClasses = ['border-primary', 'border-info', 'border-success', 'border-danger', 'border-dark'];
                            $bgClasses     = ['bg-primary', 'bg-info', 'bg-success', 'bg-danger', 'bg-dark'];

                            $statusMap = [
                                \App\Models\Order::STATUS_PENDING      => 'bg-warning text-dark',
                                \App\Models\Order::STATUS_UNDER_REVIEW => 'bg-info',
                                \App\Models\Order::STATUS_PAID         => 'bg-success',
                                \App\Models\Order::STATUS_REJECTED     => 'bg-secondary',
                                \App\Models\Order::STATUS_CANCELLED    => 'bg-danger',
                                \App\Models\Order::STATUS_FULFILLED    => 'bg-primary',
                            ];
                        @endphp

                        @foreach ($orders->display as $o)
                            @php
                                $randomBorder = $borderClasses[array_rand($borderClasses)];
                                $randomBg     = $bgClasses[array_rand($bgClasses)];
                                $cls          = $statusMap[$o->status] ?? 'bg-light text-dark';
                            @endphp

                            <div class="border border-dashed bg-body-secondary rounded p-2 mb-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="d-block border border-3 {{ $randomBorder }} rounded-5 me-2" style="height: 50px;"></span>
                                        <div>
                                            <h6 class="fw-medium mb-1">
                                                <a href="{{ route('admin.orders.show',$o) }}" class="text-decoration-none text-dark">
                                                    #{{ $o->reference }}
                                                </a>
                                                <span class="badge {{ $cls }} ms-1">
                                                    {{ ucfirst(str_replace('_',' ',$o->status_label)) }}
                                                </span>
                                            </h6>
                                            <p class="mb-0 small text-muted">
                                                {{ $o->customer_firstname }} {{ $o->customer_lastname }} · {{ $o->customer_email }}
                                            </p>
                                            <p class="mb-0 small">
                                                Total :
                                                <strong>{{ number_format($o->total, 0, ' ', ' ') }} {{ $currency }}</strong>
                                                <span class="text-muted">
                                                    — {{ $o->created_at?->format('d/m/Y H:i') }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        {{ $o->customer_phone }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>


</div>
    {{-- <div class="row">
        <div class="col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                        <h5>Dernières Réservations</h5>
                        <div>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary px-3">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        @if($bookings->isEmpty())
                        @include('partials.empty')
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom du client</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings->display as $booking)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="#">
                                                    {{ $booking->user->firstname }} {{ $booking->user->lastname }}
                                                </a>

                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $booking->bookable_type_label }}</div>
                                                <div class="text-muted">{{ Str::limit($booking->bookable_name, 15) }}</div>
                                                <div class="small text-gray-500">#{{ $booking->bookable_id }}</div>
                                            </td>
                                            <td class="text-muted small">{{ $booking->created_at?->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($booking->status == 1)
                                                    <span class="badge bg-success">Confirmée</span>
                                                @elseif($booking->status == 2)
                                                    <span class="badge bg-danger">Annulée</span>
                                                @elseif($booking->status == 3)
                                                    <span class="badge bg-secondary">Terminée</span>
                                                @else
                                                    <span class="badge bg-warning">En attente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.bookings.show',$booking) }}" class="btn btn-sm btn-info">Détails</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                        <h5>Sites touristiques</h5>
                        <div>
                            <a href="{{ route('admin.sites') }}" class="btn btn-sm btn-primary px-3">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        @if($sites->isEmpty())
                        @include('partials.empty')
                        @else
                            @foreach ($sites->display as $site)
                                @php
                                    $borderClasses = ['border-primary', 'border-info', 'border-success', 'border-danger', 'border-dark'];
                                    $bgClasses = ['bg-primary', 'bg-info', 'bg-success', 'bg-danger', 'bg-dark'];

                                    $randomBorder = $borderClasses[array_rand($borderClasses)];
                                    $randomBg = $bgClasses[array_rand($bgClasses)];
                                @endphp

                                <div class="border border-dashed bg-body-secondary rounded p-2 mb-2">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="d-block border border-3 h-12 {{ $randomBorder }} rounded-5 me-2" style="height: 50px;"></span>
                                            <div>
                                                <h6 class="fw-medium mb-1">{{ Str::limit($site->name, 50) }}</h6>
                                                <h6 class="fw-medium mb-1 text-truncate">{{ Str::limit($site->name, 50) }} - {{ Str::limit($site->city, 50) }} {{ Str::limit($site->country->name ?? '--', 50) }}</h6>
                                                <p>
                                                    Ajouté le: {{ \Carbon\Carbon::parse($site->created_at)->format('d/m/Y') }} -
                                                    Modifié le: {{ \Carbon\Carbon::parse($site->updated_at)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="circle-border {{ $randomBg }} d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; border-radius: 50%; font-size: 14px;">
                                                <div class="text-black text-bold circle-border bg-body d-flex justify-content-center align-items-center"
                                                    style="width: 37px; height: 37px; border-radius: 50%; font-size: 14px; font-weight: 600">
                                                    {{ $site->views()->count() }}
                                                </div>
                                            </div>
                                            <span class="ms-2">Vues</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @php
            use Carbon\Carbon;
        @endphp
        <div class="col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h5 class="mb-0">Derniers Événements</h5>
                        @if ($events->count())
                            <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if ($events->count())
                        @foreach ($events->display as $event)
                            @php
                                $today = Carbon::today();
                                $start = Carbon::parse($event->start_date);
                                $end = Carbon::parse($event->end_date);

                                // Déterminer le statut de l'événement
                                if ($end->isPast()) {
                                    $status = "Passé";
                                    $bgColor = "bg-purple"; // Gris
                                } elseif ($start->isFuture()) {
                                    $status = "À venir";
                                    $bgColor = "bg-secondary";
                                } else {
                                    $status = "En cours";
                                    $bgColor = "bg-success"; // Vert
                                }

                            @endphp

                            <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded shadow-sm {{ $bgColor }} text-white">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('admin.events.index') }}" class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/images/event.png') }}" class="rounded-circle border border-2" alt="Événement">
                                    </a>
                                    <div class="ms-3">
                                        <h6 class="fs-14 fw-bold text-truncate mb-1">
                                            <a href="{{ route('admin.events.index') }}" class="text-white text-decoration-none">
                                                {{ $event->name }}
                                            </a>
                                            @if ($event->category)
                                                <span class="badge bg-dark">{{ $event->category->name }}</span>
                                            @endif
                                        </h6>
                                        <p class="fs-13 mb-0">
                                            📅 Du <strong>{{ $start->format('d/m/Y') }}</strong> au <strong>{{ $end->format('d/m/Y') }}</strong>    <span class="badge bg-primary">{{ $status }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold fs-20">
                                        <i class="ti ti-user-check fs-20"></i>
                                        {{ $event->Bookings->count() }}</span>
                                </div>
                                 <div class="d-flex align-items-center">
                                    <span class="fw-bold fs-20">
                                        <i class="ti ti-eye fs-20"></i>
                                        {{ $event->views()->count() }}</span>
                                </div>

                            </div>
                        @endforeach
                    @else
                    @include('partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row">
        <div class="col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                    <h5>Nouveaux Clients</h5>
                    <div class="d-flex align-items-center">
                        <div>
                            <a href="{{ route('admin.users.customers') }}" class="btn btn-md btn-primary px-3">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        @if($clients->isEmpty())
                        @include('partials.empty')
                        @else
                            <table class="table table-nowrap dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom du client</th>
                                        <th>Téléphone</th>
                                        <th>Email</th>
                                        <th>Ville/Pays</th>
                                        <th>Inscrit le</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients->display as $client)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <h6 class="fw-medium">
                                                            <a href="#">
                                                                {{ $client->firstname }} {{ $client->lastname }}
                                                            </a>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center file-name-icon">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium">{{ $client->phone }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $client->email }}
                                                </td>
                                                <td>
                                                    {{ $client->city ?? '--' }} {{ $client->country ?? '--' }}
                                                </td>


                                                    <td>{{ \Carbon\Carbon::parse($client->created_at)->format('d/m/Y') }}</td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h5>Partenaires</h5>
                        <div>
                            <a href="#" class="btn btn-sm btn-primary px-3">Voir Tout</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                        @if ($partners->isNotEmpty())
                            @foreach ($partners->display as $partner)
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/images/senior.png') }}" class="rounded-circle border border-2" alt="img">
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fs-14 fw-medium text-truncate mb-1">
                                                <a >{{ $partner->company ?? 'Non-fournie' }}</a>
                                            </h6>
                                            <span class="badge {{ $partner->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $partner->status == 1 ? 'Actif' : 'Inactif' }}
                                            </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="tel:{{ $partner->phone }}" class="btn text-success btn-icon btn-sm me-2">
                                            <i class="ti ti-phone fs-16"></i>
                                        </a>
                                        <a href="mailto:{{ $partner->email }}" class="btn text-secondary btn-icon btn-sm me-2">
                                            <i class="ti ti-mail-bolt fs-16"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        @include('partials.empty')
                        @endif
                </div>
            </div>
        </div>


        <div class="col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                        <h5>Statistiques Réservations</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="reservations"></div>
                    <div>
                        <h6 class="mb-3">Reservations</h6>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <p class="f-13 mb-0"><i class="ti ti-circle-filled text-success me-1"></i>Confirmés</p>
                            <p class="f-13 fw-medium text-gray-9">{{ $confirmedBookingsPercent }}%</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <p class="f-13 mb-0"><i class="ti ti-circle-filled text-warning me-1"></i>En Attente</p>
                            <p class="f-13 fw-medium text-gray-9">{{ $pendingBookingsPercent }}%</p>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <p class="f-13 mb-0"><i class="ti ti-circle-filled text-danger me-1"></i>Annulés</p>
                            <p class="f-13 fw-medium text-gray-9">{{ $canceledBookingsPercent }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <script>
        window.chartLabels = ['Confirmés', 'En Attente', 'Annulés'];
        window.chartData = {!! json_encode([
            $confirmedBookings ?? 0,
            $pendingBookings ?? 0,
            $canceledBookings ?? 0
        ]) !!};
        window.chartDatasetLabel = {!! json_encode($totalBookings ?? 0) !!};
    </script> --}}

@endsection

