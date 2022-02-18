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

require_once 'models/authenticationModel.php';

class authenticationController {
  // Activa la cuenta de un usuario desde una URL
  // de autenticación de dirección de e-mail.
  public static function authentication() {
    $validations = new validations(NABU_ROUTES['home']);

    // Valida los parámetros de la URL.
    $data = $validations -> validate($_GET, array(
      array('field' => 'user', 'min_length' => 1, 'max_length' => 255),
      array('field' => 'key',  'min_length' => 1, 'max_length' => 255)
    ));

    $authenticationModel = new authenticationModel();

    // Busca los datos de autenticación de e-mail del usuario.
    $user = $authenticationModel -> get($data['user']);

    if (empty($user['hash']) || empty($user['expiration']) || !empty($user['activated']))
      utils::redirect(NABU_ROUTES['home']);

    // Reconstruye el hash con la llave de autenticación de la URL.
    $hash = hash_hmac('sha256', $user['email'], $data['key']);

    if (!hash_equals($user['hash'], $hash))
      utils::redirect(NABU_ROUTES['home']);

    // Valida si el hash de autenticación de e-mail está expirado.
    if (time() > $user['expiration']) {
      unset($authenticationModel);

      require_once 'models/usersModel.php';

      $usersModel = new usersModel();
      $usersModel -> delete($user['id']);

      messages::add('Tu cuenta ha expirado, por favor vuelve a registrarte');

      utils::redirect(NABU_ROUTES['signup']);
    }

    // Activa la cuenta del usuario y crea su perfil.
    $authenticationModel -> activate($user['id']);

    messages::add('Tu dirección de correo electrónico se ha verificado correctamente');

    utils::redirect(NABU_ROUTES['login']);
  }
}
