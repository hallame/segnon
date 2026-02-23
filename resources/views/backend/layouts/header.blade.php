@php
  use App\Support\CurrentAccount;
  $u = auth()->user();
  $account = app(CurrentAccount::class)->account;
  $mods = $account?->modules()->wherePivot('is_enabled', true)->pluck('slug')->toArray() ?? [];
  $hasHotel   = in_array('hotel', $mods, true);
  $hasArtisan = in_array('artisan', $mods, true);

  // Route de recherche par défaut: produits si "artisan", sinon réservations si "hotel"
  $searchAction = $hasArtisan
      ? route('partners.products.index')
      : ($hasHotel ? route('partners.bookings.index') : '#');
  $searchPlaceholder = $hasArtisan ? "Rechercher un article…" : ($hasHotel ? "Rechercher une réservation…" : "Recherche…");
@endphp

<!-- Header -->
<div class="header">
  <div class="main-header">
    <div class="header-left">
      <a href="{{ route('partners.dashboard') }}" class="logo-text logo logo-normal">
        @if($account)
            <span class="ms-2 badge bg-success-subtle text-success fw-semibold" style="border-radius:8px;">
            {{ $account->name }}
            </span>
        @else
            Zaly Merveille
        @endif
      </a>

    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
      <span class="bar-icon"><span></span><span></span><span></span></span>
    </a>


    <div class="header-user">
      <div class="nav user-menu nav-list">

        <div class="me-auto d-flex align-items-center" id="header-search">
          <div class="input-group input-group-flat d-inline-flex me-2">
            <span class="input-icon-addon"><i class="ti ti-search"></i></span>
            <form action="{{ $searchAction }}" method="GET" class="d-flex align-items-center gap-2">
              <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="{{ $searchPlaceholder }}">
            </form>
          </div>

          <a href="{{ route('home') }}" class="btn btn-menubar me-1" target="_blank" title="Voir le site">
            <i class="ti ti-world"></i>
          </a>
          <a href="#" class="btn btn-menubar btnFullscreen" title="Plein écran">
            <i class="ti ti-maximize"></i>
          </a>
        </div>

        <div class="d-flex align-items-center">

            {{-- @php
                $u = Auth::user();
                $currentId = (int) session('current_account_id', 0);
                $accounts  = $u?->accounts()
                    ->select('accounts.id','accounts.name','accounts.slug')
                    ->withPivot('is_owner')
                    ->orderBy('accounts.name')
                    ->get();
                $platformSlug = config('app.platform_account_slug', 'platform');
                $label = function($acc) use ($platformSlug) {
                    $isPlatform = ($acc->slug === $platformSlug) || (property_exists($acc,'is_platform') && $acc->is_platform);
                    if ($isPlatform) return ($acc->pivot?->is_owner) ? 'Super admin' : 'Administration';
                    return $acc->name;
                };
            @endphp

            @if($u && $accounts->count() > 1)
            <div class="dropdown me-2">
                <a class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" href="#">
                {{ $accounts->firstWhere('id',$currentId)?->name ?? 'Sélectionner un compte' }}
                </a>
                <div class="dropdown-menu">
                @foreach($accounts as $acc)
                    <form action="{{ route('partners.switch') }}" method="POST">
                    @csrf
                    <input type="hidden" name="account_id" value="{{ $acc->id }}">
                    <input type="hidden" name="redirect"   value="{{ url()->current() }}">
                    <button type="submit" class="dropdown-item {{ $currentId === (int)$acc->id ? 'active' : '' }}">
                        {{ $label($acc) }}
                    </button>
                    </form>
                @endforeach
                </div>
            </div>
            @endif --}}


        {{-- @php
            $u = Auth::user();
            $accountId = (int) session('current_account_id', 0);
            $accounts = $u?->accounts()
                ->select('accounts.id','accounts.name','accounts.slug')
                ->withPivot('is_owner')
                ->orderBy('accounts.name')
                ->get();
        @endphp

        @if($u && $accounts->count() > 1)
        <div class="dropdown me-2">
            <a class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" href="#">
            {{ $accounts->firstWhere('id',$accountId)?->name ?? 'Sélectionner un compte' }}
            </a>
            <div class="dropdown-menu">
            @foreach($accounts as $acc)
                <form action="{{ route('partners.switch') }}" method="POST">
                @csrf
                <input type="hidden" name="account_id" value="{{ $acc->id }}">
                <input type="hidden" name="redirect" value="{{ url()->current() }}">
                <button type="submit" class="dropdown-item {{ $accountId === (int)$acc->id ? 'active' : '' }}">
                    {{ $acc->name ?? '--' }}
                </button>
                </form>
            @endforeach
            </div>
        </div>
        @endif --}}


          {{-- Profil --}}
          <div class="dropdown profile-dropdown">
            <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
              <span class="avatar avatar-sm online">
                <img src="{{ $u?->avatar_url }}" alt="{{ $u?->firstname }} {{ $u?->lastname }}" class="img-fluid rounded-circle">
              </span>
            </a>
            <div class="dropdown-menu shadow-none">
              <div class="card mb-0">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <span class="avatar avatar-lg me-2 avatar-rounded">
                      <img src="{{ $u?->avatar_url }}" alt="{{ $u?->firstname }} {{ $u?->lastname }}" loading="lazy">
                    </span>
                    <div>
                      <h5 class="mb-0">{{ $u?->firstname }} {{ $u?->lastname }}</h5>
                      <p class="fs-10 fw-medium mb-0">{{ $u?->email }}</p>
                    </div>
                  </div>
                </div>


                <div class="card-footer">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item d-inline-flex align-items-center p-0">
                      <i class="ti ti-login me-2"></i>Se déconnecter
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-ellipsis-v"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end">
        {{-- @can('account.profile.update')
          <a class="dropdown-item" href="{{ route('partners.settings.index') }}">Paramètres</a>
        @endcan --}}
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item">Se déconnecter</button>
        </form>
      </div>
    </div>
    <!-- /Mobile Menu -->

  </div>
</div>
<!-- /Header -->

<style>
  :root{ --primary-color:#579459; --accent-color:#e67e22; --text-dark:#333; }
  .logo-text{ font-size:20px; font-weight:900; text-transform:uppercase; letter-spacing:1px; font-family:"Roboto",sans-serif }
  .dark-logo1{ color:#fff; padding:5px 10px 30px 5px; text-shadow:1px 1px 3px rgba(247,74,0,.9) }
</style>
