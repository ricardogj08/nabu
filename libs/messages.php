<?php

defined('NABU') || exit;

// Administra mensajes sobre advertencias, avisos y errores en las páginas.
class messages {
    // Agrega mensajes sobre advertencias o avisos.
    static public function add(string $message) {
        if (empty($_SESSION['messages']))
            $_SESSION['messages'] = array();

        array_push($_SESSION['messages'], $message);
    }

    // @return un array de mensajes.
    static public function get() {
        if (empty($_SESSION['messages']))
            return array();

        $messages = $_SESSION['messages'];

        unset($_SESSION['messages']);

        return $messages;
    }

    // Muestra los mensajes almacenados en una página.
    static public function exist(string $route) {
        if (!empty($_SESSION['messages'])) {
            utils::redirect($route);
        }
    }

    // Define un mensaje de error y los muestra en la página de errores.
    static public function errors(string $message, int $code) {
        $_SESSION['errors'] = array(
            'message' => $message,
            'code'    => $code
        );

        utils::redirect(NABU_ROUTES['errors']);
    }
}
