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

require_once 'libs/php-smtp-2.0.4/Email.php';

use Snipworks\Smtp\Email;

// Envía mensajes de e-mail en formato HTML.
class emails {
  private $mail;

  private function errors(string $error) {
    messages::errors($error, 500);
  }

  public function __construct() {
    if (!file_exists(NABU_DIRECTORY['email']))
      $this -> errors('No se encontró el archivo de configuración del cliente de correo electrónico ' . NABU_DIRECTORY['email']);

    // Carga el archivo de configuración del cliente de e-mail.
    $config = file_get_contents(NABU_DIRECTORY['email']);
    $config = json_decode($config, true);

    $params = array('smtp', 'port', 'address', 'password');

    foreach ($params as $param)
      if (empty($config[$param]))
        messages::errors('Define el parámetro "' . $param . '" en el archivo de configuración del cliente correo electrónico', 500);

    // Configura el cliente de e-mail.
    $this -> mail = new Email($config['smtp'], $config['port']);
    $this -> mail -> setProtocol(Email::TLS);
    $this -> mail -> setLogin($config['address'], $config['password']);
    $this -> mail -> setFrom($config['address'], NABU_DEFAULT['website-name']);
  }

  // Define el destinatario del mensaje,
  public function prepare(string $destinatary, string $name) {
    $this -> mail -> addTo($destinatary, $name);
  }

  // Envía un mensaje de e-mail HTML.
  public function send(string $subject, string $body) {
    $this -> mail -> setSubject($subject);
    $this -> mail -> setHtmlMessage($body);

    return $this -> mail -> send();
  }
}
