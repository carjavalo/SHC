<?php
$logPath = "c:\\xampp\\htdocs\\SHC\\storage\\logs\\laravel.log";
$lines = file($logPath);
$recent_lines = array_slice($lines, -500);

// We want to find context where "crearActividad" or requests fail with 422
foreach ($recent_lines as $line) {
    if (preg_match('/\{.*"message":.*"El porcentaje.*excede.*/i', $line, $matches) || preg_match('/\{.*"errors":.*/i', $line, $matches)) {
        echo $line . "\n";
    }
}
