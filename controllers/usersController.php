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

    static public function login() {
        $token    = csrf::generate();
        $messages = messages::get();
        require_once 'views/pages/login.php';
    }

    static public function logout() {
        //
    }
}
