@extends('backend.admin.layouts.master')
@section('title', 'Ajouter un Ticket')

@section('content')
<div class="card">
    <div class="card-header"><h5>Ajouter un Ticket</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.tickets.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                <div class="mb-3">
                    <label for="event_id" class="form-label">Événement <span class="text-danger">*</span></label>
                    <select name="event_id" id="event_id" class="form-control" required>
                        <option value="">-- Sélectionner un événement --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->name }}</option>
                        @endforeach
                    </select>
                    @error('event_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="ticket_type_id" class="form-label">Type de ticket <span class="text-danger">*</span></label>
                        <select name="ticket_type_id" id="ticket_type_id" class="form-control" required>
                            <option value="">-- Sélectionner un type --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" @selected(old('ticket_type_id') == $type->id)>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('ticket_type_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="available" @selected(old('status')=='available')>Disponible</option>
                            {{-- <option value="sold" @selected(old('status')=='sold')>Vendu</option>
                            <option value="reserved" @selected(old('status')=='reserved')>Réservé</option> --}}
                        </select>
                        @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="col-12 modal-footer">
                    <button type="submit" class="btn btn-primary p-2 m-2">Enregistrer</button>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const eventSelect = document.getElementById('event_id');
        const typeSelect = document.getElementById('ticket_type_id');

        // génère automatiquement la bonne URL
        const routeTemplate = "{{ route('admin.events.ticket_types', ':id') }}";

        eventSelect.addEventListener('change', function() {
            const eventId = this.value;
            typeSelect.innerHTML = '<option value="">-- Chargement... --</option>';

            if (!eventId) {
                typeSelect.innerHTML = '<option value="">-- Sélectionner un type --</option>';
                return;
            }

            // remplacer :id par l'id réel
            const url = routeTemplate.replace(':id', eventId);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    typeSelect.innerHTML = '<option value="">-- Sélectionner un type --</option>';
                    data.forEach(type => {
                        const opt = document.createElement('option');
                        opt.value = type.id;
                        opt.textContent = type.name;
                        typeSelect.appendChild(opt);
                    });
                })
                .catch(() => {
                    typeSelect.innerHTML = '<option value="">-- Erreur, réessayez --</option>';
                });
        });
    });
</script>

@endsection
