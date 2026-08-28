<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Permiso para verificar manualmente el correo de un usuario desde
     * la grilla de Usuarios (Acciones). Configurable en Asignar Permisos.
     */
    public function up(): void
    {
        $now = now();

        $permission = [
            'name' => 'users.verify',
            'display_name' => 'Verificar Correo de Usuarios',
            'group' => 'Gestión de Usuarios',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        if (!DB::table('permissions')->where('name', $permission['name'])->exists()) {
            DB::table('permissions')->insert($permission);
        }

        $permId = DB::table('permissions')->where('name', 'users.verify')->value('id');

        // Por defecto lo tienen los mismos roles que ya podían editar usuarios
        foreach (['Super Admin', 'Administrador'] as $roleName) {
            $yaAsignado = DB::table('role_permissions')
                ->where('role_name', $roleName)
                ->where('permission_id', $permId)
                ->exists();

            if (!$yaAsignado) {
                DB::table('role_permissions')->insert([
                    'role_name' => $roleName,
                    'permission_id' => $permId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        $permId = DB::table('permissions')->where('name', 'users.verify')->value('id');

        if ($permId) {
            DB::table('role_permissions')->where('permission_id', $permId)->delete();
            DB::table('permissions')->where('id', $permId)->delete();
        }
    }
};
