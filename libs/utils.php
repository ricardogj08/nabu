<?php

defined('NABU') || exit;

// Colecciòn de herramientas propias de Nabu.
class utils {
    // Redirecciona a una página web y termina la ejecución de todos los scripts de PHP.
    static public function redirect(string $route) {
        header('Location: ' . $route);
        exit;
    }

    static public function escape($pattern) {
        //
    }
}
