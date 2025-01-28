<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecteursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secteurs')->insert([
            ['nom' => 'Informatique'],
            ['nom' => 'Médecine'],
            ['nom' => 'Finance'],
            ['nom' => 'Éducation'],
            ['nom' => 'Construction'],
            ['nom' => 'Agriculture'],
            ['nom' => 'Transports'],
            ['nom' => 'Tourisme'],
            ['nom' => 'Ressources humaines'],
            ['nom' => 'Marketing'],
            ['nom' => 'Vente'],
            ['nom' => 'Logistique'],
            ['nom' => 'Design'],
            ['nom' => 'Art et culture'],
            ['nom' => 'Communication'],
            ['nom' => 'Énergie'],
            ['nom' => 'Industrie'],
            ['nom' => 'Télécommunications'],
            ['nom' => 'Automobile'],
            ['nom' => 'Événementiel'],
        ]);
    }
}
