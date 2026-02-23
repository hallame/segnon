<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array|null $changes
 * @property array|null $before
 */

class ContentSubmission extends Model {
    use SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'changes'      => 'array',
        'before'       => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at'  => 'datetime',
    ];

    public function model() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function account(){
        return $this->belongsTo(Account::class)->withDefault();
    }

    public function status() {
        return $this->belongsTo(ModerationStatus::class, 'status_id');
    }

    public function reviewer() {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    public function isPending(): bool {
        return $this->status?->slug === ModerationStatus::PENDING;
    }

    public function isApproved(): bool {
        return $this->status?->slug === ModerationStatus::APPROVED;
    }

    public function isRejected(): bool {
        return $this->status?->slug === ModerationStatus::REJECTED;
    }
}

