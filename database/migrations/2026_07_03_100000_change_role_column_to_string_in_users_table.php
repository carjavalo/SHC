<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Convierte la columna 'role' de ENUM a VARCHAR para soportar el
     * sistema de roles dinámico (tabla 'roles'). Con el ENUM, cualquier rol
     * nuevo que no estuviera en la lista fija provocaba el error
     * "Data truncated for column 'role'" al guardar (ej: Auxiliar).
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(100) NOT NULL DEFAULT 'Registrado'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Administrador', 'Docente', 'Estudiante', 'Registrado', 'Operador') NOT NULL DEFAULT 'Registrado'");
    }
};
