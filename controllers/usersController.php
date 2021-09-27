<?php

defined('NABU') || exit;

require_once 'models/usersModel.php';

class usersController {
    private const cost = array('cost' => 12);

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

            $user = $validations -> validate_form($_POST, array(
                array('name',     'exists' => true, 'trim_all'   => true, 'min_lenght' => 5,    'max_lenght' => 255),
                array('username', 'exists' => true, 'trim'       => true, 'min_lenght' => 1,    'max_lenght' => 255,  'not_spaces' => true),
                array('email',    'exists' => true, 'is_email'   => true, 'trim'       => true, 'min_lenght' => 5,    'max_lenght' => 255, 'not_spaces' => true),
                array('password', 'exists' => true, 'min_lenght' => 6,    'max_lenght' => 255,  'not_spaces' => true, 'equal'      => $_POST['confirm-password'])
            ));

            $usersModel = new usersModel();

            // Formatea en minúsculas la dirección de e-mail.
            $user['email'] = strtolower($user['email']);

            // Cifra la contraseña.
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT, self::cost);

            // Define la fecha de registro.
            $user['creation_date'] = utils::current_date();

            // Registra el nuevo usuario.
            $usersModel -> save($user);
        }
    }
}
