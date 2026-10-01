<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityBlockedIp extends Model
{
    protected $table = 'security_blocked_ips';
    protected $guarded = [];
    protected $casts = ['blocked_at' => 'datetime', 'released_at' => 'datetime'];

    public function blockedBy()
    {
        return $this->belongsTo(Utilisateur::class, 'blocked_by');
    }
}
