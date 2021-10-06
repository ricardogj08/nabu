<?php

defined('NABU') || exit();

require_once 'libs/php-smtp-2.0.4/Email.php';

use Snipworks\Smtp\Email;

// Envía mesajes de e-mail en formato HTML.
class emails {
    private $mail;

    private function errors(string $error) {
        messages::errors($error, 400);
    }

    public function __construct() {
        if (!file_exists(NABU_DIRECTORY['email'])) {
            $this -> errors('Create a e-mail config file');
        }

        // Carga el archivo de configuración del cliente de e-mail.
        $config = file_get_contents(NABU_DIRECTORY['email']);

        if ($config === false) {
            $this -> errors('The e-mail config file is invalid');
        }

        $config = json_decode($config, true);

        $keys = array('smtp', 'port', 'address', 'password');

        foreach ($keys as $key) {
            if (empty($config[$key])) {
                $this -> errors('Set "' . $key . '" in e-mail config file');
            }
        }

        // Configura el cliente del e-mail.
        $this -> mail = new Email($config['smtp'], $config['port']);
        $this -> mail -> setProtocol(Email::TLS);
        $this -> mail -> setLogin($config['address'], $config['password']);
        $this -> mail -> setFrom($config['address'], NABU_DEFAULT['website-name']);
    }

    // Define el destinatario del mensaje.
    public function prepare(string $destinatary, string $name) {
        $this -> mail -> addTo($destinatary, $name);
    }

    // Envía un mensaje de e-mail HTML.
    public function send(string $subject, string $body) {
        $this -> mail -> setSubject($subject);
        $this -> mail -> setHtmlMessage($body);
        return $this -> mail -> send();
    }
}
