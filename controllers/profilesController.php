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

require_once 'models/profilesModel.php';

class profilesController {
  static public function sent_articles() {
    //
  }

  // Renderiza la página de un perfil de usuario.
  static public function profile() {
    if (empty($_GET['user']))
      utils::redirect(NABU_ROUTES['home']);

    $profilesModel = new profilesModel();

    // Obtiene los datos de perfil del usuario.
    $profile = $profilesModel -> get('username', $_GET['user']);

    unset($profilesModel);

    if (empty($profile))
      utils::redirect(NABU_ROUTES['home']);

    $isMyProfile = false;

    if (isset($_SESSION['user']))
      if ($_SESSION['user']['username'] == $profile['username'])
        $isMyProfile = true;

    $view = NABU_ROUTES['profile'] . '&user=' . urlencode($profile['username']);

    // Escapa los caracteres del nombre completo y el apodo a HTML5.
    $profile['name']     = utils::escape($profile['name']);
    $profile['username'] = utils::escape($profile['username']);

    // Define la URL completa de la foto y fondo de perfil.
    $profile['avatar']     = utils::url_image('avatar', $profile['avatar']);
    $profile['background'] = utils::url_image('background', $profile['background']);

    if (empty($profile['description']))
      $profile['description'] = 'Compartiendo conocimiento...';

    $profile['description'] = utils::escape($profile['description']);

    $page = 1;

    $articles = array();

    require_once 'views/pages/profile.php';
  }

  // Renderiza la página de edición de perfil
  // y actualiza los datos de perfil de un usuario con el método POST.
  static public function edit_profile() {
    if (empty($_POST['edit-profile-form'])) {
      utils::check_session(NABU_ROUTES['home']);

      $profilesModel = new profilesModel();

      // Obtiene los datos de perfil del usuario de sesión.
      $profile = $profilesModel -> get('id', $_SESSION['user']['id']);

      unset($profilesModel);

      if (empty($profile))
        utils::redirect(NABU_ROUTES['home']);

      $profile['avatar']     = utils::url_image('avatar', $profile['avatar']);
      $profile['background'] = utils::url_image('background', $profile['background']);

      if (empty($profile['description']))
        $profile['description'] = '';

      $token    = csrf::generate();
      $messages = messages::get();

      require_once 'views/pages/edit-profile.php';

      exit();
    }

    csrf::validate($_POST['csrf']);

    $validations = new validations(NABU_ROUTES['edit-profile']);

    // Valida el formulario de edición de perfil.
    $data = $validations -> validate($_POST, array(
      array('field' => 'avatar',      'type'       => 'image', 'optional'   => true),
      array('field' => 'background',  'type'       => 'image', 'optional'   => true),
      array('field' => 'description', 'trim_all'   => true,    'min_length' => 1,   'max_length' => 255,  'optional' => true),
      array('field' => 'name',        'trim_all'   => true,    'min_length' => 5,   'max_length' => 255,  'optional' => true),
      array('field' => 'username',    'trim'       => true,    'min_length' => 1,   'max_length' => 255,  'optional' => true, 'not_spaces' => true),
      array('field' => 'password',    'min_length' => 6,       'max_length' => 255, 'not_spaces' => true, 'optional' => true, 'equal'      => $_POST['confirm-password']),
    ));
  }

  static public function delete_profile() {
    //
  }

  static public function favorites() {
    //
  }
}
