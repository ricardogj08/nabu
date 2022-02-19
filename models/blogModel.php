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

class blogModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // @return un array asociativo de los artículos más populares.
  public function popular(int $limit) {
    $query = 'SELECT a.title, a.synopsis, a.slug, a.cover, u.username AS author, p.avatar, ' .
             'COUNT(c.article_id) AS comments, COUNT(f.article_id) AS likes ' .
             'FROM articles AS a ' .
             'INNER JOIN users AS u ON a.user_id = u.id ' .
             'LEFT JOIN profiles AS p ON u.id = p.id ' .
             'LEFT JOIN comments AS c ON a.id = c.article_id ' .
             'LEFT JOIN favorites AS f ON a.id = f.article_id ' .
             'WHERE a.authorized = TRUE GROUP BY a.id ' .
             'ORDER BY likes DESC, comments DESC LIMIT ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($limit));

      $articles = $prepare -> fetchAll();

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para listar los artículos más populares');
    }
  }

  // @return un array asociativo de los artículos publicados recientemente.
  public function recent(int $limit) {
    $query = 'SELECT a.title, a.synopsis, a.slug, a.cover, u.username AS author, p.avatar, ' .
             'COUNT(c.article_id) AS comments, COUNT(f.article_id) AS likes ' .
             'FROM articles AS a ' .
             'INNER JOIN users AS u ON a.user_id = u.id ' .
             'LEFT JOIN profiles AS p ON u.id = p.id ' .
             'LEFT JOIN comments AS c ON a.id = c.article_id ' .
             'LEFT JOIN favorites AS f ON a.id = f.article_id ' .
             'WHERE a.authorized = TRUE GROUP BY a.id ' .
             'ORDER BY a.modification_date DESC LIMIT ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($limit));

      $articles = $prepare -> fetchAll();

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para listar los artículos más recientes');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
