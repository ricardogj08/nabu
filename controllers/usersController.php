<?php

defined('NABU') || exit();

require_once 'models/usersModel.php';

class usersController {
    private const cost = array('cost' => 12);
    private const hash = 'sha256';

    // Renderiza la página de registro de usuarios
    // y registra un usuario con el método POST.
    static public function signup() {
        if (empty($_POST['signup-submit'])) {
            utils::session_exists(NABU_ROUTES['home']);

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

            // Formatea en minúsculas la dirección de e-mail.
            $data['email'] = strtolower($data['email']);

            $usersModel = new usersModel();

            $users = $usersModel -> find($data['username'], $data['email']);

            $msg = 'Existe una cuenta registrada con el mismo apodo o dirección de correo electrónico, por favor inténtelo de nuevo';

            // Valida si la cuenta es única y elimina cuentas expiradas.
            foreach ($users as $user) {
                // Valida si es una cuenta activa o inactiva con registro de datos de usuario.
                if (empty($user['hash_expiration'])) {
                    messages::add($msg);
                    break;
                }
                else {
                    // Valida si es una cuenta expirada.
                    if (time() > $user['hash_expiration']) {
                        $usersModel -> delete($user['id']);
                    }
                    else {
                        messages::add($msg);
                        break;
                    }
                }
            }

            messages::exist(NABU_ROUTES['signup']);

            // Genera una llave aleatoria de verificación de dirección de e-mail.
            $key = bin2hex(random_bytes(32));

            // Hash de verificación de e-mail.
            $hash = hash_hmac(self::hash, $data['email'], $key);

            require_once 'libs/emails.php';

            $emails = new emails();
            $emails -> prepare($data['email'], $data['name']);

            // Genera una URL de verificación de dirección de e-mail.
            $url = NABU_ROUTES['verifications'] . '&user=' . urlencode($data['username']) . '&key=' . $key;

            $username = utils::escape($data['username']);

            $body = require_once 'views/emails/verifications.php';

            // Envía primero la URL de verificación de dirección de e-mail antes de registrar el usuario.
            if (!$emails -> send('¡Ya casi está listo!', $body)) {
                messages::errors('tuvimos un problema al enviar tu mensaje de verificación de e-mail', 500);
            }

            // Cifra la contraseña.
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, self::cost);

            // Define la fecha de registro.
            $data['creation_date'] = utils::current_date();

            // Registra el nuevo usuario.
            $usersModel -> save($data);

            $user = $usersModel -> get('username', $data['username']);

            unset($usersModel);

            $verification = array(
                'id'         => $user['id'],
                'hash'       => $hash,
                'expiration' => time() + 60 * 60
            );

            require_once 'models/verificationsModel.php';

            $verificationsModel = new verificationsModel();

            // Registra el hash de verificación de dirección de e-mail.
            $verificationsModel -> save($verification);

            messages::add('Su cuenta se ha registrado correctamente, por favor verifica tu dirección de correo electrónico');

            utils::redirect(NABU_ROUTES['signup']);
        }
    }

    // Renderiza la página de inicio de sesión
    // y asigna credeciales de acceso a los usuarios.
    static public function login() {
        if (empty($_POST['login-submit'])) {
            utils::session_exists(NABU_ROUTES['home']);

            $token    = csrf::generate();
            $messages = messages::get();

            require_once 'views/pages/login.php';
        }
        else {
            csrf::validate($_POST['csrf']);

            $validations = new validations(NABU_ROUTES['login']);

            $data = $validations -> validate_form($_POST, array(
                array('identity', 'exists' => true, 'trim' => true, 'min_lenght' => 1, 'max_lenght' => 255, 'not_spaces' => true),
                array('password', 'exists' => true, 'trim' => true, 'min_lenght' => 6, 'max_lenght' => 255, 'not_spaces' => true)
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

            $msg = 'La identificación de sesión o la contraseña es incorrecta';

            // Valida si es una cuenta activa o inactiva con registro de datos de usuario.
            if (empty($user)) {
                messages::add($msg);
            }
            else {
                if (empty($user['hash_expiration'])) {
                    // Valida la contraseña del usuario y define las creedenciales de acceso.
                    if (!empty($user['activated']) && password_verify($data['password'], $user['password'])) {
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
                    // Valida si es una cuenta expirada.
                    if (empty($user['activated'])) {
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

            messages::exist(NABU_ROUTES['login']);

            // Redirecciona al panel de administración en base al rol.
            if ($user['role'] == 'admin') {
                utils::redirect(NABU_ROUTES['admin']);
            }

            // Redirecciona al perfil del usuario.
            utils::redirect(NABU_ROUTES['profile'] . '&user=' . urlencode($user['username']));
        }
    }

    static public function logout() {
        //
    }
}
