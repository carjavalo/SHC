<?php
/**
 * Script para crear las carpetas de caché necesarias en Laravel.
 * Sube este archivo a la raíz del proyecto en cPanel y ejecútalo desde el navegador:
 * https://huveduca.huv.gov.co/fix_storage.php
 * 
 * IMPORTANTE: Elimina este archivo después de usarlo.
 */

echo "<h2>Creando carpetas de caché de Laravel...</h2>";

$basePath = __DIR__;

$directories = [
    $basePath . '/storage',
    $basePath . '/storage/app',
    $basePath . '/storage/app/public',
    $basePath . '/storage/framework',
    $basePath . '/storage/framework/cache',
    $basePath . '/storage/framework/cache/data',
    $basePath . '/storage/framework/sessions',
    $basePath . '/storage/framework/views',
    $basePath . '/storage/logs',
    $basePath . '/bootstrap/cache',
];

$results = [];

foreach ($directories as $dir) {
    $relative = str_replace($basePath . '/', '', $dir);
    if (!is_dir($dir)) {
        if (mkdir($dir, 0775, true)) {
            $results[] = "✅ Creada: $relative";
        } else {
            $results[] = "❌ Error al crear: $relative";
        }
    } else {
        // Intentar corregir permisos
        chmod($dir, 0775);
        $results[] = "✔️ Ya existe (permisos actualizados): $relative";
    }
}

// Crear archivo .gitignore en las carpetas necesarias
$gitignoreContent = "*\n!.gitignore\n";
$gitignoreDirs = [
    $basePath . '/storage/framework/cache/data',
    $basePath . '/storage/framework/sessions',
    $basePath . '/storage/framework/views',
    $basePath . '/storage/logs',
    $basePath . '/bootstrap/cache',
];

foreach ($gitignoreDirs as $dir) {
    $gitignorePath = $dir . '/.gitignore';
    if (!file_exists($gitignorePath)) {
        file_put_contents($gitignorePath, $gitignoreContent);
        $relative = str_replace($basePath . '/', '', $gitignorePath);
        $results[] = "📄 .gitignore creado en: $relative";
    }
}

echo "<ul>";
foreach ($results as $r) {
    echo "<li>$r</li>";
}
echo "</ul>";

echo "<hr>";
echo "<h3 style='color:green;'>✅ Proceso completado. Recarga tu aplicación.</h3>";
echo "<p style='color:red;'><strong>⚠️ ELIMINA este archivo (fix_storage.php) después de usarlo por seguridad.</strong></p>";
