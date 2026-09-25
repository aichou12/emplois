<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('userdata_drafts', function (Blueprint $table) {
            $table->id();
            // The legacy utilisateur table uses a signed INT primary key.
            $table->integer('utilisateur_id')->unique();
            $table->longText('payload')->nullable();
            $table->longText('files')->nullable();
            $table->unsignedTinyInteger('current_step')->default(1);
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('id')->on('utilisateur')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('userdata_drafts');
    }
};
