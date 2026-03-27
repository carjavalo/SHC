<?php 
require 'vendor/autoload.php'; 
$app = require_once 'bootstrap/app.php'; 
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class); 
$kernel->bootstrap(); 
foreach(App\Models\CursoMaterial::where('curso_id', 18)->get() as $m) { 
    echo $m->id . ' | ' . $m->titulo . ' | %m: ' . $m->porcentaje_curso . ' | %act: ' . $m->actividades()->sum('porcentaje_curso') . PHP_EOL; 
}