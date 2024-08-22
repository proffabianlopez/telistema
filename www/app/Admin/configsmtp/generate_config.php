<?php
function generatePassword($length = 12) {
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $symbols = '!@#$%^&*()-_=+<>?';

    // Garantizar que la contraseña contenga al menos un carácter de cada tipo
    $password = '';
    $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
    $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
    $password .= $numbers[rand(0, strlen($numbers) - 1)];
    $password .= $symbols[rand(0, strlen($symbols) - 1)];

    // Rellenar el resto de la contraseña con caracteres aleatorios
    $allCharacters = $uppercase . $lowercase . $numbers . $symbols;
    for ($i = 4; $i < $length; $i++) {
        $password .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
    }

    // Mezclar los caracteres de la contraseña para evitar cualquier patrón predecible
    return str_shuffle($password);
}

function capitalizeWords($string) {
    // Convierte todo el string a minúsculas
    $string = strtolower($string);
    // Convierte la primera letra de cada palabra a mayúscula
    $string = ucwords($string);
    return $string;
}
?>