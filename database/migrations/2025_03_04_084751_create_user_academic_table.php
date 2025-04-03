<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_academic', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userdata_id')->unsigned(); // Colonne clé étrangère
            $table->foreign('userdata_id')->references('id')->on('userdata')->onDelete('cascade');
           $table->unsignedBigInteger('academic_id'); // Clé étrangère vers academic
            $table->string('diplome'); // Nom du diplôme
            $table->string('etablissementdiplome'); // Institution
            $table->integer('anneediplome')->nullable(); // Année d'obtention
            $table->timestamps();
    
            $table->foreign('userdata_id')->references('id')->on('userdata')->onDelete('cascade');
            $table->foreign('academic_id')->references('id')->on('academin')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_academic');
    }
};
