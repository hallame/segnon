<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

trait AutoSlug {
    protected static function bootAutoSlug(): void {
        // Génère le slug si vide à la création (et seulement à la création)
        static::creating(function ($m) {
            if (!Schema::hasColumn($m->getTable(), 'slug')) return;

            // si un slug a été fourni au form, on le "slugify" + rend unique
            $candidate = trim((string) $m->slug);
            if ($candidate === '') {
                $candidate = (string) ($m->name ?? $m->title ?? Str::ulid());
            }
            $m->slug = static::uniqueSlug($m, $candidate);
        });

        // PAS de logique en updating => slug immuable même si name change
    }

    protected static function uniqueSlug($model, string $text): string {
        $base = Str::slug($text) ?: 'item';
        $slug = $base;
        $i = 1;

        while ($model::query()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}
