@extends('backend.admin.layouts.master')
@section('title') Partenaires @endsection
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add_partner" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus"></i> Nouveau partenaire</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filtres --}}

<form class="row g-2 mb-3 align-items-end">
  <div class="col-md-3">
    <label class="form-label">Recherche</label>
    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Nom / Email / Compte">
  </div>
  <div class="col-md-2">
    <label class="form-label">Statut utilisateur</label>
    <select name="status" class="form-select">
      <option value="">— Tous —</option>
      <option value="1" @selected(($filters['status'] ?? '')==='1')>Actif</option>
      <option value="0" @selected(($filters['status'] ?? '')==='0')>En attente</option>
      <option value="2" @selected(($filters['status'] ?? '')==='2')>Bloqué</option>
    </select>
  </div>
  <div class="col-md-2">
    <label class="form-label">Compte vérifié</label>
    <select name="verified" class="form-select">
      <option value="">— Tous —</option>
      <option value="1" @selected(($filters['verified'] ?? '')==='1')>Vérifiés</option>
      <option value="0" @selected(($filters['verified'] ?? '')==='0')>Non vérifiés</option>
    </select>
  </div>
  <div class="col-md-2">
    <label class="form-label">Module</label>
    <select name="module_id" class="form-select">
      <option value="">— Tous —</option>
      @foreach($modules as $m)
        <option value="{{ $m->id }}" @selected(($filters['moduleId'] ?? '')==$m->id)>{{ $m->name }}</option>
      @endforeach
    </select>
  </div>
  {{-- <div class="col-md-2">
    <label class="form-label">Pays</label>
    <select name="country" class="form-select">
      <option value="">— Tous —</option>
      @foreach($countries as $c)
        <option value="{{ $c }}" @selected(($filters['country'] ?? '')===$c)>{{ $c }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-1">
    <label class="form-label">Tri</label>
    <select name="sort" class="form-select">
      <option value="recent"   @selected(($filters['sort'] ?? '')==='recent')>Récent</option>
      <option value="name"     @selected(($filters['sort'] ?? '')==='name')>Nom</option>
      <option value="accounts" @selected(($filters['sort'] ?? '')==='accounts')># Comptes</option>
    </select>
  </div> --}}
  <div class="col-md-3">
    <button class="btn btn-primary">Filtrer</button>
    <a href="{{ route('admin.users.partners') }}" class="btn btn-outline-secondary">Réinitialiser</a>
  </div>
</form>
{{-- <form class="d-flex gap-2 mb-3">
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nom / Prénom / Email">
  <button class="btn btn-primary">Rechercher</button>
</form> --}}

    @if ($partners->count() > 0)
        <div class="card">
            <div class="table-responsive">
                <table class="table align-middle">
                <thead>
                    <tr>
                    <th>Partenaire</th>
                    <th>Statut</th>
                    <th>Téléphone</th>
                    <th>Inscription</th>
                    <th>Connexion</th>

                    {{-- <th class="text-center">#Comptes</th> --}}
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($partners as $p)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center file-name-icon">
                                <a href="#" class="avatar avatar-md border avatar-rounded">
                                    <img src="{{ asset($p->avatar ?? 'assets/images/senior.png') }}" class="img-fluid" alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fw-medium">
                                        <a href="#">
                                            {{ Str::limit($p->firstname, 15) }} {{ Str::limit($p->lastname, 15) }}
                                        </a>
                                    </h6>
                                    <span class="fs-12 fw-normal">{{ $p->email ?? '' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="form-check form-switch d-inline-flex ms-2 align-middle">
                            <input class="form-check-input js-status-switch" type="checkbox"
                                data-url="{{ route('admin.users.toggle', $p) }}" {{ $p->status ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>{{ $p->phone ?: '—' }}</td>
                        <td>{{ $p->created_at ?: '—' }}</td>
                        <td>{{ $p->last_login_at ?: '—' }}</td>
                        {{-- <td class="text-center">{{ $p->accounts_count }}</td> --}}
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#acc-{{ $p->id }}">Voir comptes</button>
                            @if(auth()->user()->hasAnyRole('developer'))
                                <form action="{{ route('admin.impersonate.start', $p) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        Se connecter en tant que
                                    </button>
                                </form>
                            @endif

                        </td>

                    </tr>
                    <tr class="collapse" id="acc-{{ $p->id }}">
                    <td colspan="5" class="bg-light">
                        @if($p->accounts->isEmpty())
                            <div class="text-muted">Aucun compte.</div>
                        @else
                        <div class="row g-2">
                            @foreach($p->accounts as $a)
                            <div class="col-md-6">
                                <div class="border rounded p-2 h-100">
                                <div class="d-flex justify-content-between">
                                    <div>
                                    <div class="fw-semibold">{{ $a->name }}</div>
                                    <div class="small text-muted">{{ $a->country }} {{ $a->city ? '· '.$a->city : '' }}</div>
                                    </div>
                                    <span class="badge {{ $a->is_verified ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $a->is_verified ? 'Vérifié' : 'À valider' }}
                                    </span>
                                </div>
                                
                                <div class="mt-2 small">
                                    <span class="me-3">Modules: <strong>{{ $a->modules_count }}</strong></span>
                                    <span class="me-3">Produits: <strong>{{ $a->products_count }}</strong></span>
                                    <span class="me-3">Commandes: <strong>{{ $a->orders_count }}</strong></span>
                                    <span>Total: <strong>{{ number_format($a->revenue_sum ?? 0, 0, ' ', ' ') }}</strong></span>
                                </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $partners->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @else
        <div class="text-center p-4">
            <img src="{{ asset('assets/images/empty.png') }}" alt="Aucun client" width="150">
            <p class="text-muted mt-3">Aucun partenaire trouvé.</p>
        </div>
    @endif


    <div class="modal fade" id="add_partner">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer un compte partenaire</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="ti ti-x"></i>
                </button>
            </div>

            <form action="{{ route('admin.users.store.partner') }}" method="POST">
                @csrf
                <div class="modal-body">
                {{-- ====== Choix utilisateur ====== --}}
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Propriétaire</h6>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="useExistingUser">
                        <label class="form-check-label ms-2" for="useExistingUser">Lier à un utilisateur existant</label>
                    </div>
                    </div>

                    {{-- Sélecteur utilisateur existant --}}
                    <div id="existingUserBox" class="row mt-3 d-none">
                    <div class="col-md-12">
                        <label class="form-label">Utilisateur</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">— Sélectionner —</option>
                            @foreach($assignableUsers as $u)
                                <option value="{{ $u->id }}">
                                {{ $u->firstname }} {{ $u->lastname }} — {{ $u->email }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <select name="user_id" id="user_id" class="form-select">
                            <option value="">— Sélectionner —</option>
                            @foreach(\App\Models\User::orderBy('email')->limit(200)->get(['id','firstname','lastname','email']) as $u)
                                <option value="{{ $u->id }}">
                                {{ $u->firstname }} {{ $u->lastname }} — {{ $u->email }}
                                </option>
                            @endforeach
                        </select> --}}
                    </div>
                    </div>

                    {{-- Création d’un nouvel utilisateur --}}
                    <div id="newUserBox" class="row mt-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                        <label for="firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Entrez le prénom" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                        <label for="lastname" class="form-label">Nom</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Entrez le nom">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Entrez l'email" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Numéro de téléphone</label>
                            <input type="tel" name="phone" placeholder="Ex: +123 xxxxxxxx" id="phone" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                        <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <div class="pass-group">
                            <input type="password" id="password" name="password" class="pass-input form-control" placeholder="••••••••" required>
                            <span class="ti toggle-password ti-eye-off"></span>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                        <label class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                        <div class="pass-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="pass-inputs form-control" placeholder="Répétez le mot de passe" required>
                            <span class="ti toggle-passwords ti-eye-off"></span>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                {{-- ====== Compte partenaire ====== --}}
                <div class="border rounded p-3">
                    <h6 class="mb-3">Compte partenaire</h6>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Nom du compte <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" class="form-control" placeholder="Ex : Atelier Kofi" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Email du compte</label>
                        <input type="email" name="account_email" class="form-control" placeholder="contact@exemple.com">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+224 ...">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                        <label class="form-label">Pays</label>
                        <input type="text" name="country" class="form-control" placeholder="Guinée">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                        <label class="form-label">Ville</label>
                        <input type="text" name="city" class="form-control" placeholder="Conakry">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="address" class="form-control" placeholder="Adresse complète">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Modules à activer <span class="text-danger">*</span></label>
                        <select name="modules[]" class="form-select select2" multiple required>
                            @foreach(($modules ?? []) as $m)
                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Sélectionnez au moins un module</small>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified" value="1">
                        <label class="form-check-label ms-2" for="is_verified">Marquer comme compte vérifié</label>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-outline-light border me-2" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer le partenaire</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    {{-- Toggle logiques --}}
    <script>
        (function () {
            const cb = document.getElementById('useExistingUser');
            const boxExisting = document.getElementById('existingUserBox');
            const boxNew = document.getElementById('newUserBox');

            const newRequired = ['firstname','email','password','password_confirmation'];

            function setRequired(ids, on) {
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                if (on) el.setAttribute('required','required');
                else el.removeAttribute('required');
            });
            }

            function toggle() {
            const useExisting = cb.checked;

            // UI
            boxExisting.classList.toggle('d-none', !useExisting);
            boxNew.classList.toggle('d-none', useExisting);

            // Constraints
            const userSel = document.getElementById('user_id');
            if (userSel) {
                if (useExisting) userSel.setAttribute('required','required');
                else userSel.removeAttribute('required');
            }
            setRequired(newRequired, !useExisting);
            }

            cb?.addEventListener('change', toggle);
            toggle();
        })();
    </script>


     <script>
        document.querySelectorAll('.js-status-switch').forEach(function (el) {
            el.addEventListener('change', function () {
                const url = this.dataset.url;
                const status = this.checked ? 1 : 0;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Statut mis à jour avec succès !');
                    } else {
                        // Check if an error message is provided by the controller
                        if (data.error) {
                            toastr.error(data.error);
                        } else {
                            toastr.error('Échec de la mise à jour du statut.');
                        }
                    }
                })
                .catch(() => toastr.error('Erreur lors de la mise à jour du statut.'));
            });
        });
    </script>

@endsection
