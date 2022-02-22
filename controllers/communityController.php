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

  // Registra o elimina el like de un artículo.
  static public function likes() {
    $view = NABU_ROUTES['home'];

    utils::check_session($view);

    $validations = new validations($view);

    // Valida la URL del artículo.
    $data = $validations -> validate($_GET, array(
      array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
    ));

    $communityModel = new communityModel();

    // Obtiene los datos del artículo.
    $article = $communityModel -> get_article($data['slug']);

    if (empty($article))
      utils::redirect($view);

    $id = $_SESSION['user']['id'];

    // Obtiene los datos del like del usuario de sesión con el artículo.
    $like = $communityModel -> get_like($id, $article['id']);

    // Registra el like del artículo si no existe información desde la base de datos.
    if (empty($like))
      $communityModel -> save_like($id, $article['id']);
    else
      $communityModel -> delete_like($like['id']);

    utils::redirect(NABU_ROUTES['article'] . '&slug=' . $article['slug']);
  }
}
