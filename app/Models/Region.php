<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table = 'region';
    protected $fillable = ['libelle'];

    /**
     * Une région a plusieurs départements
     */
    public function departements()
    {
        return $this->hasMany(Departement::class, 'region_id');
    }

    /**
     * Une région peut être liée à plusieurs utilisateurs via `Userdata`
     */
    public function userdatasNaissance()
    {
        return $this->hasMany(Userdata::class, 'regionnaiss_id');
    }

    public function userdatasResidence()
    {
        return $this->hasMany(Userdata::class, 'regionresidence_id');
    }
}
