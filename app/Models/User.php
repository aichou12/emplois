<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Events\Registered;
// 1) Import de l'interface MustVerifyEmail
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cni'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function sendEmailVerificationNotification()
{
    $this->notify(new \App\Notifications\CustomVerifyEmail);
}


    // Exemple de relation : un utilisateur peut avoir une info
    public function info()
    {
        return $this->hasOne(Info::class);
    }
}
