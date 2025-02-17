<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;


use App\Models\Departement;
class RegionController extends Controller
{
   
    
    public function getDepartements($region_id)
    {
        $departements = Departement::where('region_id', $region_id)->get();
        
        if ($departements->isEmpty()) {
            return response()->json(['message' => 'Aucun département trouvé'], 404);
        }
    
        return response()->json($departements);
    }
    

}