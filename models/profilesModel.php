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

class profilesModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // @return un array asociativo con los datos de perfil de un usuario.
  public function get(string $column, $pattern) {
    $query = 'SELECT u.name, u.username, p.avatar, p.background, p.description '.
             'FROM users AS u INNER JOIN profiles AS p ON u.id = p.id ' .
             'WHERE u.' . $column . ' = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($pattern));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para mostrar los datos de tu perfil');
    }
  }

  // Actualiza los datos de perfil de un usuario.
  public function update(int $id, array $data) {
    $columns = array_keys($data);
    $query   = '';

    foreach ($columns as $column)
      $query = $query . $column . ' = :' . $column . ', ';

    $query = 'UPDATE profiles SET ' . rtrim($query, ', ') . ' WHERE id = :id';

    $data['id'] = $id;

    try {
      $this -> pdo -> prepare($query) -> execute($data);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para actualizar los datos de tu perfil');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
