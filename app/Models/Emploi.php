<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emploi extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'secteur_id'];

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }
}

