@php

    use App\Support\CurrentAccount;
    $ctx     = app(CurrentAccount::class);
    $account = $ctx->get();

    $is    = fn(string $name)  => request()->routeIs($name);
    $isAny = fn(array $names)  => request()->routeIs(...$names);
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <a href="{{ route('partners.shop.dashboard') }}" class="logo-text dark-logo1">
       MYLMARK
    </a>
    <a href="{{ route('partners.shop.dashboard') }}" class="logo-small">
      <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo">
    </a>
  </div>

  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="menu-title"><span>{{ $account->name ? Str::limit($account->name, 30) : 'ESPACE BOUTIQUE' }}</span></li>
            <li>
                <ul>
                    <li class="{{ $is('partners.shop.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('partners.shop.dashboard') }}">
                            <i class="ti ti-smart-home"></i><span>Tableau de bord</span>
                            <span class="badge badge-danger fs-10 fw-medium text-white p-1"><i class="ti ti-shield-lock text-white"></i></span>

                        </a>
                    </li>

                   <li>
                        <a href="{{ route('shop.vendors.show', $account) }}" target="_blank" rel="noopener">
                            <i class="ti ti-building-store"></i>
                            <span>Mon Catalogue</span>
                            <span class="badge bg-purple fs-10 fw-medium text-white p-1">
                               <i class="ti ti-external-link text-white"></i>
                            </span>
                        </a>
                    </li>




                    {{-- SHOP: visible si module "shop  " actif --}}
                    <li class="menu-title mt-4"><span>BOUTIQUE</span></li>
                    <li class="submenu">
                        <a href="{{ route('partners.shop.products.index') }}" class="{{ $isAny(['partners.shop.products.*']) ? 'active subdrop' : '' }}">
                            <i class="ti ti-box"></i><span>Mes Produits</span>
                            <span class="badge badge-primary fs-10 fw-medium text-white p-1">Shop</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a class="{{ $is('partners.shop.products.index') ? 'active' : '' }}"
                                href="{{ route('partners.shop.products.index') }}">Tous les produits</a></li>
                            @can('products.create')
                                <li><a class="{{ $is('partners.shop.products.create') ? 'active' : '' }}"
                                    href="{{ route('partners.shop.products.create') }}">Ajouter un produit</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="{{ route('partners.shop.orders.index') }}"
                            class="{{ $isAny(['partners.shop.orders.*']) ? 'active subdrop' : '' }}">
                            <i class="fa fa-receipt"></i><span>Mes Commandes</span><span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a class="{{ $is('partners.shop.orders.index') && request('status')===null ? 'active' : '' }}"
                                    href="{{ route('partners.shop.orders.index') }}">Mes commandes</a></li>
                            {{-- <li><a href="{{ route('partners.shop.orders.index',['status'=>'pending']) }}">En attente</a></li>
                            <li><a href="{{ route('partners.shop.orders.index',['status'=>'paid']) }}">Payées</a></li>
                            <li><a href="{{ route('partners.shop.orders.index',['status'=>'cancelled']) }}">Annulées</a></li> --}}
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('partners.shop.submissions.*') ? 'active' : '' }}">
                        <a href="{{ route('partners.shop.submissions.index') }}">
                            <i class="ti ti-list-check"></i><span>Mes demandes</span>
                        </a>
                    </li>


                    <li class="menu-title mt-3"><span>PARAMÈTRES</span></li>
                    <li class="{{ $isAny(['partners.shop.profile.*']) ? 'active' : '' }}">
                        <a href="{{ route('partners.shop.profile.edit') }}">
                            <i class="ti ti-user-circle"></i><span>Mon Compte</span>
                        </a>
                    </li>

                    <li class="{{ $isAny(['partners.shop.subscription.*']) ? 'active' : '' }}">
                        <a href="{{ route('partners.shop.subscription.index') }}">
                            <i class="ti ti-credit-card"></i><span>Mon abonnement</span>
                        </a>
                    </li>
                    <li class="{{ $isAny(['partners.shop.settings.*']) ? 'active' : '' }}">
                        <a href="{{ route('partners.shop.settings.edit') }}">
                            <i class="ti ti-settings"></i><span>Paramètres</span>
                        </a>
                    </li>

                </ul>
            </li>
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
