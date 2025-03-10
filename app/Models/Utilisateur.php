<?php
//class Utilisateur extends Authenticatable

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;

class Utilisateur extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    

    // Nom de la table
    protected $table = 'utilisateur';

    // Pas de gestion automatique des timestamps
    public $timestamps = false;

    // Champs modifiables
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'username_canonical',
        'numberid',
        'email',
        'email_canonical',
        'password',
        'enabled',
        'recruted',
        'last_login',
        'date_inscription',
    ];

    // Valeurs par défaut
    protected $attributes = [
        'roles' => 'a:0:{}', // Aucun rôle par défaut
        'recruted' => 0,     // Non recruté par défaut
        'enabled' => 0,      // Non activé par défaut
    ];

    // Champs cachés
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts des attributs
    protected $casts = [
        'email_verified_at' => 'datetime',
        'enabled' => 'boolean',
        'recruted' => 'boolean',
        'last_login' => 'datetime',
        'date_inscription' => 'datetime',
    ];

    // Mise à jour de la dernière connexion
    public function updateLastLogin()
    {
        $this->last_login = now();
        $this->save();
    }

    // Notification pour la vérification d'email
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

    // Surcharge de la méthode pour indiquer si l'email est vérifié
    public function hasVerifiedEmail()
    {
        return $this->enabled === 1;
    }

    // Surcharge de la méthode pour marquer l'email comme vérifié
    public function markEmailAsVerified()
    {
        if (!$this->hasVerifiedEmail()) {
            $this->enabled = 1;
            $this->save();

            // Déclenche l'événement standard de Laravel
            event(new \Illuminate\Auth\Events\Verified($this));
        }
    }

    // Méthode pour obtenir l'email utilisé pour la vérification
    public function getEmailForVerification()
    {
        return $this->email_canonical;
    }

    public function sendPasswordResetNotification($token)
{
    $this->notify(new \App\Notifications\CustomResetPasswordNotification($token));
}

    // Mutator pour normaliser le champ `username_canonical`
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value;
        $this->attributes['username_canonical'] = strtolower(trim($value));
    }

    // Mutator pour normaliser le champ `email_canonical`
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value;
        $this->attributes['email_canonical'] = strtolower(trim($value));
    }
    /* public function hasRole($role)
    {
        // Vérifier si le champ roles est valide et décodable
        $roles = $this->roles ? json_decode($this->roles, true) : [];
    
        // Si la décodification échoue, retourner un tableau vide
        if (is_null($roles)) {
            $roles = [];
        }
    
        // Vérifier si le rôle existe dans la liste des rôles
        return in_array($role, $roles);
    } */
    public function hasRole($role)
{
    $roles = unserialize($this->roles); // Désérialiser le champ des rôles
    return in_array($role, $roles); // Vérifier si le rôle est dans le tableau
}

use HasFactory;

// Définir la relation avec la table 'userdata'
public function userdata()
{
    return $this->hasOne(Userdata::class);
}
}
