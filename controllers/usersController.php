<?php

defined('NABU') || exit;

require_once 'models/usersModel.php';

class usersController {
    private const cost = array('cost' => 12);
    private const hash = 'sha256';

    static public function login() {
        require_once 'views/pages/login.php';
    }

    static public function logout() {
        //
    }

    // Renderiza la página de registro de usuarios
    // y registra un usuario con el método POST.
    static public function signup() {
        if (empty($_POST['signup-submit'])) {
            $token    = csrf::generate();
            $messages = messages::get();
            require_once 'views/pages/signup.php';
        }
        else {
            csrf::validate($_POST['csrf']);

            $validations = new validations(NABU_ROUTES['signup']);

            $data = $validations -> validate_form($_POST, array(
                array('name',     'exists' => true, 'trim_all'   => true, 'min_lenght' => 5,    'max_lenght' => 255),
                array('username', 'exists' => true, 'trim'       => true, 'min_lenght' => 1,    'max_lenght' => 255,  'not_spaces' => true),
                array('email',    'exists' => true, 'is_email'   => true, 'trim'       => true, 'min_lenght' => 5,    'max_lenght' => 255, 'not_spaces' => true),
                array('password', 'exists' => true, 'min_lenght' => 6,    'max_lenght' => 255,  'not_spaces' => true, 'equal'      => $_POST['confirm-password'])
            ));

            $usersModel = new usersModel();

            $users = $usersModel -> find($data['username'], $data['email']);

            // Genera una llave aleatoria de verificación de dirección de e-mail.
            $key = bin2hex(random_bytes(32));

            // Formatea en minúsculas la dirección de e-mail.
            $data['email'] = strtolower($data['email']);

            // Hash de verificación de e-mail.
            $hash = hash_hmac(self::hash, $data['email'], $key);

            // Cifra la contraseña.
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, self::cost);

            // Define la fecha de registro.
            $data['creation_date'] = utils::current_date();

            // Registra el nuevo usuario.
            $usersModel -> save($data);

            $user = $usersModel -> get('username', $data['username']);

            $verification = array(
                'id'         => $user['id'],
                'hash'       => $hash,
                'expiration' => time() + 60 * 60
            );

            // Registra el hash de verificación de dirección de e-mail.
            $usersModel -> verification($verification);
        }
    }
}
