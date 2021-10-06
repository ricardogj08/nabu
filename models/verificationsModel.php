<?php

defined('NABU') || exit();

class verificationsModel extends connection {
    public function __construct() {
        parent::__construct();
    }

    // Registra el 'hash de verificación de dirección de e-mail' con tiempo de expiración.
    public function save(array $verification) {
        $query = 'INSERT INTO verifications(id, hash, expiration) VALUES(:id, :hash, :expiration)';

        try {
            $this -> pdo -> prepare($query) -> execute($verification);
        }
        catch (PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar tu clave de verificación de dirección de correo electrónico');
        }
    }

    public function __destruct() {
        parent::__destruct();

        $this -> pdo = null;
    }
}
