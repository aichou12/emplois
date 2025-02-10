<?php
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
        'secteur_id', 'numero', 'is_submitted', 'user_id' // Ajoutez 'user_id' ici
    ];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec le modèle Secteur
    public function secteur()
    {
        return $this->belongsTo(Secteur::class, 'secteur_id');
    }
    
}
