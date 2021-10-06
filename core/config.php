<?php

defined('NABU') || exit();

define('NABU_URL', 'http://localhost:8000');

define('NABU_DIRECTORY', array(
    'avatars'             => NABU_URL . '/storage/avatars',
    'backgrounds'         => NABU_URL . '/storage/backgrounds',
    'covers'              => NABU_URL . '/storage/covers',
    'database'            => './database-config.json',
    'email'               => './email-config.json',
    'icons'               => NABU_URL . '/assets/icons',
    'images'              => NABU_URL . '/assets/images',
    'storage-avatars'     => './storage/avatars',
    'storage-backgrounds' => './storage/backgrounds',
    'storage-covers'      => './storage/covers',
    'scripts'             => NABU_URL . '/assets/scripts',
    'styles'              => NABU_URL . '/assets/styles',
));

define('NABU_DEFAULT', array(
    'website-name'  => 'Nabu',
    'article-size'  => 1048576 * 1, // 1 MB (en bytes).
    'avatar'        => NABU_URL . '/assets/images/avatar.png',
    'background'    => NABU_URL . '/assets/images/background.jpg',
    'cover'         => NABU_URL . '/assets/images/cover.jpg',
    'image-formats' => 'image/gif, image/jpeg, image/png, image/svg+xml',
    'image-size'    => 1048576 * 2, // 2 MB (en bytes).
));

// Define la zona horario de todas las funciones de fecha/tiempo.
date_default_timezone_set('America/Mexico_City');

/*
// Nivel de reporte de errores (todos los errores).
ini_set('error_reporting', E_ALL);

// No muestra en pantalla todos los errores.
ini_set('display_errors', 'Off');

// No muestra en pantalla todos los errores de inicio de ejecución de PHP.
ini_set('display_startup_errors', false);

// No registra mensajes repetidos.
ini_set('ignore_repeated_errros', true);

// Selecciona el manejador de errores de PHP 'error_log'.
ini_set('log_errors', true);

// Define la ruta del archivo de registro de errores para 'error_log'.
ini_set('error_log', 'logs/errors.log');
*/
