<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handicap extends Model
{
    use HasFactory;
    protected $table = 'handicap';
    protected $fillable = ['libelle'];

    /**
     * Un handicap peut être attribué à plusieurs utilisateurs.
     */
    public function userdatas()
    {
        return $this->hasMany(Userdata::class, 'handicap_id');
    }
}

