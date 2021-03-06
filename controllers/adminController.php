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

  // Renderiza la página de administración con la lista de artículos
  // en espera de aprobación y realiza búsquedas con el método POST.
  static public function approve_articles() {
    if (!($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'moderator'))
      utils::redirect(NABU_ROUTES['logout']);

    $max    = 246;
    $search = utils::validate_search(NABU_ROUTES['approve-articles'], $max);
    $query  = $search['query'];
    $view   = $search['view'];

    $adminModel = new adminModel();

    // Obtiene el número total de artículos en espera de aprobación.
    $total = $adminModel -> count_sent($query);

    $pagination = utils::pagination($total, self::limit, $view);

    // Obtiene todos los artículos en espera de aprobación.
    $articles = $adminModel -> get_sent(self::limit, $pagination['accumulation'], $query);

    $page = $pagination['page'];

    unset($search, $adminModel, $total, $pagination);

    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/admin/approve-articles.php';
  }

  // Renderiza la página de administración para editar un artículo
  // y actualiza los datos de un artículo con el método POST.
  static public function review_article() {
    if (!($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'moderator'))
      utils::redirect(NABU_ROUTES['logout']);

    $messages = messages::get();

    $validations = new validations(NABU_ROUTES['approve-articles']);

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

    // Renderiza la página de administración para editar un artículo.
    if (empty($_POST['review-article-form'])) {
      unset($adminModel, $validations, $data);

      // Define la URL completa de la portada del artículo.
      $article['cover'] = utils::url_image('cover', $article['cover']);

      $token = csrf::generate();

      require_once 'views/admin/review-article.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    // Obtiene los datos del usuario administrador.
    $admin = $adminModel -> get_admin($_SESSION['user']['id']);

    if (empty($admin))
      utils::redirect(NABU_ROUTES['logout']);

    $validations -> route = $view;

    $form = array_merge($_POST, $_FILES);

    // Valida el formulario que actualiza los datos de un artículo.
    $data = $validations -> validate($form, array(
      array('field' => 'cover',    'type'     => 'image', 'optional' => true),
      array('field' => 'title',    'trim_all' => true, 'min_length' => 1, 'max_length' => 246),
      array('field' => 'synopsis', 'trim_all' => true, 'min_length' => 1, 'max_length' => 255),
      array('field' => 'body',     'trim'     => true, 'min_length' => 1, 'max_length' => NABU_DEFAULT['article-size'])
    ));

    $update = array();

    // Valida si hay cambios en la portada del artículo.
    if (isset($data['cover'])) {
      $update['cover'] = utils::update_image('adminModel', 'cover', $article['cover'], $data['cover']);

      if ($update['cover'] === false) {
        messages::add('¡Lo sentimos mucho! &#x1F61E;, por el momento no podemos actualizar la portada del artículo');

        unset($update['cover']);
      }
      else
        messages::add('La porta del artículo se ha actualizado correctamente');
    }

    // Valida si hay cambios en el título del artículo.
    if ($data['title'] != $article['title']) {
      $data['slug'] = utils::url_slug($data['title']);

      // Valida la longitud de la URL.
      $validations -> validate($data, array(
        array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
      ));

      if (empty($adminModel -> get_article($data['slug']))) {
        $update['title'] = $data['title'];
        $update['slug']  = $data['slug'];

        messages::add('El título del artículo se ha actualizado correctamente');
      }
      else
        messages::add('Por favor define un título diferente o espera máximo un día para actualizar el artículo');
    }

    // Valida si hay cambios en el resumen del artículo.
    if ($data['synopsis'] != $article['synopsis']) {
      $update['synopsis'] = $data['synopsis'];
      messages::add('El resumen del artículo se ha actualizado correctamente');
    }

    // Valida si hay cambios en el cuerpo del artículo.
    if ($data['body'] != $article['body']) {
      $update['body'] = $data['body'];
      messages::add('El contenido del artículo se ha actualizado correctamente');
    }

    // Actualiza los datos del artículo en la base de datos.
    if (!empty($update)) {
      $update['modification_date'] = utils::current_date();

      $adminModel -> update_article($article['id'], $update);

      // Actualiza los datos de publicación del artículo.
      if (!empty($article['authorized']))
        $adminModel -> update_record($article['id'], array(
          'user_id'            => $admin['id'],
          'authorization_date' => $update['modification_date']
        ));

      // Actualiza la URL de edición del artículo si hay cambios en el título.
      if (!empty($update['slug']))
        $view = NABU_ROUTES['review-article'] . '&slug=' . $update['slug'];
    }

    utils::redirect($view);
  }

  // Renderiza la página de administración para eliminar un artículo
  // y elimina los comentarios, favoritos y registro de publicación con el método POST.
  static public function delete_article() {
    if (!($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'moderator'))
      utils::redirect(NABU_ROUTES['logout']);

    $messages = messages::get();

    $validations = new validations(NABU_ROUTES['approve-articles']);

    // Valida la URL del artículo.
    $data = $validations -> validate($_GET, array(
      array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
    ));

    $slug = $data['slug'];

    $view = NABU_ROUTES['delete-article'] . '&slug=' . $slug;

    // Renderiza la página de administración para eliminar un artículo.
    if (empty($_POST['confirm-password-form'])) {
      unset($validations, $data, $slug);

      $token = csrf::generate();

      require_once 'views/pages/confirm-password.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $validations -> route = $view;

    // Valida el formulario para confirmar la contraseña del usuario.
    $data = $validations -> validate($_POST, array(
      array('field' => 'password', 'min_length' => 6, 'max_length' => 255, 'not_spaces' => true, 'equal' => $_POST['confirm-password'])
    ));

    $adminModel = new adminModel();

    // Obtiene los datos del usuario administrador.
    $admin = $adminModel -> get_admin($_SESSION['user']['id']);

    if (empty($admin))
      utils::redirect(NABU_ROUTES['logout']);

    // Valida la contraseña del usuario.
    if (!password_verify($data['password'], $admin['password'])) {
      messages::add('La contraseña es incorrecta');
      utils::redirect($view);
    }

    // Obtiene los datos del artículo.
    $article = $adminModel -> get_article($slug);

    if (empty($article))
      utils::redirect(NABU_ROUTES['approve-articles']);

    // Elimina la portada del artículo.
    utils::remove_image('cover', $article['cover']);

    // Elimina los comentarios, favoritos, fecha de publicación y registro del artículo.
    $adminModel -> delete_article($article['id']);

    messages::add('El artículo se ha eliminado correctamente');

    utils::redirect(NABU_ROUTES['approve-articles']);
  }

  // Renderiza la página de administración para autorizar la publicación de un artículo
  // y autoriza un artículo con el método POST.
  static public function authorize_article() {
    if (!($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'moderator'))
      utils::redirect(NABU_ROUTES['logout']);

    $messages = messages::get();

    $validations = new validations(NABU_ROUTES['approve-articles']);

    // Valida la URL del artículo.
    $data = $validations -> validate($_GET, array(
      array('field' => 'slug', 'min_length' => 1, 'max_length' => 255)
    ));

    $slug = $data['slug'];

    $view = NABU_ROUTES['authorize-article'] . '&slug=' . $slug;

    // Renderiza la página de administración para autorizar la publicación de un artículo.
    if (empty($_POST['confirm-password-form'])) {
      unset($validations, $data, $slug);

      $token = csrf::generate();

      require_once 'views/pages/confirm-password.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $validations -> route = $view;

    // Valida el formulario para confirmar la contraseña del usuario.
    $data = $validations -> validate($_POST, array(
      array('field' => 'password', 'min_length' => 6, 'max_length' => 255, 'not_spaces' => true, 'equal' => $_POST['confirm-password'])
    ));

    $adminModel = new adminModel();

    // Obtiene los datos del usuario administrador.
    $admin = $adminModel -> get_admin($_SESSION['user']['id']);

    if (empty($admin))
      utils::redirect(NABU_ROUTES['logout']);

    // Valida la contraseña del usuario.
    if (!password_verify($data['password'], $admin['password'])) {
      messages::add('La contraseña es incorrecta');
      utils::redirect($view);
    }

    // Obtiene los datos del artículo.
    $article = $adminModel -> get_article($slug);

    if (empty($article) || !empty($article['authorized']))
      utils::redirect(NABU_ROUTES['approve-articles']);

    $update = array('authorized' => true, 'modification_date' => utils::current_date());

    // Autoriza la publicación del artículo.
    $adminModel -> update_article($article['id'], $update);

    // Registra los datos de publicación del artículo.
    $adminModel -> save_record(array(
      'id'                 => $article['id'],
      'user_id'            => $admin['id'],
      'authorization_date' => $update['modification_date']
    ));

    messages::add('El artículo se ha publicado correctamente');

    utils::redirect(NABU_ROUTES['approve-articles']);
  }

  // Renderiza la página de administración con la lista de artículos
  // publicados y realiza búsquedas con el método POST.
  static public function published_articles() {
    if (!($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'moderator'))
      utils::redirect(NABU_ROUTES['logout']);

    $max    = 246;
    $search = utils::validate_search(NABU_ROUTES['published-articles'], $max);
    $query  = $search['query'];
    $view   = $search['view'];

    $adminModel = new adminModel();

    // Obtiene el número total de artículos publicados.
    $total = $adminModel -> count_published($query);

    $pagination = utils::pagination($total, self::limit, $view);

    // Obtiene todos los artículos publicados.
    $articles = $adminModel -> get_published(self::limit, $pagination['accumulation'], $query);

    $page = $pagination['page'];

    unset($search, $adminModel, $total, $pagination);

    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/admin/published-articles.php';
  }

  // Renderiza la página de administración con la lista de usuarios registrados
  // y realiza búsquedas con el método POST.
  static public function registered_users() {
    if (!($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'moderator'))
      utils::redirect(NABU_ROUTES['logout']);

    $max    = 255;
    $search = utils::validate_search(NABU_ROUTES['registered-users'], $max);
    $query  = $search['query'];
    $view   = $search['view'];

    $adminModel = new adminModel();

    // Obtiene el número total de usuarios registrados.
    $total = $adminModel -> count_users($query);

    $pagination = utils::pagination($total, self::limit, $view);

    // Obtiene todos los usuarios registrados.
    $users = $adminModel -> get_users(self::limit, $pagination['accumulation'], $query);

    $page = $pagination['page'];

    $roles = $adminModel -> get_roles();

    unset($search, $adminModel, $total, $pagination);

    $token    = csrf::generate();
    $messages = messages::get();

    require_once 'views/admin/registered-users.php';
  }

  // Renderiza la página de administración para eliminar un usuario
  // y elimina un usuario con el método POST.
  static public function delete_user() {
    if ($_SESSION['user']['role'] != 'admin')
      utils::redirect(NABU_ROUTES['registered-users']);

    $messages = messages::get();

    $validations = new validations(NABU_ROUTES['registered-users']);

    // Valida la URL del artículo.
    $data = $validations -> validate($_GET, array(
      array('field' => 'user', 'min_length' => 1, 'max_length' => 255, 'not_spaces' => true)
    ));

    $user = $data['user'];

    if ($user == 'root' || $user == $_SESSION['user']['username'])
      utils::redirect(NABU_ROUTES['registered-users']);

    $view = NABU_ROUTES['delete-user'] . '&user=' . $user;

    // Renderiza la página de administración para eliminar un artículo.
    if (empty($_POST['confirm-password-form'])) {
      unset($validations, $data, $user);

      $token = csrf::generate();

      require_once 'views/pages/confirm-password.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $validations -> route = $view;

    // Valida el formulario para confirmar la contraseña del usuario.
    $data = $validations -> validate($_POST, array(
      array('field' => 'password', 'min_length' => 6, 'max_length' => 255, 'not_spaces' => true, 'equal' => $_POST['confirm-password'])
    ));

    $adminModel = new adminModel();

    // Obtiene los datos del usuario administrador.
    $admin = $adminModel -> get_admin($_SESSION['user']['id']);

    if (empty($admin))
      utils::redirect(NABU_ROUTES['logout']);

    // Valida la contraseña del usuario.
    if (!password_verify($data['password'], $admin['password'])) {
      messages::add('La contraseña es incorrecta');
      utils::redirect($view);
    }

    require_once 'models/profilesModel.php';

    $profilesModel = new profilesModel();

    $profile = $profilesModel -> get_profile('username', $user);

    if (empty($profile))
      utils::redirect(NABU_ROUTES['registered-users']);

    $profilesModel -> delete_profile($profile['id']);

    messages::add('El usuario se ha eliminado correctamente');

    utils::redirect(NABU_ROUTES['registered-users']);
  }

  // Modifica el rol de un usuario con el método POST.
  static public function change_role() {
    csrf::validate($_POST['csrf']);

    $view = NABU_ROUTES['registered-users'];

    if ($_SESSION['user']['role'] != 'admin')
      utils::redirect($views);

    $messages = messages::get();

    $validations = new validations($view);

    // Valida la URL del artículo.
    $data = $validations -> validate($_GET, array(
      array('field' => 'user', 'min_length' => 1, 'max_length' => 255, 'not_spaces' => true)
    ));

    $user = $data['user'];

    if ($user == 'root' || $user == $_SESSION['user']['username'] || empty($_POST['change-role-form']))
      utils::redirect($view);

    // Valida el formulario para modificar el rol del usuario.
    if (!is_numeric($_POST['role']))
      utils::redirect($view);

    $role = $_POST['role'];

    $adminModel = new adminModel();

    // Obtiene los datos del usuario administrador.
    $admin = $adminModel -> get_admin($_SESSION['user']['id']);

    if (empty($admin))
      utils::redirect(NABU_ROUTES['logout']);

    if (empty($adminModel -> find_role($role)))
      utils::redirect($view);

    $adminModel -> change_role($user, $role);

    messages::add('El rol del usuario se ha modificado correctamente');

    utils::redirect($view);
  }
}
