<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToInfosTable extends Migration
{
    public function up()
    {
        Schema::table('infos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // Ajoute le champ user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Définir la clé étrangère
        });
    }

    public function down()
    {
        Schema::table('infos', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Supprimer la clé étrangère
            $table->dropColumn('user_id'); // Supprimer la colonne user_id
        });
    }
}
