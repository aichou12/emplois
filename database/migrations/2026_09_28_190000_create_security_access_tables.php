<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_login_events', function (Blueprint $table) {
            $table->id();
            $table->integer('utilisateur_id')->index();
            $table->string('channel', 24)->default('web');
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('user_agent', 1000)->nullable();
            $table->timestamp('created_at')->index();
        });

        Schema::create('security_blocked_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('utilisateur_id')->index();
            $table->integer('blocked_by')->nullable();
            $table->string('reason', 500)->nullable();
            $table->timestamp('blocked_at');
            $table->integer('released_by')->nullable();
            $table->timestamp('released_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('security_blocked_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->index();
            $table->integer('blocked_by')->nullable();
            $table->string('reason', 500)->nullable();
            $table->timestamp('blocked_at');
            $table->integer('released_by')->nullable();
            $table->timestamp('released_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_blocked_ips');
        Schema::dropIfExists('security_blocked_accounts');
        Schema::dropIfExists('security_login_events');
    }
};
