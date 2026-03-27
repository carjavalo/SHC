<?php
$lines = file('storage/logs/laravel.log');
$errors = [];
foreach ($lines as $line) {
    if (strpos($line, '"errors"') !== false || strpos($line, '"message"') !== false) {
        $data = json_decode(substr(trim($line), strpos($line, '{')), true);
        if ($data) $errors[] = $data;
    }
}
print_r(array_slice($errors, -5));
