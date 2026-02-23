@extends('backend.admin.layouts.master')
@section('title', 'Moyens de paiement')

@section('content')

<div class="modal-body">
    <div class="card bg-light-500 shadow-none">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#add_method" class="btn btn-primary d-flex align-items-center">
                <i class="ti ti-circle-plus me-2"></i>Ajouter
            </a>

            <div class="d-flex align-items-center justify-content-end">
                <div class="form-check form-switch me-2">
                    <label class="form-check-label mt-0" for="toggle-all-methods">
                        <input class="form-check-input me-2" type="checkbox" role="switch"
                                id="toggle-all-methods" onclick="toggleAllMethods()"
                                {{ $allActive ? 'checked' : '' }}>
                        <span id="toggle-all-text">{{ $allActive ? 'Désactiver tout' : 'Activer tout' }}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive border rounded">
        @if ($methods->count())
            <table class="table">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Détails</th>
                    {{-- <th>Position</th> --}}
                    <th>Statut</th>
                    <th>Actions</th>
                    {{-- <th>Clé</th> --}}
                </tr>
                </thead>
                <tbody>
                    @foreach ($methods as $method)
                        @php
                            $type = $method->type;

                            $typeLabel = match ($type) {
                                'mobile_money'  => 'Mobile Money',
                                'bank_transfer' => 'Virement',
                                'cash'          => 'Espèces',
                                'card'          => 'Carte',
                                'cod'           => 'COD',
                                default         => Str::headline($type ?? '—'),
                            };

                            // Résumé "détails" en 1 ligne selon le type
                            $detailsText = match ($type) {
                                'mobile_money'  => trim(($method->mobileMoney->operator ?? '—') . ': ' . ($method->mobileMoney->wallet_number ?? '')),
                                'bank_transfer' => trim(($method->bank->bank_name ?? '—') . ': ' . ($method->bank->iban ?? '')),
                                'cash'          => ($method->cash->address ?? '—') . ': ' . ($method->cash->phone ?? '—'),
                                'card'          => ($method->card->provider ?? '—'),
                                'cod'           => ($method->cod->phone ?? '—'),
                                default         => '—',
                            };

                            // Paquet "details" pour l'édition (data-details JSON)
                            $detailsPayload = match ($type) {
                                'mobile_money'  => [
                                'operator'       => optional($method->mobileMoney)->operator,
                                'wallet_number'  => optional($method->mobileMoney)->wallet_number,
                                'wallet_name'    => optional($method->mobileMoney)->wallet_name,
                                'qr'             => optional($method->mobileMoney)->qr,
                                'reference_hint' => optional($method->mobileMoney)->reference_hint,
                                ],
                                'bank_transfer' => [
                                'bank_name'      => optional($method->bank)->bank_name,
                                'holder'         => optional($method->bank)->holder,
                                'iban'           => optional($method->bank)->iban,
                                'bic'            => optional($method->bank)->bic,
                                'reference_hint' => optional($method->bank)->reference_hint,
                                ],
                                'cash' => [
                                'address' => optional($method->cash)->address,
                                'hours'   => optional($method->cash)->hours,
                                'phone'   => optional($method->cash)->phone,
                                ],
                                'card' => [
                                'provider'   => optional($method->card)->provider,
                                'public_key' => optional($method->card)->public_key,
                                'secret_key' => optional($method->card)->secret_key,
                                ],
                                'cod' => [
                                'phone' => optional($method->cod)->phone,
                                'note'  => optional($method->cod)->note,
                                ],
                                default => [],
                            };
                        @endphp
                        <tr>
                            <td>{{ $method->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $typeLabel }}</span>
                            </td>
                            <td class="text-truncate" style="max-width: 280px;">{{ $detailsText }}</td>

                            {{-- <td>{{ (int)$method->position }}</td> --}}

                            <td>
                                <div class="form-check form-switch">
                                    <input
                                    type="checkbox" class="form-check-input me-2 method-switch"
                                    role="switch" data-id="{{ $method->id }}"
                                    id="status-switch-{{ $method->id }}"
                                    {{ $method->active ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                {{-- EDIT --}}
                                <a href="javascript:void(0)"
                                    data-bs-toggle="modal" data-bs-target="#edit_modal"
                                    data-id="{{ $method->id }}"
                                    data-type="{{ $method->type }}"
                                    data-name="{{ $method->name }}"
                                    data-instructions="{{ htmlspecialchars($method->instructions ?? '', ENT_QUOTES) }}"
                                    data-position="{{ (int)$method->position }}"
                                    data-active="{{ $method->active ? 1 : 0 }}"
                                    data-details='@json($detailsPayload)'
                                    onclick="setEditForm(this)">
                                    <i class="ti ti-edit fs-20 text-secondary"></i>
                                </a>


                                {{-- DELETE --}}
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"
                                    onclick="setDeleteLink({{ $method->id }})">
                                    <i class="ti ti-trash fs-20 text-danger"></i>
                                </a>
                            </td>
                            {{-- <td><code>{{ $method->key ?? '—' }}</code></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            @include('partials.empty')
        @endif
    </div>
</div>




{{-- MODAL: Ajouter un moyen de paiement --}}
<div class="modal fade" id="add_method" tabindex="-1" aria-labelledby="add_method_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="addForm" method="POST" action="{{ route('admin.payment_methods.store') }}">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="add_method_title">Ajouter</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>

        <div class="modal-body">
          {{-- TYPE --}}
          <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type" required>
              <option value="">— Sélectionner —</option>
              <option value="mobile_money">Mobile Money</option>
              <option value="bank_transfer">Virement bancaire</option>
              <option value="cash">Espèces (sur place)</option>
              {{-- <option value="card">Carte bancaire</option> --}}
              <option value="cod">Paiement à la livraison (COD)</option>
            </select>
            <small class="text-muted">Choisissez un type pour continuer.</small>
          </div>

          {{-- BLOC PRINCIPAL (caché avant le choix du type) --}}
          <div id="main-block" style="display:none;">

            {{-- Nom (clé générée) --}}
            <div class="mb-3">
              <label for="name" class="form-label">Nom affiché</label>
              <input type="text" class="form-control" id="name" name="name" required placeholder="Ex. Orange Money">
            </div>

            <div class="mt-3 d-flex align-items-center justify-content-between">
              <label for="instructions" class="form-label mb-0">Instructions</label>
              <button class="btn btn-sm btn-outline-secondary" type="button" id="btn-fill-template">Insérer un modèle</button>
            </div>
            <div class="mb-3">
              <textarea class="form-control" id="instructions" name="instructions" rows="2" placeholder="Détails clairs pour le client…"></textarea>
            </div>

            {{-- CHAMPS DÉTAILS SPÉCIFIQUES (rendus dynamiquement) --}}
            <div id="details-fields"></div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label for="position" class="form-label">Position</label>
                <input type="number" class="form-control" id="position" name="position" value="0">
              </div>
              <div class="col-md-6 d-flex align-items-end">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="active" name="active" checked>
                  <label class="form-check-label ms-2" for="active">Actif</label>
                </div>
              </div>
            </div>
          </div> {{-- /#main-block --}}
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
    const $ = (s, ctx=document) => ctx.querySelector(s);

    const typeSelect   = $('#type');
    const mainBlock    = $('#main-block');
    const nameInput    = $('#name');
    const instrTA      = $('#instructions');
    const detailsWrap  = $('#details-fields');

    // Garde-fous si des éléments manquent
    if (!typeSelect || !mainBlock || !nameInput || !instrTA || !detailsWrap) {
        console.error('Form Add: éléments manquants. Vérifie les IDs (type, main-block, name, instructions, details-fields).');
        return;
    }

    const PRESETS = {
        mobile_money: {
        label: 'Mobile Money',
        instructionsTpl: 'Envoyez le montant sur le compte ci-dessous puis indiquez la référence de votre commande.',
        operatorOptions: [
            { value:'Orange', text:'Orange Money' },
            { value:'MTN',    text:'MTN Mobile Money' },
            { value:'Moov',   text:'Moov Money' },
            { value:'Wave',   text:'Wave' },
            // { value:'Free',   text:'Free Money' },
        ],
        fields: [
            { name:'wallet_number',  label:'Numéro du compte', placeholder:'+224 622 83 96 30', required:true },
            { name:'wallet_name',    label:'Nom du compte',    placeholder:'Zaly Merveille' },
            { name:'reference_hint', label:'Conseil référence',placeholder:'Indiquez la réf. commande' },
            // { name:'qr',          label:'QR (URL/chemin)',   placeholder:'storage/qrs/momo_orange.png' },
        ]
        },
        bank_transfer: {
        label: 'Virement bancaire',
        instructionsTpl: 'Effectuez un virement en précisant la référence de commande.',
        fields: [
            { name:'bank_name',      label:'Banque',     placeholder:'CORISBANK', required:true },
            { name:'holder',         label:'Titulaire',  placeholder:'ZALY SARL', required:true },
            { name:'iban',           label:'IBAN/RIB',   placeholder:'GN12 0000 0000 0000 0000 0000', required:true },
            { name:'bic',            label:'BIC/SWIFT',  placeholder:'CORGNGN' },
            { name:'reference_hint', label:'Conseil référence', placeholder:'Indiquez la réf. commande' },
        ]
        },
        cash: {
        label: 'Espèces (sur place)',
        instructionsTpl: 'Règlement sur place.',
        fields: [
            { name:'address', label:'Adresse',   placeholder:'Nzérékoré, Guinée', required:true },
            { name:'hours',   label:'Horaires',  placeholder:'Lun–Ven 9h–17h' },
            { name:'phone',   label:'Téléphone', placeholder:'+224 622 83 96 30' },
        ]
        },
        card: {
        label: 'Carte bancaire',
        instructionsTpl: 'Paiement sécurisé par carte.',
        fields: [
            { name:'provider',   label:'Prestataire', placeholder:'Stripe / Paystack / CinetPay', required:true },
            { name:'public_key', label:'Clé publique', placeholder:'pk_live_...' },
            { name:'secret_key', label:'Clé secrète',  placeholder:'sk_live_...' },
        ]
        },
        cod: {
        label: 'Paiement à la livraison (COD)',
        instructionsTpl: 'Payez au livreur lors de la réception.',
        fields: [
            { name:'phone', label:'Téléphone service', placeholder:'+224 622 83 96 30' },
            { name:'note',  label:'Note',              placeholder:'Zone desservie, frais éventuels…' },
        ]
        }
    };

    // Affiche/rafraîchit l'UI quand on change de type
    typeSelect.addEventListener('change', onTypeChange);

    function onTypeChange(){
        const t = typeSelect.value;
        detailsWrap.innerHTML = '';
        mainBlock.style.display = t ? '' : 'none';

        nameInput.value = '';
        nameInput.placeholder = PRESETS[t]?.label || 'Nom du moyen';

        if (!t) return;

        // Template d'instructions par défaut (si vide)
        if (!instrTA.value) instrTA.placeholder = PRESETS[t]?.instructionsTpl || instrTA.placeholder;

        // Mobile Money : opérateur + champs
        if (t === 'mobile_money') {
        detailsWrap.appendChild(renderOperatorSelect(PRESETS[t].operatorOptions));
        installOperatorAutoFill(); // auto-remplit name selon l’opérateur
        }

        // Champs détails [details[...]]
        detailsWrap.appendChild(renderDetailFields(PRESETS[t].fields));
    }

    // Bouton "Insérer un modèle" pour les instructions
    const btnTpl = document.getElementById('btn-fill-template');
    if (btnTpl) {
        btnTpl.addEventListener('click', () => {
        const t = typeSelect.value;
        const tpl = PRESETS[t]?.instructionsTpl || '';
        if (tpl && !instrTA.value) instrTA.value = tpl;
        });
    }

    // Rendu des champs spécifiques
    function renderDetailFields(fields){
        const group = document.createElement('div');
        group.className = 'row g-3';
        fields.forEach(f => {
        const col = document.createElement('div');
        col.className = 'col-md-6';
        const id = `details_${f.name}`;
        col.innerHTML = `
            <label for="${id}" class="form-label">${escapeHtml(f.label)}${f.required ? ' <span class="text-danger">*</span>' : ''}</label>
            <input type="text" class="form-control" id="${id}" name="details[${f.name}]" placeholder="${escapeAttr(f.placeholder||'')}" ${f.required ? 'required' : ''}>
        `;
        group.appendChild(col);
        });
        return group;
    }

    // Opérateur (Mobile Money)
    function renderOperatorSelect(options){
        const wrap = document.createElement('div');
        wrap.className = 'mb-3';
        wrap.innerHTML = `
        <label for="details_operator" class="form-label">Opérateur <span class="text-danger">*</span></label>
        <select id="details_operator" name="details[operator]" class="form-select" required>
            <option value="">— Sélectionner —</option>
            ${options.map(o => `<option value="${o.value}">${o.text}</option>`).join('')}
        </select>
        `;
        return wrap;
    }
    function installOperatorAutoFill(){
        const sel = document.getElementById('details_operator');
        if (!sel) return;
        sel.addEventListener('change', () => {
        const label = sel.options[sel.selectedIndex]?.text || '';
        if (!nameInput.value) nameInput.value = label || 'Mobile Money';
        });
    }

    // Helpers
    function escapeHtml(s){ return (s||'').replace(/[&<>"']/g, m=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
    function escapeAttr(s){ return (s||'').replace(/"/g,'&quot;'); }
    });
</script>


{{-- MODAL: Modifier un moyen de paiement (update) --}}
<div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="edit_method_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editForm" method="POST" action="">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="edit_method_title">Modifier le moyen de paiement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>

        <div class="modal-body">
          {{-- TYPE --}}
          <div class="mb-3">
            <label for="edit_type" class="form-label">Type</label>
            <select class="form-select" id="edit_type" name="type" required>
              <option value="mobile_money">Mobile Money</option>
              <option value="bank_transfer">Virement bancaire</option>
              <option value="cash">Espèces (sur place)</option>
              {{-- <option value="card">Carte bancaire</option> --}}
              <option value="cod">Paiement à la livraison (COD)</option>
            </select>
            <small class="text-muted">Changer le type recrée les champs de détails.</small>
          </div>

          <div id="edit-main-block">
            {{-- Nom (clé générée côté back au store; on ne l’édite pas ici) --}}
            <div class="mb-3">
              <label for="edit_name" class="form-label">Nom affiché</label>
              <input type="text" class="form-control" id="edit_name" name="name" required>
            </div>

            <div class="mb-2 d-flex align-items-center justify-content-between">
              <label for="edit_instructions" class="form-label mb-0">Instructions</label>
              <button class="btn btn-sm btn-outline-secondary" type="button" id="btn-edit-fill-template">Insérer un modèle</button>
            </div>
            <div class="mb-3">
              <textarea class="form-control" id="edit_instructions" name="instructions" rows="2" placeholder="Détails clairs pour le client…"></textarea>
            </div>

            {{-- CHAMPS DÉTAILS SPÉCIFIQUES --}}
            <div id="edit-details-fields"></div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label for="edit_position" class="form-label">Position</label>
                <input type="number" class="form-control" id="edit_position" name="position" value="0">
              </div>
              <div class="col-md-6 d-flex align-items-end">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="edit_active" name="active">
                  <label class="form-check-label ms-2" for="edit_active">Actif</label>
                </div>
              </div>
            </div>
          </div> {{-- /#edit-main-block --}}
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Script EDIT --}}

<script>
    document.getElementById('edit_type').addEventListener('mousedown', e => e.preventDefault());
</script>
<script>
    (function(){
    const $ = (s, ctx=document) => ctx.querySelector(s);

    const editForm        = $('#editForm');
    const typeSelect      = $('#edit_type');
    const nameInput       = $('#edit_name');
    const instrTA         = $('#edit_instructions');
    const positionInput   = $('#edit_position');
    const activeInput     = $('#edit_active');
    const detailsWrap     = $('#edit-details-fields');
    const btnTpl          = $('#btn-edit-fill-template');

    if (!editForm || !typeSelect || !nameInput || !instrTA || !positionInput || !activeInput || !detailsWrap) {
        console.error('Edit form: éléments manquants (IDs).');
        return;
    }

    // Même mapping que pour "Add", sans "card" si tu l’as retiré
    const PRESETS = {
        mobile_money: {
        label: 'Mobile Money',
        instructionsTpl: 'Envoyez le montant sur le compte ci-dessous puis indiquez la référence de votre commande.',
        operatorOptions: [
            { value:'orange', text:'Orange Money' },
            { value:'mtn',    text:'MTN Mobile Money' },
            { value:'moov',   text:'Moov Money' },
            { value:'wave',   text:'Wave' },
            { value:'free',   text:'Free Money' },
        ],
        fields: [
            { name:'wallet_number',  label:'Numéro du compte', placeholder:'+224 622 83 96 30', required:true },
            { name:'wallet_name',    label:'Nom du compte',    placeholder:'Zaly Merveille' },
            { name:'reference_hint', label:'Conseil référence',placeholder:'Indiquez la réf. commande' },
            // { name:'qr',          label:'QR (URL/chemin)',   placeholder:'storage/qrs/momo_orange.png' },
        ]
        },
        bank_transfer: {
        label: 'Virement bancaire',
        instructionsTpl: 'Effectuez un virement en précisant la référence de commande.',
        fields: [
            { name:'bank_name',      label:'Banque',     placeholder:'CORISBANK', required:true },
            { name:'holder',         label:'Titulaire',  placeholder:'ZALY SARL', required:true },
            { name:'iban',           label:'IBAN/RIB',   placeholder:'GN12 0000 0000 0000 0000 0000', required:true },
            { name:'bic',            label:'BIC/SWIFT',  placeholder:'CORGNGN' },
            { name:'reference_hint', label:'Conseil référence', placeholder:'Indiquez la réf. commande' },
        ]
        },
        cash: {
        label: 'Espèces (sur place)',
        instructionsTpl: 'Règlement sur place.',
        fields: [
            { name:'address', label:'Adresse',   placeholder:'Nzérékoré, Guinée', required:true },
            { name:'hours',   label:'Horaires',  placeholder:'Lun–Ven 9h–17h' },
            { name:'phone',   label:'Téléphone', placeholder:'+224 622 83 96 30' },
        ]
        },
        // card: {...} // si tu le réactives plus tard
        cod: {
        label: 'Paiement à la livraison (COD)',
        instructionsTpl: 'Payez au livreur lors de la réception.',
        fields: [
            { name:'phone', label:'Téléphone service', placeholder:'+224 622 83 96 30' },
            { name:'note',  label:'Note',              placeholder:'Zone desservie, frais éventuels…' },
        ]
        }
    };

    // Exposé globalement : appelé par <a ... onclick="setEditForm(this)">
    window.setEditForm = function(el) {
        const d = el?.dataset || {};
        const id           = d.id;
        const type         = d.type || 'cash';
        const name         = d.name || '';
        const instructions = d.instructions || '';
        const position     = d.position || 0;
        const active       = d.active === '1' || d.active === 1 || d.active === true || d.active === 'true';
        const details      = safeParse(d.details) || {};

        // action PUT
        editForm.action = '{{ route("admin.payment_methods.update", ":id") }}'.replace(':id', id);

        // set valeurs
        typeSelect.value    = type;
        nameInput.value     = name;
        instrTA.value       = instructions;
        positionInput.value = position;
        activeInput.checked = !!active;

        // (re)render des champs selon type + pré-remplissage
        renderEditDetailsFields(type, details);

        // installer listener de changement de type (rebuild des champs)
        // On remet le listener à neuf à chaque ouverture pour éviter les doubles
        typeSelect.onchange = function(){
        renderEditDetailsFields(typeSelect.value, {}); // si l’admin change le type, on repart sur champs vides
        // proposer un modèle si textarea vide
        if (!instrTA.value) instrTA.placeholder = PRESETS[typeSelect.value]?.instructionsTpl || '';
        };

        // bouton “Insérer un modèle”
        btnTpl.onclick = function() {
        const t = typeSelect.value;
        const tpl = PRESETS[t]?.instructionsTpl || '';
        if (tpl && !instrTA.value) instrTA.value = tpl;
        };
    };

    function renderEditDetailsFields(type, details) {
        detailsWrap.innerHTML = '';
        const preset = PRESETS[type];
        if (!preset) return;

        // Mobile Money → opérateur
        if (type === 'mobile_money') {
        detailsWrap.appendChild(renderOperatorSelect(preset.operatorOptions, details.operator));
        }

        // Champs
        detailsWrap.appendChild(renderFields(preset.fields, details));
    }

    function renderOperatorSelect(options, selectedVal) {
        const wrap = document.createElement('div');
        wrap.className = 'mb-3';
        const opts = options.map(o => `<option value="${o.value}" ${o.value===(selectedVal||'')?'selected':''}>${o.text}</option>`).join('');
        wrap.innerHTML = `
        <label for="edit_details_operator" class="form-label">Opérateur <span class="text-danger">*</span></label>
        <select id="edit_details_operator" name="details[operator]" class="form-select" required>
            <option value="">— Sélectionner —</option>
            ${opts}
        </select>
        `;
        return wrap;
    }

    function renderFields(fields, details) {
        const row = document.createElement('div');
        row.className = 'row g-3';
        fields.forEach(f => {
        const col = document.createElement('div');
        col.className = 'col-md-6';
        const id = `edit_details_${f.name}`;
        const val = (details && typeof details[f.name] !== 'undefined') ? details[f.name] : '';
        col.innerHTML = `
            <label for="${id}" class="form-label">${escapeHtml(f.label)}${f.required ? ' <span class="text-danger">*</span>' : ''}</label>
            <input type="text" class="form-control" id="${id}" name="details[${f.name}]" value="${escapeAttr(val)}" placeholder="${escapeAttr(f.placeholder||'')}" ${f.required ? 'required' : ''}>
        `;
        row.appendChild(col);
        });
        return row;
    }

    function safeParse(json) {
        try { return JSON.parse(json); } catch(e) { return null; }
    }
    function escapeHtml(s){ return (s||'').replace(/[&<>"']/g, m=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
    function escapeAttr(s){ return (s||'').replace(/"/g,'&quot;'); }
    })();
</script>


{{-- ============== MODAL: DELETE ============== --}}
<div class="modal fade" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                    <i class="ti ti-trash-x fs-36"></i>
                </span>
                <h4 class="mb-1">Confirmer la suppression</h4>
                <p class="mb-3">Cette action est irréversible.</p>

                <div class="d-flex justify-content-center">
                    <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</a>

                    <form id="deleteForm" action="{{ route('admin.payment_methods.destroy', ':id') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============== SCRIPTS ============== --}}
<script>
    // Préparer l'URL de suppression
    function setDeleteLink(id) {
        let deleteUrl = '{{ route("admin.payment_methods.destroy", ":id") }}'.replace(':id', id);
        document.getElementById('deleteForm').setAttribute('action', deleteUrl);
    }
</script>



<script>
    document.addEventListener('DOMContentLoaded', () => {
    const $  = (s, ctx=document) => ctx.querySelector(s);
    const $$ = (s, ctx=document) => Array.from(ctx.querySelectorAll(s));
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // GÉNÈRE UNE URL DE ROUTE SANS HARD-CODE (placeholder remplaçable)
    const toggleUrlTmpl = @json(route('admin.payment_methods.toggle', ['payment_method' => '__ID__']));

    function setLoading(cb, on) {
        cb.disabled = on;
        cb.closest('.form-check')?.classList.toggle('opacity-50', on);
    }

    async function updateMethodStatus(id, isChecked, cb) {
        const url = toggleUrlTmpl.replace('__ID__', id); // <-- construit ici, avec l'id reçu
        try {
        setLoading(cb, true);
        const res = await fetch(url, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': CSRF
            }, // <-- virgule manquante corrigée
            body: JSON.stringify({ active: isChecked ? 1 : 0 })
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok || !data.success) throw new Error(data.message || 'Erreur serveur');

        cb.dataset.prev = isChecked ? '1' : '0';
        toastr?.success?.('Statut mis à jour avec succès !');
        } catch (e) {
        cb.checked = (cb.dataset.prev === '1'); // rollback
        toastr?.error?.(e.message || 'Échec de la mise à jour du statut.');
        } finally {
        setLoading(cb, false);
        }
    }

    // Switch individuel
    $$('.method-switch').forEach(cb => {
        cb.dataset.prev = cb.checked ? '1' : '0';
        cb.addEventListener('change', () => updateMethodStatus(cb.dataset.id, cb.checked, cb));
    });

    // Toggle global
    window.toggleAllMethods = async function () {
        const master = $('#toggle-all-methods');
        const label  = $('#toggle-all-text');
        const target = !!master?.checked;
        if (label) label.textContent = target ? 'Désactiver tout' : 'Activer tout';

        for (const cb of $$('.method-switch')) {
        if (cb.checked !== target) {
            cb.checked = target; // optimiste
            await updateMethodStatus(cb.dataset.id, target, cb);
        }
        }
    };
    });
</script>



{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
    const $ = (s, ctx=document) => ctx.querySelector(s);
    const $$ = (s, ctx=document) => Array.from(ctx.querySelectorAll(s));
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const url = '{{ route('admin.payment_methods.toggle', ':id') }}'.replace(':id', id);

    // === Helpers UI ===
    function setLoading(cb, on) {
        cb.disabled = on;
        cb.closest('.form-check')?.classList.toggle('opacity-50', on);
    }

    // === AJAX update (avec rollback si erreur) ===
    async function updateMethodStatus(id, isChecked, cb) {
        try {
        setLoading(cb, true);
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': CSRF
            }
            body: JSON.stringify({ active: isChecked ? 1 : 0 })
        });
        const data = await res.json().catch(() => ({}));

        if (!res.ok || !data.success) {
            throw new Error(data.message || 'Erreur serveur');
        }
        cb.dataset.prev = isChecked ? '1' : '0';
        toastr?.success?.('Statut mis à jour avec succès !');
        } catch (e) {
        // rollback
        const prev = cb.dataset.prev === '1';
        cb.checked = prev;
        toastr?.error?.(e.message || 'Échec de la mise à jour du statut.');
        } finally {
        setLoading(cb, false);
        }
    }

    // === Init des switches individuels ===
    $$('.method-switch').forEach(cb => {
        cb.dataset.prev = cb.checked ? '1' : '0';
        cb.addEventListener('change', () => {
        updateMethodStatus(cb.dataset.id, cb.checked, cb);
        });
    });

    // === Toggle global (sequentiel pour éviter la surcharge serveur) ===
    window.toggleAllMethods = async function () {
        const master = $('#toggle-all-methods');
        const label  = $('#toggle-all-text');
        const target = !!master?.checked;
        if (label) label.textContent = target ? 'Désactiver tout' : 'Activer tout';

        const switches = $$('.method-switch');
        for (const cb of switches) {
        if (cb.checked !== target) {
            cb.checked = target; // optimiste
            await updateMethodStatus(cb.dataset.id, target, cb);
        }
        }
    };
    });
</script> --}}

@endsection
