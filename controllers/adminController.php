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

require_once 'models/adminModel.php';

class adminController {
  private const limit = 10;

  // Renderiza la página de administración para aprobar un artículo
  // y realiza búsquedas con el método POST.
  static public function approve_articles() {
    $max    = 246;
    $search = utils::validate_search(NABU_ROUTES['approve-articles'], $max);
    $query  = $search['query'];
    $view   = $search['view'];

    $adminModel = new adminModel();

    // Obtiene el número total de artículos en espera de aprobación.
    $total = $adminModel -> count_sent($query);

    $pagination = utils::pagination($total, self::limit, $view);

    // Lista de artículos en espera de aprobación.
    $articles = $adminModel -> sent(self::limit, $pagination['accumulation'], $query);

    $page = $pagination['page'];

    unset($search, $adminModel, $total, $pagination);

    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/admin/approve-articles.php';
  }

  // Renderiza la página de administración para editar un artículo
  // y actualiza los datos de un artículo con el método POST.
  static public function review_article() {
    $validations = new validations(NABU_ROUTES['approve-articles']);

    $messages = messages::get();

    // Valida la URL del artículo.
    $data = $validations -> validate($_GET, array(
      array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
    ));

    $adminModel = new adminModel();

    // Obtiene los datos del artículo.
    $article = $adminModel -> get_article($data['slug']);

    if (empty($article))
      utils::redirect(NABU_ROUTES['approve-articles']);

    $view = NABU_ROUTES['review-article'] . '&slug=' . $article['slug'];

    if (empty($_POST['review-article-form'])) {
      unset($adminModel, $validations, $data);

      // Define la URL completa de la portada del artículo.
      $article['cover'] = utils::url_image('cover', $article['cover']);

      $token = csrf::generate();

      require_once 'views/admin/review-article.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $validations -> route = $view;

    $form = array_merge($_POST, $_FILES);

    // Valida el formulario para actualizar los datos de un artículo.
    $data = $validations -> validate($form, array(
      array('field' => 'cover',    'type'     => 'image'),
      array('field' => 'title',    'trim_all' => true, 'min_length' => 1, 'max_length' => 246),
      array('field' => 'synopsis', 'trim_all' => true, 'min_length' => 1, 'max_length' => 255),
      array('field' => 'body',     'trim'     => true, 'min_length' => 1, 'max_length' => NABU_DEFAULT['article-size'])
    ));
  }

  // Renderiza la página para eliminar un artículo.
  static public function delete_article() {
    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/pages/confirm-password.php';
  }

  // Renderiza la página para autorizar la publicación de un artículo.
  static public function authorize_article() {
    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/pages/confirm-password.php';
  }

  // Renderiza la página de administración para buscar artículos publicados.
  static public function published_articles() {
    $view  = NABU_ROUTES['published-articles'];
    $max   = 246;
    $query = '';

    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/admin/published-articles.php';
  }

  // Renderiza la página de administración para buscar usuarios registrados.
  static public function registered_users() {
    $view  = NABU_ROUTES['registered-users'];
    $max   = 255;
    $query = '';

    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/admin/registered-users.php';
  }
}
