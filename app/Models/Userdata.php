<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userdata extends Model
{
    use HasFactory;

    protected $table = 'userdata';

    protected $fillable = [
        'utilisateur_id', 'departementnaiss_id', 'departementresidence_id',
        'emploi1_id', 'emploi2_id', 'handicap_id', 'academic_id',
        'datenaiss', 'lieuresidence', 'lieunaiss', 'genre',
        'situationmatrimoniale', 'telephone1', 'telephone2', 'nombreenfants',
        'diplome', 'autresdiplomes', 'experiences', 'motivation',
        'anneediplome', 'anneeexperience1', 'anneeexperience2',
        'specialite', 'etablissementdiplome', 'regionnaiss_id', 'regionresidence_id',
        'nombreanneeexpe', 'posteoccupe', 'employeur', 'diplome_file', 'cv_file',
        'photo_profil'  // ✅ Ajout du champ photo_profil
    ];

    /**
     * Un utilisateur possède une seule userdata.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    /**
     * Un userdata est lié à une région de naissance.
     */
    public function regionNaissance()
    {
        return $this->belongsTo(Region::class, 'regionnaiss_id');
    }

    /**
     * Un userdata est lié à une région de résidence.
     */
    public function regionResidence()
    {
        return $this->belongsTo(Region::class, 'regionresidence_id');
    }

    /**
     * Un userdata est lié à un département de naissance.
     */
    public function departementNaissance()
    {
        return $this->belongsTo(Departement::class, 'departementnaiss_id');
    }

    /**
     * Un userdata est lié à un département de résidence.
     */
    public function departementResidence()
    {
        return $this->belongsTo(Departement::class, 'departementresidence_id');
    }

    /**
     * Un userdata est lié à un premier emploi.
     */
    public function emploi1()
    {
        return $this->belongsTo(Emploi::class, 'emploi1_id');
    }

    /**
     * Un userdata est lié à un deuxième emploi.
     */
    public function emploi2()
    {
        return $this->belongsTo(Emploi::class, 'emploi2_id');
    }

    /**
     * Un userdata est lié à un handicap.
     */
    public function handicap()
    {
        return $this->belongsTo(Handicap::class);
    }

    /**
     * Un userdata est lié à un diplôme académique.
     */
    public function academic()
    {
        return $this->belongsTo(Academic::class, 'academic_id');
    }
}
