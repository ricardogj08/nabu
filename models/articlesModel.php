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

class articlesModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // @return un array asociativo con los datos de un artículo.
  public function find_article(string $slug) {
    $query = 'SELECT id FROM articles WHERE slug = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($slug));

      $article = $prepare -> fetch();

      return $article;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener el identificador de un artículo');
    }
  }

  // Registra un artículo en espera de aprobación.
  public function save_article(array $data) {
    $query = 'INSERT INTO articles(user_id, title, synopsis, body, slug, creation_date) ' .
             'VALUES(:user_id, :title, :synopsis, :body, :slug, :creation_date)';

    try {
      $this -> pdo -> prepare($query) -> execute($data);
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para registrar un artículo');
    }
  }

  // @return el número total de artículos autorizados.
  public function count_all(string $pattern) {
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
      $this -> errors($e -> getMessage(), 'tuvimos un problema para calcular el número total de artículos autorizados');
    }
  }

  // @return un array asociativo de artículos publicados.
  public function get_all(int $limit, int $accumulation, string $pattern) {
    $query = 'SELECT a.title, a.synopsis, a.slug, a.cover, u.username AS author, p.avatar, ' .
             'COUNT(c.article_id) AS comments, COUNT(f.article_id) AS likes ' .
             'FROM articles AS a ' .
             'INNER JOIN users AS u ON a.user_id = u.id ' .
             'LEFT JOIN profiles AS p ON u.id = p.id ' .
             'LEFT JOIN comments AS c ON a.id = c.article_id ' .
             'LEFT JOIN favorites AS f ON a.id = f.article_id ' .
             'WHERE a.authorized = TRUE ';

    if (!empty($pattern))
      $query = $query . 'AND a.title LIKE ? ';

    $query = $query . 'GROUP BY a.id ORDER BY a.title ASC LIMIT ? OFFSET ?';

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

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
