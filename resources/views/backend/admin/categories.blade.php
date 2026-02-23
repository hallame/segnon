@extends('backend.admin.layouts.master')
@section('title')
    Gestion des Catégories
@endsection
@section('content')

<div class="modal-body">
    <div class="card bg-light-500 shadow-none">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#add_category" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter une Catégorie</a>
            <div class="d-flex align-items-center justify-content-end">
                <div class="form-check form-switch me-2">
                    <label class="form-check-label mt-0">
                        <input class="form-check-input me-2" type="checkbox" role="switch"
                            id="toggle-all-categories" onclick="toggleAllCategories()"
                            {{ $allActive ? 'checked' : '' }}>
                        <span id="toggle-all-text">{{ $allActive ? 'Désactiver tout' : 'Activer tout' }}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive border rounded">
        @if ($categories->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Entité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ Str::limit($category->description, 60) }}</td>
                        {{-- <td>{{ $category->type ?? '-' }}</td> --}}
                        <td>{{ $category->model ? __('models.' . strtolower($category->model) . 's') : '-' }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input me-2" role="switch"
                                    data-id="{{ $category->id }}"
                                    id="status-switch-{{ $category->id }}"
                                    {{ $category->status ? 'checked' : '' }}>
                            </div>

                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal" onclick="setDeleteLink({{ $category->id }})">
                                <i class="ti ti-trash fs-20 text-danger"></i>
                            </a>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_modal"
                                onclick="setEditForm({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description) }}', '{{ addslashes($category->type) }}', '{{ addslashes($category->model) }}')">
                                <i class="ti ti-edit fs-20 text-secondary"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            @include('partials.empty')
        @endif
    </div>
</div>

<div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="edit_type" name="type">
                    </div>
                    <div class="mb-3">
                        <label for="edit_model" class="form-label">Module concerné</label>
                        <select class="form-select" id="edit_model" name="model" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="Product">Produit:Zaly Shop</option>
                            <option value="Room">Chambre</option>
                            <option value="Hotel">Hôtel</option>
                            <option value="Site">Site</option>
                            <option value="Event">Événement</option>
                            <option value="Monument">Monument</option>
                            <option value="Museum">Musée</option>
                            <option value="Circuit">Circuit</option>
                            <option value="Faq">Circuit</option>
                            <option value="Other">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                    <i class="ti ti-trash-x fs-36"></i>
                </span>
                <h4 class="mb-1">Confirmer la suppression</h4>
                <p class="mb-3">Vous voulez supprimer cet élément, cela ne pourra pas être annulé une fois supprimé.</p>
                <div class="d-flex justify-content-center">
                    <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</a>

                    <!-- Formulaire de suppression dynamique -->
                    <form id="deleteForm" action="{{ route('admin.category.delete', ':id') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setDeleteLink(categoryId) {
        // Dynamiser l'URL de suppression avec l'ID du pays
        var deleteUrl = '{{ route("admin.category.delete", ":id") }}';
        deleteUrl = deleteUrl.replace(':id', categoryId);

        // Mettre à jour l'URL du formulaire de suppression
        document.getElementById("deleteForm").setAttribute("action", deleteUrl);
    }
</script>


<script>
    // Coche ou décoche toutes les switches sauf le bouton principal
    function toggleAllCategories() {
        let toggleSwitch = document.getElementById('toggle-all-categories');
        let checkboxes = document.querySelectorAll('input[type="checkbox"][role="switch"]:not(#toggle-all-categories)');
        let toggleText = document.getElementById('toggle-all-text');

        checkboxes.forEach(checkbox => {
            checkbox.checked = toggleSwitch.checked;
            updateCategoryStatus(checkbox.dataset.id, checkbox.checked);
        });

        toggleText.textContent = toggleSwitch.checked ? 'Désactiver tout' : 'Activer tout';
    }

    // Met à jour un statut par requête AJAX
    function updateCategoryStatus(categoryId, isChecked) {
        fetch(`/zpanel/categories/status/${categoryId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: isChecked ? 1 : 0 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success('Statut mis à jour avec succès !');
            } else {
                toastr.error('Échec de la mise à jour du statut.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            toastr.error('Erreur lors de la mise à jour du statut.');
        });
    }

    // Sur changement individuel
    document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
        if (checkbox.id !== 'toggle-all-categories') {
            checkbox.addEventListener('change', function () {
                updateCategoryStatus(this.dataset.id, this.checked);
            });
        }
    });
</script>

<script>
    function setEditForm(id, name, description, type = '', model = '') {
        const editUrl = '{{ route("admin.category.update", ":id") }}'.replace(':id', id);
        const form = document.getElementById('editForm');

        form.action = editUrl;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_type').value = type || '';
        document.getElementById('edit_model').value = model || '';
    }
</script>


@endsection
