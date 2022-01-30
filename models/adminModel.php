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

  // @return un array asociativo de artículos en espera de aprobación.
  public function sent(string $pattern = '') {
    $query = 'SELECT a.title, a.slug, u.username AS author ' .
             'FROM articles AS a INNER JOIN users AS u ON a.user_id = u.id ' .
             'WHERE a.authorized = FALSE ORDER BY a.creation_date DESC';

    if (!empty($pattern))
      $query = $query . 'LIMIT ? OFFSET ?';

    try {
      $prepare = $this -> pdo -> prepare($query);

      if (empty($pattern))
        $prepare -> execute();
      else
        $prepare -> execute();

      $articles = $prepare -> fetchAll();

      if (empty($articles))
        $articles = array();

      return $articles;
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para mostrar los artículos en espera de aprobación');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
