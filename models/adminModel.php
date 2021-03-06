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

class adminModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // @return el número total de artículos en espera de aprobación.
  public function count_sent(string $pattern) {
    $query = 'SELECT COUNT(*) AS total FROM articles WHERE authorized = FALSE';

    if (!empty($pattern))
      $query = $query . ' AND title LIKE ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      if (empty($pattern))
        $prepare -> execute();
      else
        $prepare -> execute(array('%' . $pattern . '%'));

      $count = $prepare -> fetch();

      return $count['total'];
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para calcular el número total de artículos en espera de aprobación');
    }
  }

  // @return un array con los artículos en espera de aprobación.
  public function get_sent(int $limit, int $accumulation, string $pattern) {
    $query = 'SELECT a.title, a.slug, u.username AS author, u.email ' .
             'FROM articles AS a INNER JOIN users AS u ON a.user_id = u.id ' .
             'WHERE a.authorized = FALSE ';

    if (!empty($pattern))
      $query = $query . 'AND a.title LIKE ? ';

    $query = $query . 'ORDER BY a.creation_date DESC LIMIT ? OFFSET ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      if (empty($pattern))
        $prepare -> execute(array($limit, $accumulation));
      else
        $prepare -> execute(array('%' . $pattern . '%', $limit, $accumulation));

      $articles = $prepare -> fetchAll();

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener todos los artículos en espera de aprobación');
    }
  }

  // @return un array asociativo con los datos de un artículo.
  public function get_article(string $slug) {
    $query = 'SELECT id, title, synopsis, body, cover, slug, authorized ' .
             'FROM articles WHERE slug = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($slug));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de un artículo');
    }
  }

  // @return el id de un artículo si existe una imagen.
  public function find_image(string $column, string $filename) {
    $query = 'SELECT id FROM articles WHERE ' . $column . ' = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($filename));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para buscar la portada de un artículo');
    }
  }

  // @return los datos de un usuario administrador.
  public function get_admin(int $id) {
    $query = 'SELECT id, role_id AS role, username, email, password FROM users '.
             'WHERE id = ? AND activated = TRUE AND (role_id = 1 OR role_id = 2)';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($id));

      $user = $prepare -> fetch();

      if (empty($user))
        return array();

      $user['role'] = $this -> role($user['role']);

      return $user;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de un usuario administrador');
    }
  }

  // Actualiza los datos de un artículo.
  public function update_article(int $id, array $data) {
    $columns = array_keys($data);
    $query   = '';

    foreach ($columns as $column)
      $query = $query . $column . ' = :' . $column . ', ';

    $query = 'UPDATE articles SET ' . rtrim($query, ', ') . ' WHERE id = :id';

    $data['id'] = $id;

    try {
      $this -> pdo -> prepare($query) -> execute($data);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para actualizar los datos de un artículo');
    }
  }

  // Actualiza los datos de publicación de un artículo.
  public function update_record(int $id, array $data) {
    $columns = array_keys($data);
    $query   = '';

    foreach ($columns as $column)
      $query = $query . $column . ' = :' . $column . ', ';

    $query = 'UPDATE authorizations SET ' . rtrim($query, ', ') . ' WHERE id = :id';

    $data['id'] = $id;

    try {
      $this -> pdo -> prepare($query) -> execute($data);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para actualizar el registro de publicación de un artículo');
    }
  }

  // Elimina un artículo.
  public function delete_article(int $id) {
    $query = 'DELETE FROM articles WHERE id = ?';

    try {
      $this -> pdo -> prepare($query) -> execute(array($id));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para eliminar un artículo');
    }
  }

  // Registra los datos de publicación de un artículo.
  public function save_record(array $data) {
    $query = 'INSERT INTO authorizations(id, user_id, authorization_date) ' .
             'VALUES(:id, :user_id, :authorization_date)';

    try {
      $this -> pdo -> prepare($query) -> execute($data);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar los datos de publicación de un artículo');
    }
  }

  // @return el número total de artículos publicados.
  public function count_published(string $pattern) {
    $query = 'SELECT COUNT(*) AS total FROM articles WHERE authorized = TRUE';

    if (!empty($pattern))
      $query = $query . ' AND title LIKE ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      if (empty($pattern))
        $prepare -> execute();
      else
        $prepare -> execute(array('%' . $pattern . '%'));

      $count = $prepare -> fetch();

      return $count['total'];
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para calcular el número total de artículos publicados');
    }
  }

  // @return un array con los artículos publicados.
  public function get_published(int $limit, int $accumulation, string $pattern) {
    $query = 'SELECT a.title, a.slug, u.username AS author, u.email ' .
             'FROM articles AS a INNER JOIN users AS u ON a.user_id = u.id ' .
             'WHERE a.authorized = TRUE ';

    if (!empty($pattern))
      $query = $query . 'AND a.title LIKE ? ';

    $query = $query . 'ORDER BY a.title ASC LIMIT ? OFFSET ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      if (empty($pattern))
        $prepare -> execute(array($limit, $accumulation));
      else
        $prepare -> execute(array('%' . $pattern . '%', $limit, $accumulation));

      $articles = $prepare -> fetchAll();

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener todos los artículos publicados');
    }
  }

  // @return el número total de usuarios registrados.
  public function count_users(string $pattern) {
    $query = 'SELECT COUNT(*) AS total FROM users WHERE activated = TRUE';

    if (!empty($pattern))
      $query = $query . ' AND (name LIKE ? OR username LIKE ?)';

    try {
      $prepare = $this -> pdo -> prepare($query);

      if (empty($pattern))
        $prepare -> execute();
      else
        $prepare -> execute(array('%' . $pattern . '%', '%' . $pattern . '%'));

      $count = $prepare -> fetch();

      return $count['total'];
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para calcular el número total de usuarios registrados');
    }
  }

  // @return un array con los usuarios registrados.
  public function get_users(int $limit, int $accumulation, string $pattern) {
    $query = 'SELECT u.name, u.username, u.email, r.id AS roleId, r.name AS role ' .
             'FROM users AS u ' .
             'INNER JOIN roles AS r ON u.role_id = r.id ' .
             'WHERE u.activated = TRUE ';

    if (!empty($pattern))
      $query = $query . 'AND (u.name LIKE ? OR u.username LIKE ?) ';

    $query = $query . 'ORDER BY u.name ASC LIMIT ? OFFSET ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      if (empty($pattern))
        $prepare -> execute(array($limit, $accumulation));
      else
        $prepare -> execute(array('%' . $pattern . '%', '%' . $pattern . '%', $limit, $accumulation));

      $articles = $prepare -> fetchAll();

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener todos los usuarios registrados');
    }
  }

  // @return un array con los roles del sistema.
  public function get_roles() {
    $query = 'SELECT * FROM roles ORDER BY name ASC';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute();

      $roles = $prepare -> fetchAll();

      if (empty($roles))
        $roles = array();

      return $roles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener todos los roles del sistema');
    }
  }

  // @return un array de un rol del sistema.
  public function find_role(int $id) {
    $query = 'SELECT * FROM roles WHERE id = ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($id));

      $role = $prepare -> fetch();

      if (empty($role))
        $role = array();

      return $role;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para buscar un rol del sistema');
    }
  }

  // Actualiza el rol de un usuario.
  public function change_role(string $user, int $role) {
    $query = 'UPDATE users SET role_id = ? WHERE username = ?';

    try {
      $this -> pdo -> prepare($query) -> execute(array($role, $user));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para modificar el rol de un usuario');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
