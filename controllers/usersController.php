<?php

defined('NABU') || exit();

require_once 'models/usersModel.php';

class usersController {
    // Renderiza la página de registro de usuarios
    // y registra un usuario con el método POST.
    static public function signup() {
        // Renderiza la página de registro de usuarios.
        if (empty($_POST['signup-submit'])) {
            // Redirecciona a home si existe una sesión de usuario.
            utils::session_exists(NABU_ROUTES['home']);

            $token    = csrf::generate();
            $messages = messages::get();

            require_once 'views/pages/signup.php';

            exit();
        }

        csrf::validate($_POST['csrf']);

        $validations = new validations(NABU_ROUTES['signup']);

        // Valida el formulario de registro de usuarios.
        $data = $validations -> validate_form($_POST, array(
            array('name',     'exists' => true, 'trim_all'   => true, 'min_lenght' => 5,    'max_lenght' => 255),
            array('username', 'exists' => true, 'trim'       => true, 'min_lenght' => 1,    'max_lenght' => 255,  'not_spaces' => true),
            array('email',    'exists' => true, 'is_email'   => true, 'trim'       => true, 'min_lenght' => 5,    'max_lenght' => 255, 'not_spaces' => true),
            array('password', 'exists' => true, 'min_lenght' => 6,    'max_lenght' => 255,  'not_spaces' => true, 'equal'      => $_POST['confirm-password'])
        ));

        // Formatea en minúsculas la dirección de e-mail.
        $data['email'] = strtolower($data['email']);

        $usersModel = new usersModel();

        $users = $usersModel -> find($data['username'], $data['email']);

        $msg   = 'Existe una cuenta registrada con el mismo apodo o dirección de correo electrónico, por favor inténtalo de nuevo';
        $route = NABU_ROUTES['signup'];

        // Valida si la cuenta es única y elimina cuentas con hash expirado.
        foreach ($users as $user) {
            // Valida si es una cuenta inactiva.
            if (empty($user['activated']) && !empty($user['hash_expiration'])) {
                // Valida si es una cuenta con hash expirado.
                if (time() > $user['hash_expiration']) {
                    $usersModel -> delete($user['id']);
                }
                else {
                    messages::add($msg);
                    messages::exist($route);
                }
            }
            else {
                messages::add($msg);
                messages::exist($route);
            }
        }

        // Genera una llave aleatoria de verificación de e-mail.
        $key = bin2hex(random_bytes(32));

        // Genera un hash de verificación de e-mail.
        $hash = hash_hmac('sha256', $data['email'], $key);

        require_once 'libs/emails.php';

        $emails = new emails();
        $emails -> prepare($data['email'], $data['name']);

        // Genera una URL de verificación de e-mail.
        $url = NABU_ROUTES['verifications'] . '&user=' . urlencode($data['username']) . '&key=' . $key;

        $username = utils::escape($data['username']);

        $body = require_once 'views/emails/verifications.php';

        // Envía primero la URL de verificación de e-mail antes de registrar un usuario.
        if (!$emails -> send('¡Ya casi está listo!', $body)) {
            messages::errors('tuvimos un problema al enviar tu mensaje de verificación de e-mail', 500);
        }

        // Cifra la contraseña.
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, array('cost' => 12));

        // Establece la fecha de registro.
        $data['creation_date'] = utils::current_date();

        // Registra el nuevo usuario.
        $usersModel -> save($data);

        // Consulta el id del nuevo usuario.
        $user = $usersModel -> get('username', $data['username']);

        unset($usersModel);

        // Establece la fecha de expiración del hash
        // de verificación de e-mail (1 hora).
        $verification = array(
            'id'         => $user['id'],
            'hash'       => $hash,
            'expiration' => time() + 60 * 60
        );

        require_once 'models/verificationsModel.php';

        $verificationsModel = new verificationsModel();

        // Registra el hash de verificación de e-mail.
        $verificationsModel -> save($verification);

        messages::add('Su cuenta se ha registrado correctamente, por favor verifica tu dirección de correo electrónico');

        utils::redirect(NABU_ROUTES['signup']);
    }

    // Renderiza la página de inicio de sesión y asigna credeciales
    // de acceso a los usuarios con el método POST.
    static public function login() {
        // Renderiza la página de inicio de sesión.
        if (empty($_POST['login-submit'])) {
            // Redirecciona a home si existe una sesión de usuario.
            utils::session_exists(NABU_ROUTES['home']);

            $token    = csrf::generate();
            $messages = messages::get();

            require_once 'views/pages/login.php';

            exit();
        }

        csrf::validate($_POST['csrf']);

        $validations = new validations(NABU_ROUTES['login']);

        // Valida el formulario de inicio de sesión.
        $data = $validations -> validate_form($_POST, array(
            array('identity', 'exists' => true, 'trim'       => true, 'min_lenght' => 1,   'max_lenght' => 255, 'not_spaces' => true),
            array('password', 'exists' => true, 'min_lenght' => 6,    'max_lenght' => 255, 'not_spaces' => true)
        ));

        $column = 'username';

        // Selecciona el tipo de identificación (por apodo o e-mail).
        if (filter_var($data['identity'], FILTER_VALIDATE_EMAIL)) {
            $column           = 'email';
            $data['identity'] = strtolower($data['identity']);
        }

        $usersModel = new usersModel();

        // Busca el usuario de acceso.
        $user = $usersModel -> get($column, $data['identity']);

        $msg   = 'La identificación de sesión o la contraseña es incorrecta';
        $route = NABU_ROUTES['login'];

        // Valida si existe el usuario.
        if (empty($user)) {
            messages::add($msg);
            messages::exist($route);
        }

        // Valida la contraseña del usuario.
        if (password_verify($data['password'], $user['password'])) {
            // Valida si el usuario tiene fecha de expiración del hash de verificación de e-mail.
            if (empty($user['hash_expiration'])) {
                // Establece las credenciales de acceso si es una cuenta activa.
                if (empty($user['activated'])) {
                    $_SESSION['user'] = array(
                        'id'       => $user['id'],
                        'username' => $user['username'],
                        'role'     => $user['role']
                    );
                }
                else {
                    messages::add($msg);
                }
            }
            else {
                // Valida si es una cuenta inactiva.
                if (empty($user['activated'])) {
                    // Valida si es una cuenta con hash expirado.
                    if (time() > $user['hash_expiration']) {
                        $userModel -> delete($user['id']);
                        messages::add('Tu cuenta a expirado, por favor vuelve a registrarte');
                    }
                    else {
                        messages::add('Por favor confirma tu dirección de correo electrónico');
                    }
                }
                else {
                    messages::add($msg);
                }
            }
        }
        else {
            messages::add($msg);
        }

        messages::exist($route);

        // Redirecciona al panel de administración en base al rol.
        if ($user['role'] == 'admin') {
            utils::redirect(NABU_ROUTES['admin']);
        }

        // Redirecciona al perfil del usuario.
        utils::redirect(NABU_ROUTES['profile'] . '&user=' . urlencode($user['username']));
    }

    // Cierra una sesión de usuario.
    static public function logout() {
        session_unset();
        session_destroy();
        utils::redirect(NABU_ROUTES['home']);
    }
}
