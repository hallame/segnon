<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModerationStatus extends Model {

    protected $guarded = [];

    public const PENDING  = 'pending';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';

    public static function idFor(string $slug): ?int {
        static $cache = [];
        if (!isset($cache[$slug])) {
            $cache[$slug] = static::where('slug', $slug)->value('id');
        }
        return $cache[$slug];
    }
}
