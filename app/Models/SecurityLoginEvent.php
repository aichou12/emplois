<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLoginEvent extends Model
{
    protected $table = 'security_login_events';
    public $timestamps = false;
    protected $fillable = ['utilisateur_id', 'channel', 'result', 'identifier_hint', 'ip_address', 'user_agent', 'created_at'];
    protected $casts = ['created_at' => 'datetime'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}
