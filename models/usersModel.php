<?php

defined('NABU') || exit;

class usersModel extends connection {
    public function __construct() {
        parent::__construct();
    }

    // @return un lista de arrays asociativos con los datos de usuarios.
    public function find(string $username, string $email) {
        $query = 'SELECT u.id, u.role_id AS role, u.username, u.email, u.password, u.activated, u.creation_date,' .
                 'v.hash, v.expiration AS hash_expiration FROM users AS u ' .
                 'LEFT JOIN verifications AS v on u.id = v.id ' .
                 'WHERE u.username = ? OR u.email = ? LIMIT 2';

        try {
            $prepare = $this -> pdo -> prepare($query);

            $prepare -> execute(array($username, $email));

            $users = $prepare -> fetchAll();

            if (empty($users)) {
                return array();
            }

            return $users;
        }
        catch(PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para validar si tu apodo y dirección de correo electrónico son únicos');
        }
    }

    // Registra un nuevo usuario.
    public function save(array $data) {
        $query = 'INSERT INTO users(name, username, email, password, creation_date) ' .
                 'VALUES(:name, :username, :email, :password, :creation_date)';

        try {
            $this -> pdo -> prepare($query) -> execute($data);
        }
        catch(PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar tu cuenta de usuario');
        }
    }

    // @return un array asociativo con los datos de un solo usuario.
    public function get(string $column, $pattern) {
        $query = 'SELECT u.id, u.role_id AS role, u.username, u.email, u.password, u.activated, u.creation_date,' .
                 'v.hash, v.expiration AS hash_expiration FROM users AS u ' .
                 'LEFT JOIN verifications AS v on u.id = v.id ' .
                 'WHERE u.' . $column .  ' = ? LIMIT 1';

        try {
            $prepare = $this -> pdo -> prepare($query);

            $prepare -> execute(array($pattern));

            $user = $prepare -> fetch();

            if ($user !== false) {
                $user['role'] = $this -> role_format($user['role']);
            }

            return $user;
        }
        catch(PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para buscar tu cuenta de usuario');
        }
    }

    // Registra el 'hash de verificación de dirección de e-mail' con tiempo de expiración.
    public function verification(array $verification) {
        $query = 'INSERT INTO verifications(id, hash, expiration) VALUES(:id, :hash, :expiration)';

        try {
            $this -> pdo -> prepare($query) -> execute($verification);
        }
        catch(PDOException $e) {
            $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar tu clave de verificación de dirección de correo electrónico');
        }
    }

    public function __destruct() {
        parent::__destruct();
        $this -> pdo = null;
    }
}
