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

      if (empty($count))
        return $count;

      return $count['total'];
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para calcular el número total de artículos en espera de aprobación');
    }
  }

  // @return un array asociativo de artículos en espera de aprobación.
  public function sent(int $limit, int $accumulation, string $pattern) {
    $query = 'SELECT a.title, a.slug, u.username AS author ' .
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
      $this -> errors($e -> getMessage(), 'tuvimos un problema para listar los artículos en espera de aprobación');
    }
  }

  // @return un array asocitivo con los datos de un artículo.
  public function get_article(string $slug) {
    $query = 'SELECT id, title, synopsis, body, cover, slug, authorized FROM articles WHERE slug = ? LIMIT 1';

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
  public function record_article(array $data) {
    $query = 'INSERT INTO authorizations(id, user_id, authorization_date) ' .
             'VALUES(:id, :user_id, :authorization_date)';

    try {
      $this -> pdo -> prepare($query) -> execute($data);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar los datos de publicación de un artículo');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
