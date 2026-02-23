@php
  $is    = fn(string $name)  => request()->routeIs($name);
  $isAny = fn(array $names)  => request()->routeIs(...$names);

  use App\Support\CurrentAccount;
  use Illuminate\Support\Facades\Schema;
  use Illuminate\Support\Facades\DB;
  use Carbon\Carbon;

  $accId = (int) app(CurrentAccount::class)->id();
  $now   = Carbon::now();

  // Compteurs modération événements (si colonnes présentes)
  $eventCounts = ['drafts'=>0,'pending'=>0,'published'=>0];
  if (Schema::hasColumn('events','moderation_status')) {
      $eventCounts['drafts']    = DB::table('events')->where('account_id',$accId)->where('moderation_status',0)->count();
      $eventCounts['pending']   = DB::table('events')->where('account_id',$accId)->where('moderation_status',1)->count();
      $eventCounts['published'] = DB::table('events')->where('account_id',$accId)->where('moderation_status',2)->count();
  }

  // Compteurs commandes (si table présente)
  $ordersPending = 0;
  $ordersRefunds = 0;
  if (Schema::hasTable('orders') && Schema::hasColumn('orders','event_id')) {
      $ordersPending = DB::table('orders')
          ->where('account_id',$accId)->whereNotNull('event_id')
          ->whereIn('payment_status',['pending','requires_action'])
          ->count();
      $ordersRefunds = DB::table('orders')
          ->where('account_id',$accId)->whereNotNull('event_id')
          ->where('payment_status','refunded')
          ->count();
  }

  // Check-ins du jour (si table présente)
  $checkinsToday = 0;
  if (Schema::hasTable('checkins') && Schema::hasColumn('checkins','scanned_at')) {
      $checkinsToday = DB::table('checkins')->whereDate('scanned_at',$now->toDateString())->count();
  }
@endphp

