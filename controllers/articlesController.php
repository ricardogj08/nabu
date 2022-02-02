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

require_once 'models/articlesModel.php';

class articlesController {
  // Renderiza la página para publicar artículos
  // y envía un artículo para su aprobación con el método POST.
  static public function post_article() {
    utils::check_session(NABU_ROUTES['home']);

    if (empty($_POST['post-article-form'])) {
      $token    = csrf::generate();
      $messages = messages::get();

      require_once 'views/pages/post-article.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $view = NABU_ROUTES['post-article'];

    $validations = new validations($view);

    // Valida el formulario de inicio de sesión.
    $data = $validations -> validate($_POST, array(
      array('field' => 'title',    'trim_all' => true, 'min_length' => 1, 'max_length' => 246),
      array('field' => 'synopsis', 'trim_all' => true, 'min_length' => 1, 'max_length' => 255),
      array('field' => 'content',  'trim'     => true, 'min_length' => 1, 'max_length' => NABU_DEFAULT['article-size']),
    ));

    $data['slug'] = utils::url_slug($data['title']);

    // Valida la longitud de la URL.
    $validations -> validate($data, array(
      array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
    ));

    $articlesModel = new articlesModel();

    $article = $articlesModel -> find($data['slug']);

    // Valida si el título del artículo es único en el día.
    if (!empty($article)) {
      messages::add('Por favor define un título diferente o espera máximo un día para enviar tu publicación');
      utils::redirect($view);
    }

    $data['user_id']       = $_SESSION['user']['id'];
    $data['creation_date'] = utils::current_date();

    // Registra un artículo para su aprobación.
    $articlesModel -> save($data);

    messages::add('Tu publicación se ha enviado correctamente, en breve autorizaremos tu publicación');
    utils::redirect(NABU_ROUTES['sent-articles']);
  }

  static public function all_articles() {
    $view     = NABU_ROUTES['home'];
    $max      = 246;
    $token    = csrf::generate();
    $articles = array();

    require_once 'views/pages/all-articles.php';
  }

  static public function search() {
    //
  }

  static public function article() {
    require_once 'views/pages/article.php';
  }
}
