<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('userdata', function (Blueprint $table) {
            $table->string('diplome_file')->nullable()->after('employeur');
            $table->string('cv_file')->nullable()->after('diplome_file');
        });
    }

    public function down()
    {
        Schema::table('userdata', function (Blueprint $table) {
            $table->dropColumn(['diplome_file', 'cv_file']);
        });
    }
};

