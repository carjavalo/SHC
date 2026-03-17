<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$c = \App\Models\Curso::find(20);
echo "Curso " . $c->id . " - " . $c->titulo . "\n";
echo "Fecha Inicio (Curso): " . $c->fecha_inicio . "\n";
echo "Fecha Fin (Curso): " . $c->fecha_fin . "\n";

$inscripciones = \DB::table('curso_estudiantes')->where('curso_id', 20)->get();
foreach ($inscripciones as $i) {
    echo "\nEstudiante ID: " . $i->estudiante_id . "\n";
    echo "Fecha Inscripción: " . $i->fecha_inscripcion . "\n";
    echo "Progreso: " . $i->progreso_porcentaje . "%\n";
}
