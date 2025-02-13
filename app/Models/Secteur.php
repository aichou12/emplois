<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;

    protected $fillable = ['libelle'];

    /**
     * Un secteur peut avoir plusieurs emplois.
     */
    public function emplois()
    {
        return $this->hasMany(Emploi::class, 'secteur_id');
    }
}

