<?php

// app/Models/Info.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'cni', 'genre', 'datenaiss', 'lieu', 'situation',
        'nombrenfant', 'exp_professionnelle', 'nombrexp', 'dernierposte', 'dernieremp',
        'cv', 'lettremoti', 'lieu_residence', 'adresse', 'handicap', 'diplome',
        'institution', 'intitule_diplome', 'annee_obs', 'specialite', 'autre_diplome',
        'secteur_id', 'nombre_annee_exp', 'numero'
    ];

    // Define the relationship with Secteur model
    public function secteur()
    {
        return $this->belongsTo(Secteur::class, 'secteur_id');
    }

    // Define the relationship with Emploi model
  
}
