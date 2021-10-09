<?php

defined('NABU') || exit();

// Manipula los datos de verificación de e-mail.
class verificationsModel extends connection {
    public function __construct() {
        parent::__construct();
    }

    // Registra el hash de verificación de e-mail con tiempo de expiración.
    public function save(array $verification) {
        $query = 'INSERT INTO verifications(id, hash, expiration) VALUES(:id, :hash, :expiration)';

        try {
            $this -> pdo -> prepare($query) -> execute($verification);
        }
        catch (PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar tu clave de verificación de dirección de correo electrónico');
        }
    }

    // @return un array asociativo con los datos de verificación de e-mail de un usuario.
    public function get(string $username) {
        $query = 'SELECT u.id, u.email, u.activated, v.hash, v.expiration as hash_expiration ' .
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

    // Activa la cuenta, elimina la verificación y crea el perfil de un usuario.
    public function activate(int $id) {
        $query_activate = 'UPDATE users SET activated = TRUE WHERE id = ?';
        $query_delete   = 'DELETE FROM verifications WHERE id = ?';
        $query_profile  = 'INSERT INTO profiles(id) VALUES(?)';

        $id = array($id);

        try {
            $this -> pdo -> prepare($query_activate) -> execute($id);
            $this -> pdo -> prepare($query_delete) -> execute($id);
            $this -> pdo -> prepare($query_profile) -> execute($id);
        }
        catch (PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para activar tu cuenta de usuario');
        }
    }

    public function __destruct() {
        parent::__destruct();
        $this -> pdo = null;
    }
}
