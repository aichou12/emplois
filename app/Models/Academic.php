<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importer le trait HasFactory
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory; // Utiliser le trait HasFactory

    protected $table = 'academic';
    protected $fillable = ['libelle'];

    /**
     * Une région a plusieurs départements
     */
    public function userdata()
    {
        return $this->hasMany(Userdata::class, 'academic_id');
    }
}
