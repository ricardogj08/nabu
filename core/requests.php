<?php

defined('NABU') || exit;

session_start();

require_once 'core/config.php';
require_once 'libs/utils.php';
require_once 'libs/messages.php';
require_once 'libs/validations.php';

$components = require 'core/routes.php';

$routes = array();

// Genera la URL completa de todas las rutas.
foreach ($components as $alias => $component) {
    $routes[$alias] = NABU_URL . '/index.php?view=' . $component['route'];
}

define('NABU_ROUTES', $routes);

// Selecciona el controlador y la vista de una ruta solicitada.
if (!empty($_GET['view'])) {
    foreach ($components as $alias => $component) {
        if ($component['route'] == $_GET['view']) {
            $controller = $component['controller'];
            $view       = $component['view'];
            break;
        }
    }
}

if (empty($controller) || empty($view)) {
    utils::redirect(NABU_ROUTES['home']);
}

unset($components, $routes);

require_once 'controllers/' . $controller . '.php';

// Renderiza la vista de una página web.
$controller::$view();
