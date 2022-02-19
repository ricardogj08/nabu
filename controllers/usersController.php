<?php
/*
* Este archivo es parte de Nabu.
*
* Nabu es software libre: puedes redistribuirlo y/o modificarlo
* bajo los términos de la Licencia Pública General de GNU Affero publicada por
* la Free Software Foundation, ya sea la versión 3 de la Licencia, o
* (a su elección) cualquier versión posterior.
*
* Nabu se distribuye con la esperanza de que sea de utilidad,
* pero SIN NINGUNA GARANTÍA; incluso sin la garantía implícita de
* COMERCIABILIDAD o APTITUD PARA UN PROPÓSITO PARTICULAR. Consulte la
* Licencia Pública General de GNU Affero para obtener más detalles.
*
* Debería haber recibido una copia de la Licencia Pública General de GNU Affero
* junto con este programa. De lo contrario, consulte <https://www.gnu.org/licenses/>.
*/

defined('NABU') || exit();

require_once 'models/usersModel.php';

class usersController {
  // Renderiza la página de registro de usuarios
  // y registra usuarios con el método POST.
  static public function signup() {
    // Redirecciona a "home" si existe una sesión de usuario.
    utils::session_exists(NABU_ROUTES['home']);

    // Renderiza la página de registro de usuarios.
    if (empty($_POST['signup-form'])) {
      $token    = csrf::generate();
      $messages = messages::get();

      require_once 'views/pages/signup.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $view = NABU_ROUTES['signup'];

    $validations = new validations($view);

    // Valida el formulario de registro de usuarios.
    $data = $validations -> validate($_POST, array(
      array('field' => 'name',     'trim_all'   => true, 'min_length' => 5,   'max_length' => 255),
      array('field' => 'username', 'trim'       => true, 'min_length' => 1,   'max_length' => 255,  'not_spaces' => true),
      array('field' => 'email',    'trim'       => true, 'min_length' => 5,   'max_length' => 255,  'not_spaces' => true, 'type' => 'email'),
      array('field' => 'password', 'min_length' => 6,    'max_length' => 255, 'not_spaces' => true, 'equal'      => $_POST['confirm-password'])
    ));

    // Formatea en minúsculas la dirección de e-mail.
    $data['email'] = strtolower($data['email']);

    $usersModel = new usersModel();

    $users = $usersModel -> find($data['username'], $data['email']);

    $msg = 'Existe un cuenta registrada con el mismo apodo o dirección de correo electrónico, por favor inténtelo de nuevo';

    // Valida si la cuenta es única y elimina cuentas con autenticación expirada.
    foreach ($users as $user) {
      // Valida si es una cuenta inactiva.
      if (empty($user['activated']) && !empty($user['expiration'])) {
        // Valida si la autenticación está expirada.
        if (time() > $user['expiration'])
          $usersModel -> delete($user['id']);
        else {
          messages::add($msg);
          messages::check($view);
        }
      }
      else {
        messages::add($msg);
        messages::check($view);
      }
    }

    // Genera una llave aleatoria de autenticación de e-mail.
    $key = bin2hex(random_bytes(32));

    // Genera un hash de autenticación de e-mail.
    $hash = hash_hmac('sha256', $data['email'], $key);

    require_once 'libs/emails.php';

    $emails = new emails();
    $emails -> prepare($data['email'], $data['name']);

    // Genera una URL de autenticación de e-mail.
    $url = NABU_ROUTES['authentication'] . '&user=' . urlencode($data['username']) . '&key=' . $key;

    $username = utils::escape($data['username']);

    $body = require_once 'views/emails/authentication.php';

    // Envía primero la URL de autenticación de e-mail antes de registrar al usuario.
    if (!$emails -> send('¡Ya casi está listo!', $body))
      messages::errors('¡Lo sentimos mucho! &#x1F61E;, por el momento no podemos enviar tu mensaje de autenticación de e-mail', 500);

    // Cifra la contraseña.
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, array('cost' => 12));

    $data['registration_date'] = utils::current_date();

    // Registra el nuevo usuario.
    $usersModel -> save($data);

    // Consulta el id del nuevo usuario.
    $user = $usersModel -> get('username', $data['username']);

    unset($usersModel);

    // Define la fecha de expiración de la autenticación de e-mail.
    $authentication = array(
      'id'         => $user['id'],
      'hash'       => $hash,
      'expiration' => time() + 60 * 60
    );

    require_once 'models/authenticationModel.php';

    $authenticationModel = new authenticationModel();

    // Registra el hash de autenticación de e-mail.
    $authenticationModel -> save($authentication);

    messages::add('Tu cuenta se ha registrado correctamente, por favor verifica tu dirección de correo electrónico');

    utils::redirect($view);
  }

  // Renderiza la página de inicio de sesión
  // y asigna credenciales de acceso con el método POST.
  static public function login() {
    utils::session_exists(NABU_ROUTES['home']);

    // Renderiza la página de inicio de sesión.
    if (empty($_POST['login-form'])) {
      $token    = csrf::generate();
      $messages = messages::get();

      require_once 'views/pages/login.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $view = NABU_ROUTES['login'];

    $validations = new validations($view);

    // Valida el formulario de inicio de sesión.
    $data = $validations -> validate($_POST, array(
      array('field' => 'identity', 'trim'       => true, 'min_length' => 1,   'max_length' => 255, 'not_spaces' => true),
      array('field' => 'password', 'min_length' => 6,    'max_length' => 255, 'not_spaces' => true)
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

    $msg = 'La identificación de sesión o la contraseña son incorrectas';

    // Valida si existe el usuario.
    if (empty($user)) {
      messages::add($msg);
      utils::redirect($view);
    }

    // Valida la contraseña del usuario.
    if (!password_verify($data['password'], $user['password'])) {
      messages::add($msg);
      utils::redirect($view);
    }

    // Valida si el usuario tiene fecha de expiración del hash de autenticación de e-mail.
    if (empty($user['expiration'])) {
      // Define las credenciales de acceso si es una cuenta activa.
      if (empty($user['activated']))
        messages::add($msg);
      else
        $_SESSION['user'] = array(
          'id'       => $user['id'],
          'username' => $user['username'],
          'role'     => $user['role']
        );
    }
    else {
      // Valida si es una cuenta inactiva.
      if (empty($user['activated'])) {
        // Valida si es una cuenta con hash expirado.
        if (time() > $user['expiration']) {
          $usersModel -> delete($user['id']);
          messages::add('Tu cuenta ha expirado, por favor vuelve a registrarte');
        }
        else
          messages::add('Por favor confirma tu dirección de correo electrónico');
      }
      else
        messages::add($msg);
    }

    messages::check($view);

    $role = $user['role'];

    // Redirecciona al panel de administración en base al role.
    if ($role == 'admin' || $role == 'moderator')
      utils::redirect(NABU_ROUTES['approve-articles']);

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
