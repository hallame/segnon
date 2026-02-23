
@extends('backend.partners.layouts.master')
@section('title') Gestion des médias @endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- En-tête --}}
    <div class="mb-5 border-b pb-5">
        <div class="flex items-center gap-4">
            <i class="ti ti-photo text-4xl text-primary"></i>
            <div class="text-sm text-gray-500 font-medium mb-1">
                Gérer les médias de
                <span class="text-secondary">{{ $model->name ?? $model->title ?? $model->slug }}</span>
                <span class="text-2xl text-primary font-extrabold leading-tight">
                    ({{ __("models." . class_basename($model)) }})
                </span>
            </div>
        </div>
    </div>

    {{-- Formulaire Upload --}}
    <form action="{{ route('media.store', ['type' => $type, 'key'  => $model->slug ?: $model->getKey()]) }}"
          method="POST" enctype="multipart/form-data"
          class="bg-gradient-to-tr from-white to-gray-50 border border-dashed border-primary-light rounded-2xl p-6 text-center shadow-md hover:shadow-lg transition mb-5">
        @csrf

        <div class="flex flex-col items-center justify-center space-y-4">
            <i class="ti ti-cloud-upload text-5xl text-primary"></i>
            <h3 class="text-lg font-semibold text-gray-800 text-center">
                Glissez vos fichiers ici ou cliquez pour en choisir
            </h3>

            <label class="cursor-pointer inline-block">
                <input id="media-files" type="file" name="files[]" multiple accept="image/*,video/mp4" class="hidden">
                <span class="mt-3 inline-block px-6 py-2 bg-primary text-white font-medium text-sm rounded-md shadow hover:bg-primary-dark transition">
                    Sélectionner les fichiers
                </span>
            </label>
        </div>

        <button type="submit"
                class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-secondary text-white font-semibold text-sm rounded-lg shadow hover:bg-secondary-dark focus:outline-none">
            <i class="ti ti-send"></i> Envoyer
        </button>
    </form>

    {{-- Galerie responsive --}}
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @forelse($model->getMedia('gallery') as $media)
        
            <div class="relative group overflow-hidden rounded-xl shadow border border-gray-200 bg-white hover:shadow-xl transition duration-300">
                @if(\Illuminate\Support\Str::startsWith($media->mime_type, 'image/'))
                    <img src="{{ $media->getUrl() }}" alt="media"
                         class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105">
                @elseif(\Illuminate\Support\Str::startsWith($media->mime_type, 'video/'))
                    <video src="{{ $media->getUrl() }}" controls
                           class="w-full h-56 object-cover bg-black"></video>
                @endif

                {{-- Overlay suppression --}}
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <form method="POST" action="{{ route('media.destroy', $media) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg shadow transition"
                                title="Supprimer ce média">
                            <i class="ti ti-trash text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 text-base">
                <i class="ti ti-photo-off text-5xl mb-4"></i>
                <p>Aucun média trouvé pour cet élément.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Si tu n’utilises pas Tailwind via Vite, laisse le CDN. Sinon, retire cette ligne. --}}
<script src="https://cdn.tailwindcss.com"></script>
@endsection
