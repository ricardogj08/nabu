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

// Administra mensajes sobre advertencias, avisos y errores.
class messages {
  // Agrega nuevos mensajes.
  static public function add(string $message) {
    if (empty($_SESSION['messages']))
      $_SESSION['messages'] = array();

    array_push($_SESSION['messages'], $message);
  }

  // @return un array de mensajes.
  static public function get() {
    if (empty($_SESSION['messages']))
      return array();

    $messages = $_SESSION['messages'];

    unset($_SESSION['messages']);

    return $messages;
  }

  // Muestra los mensajes almacenados en una página.
  static public function check(string $route) {
    if (isset($_SESSION['messages']))
      utils::redirect($route);
  }

  // Define un mensaje de error y redirecciona a la página de errores.
  static public function errors(string $message, int $code) {
    $_SESSION['errors'] = array(
      'message' => $message,
      'code'    => $code
    );
    utils::redirect(NABU_ROUTES['errors']);
  }
}
