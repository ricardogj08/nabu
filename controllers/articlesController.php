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
  private const limit = 10;

  // Renderiza la página para publicar artículos
  // y envía un artículo para su aprobación con el método POST.
  static public function post_article() {
    utils::check_session(NABU_ROUTES['home']);

    // Renderiza la página para publicar un artículo.
    if (empty($_POST['post-article-form'])) {
      $token    = csrf::generate();
      $messages = messages::get();

      require_once 'views/pages/post-article.php';
      //require_once 'views/pages/congrats.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $view = NABU_ROUTES['post-article'];

    $validations = new validations($view);

    // Valida el formulario para enviar un artículo.
    $data = $validations -> validate($_POST, array(
      array('field' => 'title',    'trim_all' => true, 'min_length' => 1, 'max_length' => 246),
      array('field' => 'synopsis', 'trim_all' => true, 'min_length' => 1, 'max_length' => 255),
      array('field' => 'body',     'trim'     => true, 'min_length' => 1, 'max_length' => NABU_DEFAULT['article-size'])
    ));

    $data['slug'] = utils::url_slug($data['title']);

    // Valida la longitud de la URL.
    $validations -> validate($data, array(
      array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
    ));

    $articlesModel = new articlesModel();

    $article = $articlesModel -> find_article($data['slug']);

    // Valida si el título del artículo es único en el día.
    if (!empty($article)) {
      messages::add('Por favor define un título diferente o espera máximo un día para enviar tu publicación');
      utils::redirect($view);
    }

    $data['user_id']       = $_SESSION['user']['id'];
    $data['creation_date'] = utils::current_date();

    // Registra un artículo para su aprobación.
    $articlesModel -> save_article($data);

    unset($view, $validations, $data, $articlesModel, $article);

    require_once 'views/pages/congrats.php';
  }

  // Renderiza la página para mostrar todos los artículos publicados
  // y realiza búsquedas con el método POST.
  static public function all_articles() {
    $max    = 246;
    $search = utils::validate_search(NABU_ROUTES['all-articles'], $max);
    $query  = $search['query'];
    $view   = $search['view'];

    $articlesModel = new articlesModel();

    // Obtiene el número total de artículos publicados.
    $total = $articlesModel -> count_all($query);

    $pagination = utils::pagination($total, self::limit, $view);

    // Obtiene los artículos publicados.
    $articles = $articlesModel -> get_all(self::limit, $pagination['accumulation'], $query);

    $page = $pagination['page'];

    unset($search, $articlesModel, $total, $pagination);

    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/pages/all-articles.php';
  }

  // Renderiza un artículo publicado
  // y publica un comentario con el método POST.
  static public function article() {
    $messages = messages::get();

    $validations = new validations(NABU_ROUTES['home']);

    // Valida la URL del artículo.
    $data = $validations -> validate($_GET, array(
      array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
    ));

    $articlesModel = new articlesModel();

    $article = $articlesModel -> find_article($data['slug']);

    if (empty($article))
      utils::redirect(NABU_ROUTES['home']);

    $view = NABU_ROUTES['article'] . '&slug=' . $article['slug'];

    // Renderiza un artículo publicado.
    if (empty($_POST['comments-form'])) {
      // Obtiene el contenido del artículo.
      $article = $articlesModel -> get_article($article['id']);

      // Obtiene los artículos más populares del autor.
      $articles = $articlesModel -> popular_articles($article['author_id'], 3);

      // Obtiene los comentarios del artículo.
      $comments = $articlesModel -> get_comments($article['id']);

      $login = array('avatar' => null, 'profile' => NABU_ROUTES['login']);

      // Obtiene la foto de perfil del usuario de sesión para mostrar en los comentarios.
      if (isset($_SESSION['user'])) {
        $login = $articlesModel -> get_avatar($_SESSION['user']['id']);

        $login['role'] = $_SESSION['user']['role'];

        $login['profile'] = NABU_ROUTES['profile'] . '&user=' . urlencode($_SESSION['user']['username']);
      }

      $login['avatar'] = utils::url_image('avatar', $login['avatar']);

      require_once 'libs/parsedown-1.7.4/Parsedown.php';

      // Formatea los datos del artículo.
      $article['title']    = utils::escape($article['title']);
      $article['cover']    = utils::url_image('cover', $article['cover']);
      $article['author']   = utils::escape($article['author']);
      $article['avatar']   = utils::url_image('avatar', $article['avatar']);
      $article['profile']  = NABU_ROUTES['profile'] . '&user=' . urlencode($article['username']);
      $article['username'] = utils::escape($article['username']);

      $parsedown = new Parsedown;
      //$parsedown -> setSafeMode(true);

      // Convierte el artículo Markdown en HTML.
      $article['body'] = $parsedown -> text($article['body']);

      if (empty($article['description']))
        $article['description'] = NABU_DEFAULT['description'];

      $article['description'] = utils::escape($article['description']);

      // Segmenta la fecha en un array asociativo.
      $date = utils::format_date($article['date']);

      $article['date'] = $date['day'] . ' de ' . $date['month'] . ' del ' . $date['year'];

      unset($validations, $data, $articlesModel, $parsedown, $date, $month);

      $token = csrf::generate();

      require_once 'views/pages/article.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    utils::check_session(NABU_ROUTES['login']);

    $validations -> route = $view;

    // Valida el formulario para publicar un comentario.
    $data = $validations -> validate($_POST, array(
      array('field' => 'body', 'trim_all' => true, 'min_length' => 1, 'max_length' => 255),
    ));

    $data['user_id']      = $_SESSION['user']['id'];
    $data['article_id']   = $article['id'];
    $data['comment_date'] = utils::current_date();

    // Publica un comentario.
    $articlesModel -> post_comment($data);

    utils::redirect($view);
  }
}
