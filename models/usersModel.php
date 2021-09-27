<?php

defined('NABU') || exit;

class usersModel extends connection {
    public function __construct() {
        parent::__construct();
    }

    // Registra un nuevo usuario en la base de datos.
    public function save(array $user) {
        $query = 'INSERT INTO users(name, username, email, password, creation_date) ' .
                 'VALUES(:name, :username, :email, :password, :creation_date)';

        try {
            $this -> pdo -> prepare($query) -> execute($user);
        }
        catch(PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar tu cuenta de usuario');
        }
    }

    public function __destruct() {
        parent::__destruct();
        $this -> pdo = null;
    }
}
