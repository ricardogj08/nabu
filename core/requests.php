<?php

defined('NABU') || exit;

require_once 'core/config.php';

$components = require 'core/routes.php';

$routes = array();

// Genera la URL completa de todas las rutas.
foreach ($components as $alias => $component) {
    $routes[$alias] = NABU_URL . '/index.php?view=' . $component['route'];
}

define('NABU_ROUTES', $routes);

// Selecciona el controlador y la vista de una ruta solicitada.
$controller = 'blogController';
$view       = 'home';

if (!empty($_GET['view'])) {
    foreach ($components as $alias => $component) {
        if ($component['route'] == $_GET['view']) {
            $controller = $component['controller'];
            $view       = $component['view'];
        }
    }
}

unset($components, $routes);

require_once 'controllers/' . $controller . '.php';

// Renderiza la vista de una página web.
$controller::$view();
