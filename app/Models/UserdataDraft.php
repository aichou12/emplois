<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserdataDraft extends Model
{
    protected $fillable = ['utilisateur_id', 'payload', 'files', 'current_step'];

    protected $casts = [
        'payload' => 'encrypted:array',
        'files' => 'encrypted:array',
        'current_step' => 'integer',
    ];
}
