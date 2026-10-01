<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityBlockedAccount extends Model
{
    protected $table = 'security_blocked_accounts';
    protected $guarded = [];
    protected $casts = ['blocked_at' => 'datetime', 'released_at' => 'datetime'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function blockedBy()
    {
        return $this->belongsTo(Utilisateur::class, 'blocked_by');
    }
}
