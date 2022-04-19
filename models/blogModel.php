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

  // @return un array con los artículos más populares.
  public function popular_articles(int $limit) {
    $query = 'SELECT a.id, a.title, a.synopsis, a.slug, a.cover, u.username AS author, p.avatar, ' .
             'COUNT(f.article_id) AS likes ' .
             'FROM articles AS a ' .
             'INNER JOIN users AS u ON a.user_id = u.id ' .
             'LEFT JOIN profiles AS p ON u.id = p.id ' .
             'LEFT JOIN favorites AS f ON a.id = f.article_id ' .
             'WHERE a.authorized = TRUE ' .
             'GROUP BY a.id ' .
             'ORDER BY likes DESC LIMIT ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($limit));

      $articles = $prepare -> fetchAll();

      if (!empty($articles)) {
        $query = 'SELECT COUNT(*) AS comments FROM comments WHERE article_id = ?';

        $prepare = $this -> pdo -> prepare($query);

        foreach ($articles as &$article) {
          $prepare -> execute(array($article['id']));

          $data = $prepare -> fetch();

          $article['comments'] = $data['comments'];
        }

        unset($article);
      }

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los artículos más populares');
    }
  }

  // @return un array con los artículos publicados recientemente.
  public function recent_articles(int $limit) {
    $query = 'SELECT a.id, a.title, a.synopsis, a.slug, a.cover, u.username AS author, p.avatar, ' .
             'COUNT(f.article_id) AS likes ' .
             'FROM articles AS a ' .
             'INNER JOIN users AS u ON a.user_id = u.id ' .
             'LEFT JOIN profiles AS p ON u.id = p.id ' .
             'LEFT JOIN favorites AS f ON a.id = f.article_id ' .
             'WHERE a.authorized = TRUE '.
             'GROUP BY a.id ' .
             'ORDER BY a.modification_date DESC LIMIT ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($limit));

      $articles = $prepare -> fetchAll();

      if (!empty($articles)) {
        $query = 'SELECT COUNT(*) AS comments FROM comments WHERE article_id = ?';

        $prepare = $this -> pdo -> prepare($query);

        foreach ($articles as &$article) {
          $prepare -> execute(array($article['id']));

          $data = $prepare -> fetch();

          $article['comments'] = $data['comments'];
        }

        unset($article);
      }

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los artículos más recientes');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
