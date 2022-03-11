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
  // Elimina un comentario con el método GET.
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

  // Registra o elimina el like de un artículo con el método GET.
  static public function likes() {
    utils::check_session(NABU_ROUTES['login']);

    $view = NABU_ROUTES['home'];

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

  // Cancela la suscripción de un correo con el método GET
  // y registra un e-mail al boletín de los artículos más recientes con el método POST.
  static public function suscription() {
    $view = NABU_ROUTES['all-articles'];

    $validations = new validations($view);

    // Cancela la suscripción.
    if (empty($_POST['suscription-form'])) {
      // Valida los parámetros de la URL.
      $data = $validations -> validate($_GET, array(
        array('field' => 'email', 'trim'       => true, 'min_length' => 5, 'max_length' => 255, 'not_spaces' => true),
        array('field' => 'key',   'min_length' => 1,    'max_length' => 255)
      ));

      $email = strtolower($data['email']);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        messages::add('Por favor ingresa una dirección de correo electrónico válido');
        utils::redirect($view);
      }

      $communityModel = new communityModel();

      // Obtiene los datos de suscripción.
      $suscription = $communityModel -> get_suscription($email);

      if (empty($suscription))
        utils::redirect($view);

      messages::add('Tu suscripción se ha cancelado correctamente');

      utils::redirect($view);
    }

    csrf::validate($_POST['csrf']);

    // Valida el email de la suscripción.
    $data = $validations -> validate($_POST, array(
      array('field' => 'email', 'trim' => true, 'min_length' => 5, 'max_length' => 255, 'not_spaces' => true),
    ));

    $email = strtolower($data['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      messages::add('Por favor ingresa una dirección de correo electrónico válido');
      utils::redirect($view);
    }

    $communityModel = new communityModel();

    // Obtiene los datos de suscripción.
    $suscription = $communityModel -> get_suscription($email);

    if (empty($suscription)) {
      // Genera una llave aleatoria de cancelación de suscripción.
      $key = bin2hex(random_bytes(32));

      // Genera un hash de cancelación de suscripción.
      $hash = hash_hmac('sha256', $email, $key);

      require_once 'libs/emails.php';

      $emails = new emails();
      $emails -> prepare($email, $email);

      // Genera una URL de cancelación de suscripción.
      $url = NABU_ROUTES['suscription'] . '&email=' . urlencode($email) . '&key=' . $key;

      $body = require_once 'views/emails/suscription.php';

      // Envía primero un mensaje de suscripción antes de registrarlo.
      if (!$emails -> send('¡Gracias por suscribirte!', $body))
        messages::errors('¡Lo sentimos mucho! &#x1F61E;, por el momento no podemos enviar tu mensaje de suscripción', 500);

      // Registra la suscripción.
      $communityModel -> save_suscription($email, $hash);

      messages::add('Gracias por suscribirte al boletín de ' . NABU_DEFAULT['website-name']);
    }
    else
      messages::add('Tu correo electrónico está suscripto al boletín de ' . NABU_DEFAULT['website-name']);

    utils::redirect($view);
  }

  static public function favorites() {
    //
  }
}
