<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('utilisateur')
            || !Schema::hasColumn('utilisateur', 'last_login')
            || !Schema::hasTable('security_login_events')) {
            return;
        }

        DB::table('utilisateur')
            ->whereNotNull('last_login')
            ->select(['id', 'last_login'])
            ->orderBy('id')
            ->chunk(500, function ($users) {
                $events = $users->map(fn ($user) => [
                    'utilisateur_id' => $user->id,
                    'channel' => 'historique',
                    'ip_address' => null,
                    'user_agent' => null,
                    'created_at' => $user->last_login,
                ])->all();

                if ($events) {
                    DB::table('security_login_events')->insert($events);
                }
            });
    }

    public function down(): void
    {
        DB::table('security_login_events')->where('channel', 'historique')->delete();
    }
};
