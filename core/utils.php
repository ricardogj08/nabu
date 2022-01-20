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

// Colección de herramientas propias para Nabu.
class utils {
  // Redirecciona a una ruta y termina la ejecución de todos los scripts de PHP.
  static public function redirect(string $route) {
    header('Location: ' . $route);
    exit();
  }

  // Redirecciona a una ruta si existe una sesión de usuario.
  static public function session_exists(string $route) {
    if (isset($_SESSION['user']))
      self::redirect($route);
  }

  // @return un string escapado para HTML.
  static public function escape(string $str) {
    return htmlentities($str, ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }

  // @return la fecha actual.
  static public function current_date() {
    return date('Y-m-d H:i:s');
  }
}
