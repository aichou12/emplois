<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


    /**
     * Run the migrations.
     */
    class CreateInfosTable extends Migration
    {
        public function up()
        {
            Schema::create('infos', function (Blueprint $table) {
                $table->id();
                $table->string('nom');
                $table->string('prenom');
                $table->string('cni');
                $table->enum('genre', ['Homme', 'Femme']);
                $table->date('datenaiss');
                $table->string('lieu');
                $table->enum('situation', ['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf/Veuve']);
                $table->integer('nombrenfant');
                $table->text('exp_professionnelle');
                $table->integer('nombrexp');
                $table->string('dernierposte');
                $table->string('dernieremp');
                $table->text('cv');
                $table->text('lettremoti');
                $table->foreignId('lieu_residence')->constrained('countries');
                $table->string('adresse');
                $table->boolean('handicap');
                $table->string('diplome');
                $table->string('institution');
                $table->string('intitule_diplome');
                $table->integer('annee_obs');
                $table->string('specialite');
                $table->string('autre_diplome')->nullable();
                $table->string('secteur');
                
                $table->integer('nombre_annee_exp');
                $table->timestamps();
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('infos');
        }
    }
    
   

