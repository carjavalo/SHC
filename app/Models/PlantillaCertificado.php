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
     * Detecta automáticamente el formato real (JPEG/PNG) para evitar
     * problemas con X-Content-Type-Options: nosniff.
     */
    public function getFondoUrlAttribute(): ?string
    {
        try {
            // Extraer el base64 del JSON para detectar formato
            $base64 = $this->elementos_json['fondo_base64'] ?? null;

            // Detectar extensión real del formato de imagen
            $extension = 'png'; // default
            if ($base64) {
                if (str_contains($base64, 'data:image/jpeg') || str_contains($base64, 'data:image/jpg')) {
                    $extension = 'jpg';
                } elseif (str_contains($base64, 'data:image/webp')) {
                    $extension = 'webp';
                } elseif (str_contains($base64, 'data:image/gif')) {
                    $extension = 'gif';
                }
            }

            // Ruta relativa del archivo de fondo (con extensión correcta)
            $relativePath = 'certificados/fondos/plantilla_' . $this->id . '.' . $extension;

            // Si ya existe el archivo con la extensión correcta, devolver la URL
            if (Storage::disk('public')->exists($relativePath)) {
                return asset('storage/' . $relativePath);
            }

            // Limpiar archivos con extensión incorrecta (migración automática)
            $possibleExtensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
            foreach ($possibleExtensions as $ext) {
                $oldPath = 'certificados/fondos/plantilla_' . $this->id . '.' . $ext;
                if ($ext !== $extension && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

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

            // Si no se pudo detectar por el prefijo base64, detectar por magic bytes
            if ($extension === 'png' && strlen($decodedImage) >= 2) {
                $firstBytes = unpack('C2', $decodedImage);
                if ($firstBytes[1] === 0xFF && $firstBytes[2] === 0xD8) {
                    $extension = 'jpg';
                    $relativePath = 'certificados/fondos/plantilla_' . $this->id . '.' . $extension;
                }
            }

            // Guardar como archivo con extensión correcta
            Storage::disk('public')->put($relativePath, $decodedImage);

            // Actualizar fondo_path en la BD
            $this->update(['fondo_path' => $relativePath]);

            return asset('storage/' . $relativePath);
        } catch (\Throwable $e) {
            Log::warning("PlantillaCertificado #{$this->id}: Error al obtener fondo URL - " . $e->getMessage());

            // Fallback: devolver el base64 original directamente (funciona siempre)
            $base64 = $this->elementos_json['fondo_base64'] ?? null;
            return $base64 ?: null;
        }
    }
}
