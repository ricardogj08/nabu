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

class articlesController {
  // Renderiza la página para publicar artículos
  // y envía un artículo para su aprobación con el método POST.
  static public function post_article() {
    utils::session_check(NABU_ROUTES['home']);

    if (empty($_POST['post-article-form'])) {
      $token    = csrf::generate();
      $messages = messages::get();

      require_once 'views/pages/post-article.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $validations = new validations(NABU_ROUTES['post-article']);

    // Valida el formulario de inicio de sesión.
    $data = $validations -> validate($_POST, array(
      array('field' => 'title',    'trim_all' => true, 'min_length' => 1, 'max_length' => 246),
      array('field' => 'synopsis', 'trim_all' => true, 'min_length' => 1, 'max_length' => 255),
      array('field' => 'content',  'trim'     => true, 'min_length' => 1, 'max_length' => NABU_DEFAULT['article-size']),
    ));
  }

  static public function all_articles() {
    require_once 'views/pages/all-articles.php';
  }

  static public function article() {
    require_once 'views/pages/article.php';
  }
}
