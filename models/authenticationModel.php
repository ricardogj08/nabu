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

class authenticationModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // Registra el hash de autenticación de e-mail con tiempo de expiración.
  public function save(array $authentication) {
    $query = 'INSERT INTO authentications(id, hash, expiration) VALUES(:id, :hash, :expiration)';

    try {
      $this -> pdo -> prepare($query) -> execute($authentication);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar una clave de verificación de dirección de correo electrónico');
    }
  }

  // @return un array asociativo con los datos de autenticación de e-mail de un usuario.
  public function get(string $username) {
    $query = 'SELECT u.id, u.email, u.activated, a.hash, a.expiration ' .
             'FROM users AS u LEFT JOIN authentications AS a ON u.id = a.id ' .
             'WHERE u.username = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($username));

      $user = $prepare -> fetch();

      if (empty($user))
        $user = array();

      return $user;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de autenticación de dirección de correo electrónico');
    }
  }

  // Activa la cuenta, elimina la autenticación y crea el perfil de un usuario.
  public function activate(int $id) {
    $query_activate = 'UPDATE users SET activated = TRUE WHERE id = ?';
    $query_delete   = 'DELETE FROM authentications WHERE id = ?';
    $query_profile  = 'INSERT INTO profiles(id) VALUES(?)';

    $id = array($id);

    try {
      $this -> pdo -> prepare($query_activate) -> execute($id);
      $this -> pdo -> prepare($query_delete) -> execute($id);
      $this -> pdo -> prepare($query_profile) -> execute($id);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para activar una cuenta de usuario');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
