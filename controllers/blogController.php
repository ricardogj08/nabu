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

class blogController {
  // Renderiza la página principal del sitio web.
  static public function home() {
    require_once 'models/blogModel.php';

    $blogModel = new blogModel();

    // Obtiene los artículos más populares.
    $articles = $blogModel -> popular_articles(5);

    // Obtiene los artículos más recientes.
    $recent_articles = $blogModel -> recent_articles(10);

    unset($blogModel);

    $messages = messages::get();

    require_once 'views/pages/home.php';
  }

  // Renderiza la página de errores.
  static public function errors() {
    if (empty($_SESSION['errors']))
      utils::redirect(NABU_ROUTES['home']);

    // Define el código HTTP de respuesta.
    http_response_code($_SESSION['errors']['code']);

    $error = $_SESSION['errors']['message'];

    unset($_SESSION['errors']);

    messages::get();

    require_once 'views/pages/errors.php';
  }
}
