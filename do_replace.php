<?php
$file = 'resources/views/welcome.blade.php';
$content = file_get_contents($file);

// El inicio de la etiqueta ul class="nav nav-tabs" hasta el final de la etiqueta de la forma
$pattern = '/<div class="overlay">\s*<div class="auth-container">.*?<div class="col-md-7 card-right">\s*(<ul class="nav nav-tabs".*?<\/div>\s*<\/div>\s*<\/form>\s*<\/div>\s*<\/div>)\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/s';

$replacement = '<div class="overlay" style="display:flex; align-items:center; min-height: 100vh;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div class="card-right" style="background-color: rgba(255,255,255,0.95); border-radius: 10px; padding: 20px;">
                        $1
                    </div>
                </div>
            </div>
        </div>
    </div>';

$newContent = preg_replace($pattern, $replacement, $content);

// Also remove the carousel script since we don't need it.
$newContent = preg_replace('/<!-- Carrusel JavaScript -->.*?<\/script>/s', '<!-- JS -->', $newContent);

file_put_contents($file, $newContent);
echo "Done";