<!-- Sidebar Organizer -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <a href="{{ route('partners.event.dashboard') }}" class="logo-text dark-logo1">ZALY MERVEILLE</a>
    <a href="{{ route('partners.event.dashboard') }}" class="logo-small">
      <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo">
    </a>
  </div>

  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>
        <li class="menu-title"><span>Espace Organisateur</span></li>
        <li>
          <ul>
            <li class="{{ $is('partners.event.dashboard') ? 'active' : '' }}">
              <a href="{{ route('partners.event.dashboard') }}">
                <i class="ti ti-smart-home"></i><span>Tableau de bord</span>
              </a>
            </li>

            <li class="menu-title mt-3"><span>ÉVÉNEMENTS</span></li>

            {{-- Mes événements (sous-menu) --}}
            <li class="submenu">
              <a href="{{ route('partners.event.events.index') }}"
                 class="{{ ($isAny(['partners.event.events.*']) && !$is('partners.event.events.calendar') && !$is('partners.event.events.export')) ? 'active subdrop' : '' }}">
                <i class="ti ti-calendar-event"></i><span>Mes événements</span>
                <span class="menu-arrow"></span>
              </a>
              <ul>
                <li>
                  <a class="{{ $is('partners.event.events.index') && !request('status') ? 'active' : '' }}"
                     href="{{ route('partners.event.events.index') }}">
                    Tous
                  </a>
                </li>
                {{-- <li>
                  <a class="{{ $is('partners.event.events.calendar') ? 'active' : '' }}"
                     href="{{ route('partners.event.events.calendar') }}">
                    Calendrier
                  </a>
                </li> --}}
                <li>
                  <a class="{{ $is('partners.event.events.create') ? 'active' : '' }}"
                     href="{{ route('partners.event.events.create') }}">
                    Créer un événement
                  </a>
                </li>

              </ul>
            </li>

            <li class="{{ $isAny(['partners.event.events.calendar']) ? 'active' : '' }}">
                <a class="{{ $is('partners.event.events.calendar') ? 'active' : '' }}"
                     href="{{ route('partners.event.events.calendar') }}">
                     <i class="ti ti-calendar-stats"></i><span>Calendrier</span>
                  </a>
            </li>
            <li class="{{ $isAny(['partners.event.events.export']) ? 'active' : '' }}">
                <a class="{{ $is('partners.event.events.export') ? 'active' : '' }}"
                     href="{{ route('partners.event.events.export') }}">
                     <i class="ti ti-download"></i><span>Exporter</span>
                  </a>
            </li>

             <li class="menu-title mt-3"><span>BILLETTERIE</span></li>
            {{-- <li class="submenu">
              <a href="{{ route('partners.event.orders.index') }}"
                 class="{{ $isAny(['partners.event.orders.*']) ? 'active subdrop' : '' }}">
                <i class="ti ti-shopping-cart"></i><span>Commandes</span>
                @if($ordersPending > 0)
                  <span class="badge badge-warning fs-10 fw-medium text-white p-1">{{ $ordersPending }}</span>
                @endif
                <span class="menu-arrow"></span>
              </a>
              <ul>
                <li>
                  <a class="{{ $is('partners.event.orders.index') && !request('payment_status') ? 'active' : '' }}"
                     href="{{ route('partners.event.orders.index') }}">
                    Toutes
                  </a>
                </li>
                <li>
                  <a class="{{ $is('partners.event.orders.index') && request('payment_status')==='pending' ? 'active' : '' }}"
                     href="{{ route('partners.event.orders.index', ['payment_status'=>'pending']) }}">
                    En attente
                    @if($ordersPending > 0)
                      <span class="badge badge-warning fs-10 fw-medium text-white p-1">{{ $ordersPending }}</span>
                    @endif
                  </a>
                </li>
                <li>
                  <a class="{{ $is('partners.event.orders.index') && request('payment_status')==='refunded' ? 'active' : '' }}"
                     href="{{ route('partners.event.orders.index', ['payment_status'=>'refunded']) }}">
                    Remboursées
                    @if($ordersRefunds > 0)
                      <span class="badge badge-info fs-10 fw-medium text-white p-1">{{ $ordersRefunds }}</span>
                    @endif
                  </a>
                </li>
              </ul>
            </li> --}}

            {{-- <li class="{{ $isAny(['partners.event.attendees.*']) ? 'active' : '' }}">
              <a href="{{ route('partners.event.attendees.index') }}">
                <i class="ti ti-users"></i><span>Participants</span>
              </a>
            </li>

            <li class="{{ $isAny(['partners.event.checkin.*']) ? 'active' : '' }}">
              <a href="{{ route('partners.event.checkin.index') }}">
                <i class="ti ti-qrcode"></i><span>Check-in</span>
                @if($checkinsToday > 0)
                  <span class="badge badge-success fs-10 fw-medium text-white p-1">{{ $checkinsToday }}</span>
                @endif
              </a>
            </li> --}}

            {{-- <li class="{{ $isAny(['partners.event.coupons.*']) ? 'active' : '' }}">
              <a href="{{ route('partners.event.coupons.index') }}">
                <i class="ti ti-ticket"></i><span>Coupons</span>
              </a>
            </li> --}}

            {{-- <li class="{{ $isAny(['partners.event.reports.*']) ? 'active' : '' }}">
              <a href="{{ route('partners.event.reports.index') }}">
                <i class="ti ti-chart-bar"></i><span>Rapports</span>
              </a>
            </li> --}}

            <li class="menu-title mt-3"><span>PARAMÈTRES</span></li>
            <li class="{{ $isAny(['partners.event.settings.*']) ? 'active' : '' }}">
              <a href="{{ route('partners.event.settings.edit') }}">
                <i class="ti ti-settings"></i><span>Réglages</span>
              </a>
            </li>
            <li class="{{ $isAny(['partners.event.profile.*']) ? 'active' : '' }}">
              <a href="{{ route('partners.event.profile.edit') }}">
                <i class="ti ti-user-circle"></i><span>Mon profil</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>

<style>
  :root { --primary-color:#579459!important; --accent-color:#e67e22!important; }
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap');
  .logo-text{font-size:18px;font-weight:900;text-transform:uppercase;letter-spacing:1px;display:block;font-family:"Roboto",sans-serif}
  .logo-small{font-size:20px;color:#3498DB}
  .dark-logo1{color:#fff!important;padding:5px 10px 30px 5px;text-shadow:1px 1px 3px rgba(247,74,0,.9)}
</style>
