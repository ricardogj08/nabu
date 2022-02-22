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

require_once 'models/communityModel.php';

class communityController {
  // Elimina un comentario.
  static public function delete_comment() {
    $view = NABU_ROUTES['home'];

    utils::check_session($view);

    if (empty($_GET['id']) || !is_numeric($_GET['id']))
      utils::redirect($view);

    $communityModel = new communityModel();

    // Obtiene los datos del comentario.
    $comment = $communityModel -> get_comment($_GET['id']);

    if (empty($comment))
      utils::redirect($view);

    $user = $_SESSION['user'];

    // Elimina el comentario.
    if ($comment['user_id'] == $user['id'] || $user['role'] == 'admin' || $user['role'] == 'moderator') {
      $communityModel -> delete_comment($comment['id']);

      messages::add('El comentario se ha eliminado correctamente');
    }

    utils::redirect(NABU_ROUTES['article'] . '&slug=' . $comment['slug']);
  }
}
