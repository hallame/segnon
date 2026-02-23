<?php

namespace App\Models\Concerns;

use App\Models\Guide;
use App\Models\Outing;

trait HasGuides {
    public function guides() {
        return $this->morphToMany(Guide::class, 'placeable', 'guide_places')
            ->withPivot(['price','currency','is_active','approved','is_primary'])
            ->withTimestamps();
    }

    public function outings() {
        return $this->morphMany(Outing::class, 'outable');
    }

    // MAJ compteur (à appeler après attach/detach/validation)
    public function refreshGuidesCount(): void {
        $count = $this->guides()
            ->wherePivot('is_active', true)
            ->wherePivot('approved', true)
            ->whereHas('guides', fn($q) => $q->where('status','approved')); // safety
        $this->update(['guides_count' => $count->count()]);
    }
}
