@extends('backend.admin.layouts.master')
@section('title') Clients @endsection
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
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nom / Prénom / Email">
        <button class="btn btn-primary">Rechercher</button>
    </form>


    <!-- Clients list -->
    @if ($customers->count() > 0)
        <div class="card">
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Nom Complet</th>
                                <th>Téléphone</th>
                                {{-- <th>Réservations</th> --}}
                                <th>Inscription</th>
                                <th>Connexion</th>
                                <th>Achats</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center file-name-icon">
                                            <a href="#" class="avatar avatar-md border avatar-rounded">
                                                <img src="{{ asset($customer->profile_image ?? 'assets/images/client.png') }}" class="img-fluid" alt="img">
                                            </a>
                                            <div class="ms-2">
                                                <h6 class="fw-medium">
                                                    <a href="#">
                                                        {{ $customer->firstname }} {{ $customer->lastname }}
                                                    </a>
                                                </h6>
                                                <span class="fs-12 fw-normal">{{ $customer->email ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $customer->phone ?? '---' }}</td>
                                    {{-- <td>{{ $customer->bookings->count() }} fois</td> --}}
                                    <td>{{ $customer->created_at ?: '—' }}</td>
                                    <td>{{ $customer->last_login_at ?: '—' }}</td>

                                    <td>{{ $customer->orders_count }} fois</td>
                                    </td>
                                    <td>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input js-status-switch" type="checkbox"
                                            data-url="{{ route('admin.users.toggle', $customer) }}"
                                            {{ $customer->status ? 'checked' : '' }}>
                                        </div>

                                        {{-- <div class="action-icon d-inline-flex">
                                            <a href="#" class="me-2" data-bs-toggle="modal" data-bs-target="#edit_client">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div> --}}
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#upgradeToPartnerModal"
                                            data-action="{{ route('admin.users.upgrade', $customer) }}"
                                            data-name="{{ $customer->firstname }} {{ $customer->lastname }}"
                                            data-email="{{ $customer->email }}"
                                            data-phone="{{ $customer->phone }}"
                                            data-whatsapp="{{ $customer->whatsapp }}">
                                            <i class="ti ti-store"></i> En faire un vendeur
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $customers->withQueryString()->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    @else
        <div class="text-center p-4">
            <img src="{{ asset('assets/images/empty.png') }}" alt="Aucun client" width="150">
            <p class="text-muted mt-3">Aucun client trouvé.</p>
        </div>
    @endif
    <!-- /Clients list -->

    <!-- Modal Upgrade -> Partenaire -->
    <div class="modal fade" id="upgradeToPartnerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <form id="upgradeToPartnerForm" method="POST">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title">Transformer en partenaire / vendeur</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                    <label class="form-label">Nom du compte / boutique <span class="text-danger">*</span></label>
                    <input type="text" name="account_name" id="upgrade_account_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                    <label class="form-label">Email du compte</label>
                    <input type="email" name="account_email" id="upgrade_account_email" class="form-control">
                    </div>

                    <div class="col-md-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="account_phone" id="upgrade_account_phone" class="form-control">
                    </div>

                    <div class="col-md-3">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="account_whatsapp" id="upgrade_account_whatsapp" class="form-control">
                    </div>

                    <div class="col-md-6">
                    <label class="form-label">Ville</label>
                    <input type="text" name="city" class="form-control" value="">
                    </div>

                    <div class="col-md-6">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="account_address" class="form-control" value="">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Plan d’abonnement</label>
                        <select name="subscription_plan" class="form-select">
                        <option value="{{ \App\Models\Account::PLAN_STANDARD }}">Standard</option>
                        <option value="{{ \App\Models\Account::PLAN_PREMIUM }}">Premium</option>
                        </select>
                        <small class="text-muted">
                        L’essai gratuit (ex. 30 jours) sera appliqué automatiquement.
                        </small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label d-block">Modules à activer <span class="text-danger">*</span></label>
                        <div class="row">
                            @foreach($modules as $m)
                                <div class="col-md-2">
                                <div class="form-check mb-1">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="modules[]"
                                        id="upgrade_module_{{ $m->id }}"
                                        value="{{ $m->id }}"
                                        {{ $m->slug === 'shop' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="upgrade_module_{{ $m->id }}">
                                    {{ $m->slug }}
                                    </label>
                                </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check"></i> Créer le compte partenaire
                </button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('upgradeToPartnerModal');
            var form  = document.getElementById('upgradeToPartnerForm');

            modal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                if (!button) return;

                var action   = button.getAttribute('data-action');
                var name     = button.getAttribute('data-name') || '';
                var email    = button.getAttribute('data-email') || '';
                var phone    = button.getAttribute('data-phone') || '';
                var whatsapp = button.getAttribute('data-whatsapp') || '';

                form.setAttribute('action', action);

                document.getElementById('upgrade_account_name').value =
                    'Boutique de ' + name.trim();

                document.getElementById('upgrade_account_email').value   = email;
                document.getElementById('upgrade_account_phone').value   = phone;
                document.getElementById('upgrade_account_whatsapp').value= whatsapp;
            });
        });
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
