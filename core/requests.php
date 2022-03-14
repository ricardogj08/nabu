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

session_start();

$components = require 'core/routes.php';

require_once 'core/config.php';
require_once 'core/utils.php';
require_once 'core/messages.php';
require_once 'db/connection.php';
require_once 'libs/csrf.php';
require_once 'libs/validations.php';

// Selecciona el controlador y la vista de una ruta solicitada.
if (isset($_GET['view']))
  foreach ($components as $alias => $component)
    if ($component['route'] == $_GET['view']) {
      $controller = $component['controller'];
      $view       = $component['view'];
      break;
    }

unset($components);

if (empty($controller) || empty($view))
  utils::redirect(NABU_ROUTES['home']);

require_once 'controllers/' . $controller . '.php';

// Renderiza la vista de una página web.
$controller::$view();
