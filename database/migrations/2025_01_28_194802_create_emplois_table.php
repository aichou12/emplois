<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emplois', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->string('nom'); // Nom de l'emploi
            $table->foreignId('secteur_id') // Clé étrangère vers la table secteurs
                  ->constrained('secteurs') // Relie à la table secteurs
                  ->onDelete('cascade'); // Suppression en cascade si le secteur est supprimé
            $table->timestamps(); // Champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emplois');
    }
}
