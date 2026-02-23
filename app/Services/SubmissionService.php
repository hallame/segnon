<?php

namespace App\Services;

use App\Models\ContentSubmission;
use App\Models\ModerationStatus;
use App\Support\CurrentAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubmissionNotification;
use App\Mail\VendorStatusNotification;

class SubmissionService {

    public function submit(Model $model, array $payload, string $operation = 'update', ?string $comment = null): ContentSubmission {
        // ADD: verrou 1 pending par ressource
        if ($this->pendingFor($model)) {
            throw ValidationException::withMessages([
                'action' => "Une demande est déjà en attente pour cet élément."
            ]);
        }

        $payload = $this->onlyScalars($payload);
        [$changes, $before] = $this->computeChanges($model, $payload, $operation);

        
        $submission = new ContentSubmission([
            'model_type'   => $model::class,
            'model_id'     => $model->getKey(),
            'account_id'   => app(CurrentAccount::class)->id(),
            'user_id'      => Auth::id(),
            'operation'    => $operation,
            'changes'      => $changes ?: null,
            'before'       => $before ?: null,
            'status_id'    => ModerationStatus::idFor(ModerationStatus::PENDING),
            'submitted_at' => now(),
            'submitted_by' => Auth::id(),
            'comment'      => $comment,
            // si tu ajoutes la colonne is_pending (optionnel DB) : 'is_pending' => true,
        ]);

        $submission->save();
        $this->sendSubmissionNotification($submission);
        return $submission;
    }


    private function sendSubmissionNotification(ContentSubmission $submission): void {
        try {
            // Récupérer l'email perso depuis la configuration
            $recipientEmail = config('mail.submission_notification.email');

            if (empty($recipientEmail)) {
                \Log::warning('Aucun email configuré pour les notifications de soumission');
                return;
            }

            // Envoyer l'email
            Mail::to($recipientEmail)->send(new SubmissionNotification($submission));

            // Optionnel: logger l'envoi
            \Log::info('Notification de soumission envoyée à ' . $recipientEmail, [
                'submission_id' => $submission->id,
                'model_type' => $submission->model_type,
                'model_id' => $submission->model_id,
            ]);

        } catch (\Exception $e) {
            // Logger l'erreur mais ne pas bloquer la soumission
            \Log::error('Erreur lors de l\'envoi de la notification email: ' . $e->getMessage(), [
                'submission_id' => $submission->id,
                'error' => $e->getTraceAsString(),
            ]);
        }
    }





    private function setModerationApproved(Model $model): void {
        if (Schema::hasColumn($model->getTable(), 'moderation_status')) {
            // 2 = APPROVED
            $model->setAttribute('moderation_status', 2);
        }
    }

    public function approve(ContentSubmission $s, ?string $comment = null): void {
        $model = $s->model;
        $changes = $s->changes ?? [];
        if (is_array($changes) && array_key_exists('status', $changes)) {
            // "on", "1", 1, true => 1 ; sinon 0
            $changes['status'] = !empty($changes['status']) ? 1 : 0;
        }

        match ($s->operation) {
            'create'     => $this->applyCreate($model, $s->changes),
            'update'     => $this->applyUpdate($model, $s->changes),
            'delete'     => $this->applyDelete($model),
            'publish'    => $this->applyPublish($model),
            'unpublish'  => $this->applyUnpublish($model),
            'activate'   => $this->applyPublish($model),
            'deactivate' => $this->applyUnpublish($model),
            default      => null,
        };

        // Notifier le vendeur APRÈS l'approbation
        $this->notifyVendor($s, 'approved');


        //  marquer approuvé si pas delete
        if ($s->operation !== 'delete') {
            $this->setModerationApproved($model);
            $model->save(); // s'assure que la modération est persistée
        }

        $s->update([
            'status_id'   => ModerationStatus::idFor(ModerationStatus::APPROVED),
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'comment'     => $comment,
        ]);

        // ADD: si delete approuvé, auto-rejeter toute autre pending du même couple (model_type, model_id)
        if ($s->operation === 'delete') {
            ContentSubmission::query()
                ->where('model_type', $s->model_type)
                ->where('model_id',   $s->model_id)
                ->where('id',        '!=', $s->id)
                ->whereHas('status', fn($q) => $q->where('slug', ModerationStatus::PENDING))
                ->update([
                    'status_id'   => ModerationStatus::idFor(ModerationStatus::REJECTED),
                    'reviewed_at' => now(),
                    'reviewed_by' => Auth::id(),
                    'comment'     => \DB::raw("CONCAT(COALESCE(comment,''), '\n[auto] Rejetée suite à la suppression de la ressource.')"),
                    // si colonne 'is_pending' : 'is_pending' => false,
                ]);
        }
    }


    public function reject(ContentSubmission $s, ?string $comment = null): void {
        foreach (['image_pending','video_pending'] as $k) {
            if (!empty($s->changes[$k])) Storage::disk('pending')->delete($s->changes[$k]);
        }
        $s->update([
            'status_id'   => ModerationStatus::idFor(ModerationStatus::REJECTED),
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'comment'     => $comment,
        ]);

        // Notifier le vendeur du rejet
        $this->notifyVendor($s, 'rejected', $comment);
    }


    // ---------- helpers ----------
    // ADD
    private function pendingFor(Model $model): ?ContentSubmission {
        return ContentSubmission::query()
            ->where('model_type', $model::class)
            ->where('model_id', $model->getKey())
            ->whereHas('status', fn($q) => $q->where('slug', ModerationStatus::PENDING))
            ->first();
    }


