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
      $this -> errors($e -> getMessage(), 'tuvimos un problema para mostrar los artículos en espera de aprobación');
    }
  }

  // @return un array asocitivo con los datos de un artículo.
  public function get_article(string $slug) {
    $query = 'SELECT id, title, synopsis, body, cover, slug FROM articles WHERE slug = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($slug));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de un artículo');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
