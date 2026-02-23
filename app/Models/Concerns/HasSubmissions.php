<?php

namespace App\Models\Concerns;

use App\Models\ContentSubmission;

trait HasSubmissions {
    public function submissions()
    {
        // 'model' = nom du morph côté ContentSubmission::model()
        return $this->morphMany(ContentSubmission::class, 'model')->latest();
    }

    public function hasPendingSubmission(): bool {
        return $this->submissions()
            ->whereHas('status', fn($q) => $q->where('slug','pending'))
            ->exists();
    }
}
