<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plantilla_certificados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('fondo_path')->nullable();
            $table->json('elementos_json')->nullable(); // Store positions, texts, logos coordinates.
            $table->text('html_content')->nullable(); // Cached HTML version if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_certificados');
    }
};
