@extends('backend.shop.layouts.master')
@section('title', 'Tableau de bord')
@section('content')

@php
    use App\Support\CurrentAccount;
    $u   = auth()->user();
    $acc = app(CurrentAccount::class)->account;
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
            <a href="{{ route('partners.shop.products.create') }}" class="btn btn-light btn-md me-2">
                <i class="ti ti-package me-2"></i>Nouveau Produit
            </a>
        </div>
    </div>
    <div class="welcome-bg">
        <img src="{{ asset('assets/back/img/bg/welcome-bg-02.svg') }}" alt="img" class="welcome-bg-01">
        <img src="{{ asset('assets/back/img/bg/welcome-bg-03.svg') }}" alt="img" class="welcome-bg-02">
        <img src="{{ asset('assets/back/img/bg/welcome-bg-01.svg') }}" alt="img" class="welcome-bg-03">
    </div>
</div>


<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card position-relative">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-md br-10 icon-rotate bg-danger flex-shrink-0">
                        <span class="d-flex align-items-center">
                            <i class="ti ti-shopping-bag text-white fs-16"></i>
                        </span>
                    </div>
                    <div class="ms-3">
                        <a href="{{ route('partners.shop.products.index') }}">
                                <p class="fw-medium text-truncate mb-1">Mes Produits</p>
                        </a>
                        <h5>{{ $totalProducts }}</h5>
                    </div>
                </div>
                <span class="position-absolute top-0 end-0">
                    <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                </span>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card position-relative">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-md br-10 icon-rotate bg-purple flex-shrink-0">
                        <span class="d-flex align-items-center">
                            <i class="ti ti-receipt text-white fs-16"></i>
                        </span>
                    </div>
                    <div class="ms-3">
                        <a href="{{ route('partners.shop.orders.index') }}">
                            <p class="fw-medium text-truncate mb-1">Mes Commandes</p>
                        </a>
                        <h5>{{ $totalOrders }}</h5>
                    </div>
                </div>
                <span class="position-absolute top-0 end-0">
                    <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                </span>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card position-relative">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-md br-10 icon-rotate bg-info flex-shrink-0">
                        <span class="d-flex align-items-center">
                            <i class="ti ti-list-check text-white fs-16"></i>
                        </span>
                    </div>
                    <div class="ms-3">
                        <a href="{{ route('partners.shop.submissions.index') }}">
                            <p class="fw-medium text-truncate mb-1">Mes demandes</p>
                        </a>
                        <h5>{{ $totalSubs }}</h5>
                    </div>
                </div>
                <span class="position-absolute top-0 end-0">
                    <img src="{{ asset('assets/back/img/bg/card-bg-04.png') }}" alt="">
                </span>
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
                        <a href="{{ route('partners.shop.products.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
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
                                <a href="{{ route('partners.shop.products.edit',$p) }}" class="avatar flex-shrink-0">
                                    <img src="{{ $img }}" class="rounded-circle border border-2" alt="{{ $p->name }}">
                                </a>
                                <div class="ms-1">
                                    <h6 class="fs-14 fw-bold text-truncate mb-1">
                                        <a href="{{ route('shop.products.show',$p) }}" class=" {{ $textColor }} text-decoration-none">
                                            {{ $p->name }}
                                        </a>
                                        {{-- @if ($p->category)
                                            <span class="badge bg-dark ms-1">{{ $p->category->name }}</span>
                                        @endif
                                        <span class="badge bg-light text-dark ms-1">
                                            {{ $p->type === 'variable' ? 'Variable' : 'Simple' }}
                                        </span> --}}
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
                                <a href="{{ route('partners.shop.products.edit',$p) }}" class="btn btn-sm btn-dark mt-1">
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
                        <a href="{{ route('partners.shop.orders.index') }}" class="btn btn-sm btn-primary px-3">Voir tout</a>
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

@endsection
