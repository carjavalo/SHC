<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
