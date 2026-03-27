<?php
$logPath = "c:\\xampp\\htdocs\\SHC\\storage\\logs\\laravel.log";
$lines = file($logPath);
$recent_lines = array_slice($lines, -1000);
$found = [];
foreach ($recent_lines as $i => $line) {
    if (strpos($line, '422') !== false || strpos($line, 'error') !== false || strpos($line, 'excede') !== false || strpos($line, 'fail') !== false || strpos($line, 'Validation') !== false) {
        $found[] = trim($line);
    }
}
print_r(array_slice($found, -20));
