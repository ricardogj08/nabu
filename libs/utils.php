<?php

defined('NABU') || exit();

// Colección de herramientas propias de Nabu.
class utils {
    // Redirecciona a una página web y termina la ejecución de todos los scripts de PHP.
    static public function redirect(string $route) {
        header('Location: ' . $route);
        exit();
    }

    // @return la fecha actual.
    static public function current_date() {
        return date('Y-m-d H:i:s');
    }

    static public function escape($str) {
        //
    }
}
