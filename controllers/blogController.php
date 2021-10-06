<?php

defined('NABU') || exit();

require_once 'models/blogModel.php';

class blogController {
    // Renderiza la página de errores.
    static public function errors() {
        /*
        if (empty($_SESSION['errors'])) {
            utils::redirect(NABU_ROUTES['home']);
        }
        */

        // Define el código HTTP de respuesta.
        http_response_code($_SESSION['errors']['code']);

        $error = $_SESSION['errors']['message'];

        unset($_SESSION['errors']);

        messages::get();

        require_once 'views/pages/errors.php';
    }

    static public function home() {
        require_once 'views/pages/home.php';
    }
}
