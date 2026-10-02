<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('subject', 180);
            $table->text('body');
            $table->json('filters')->nullable();
            $table->string('channel', 12)->default('email');
            $table->string('status', 20)->default('draft')->index();
            $table->unsignedInteger('recipient_count')->default(0);
            $table->unsignedInteger('sent_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->integer('created_by')->nullable()->index();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('admin_email_campaign_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('admin_email_campaigns')->cascadeOnDelete();
            $table->integer('utilisateur_id')->nullable()->index();
            $table->string('email', 255);
            $table->string('status', 16)->default('pending')->index();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->unique(['campaign_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_email_campaign_recipients');
        Schema::dropIfExists('admin_email_campaigns');
    }
};
