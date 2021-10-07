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

    // @return un string escapado para HTML.
    static public function escape($str) {
        return htmlentities($str, ENT_COMPAT | ENT_HTML5, 'UTF-8');
    }

    // Redirecciona a 'route' si existe una sesión de usuario.
    static public function session_exists(string $route) {
        if (!empty($_SESSION['user'])) {
            self::redirect($route);
        }
    }
}
