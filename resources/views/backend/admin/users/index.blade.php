@extends('backend.admin.layouts.master')
@section('title') Utilisateurs @endsection
@section('content')


<div class="row">
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-pink-transparent border border-pink d-flex align-items-center justify-content-center">
                                <i class="ti ti-users-group text-pink fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1"> Utilisateurs</p>
                            <h4>{{ $stats['total_users'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-success-transparent border border-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-user-share fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1"> Clients</p>
                            <h4>{{ $stats['customers'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <span class="p-2 br-10 bg-purple-transparent border border-purple d-flex align-items-center justify-content-center">
                                <i class="ti ti-user-star fs-18"></i>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-0 text-gray-5 mb-1"> Partenaires</p>
                            <h4>{{ $stats['partners'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add_user" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filtres --}}
<form class="d-flex gap-2 mb-3">
  <select name="scope" class="form-select" style="width:auto">
    <option value="all"      @selected($scope==='all')>Tous</option>
    <option value="customers"  @selected($scope==='customers')>Clients</option>
    <option value="partners" @selected($scope==='partners')>Partenaires</option>
  </select>
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nom / Email">
  <button class="btn btn-primary">Filtrer</button>
</form>

{{-- Liste --}}
<div class="card">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
            <th>Utilisateur</th>
            <th>Email</th>
            <th>Statut</th>
            <th>Inscription</th>

            <th>Connexion</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
          <tr>
            <td>{{ $u->firstname }} {{ $u->lastname }}</td>
            <td>{{ $u->email }}</td>
            <td>
              <span class="badge {{ $u->status==1?'bg-success':'bg-secondary' }}">
                {{ $u->status==1?'Actif':'Inactif' }}
              </span>
            </td>
            <td>{{ $u->created_at ?: '—' }}</td>
            <td>{{ $u->last_login_at ?: '—' }}</td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted py-4">Aucun résultat.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
</div>

@endsection
