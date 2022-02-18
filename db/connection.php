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

// Realiza la conexión con la base de datos.
class dbconnection {
  protected $pdo;

  public function __construct() {
    if (!file_exists(NABU_DIRECTORY['db']))
      messages::errors('No podemos encontrar el archivo de configuración de la base de datos ' . NABU_DIRECTORY['db'], 500);

    // Lee el archivo de configuración de la base de datos.
    $config = file_get_contents(NABU_DIRECTORY['db']);
    $config = json_decode($config, true);

    $params = array('dbms', 'host', 'database', 'user', 'password', 'charset');

    foreach ($params as $param)
      if (empty($config[$param]))
        messages::errors('Define el parámetro "' . $param . '" en el archivo de configuración de la base de datos', 500);

    // Parámetros de configuración para la conexión de la base de datos.
    $options = array(
      // Mantiene el nombre de las columnas como en la base de datos.
      PDO::ATTR_CASE               => PDO::CASE_NATURAL,
      // Define los errores de "PDO" por excepciones, utiliza el objeto "PDOException".
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      // Desactiva las consultas preparadas por PDO y utiliza el sistema nativo del SGBD.
      PDO::ATTR_EMULATE_PREPARES   => false,
      // Por defecto, retorna los resultados de las consultas como arrays asociativos.
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    // Origen de la base de datos.
    $dsn = $config['dbms'] . ':host=' . $config['host'] . ';dbname=' . $config['database'];

    try {
      // Realiza la conexión con la base de datos.
      $this -> pdo = new PDO($dsn, $config['user'], $config['password'], $options);

      // Establece la codificación de caracteres para el cliente del SGBD y los resultados de las consultas.
      $this -> pdo -> exec('SET CHARSET ' . $config['charset']);
    }
    catch (PDOException $e) {
      messages::errors($e -> getMessage(), 500);
    }
  }

  protected function errors(string $exception, string $error) {
    error_log($exception);

    messages::errors('¡Lo sentimos mucho! &#x1F61E;, ' . $error . ', por favor inténtelo más tarde', 500);
  }

  // @return el alias de un id de role.
  protected function role(int $id) {
    $role = 'user';

    if ($id == 1)
      $role = 'admin';
    elseif ($id == 2)
      $role = 'moderator';

    return $role;
  }

  // Finaliza la conexión con la base de datos.
  public function __destruct() {
    $this -> pdo = null;
  }
}
