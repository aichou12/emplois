<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emploi extends Model
{
    use HasFactory;
    protected $table = 'emploi';
    protected $fillable = ['libelle', 'secteur_id'];

    /**
     * Un emploi appartient à un secteur.
     */
    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    /**
     * Un emploi peut être choisi par plusieurs utilisateurs comme premier emploi.
     */
    public function userdatasEmploi1()
    {
        return $this->hasMany(Userdata::class, 'emploi1_id');
    }

    /**
     * Un emploi peut être choisi par plusieurs utilisateurs comme deuxième emploi.
     */
    public function userdatasEmploi2()
    {
        return $this->hasMany(Userdata::class, 'emploi2_id');
    }
}

