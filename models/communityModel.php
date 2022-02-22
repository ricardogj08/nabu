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

class communityModel extends dbConnection {
  public function __construct() {
    parent::__construct();
  }

  // @return un array asociativo con los datos de un comentario.
  public function get_comment(int $id) {
    $query = 'SELECT c.id, c.user_id, a.slug FROM comments AS c ' .
             'INNER JOIN articles AS a ON c.article_id = a.id ' .
             'WHERE c.id = ? LIMIT 1';

    try {
      $prepare = $this -> pdo -> prepare($query);

      $prepare -> execute(array($id));

      return $prepare -> fetch();
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para obtener los datos de un comentario');
    }
  }

  // Elimina un comentario.
  public function delete_comment(int $id) {
    $query = 'DELETE FROM comments WHERE id = ?';

    try {
      $this -> pdo -> prepare($query) -> execute(array($id));
    }
    catch (PDOException $e) {
      $this -> errors($e -> getMessage(), 'tuvimos un problema para eliminar un comentario');
    }
  }

  public function __destruct() {
    parent::__destruct();
    $this -> pdo = null;
  }
}
