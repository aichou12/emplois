<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecteurIdAndEmploiIdToInfosTable extends Migration
{
    public function up()
    {
        Schema::table('infos', function (Blueprint $table) {
            // Add foreign key columns
            $table->unsignedBigInteger('secteur_id')->nullable();
            $table->unsignedBigInteger('emploi_id')->nullable();

            // Add foreign key constraints
            $table->foreign('secteur_id')->references('id')->on('secteurs')->onDelete('set null');
            $table->foreign('emploi_id')->references('id')->on('emplois')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('infos', function (Blueprint $table) {
            // Drop the foreign keys
            $table->dropForeign(['secteur_id']);
            $table->dropForeign(['emploi_id']);

            // Drop the columns
            $table->dropColumn(['secteur_id', 'emploi_id']);
        });
    }
}

