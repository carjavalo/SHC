<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            return;
        }

        $exists = DB::table('roles')->where('name', 'Auxiliar')->exists();
        if (!$exists) {
            $now = now();
            DB::table('roles')->insert([
                'name' => 'Auxiliar',
                'description' => 'Auxiliar',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // No eliminamos roles en rollback para no perder datos
    }
};
