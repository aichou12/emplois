<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('academic')) {
            // Vérifier et insérer l'entrée ID = 20 (Sans diplôme) si absente
            if (!DB::table('academic')->where('id', 20)->exists()) {
                DB::table('academic')->insert([
                    'id' => 20,
                    'libelle' => 'Sans diplôme',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('academic')) {
            // Ne pas supprimer si référencé
        }
    }
};
