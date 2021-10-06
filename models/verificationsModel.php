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

    // @return un array asociativo con los datos de verificación de un usuario.
    public function get(string $username) {
        $query = 'SELECT u.id, u.email, v.hash, v.expiration as hash_expiration ' .
                 'FROM users AS u LEFT JOIN verifications AS v ON u.id = v.id ' .
                 'WHERE u.username = ? LIMIT 1';

        try {
            $prepare = $this -> pdo -> prepare($query);

            $prepare -> execute(array($username));

            $user = $prepare -> fetch();

            if (empty($user)) {
                return array();
            }

            return $user;
        }
        catch (PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para validar tu dirección de correo electrónico');
        }
    }

    public function __destruct() {
        parent::__destruct();
        $this -> pdo = null;
    }
}
