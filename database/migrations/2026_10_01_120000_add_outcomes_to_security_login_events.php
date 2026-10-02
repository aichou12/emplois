<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('security_login_events', function (Blueprint $table) {
            $table->integer('utilisateur_id')->nullable()->change();
            $table->string('result', 32)->default('success')->index();
            $table->string('identifier_hint', 180)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('security_login_events', function (Blueprint $table) {
            $table->dropIndex(['result']);
            $table->dropColumn(['result', 'identifier_hint']);
        });

        DB::table('security_login_events')->whereNull('utilisateur_id')->update(['utilisateur_id' => 0]);

        Schema::table('security_login_events', function (Blueprint $table) {
            $table->integer('utilisateur_id')->nullable(false)->change();
        });
    }
};
