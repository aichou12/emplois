<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;
    protected $table = 'departement';
    protected $fillable = ['libelle', 'region_id'];

    /**
     * Un département appartient à une région
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Un département peut être le lieu de naissance de plusieurs utilisateurs
     */
    public function userdatasNaissance()
    {
        return $this->hasMany(Userdata::class, 'departementnaiss_id');
    }

    /**
     * Un département peut être le lieu de résidence de plusieurs utilisateurs
     */
    public function userdatasResidence()
    {
        return $this->hasMany(Userdata::class, 'departementresidence_id');
    }
}

