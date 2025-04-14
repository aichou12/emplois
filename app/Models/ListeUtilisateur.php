<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeUtilisateur extends Model
{
    protected $table = 'liste_utilisateurs';
    public $timestamps = false; // Car les vues n'ont généralement pas de timestamps

    protected $guarded = []; // Permet l'accès à toutes les colonnes
    //protected $guarded = [];pour le push
}
