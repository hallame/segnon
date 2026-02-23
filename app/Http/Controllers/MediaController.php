<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Support\CurrentAccount;

class MediaController extends Controller {

    protected function resolveModel(string $type) {
        $map = [
            'room'    => \App\Models\Room::class,
            'product'    => \App\Models\Product::class,
            'event'   => \App\Models\Event::class,
            'hotel'   => \App\Models\Hotel::class,
        ];
        abort_unless(isset($map[$type]), 404, "Type d'entité inconnu.");
        return $map[$type];
    }

    protected function findByKeyOrSlug(string $class, string $key): Model {
        /** @var \Illuminate\Database\Eloquent\Model $instance */
        $instance = new $class;

        // Tentative par clé primaire (ID numérique ou string UUID)
        $q = $class::query()->where($instance->getKeyName(), $key);

        // Si le modèle a une colonne "slug", on tente aussi par slug
        // (évite un Schema::hasColumn coûteux à chaque requête)
        if (property_exists($instance, 'fillable') && in_array('slug', $instance->getFillable(), true)) {
            $q->orWhere('slug', $key);
        } elseif (method_exists($instance, 'getTable')) {
            // fallback léger (si pas de fillable défini)
            try {
                if (\Schema::hasColumn($instance->getTable(), 'slug')) {
                    $q->orWhere('slug', $key);
                }
            } catch (\Throwable $e) {
                // ignore si pas migré
            }
        }

        return $q->firstOrFail();
    }

    protected function authorizeModel(Model $model): void {
        $user = Auth::user();

        // Staff plateforme = bypass
        if ($user && ($user->can('platform.view') || $user->hasAnyRole([
            'super_admin','moderator','finance_admin','support','developer'
        ]))) {
            return;
        }

        // Partenaire : doit appartenir au compte courant
        $accountId = app(CurrentAccount::class)->id();
        abort_if(!$accountId, 403, "Compte courant non résolu.");

        $modelAccountId = (int) data_get($model, 'account_id', 0);
        abort_unless($modelAccountId > 0 && $modelAccountId === (int) $accountId, 403, "Accès refusé.");
    }

    public function index(string $type, string $key) {
        $class = $this->resolveModel($type);
        $model = $this->findByKeyOrSlug($class, $key);
        // $this->authorizeModel($model);
        return view('partials.media', compact('model','type'));
    }


    public function store(Request $request, string $type, string $key){
        $class = $this->resolveModel($type);
        $model = $this->findByKeyOrSlug($class, $key);
        // $this->authorizeModel($model);

        // 1) Bloquer si soumission en attente
        if (data_get($model, 'has_pending_submission')) {
            return back()->with('warning', "Upload désactivé pendant une soumission en attente.");
        }


        // 2) Quota
        $max = 20;
        $current = $model->media()->where('collection_name','gallery')->count();
        $incoming = count((array) $request->file('files', []));
        if ($current + $incoming > $max) {
            $left = max(0, $max - $current);
            return back()->withErrors(['files' => "Quota dépassé ({$max}). Restants: {$left}."]);
        }

        // 3) Validation stricte (dimensions min pour images)
        $request->validate([
            'files'   => ['required','array'],
            'files.*' => [
                'file','mimes:jpg,jpeg,png,webp,mp4','max:10240',
                function($attr,$file,$fail){
                    if (str_starts_with($file->getMimeType(),'image/')) {
                        [$w,$h] = @getimagesize($file->getPathname()) ?: [0,0];
                        if ($w < 600 || $h < 400) $fail('Image trop petite (min 600x400).');
                    }
                },
            ],
        ]);

        // 4) Galerie = pas de modération -> disque public
        foreach ((array) $request->file('files', []) as $file) {
            $model->addMedia($file)->toMediaCollection('gallery', 'public');
        }

        return back()->with('success', 'Fichiers ajoutés.');
    }


    public function destroy(Request $request, Media $media) {
        $owner = $media->model; // morph owner
        $this->authorizeModel($owner);

        $media->delete();
        return back()->with('success', 'Le média a été supprimé avec succès.');
    }

}
