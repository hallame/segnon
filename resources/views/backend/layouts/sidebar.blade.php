@php
    use App\Support\CurrentAccount;

    $ctx     = app(CurrentAccount::class);
    $account = $ctx->get();

    if ($account && ! $account->relationLoaded('modules')) {
        $account->load('modules:id,slug');
    }

    // Slugs des modules activés (hotel, shop, guide, …)
    $mods = $account
        ? $account->modules()
            ->wherePivot('is_enabled', 1)
            ->pluck('modules.slug')
            ->toArray()
        : [];

    $hasHotel = in_array('hotel', $mods, true);
    $hasShop  = in_array('shop',  $mods, true);   // ✅ corrige l’ancien $hasArtisan
    $hasGuide = in_array('guide', $mods, true);

    $is    = fn(string $name)  => request()->routeIs($name);
    $isAny = fn(array $names)  => request()->routeIs(...$names);

    // Sommes-nous sur une route du module Guide ?
    $onGuide = request()->routeIs('partners.guide.*');

    // Route d’accueil contextuelle
    $homeRoute = $onGuide ? 'partners.guide.dashboard' : 'partners.dashboard';
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <a href="{{ route($homeRoute) }}" class="logo-text dark-logo1">
        {{ $account ? $account->name : 'ZALY MERVEILLE' }}
    </a>
    <a href="{{ route($homeRoute) }}" class="logo-small">
      <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo">
    </a>
  </div>

  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>
        <li class="menu-title"><span>ESPACE ADMIN</span></li>

        <li class="{{ $is('partners.dashboard') ? 'active' : '' }}">
          <a href="{{ route('partners.dashboard') }}">
            <i class="ti ti-smart-home"></i><span>Tableau de bord</span>
            <span class="badge badge-danger fs-10 fw-medium text-white p-1">
              <i class="ti ti-shield-lock text-white"></i>
            </span>
          </a>
        </li>

        <li class="{{ request()->routeIs('partners.submissions.*') ? 'active' : '' }}">
          <a href="{{ route('partners.submissions.index') }}">
            <i class="ti ti-list-check"></i><span>Mes demandes</span>
          </a>
        </li>

        {{-- ================= HÔTELLERIE ================= --}}
        @if ($hasHotel)
          <li class="menu-title mt-4"><span>HÔTELLERIE</span></li>

          @can('hotels.view-any')
            <li class="submenu">
              <a href="{{ route('partners.hotels.index') }}"
                 class="{{ $isAny(['partners.hotels.*']) ? 'active subdrop' : '' }}">
                <i class="fa fa-hotel"></i><span>Hôtels</span><span class="menu-arrow"></span>
              </a>
              <ul>
                <li><a class="{{ $is('partners.hotels.index') ? 'active' : '' }}"
                       href="{{ route('partners.hotels.index') }}">Tous les hôtels</a></li>
                @can('hotels.create')
                  <li><a class="{{ $is('partners.hotels.create') ? 'active' : '' }}"
                         href="{{ route('partners.hotels.create') }}">Ajouter un hôtel</a></li>
                @endcan
              </ul>
            </li>
          @endcan

          @can('rooms.view-any')
            <li class="submenu">
              <a href="{{ route('partners.rooms.index') }}"
                 class="{{ $isAny(['partners.rooms.*']) ? 'active subdrop' : '' }}">
                <i class="fa fa-bed"></i><span>Chambres</span><span class="menu-arrow"></span>
              </a>
              <ul>
                <li><a class="{{ $is('partners.rooms.index') ? 'active' : '' }}"
                       href="{{ route('partners.rooms.index') }}">Toutes les chambres</a></li>
                @can('rooms.create')
                  <li><a class="{{ $is('partners.rooms.create') ? 'active' : '' }}"
                         href="{{ route('partners.rooms.create') }}">Ajouter une chambre</a></li>
                @endcan
              </ul>
            </li>
          @endcan

          @can('bookings.view')
            <li class="submenu">
              <a href="{{ route('partners.bookings.index') }}"
                 class="{{ $isAny(['partners.bookings.*']) ? 'active subdrop' : '' }}">
                <i class="ti ti-calendar-check"></i><span>Réservations</span><span class="menu-arrow"></span>
              </a>
              <ul>
                <li><a class="{{ $is('partners.bookings.index') && request('status')===null ? 'active' : '' }}"
                       href="{{ route('partners.bookings.index') }}">Toutes</a></li>
                <li><a href="{{ route('partners.bookings.index',['status'=>\App\Models\Booking::STATUS_PENDING]) }}">En attente</a></li>
                <li><a href="{{ route('partners.bookings.index',['status'=>\App\Models\Booking::STATUS_CONFIRMED]) }}">Confirmées</a></li>
                <li><a href="{{ route('partners.bookings.index',['status'=>\App\Models\Booking::STATUS_CANCELLED]) }}">Annulées</a></li>
              </ul>
            </li>
          @endcan
        @endif

        {{-- ================= BOUTIQUE D’ART (SHOP) ================= --}}
        @if ($hasShop)
          <li class="menu-title mt-4"><span>BOUTIQUE D’ART</span></li>

          @can('products.view-any')
            <li class="submenu">
              <a href="{{ route('partners.products.index') }}"
                 class="{{ $isAny(['partners.products.*']) ? 'active subdrop' : '' }}">
                <i class="ti ti-box"></i><span>Produits</span>
                <span class="badge badge-secondary fs-10 fw-medium text-white p-1">Ecommerce</span>
                <span class="menu-arrow"></span>
              </a>
              <ul>
                <li><a class="{{ $is('partners.products.index') ? 'active' : '' }}"
                       href="{{ route('partners.products.index') }}">Tous les articles</a></li>
                @can('products.create')
                  <li><a class="{{ $is('partners.products.create') ? 'active' : '' }}"
                         href="{{ route('partners.products.create') }}">Ajouter un article</a></li>
                @endcan
              </ul>
            </li>
          @endcan

          @can('orders.view')
            <li class="submenu">
              <a href="{{ route('partners.orders.index') }}"
                 class="{{ $isAny(['partners.orders.*']) ? 'active subdrop' : '' }}">
                <i class="fa fa-receipt"></i><span>Commandes</span><span class="menu-arrow"></span>
              </a>
              <ul>
                <li><a class="{{ $is('partners.orders.index') && request('status')===null ? 'active' : '' }}"
                       href="{{ route('partners.orders.index') }}">Mes commandes</a></li>
                <li><a href="{{ route('partners.orders.index',['status'=>'pending']) }}">En attente</a></li>
                <li><a href="{{ route('partners.orders.index',['status'=>'paid']) }}">Payées</a></li>
                <li><a href="{{ route('partners.orders.index',['status'=>'cancelled']) }}">Annulées</a></li>
              </ul>
            </li>
          @endcan
        @endif

        {{-- ================= GUIDES TOURISTIQUES ================= --}}
        @if ($hasGuide)
          <li class="menu-title mt-4"><span>GUIDES TOURISTIQUES</span></li>

          <li class="{{ $is('partners.guide.dashboard') ? 'active' : '' }}">
            <a href="{{ route('partners.guide.dashboard') }}">
              <i class="ti ti-compass"></i><span>Dashboard guide</span>
            </a>
          </li>

          <li class="submenu">
            <a href="{{ route('partners.guide.outings.index') }}"
               class="{{ $isAny(['partners.guide.outings.*']) ? 'active subdrop' : '' }}">
              <i class="ti ti-map-pin"></i><span>Sorties</span><span class="menu-arrow"></span>
            </a>
            <ul>
              <li><a class="{{ $is('partners.guide.outings.index') ? 'active' : '' }}"
                     href="{{ route('partners.guide.outings.index') }}">Toutes les sorties</a></li>
              <li><a class="{{ $is('partners.guide.outings.create') ? 'active' : '' }}"
                     href="{{ route('partners.guide.outings.create') }}">Créer une sortie</a></li>
            </ul>
          </li>

          <li class="{{ $is('partners.guide.places.index') ? 'active' : '' }}">
            <a href="{{ route('partners.guide.places.index') }}">
              <i class="ti ti-flag"></i><span>Lieux & tarifs</span>
            </a>
          </li>
        @endif

      </ul>
    </div>
  </div>
</div>

<style>
    :root { --primary-color:#579459!important; --accent-color:#e67e22!important; --text-dark:#333!important; }
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap');
    .logo-text{font-size:18px;font-weight:900;text-transform:uppercase;letter-spacing:1px;display:block;font-family:"Roboto",sans-serif}
    .logo-small{font-size:20px;color:#3498DB}
    .dark-logo1{color:#fff!important;padding:5px 10px 30px 5px;text-shadow:1px 1px 3px rgba(247,74,0,.9)}
</style>
