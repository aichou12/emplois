<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('userdata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('regionnaiss_id')->nullable();
            $table->unsignedBigInteger('regionresidence_id')->nullable();
            $table->unsignedBigInteger('departementnaiss_id')->nullable();
            $table->unsignedBigInteger('departementresidence_id')->nullable();
            $table->unsignedBigInteger('emploi1_id')->nullable();
            $table->unsignedBigInteger('emploi2_id')->nullable();
            $table->unsignedBigInteger('handicap_id')->nullable();
            $table->unsignedBigInteger('academic_id')->nullable();

            $table->date('datenaiss')->nullable();
            $table->string('lieunaiss')->nullable();
            $table->string('lieuresidence')->nullable();
            $table->string('addresse')->nullable();
            $table->string('genre')->nullable();
            $table->string('situationmatrimoniale')->nullable();
            $table->string('telephone1')->nullable();
            $table->string('telephone2')->nullable();
            $table->integer('nombreenfant')->nullable();

            $table->string('diplome')->nullable();
            $table->string('anneediplome')->nullable();
            $table->string('specialite')->nullable();
            $table->string('etablissementdiplome')->nullable();
            $table->json('autresdiplomes')->nullable();
            $table->json('experiences')->nullable();

            $table->text('motivation')->nullable();
            $table->integer('nombreanneeexpe')->nullable();
            $table->string('posteoccupe')->nullable();
            $table->string('employeur')->nullable();
            $table->string('anneeexperience1')->nullable();
            $table->string('anneeexperience2')->nullable();
            $table->text('cv_summary')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('userdata');
    }
};