<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PlantillaCertificado extends Model
{
    protected $fillable = [
        'nombre',
        'fondo_path',
        'elementos_json',
        'html_content',
    ];

    protected $casts = [
        'elementos_json' => 'array',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'plantilla_certificado_id');
    }

    /**
     * Obtener la URL del fondo del certificado.
     * Extrae el base64 del JSON, lo guarda como archivo de imagen en disco
     * y devuelve la URL pública. Si ya existe, devuelve la URL directamente.
     * Esto evita inyectar ~141KB de base64 en el HTML y resuelve problemas
     * de columnas TEXT truncadas en cPanel.
     */
    public function getFondoUrlAttribute(): ?string
    {
        try {
            // Ruta relativa del archivo de fondo
            $relativePath = 'certificados/fondos/plantilla_' . $this->id . '.png';

            // Si ya existe el archivo guardado, devolver la URL
            if (Storage::disk('public')->exists($relativePath)) {
                return asset('storage/' . $relativePath);
            }

            // Extraer el base64 del JSON
            $base64 = $this->elementos_json['fondo_base64'] ?? null;
            if (!$base64) {
                return null;
            }

            // Quitar el prefijo data:image/... si existe
            $imageData = $base64;
            if (str_contains($base64, ',')) {
                $imageData = substr($base64, strpos($base64, ',') + 1);
            }

            $decodedImage = base64_decode($imageData);
            if ($decodedImage === false) {
                Log::warning("PlantillaCertificado #{$this->id}: fondo_base64 no se pudo decodificar.");
                return null;
            }

            // Guardar como archivo
            Storage::disk('public')->put($relativePath, $decodedImage);

            // Actualizar fondo_path en la BD
            $this->update(['fondo_path' => $relativePath]);

            return asset('storage/' . $relativePath);
        } catch (\Throwable $e) {
            Log::warning("PlantillaCertificado #{$this->id}: Error al obtener fondo URL - " . $e->getMessage());

            // Fallback: devolver el base64 original si existe
            $base64 = $this->elementos_json['fondo_base64'] ?? null;
            return $base64 ?: null;
        }
    }
}
