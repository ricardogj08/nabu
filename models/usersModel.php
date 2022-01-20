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

class usersModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // @return una lista de arrays asociativos con los datos de los usuarios.
  public function find(string $username, string $email) {
    $query = 'SELECT u.id, u.username, u.email, u.password, u.activated, u.registration_date,' .
             'a.hash, a.expiration FROM users AS u ' .
             'LEFT JOIN authentications AS a ON u.id = a.id ' .
             'WHERE u.username = ? OR u.email = ? LIMIT 2';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($username, $email));

      $users = $prepare -> fetchAll();

      if (empty($users))
        $users = array();

      return $users;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para validar si tu apodo y dirección de correo electrónico son únicos');
    }
  }

  // Elimina un usuario.
  public function delete(int $id) {
    $query = 'DELETE FROM users WHERE id = ?';

    try {
      $this -> pdo -> prepare($query) -> execute(array($id));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para eliminar una cuenta de usuario');
    }
  }

  // Registra un nuevo usuario.
  public function save(array $data) {
    $query = 'INSERT INTO users(name, username, email, password, registration_date) ' .
             'VALUES(:name, :username, :email, :password, :registration_date)';

    try {
      $this -> pdo -> prepare($query) -> execute($data);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar tu cuenta de usuario');
    }
  }

  // @return un array asociativo con los datos de un solo usuario.
  public function get(string $column, $pattern) {
    $query = 'SELECT u.id, u.role_id AS role, u.username, u.email, u.password, u.activated, u.registration_date,' .
             'a.hash, a.expiration FROM users AS u ' .
             'LEFT JOIN authentications AS a ON u.id = a.id ' .
             'WHERE u.' . $column . ' = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($pattern));

      $user = $prepare -> fetch();

      if (empty($user))
        return array();

      $user['role'] = $this -> role($user['role']);

      return $user;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para validar si tu apodo y dirección de correo electrónico son únicos');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