    protected function computeChanges(Model $model, array $payload, string $operation): array {
        $fillable = property_exists($model, 'fillable') && $model->getFillable()
            ? $model->getFillable()
            : array_keys($payload);

        $keep = array_unique(array_merge($fillable, ['image_pending','video_pending']));
        $payload = \Illuminate\Support\Arr::only($payload, $keep);

        if ($operation === 'create') return [$payload, null];

        if ($operation === 'update') {
            $before  = \Illuminate\Support\Arr::only($model->getOriginal(), array_keys($payload));
            $changes = [];
            foreach ($payload as $k => $v) if ($model->{$k} !== $v) $changes[$k] = $v;
            return [$changes, $before ?: null];
        }
        return [null, null];
    }


    protected function applyCreate(Model $model, ?array $changes): void {
        if ($changes) $model->fill($changes);
        $this->ensureStatus($model, true); // création approuvée => publier
        $this->applyPendingMedia($model, $changes);
        $model->save();
    }

    protected function applyUpdate(Model $model, ?array $changes): void {
        if ($changes) $model->fill($changes);
        // NE PAS toucher au status ici
        $this->applyPendingMedia($model, $changes);
        $model->save();
    }

    protected function applyPublish(Model $model): void {
        $this->ensureStatus($model, true);
        $model->save();
    }

    protected function applyUnpublish(Model $model): void {
        $this->ensureStatus($model, false);
        $model->save();
    }

    protected function applyDelete(Model $model): void {
        // delete() gère soft/hard selon le trait présent
        $model->delete();
    }

    private function ensureStatus(Model $model, bool $active): void {
        if (!is_null($model->getAttribute('status'))) {
            $model->setAttribute('status', $active ? 1 : 0);
        }
    }

    private function onlyScalars(array $data): array {
        return collect($data)->filter(fn($v) => is_null($v) || is_scalar($v))->all();
    }

    private function applyPendingMedia(Model $model, ?array $changes): void {
        if (!$changes) return;
        $base = $model->getTable(); // 'hotels' | 'rooms' | ...
        foreach (['image','video'] as $field) {
            $k = $field.'_pending';
            $rel = $changes[$k] ?? null;         // ex: "hotels/images/abc.jpg"
            if (!$rel || !Storage::disk('pending')->exists($rel)) continue;

            $ext = pathinfo($rel, PATHINFO_EXTENSION);
            $new = "{$base}/{$field}s/".Str::ulid().($ext ? ".{$ext}" : '');

            // stream copy (privé -> public)
            $in = Storage::disk('pending')->readStream($rel);
            Storage::disk('public')->writeStream($new, $in);
            if (is_resource($in)) fclose($in);
            Storage::disk('pending')->delete($rel);

            // nettoyer l'ancien public si existait
            if ($old = $model->getOriginal($field)) {
                Storage::disk('public')->delete($old);
            }

            // après avoir déplacé le fichier vers 'public' et set $model->image = $new;
            $model->addMediaFromDisk($new, 'public')->toMediaCollection('cover','public');
            $model->setAttribute($field, $new);
        }
    }


    public function upsertPending(Model $model, array $payload, string $operation = 'update'): ContentSubmission {
        $existing = $this->pendingFor($model);
        [$changes, $before] = $this->computeChanges($model, $payload, $operation);

        if (!$existing) {
            return $this->submit($model, $changes ?? [], $operation);
        }

        if ($existing->operation !== 'update') {
            throw ValidationException::withMessages([
                'action' => "Une demande « {$existing->operation} » est déjà en attente pour cet élément."
            ]);
        }

        $merged = array_merge((array) $existing->changes ?: [], (array) $changes ?: []);
        $existing->fill([
            'changes'      => $merged ?: null,
            'before'       => $existing->before ?: ($before ?: null),
            'submitted_at' => now(),
            'user_id'      => Auth::id(),
        ])->save();
        $this->sendSubmissionNotification($existing);
        return $existing;
    }



    private function notifyVendor(ContentSubmission $submission, string $status, ?string $comment = null): void {
        try {
            $model = $submission->model;

            if (!$model || !method_exists($model, 'account')) {
                return;
            }

            $account = $model->account;
            if (!$account) {
                return;
            }

            // Récupérer uniquement le owner
            $owner = $account->users()
                ->wherePivot('is_owner', true)
                ->first();


            if (!$owner) {
                \Log::warning('Aucun owner trouvé pour le compte', [
                    'account_id' => $account->id,
                    'submission_id' => $submission->id,
                ]);
                return;
            }

            // Préparer les données pour le mail
            $data = [
                'product_name' => $model->name ?? ($model->title ?? ''),
                'product_id'   => $model->id,
                'sku'          => $model->sku ?? null,
                'status'       => $status, // 'approved' ou 'rejected'
                'comment'      => $comment,
                'submitted_at' => $submission->submitted_at,
                'reviewed_at'  => $submission->reviewed_at,
                'operation'    => $submission->operation,
                'reviewer'     => $submission->reviewer->firstname ?? null,
                'owner_name'   => $owner->firstname,
            ];

            Mail::to($owner->email)->send(new VendorStatusNotification($data));

            \Log::info("Notification de statut {$status} envoyée au owner {$owner->email}", [
                'account_id' => $account->id,
                'owner_id'   => $owner->id,
                'model_type' => $submission->model_type,
                'model_id'   => $submission->model_id,
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la notification vendeur: ' . $e->getMessage(), [
                'submission_id' => $submission->id,
                'status' => $status,
            ]);
        }
    }

}
