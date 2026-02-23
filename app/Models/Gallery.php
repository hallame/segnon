<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Gallery extends Model {

    use HasFactory;
    protected $fillable = [
        'image',
        'slug',
        'galleryable_id',
        'galleryable_type',
        'status'
    ];

    public function galleryable() {
        return $this->morphTo();
    }

    
     public function registerView(){
        $sessionUserId = Session::get('user_id'); // ID de l'utilisateur depuis la session
        $sessionUserType = Session::get('user_type'); // Type de l'utilisateur depuis la session
        // Vérifier si l'utilisateur a déjà vu l'article aujourd'hui
        $existingView = View::where('viewable_type', self::class)
            ->where('viewable_id', $this->id)
            ->when($sessionUserId, fn($query) =>
                $query->where('viewer_id', $sessionUserId)
                    ->where('viewer_type', $sessionUserType))
            ->when(!$sessionUserId, fn($query) => $query->where('ip', request()->ip()))
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if (!$existingView) {
            View::create([
                'viewable_type' => self::class,
                'viewable_id' => $this->id,
                'viewer_type' => $sessionUserId ? $sessionUserType : null,
                'viewer_id' => $sessionUserId ?: null,
                'ip' => $sessionUserId ? null : request()->ip(), // Si non connecté, stocker l'IP
            ]);
        }
    }
}
