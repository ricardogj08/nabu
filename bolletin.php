#!/usr/bin/env php
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

php_sapi_name() == 'cli' || exit();

// Imprime errores en terminal.
class messages {
  static public function errors(string $message, int $code = 500) {
    exit($message);
  }
}

define('NABU', true);

$components = require 'core/routes.php';

require_once 'core/config.php';
require_once 'db/connection.php';
require_once 'libs/emails.php';
require_once 'core/utils.php';

// Envía por e-mail los artículos más recientes a una lista de suscriptores.
$bolletin = new class extends dbConnection {
  private $articles = 10;

  public function __construct() {
    parent::__construct();
  }

  public function __invoke() {
   $query = 'SELECT title, synopsis, slug FROM articles ' .
            'ORDER BY modification_date DESC LIMIT ?';

    // Obtiene los artículos más recientes.
    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($this -> articles));

      $articles = $prepare -> fetchAll();
    }
    catch (PDOException $e) {
      messages::errors('Tuvimos un problema para obtener los artículos más recientes');
    }

    if (empty($articles))
      exit();

    $query = 'SELECT id, email FROM suscriptions';

    // Obtiene la lista de suscriptores.
    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute();

      $subscribers = $prepare -> fetchAll();
    }
    catch (PDOException $e) {
      messages::errors('Tuvimos un problema para obtener la lista de suscriptores');
    }

    if (empty($subscribers))
      exit();

    $body = require_once 'views/emails/bolletin.php';

    $emails = new emails();

    // Adjunta en un solo e-mail los destinatarios.
    foreach ($subscribers as $subscriber) {
      $emails -> prepare($subscriber['email'], $subscriber['email']);
    }

    // Envía el boletín.
    $emails -> send('¡Llegaron los artículos del mes!', $body);
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
};

$bolletin();
